<?php 
  session_start(); 
?>
<?php include 'head.php';?>

<div class="container">
  <!-- Example row of columns -->
  <div class="row">
    <div class="col-md-6">
      <h2>DB error message</h2>

      <div class="alert alert-dismissible alert-warning cardshadow">
      <?php if ($_SESSION['error']) {
        echo 'Error: There is an database error. Please check your data.';
      } ?>
      </div>
    </div>
  </div>
</div> 

</body>
</html>