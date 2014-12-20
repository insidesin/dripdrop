<?php
include_once 'db_consts.php';
 
function startUserSession() {
	if(!isset($_SESSION)){
		// Sets the session name to the one set above.
		session_name("user_session_id");
		session_start();            // Start the PHP session 
		session_regenerate_id();    // regenerated the session, delete the old one. 
	}
}
?>