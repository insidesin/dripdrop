<?php
include_once 'session.php';
include_once 'user_login.php';
 
startUserSession();

// Are we logged in or out?
$logged = checkLogin($pdo) ? 'in' : 'out';

// Set a bit of Javascript to allow the openning and closing of the login form.
// This is mainly a visual feature that allows the box to be visible only when the user clicks.
echo "<script type=\"text/javascript\">";
echo "	function loginMenu(clicked) { ";
echo "		if(clicked && document.getElementById(\"login_form\").style.display != 'block')";
echo "			document.getElementById(\"login_form\").style.display = 'block';";
echo "		else";
echo "			document.getElementById(\"login_form\").style.display = 'none';";
echo "	}";
echo "</script>";

// Create login button and check if we're logged in? If not, rename button.
echo "<a href=\"#\" id=\"login_menu\" onclick=\"loginMenu(true);return false;\"> Log";
echo $logged == 'in' ? 'out' : 'in';
echo "</a>";

echo "<div id=\"login_form\">";
	// Display options to login, or if they're already logged in, a logout button.
	// User must provide their Username and Password correctly to login.
	if($logged == 'out') {
		echo "<form name=\"loginForm\" action=\"includes/user_login.php?login=1\" method=\"post\">";                
		echo "	<p class=\"login_field\">Username: <input type=\"text\" name=\"username\" /></p>";
		echo "	<p class=\"login_field\">Password: <input type=\"password\" name=\"password\" id=\"password\"/></p>";
		echo "	<p class=\"login_field\"><input class=\"form_data\" type=\"submit\" value=\"Login\" /></p>";
		echo "</form>";
	//Displays if the user is currently logged in and allows for the logging out of the user.
	} else if($logged == 'in') {
		echo "<p>You are currently logged in.</p>";
		echo "<form name=\"logoutForm\" action=\"includes/user_login.php?logout=1\" method=\"post\">";
		echo "	<input class=\"form_data\" type=\"submit\" value=\"Logout\" />";
		echo "</form>";
	}
echo "</div>";

?>