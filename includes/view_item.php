<?php 
include('db_consts.php');

//Gets the form submitted data, if we haven't specified an id, try check 
//the last from our session else fall back with null.
$itemId = (isset($_GET['id'])) ? $_GET['id'] : null;
if(isset($itemId)) 
	$_SESSION['item_id'] = $itemId;
else if(isset($_SESSION['item_id']))
	$itemId = $_SESSION['item_id'];

if($itemId > 0 && $itemId != NULL) {
	// Prepare the statement, select values based on user decision, or if ANY rating value.
	$sql = $pdo->prepare('SELECT i.*, avg(r.rating) FROM Items i LEFT JOIN Reviews r ON i.itemId = r.itemId WHERE i.itemId=:id GROUP BY itemId');
	$sql->bindValue(':id', $itemId); 
	$sql->execute();
	
	if($sql->rowCount() == 0) {
		echo 'Issue with fetching Item Id! No item exists.';
	}
	
	$row = $sql->fetch();
	
	//Collect data from SQL query and add to variables.
	$toiletName = $row[1];
	$environment = $row[2];
	$street = $row[3];
	$suburb = $row[4];
	$description = $row[5];
	$disabledAccess = $row[6];
	$availability = $row[7];
	$latitude = $row[8];
	$longitude = $row[9];
	$rating = $row[10];

?>

<!-- The info box contains rating values, and more that weren't included. -->
<div id="info_box">
        <!-- DRIP/DROP RATING (good/bad)    removed as extra feature...
        <img class="vote_image" src="images/youtube.gif" alt="Drip (vote good)">	
        <img class="vote_image" src="images/twitter.gif" alt="Drop (vote good)">
        -->
        <h3 id="box_header"> Current Rating: </h3>
        <!-- Set the rating to either 'No Rating' or the amount of stars the rating receives. -->
        <p id="star_rating"> <?php echo $rating > 0 ? str_repeat('&#x2606; ', round($rating)) : 'No rating'; ?> </p>
</div>
    
<?php 

	//BEGIN ITEM LISTING
	echo "<h2>$toiletName:</h2>";
	newItemStatistic("Environment", "environment", $environment);
	newItemStatistic("Street", "street", $street);
	newItemStatistic("Suburb", "suburb", $suburb);
	newItemStatistic("Availability", "availability", $availability);
	newItemStatistic("Disabled Access", "disabled_access", $disabledAccess);
	newItemStatistic("Description", "description", $description);

} else {
	//If user logs out during a sessioned item id, or refreshes page with no id posted.
	echo 'Did not retrieve Item details successfully, try again later. This could due to a page refresh, if so try search again.';
}

//BEGIN REVIEWS LISTINGS
echo "<div id=\"reviews_box\">";

	//Reviews Title
	echo "<h3 id =\"review_title\"> Reviews</h3>";
	
	// Prepare the statement, select values based on user decision, or if ANY rating value.
	$sql = $pdo->prepare('SELECT r.*, m.Username FROM Reviews r, Members m WHERE itemId=:id AND r.userId = m.Id');
	$sql->bindValue(':id', $itemId); 
	$sql->execute();
	
	//Begin adding existing reviews
	while($row = $sql->fetch()) {
		//New Review: [Username, Rating, Description, Time]
		newReview($row[6], $row[5], $row[4], date('d/m/Y', strtotime($row[3])));
	}
	
	//Allows users to add own review if logged in
	//include('user_login.php');
	if(checkLogin($pdo)) {
		echo "<div class=\"review_post\">";
			echo "<form name=\"add_review\" action=\"includes/add_review.php?id=$itemId\" method=\"post\">";
			echo "<h4>Add your own review:</h4>";
			
			echo "<p>Rating: <select class=\"review_field\" name=\"rating\">";
				// Repeat the options for each, 1 star, 2 stars, etc.
				for($i = 1; $i <= 5; $i++) {
					echo "<option>".str_repeat('&#x2606; ', $i)."</option>";
				}
			echo '</select></p>';
			
			//Comments
			echo "<p>Comments: ";
			echo "<textarea class=\"review_field\" name=\"comments\"></textarea>";
			
			echo "<p><input class=\"search_button\" type=\"submit\" value=\"Submit\" /></p>";
			echo "</form></p>";
		echo "</div>";
	} else {
		//Users must be logged in to review items.
		echo "<div class=\"review_post\">";
			echo "<p>You must login to post a review!</p>";
		echo "</div>";
	}
    
echo "</div>";

//Basic function to generate simple item data and captions.
function newItemStatistic($caption, $name, $data) {
	if($data != '' || $data != NULL) {
		echo "<div class=\"content_post\">";
			echo "<h3 class=\"result_info_title\">$caption:</h3> <h4 class=\"result_info_content\" id=\"".$name."_result\">$data</h4>";
		echo "</div>";
	}
}

//Basic function to generate reviews by individual users on any page.
function newReview($username, $rating, $comments, $time) {
	echo "<div class=\"review_post\">";
        echo "User Rating posted on $time by: <p class=\"user_name\">$username</p>";
        echo "<p class=\"review_stars_rating\">" .($rating > 0 ? str_repeat('&#x2606; ', $rating) : 'No rating'). "</p>";
        echo "<p class=\"rating_notes\">$comments</p>";
    echo "</div>";
}

?>