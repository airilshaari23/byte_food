<?php
    include_once("database_ctrl.php");
    session_start();
    $member = $_SESSION['member'];
    if (!isset($_SESSION['error']))
      $_SESSION['error'] = NULL;
?>
<?php include 'head.php';?>

<div class="container">
  <!-- Example row of columns -->
  <div class="row">
    <div class="col-md-6">
      <h2>Change Password Form</h2>
      <div class="alert alert-dismissible bf-form-bg cardshadow">
        <form class="form-horizontal" method="post" action="user_changepassword_ctrl.php">
            <?php if ($_SESSION['error']) { ?>
            <div class="alert alert-dismissible alert-warning cardshadow">
              Error: <?php echo $_SESSION['error']?>
            </div>
            <?php } ?>
            <div class="form-group">
              <label for="password" class="col-lg-2 control-label">New Password</label>
              <div class="col-lg-10">
                <input type="password" class="form-control" id="password" name="password" placeholder="New Password" required>
              </div>
            </div>
            <div class="form-group">
              <label for="c_password" class="col-lg-2 control-label">Confirm Password</label>
              <div class="col-lg-10">
                <input type="password" class="form-control" id="c_password" name="c_password" placeholder="Confirm Password" required>
              </div>
            </div>                                                                  
            <div class="form-group">
              <div class="col-lg-10 col-lg-offset-2">
                <a href="user_profile.php?parent=profile" class="btn btn-default">Cancel</a>
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div> 
<?php unset($_SESSION['error']); ?>
</body>
</html>
