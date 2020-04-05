<?php
	// verifying the user
	session_start();	// start session
	
	// delete session data that was used to judge
	unset($_SESSION['user_name']);

	// delete session data of user information
	unset($_SESSION['user_data']);


	// redirect to the login.php
	header("Location: login.php");
	exit;
?>
