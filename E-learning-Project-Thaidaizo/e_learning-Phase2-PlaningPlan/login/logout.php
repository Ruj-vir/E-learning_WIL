<?php
    include "alert/alert_session.php";
    include "alert/alert_user.php";

	//session_start();
	unset($_SESSION['UserID@Learning']);
	unset($_SESSION['Status@Learning']);
	unset($_SESSION['Authorize@Learning']);
	//session_unregister('UserID');
	//session_destroy();
	header("location:index.php");
?>
