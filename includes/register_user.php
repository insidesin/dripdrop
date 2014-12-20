<?php

//Gets the form submitted data
$register = (isset($_GET['register']) ? $_GET['register'] : null);

//Stores errors for each field.
$errors = array();

if($register == 1 && !empty($_POST)) {
	
	//Fetch username from form and strip dangerous characters.
	$username = isset($_POST['username']) ? $_POST['username'] : '';
	$username = strip_tags($username); //strip tags are used to take plain text only
	$username = str_replace(' ', '', $username); // to remove blank spaces
    //Check whether the username is less than or equal 16 characters long and not blank.
	if(strlen($username) > 16 || strlen($username) <= 0) {
		alertInvalid($errors, 'username', "Username must be filled in and no longer than 16 characters.");
	}
	
	//Fetch email from form and strip dangerous characters.
	$email = isset($_POST['email']) ? $_POST['email'] : '';
	$email = strip_tags($email); 
	$email = str_replace(' ', '', $email);
	//Check whether the email is less than or equal 50 characters long and not blank.
	if(strlen($email) > 50 || strlen($email) <= 0) {
		alertInvalid($errors, 'email', "Email must be filled in and no longer than 50 characters.");
	}
	
	//Fetch passwords from form and strip dangerous characters.
	$password = isset($_POST['password']) ? $_POST['password'] : '';
	$password = strip_tags($password);
	$password_confirm = $_POST['password_confirm'];
	$password_confirm = strip_tags($password_confirm);
	//If passwords are not identical or it is shorter than 5 characters, alert the user and refuse creation.
	if($password_confirm != $password) {
		alertInvalid($errors, 'password_confirm', "Password inputs do not match.");
	} 
	if(strlen($password_confirm) < 5) {
		alertInvalid($errors, 'password', "Password must be 5 characters or longer.");
	}
	 
	//Fetch gender from form and strip dangerous characters.
	$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
	$gender = strip_tags($gender);
	
	//Fetch birthdate from form and strip dangerous characters.
	$birthday = isset($_POST['birthday']) ? $_POST['birthday'] : '';
	$birthday = strip_tags($birthday);
	//Make sure the date is valid in forms of British time.
	if (strlen($birthday) > 0 && strptime($birthday, '%d/%m/%Y') == false) {
		alertInvalid($errors, 'birthday', "Invalid Date, please use DD/MM/YYYY.");
	}
	
	//Fetch and evaluate disability data.
	$disabled = isset($_POST['disability']) ? $_POST['disability'] : '';
	
	//Fetch and evaluate subscription data, true = 1, false = 0.
	$subscribe = isset($_POST['newsletter']) && $_POST['newsletter'] ? "1" : "0";
	 
	//Check if there are any username identicals in table already.
	$sql = $pdo->prepare("SELECT Id FROM Members WHERE Username=:username"); // checking username already exists
	$sql->bindValue(':username', $username);
	$sql->execute();
	
	if($username == '' || $password == '' || $email == '' || $password_confirm == '') {
		alertInvalid($errors, 'username', "Invalid or empty fields found where are required.");
	}
	
	//If there isnt and our code is validated correctly, continue, otherwise alert the user.
	if($sql->rowCount() != 0) {
		alertInvalid($errors, 'username', "Username already exists! Please choose another username.");
	} else if(count($errors) == 0) {
		
		//PREPARE CERTAIN VALUES FOR MYSQL INSERTION
		//Assign true/false value to disability needs.
		$disabled == 'No disability' ? '0' : '1';
		//Shorten gender to 1char.
		$gender = $gender == 'Male' ? 'M' : ($gender == 'Female' ? 'F' : 'N');
		//Hash the password so when we insert it into the members table it'll be saved securely.
		$randsalt = mcrypt_create_iv(64, MCRYPT_DEV_URANDOM);
		$password = hash('sha256', $randsalt . $password); 
		//Ready date for YYYY-MM-DD format in MySQL database (if dat not found, set to NULL)
		$birthday = strtotime(str_replace('/', '.', $birthday)) == 0 ? NULL : strtotime(str_replace('/', '.', $birthday));
		$birthday = date('Y-m-d', $birthday);
								
		$sql = $pdo->prepare("INSERT INTO Members(Username, Email, BirthDate, Gender, Disabled, Subscriber, Password, RandSalt)
							  VALUES (:username, :email, :birthday, :gender, :disabled, :subscribe, :password, :randsalt)");
		$sql->bindValue(':username', $username);
		$sql->bindValue(':email', $email);
		$sql->bindValue(':birthday', $birthday);
		$sql->bindValue(':gender', $gender);
		$sql->bindValue(':disabled', $disabled);
		$sql->bindValue(':subscribe', $subscribe);
		$sql->bindValue(':password', $password);
		$sql->bindValue(':randsalt', $randsalt);
		$success = $sql->execute();
	  
		// Did we succeed in adding our new member? Inform user and redirect if we succeeded.
		if($success) {
			//Exit with a notification for the user on the next page using POST.
			header('Location: ' . strtok($_SERVER['HTTP_REFERER'], '?') //Remove GET messages from last page URL.
			. "?success=Registration successful, your username is $username. Please login to access your account."); //Add on new message on same link.
		} else {
			//Exit with a notification for the user on the next page using POST.
			header('Location: ' . strtok($_SERVER['HTTP_REFERER'], '?') //Remove GET messages from last page URL.
			. "?failure=Registration failed, something went wrong. Please try again later."); //Add on new message on same link.
		}
	}
}

?>