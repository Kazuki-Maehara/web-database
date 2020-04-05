<?php
	// verifying a connection
	session_start();

	//connecting to database, "nsw"
	$mysqli = new mysqli("localhost", "root", "271828", "nsw");

	if($mysqli -> connect_error) { 
		echo $mysqli -> connect_error;
		exit();
	}
	//setting character code
	$result = $mysqli -> query("set names utf8;");

	//setting time-zone
	date_default_timezone_set("Asia/Tokyo");

	// comparing input data and table, then calculating a number of matchs
	$checkLogin = $mysqli -> query("SELECT COUNT(*) AS checkFlg FROM user WHERE account='".$_POST['account']."' AND password='".$_POST['password']."'");
	$row = $checkLogin -> fetch_assoc();


	// if matchs are not 1, then go to login.php with verifying error
	if($row['checkFlg'] != 1) {
		header('Location: login.php?error=1');
		exit;
	} else {
		// getting information to write out to 'session' from database
		$userCheck = $mysqli -> query("SELECT * FROM user WHERE account='".$_POST['account']."' AND password='".$_POST['password']."'");
		
		$row = $userCheck -> fetch_assoc();

		// write out to the session
		$_SESSION['user_name'] = $row['name_a'].$row['name_b'];

		// get the whole other data into "$_SESSION['user_data']"
		$_SESSION['user_data'] = $row;

		// jumping to Menu page
		header('Location: menu.php');
		exit;
	}
?>

