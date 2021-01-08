<?php
  session_start();
  ini_set('display_errors', 0);
  error_reporting(~0);

  if($_SESSION['UserID_OT']){
	//include ('home.php');
  header("location:index/index.php");
  }

  else if(!$_SESSION['UserID_OT']){
	//include ('login.php');
	header("location:index/login.php");
  }
?>
