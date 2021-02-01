<?php
include "alert/alert_session.php";
include "alert/alert_user.php";
include "../database/conn_sqlsrv.php";
//include "../database/conn_odbc.php";
//include "../../database/conn_mysql.php";
include "alert/data_detail.php";

//include "alert/alert_authority.php";

if(trim($inputAccess) == 1){
    $ListLoop = "SELECT DISTINCT 
    HRSystem.dbo.eEmployee.sEmpEngNamePrefix, 
    dbo.ReqUser.EmpUserID, 
    dbo.ReqUser.EmpUserName, 
    dbo.ReqUser.EmpUserSurname, 
    dbo.ReqUser.EmpUserPosition, 
    dbo.ReqUser.EmpUserSection, 
    dbo.ReqUser.EmpUserDepartment
    
    FROM HRSystem.dbo.eEmployee INNER JOIN
    dbo.ReqUser ON HRSystem.dbo.eEmployee.sEmpID = dbo.ReqUser.EmpUserID COLLATE SQL_Latin1_General_CP1_CI_AS INNER JOIN
    dbo.ReqInfo ON dbo.ReqUser.EmpUserID = dbo.ReqInfo.EmployeeID
    WHERE (dbo.ReqInfo.ReqType = 4) 
    AND (dbo.ReqInfo.ReqNo = '$ItemReqNo') 
    AND (dbo.ReqInfo.ReqIssuer = '$ReqIssuer')
    AND (dbo.ReqInfo.Status <> 0) ";
    
    } else if(trim($inputAccess) == 2){
      $ListLoop = "SELECT DISTINCT 
      HRSystem.dbo.eEmployee.sEmpEngNamePrefix,
      dbo.ReqUser.EmpUserID, 
      dbo.ReqUser.EmpUserName, 
      dbo.ReqUser.EmpUserSurname, 
      dbo.ReqUser.EmpUserPosition, 
      dbo.ReqUser.EmpUserSection, 
      dbo.ReqUser.EmpUserDepartment
      
        FROM HRSystem.dbo.eEmployee 
        INNER JOIN dbo.ReqUser ON HRSystem.dbo.eEmployee.sEmpID = dbo.ReqUser.EmpUserID COLLATE SQL_Latin1_General_CP1_CI_AS 
        INNER JOIN dbo.ReqInfo ON dbo.ReqUser.EmpUserID = dbo.ReqInfo.EmployeeID
    
        WHERE (dbo.ReqInfo.ReqType = 4) 
        AND (dbo.ReqInfo.ReqNo = '$ItemReqNo')
        AND (dbo.ReqInfo.ReqIssuer = '$ReqIssuer') 
        AND (dbo.ReqInfo.ReqChecker = '$SesUserID')
      AND (dbo.ReqInfo.Status <> 0) ";
      
    } else if(trim($inputAccess) == 3){
      $ListLoop = "SELECT DISTINCT 
      HRSystem.dbo.eEmployee.sEmpEngNamePrefix,
      dbo.ReqUser.EmpUserID, 
      dbo.ReqUser.EmpUserName, 
      dbo.ReqUser.EmpUserSurname, 
      dbo.ReqUser.EmpUserPosition, 
      dbo.ReqUser.EmpUserSection, 
      dbo.ReqUser.EmpUserDepartment
      
        FROM HRSystem.dbo.eEmployee 
        INNER JOIN dbo.ReqUser ON HRSystem.dbo.eEmployee.sEmpID = dbo.ReqUser.EmpUserID COLLATE SQL_Latin1_General_CP1_CI_AS 
        INNER JOIN dbo.ReqInfo ON dbo.ReqUser.EmpUserID = dbo.ReqInfo.EmployeeID
    
        WHERE (dbo.ReqInfo.ReqType = 4) 
        AND (dbo.ReqInfo.ReqNo = '$ItemReqNo')
        AND (dbo.ReqInfo.ReqIssuer = '$ReqIssuer') 
        AND (dbo.ReqInfo.ReqApprover = '$SesUserID')
      AND (dbo.ReqInfo.Status <> 0) ";
      
    } else if(trim($inputAccess) == 4){
      $ListLoop = "SELECT DISTINCT 
      HRSystem.dbo.eEmployee.sEmpEngNamePrefix,
      dbo.ReqUser.EmpUserID, 
      dbo.ReqUser.EmpUserName, 
      dbo.ReqUser.EmpUserSurname, 
      dbo.ReqUser.EmpUserPosition, 
      dbo.ReqUser.EmpUserSection, 
      dbo.ReqUser.EmpUserDepartment
      
        FROM HRSystem.dbo.eEmployee 
        INNER JOIN dbo.ReqUser ON HRSystem.dbo.eEmployee.sEmpID = dbo.ReqUser.EmpUserID COLLATE SQL_Latin1_General_CP1_CI_AS 
        INNER JOIN dbo.ReqInfo ON dbo.ReqUser.EmpUserID = dbo.ReqInfo.EmployeeID
    
        WHERE (dbo.ReqInfo.ReqType = 4) 
        AND (dbo.ReqInfo.ReqNo = '$ItemReqNo')
        AND (dbo.ReqInfo.ReqIssuer = '$ReqIssuer') 
        AND (dbo.ReqInfo.UpdateBy = '$SesUserID')
      AND (dbo.ReqInfo.Status <> 0) ";
      
    } else if(trim($inputAccess) == 5){
    
      if(in_array($AuthenReq, $Arr_Owner)){
      $ListLoop = "SELECT DISTINCT 
      HRSystem.dbo.eEmployee.sEmpEngNamePrefix, 
      dbo.ReqUser.EmpUserID, 
      dbo.ReqUser.EmpUserName, 
      dbo.ReqUser.EmpUserSurname, 
      dbo.ReqUser.EmpUserPosition, 
      dbo.ReqUser.EmpUserSection, 
      dbo.ReqUser.EmpUserDepartment
      
        FROM HRSystem.dbo.eEmployee 
        INNER JOIN dbo.ReqUser ON HRSystem.dbo.eEmployee.sEmpID = dbo.ReqUser.EmpUserID COLLATE SQL_Latin1_General_CP1_CI_AS 
        INNER JOIN dbo.ReqInfo ON dbo.ReqUser.EmpUserID = dbo.ReqInfo.EmployeeID
        
        WHERE (dbo.ReqInfo.ReqType = 4) 
        AND (dbo.ReqInfo.ReqNo = '$ItemReqNo') 
      AND (dbo.ReqInfo.Status <> 0) ";
      }
    
    }else {
      echo "<script>window.close();</script>";
      exit();
    }

    