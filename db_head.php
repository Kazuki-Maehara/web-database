<?php

	session_start();
	// verifying a connection
	if(!isset($_SESSION['user_name'])) {
		header("Location: login.php");
		exit;
	}




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
?><!DOCTYPE html>
<html lang="ja">

