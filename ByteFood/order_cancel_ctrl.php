<?php
	include("database.php");

	$db = getDatabase();

	$orderno = $_GET['orderno'];
	$cancel = $_GET['cancel'];

	$updateResult = $db->cancelOrder($orderno, $cancel);
	
	if ($updateResult->status) {
		header("Location: order_list.php?parent=order"); /* Redirect browser */
		exit();
	} else {		
		$_SESSION['error'] = $updateResult->error;
		header("Location: dberror.php?parent=order"); /* Redirect browser */
		exit();
	}
?>


