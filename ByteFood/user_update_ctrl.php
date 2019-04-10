<?php
	include("database.php");   
	
	$member = $_SESSION['member'];

  	$db = getDatabase();

	$name = $_POST['name'];
	$age = $_POST['age'];
	$email = $_POST['email'];
	$address = $_POST['address'];
	$dob = date("Y-m-d",strtotime($_POST['dob']));

	$updateResult = $db->editProfile($member->username, $name, $age, $email, $address, $dob);

	if ($_FILES['uploaded']['name']){
		class ImageInfo
	  	{
	    	public $width = 0;
	    	public $height = 0;
	    	public $type = "";
	  	}
	  
	  	function getImageInfo($filename)
	  	{
	    	list($width, $height, $type, $attr) = getimagesize($filename);
	    
	    	$imageInfo = new ImageInfo();
	    	$imageInfo->width = $width;   
	    	$imageInfo->height = $height;
	    
	    	if (intval($type) == 1)
	      	$imageInfo->type = "GIF";
	    	else if (intval($type) == 2)
	      	$imageInfo->type = "JPG";   
	    	else if (intval($type) == 3)
	      	$imageInfo->type = "PNG";
	    	else
	      	$imageInfo->type = "UNSUPPORTED"; 
	      
	    	return $imageInfo;
	  	}

	  	$size = $_FILES['uploaded']['size'];
	  	$uploaded_type = $_FILES['uploaded']['type'];
	  	$filename = explode('.',$_FILES['uploaded']['name']);
	  	$newfilename = $filename[0].'_'.$member->username.'.'.end($filename);
	  	$target = "member_img/$newfilename";
	  	move_uploaded_file($_FILES['uploaded']['tmp_name'], $target);
	  
	  	$imageInfo = getImageInfo($target);
	  	echo "Width: " . $imageInfo->width . "</br>"; 
	  	echo "Height: " . $imageInfo->height . "</br>";
	  	echo "Type: " . $imageInfo->type . "</br>";
	  	echo "Size: " . $size . "</br>";
	  
	  	if ($imageInfo->type === "UNSUPPORTED")
	  	{ 
	    	unlink($target);
	    	die("File ($uploaded_type) unsupported!");
	  	}

	  	$updateResult = $db->updateProfilePhoto($member->username, $newfilename);
	}

	if ($updateResult->status) {
		header("Location: user_profile.php?parent=profile"); /* Redirect browser */
		exit();
	} else {		
		$_SESSION['error'] = $updateResult->error;
		header("Location: dberror.php?parent=profile"); /* Redirect browser */
		exit();
	}
?>


