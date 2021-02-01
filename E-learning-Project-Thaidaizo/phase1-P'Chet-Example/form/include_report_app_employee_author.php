
<?php
include "alert/alert_session.php";
include "alert/alert_user.php";
include "../database/conn_sqlsrv.php";
//include "../database/conn_odbc.php";
//include "../../database/conn_mysql.php";
include "alert/data_detail.php";

//include "alert/alert_authority.php";

if ((isset($_GET["ItemReqNo"]) && trim($_GET["ItemReqNo"]) != NULL) &&
(isset($_GET["AccessNo"]) && trim($_GET["AccessNo"]) != NULL)) {

  $strItemReqNo = trim($_GET["ItemReqNo"]);
  //$FineDataEmp = addslashes($str);
  $vowelsItemReqNo = array("'");
  $ItemReqNo = str_replace($vowelsItemReqNo, '', $strItemReqNo);

  $strinputAccess = $_GET["AccessNo"]; 
  $vowelsinputAccess = array("'");
  $inputAccess = str_replace($vowelsinputAccess, '', $strinputAccess);

  $Arr_AccessNo = array("1","2","3","4","5");
  if(!in_array($inputAccess, $Arr_AccessNo)){
    echo "<script>window.close();</script>";
    exit();
  }

} else {
  echo "<script>window.close();</script>";
  exit();
}

$AuthenReq = $resultSQL['Authentication'];
$Arr_Owner = array("6","9");

