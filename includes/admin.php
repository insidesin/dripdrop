<?php 

if(checkLogin($pdo) && $_SESSION['is_admin'] == 1) {
	
	if(isset($_FILES["csv"])) {
		if ($_FILES["csv"]["size"] > 0) {

			//Get the CSV file
			$file = $_FILES["csv"]["tmp_name"];
			$handle = fopen($file, "r");
			
			$first_row = true;
			
			//Get data from each row and insert into Database
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				//Exclude first row.
				if($first_row) { 
					$first_row = false;
				} else {
					
					$sql = $pdo->prepare("INSERT INTO Items (toiletName, placeDescription, street, suburb, description, disabledAccess, availability, latitude, longitude) 
										  VALUES (:toiletName, :placeDescription, :street, :suburb, :description, :disabledAccess, :availability, :latitude, :longitude)");
					$sql->bindValue(':toiletName', $data[1]);
					$sql->bindValue(':placeDescription', $data[2]);
					$sql->bindValue(':street', $data[3]);
					$sql->bindValue(':suburb', $data[4]);
					$sql->bindValue(':description', $data[5]);
					$sql->bindValue(':disabledAccess', $data[6]);
					$sql->bindValue(':availability', $data[7]);
					$sql->bindValue(':latitude', $data[8]);
					$sql->bindValue(':longitude', $data[9]);
					$sql->execute();
				}
			}
			
			fclose($handle);
			
			//Exit with a notification for the user on the next page using POST.
			header('Location: ' . strtok($_SERVER['HTTP_REFERER'], '?') //Remove GET messages from last page URL.
				. "?success=The Data upload was successfully added to the database."); die; //Add on new message on same link.
		} 
	}
	
?>
	
    <!-- Define the form that admins can upload to. -->
    <h3>Import new CSV data onto existing Item database.</h3>
    <p>Warning: This will insert data over the current database.</p>
	<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
          <p>Select the CSV file:
          <input name="csv" type="file" id="csv" />
          <input type="submit" name="Submit" value="Submit" /></p>
	</form> 

<?php
}
?>