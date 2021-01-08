
<?php

    //include "../alert/alert_session.php";
    include "../../database/conn_sqlsrv.php";
    //include "../database/conn_mysql.php";
    //include "../alert/alert_user.php";
	//include "../alert/data_detail.php";

	$inputRFID = trim($_POST["txtRFID"]);
	$InfoSql = "SELECT 
	CONVERT(varchar(10), GETDATE(), 111) AS DateCurrnt, 
	CONVERT(varchar(10), GETDATE(), 108) AS TimeCurrnt, 
	dbo.RFID_Master.EmpID, 
	dbo.RFID_Master.Status, 
	dbo.Cnt_Quota.Qta_Qty, 
	dbo.Cnt_Quota.Qta_Value, 
	dbo.Cnt_Quota.UserDefine1
	FROM dbo.RFID_Master 
	INNER JOIN dbo.Cnt_Quota 
	ON dbo.RFID_Master.EmpID = dbo.Cnt_Quota.EmpID
	WHERE (dbo.RFID_Master.RFIDNo = '$inputRFID') AND (dbo.RFID_Master.Status = 1) ";
	$InfoQuery = sqlsrv_query($connCanteen, $InfoSql);
	$InfoResult = sqlsrv_fetch_array($InfoQuery, SQLSRV_FETCH_ASSOC);
	
	$DateCurrnt = $InfoResult['DateCurrnt'];
	$TimeCurrnt = $InfoResult['TimeCurrnt'];
	$inputEmpID = $InfoResult['EmpID'];
	$Plant = $_POST["plant"];
	$Status = $InfoResult["Status"];
	$QtaValue = $InfoResult["Qta_Value"];
	
	$DateStart = str_replace('/', '-', $DateCurrnt);
	$TimeStart = substr($TimeCurrnt, 0 ,5);
  	$DayName = date('l', strtotime($DateStart));
	
	$Queryer = "SELECT TOP (1) TrnNo,TrnDate 
	FROM Cnt_TrnDetail 
	ORDER BY TrnNo DESC, TrnTime DESC";
	$objQueryer = sqlsrv_query($connCanteen, $Queryer);
	$objResulty = sqlsrv_fetch_array($objQueryer,SQLSRV_FETCH_ASSOC);
	if(date_format($objResulty["TrnDate"], 'Y-m-d') == $DateStart) {
		$timeConn = (trim($objResulty["TrnNo"] + 1));
	}else {
		$time = str_replace('-', '', $DateStart);
		$timeConn = (trim($time.'0001'));
	}


if(strlen($inputEmpID) == 5){
  if (($TimeStart >= '09:00') && ($TimeStart <= '14:00')) {
    if (($DayName == 'Saturday') && ($InfoResult["Qta_Qty"] <= 1)) {
        include ('save_picking_tv.php');
    }else {
      $mystring = $InfoResult["UserDefine1"];
      $pos = strrpos($mystring, "OT Request");
      if (is_bool($pos)) {
        include ('save_picking_tv.php');
      }else {
        if (($InfoResult["Qta_Qty"]) > 1) {
          include ('save_picking_tv.php');
        }else {
          echo "<script>window.top.window.showResult('4');</script>";
        	exit();
        }
      }
    }
  }else if (($TimeStart >= '14:30') && ($TimeStart <= '18:30')) {
    include ('save_picking_tv.php');
  }else if (($TimeStart >= '04:00') && ($TimeStart <= '07:00')) {
    include ('save_picking_tv.php');
  }else {
    echo "<script>window.top.window.showResult('4');</script>";
  	exit();
  }
  //! Subcontact !\\
}else {
  if (($TimeStart >= '09:00') && ($TimeStart <= '14:00')) {
        if (($InfoResult["Qta_Qty"]) > 1) {
          include ('save_picking_tv.php');
        }else {
          echo "<script>window.top.window.showResult('4');</script>";
        	exit();
        }
  }else if (($TimeStart >= '14:30') && ($TimeStart <= '18:30')) {
	include ('save_picking_tv.php');
  }else if (($TimeStart >= '04:00') && ($TimeStart <= '07:00')) {
	include ('save_picking_tv.php');
  }else {
    echo "<script>window.top.window.showResult('4');</script>";
  	exit();
  }
}






  //sqlsrv_close($conn);
  
    /*$CountSQL = "SELECT COUNT(DISTINCT TrnNo) AS NumChecked 
	FROM Cnt_TrnDetail 
	WHERE (TrnDate = '$DateStart 00:00:00') 
	AND (EmpID = '$inputEmpID') 
	AND (Status <> 0) ";
    $CountQuery = sqlsrv_query($connCanteen, $CountSQL);
    $CountResult = sqlsrv_fetch_array($CountQuery, SQLSRV_FETCH_ASSOC);
    $NumChecked = $CountResult["NumChecked"];
	
	if ($NumChecked > 0) {
        if (($InfoResult["Qta_Qty"]) == 1) {
          include ('save_picking_tv.php');
        }else {
          echo "<script>window.top.window.showResult('4');</script>";
        	exit();
        }
	}else {
        if (($InfoResult["Qta_Qty"]) >= 2) {
          include ('save_picking_tv.php');
        }else {
          echo "<script>window.top.window.showResult('4');</script>";
        	exit();
        }
	}*/
?>




