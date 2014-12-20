<?php
include_once 'session.php';

startUserSession(); // Our custom secure way of starting a PHP session.

//Handle new requests for user login via login_form.
$login = (isset($_GET['login']) ? $_GET['login'] : null);

if($login == 1 && !empty($_POST)) {
	$username = $_POST['username'];
	$password = $_POST['password']; // The hashed password.
 
	if (loginUser($username, $password, $pdo) == true) {
		//Exit with a notification for the user on the next page using POST.
		header('Location: ' . strtok($_SERVER['HTTP_REFERER'], '?') //Remove GET messages from last page URL.
			. "?success=Thank you for logging in, $username."); //Add on new message on same link.
	} else {
		//Exit with a notification for the user on the next page using POST.
		// --REFRESH STOPS USERS FROM RETRYING OVER AND OVER.
		header('Location: ' . strtok($_SERVER['HTTP_REFERER'], '?') //Remove GET messages from last page URL.
			. '?failure=Login failed. Make sure you had your credentials correct and try again.'); //Add on new message on same link.
	}
} 

//Handle logging out button.
$logout = (isset($_GET['logout']) ? $_GET['logout'] : null);

//Are we requesting a logout? If so, delete our session and return.
if($logout == 1) {
	session_unset();
	session_destroy();
	
	//Exit with a notification for the user on the next page using POST.
	header('Location: ' . strtok($_SERVER['HTTP_REFERER'], '?') //Remove GET messages from last page URL.
			. '?success=You have successfully logged out.'); //Add on new message on same link.
}

function loginUser($username, $password, $pdo) {
    // Use prepared statements to prevent MySQL injection of user login searches.
    if ($stmt = $pdo->prepare("SELECT Id, Username, Password, Randsalt, admin 
								FROM Members
								WHERE Username = :username LIMIT 1")) {
		$stmt->bindValue(':username', $username);
        $stmt->execute();
		$row = $stmt->fetch();
		
		//Fetch the line into different variables.
		$member_id = $row[0];
		$username = $row[1];
		$coded_pass = $row[2];
		$randsalt = $row[3];
		$admin = $row[4];
 
        // Hash the password that the user has given us for verification later.
        $password = hash('sha256', $randsalt . $password);
		
        if ($stmt->rowCount() == 1) {
			// Check if both hashed passwords are identical.
			if ($coded_pass == $password) {
				// Get the user-agent string of the user.
				$user_browser = $_SERVER['HTTP_USER_AGENT'];
				// XSS protection as we might print this value
				$member_id = preg_replace("/[^0-9]+/", "", $member_id);
				$_SESSION['member_id'] = $member_id;
				$_SESSION['is_admin'] = $admin;
				// XSS protection as we might print this value
				$username = preg_replace("/[^a-zA-Z0-9_\-]+/", 
															"", 
															$username);
				$_SESSION['username'] = $username;
				$_SESSION['login_string'] = hash('sha256', $password . $user_browser);
				
				// Login successful.
				return true;
			} else {
				//Your hashed password did not match the server's hashed password.
				return false;
			}
        } else {
            // No user could be found, or there are duplicates (unlikely).
            return false;
        }
    }
}

function checkLogin($pdo) {
    // Check if all session variables are set 
    if (isset($_SESSION['member_id'], 
              $_SESSION['username'], 
              $_SESSION['login_string'])) {
 
        $member_id = $_SESSION['member_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];
 
        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
 
 		//Search for the user to check the login again.
        if ($stmt = $pdo->prepare("SELECT Password FROM Members 
                                      WHERE Id = :member_id LIMIT 1")) {
			$stmt->bindValue(':member_id', $member_id);
			$stmt->execute();
			$row = $stmt->fetch();
 
            if ($stmt->rowCount() == 1) {
                // If the user exists get variables from result.
				$password = $row[0];
				
                $login_check = hash('sha256', $password . $user_browser);
 
                if ($login_check == $login_string) {
                    // Logged In!!!! 
                    return true;
                } else {
                    // Not logged in, as are all the cascading else responses below.
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    } else {
        return false;
    }
}

?>