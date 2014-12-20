<!-- Main search box for toilets -->
<div class="left_content_box">
    <h4>Search for toilets:</h4>
    <div class="side_box">
        <form  name="searchForm" action="results.php?search=1" method="post">
            <ul class="search_form">
            
                <li>Name:	<input class="form_option_box" name="name" id="name" ></li>
                <?php 
				// Select by suburb field generation.
				fetchSuburbsField($pdo);
				
				// Select by rating field generation.
				ratingsFormField();
				?>
                
                <li>---------------------------------</li>
                
                <li>Use current location: 	
                	<input type="checkbox" id="current_location" onchange="updateSearch(false)">
                </li>
                <li class="hidden_form_option_box" id="distance">Distance:	<input name="distance" ></li>
                <!-- HIDDEN GEOLOCATION SETTINGS -->
                <input class="hidden_form_option_box" name="user_lat" id="user_lat" >
                <input class="hidden_form_option_box" name="user_long" id="user_long" >
                <p id="search_alert"></p>
                
                <li><input class="search_button" type="submit" value="Search" /></li>
                
            </ul>
        </form>
    </div>
</div>

<?php
include('db_consts.php'); //Include MySQL db connection info.

//Creates a field that is strictly to do with the suburb selection for searches. Suburbs are produced in distinct options.
function fetchSuburbsField($pdo) {
	echo '<li>';
		echo 'Suburb:	';
		
		echo "<select class=\"form_option_box\" name=\"suburb\" id=\"suburb\" >";
		
		echo "<option>ANY</option>"; //Default to ANY suburb.
		
		$sql = $pdo->prepare("SELECT DISTINCT suburb FROM Items");
		$sql->execute();
		while ($row = $sql->fetch()) {
			echo "<option>$row[0]</option>";
		}
		
		echo '</select>';
	echo '</li>';
}

//Creates a field that is strictly to do with the rating selection for searches.
function ratingsFormField() {
	echo '<li>';
		echo 'Rating:	';
		echo "<select class=\"form_option_box\" name=\"rating\" id=\"rating\" >";
		
			// Repeat the options for each, 1 star, 2 stars, etc.
			for($i = 0; $i <= 5; $i++) {
				if($i == 0)
					$stars = 'ANY';
				else
					$stars = str_repeat('&#x2606; ', $i);
					
				echo "<option>$stars</option>";
			}
			
		echo '</select>';
	echo '</li>';
}

function initiateSearch() {
	$_SESSION['SEARCH_QUERY'] = $_POST;
	header("location: results.php");
}

?>