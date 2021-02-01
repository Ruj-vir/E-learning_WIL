<?php
include "../alert/alert_session.php";
include "../../database/conn_sqlsrv.php";
//include "../database/conn_odbc.php";
//include "../../database/conn_mysql.php";
include "../alert/alert_user.php";
include "../alert/data_detail.php";



if ((trim($_POST["txtChange"]) != NULL) && (trim($_POST["txtEmpCurrent"]) != NULL)) {

  $EmpCurrent = trim($_POST["txtEmpCurrent"]);
  $EmpChange = trim($_POST["txtChange"]);

  if (trim($_POST["txtAccess"]) == 2) {
    $ChangeSQL = "UPDATE ReqUser SET 
        Authentication = 3 ,
        UpdateBy = '$SesUserID' ,
        UpdateDate = GETDATE() 
        WHERE EmpUserID = '$EmpChange' ";
    $ChangeSTMT = sqlsrv_query($connRequest, $ChangeSQL);

    if ($ChangeSTMT) {
      $ChangeApproveSQL = "SELECT EmpUserID FROM ReqUser WHERE (LvApprove = '$EmpCurrent') ";
      $ChangeApproveQuery = sqlsrv_query($connRequest, $ChangeApproveSQL);
      while ($ChangeApproveResult = sqlsrv_fetch_array($ChangeApproveQuery, SQLSRV_FETCH_ASSOC)) {

        $ChangeApproveUpdateSQL = "UPDATE ReqUser SET 
		  LvApprove = ?,
		  Authentication = ?,
		  UpdateBy = ?,
		  UpdateDate = GETDATE()
		  WHERE EmpUserID = ? ";
        $ChangeApproveUpdateParams = array($EmpChange, 3, $SesUserID, $ChangeApproveResult["EmpUserID"]);
        $ChangeApproveUpdateStmt = sqlsrv_query($connRequest, $ChangeApproveUpdateSQL, $ChangeApproveUpdateParams);
      }
      if ($ChangeApproveUpdateStmt === false) {
        echo "<script>window.top.window.ResultUpdateRelated('0');</script>";
        exit();
      } else {
        echo "<script>window.top.window.ResultUpdateRelated('1');</script>";
        exit();
      }
    } else {
      echo "<script>window.top.window.ResultUpdateRelated('0');</script>";
      exit();
    }
  }

  if (trim($_POST["txtAccess"]) == 3) {
    $ChangeSQL = "UPDATE ReqUser SET 
        Authentication = 9 ,
        UpdateBy = '$SesUserID' ,
        UpdateDate = GETDATE() 
        WHERE EmpUserID = '$EmpChange' ";
    $ChangeSTMT = sqlsrv_query($connRequest, $ChangeSQL);

    if ($ChangeSTMT) {
      $ChangeCheckSQL = "SELECT EmpUserID FROM ReqUser WHERE (EduVerify = '$EmpCurrent') ";
      $ChangeCheckQuery = sqlsrv_query($connRequest, $ChangeCheckSQL);
      while ($ChangeCheckResult = sqlsrv_fetch_array($ChangeCheckQuery, SQLSRV_FETCH_ASSOC)) {

        $ChangeCheckUpdateSQL = "UPDATE ReqUser SET 
          EduVerify = ?,
          Authentication = ?,
          UpdateBy = ?,
          UpdateDate = GETDATE()
          WHERE EmpUserID = ? ";
        $ChangeCheckUpdateParams = array($EmpChange, 9, $SesUserID, $ChangeCheckResult["EmpUserID"]);
        $ChangeCheckUpdateStmt = sqlsrv_query($connRequest, $ChangeCheckUpdateSQL, $ChangeCheckUpdateParams);
      }
      if ($ChangeCheckUpdateStmt === false) {
        echo "<script>window.top.window.ResultUpdateRelated('0');</script>";
        exit();
      } else {
        echo "<script>window.top.window.ResultUpdateRelated('1');</script>";
        exit();
      }
    } else {
      echo "<script>window.top.window.ResultUpdateRelated('0');</script>";
      exit();
    }
  }

  if (trim($_POST["txtAccess"]) == 4) {
    $ChangeSQL = "UPDATE ReqUser SET 
        Authentication = 9 ,
        UpdateBy = '$SesUserID' ,
        UpdateDate = GETDATE() 
        WHERE EmpUserID = '$EmpChange' ";
    $ChangeSTMT = sqlsrv_query($connRequest, $ChangeSQL);

    if ($ChangeSTMT) {
      $ChangeCheckSQL = "SELECT EmpUserID FROM ReqUser WHERE (EduApprove = '$EmpCurrent') ";
      $ChangeCheckQuery = sqlsrv_query($connRequest, $ChangeCheckSQL);
      while ($ChangeCheckResult = sqlsrv_fetch_array($ChangeCheckQuery, SQLSRV_FETCH_ASSOC)) {

        $ChangeCheckUpdateSQL = "UPDATE ReqUser SET 
          EduApprove = ?,
          Authentication = ?,
          UpdateBy = ?,
          UpdateDate = GETDATE()
          WHERE EmpUserID = ? ";
        $ChangeCheckUpdateParams = array($EmpChange, 9, $SesUserID, $ChangeCheckResult["EmpUserID"]);
        $ChangeCheckUpdateStmt = sqlsrv_query($connRequest, $ChangeCheckUpdateSQL, $ChangeCheckUpdateParams);
      }
      if ($ChangeCheckUpdateStmt === false) {
        echo "<script>window.top.window.ResultUpdateRelated('0');</script>";
        exit();
      } else {
        echo "<script>window.top.window.ResultUpdateRelated('1');</script>";
        exit();
      }
    } else {
      echo "<script>window.top.window.ResultUpdateRelated('0');</script>";
      exit();
    }
  }


} else {
  echo "<script>window.close();</script>";
  exit();
}
