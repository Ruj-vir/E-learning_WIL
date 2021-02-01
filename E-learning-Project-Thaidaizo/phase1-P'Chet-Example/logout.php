<?php
    include "alert/alert_session.php";
    include "../database/conn_sqlsrv.php";
    //include "../database/conn_odbc.php";
    //include "../database/conn_mysql.php";
    include "alert/alert_user.php";
	include "alert/data_detail.php";
	
	unset($_SESSION['UserID_OT']);
	unset($_SESSION['Status_OT']);
	unset($_SESSION['Authorize_OT']);
	//session_unregister('UserID');
	//session_destroy();
	header("location:index.php");
?>
