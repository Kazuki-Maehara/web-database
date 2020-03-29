<?php
require_once("db_head.php");
?>

<head>
	<title>Edit page</title>
</head>
<body>
<h1>Data checking/revising</h1>
<?php
	// getting target-table name out from key of POST data array
	foreach($_POST as $p_key => $p_array) {
		if($p_key != "mode") {
			$table_name = $p_key;
		}
	}

	// gettign id of target data
	$target_id = $_POST[$table_name]['id'];

	// when comming with 'edit mode', following code will be carried out
	if($_POST['mode'] == "upd") {
		$sql = "UPDATE ".$table_name." SET ";
		foreach($_POST[$table_name] as $u_key => $u_value) {
			// 'id' column is ignored
			if($u_key != "id") {
				$sql .= $u_key."='".$u_value."',";
			}
		}

		// setting the modified datetime
		$sql .= "modified='".date("Y-m-d H:i:m")."'";

		// limiting data by 'id'
		$sql .= " WHERE id=".$target_id;

		// issuing the SQL sentence
		$resultInsBlock = $mysqli -> query($sql);


		if($mysqli -> error) {
			echo $mysqli -> error;
		}

		echo "<hr><h2>Update successed</h2><hr>";
	} // end of the edit mode

	// following code is for when comming from 'data list', and showing updated data

	// getting the column information from specified table
	$resultColumn = $mysqli -> query("SHOW FULL COLUMNS FROM ".$table_name);
	
	// getting comments from each column
	$commentList = [];
	while($rowColumn = $resultColumn -> fetch_assoc()) {
		// storing comments in array which has keys of each column name
		// then it's such that "$commentList['block_name'] = "ブロック名"

		$commentList[$rowColumn['Field']] = $rowColumn['Comment'];
	}

?>

<table>
<form method="POST" action="edit_data.php">
<!-- sending POST to this program itself  -->

<!-- edit-mode flag -->
<input type="hidden" name="mode" value="upd">

<?php
	// getting id data from specified table
	$resultBlock = $mysqli -> query("SELECT * FROM ".$table_name." WHERE id=".$target_id);

	// not needing 'while sentence" becouse of single data
	$rowBlock = $resultBlock -> fetch_assoc();

	// carrying out rendering process
	foreach($commentList as $cl_k => $cl_v) {
		echo "<tr>";

		// not editing id, created and modified field
		if($cl_k == 'id' || $cl_k == 'created' || $cl_k == 'modified') {
			echo "<td>".$cl_v."</td>";
			echo "<td>".$rowBlock[$cl_k]."</td>";
			// if 'Field' name is 'id', then make form have value in hidden type
			if($cl_k == 'id') {
				echo "<input type=\"hidden\" name=\"".$table_name."[id]\" value=\"".$rowBlock['id']."\">";
			}
		// being able to edit other than above
		} else {
			echo "<td>".$cl_v."</td>";
			echo "<td><input type=\"text\" name=\"".$table_name."[".$cl_k."]\" value=\"".$rowBlock[$cl_k]."\" required></td>";
		}
	echo "</tr>";
	}
?>
<tr>
<td>&nbsp;</td>
<td><input type="submit" value="Update"></td>
</tr>
</form>
</table>

<p>
<a href="user_list.php">Go back to user-list page</a>
</p>
</body>

<?php
require_once("db_foot.php");
?>

