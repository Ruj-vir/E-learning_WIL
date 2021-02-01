<?php
  session_start();
  ini_set('display_errors', 0);
  error_reporting(~0);

  if($_SESSION['UserID_OT']){
	include ('home.php');
  }else{
	include ('login.php');
  }
?>
