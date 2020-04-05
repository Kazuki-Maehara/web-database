<?php
	require_once("db_head.php");
?>

	<head>
		<title>Menu page</title>
	</head>
	<body>
<?php
	// other data gained from table is be able to refer by code of "$SESSION['user_data']["column name"].
	echo "<h1>".$_SESSION['user_data']['name_a']."'s menu page</h1>";
?>

	<a href="user_list.php">Data list</a>
<hr>
	<a href="sale.php">Sales</a>
<br>
<hr>
	<a href="sale_list.php">Receipt</a>
<br>
<hr>
	<a href="logout.php">Log out</a>
	</body>

<?php
	require_once("db_foot.php");
?>

