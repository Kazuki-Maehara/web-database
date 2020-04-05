<?php
	// verify user
	session_start(); // start to use session
	// no verified means no user name in session
	if(!isset($_SESSION['user_name'])) {
		header('Location: login.php');
		exit;
	}

	// connect
	$mysqli = new mysqli("localhost", "root", "271828", "nsw");
 
	if($mysqli -> connect_error) { // connection error
		// print error message
		echo $mysqli -> connect_error;
		exit();
	}

	// set character code
	$result = $mysqli -> query("set names utf8;");
	// set time zone
	date_default_timezone_set('Asia/Tokyo');

	// get table name from key of array of POST data
	foreach($_POST as $p_key => $p_array) {
		$table_name = $p_key;
	}
	$data_ar = [];
	foreach($_POST[$table_name] as $b_key => $b_data) {
		// delete a pair of '' from column name and add a comma
		$keys .= $b_key.",";

		// in this case, "item_id" and "item_count" are in each array
		if(is_array($b_data)) {
			foreach($b_data as $data) {
				if($data != "") {
				// when nothin was selected in sending page, you receive ""(not NULL), so You can't use is_null judgement
					if(is_numeric($data)) { // if $data is number
						$data_str = $data; // don't put ''
					} else { // if $data is not number
						$data_str = "'".$data."'"; // put ''
					}
					// assign data in an array of key names
					$data_ar[$b_key][] = $data_str;
				}
			}

		} else { // following code is for non array data(=user_id)
			// user_id can be got from $_SESSION,
			// but it is POSTed from the form.
			// following code is example for how to process a mixed data with array and non array data
			if(is_numeric($b_data)) { // if $b_data is number 
				$datas .= $b_data.","; // don't put ''
			} else {
				$datas .= "'".$b_data."',";
			}
		}
	}


	// get time of now
	// whatever data come in, then record it, so get it first
	$cDate = "'".date('Y-m-d')."'";
	$cTime = "'".date('H:i:s')."'";

	// date and time of sales
	$keys .= "sold_date,sold_time,";
	$datas .= $cDate.",".$cTime.",";

	// generate receipt id
	$keys .= "regist_no";

	// get block id from shop id of session data
	$BlockInfo = $mysqli -> query("SELECT block_id FROM shop WHERE id=".$_SESSION['user_data']['shop_id']);
	$rowBlock = $BlockInfo -> fetch_assoc();
	
	// receipt id is "block_id - shop_id - time of now"
	$regi_no = $rowBlock['block_id']."-".$_SESSION['user_data']['shop_id']."-".date('YmdHis');

	$datas .= "'".$regi_no."'";

	// check wether or not quantity and item_id data amount are equal
	if(count($data_ar['item_id'])!=count($data_ar['item_count'])) {
		// both are not equal
		echo "item quantity and item_id data count are not matched";
		exit;
	}
	
	for($i=0 ; $i<count($data_ar['item_id']) ; $i++) { // loop for item_id data amount
		$data_tmp = $data_ar['item_id'][$i].",".$data_ar['item_count'][$i].",".$datas;

		// generate INSERT sentence of SQL
		$setRegist = $mysqli -> query("INSERT INTO ".$table_name." (".$keys.") VALUES(" .$data_tmp.")");
	}


	// if error is happen
	if($mysqli -> error) {
		echo $mysqli -> error;
		exit;
	}

	// disconnect from database
	$mysqli -> close();

	// redirect to input page
	// caution : after display something, it cannot be redirecting
	/* if it uses db_head.php, then <!doctype> or <html> are displayed */
	header('Location: sale.php');
	exit;
?>
