<?php
	include("database.php");

	$db = getDatabase();

	$username = $_POST['username'];
	$password = $_POST['password'];

	$member = $db->loginvalidation($username, $password);

	//echo json_encode($member);
	//exit;

	if (isset($member->username)) {
		$_SESSION['member']= $member;
		header("Location: menu_list.php?parent=menu"); /* Redirect browser */
		exit();
	} else {
		header("Location: login_failed.php"); /* Redirect browser */
		exit();
	}
?>



