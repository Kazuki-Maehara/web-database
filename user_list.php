<?php
	require_once("db_head.php");
?>

<head>
	<title>user_list</title>
	<style>
		table {
			border-collapse: collapse;
		}
		table, th, td {
			border: 1px #000 solid;
		}
	</style>
</head>
<body>
<a href="menu.php">Back to menu</a>
<br>
<hr>

	<h1>Block list</h1>
	<p><?php
//requesting data amount of block table
$resultCount = $mysqli -> query("SELECT COUNT(*) AS cnt FROM block");
$rowCountBlock = $resultCount -> fetch_assoc();
echo htmlentities($rowCountBlock['cnt']."-data exist.");
$resultCount -> free();
	?></p>

<h3>Creating a new record</h3>
<table border="1">
<form action="reg_data.php" method="POST">
	<tr>
		<th>block_id</th>
		<th>block_ name</th>
		<th>block_kana</th>
		<th>created</th>
		<th>modified</th>
		<th>&nbsp;</th>
	</tr>
	<tr>
		<td>-- Automatic serial number --</td>
		<td><input type="text" name="block[block_name]" required></td>
		<td><input type="text" name="block[block_kana]" required></td>
		<td>-- Automatic aquisition --</td>
		<td>-- Automatic aquisition --</td>
		<td><input type="submit" value="Create!"></td>
	</tr>
</form>
</table><br>


<?php if($rowCountBlock['cnt']): //if there is at least one data ?>
<h3>Data list</h3>
<table border="1">
	<tr>
		<th>block_id</th>
		<th>block_name</th>
		<th>block_kana</th>
		<th>created</th>
		<th>modified</th>
		<th>&nbsp;</th>
	</tr>

<?php
	//requesting all data of block table
	$resultBlock = $mysqli -> query("SELECT * FROM block");
	while($rowBlock = $resultBlock -> fetch_assoc()) {
		echo "<tr>";
		echo "<form action=\"edit_data.php\" method=\"POST\">";
		echo "<td>".$rowBlock['id']."</td>";
		echo "<td>".$rowBlock['block_name']."</td>";
		echo "<td>".$rowBlock['block_kana']."</td>";
		echo "<td>".$rowBlock['created']."</td>";
		echo "<td>".$rowBlock['modified']."</td>";
		echo "<td><input type=\"submit\" value=\"Edit\"></td>";
		echo "<input type=\"hidden\" name=\"block[id]\" value=\"".$rowBlock['id']."\">";
		echo "</form>";
		echo "</tr>";
	}

	$resultBlock -> free();

?>

</table>

<?php endif; ?>

<br>

<hr>

	<h2>Shop list</h2>
	<p><?php
//requesting data amount of shop table
$resultCountShop = $mysqli -> query("SELECT COUNT(*) AS cnt FROM shop");
$rowCountShop = $resultCountShop -> fetch_assoc();
echo htmlentities($rowCountShop['cnt']."-data exist.");
$resultCountShop -> free();
	?></p>

<h3>Creating a new record</h3>

<?php if($rowCountBlock['cnt'] == 0): //if there is no block data ?>
<p>!! In advance, you must create at least one block data !!</p>

<?php else: ?>
<table border="1">
<form action="reg_data.php" method="POST">
	<tr>
		<th>shop_id</th>
		<th>shop_name</th>
		<th>shop_kana</th>
		<th>block_id</th>
		<th>created</th>
		<th>modified</th>
		<th>&nbsp;</th>
	</tr>
	<tr>
		<td>-- Automatic serial number --</td>
		<td><input type="text" name="shop[shop_name]" required></td>
		<td><input type="text" name="shop[shop_kana]" required></td>
		<td>
			<select name="shop[block_id]">
<?php
	//getting block list; name is block_name and value is block_id
	//requesting all data of the block table
	$resultBlock = $mysqli -> query("SELECT * FROM block");
	while($rowBlock = $resultBlock -> fetch_assoc()) {
		echo "<option value=\"".$rowBlock[id]."\">".$rowBlock['block_name']."</option>";
	}
?>
			</select>
		</td>
		<td>-- Automatic serial number --</td>
		<td>-- Automatic serial number --</td>
		<td><input type="submit" value="Create!"></td>
	</tr>

</form>
</table>
<?php endif ?>

<br>

<?php if($rowCountShop['cnt']): //if there is at least one data ?>
<h3>Data list</h3>
<table border="1">
	<tr>
		<th>shop_id</th>
		<th>shop_name</th>
		<th>shop_kana</th>
		<th>block_id</th>
		<th>created</th>
		<th>modified</th>
		<th>&nbsp;</th>
	</tr>

