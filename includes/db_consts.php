<?php
	//Try to create a new database with the correct information given by the INB271 Lecturers.
	try {
		$user = 'saneitne_drip';
		$pass = '%NN1R]TGA-o$';
		
		# MySQL with PDO_MYSQL
		$pdo = new PDO("mysql:host=localhost;dbname=saneitne_dripdrop", $user, $pass);
	}
	//Catch any connection messages.
	catch(PDOException $e) {
		echo $e->getMessage();
	}
?>