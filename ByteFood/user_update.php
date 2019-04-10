<?php  
    include("database.php");
    
    $member = $_SESSION['member'];

    $db = getDatabase();

    $profile = $db->getProfileInfo($member->username);
?>
<?php include 'head.php';?>

<div class="container">
  <!-- Example row of columns -->
  <div class="row">
    <div class="col-md-12">
      <h2>Edit Profile</h2>
      <div class="alert alert-dismissible bf-form-bg cardshadow">
        <form class="form-horizontal" enctype="multipart/form-data" method="post" action="user_update_ctrl.php">
        <div class="col-md-6">
            <div class="form-group">
              <label for="name" class="col-lg-2 control-label">Name</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" id="name" name="name" value="<?=isset($profile->name) ? $profile->name : ''?>" reqiured>
              </div>
            </div>
            <div class="form-group">
              <label for="username" class="col-lg-2 control-label">Username</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" id="username" name="username" value="<?=isset($profile->username) ? $profile->username : ''?>" readonly>
              </div>
            </div>
            <div class="form-group">
              <label for="age" class="col-lg-2 control-label">Age</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" id="age" name="age" value="<?=isset($profile->age) ? $profile->age : ''?>" required>
              </div>
            </div> 
            <div class="form-group">
              <label for="email" class="col-lg-2 control-label">Email</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" id="email" name="email" value="<?=isset($profile->email) ? $profile->email : ''?>" required>
              </div>
            </div>
            <div class="form-group">
              <label for="address" class="col-lg-2 control-label">Address</label>
              <div class="col-lg-10">
                <textarea type="text" class="form-control" id="address" name="address" style="height:200px" required><?=isset($profile->address) ? $profile->address : ''?></textarea>
              </div>
            </div>
            <div class="form-group">
              <label for="dob" class="col-lg-2 control-label">DOB</label>
              <div class="col-lg-10">
                <div class='input-group date' id='datetimepicker1'>
                    <input type='text' class="form-control" name="dob" id="dob" value="<?=isset($profile->dob) ? $profile->dob : ''?>" required/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
              </div>
            </div>
            </div>
            <div class="col-md-6">
            <div class="form-group">
              <label for="photo" class="col-lg-2 control-label">Photo</label>
              <div class="col-lg-10">
                <div class="alert alert-dismissible alert-default cardshadow">
                  <img src="member_img/<?php echo $profile->photo?>" width="300"/>
                </div>  
              </div>
            </div>
            <div class="form-group">
              <label for="matriks" class="col-lg-2 control-label">Please Choose Image</label>
              <div class="col-lg-10">
                <input name="uploaded" type="file"/>
              </div>
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
      <script src="js/vendor/jquery-1.11.2.min.js"></script>
      <script src="js/moment.min.js"></script>
      <script src="js/bootstrap-datetimepicker.min.js"></script>    
      <script src="js/app.js"></script>   
</body>
</html>
