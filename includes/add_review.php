<?php
include('db_consts.php');
include('user_login.php');

//Gets the form submitted data
$reviewId = (isset($_GET['id']) ? $_GET['id'] : null);

if($reviewId > 0 && !empty($_POST)) {
	
	checkLogin($pdo);
	$success = true;
	
	//Fetch rating from form and strip dangerous characters.
	$rating = isset($_POST['rating']) ? $_POST['rating'] : '';
	$rating = strip_tags($rating);
	$rating_count = substr_count($rating, '☆');
	
	//Check for more rating counts than allowed
	if($rating_count < 0 || $rating_count > 5) {
		$success = false;
	}
	
	$comments = isset($_POST['comments']) ? $_POST['comments'] : '';
	$comments = strip_tags($comments);
	
	//Check whether the email is less than or equal 50 characters long and not blank.
	if(strlen($comments) < 0 || strlen($comments) > 50) {
		//exit();
	}
	
	//Have we succeeded so far? If so, let's move on to adding the review.
	if($success) {		
		$sql = $pdo->prepare("INSERT INTO Reviews(itemId, userId, comments, rating)
							  VALUES (:itemId, :userId, :comments, :rating)");
		$sql->bindValue(':itemId', $reviewId);
		$sql->bindValue(':userId', $_SESSION['member_id']);
		$sql->bindValue(':comments', $comments);
		$sql->bindValue(':rating', $rating_count);
		$success = $sql->execute();
	  	
		// Did we succeed in adding our new review? Inform user and redirect if we didn't succeed.
		if($success) {
			//Exit with a notification for the user on the next page using POST.
			header('Location: ' . $_SERVER['HTTP_REFERER'] //Remove GET messages from last page URL.
			. "&success=Your review was added to the database! Thank you."); //Add on new message on same link.
		} else {
			//Exit with a notification for the user on the next page using POST.
			header('Location: ' . $_SERVER['HTTP_REFERER'] //Remove GET messages from last page URL.
			. "&failure=Your review was not submitted, try again later."); //Add on new message on same link.	
		}
	}
}

?>