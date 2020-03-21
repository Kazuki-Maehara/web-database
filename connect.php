<?php
	//connecting to database, "nsw"
	$mysqli = new mysqli("localhost", "root", "271828", "nsw");

	if($mysqli -> connect_error) {
		echo $mysqli -> connect_error;
		exit();
	}else{
		echo "<p>Connection successful</p>";
	}

	//reqiesting the data amount of "user" table
	$result = $mysqli -> query("SELECT COUNT(*) AS cnt FROM user");
	$row = $result -> fetch_assoc();
	echo htmlentities($row['cnt']."-data exist.");

	//disconnecting from the database
	$mysqli -> close();
?>
