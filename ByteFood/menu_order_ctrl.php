<?php
	include("database.php");
	$order = $_SESSION['order'];
	$member = $_SESSION['member'];

	$db = getDatabase();

	$order_seq = $db->OrderSeqNo();

	if ($order_seq->order_no < 10){
		$order_seqno = "BF000$order_seq->order_no";
	}
	else if ($order_seq->order_no < 100){
		$order_seqno = "BF00$order_seq->order_no";
	}
	else if ($order_seq->order_no < 1000){
		$order_seqno = "BF0$order_seq->order_no";
	}
	else{
		$order_seqno = "BF$order_seq->order_no";
	}
	foreach ($order as $row){
		$insertResult = $db->insertOrder($order_seqno, $row['menu_name'], $row['order_quantity'], $row['price'], $member->username);
	}

	$neworderno = $order_seq->order_no + 1;
	$updateResult = $db->updateOrderNo($neworderno);

	if ($insertResult->status) {
		header("Location: order_list.php?parent=order"); /* Redirect browser */
		exit();
	} else {		
		$_SESSION['error'] = $insertResult->error;
		header("Location: dberror.php?parent=order"); /* Redirect browser */
		exit();
	}
?>