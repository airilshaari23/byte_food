<?php
	ini_set("date.timezone", "Asia/Kuala_Lumpur");

    include_once("database_ctrl.php");

	session_start();   

	function getDatabase() {
    	$dbhost="localhost";
    	$dbuser="root";
    	$dbpass="";
    	$dbname="foodorderdb";

    	$db = new Database($dbhost, $dbuser, $dbpass, $dbname);
    	return $db;
	}
?>