<?php
	//requesting all data of shop table
	$resultShop = $mysqli -> query("SELECT * FROM shop");

	while($rowShop = $resultShop -> fetch_assoc()) {
		echo "<tr>";
		echo "<form action=\"edit_data.php\" method=\"POST\">";
		echo "<td>".$rowShop['id']."</td>";
		echo "<td>".$rowShop['shop_name']."</td>";
		echo "<td>".$rowShop['shop_kana']."</td>";
		echo "<td>".$rowShop['block_id']."</td>";
		echo "<td>".$rowShop['created']."</td>";
		echo "<td>".$rowShop['modified']."</td>";
		echo "<td><input type=\"submit\" value=\"Edit\"></td>";
		echo "<td><input type=\"hidden\" name=\"shop[id]\" value=\"".$rowShop['id']."\">";
		echo "</form>";
		echo "</tr>";
	}

	$resultShop -> free();
?>
</table>
<?php endif; ?>

<br>
<hr>


	<h2>User list</h2>
	<p><?php
//requesting all data of user table
$resultCountUser = $mysqli -> query("SELECT COUNT(*) AS cnt FROM user");
$rowCountUser = $resultCountUser -> fetch_assoc();
echo htmlentities($rowCountUser['cnt']."-data exist.");
$resultCountUser -> free();
	?></p>

<?php if($rowCountShop['cnt'] == 0): //if there is no shop data ?>
<p>!! In advance, you must create shop data !!</p>

<?php else: ?>
<h3>Creating a new record</h3>
<table border="1">
<form action="reg_data.php" method="POST">
	<tr>
		<th>user_id</th>
		<th>account</th>
		<th>password</th>
		<th>name_a</th>
		<th>name_b</th>
		<th>kana_a</th>
		<th>kana_b</th>
		<th>permit</th>
		<th>shop_id</th>
		<th>created</th>
		<th>modified</th>
		<th>&nbsp;</th>
	</tr>
	<tr>
		<td>-- Automatic serial number --</td>
		<td><input type="text" name="user[account]" size="10" required></td>
		<td><input type="text" name="user[password]" size="10" required></td>
		<td><input type="text" name="user[name_a]" size="10" required></td>
		<td><input type="text" name="user[name_b]" size="10" required></td>
		<td><input type="text" name="user[kana_a]" size="5" required></td>
		<td><input type="text" name="user[kana_b]" size="5" required></td>
		<td>
		<select name="user[permit]">
			<option value="0">General</option>
			<option value="1">Administrator</option>
		</select>
		</td>
		<td>
			<select name="user[shop_id]">

			<?php
			//getting shoplist; name is shop_name and value is shop_id
			//requesting all data of block table
			$resultShop = $mysqli -> query("SELECT * FROM shop");
			while($rowShop = $resultShop -> fetch_assoc()) {
					echo "<option value=\"".$rowShop['id']."\">".$rowShop['shop_name']."</option>";
			}
			?>

			</select>
		</td>
		<td>-- Automatic serial number --</td>
		<td>-- Automatic serial number --</td>
		<td><input type="submit" value="Create!"></td>
	</tr>
</form>
</table>
<?php endif; ?>

<br>

<?php if($rowCountUser['cnt']): //if there is at least one data ?>
<h3>Data list</h3>
<table border="1">
	<tr>
		<th>user_id</th>
		<th>account</th>
		<th>password</th>
		<th>name</th>
		<th>kana</th>
		<th>permit</th>
		<th>shop_id</th>
		<th>created</th>
		<th>modified</th>
		<th>&nbsp;</th>
	</tr>
	<?php
	//requesting all data of user table
	$resultUser = $mysqli -> query("SELECT * FROM user");

	while($rowUser = $resultUser -> fetch_assoc()) {
		echo "<tr>";
		echo "<form action=\"edit_data.php\" method=\"POST\">";
		echo "<td>".$rowUser['id']."</td>";
		echo "<td>".$rowUser['account']."</td>";
		echo "<td>".$rowUser['password']."</td>";
		// concatanating first-name and last-name
		echo "<td>".$rowUser['name_a']." ".$rowUser['name_b']."</td>";
		// concatanating phonetic text
		echo "<td>".$rowUser['kana_a']." ".$rowUser['kana_b']."</td>";
		if($rowUser['permit'] == 1) {
			echo "<td>Administrator</td>";
		} else {
			echo "<td>General</td>";
		}
		echo "<td>".$rowUser['shop_id']."</td>";
		echo "<td>".$rowUser['created']."</td>";
		echo "<td>".$rowUser['modified']."</td>";
		echo "<td><input type=\"submit\" value=\"Edit!\"></td>";
		echo "<input type=\"hidden\" name=\"user[id]\" value=\"".$rowUser['id']."\">";
		echo "</form>";
		echo "</tr>";
	}

	$resultUser -> free();
	?>
</table>
<?php endif; ?>

<br><br><br>
</body>
<?php
	require_once("db_foot.php");
?>

