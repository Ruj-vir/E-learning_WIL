<?php
    include "../alert/alert_session.php";
    include "../../database/conn_sqlsrv.php";
    //include "../database/conn_mysql.php";
    include "../alert/alert_user.php";
    include "../alert/data_detail.php";

  $Queryer = "SELECT TrnNo FROM Cnt_TrnDetail WHERE (TrnDate = '".$_POST["inputDate"]."') ORDER BY TrnNo DESC";
  $objQueryer = sqlsrv_query($connCanteen, $Queryer);
  $objResulty = sqlsrv_fetch_array($objQueryer, SQLSRV_FETCH_ASSOC);
  $timeConn = (trim($objResulty["TrnNo"] + 1));

if(isset($_POST["addlisttda"])){
  $Timeuse01 = $_POST["inputDate"]."T".$_POST["inputTime"].":00";

  $sql01 = "INSERT INTO Cnt_TrnDetail (TrnNo, TrnDate, TrnTime, EmpID, Qta_Qty, Qta_Value, Status, UserDefine1, MakeBy, CreatedBy, CreatedDate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE())";
  $params01 = array($timeConn, $_POST['inputDate'], $Timeuse01,  $_POST['inputID'], 1, 20, 1, $_POST['inputDetail'], 'Canteen TDA', $SesUserID);
  $stmt01 = sqlsrv_query($connCanteen, $sql01, $params01);
  if( $stmt01 === false ) {
    //die( print_r( sqlsrv_errors(), true));
    //die ("Error Query [".$sql01."]");
    echo "<script type=text/javascript>window.top.window.CanteenResult('0');</script>";
    exit();
  }else {
    echo "<script type=text/javascript>window.top.window.CanteenResult('1');</script>";
    exit();
  }



}if(isset($_POST["addlisttdp"])){
  $Timeuse02 = $_POST["inputDate"]."T".$_POST["inputTime"].":00";
  
  $sql02 = "INSERT INTO Cnt_TrnDetail (TrnNo, TrnDate, TrnTime, EmpID, Qta_Qty, Qta_Value, Status, UserDefine1, MakeBy, CreatedBy, CreatedDate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE())";
  $params02 = array($timeConn, $_POST['inputDate'], $Timeuse02,  $_POST["inputID"], 1, 20, 1, $_POST['inputDetail'], 'Canteen TDP', $SesUserID);
  $stmt02 = sqlsrv_query($connCanteen, $sql02, $params02);
  if( $stmt02 === false ) {
    //die( print_r( sqlsrv_errors(), true));
    echo "<script type=text/javascript>window.top.window.CanteenResult('0');</script>";
    exit();
  }else {
    echo "<script type=text/javascript>window.top.window.CanteenResult('1');</script>";
    exit();
  }
}

?>