<?php
    include "../alert/alert_session.php";
    include "../../database/conn_sqlsrv.php";
    //include "../database/conn_mysql.php";
    include "../alert/alert_user.php";
    include "../alert/data_detail.php";


    $PlantempID = $_POST["PlantempID"];
    $Plant = $_POST["Plant"];

if(isset($_POST["ChangePlanUser"])) {
	$QuotaSigSql = "UPDATE VREmpBus SET
				Plant = ? ,
				UpdateDate = GETDATE() ,
				UpdateBy = ?
				WHERE EmpCode = ? ";
	$QuotaSigParam = array($Plant, $SesUserID, $PlantempID);
	$QuotaSigStmt = sqlsrv_query($connCarBooking, $QuotaSigSql, $QuotaSigParam);
	if($QuotaSigStmt === false) {
		echo "<script type=text/javascript>window.top.window.CanteenResult('0');</script>";
		exit();
	}else{
		echo "<script type=text/javascript>window.top.window.CanteenResult('1');</script>";
		exit();
	}
}else {
    echo "<script>window.close();</script>";
	exit();
}



?>