if(trim($inputAccess) == 1){

  $ListSql = "SELECT DISTINCT TOP (1) 
  dbo.ReqInfo.ReqIssuer, 
  dbo.ReqInfo.ReqIssueDate, 
  dbo.ReqInfo.ReqDate, 
  dbo.ReqInfo.TrnTime, 
  dbo.ReqInfo.ReqRemark, 
  dbo.ReqInfo.UserDefine1,

  dbo.ReqInfo.ReqChecker,
  dbo.ReqInfo.ReqCheckDate,
  dbo.ReqInfo.ReqApprover,
  dbo.ReqInfo.ReqApproveDate,
  dbo.ReqInfo.UpdateBy,
  dbo.ReqInfo.UpdateDate,
  
  HRSystem.dbo.eEmployee.sEmpEngNamePrefix, 
  dbo.ReqUser.EmpUserName, 
  dbo.ReqUser.EmpUserSurname, 
  dbo.ReqUser.EmpUserPosition, 
  dbo.ReqUser.EmpUserSection, 
  dbo.ReqUser.EmpUserDepartment
  
  FROM dbo.ReqInfo 
  INNER JOIN dbo.ReqUser ON dbo.ReqInfo.ReqIssuer = dbo.ReqUser.EmpUserID
  INNER JOIN HRSystem.dbo.eEmployee ON dbo.ReqUser.EmpUserID COLLATE SQL_Latin1_General_CP1_CI_AS = HRSystem.dbo.eEmployee.sEmpID
  WHERE (dbo.ReqInfo.ReqType = 4) 
  AND (dbo.ReqInfo.ReqNo = '$ItemReqNo')
  AND (dbo.ReqInfo.ReqIssuer = '$SesUserID')
  AND (dbo.ReqInfo.Status <> 0) ";

} else if(trim($inputAccess) == 2){

  $ListSql = "SELECT DISTINCT TOP (1) 
  dbo.ReqInfo.ReqIssuer, 
  dbo.ReqInfo.ReqIssueDate, 
  dbo.ReqInfo.ReqDate, 
  dbo.ReqInfo.TrnTime, 
  dbo.ReqInfo.ReqRemark, 
  dbo.ReqInfo.UserDefine1,

  dbo.ReqInfo.ReqChecker,
  dbo.ReqInfo.ReqCheckDate,
  dbo.ReqInfo.ReqApprover,
  dbo.ReqInfo.ReqApproveDate,
  dbo.ReqInfo.UpdateBy,
  dbo.ReqInfo.UpdateDate,
  
  HRSystem.dbo.eEmployee.sEmpEngNamePrefix,
  dbo.ReqUser.EmpUserName, 
  dbo.ReqUser.EmpUserSurname, 
  dbo.ReqUser.EmpUserPosition, 
  dbo.ReqUser.EmpUserSection, 
  dbo.ReqUser.EmpUserDepartment
  
  FROM dbo.ReqInfo 
  INNER JOIN dbo.ReqUser ON dbo.ReqInfo.ReqIssuer = dbo.ReqUser.EmpUserID
  INNER JOIN HRSystem.dbo.eEmployee ON dbo.ReqUser.EmpUserID COLLATE SQL_Latin1_General_CP1_CI_AS = HRSystem.dbo.eEmployee.sEmpID
  WHERE (dbo.ReqInfo.ReqType = 4) 
  AND (dbo.ReqInfo.ReqNo = '$ItemReqNo')
  AND (dbo.ReqInfo.ReqChecker = '$SesUserID')
  AND (dbo.ReqInfo.Status <> 0) ";

} else if(trim($inputAccess) == 3){

  $ListSql = "SELECT DISTINCT TOP (1) 
  dbo.ReqInfo.ReqIssuer, 
  dbo.ReqInfo.ReqIssueDate, 
  dbo.ReqInfo.ReqDate, 
  dbo.ReqInfo.TrnTime, 
  dbo.ReqInfo.ReqRemark, 
  dbo.ReqInfo.UserDefine1,

  dbo.ReqInfo.ReqChecker,
  dbo.ReqInfo.ReqCheckDate,
  dbo.ReqInfo.ReqApprover,
  dbo.ReqInfo.ReqApproveDate,
  dbo.ReqInfo.UpdateBy,
  dbo.ReqInfo.UpdateDate,
  
  HRSystem.dbo.eEmployee.sEmpEngNamePrefix,
  dbo.ReqUser.EmpUserName, 
  dbo.ReqUser.EmpUserSurname, 
  dbo.ReqUser.EmpUserPosition, 
  dbo.ReqUser.EmpUserSection, 
  dbo.ReqUser.EmpUserDepartment
  
  FROM dbo.ReqInfo 
  INNER JOIN dbo.ReqUser ON dbo.ReqInfo.ReqIssuer = dbo.ReqUser.EmpUserID
  INNER JOIN HRSystem.dbo.eEmployee ON dbo.ReqUser.EmpUserID COLLATE SQL_Latin1_General_CP1_CI_AS = HRSystem.dbo.eEmployee.sEmpID
  WHERE (dbo.ReqInfo.ReqType = 4) 
  AND (dbo.ReqInfo.ReqNo = '$ItemReqNo')
  AND (dbo.ReqInfo.ReqApprover = '$SesUserID')
  AND (dbo.ReqInfo.Status <> 0) ";

} else if(trim($inputAccess) == 4){

  $ListSql = "SELECT DISTINCT TOP (1) 
  dbo.ReqInfo.ReqIssuer, 
  dbo.ReqInfo.ReqIssueDate, 
  dbo.ReqInfo.ReqDate, 
  dbo.ReqInfo.TrnTime, 
  dbo.ReqInfo.ReqRemark, 
  dbo.ReqInfo.UserDefine1,

  dbo.ReqInfo.ReqChecker,
  dbo.ReqInfo.ReqCheckDate,
  dbo.ReqInfo.ReqApprover,
  dbo.ReqInfo.ReqApproveDate,
  dbo.ReqInfo.UpdateBy,
  dbo.ReqInfo.UpdateDate,
  
  HRSystem.dbo.eEmployee.sEmpEngNamePrefix,
  dbo.ReqUser.EmpUserName, 
  dbo.ReqUser.EmpUserSurname, 
  dbo.ReqUser.EmpUserPosition, 
  dbo.ReqUser.EmpUserSection, 
  dbo.ReqUser.EmpUserDepartment
  
  FROM dbo.ReqInfo 
  INNER JOIN dbo.ReqUser ON dbo.ReqInfo.ReqIssuer = dbo.ReqUser.EmpUserID
  INNER JOIN HRSystem.dbo.eEmployee ON dbo.ReqUser.EmpUserID COLLATE SQL_Latin1_General_CP1_CI_AS = HRSystem.dbo.eEmployee.sEmpID
  WHERE (dbo.ReqInfo.ReqType = 4) 
  AND (dbo.ReqInfo.ReqNo = '$ItemReqNo')
  AND (dbo.ReqInfo.UpdateBy = '$SesUserID')
  AND (dbo.ReqInfo.Status <> 0) ";

}else if(trim($inputAccess) == 5){
    if(in_array($AuthenReq, $Arr_Owner)){

      $ListSql = "SELECT DISTINCT TOP (1) 
      dbo.ReqInfo.ReqIssuer, 
      dbo.ReqInfo.ReqIssueDate, 
      dbo.ReqInfo.ReqDate, 
      dbo.ReqInfo.TrnTime, 
      dbo.ReqInfo.ReqRemark, 
      dbo.ReqInfo.UserDefine1,
    
      dbo.ReqInfo.ReqChecker,
      dbo.ReqInfo.ReqCheckDate,
      dbo.ReqInfo.ReqApprover,
      dbo.ReqInfo.ReqApproveDate,
      dbo.ReqInfo.UpdateBy,
      dbo.ReqInfo.UpdateDate,
      
      HRSystem.dbo.eEmployee.sEmpEngNamePrefix,
      dbo.ReqUser.EmpUserName, 
      dbo.ReqUser.EmpUserSurname, 
      dbo.ReqUser.EmpUserPosition, 
      dbo.ReqUser.EmpUserSection, 
      dbo.ReqUser.EmpUserDepartment
      
      FROM dbo.ReqInfo 
      INNER JOIN dbo.ReqUser ON dbo.ReqInfo.ReqIssuer = dbo.ReqUser.EmpUserID
      INNER JOIN HRSystem.dbo.eEmployee ON dbo.ReqUser.EmpUserID COLLATE SQL_Latin1_General_CP1_CI_AS = HRSystem.dbo.eEmployee.sEmpID
      WHERE (dbo.ReqInfo.ReqType = 4) 
      AND (dbo.ReqInfo.ReqNo = '$ItemReqNo')
      AND (dbo.ReqInfo.Status <> 0) ";

    }else {
      echo "<script>window.close();</script>";
      exit();
    }
}else {
  echo "<script>window.close();</script>";
  exit();
}

$ListIParams = array();
$ListIOptions =  array("Scrollable" => SQLSRV_CURSOR_KEYSET);
$ListIStmt = sqlsrv_query($connRequest, $ListSql, $ListIParams, $ListIOptions);
$ListIRow = sqlsrv_num_rows($ListIStmt);

if ($ListIRow > 0) {

  $ListObj = sqlsrv_query($connRequest, $ListSql);
  $ListResult = sqlsrv_fetch_array($ListObj, SQLSRV_FETCH_ASSOC);
  $EleData = explode('|', $ListResult["UserDefine1"]);

} else {
  echo "<script>window.close();</script>";
  exit();
}