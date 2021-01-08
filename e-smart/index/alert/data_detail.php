<?php

    $objSql = "SELECT EmpUserID,EmpUserName,EmpUserSurname,EmpUserEmail,EmpUserPosition,EmpUserSection,EmpUserDepartment FROM ReqUser WHERE (EmpUserID = '$SesUserID')";
    $objQuery = sqlsrv_query($connRequest, $objSql);
	$objResult = sqlsrv_fetch_array($objQuery, SQLSRV_FETCH_ASSOC);
	
	if($objResult['EmpUserID'] != $SesUserID) {
		//echo "<script type=text/javascript>window.location='index.php';</script>";
		header("location:index.php"); 
		exit();
	}
	
    $OfficeSql = "SELECT Emp.sEmpID, Emp.sEmpFirstName, Emp.sEmpLastName, Emp.sEmpEngFirstName, Emp.sEmpEngLastName, 
	Posi.sEngName AS Position, Dept.sEngName AS Department, Sec.sEngName AS Section
	FROM dbo.eEmployee AS Emp INNER JOIN
	dbo.View_Department AS Dept ON Emp.sEmpOrgLevel2 = Dept.sCode2 INNER JOIN
	dbo.cPosition AS Posi ON Emp.sEmpPosTitle = Posi.sCode INNER JOIN
	dbo.cOrgLevel AS Sec ON Emp.sEmpOrgLevel3 = Sec.sCode3
	WHERE (Emp.sEmpID = '$SesUserID') ";
    $OfficeQuery = sqlsrv_query($connHR, $OfficeSql);
	$OfficeResult = sqlsrv_fetch_array($OfficeQuery, SQLSRV_FETCH_ASSOC);


?>