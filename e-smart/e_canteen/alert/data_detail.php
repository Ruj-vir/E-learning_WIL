<?php

	$SesUserID = $_SESSION['UserID_OT'];
	
    $SQL = "SELECT EmpUserID,EmpUserName,EmpUserSurname,Authentication FROM ReqUser WHERE (EmpUserID = '$SesUserID')";
    $objSQL = sqlsrv_query($connRequest, $SQL);
	$resultSQL = sqlsrv_fetch_array($objSQL, SQLSRV_FETCH_ASSOC);
	
	if($resultSQL['EmpUserID'] != $SesUserID) {
		echo "<script type=text/javascript>window.location='../index.php';</script>";
		exit();
	}
	
	$QuotaSQL = "SELECT Qta_Qty,Qta_Value FROM Cnt_Quota WHERE (EmpID = '$SesUserID') ";
	$QuotaObjQuery = sqlsrv_query($connCanteen, $QuotaSQL);
	$QuotaObjResult = sqlsrv_fetch_array($QuotaObjQuery, SQLSRV_FETCH_ASSOC);

	$UserCanSql = "SELECT EmpUserID FROM Cnt_User WHERE (EmpUserID = '$SesUserID') AND (Status=1)";
	$UserCanQuery = sqlsrv_query($connCanteen, $UserCanSql);
	$UserCanResult = sqlsrv_fetch_array($UserCanQuery, SQLSRV_FETCH_ASSOC);

?>