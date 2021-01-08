<?php
	if(isset($_SESSION['UserID_OT']) == NULL){
		echo "<script type=text/javascript>window.location='../index.php';</script>";
		exit();
	}
	if(isset($_SESSION['Status_OT']) != "1"){
		echo "<script type=text/javascript>window.location='../index.php';</script>";
		exit();
	}
	if(!$_SESSION['Authorize_OT']){
		echo "<script type=text/javascript>window.location='../index.php';</script>";
		exit();
	}
?>
