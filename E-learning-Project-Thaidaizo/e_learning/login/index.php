
<?php
  include "alert/alert_session.php";
  
  if(isset($_SESSION['UserID@Learning']) && isset($_SESSION['Authorize@Learning']) && isset($_SESSION['Status@Learning'])) {
    header("location:register_user.php"); 
    exit();
  }else{
    header("location:login.php"); 
    exit();
  } 
?>
