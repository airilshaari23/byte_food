<!DOCTYPE html>
<html lang="en">
<head>
  <title>ByteFood</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/default.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <?php 
  $_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  $segments = explode('/', rtrim($_SERVER['REQUEST_URI_PATH'], '/')); ?>
  
  <?php if (end($segments) == 'user_update.php') { ?>
    <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">
  <?php } ?>

  <?php if (end($segments) == 'menu_list.php') { ?>
  <script type="text/javascript">
    function ShowHideDiv(chkPassport,a) {
     // alert(a);
        var dvPassport = document.getElementById(a);
        dvPassport.style.display = chkPassport.checked ? "block" : "none";
    }
  </script>
  <?php } ?>

</head>
<body style="background-color:#DCDCDC;">

<nav class="navbar navbar-inverse" style="border-radius:0px">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
       <a  href="menu_list.php?parent=menu"><img src="ByteFood2.png"  class="" style="width: 100px;"/></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
    <?php if (end($segments) != 'user_registration.php') { ?>
    <ul class="nav navbar-nav">
      <li <?=$_GET['parent'] == 'menu' ? 'class="active"' : '' ?>><a href="menu_list.php?parent=menu">Menu</a></li>
      <li <?=$_GET['parent'] == 'order' ? 'class="active"' : '' ?>><a href="order_list.php?parent=order">Order History</a></li>
      <li <?=$_GET['parent'] == 'profile' ? 'class="active dropdown"' : 'class="dropdown"' ?>><a class="dropdown-toggle" data-toggle="dropdown" href="user_profile.php?parent=profile">Profile<span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="user_profile.php?parent=profile">Profile</a></li>
          <li><a href="user_changepassword.php?parent=profile">Change Password</a></li>
        </ul>
      </li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>Log Out</a></li>
    </ul>
    <?php } ?>
    </div>
  </div>
</nav>