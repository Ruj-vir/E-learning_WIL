<?php

	$strSQL = "SELECT EmpUserID,EmpUserName,UserDefine1,Status FROM Cnt_User WHERE (EmpUserID = '$SesUserID') ";
	$objQuery = sqlsrv_query($connCanteen, $strSQL);
	$objResult = sqlsrv_fetch_array($objQuery, SQLSRV_FETCH_ASSOC);

	if($SesUserID != $objResult["EmpUserID"]){
		echo "<script type=text/javascript>window.location='../index.php';</script>";
		exit();
	}

	if(($objResult['UserDefine1'] == "1") || ($resultSQL['Authentication'] == "9")){
    
  	}else{
		echo "<script type=text/javascript>alert('Only the administrator!');window.location='../index.php';</script>";
		exit();
	}
	if(trim($objResult['Status']) != "1"){
		echo "<script type=text/javascript>alert('Status disabled!');window.location='../index.php';</script>";
		exit();
  	}	
  
?>


