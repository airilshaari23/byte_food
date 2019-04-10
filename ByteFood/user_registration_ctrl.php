<?php
	include("database.php");

	$db = getDatabase();

	$name = $_POST['name'];
	$username = $_POST['username'];
	$password = $_POST['password'];	

	$insertResult = $db->registerUser($name, $username, $password);

	if ($insertResult->status) {
		header("Location: index.php"); /* Redirect browser */
		exit();
	} else {		
		$_SESSION['error'] = $insertResult->error;
		header("Location: user_registration.php"); /* Redirect browser */
		exit();
	}
?>


