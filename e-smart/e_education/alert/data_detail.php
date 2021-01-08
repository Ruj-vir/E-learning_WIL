<?php
	
    $SQL = "SELECT EmpUserID,EmpUserName,EmpUserSurname,EmpUserEmail,LvApprove,EduVerify,EduApprove,Authentication FROM ReqUser WHERE EmpUserID = ? COLLATE Latin1_General_CS_AS";
	$ParamSQL = [$SesUserID];
	$objSQL = sqlsrv_query($connRequest, $SQL, $ParamSQL);
	$resultSQL = sqlsrv_fetch_array($objSQL, SQLSRV_FETCH_ASSOC);
	
	if(isset($resultSQL["EmpUserID"]) != $SesUserID) {
		echo "<script type=text/javascript>window.location='../index.php';</script>";
		exit();
	}

?>