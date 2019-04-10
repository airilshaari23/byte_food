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

    $orderhistory = $db->order_listing($member->username);
?>
<?php include 'head.php';?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2>Order History</h2>
      <p>&nbsp;</p>
      <div class="alert alert-dismissible bf-form-bg cardshadow">
      <div class="table-responsive">
        <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Order Number</th>
            <th>Status</th>
            <th>Order Duration</th>
            <th>Total Price</th>
            <th>Operation</th>
          </tr>
        </thead>
        <tbody>
            <?php 
              $index = 0;
              foreach( $orderhistory as $row )
            { 
              $index++;
              $order_no = $row->order_no;
              $order_status = $row->order_status;
              $foodprice = $row->foodprice;
              $order_date = $row->order_date; 

              echo "<tr>";
                echo "  <td class='id-column'>$index</td>";
                echo "  <td><a href='order_detail.php?parent=order&orderno=$order_no'>$order_no</a></td>";
                
                if ($order_status == '0'){
                  $str_status = "  <span class='label label-default'>In Progress</span>";
                }
                else if ($order_status == '1'){
                  $str_status = "  <span class='label label-warning'>In Delivery</span>";
                }
                else if ($order_status == '2'){
                  $str_status = "  <span class='label label-success'>Delivered</span>";
                }
                else if ($order_status == '3'){
                  $str_status = "  <span class='label label-danger'>Cancelled</span>";
                }
                echo "  <td>$str_status</td>";

                $str_addeddate = "<span class='label label-default'>$order_date</span>";
                echo "  <td>$str_addeddate</td>";
                echo "  <td>$foodprice</td>";
                
                
                echo "   <td>";
                if ($order_status == '0') {
                  echo "     <a href='order_cancel_ctrl.php?orderno=$order_no&cancel=3'>";
                  echo "       <span class='label label-danger'>Cancel</span>";
                  echo "     </a>&nbsp;";
                }
                echo "   </td>";
              echo "</tr>";
            }
            ?>        
        </tbody>
        </table>
        </div>    
      </div>
    </div>
  </div>
</div>
</body>
</html>
