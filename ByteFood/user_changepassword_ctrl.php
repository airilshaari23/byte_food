<?php
	include("database.php");
	
	$member = $_SESSION['member'];

	$db = getDatabase();

	$password = $_POST['password'];
	$c_password = $_POST['c_password'];

	if ($password == $c_password){
		$updateResult = $db->editPassword($member->username, $password);
		if ($updateResult->status) {
			header("Location: logout.php"); /* Redirect browser */
			exit();
		} else {		
			$_SESSION['error'] = $updateResult->error;
			header("Location: dberror.php?parent=profile"); /* Redirect browser */
			exit();
		}
	}
	else{
		$_SESSION['error'] = 'Invalid Password';
		header("Location: user_changepassword.php?parent=profile"); /* Redirect browser */
		exit();
	}



