<?php
    include "../alert/alert_session.php";
    include "../../database/conn_sqlsrv.php";
    //include "../database/conn_mysql.php";
    include "../alert/alert_user.php";
    include "../alert/data_detail.php";


    
  if(isset($_POST["AddUser"])){
    $strSQL = "INSERT INTO Cnt_Quota (EmpID,Qta_Date,Qta_Shift,Qta_Qty,Qta_Value,UserDefine1,CreateBy,CreateDate) 
    VALUES ('".$_POST["txtempID"]."', GETDATE(), 0, '".$_POST["txtQTY"]."', '".$_POST["txtQTY"]."' * 20, '".$_POST["txtDetail"]."', '$SesUserID', GETDATE())";
    $objQuery = sqlsrv_query($connCanteen, $strSQL);
    //or die ("Error Query [".$strSQL."]");
    if($objQuery){
      echo "<script type=text/javascript>window.top.window.CanteenResult('0');/script>";
      exit();
    }else {
      echo "<script type=text/javascript>window.top.window.CanteenResult('1');</script>";
      exit();
    }
  }else {
    echo "<script>window.close();</script>";
		exit();
  }


?>
