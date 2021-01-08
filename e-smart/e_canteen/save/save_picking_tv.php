<?php


  if(($inputEmpID != NULL) && ($Status == 1)){

    	if(($QtaValue) > 0) {
    		//UPDATE
    		$sql1 = "UPDATE Cnt_Quota SET Qta_Qty = Qta_Qty - ?, Qta_Value = Qta_Value - ?, UpdateDate = GETDATE(), UpdateBy = ? WHERE EmpID = ? ";
    		$params1 = array(1, 20, $Plant, $inputEmpID);
    		$stmt1 = sqlsrv_query($connCanteen, $sql1, $params1);
    		//INSERT
    		$sql2 = "INSERT INTO Cnt_TrnDetail (TrnNo, TrnDate, TrnTime, EmpID, Qta_Qty, Qta_Value, Status, MakeBy) VALUES ( ?, DATEADD(DAY,0,DATEDIFF(DAY,0,GETDATE())), GETDATE(), ?, ?, ?, ?, ?)";
    		$params2 = array($timeConn, $inputEmpID, 1, 20, 1, $Plant);
    		$stmt2 = sqlsrv_query($connCanteen, $sql2, $params2);
    		if(($stmt1 || $stmt2) === false) {
			//echo ("Error Query [".$strSQL11."]");
			echo ( print_r( sqlsrv_errors(), true));
    			//echo "<script>window.top.window.showResult('3');</script>";
    			exit();
    		}else{
    			echo "<script>window.top.window.showResult('1');</script>";
    			exit();
    		}
    	}else {
    		$sql3 = "INSERT INTO Cnt_TrnDetail (TrnNo, TrnDate, TrnTime, EmpID, Qta_Qty, Qta_Value, Status, MakeBy) VALUES ( ?, DATEADD(DAY,0,DATEDIFF(DAY,0,GETDATE())), GETDATE(), ?, ?, ?, ?, ?)";
    		$params3 = array($timeConn, $inputEmpID, 0, 0, 0, $Plant);
    		$stmt3 = sqlsrv_query($connCanteen, $sql3, $params3);
    		if($stmt3 === false){
    			//echo "<script>window.top.window.showResult('3');</script>";
    			exit();
    		}
    		else{
    		echo "<script>window.top.window.showResult('0');</script>";
    		exit();
    		}
    	}

  }else{
  	echo "<script>window.top.window.showResult('4');</script>";
  	exit();
  }

//sqlsrv_close($conn);
?>
