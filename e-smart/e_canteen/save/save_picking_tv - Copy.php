<?php
	$Queryer = "SELECT TOP (1) TrnNo,TrnDate FROM Cnt_TrnDetail ORDER BY TrnNo DESC, TrnTime DESC";
	$objQueryer = sqlsrv_query($connCanteen, $Queryer);
	$objResulty = sqlsrv_fetch_array($objQueryer,SQLSRV_FETCH_ASSOC);
	if(date_format($objResulty["TrnDate"], 'Y-m-d') == $Datelimit) {
		$timeConn = (trim($objResulty["TrnNo"] + 1));
	}else {
		$time = str_replace('-', '', $Datelimit);
		$timeConn = (trim($time.'0001'));
	}

  if(($objResult1["EmpID"] != '') && ($objResult1["Status"] == 1)){

	$Plant = $_POST["plant"];

    	if(($objResult2["Qta_Value"]) > 0) {
    		//UPDATE
    		$sql1 = "UPDATE Cnt_Quota SET Qta_Qty = Qta_Qty - ?, Qta_Value = Qta_Value - ?, UpdateDate = GETDATE(), UpdateBy = '$Plant' WHERE EmpID = ? ";
    		$params1 = array(1, 20, $objResult1["EmpID"]);
    		$stmt1 = sqlsrv_query($connCanteen, $sql1, $params1);
    		//INSERT
    		$sql2 = "INSERT INTO Cnt_TrnDetail (TrnNo, TrnDate, TrnTime, EmpID, Qta_Qty, Qta_Value, Status, MakeBy) VALUES ( ?, DATEADD(DAY,0,DATEDIFF(DAY,0,GETDATE())), GETDATE(), ?, 1, 20, 1, '$Plant')";
    		$params2 = array($timeConn, $objResult1["EmpID"]);
    		$stmt2 = sqlsrv_query($connCanteen, $sql2, $params2);
    		if(($stmt1 || $stmt2) === false) {
    			echo "<script type=text/javascript>window.top.window.showResult('3');</script>";
    			exit();
    		}else{
    			echo "<script language=\"JavaScript\">window.top.window.showResult('1');</script>";
    			exit();
    		}
    	}else {
    		$sql3 = "INSERT INTO Cnt_TrnDetail (TrnNo, TrnDate, TrnTime, EmpID, Qta_Qty, Qta_Value, Status, MakeBy) VALUES ( ?, DATEADD(DAY,0,DATEDIFF(DAY,0,GETDATE())), GETDATE(), ?, 0, 0, 0, '$Plant')";
    		$params3 = array($timeConn, $objResult1["EmpID"]);
    		$stmt3 = sqlsrv_query($connCanteen, $sql3, $params3);
    		if($stmt3 === false){
    			echo "<script type=text/javascript>window.top.window.showResult('3');</script>";
    			exit();
    		}
    		else{
    		echo "<script language=\"JavaScript\">window.top.window.showResult('0');</script>";
    		exit();
    		}
    	}

  }else{
  	echo "<script language=\"JavaScript\">window.top.window.showResult('4');</script>";
  	exit();
  }

//sqlsrv_close($conn);
?>
