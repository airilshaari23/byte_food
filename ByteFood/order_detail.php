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
    $orderno = $_GET['orderno'];
    $orderdetail = $db->orderDetails($orderno);
?>
<?php include 'head.php';?>

<form class="form-horizontal">
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2>Order History - <?=$orderdetail[0]->order_no?></h2>
      <p>&nbsp;</p>
      <div class="alert alert-dismissible bf-form-bg cardshadow">
      <div class="table-responsive">
        <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Menu Name</th>
            <th>Unit Price</th>
            <th>Quantity</th>
            <th>Status</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
            <?php $index = 1; $totalprice = 0; foreach( $orderdetail as $row ) { ?> 
              <tr>
                  <td class='id-column'><?=$index++?></td>
                  <td><?=ucwords($row->menu_name)?></td>
                  <td><?=$row->price_per_unit?></td>
                  <td><?=$row->order_quantity?></td>

                <?php if ($row->order_status == '0') { ?>
                  <td><span class='label label-default'>In Progress</span></td>
                <?php } else if ($row->order_status == '1') { ?>
                  <td><span class='label label-warning'>In Delivery</span></td>
                <?php } else if ($row->order_status == '2') { ?>
                  <td><span class='label label-success'>Delivered</span></td>
                <?php } else if ($row->order_status == '3') { ?>
                  <td><span class='label label-danger'>Cancelled</span></td>
                <?php } ?>
                <?php $total = number_format(($row->order_quantity * $row->price_per_unit),2);
                $totalprice += $total; ?>
                <td><?=$total?></td>
              </tr>
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
              <a href="order_list.php?parent=order" class="btn btn-default">Back</a>
          </div>
        </div> 
        </div>        
      </div>
    </div>
  </div>
</div>
</form>
</body>
</html>
