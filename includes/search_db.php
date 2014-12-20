<?php

//Gets the form submitted data
$search = (isset($_GET['search']) ? $_GET['search'] : null);

if($search == 1 && !empty($_POST)) {
	
	//Search by position if set.
	if(!empty($_POST['user_lat']) && !empty($_POST['user_long'])) {
		
		//Fetch latitude from hidden field and strip dangerous characters.
		$user_lat = $_POST['user_lat'];
		$user_lat = strip_tags($user_lat); 
		
		//Fetch longitude from hidden field and strip dangerous characters.
		$user_long = $_POST['user_long'];
		$user_long = strip_tags($user_long);
		
		//Fetch distance from hidden field and strip dangerous characters.
		$distance = $_POST['distance'];
		$distance = strip_tags($distance);
		//If the distance field is not numeric, reset to standard 5kms.
		$distance = is_numeric($distance) ? $distance : 5; 
		
		//Used to measure distance (kilometres) between Lat/long points.
		$distance_equation = '(6371* acos(cos(radians(:lat)) * cos(radians(i.latitude)) 
								* cos(radians(i.longitude) - radians(:long)) + sin(radians(:lat)) 
								* sin(radians(i.latitude))))';
		$sql_statement = "SELECT i.itemId, i.toiletName, i.suburb, avg(r.rating), $distance_equation AS distance 
						FROM Items i LEFT JOIN Reviews r ON i.itemId = r.itemId 
						GROUP BY itemId 
						HAVING distance <:distance
						ORDER BY distance ";
		// Prepare the statement, select values based on user decision, or if ANY rating value.
		$sql = $pdo->prepare($sql_statement);
		
		//Only bind values that search has asked for.
		
		$sql->bindValue(':lat', $user_lat);
		$sql->bindValue(':long', $user_long);
		$sql->bindValue(':distance', $distance);
		
		$sql->execute();
		$result_count = $sql->rowCount();
		
		//Start table development using MySQL DB rows.
		echo "<h2>Results: [$result_count]</h2>";
		echo "<p>Search has searched for toilets within your location and has displayed them in order of closest, to furtherest.</p>";
				
	} else {
		
		//Fetch name from form and strip dangerous characters.
		$name = isset($_POST['name']) ? $_POST['name'] : '';
		$name = strip_tags($name); 
		
		//Fetch suburb from form and strip dangerous characters.
		$suburb = isset($_POST['suburb']) ? $_POST['suburb'] : 'ANY';
		$suburb = strip_tags($suburb);
		
		//Fetch suburb from form and strip dangerous characters.
		$rating = isset($_POST['rating']) ? $_POST['rating'] : '0';
		$rating = strip_tags($rating);
		$rating_count = substr_count($rating, '☆');
		
		// Prepare the statement, select values based on user decision, or if ANY rating value.
		$sql = $pdo->prepare(searchSQLStatement($name, $suburb, $rating_count));
		
		//Only bind values that search has asked for.
		
		if($name != '') 		{ $sql->bindValue(':name', "%".$name."%"); }
		if($suburb != 'ANY') 	{ $sql->bindValue(':suburb', $suburb); }
		if($rating_count != 0) 	{ $sql->bindValue(':rating', $rating_count); }
		
		$sql->execute();
		$result_count = $sql->rowCount();
		
		//Start table development using MySQL DB rows.
		echo "<h2>Results: [$result_count]</h2>";
		echo "<p><b>Search data: [Name]:</b> $name	<b>[Suburb]:</b> $suburb	<b>[Rating]:</b> $rating</p>";
	}
	
	echo "<table id=\"results_table\">";
	//Column names
	echo "<tr> <!-- TABLE COLUMN HEADS -->";
		echo "<td class=\"name_column_head\">Name</td>";
		echo "<td class=\"suburb_column_head\">Suburb</td>";
		echo "<td class=\"rating_column_head\">Rating</td>";
	echo "</tr>";
	
	//Generate all items in search.
		while ($row = $sql->fetch()) {
			//If there is no current rating.
			if($row[3] == NULL)
				$row[3] = 'No Rating';
			else
				$row[3] = str_repeat('&#x2606; ', round($row[3]));
				
			//New row for database information.
			echo "<tr> <!-- NEW TABLE RECORD -->";
				echo "<td class=\"name_column\"><a href=\"item_view.php?id=$row[0]\">$row[1]</a></td>";
				echo "<td class=\"suburb_column\">$row[2]</td>";
				echo "<td class=\"rating_column\">$row[3]</td>";
			echo "</tr>";
		}
	echo "</table>";
	
}

function searchSQLStatement($name, $suburb, $rating_count) {
	//Format the SQL Query correctly by placing WHERE, AND clauses in appropriate fashion.
	//This is a lot of code that is required to format the SQL request in a proper fashion
	//to allow the searching and retrieving of some values, and not others.
	$sql_statement = "SELECT i.itemId, i.toiletName, i.suburb, ROUND(avg(r.rating), 0) as avg_rating FROM Items i LEFT JOIN Reviews r ON i.itemId = r.itemId";
	if($name != '') {
		$sql_statement .= " WHERE i.toiletName LIKE :name";
		if($suburb != 'ANY')	//Only search by suburb if user selects to.
			 $sql_statement .= " AND i.suburb=:suburb";
		if($rating_count != 0)	//Only search by rating if user selects to.
			 $sql_statement .= " AND (SELECT AVG(r.rating) FROM Reviews)=:rating AND 
			 						(SELECT AVG(r.rating) FROM Reviews) IS NOT NULL";	
	} else if($suburb != 'ANY')	{
		$sql_statement .= " WHERE i.suburb=:suburb";
		if($rating_count != 0)
			 $sql_statement .= " AND (SELECT AVG(r.rating) FROM Reviews)=:rating AND 
			 						(SELECT AVG(r.rating) FROM Reviews) IS NOT NULL";
	} else if($rating_count != 0) {
		$sql_statement .= " WHERE (SELECT AVG(r.rating) FROM Reviews)=:rating AND 
								(SELECT AVG(r.rating) FROM Reviews) IS NOT NULL";
	}
	$sql_statement .= " GROUP BY itemId";
	return $sql_statement;
}
?>