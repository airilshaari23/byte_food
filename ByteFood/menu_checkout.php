<?php
    include("database.php");
    //get session data first for page authentication
    if (!isset($_SESSION['member']))
    {
      //redirect to login_terminated.html
      //access violation of page
      $to = "login_terminated.php";
      
      header('Location: '. $to);
      exit;
    }

    $member = $_SESSION['member'];

    $db = getDatabase();

    $menufood = $db->menufood_listing();
    $menudrink = $db->menudrink_listing();

    $orders = isset($_POST['menu']) ? $_POST['menu'] : NULL;
    $ordersquantity = isset($_POST['quantity']) ? $_POST['quantity'] : NULL;
   
    $data_order = array();

    if ($orders){
      foreach ($ordersquantity as $qk=>$qv){
        if ($qv != '' && is_numeric($qv))
        $data_order[$qk]['order_quantity'] = $qv;
      }
      foreach ($orders as $order){
        if (array_key_exists($order, $data_order)) {
          $data_order[$order]['menu_name'] = $order;
        }
      }
      foreach ($menufood as $mf){
        if (array_key_exists($mf->menu_name, $data_order)) {
          $data_order[$mf->menu_name]['price'] = $mf->menu_price;
        }
      }
      foreach ($menudrink as $md){
        if (array_key_exists($md->menu_name, $data_order)) {
          $data_order[$md->menu_name]['price'] = $md->menu_price;
        }
      }
    }

    $_SESSION['order'] = $data_order;
?>
<?php include 'head.php';?>

<form class="form-horizontal" method="post" action="menu_order_ctrl.php">
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2>Menu List</h2>
      <p>&nbsp;</p>
      <div class="alert alert-dismissible bf-form-bg cardshadow">
        <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Menu Name</th>
            <th>Menu Price</th>
            <th>Quantity</th>
            <th>Total Price</th>
          </tr>
        </thead>
        <tbody>
            <?php $index = 1; $totalprice = 0; foreach( $data_order as $row ) { ?>
              <tr>
                <td class='id-column'><?=$index++?></td>
                <td><?=ucwords($row['menu_name'])?></td>
                <td><?=$row['price']?></td>
                <td><?=$row['order_quantity']?></td>
                <?php $total =  number_format(($row['order_quantity'] * $row['price']),2);
                $totalprice += $total; ?>
                <td><?=$total?></td>
            <?php } ?>        
        </tbody>
        </table>  
        <div class="form-group">
		      <label for="totalprice" class="col-lg-2 control-label">Total Price</label>
		      <div class="col-lg-10">
		        <input type="text" class="form-control" id="totalprice" name="totalprice" value="<?=number_format($totalprice,2)?>" readonly>
		      </div>
		    </div>
  	  	<div class="form-group">
  	    	<div class="col-lg-10 col-lg-offset-2">
  	       		<a href="menu_list.php?parent=menu" class="btn btn-default">Cancel</a>
              <?php if (number_format($totalprice,2) != 0.00){ ?>
  	      		<button type="submit" class="btn btn-primary">Order</button>
              <?php } ?>
  	    	</div>
  	  	</div>  
      </div>
    </div>
  </div>
</div>
</form>
</body>
</html>
