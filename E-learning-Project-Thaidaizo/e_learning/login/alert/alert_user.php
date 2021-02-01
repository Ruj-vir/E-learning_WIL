<?php
	$SesUserID = $_SESSION['UserID@Learning'];
	$SesState = $_SESSION['Status@Learning'];
	$SesAuthor = $_SESSION['Authorize@Learning'];

	if(isset($SesUserID) == NULL){
		echo "<script type=text/javascript>window.location='index.php';</script>";
		exit();
	}
	if(isset($SesState) != "1"){
		echo "<script type=text/javascript>window.location='index.php';</script>";
		exit();
	}
	if(!$SesAuthor){
		echo "<script type=text/javascript>window.location='index.php';</script>";
		exit();
	}
?>
