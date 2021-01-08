
<?php
    //include "../alert/alert_session.php";
    include "../../database/conn_sqlsrv.php";
    //include "../database/conn_mysql.php";
    //include "../alert/alert_user.php";
	  //include "../alert/data_detail.php";

  

  $QDate = "SELECT convert(varchar(10), GETDATE(), 111) AS Datelimit, convert(varchar(10), GETDATE(), 108) AS Timelimit";
	$objDate = sqlsrv_query($connCanteen, $QDate);
	$Current = sqlsrv_fetch_array($objDate,SQLSRV_FETCH_ASSOC);
	$limit = $Current['Datelimit'];
	$Datelimit = str_replace('/', '-', $limit);
  $DayName = date('l', strtotime($Datelimit));
  $Timelimit = $Current['Timelimit'];
  $TimeStart = substr($Timelimit, 0 ,5);

  $strSQL1 = "SELECT EmpID,Status FROM RFID_Master WHERE (RFIDNo = '".$_POST["txtRFID"]."') AND (Status = 1)";
	$objQuery1 = sqlsrv_query($connCanteen, $strSQL1);
	$objResult1 = sqlsrv_fetch_array($objQuery1,SQLSRV_FETCH_ASSOC);

	$strSQL2 = "SELECT Qta_Qty,Qta_Value,UserDefine1 FROM Cnt_Quota WHERE (EmpID = '".$objResult1["EmpID"]."')";
	$objQuery2 = sqlsrv_query($connCanteen, $strSQL2);
	$objResult2 = sqlsrv_fetch_array($objQuery2,SQLSRV_FETCH_ASSOC);


  if (($TimeStart >= '09:00') && ($TimeStart <= '14:00')) {
    if (($DayName == 'Saturday') && ($objResult2["Qta_Qty"] <= 1)) {
        include ('save_picking_tv.php');
    }else {
      $mystring = $objResult2["UserDefine1"];
      $pos = strrpos($mystring, "OT Request");
      if (is_bool($pos)) {
        include ('save_picking_tv.php');
      }else {
        if (($objResult2["Qta_Qty"]) > 1) {
          include ('save_picking_tv.php');
        }else {
          echo "<script language=\"JavaScript\">window.top.window.showResult('4');</script>";
        	exit();
        }
      }
    }
  }else if (($TimeStart >= '14:30') && ($TimeStart <= '18:30')) {
    include ('save_picking_tv.php');
  }else if (($TimeStart >= '04:00') && ($TimeStart <= '07:00')) {
    include ('save_picking_tv.php');
  }else {
    echo "<script language=\"JavaScript\">window.top.window.showResult('4');</script>";
  	exit();
  }

  //sqlsrv_close($conn);
?>
