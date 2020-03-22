<?php
require_once("db_head.php");
?>

<head>
	<title>Creating view</title>
</head>

<body>

<?php
	//first of all, getting present time
	//if anydata come to this php program, then it is registering present time to database
	$cDateTime = "'".date('Y-m-d H:i:s')."'";
	
	//created time and modified time
	$keys = "created,modified,";

	//setting values of created time and modified time
	$datas = $cDateTime.",".$cDateTime.",";

	//getting table name from the key names of POST data array
	foreach($_POST as $p_key => $p_array) {
		$table_name = $p_key;
	}

	foreach($_POST[$table_name] as $b_key => $b_data) {
		$keys .= $b_key.",";

		$datas .= "'".$b_data."',";

	}

	//removing comma at end of line
	$keys = rtrim($keys, ",");

	$datas = rtrim($datas, ",");

	
	//generating a SQL sentence
	$resultInsBlock = $mysqli -> query("INSERT INTO ".$table_name." (".$keys.") VALUES(".$datas.")");


	//if error is happen, then...
	if($mysqli -> error) {
		echo $mysqli -> error;
	}

?>
<p>
<a href="user_list.php">Return to the list page</a>
</p>
</body>

<?php
require_once("db_foot.php");
?>
