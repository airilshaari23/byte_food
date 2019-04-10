<?php
class Member {
		var $id;
		var $type;
    	var $username;
    	var $name;
    	var $age;
    	var $email;
    	var $address; 
    	var $dob; 
    	var $photo; 
    	var $status; 
    	var $addeddate;
   	}

   	class Menu {
   		var $id;
   		var $menu_name;
    	var $menu_type;
    	var $menu_category;
    	var $menu_price;
    	var $menu_status; 
    	var $addeddate; 
   	}

   	class OrderHis {
   		var $order_no;
    	var $order_status;
    	var $order_date;
    	var $foodprice;
   	}

   	class Order {
   		var $id;
   		var $order_no;
    	var $menu_name;
    	var $order_quantity;
    	var $price_per_unit;
    	var $order_status;
    	var $order_date;
    	var $user_id;
   	}

   	class OrderNo {
   		var $order_no;
   	}

   	class DeleteResult {
	    var $status;
	    var $error;
   	}

   	class InsertResult {
      var $status;
      var $error;
   	}

   	class UpdateResult {
      var $status;
      var $error;
   	}

   	function time_elapsed_string($datetime, $full = false) {
      	if ($datetime == '0000-00-00 00:00:00')
         	return "none";

      	$now = new DateTime;
      	$ago = new DateTime($datetime);
      	$diff = $now->diff($ago);

      	$diff->w = floor($diff->d / 7);
      	$diff->d -= $diff->w * 7;

      	$string = array(
         	'y' => 'year',
         	'm' => 'month',
         	'w' => 'week',
         	'd' => 'day',
         	'h' => 'hour',
         	'i' => 'minute',
         	's' => 'second',
      	);
      
      	foreach ($string as $k => &$v) {
         	if ($diff->$k) {
            	$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
         	} else {
            	unset($string[$k]);
         	}
      	}

      	if (!$full) $string = array_slice($string, 0, 1);
         	return $string ? implode(', ', $string) . ' ago' : 'just now';
   	}

   	class Database {
   		protected $dbhost;
    	protected $dbuser;
    	protected $dbpass;
    	protected $dbname;
    	protected $db;

	 	function __construct( $dbhost, $dbuser, $dbpass, $dbname) {
	   		$this->dbhost = $dbhost;
	   		$this->dbuser = $dbuser;
	   		$this->dbpass = $dbpass;
	   		$this->dbname = $dbname;

	   		$db = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
	    	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	        $db->setAttribute(PDO::MYSQL_ATTR_FOUND_ROWS, true);
	    	$this->db = $db;
	   	}
	   	function beginTransaction() {
	        try {
	           $this->db->beginTransaction(); 
	        }
	        catch(PDOException $e) {
	           $errorMessage = $e->getMessage();
	           return 0;
	        } 
	    }

      	function commit() {
         	try {
            	$this->db->commit();
         	}
         	catch(PDOException $e) {
            	$errorMessage = $e->getMessage();
            	return 0;
         	} 
      	}

      	function rollback() {
         	try {
            	$this->db->rollback();
         	}
         	catch(PDOException $e) {
            	$errorMessage = $e->getMessage();
            	return 0;
         	} 
      	}

      	function close() {
         	try {
            	$this->db = null;   
         	}
         	catch(PDOException $e) {
            	$errorMessage = $e->getMessage();
            	return 0;
         	} 
      	}
		function loginvalidation($username, $password) {
	        $sql = "SELECT *
	                FROM membership
	                WHERE username = :username
	                AND password = :password";

	        $stmt = $this->db->prepare($sql);
	        $stmt->bindParam("username", $username);
	        $stmt->bindParam("password", $password);
	        $stmt->execute(); 
	        $row_count = $stmt->rowCount();

	        $member = new Member();

	        if ($row_count)
	        {
	        	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	        	{
	        		$member->id = $row['id'];
	        		$member->type = $row['type'];
	        		$member->username = $row['username'];
	        		$member->name = $row['name'];
	        		$member->age = $row['age'];
	        		$member->email = $row['email'];
	        		$member->address = $row['address'];
	        		if ($row['dob'] != NULL){
	        		 $member->dob = $row['dob'];
	        		}
	        		else{
	        		 $member->dob = NULL;
	        		}
	        		$member->photo = $row['photo'];
	        		$member->status = $row['status']; 
	        		$member->addeddate = $row['addeddate'];
	        	}
	        }

	        return $member;
		}
		function menufood_listing(){
			$sql = "SELECT *
	                FROM menu_listing
	                WHERE menu_type = 'food'
	                AND menu_status = 'A'
	                ORDER BY menu_category, menu_name";

	        $stmt = $this->db->prepare($sql);
	        $stmt->execute(); 
	        $row_count = $stmt->rowCount();

	        

	        if ( count($row_count) )
	        {
	            $data_menu = array();

	            while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	            {
	               $menu = new Menu();
	               $menu->id = $row['id'];
	               $menu->menu_name = $row['menu_name'];
	               $menu->menu_type = $row['menu_type'];
	               $menu->menu_category = $row['menu_category'];
	               $menu->menu_price = number_format($row['menu_price'],2);
	               $menu->menu_status = $row['menu_status'];
	               $addeddate = $row['addeddate'];
               	   $menu->addeddate = time_elapsed_string($addeddate);
	               array_push($data_menu, $menu);
	            }
	        }
	        //print_r($data_menu);
	        //exit();
	        return $data_menu;	
		}
		function menudrink_listing(){
			$sql = "SELECT *
	                FROM menu_listing
	                WHERE menu_type = 'drink'
	                AND menu_status = 'A'
	                ORDER BY menu_category, menu_name";

	        $stmt = $this->db->prepare($sql);
	        $stmt->execute(); 
	        $row_count = $stmt->rowCount();

	        

	        if ( count($row_count) )
	        {
	            $data_menu = array();

	            while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	            {
	               $menu = new Menu();
	               $menu->id = $row['id'];
	               $menu->menu_name = $row['menu_name'];
	               $menu->menu_type = $row['menu_type'];
	               $menu->menu_category = $row['menu_category'];
	               $menu->menu_price = number_format($row['menu_price'],2);
	               $menu->menu_status = $row['menu_status'];
	               $addeddate = $row['addeddate'];
               	   $menu->addeddate = time_elapsed_string($addeddate);
	               array_push($data_menu, $menu);
	            }
	        }
	        //print_r($data_menu);
	        //exit();
	        return $data_menu;	
		}
		function insertOrder($order_no, $menu_name, $order_quantity, $price_per_unit, $user_id) {
	        $sql = "INSERT INTO order_history(order_no, menu_name, order_quantity, price_per_unit, order_date, user_id)
	                VALUES (:order_no, :menu_name, :order_quantity, :price_per_unit, NOW(), :user_id)";

	        try {
	            $stmt = $this->db->prepare($sql);  
	            $stmt->bindParam("order_no", $order_no);
	            $stmt->bindParam("menu_name", $menu_name);
	            $stmt->bindParam("order_quantity", $order_quantity);
	            $stmt->bindParam("price_per_unit", $price_per_unit);
		        $stmt->bindParam("user_id", $user_id);
	            $stmt->execute();

	            $insertResult = new InsertResult();
	            $insertResult->status = true;
	            return $insertResult;
	            
	            //return $this->db->lastInsertId();
	         }
	        catch(PDOException $e) {
	            $errorMessage = $e->getMessage();

	            $insertResult = new InsertResult();
	            $insertResult->status = false;
	            $insertResult->error = $errorMessage;
	            return $insertResult;
         	}                      
      	}
      	function OrderSeqNo(){
      		$sql = "SELECT *
      				FROm order_number_seq";

      		$stmt = $this->db->prepare($sql);
	        $stmt->execute(); 
	        $row_count = $stmt->rowCount();

	        $orderseq = new OrderNo();

	        if ($row_count)
	        {
	            while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	            {
	               $orderseq->order_no = $row['order_no'];
	            }
	        }

	        return $orderseq;
      	}
      	function updateOrderNo($order_no){
      		$sql = "UPDATE order_number_seq
      				SET order_no = :order_no";

      		try {
	            $stmt = $this->db->prepare($sql); 
	            $stmt->bindParam("order_no", $order_no);
	            $stmt->execute();

	            $updateResult = new UpdateResult();
	            $updateResult->status = true;
	            return $updateResult;
	        }
	        catch(PDOException $e) {
	            $errorMessage = $e->getMessage();

	            $updateResult = new InsertResult();
	            $updateResult->status = false;
	            $updateResult->error = $errorMessage;
	            return $updateResult; 
	        }
      	}
      	function order_listing($user_id){
			$sql = "SELECT order_no, SUM(price_per_unit*order_quantity) AS foodprice, order_status, order_date
	                FROM order_history
	                WHERE user_id = :user_id
	                GROUP BY order_no DESC";

	        $stmt = $this->db->prepare($sql);
	        $stmt->bindParam("user_id", $user_id);
	        $stmt->execute(); 
	        $row_count = $stmt->rowCount();

	        

	        if ( count($row_count) )
	        {
	            $data_order = array();

	            while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	            {
	               $order = new OrderHis();
	               $order->order_no = $row['order_no'];
	               $order->order_status = $row['order_status'];
	               $order->foodprice = number_format($row['foodprice'],2);
	               $order_date = $row['order_date'];
               	   $order->order_date = time_elapsed_string($order_date);
	               array_push($data_order, $order);
	            }
	        }
	        //print_r($data_menu);
	        //exit();
	        return $data_order;	
		}
		function orderDetails($order_no){
			$sql = "SELECT *
	                FROM order_history
	                WHERE order_no = :order_no";

	        $stmt = $this->db->prepare($sql);
	        $stmt->bindParam("order_no", $order_no);
	        $stmt->execute(); 
	        $row_count = $stmt->rowCount();

	        

	        if ( count($row_count) )
	        {
	            $data_order = array();

	            while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	            {
	               $order = new OrderHis();
	               $order->id = $row['id'];
	               $order->order_no = $row['order_no'];
	               $order->menu_name = $row['menu_name'];
	               $order->order_quantity = $row['order_quantity'];
	               $order->price_per_unit = number_format($row['price_per_unit'],2);
	               $order->order_status = $row['order_status'];
	               $order->user_id = $row['user_id'];
	               $order_date = $row['order_date'];
               	   $order->order_date = time_elapsed_string($order_date);
	               array_push($data_order, $order);
	            }
	        }
	        //print_r($data_menu);
	        //exit();
	        return $data_order;	
		}
		function cancelOrder($order_no, $order_status){
      		$sql = "UPDATE order_history 
      				SET order_status = :order_status
      				WHERE order_no = :order_no";

      		try {
	            $stmt = $this->db->prepare($sql); 
	            $stmt->bindParam("order_no", $order_no);
	            $stmt->bindParam("order_status", $order_status);
	            $stmt->execute();

	            $updateResult = new UpdateResult();
	            $updateResult->status = true;
	            return $updateResult;
	        }
	        catch(PDOException $e) {
	            $errorMessage = $e->getMessage();

	            $updateResult = new InsertResult();
	            $updateResult->status = false;
	            $updateResult->error = $errorMessage;
	            return $updateResult; 
	        }
      	}
      	function getProfileInfo($username){
      		$sql = "SELECT *
      				FROM membership
      				WHERE username = :username";

      		$stmt = $this->db->prepare($sql);
	        $stmt->bindParam("username", $username);
	        $stmt->execute(); 
	        $row_count = $stmt->rowCount();

	        $profile = new Member();

	        if ($row_count)
	        {
	            while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	            {
	               $profile->id = $row['id'];
	               $profile->type = $row['type'];
	               $profile->username = $row['username'];
	               $profile->name = $row['name'];
	               $profile->age = $row['age'];
	               $profile->email = $row['email'];
	               $profile->address = $row['address'];
	               if ($row['dob']){
	               	$profile->dob = date("d-m-Y",strtotime($row['dob']));
	               }
	               else{
	               	$profile->dob = NULL;
	               }

	               $profile->photo = $row['photo'];
	               $profile->status = $row['status'];
	               $profile->addeddate = $row['addeddate'];
	            }
	        }

	        return $profile;
      	}
      	function editProfile($username, $name, $age, $email, $address, $dob){
      		$sql = "UPDATE membership
      				SET name = :name,
      				age = :age,
      				email = :email,
      				address = :address,
      				dob = :dob
      				WHERE username = :username";

      		try {
	            $stmt = $this->db->prepare($sql); 
	            $stmt->bindParam("username", $username);
	            $stmt->bindParam("name", $name);
	            $stmt->bindParam("age", $age);
	            $stmt->bindParam("email", $email);
	            $stmt->bindParam("address", $address);
	            $stmt->bindParam("dob", $dob);
	            $stmt->execute();

	            $updateResult = new UpdateResult();
	            $updateResult->status = true;
	            return $updateResult;
	        }
	        catch(PDOException $e) {
	            $errorMessage = $e->getMessage();

	            $updateResult = new InsertResult();
	            $updateResult->status = false;
	            $updateResult->error = $errorMessage;
	            return $updateResult; 
	        }
      	}
      	function updateProfilePhoto($username, $photo) {
	        $sql = "UPDATE membership
	                SET photo = :photo
	                WHERE username = :username";

	        try {
	           	$stmt = $this->db->prepare($sql); 
	           	$stmt->bindParam("username", $username);
	           	$stmt->bindParam("photo", $photo);
	           	$stmt->execute();

	           	$updateResult = new UpdateResult();
	           	$updateResult->status = true;
	           	return $updateResult;
	        }
	        catch(PDOException $e) {
	           	$errorMessage = $e->getMessage();

	           	$updateResult = new InsertResult();
	           	$updateResult->status = false;
	           	$updateResult->error = $errorMessage;
	           	return $updateResult; 
	        }       
	    }
	    function editPassword($username, $password){
      		$sql = "UPDATE membership
      				SET password = :password
      				WHERE username = :username";

      		try {
	            $stmt = $this->db->prepare($sql); 
	            $stmt->bindParam("username", $username);
	            $stmt->bindParam("password", $password);
	            $stmt->execute();

	            $updateResult = new UpdateResult();
	            $updateResult->status = true;
	            return $updateResult;
	        }
	        catch(PDOException $e) {
	            $errorMessage = $e->getMessage();

	            $updateResult = new InsertResult();
	            $updateResult->status = false;
	            $updateResult->error = $errorMessage;
	            return $updateResult; 
	        }
      	}
      	function registerUser($name, $username, $password) {
         	$sql = "INSERT INTO membership(name, username, password, addeddate)
                 	VALUES (:name, :username, :password, NOW())";

         	try {
            	$stmt = $this->db->prepare($sql);  
            	$stmt->bindParam("name", $name);
            	$stmt->bindParam("username", $username);
            	$stmt->bindParam("password", $password);
            	$stmt->execute();

            	$insertResult = new InsertResult();
            	$insertResult->status = true;
            	return $insertResult;
            
            	//return $this->db->lastInsertId();
         	}
         	catch(PDOException $e) {
            	$errorMessage = $e->getMessage();

            	$insertResult = new InsertResult();
            	$insertResult->status = false;
            	$insertResult->error = $errorMessage;
            	return $insertResult;
         	}                      
      	}
   	}
?>