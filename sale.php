
<?php
	require_once("db_head.php");
?>

<head>
<style>

th {
	padding-left : 1em;
}

td {
	padding-left : 1em;
	text-align : right;
}

td input {
	text-align : right;
}

</style>

<script
	src="https://code.jquery.com/jquery-3.4.1.js"
	crossorigin="origin" integrity="sha384-mlceH9HlqLp7GMKHrj5Ara1+LvdTZVMx4S1U43/NxCvAkzIo8WJ0FE7duLel3wVo"></script>
</head>


<body>
<form method="POST" action="sale_reg.php">
<a href="menu.php">Back to menu</a>
<hr>
<br>
<table>
	<tr>
		<th class="cation">Item</th>
		<th class="cation">Amount</th>
		<th class="cation">Subtotal</th>
	</tr>

<?php
// iterate 3 times
for($i=0; $i<3; $i++) :
?>
	<tr>
		<td>
			<select name="sale[item_id][]" id="sel_<?php echo $i; ?>">
				<option value="">-</option>
<?php
	// get item names and id from "item table"
	$resultItem = $mysqli -> query("SELECT * FROM item");
	while($rowItem = $resultItem -> fetch_assoc()) {
		echo "<option value=\"".$rowItem['id']."\" data-price=\"".$rowItem['price']."\">".$rowItem['name']."</option>";
	}
?>
			</select>
		</td>
		<td data-test="x"><input type="number" style="width:4em;" name="sale[item_count][]"
		class="input_price" data-index="<?php echo $i;?>"> items</td>
		<td><span id="subtotal_<?php echo $i;?>" class="subtotal">0</span> yen</td>

<?php
// end of iterating
endfor;
?>

</table>
<hr>
<p>Total <span id="total_price">0</span> yen</p>
<input type="hidden" name="sale[user_id]" value="<?php echo $_SESSION['user_data']['id']; ?>">
<input type="submit" value="Submit">
</form>

</body>


<script>
$(function() {
	$('.input_price').on('change', function() {
		var ind = $(this).data('index');
		var sind = $('#sel_' + ind).prop("selectedIndex");
		var single_price = $('#sel_0 option').eq(sind).data('price');
		var subtotal = single_price * $(this).val();
		var total_price = 0;

		$('#subtotal_' + ind).text(subtotal);
		$('.subtotal').each(function(index, element) {
			total_price += Number($(this).text());
		})

		$('#total_price').text(total_price);
	});
});

</script>

<?php
	require_once("db_foot.php");
?>
