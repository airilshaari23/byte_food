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

?>
<?php include 'head.php';?>

<form class="form-horizontal" method="post" action="menu_checkout.php?parent=menu">
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2>Menu List</h2>
      <p>&nbsp;</p>
      <div class="alert alert-dismissible bf-form-bg cardshadow">
        <h3>Food List</h3>
        <table class="table table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Menu Name</th>
            <th>Menu Price</th>
            <th>Quantity</th>
          </tr>
        </thead>
        <tbody>
            <?php $index = 0; $category = ''; foreach( $menufood as $mf ) { ?> 
              <?php if ($mf->menu_category != $category) { ?>
                <?php $category = $mf->menu_category; ?>
                <tr>
                  <td colspan='6' class='cat'><?=strtoupper($category)?> FOOD</td>
                </tr>
              <?php } ?>
                <tr>
                  <td class='id-column'><input type='checkbox' name='menu[<?=$mf->menu_name?>]' value='<?=$mf->menu_name?>' onclick='ShowHideDiv(this,<?=$mf->id?>)'></td>
                  <td><?=ucwords($mf->menu_name)?></td>
                  <td><?=$mf->menu_price?></td>
                  <td><div id='<?=$mf->id?>' style='display: none'><input type='text' class='form-control' id='quantity' name='quantity[<?=$mf->menu_name?>]' size='2'></div></td>
                </tr>
            <?php } ?>        
        </tbody>
        </table>    
      </div>
      <div class="alert alert-dismissible bf-form-bg cardshadow">
        <h3>Drink List</h3>
        <table class="table table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Menu Name</th>
            <th>Menu Price</th>
            <th>Quantity</th>
          </tr>
        </thead>
        <tbody>
            <?php $index = 0; $category = ''; foreach( $menudrink as $md ) { ?>
              <?php if ($md->menu_category != $category) { ?>
                <?php $category = $md->menu_category; ?>
                <tr>
                  <td colspan='6' class='cat'><?=strtoupper($category)?> DRINK</td>
                </tr>
              <?php } ?>   
                <tr>
                  <td class='id-column'><input type='checkbox' name='menu[<?=$md->menu_name?>]' value='<?=$md->menu_name?>' onclick='ShowHideDiv(this,<?=$md->id?>)'></td>
                  <td><?=ucwords($md->menu_name)?></td>
                  <td><?=$md->menu_price?></td>
                  <td><div id='<?=$md->id?>' style='display: none'><input type='text' class='form-control' id='quantity' name='quantity[<?=$md->menu_name?>]' size='2'></div></td>
                </tr>
            <?php } ?>        
        </tbody>
        </table>     
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="col-lg-10 col-lg-offset-2">
      <button type="submit" class="btn btn-primary">Check Out</button>
    </div>
  </div>
</div>
</form>
</body>
</html>
