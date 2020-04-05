<?php
	require_once("db_head.php");
?>

<head>
	<title>Receipt list</title>
	<style>
		table {
			border-collapse: collapse;
		}
		td {
			text-align: right;
		}
	</style>
</head>
<body>
<div>
<a href="menu.php">Back to menu</a>
</div>
	<h2>Filter settings</h2>
	<form method="GET" action="sale_list.php">
	<table>
		<tr>
			<td>Block</td>
			<td>
				<select name="block_id">
					<option value="">-</option>
<?php
	// get block list; a value is "block_id", a view is a real block name
	// request whole data of block table
	$resultBlock = $mysqli -> query("SELECT * FROM block");
	while($rowBlock = $resultBlock -> fetch_assoc()) {
		// if anything is specified by a filter, $selected flag is assigned to " selected"
		if($rowBlock['id'] == $_GET['block_id']) {
			$selected = " selected";
		} else {
			$selected = null;
		}
		echo "<option value=\"".$rowBlock['id']."\"".$selected.">".$rowBlock['block_name']."</option>";
	}
?>

				</select>
			</td>
			<td>&nbsp;</td>
			<td>Shop</td>
			<td>
				<select name="shop_id">
					<option value="">-</option>
<?php
	// get shop list; a value is "shop_id", a view is a real shop name
	// request whole data of block table
	$resultShop = $mysqli -> query("SELECT * FROM shop");
	while($rowShop = $resultShop -> fetch_assoc()) {
		if($rowShop['id'] == $_GET['shop_id']) {
			$selected = " selected";
		} else {
			$selected = null;
		}
		echo "<option value=\"".$rowShop['id']."\"".$selected.">".$rowShop['shop_name']."</option>";
	}
?>
				</select>
			</td>
			<td>&nbsp;</td>
			<td>Date of sales</td>
			<td>
			
<?php
	if($_GET['sold_date']) {
		$sold_date = " value=\"".$_GET['sold_date']."\"";
	} else {
		$selected = null;
	}
	echo "<input type=\"date\" name=\"sold_date\"".$sold_date.">";
?>
			</td>
			<td>&nbsp;</td>
			<td>
				<input type="submit" value="Filter">
			</td>
		</tr>
	</table>
</form>

<p>/* Except Chrome, 'input type="date"' which specifies Date of sales does NOT work out as you expect. */</p>

<h2>Filtered result</h2>
<table border="1">
	<tr>
		<th>Sales date</th>
		<th>Receipt No.</th>
		<th>Quantity</th>
		<th>Subtotal</th>
		<th>Shop</th>
		<th>Sales rep.</th>
	</tr>

<?php
	// an array which is expected to be assigned filter settings
	$whereArray = [];

	// if GET argument is set
	// specify a block
	if($_GET['block_id']) {
		$whereArray[] = " block_id=".$_GET['block_id'];
	}

	// specify a shop
	if($_GET['shop_id']) {
		$whereArray[] = " shop_id=".$_GET['shop_id'];
	}

	// specify a date of sales
	if($_GET['sold_date']) {
		$whereArray[] = " sale.sold_date=".$_GET['sold_date'];
	}

	// if any conditions are in $whereArray, generate a WHERE sentence
	if(count($whereArray)!=0) {
		$whereString = " WHERE ".implode(" AND ",$whereArray)." ";
	} else {
		$whereString = " "; // if nothing is specified, add a half-width space
		// Without above, JOIN and GROUP BY sentences are concatenated; A SQL sentence will be malfunctional
	}
	
	// get data for listing view
	$resultSale = $mysqli -> query(
		"SELECT *, SUM(item_count), user.name_a, shop.shop_name FROM sale
		INNER JOIN user ON sale.user_id = user.id
		INNER JOIN shop ON shop.id = user.shop_id
		INNER JOIN block ON shop.block_id = block.id".
		$whereString
		."GROUP BY regist_no"
		);

	while($rowSale = $resultSale -> fetch_assoc()) {
		// calculate each sales ammount per receipt
			$resultPrice = $mysqli -> query(
				"SELECT *, item.price FROM sale
				INNER JOIN item ON sale.item_id = item.id
				WHERE regist_no='".$rowSale['regist_no']."'"
				);
		
	
		// an variable for subtotal; it will be initialized each item
		$totalPrice = 0;
		while($rowPrice = $resultPrice -> fetch_assoc()) {
			// calculate subtotal, multiplying item quantity and price 
			$totalPrice += ($rowPrice['price'] * $rowPrice['item_count']);
		}
	
		// make comma appear each three digit
		$totalPrice = number_format($totalPrice);
	
		echo "<tr>".PHP_EOL;
		echo "<td>".$rowSale['sold_date']."</td>";
		echo "<td>".$rowSale['regist_no']."</td>";
		echo "<td>".$rowSale['SUM(item_count)']."</td>";
		echo "<td>".$totalPrice."yen</td>";
		echo "<td>".$rowSale['shop_name']."</td>";
		echo "<td>".$rowSale['name_a']."</td>";
		echo "</tr>".PHP_EOL;
	}
?>

