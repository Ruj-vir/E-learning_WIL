
<?php
    include "../alert/alert_session.php";
    include "../../database/conn_sqlsrv.php";
    //include "../database/conn_mysql.php";
    include "../alert/alert_user.php";
    include "../alert/data_detail.php";


	$QDate = "SELECT convert(varchar(10), GETDATE(), 111) AS Datelimit";
	$objDate = sqlsrv_query($connCanteen, $QDate);
	$sumDate = sqlsrv_fetch_array($objDate, SQLSRV_FETCH_ASSOC);
	$Datelimit = $sumDate['Datelimit'];
	$Datelimit = str_replace('/', '-', $Datelimit);

	$Queryer = "SELECT TOP (1) TrnNo,TrnDate FROM Cnt_TrnDetail ORDER BY TrnNo DESC, TrnTime DESC";
	$objQueryer = sqlsrv_query($connCanteen, $Queryer);
	$objResulty = sqlsrv_fetch_array($objQueryer, SQLSRV_FETCH_ASSOC);
	if (date_format($objResulty["TrnDate"], 'Y-m-d') == $Datelimit) {
		$timeConn = (trim($objResulty["TrnNo"] + 1));
	}
	else {
		$time = str_replace('-', '', $Datelimit);
		$timeConn = (trim($time.'0001'));
	}

	if(trim($_POST["InputRFID"]) != NULL) {

	$CanteenPlan = $_POST["CanteenPlan"];
	$InputRFID = $_POST["InputRFID"];

	$strSQL01 = "SELECT EmpID FROM RFID_Master WHERE (RFIDNo = '$InputRFID') AND (Status = 1)";
	$objQuery01 = sqlsrv_query($connCanteen, $strSQL01);
	$objResult01 = sqlsrv_fetch_array($objQuery01, SQLSRV_FETCH_ASSOC);

	$strSQL = "SELECT Qta_Qty,Qta_Value FROM Cnt_Quota WHERE (EmpID = '".$objResult01["EmpID"]."') ";
	$objQuery = sqlsrv_query($connCanteen, $strSQL);
	$objResult = sqlsrv_fetch_array($objQuery, SQLSRV_FETCH_ASSOC);

if(isset($objResult01["EmpID"]) != "") {
	if( $objResult["Qta_Value"] > 0 ) {
		//UPDATE
		$sql1 = "UPDATE Cnt_Quota SET Qta_Qty = Qta_Qty - ? , Qta_Value = Qta_Value - ?, UpdateDate = GETDATE(), UpdateBy = '$CanteenPlan' WHERE EmpID = ? ";
		$params1 = array(1 , 1 * 20, $objResult01["EmpID"]);
		$stmt1 = sqlsrv_query( $connCanteen, $sql1, $params1);
		//INSERT
		$sql = "INSERT INTO Cnt_TrnDetail (TrnNo, TrnDate, TrnTime, EmpID, Qta_Qty, Qta_Value, Status, MakeBy) VALUES ( ?, DATEADD(DAY,0,DATEDIFF(DAY,0,GETDATE())), GETDATE(), ?, 1, 20, 1, '$CanteenPlan')";
		$params = array($timeConn, $objResult01["EmpID"]);
		$stmt = sqlsrv_query( $connCanteen, $sql,  $params);
		if(($stmt1 || $stmt) === false) {
			//echo '<span class="btn No_money">Error!! Save Picking - Contact IT</span>'."<br><br>";
			//die( print_r( sqlsrv_errors(), true));
			echo "<script>window.top.window.CanteenResult('101');</script>";
			exit();
		}else {
			//echo '<audio id="Okey" src="../img/media/Thank.mp3" type="audio/mpeg"></audio><script>var audio = document.getElementById("Okey").play();audio.volume = 0.9;setTimeout(function(){ javascript:history.back(1);}, 1300);</script>';
			//echo '<span class="btn money rounded">20 THB</span><script>setTimeout(function(){ javascript:history.back(1);}, 1500);';
			echo "<script>window.top.window.CanteenResult('501');</script>";
			exit();
		}
	}
	else {
		$Excute = "INSERT INTO Cnt_TrnDetail (TrnNo, TrnDate, TrnTime, EmpID, Qta_Qty, Qta_Value, Status, MakeBy) VALUES ( ?, DATEADD(DAY,0,DATEDIFF(DAY,0,GETDATE())), GETDATE(), ?, 0, 0, 0, '$CanteenPlan')";
		$paramit = array($timeConn, $objResult01["EmpID"]);
		$lungtung = sqlsrv_query( $connCanteen, $Excute,  $paramit);
		if($lungtung === false) {
			//echo '<span class="btn No_money">Error!! No Payment - Contact IT</span>'."<br><br>";
			//die( print_r( sqlsrv_errors(), true));
			echo "<script>window.top.window.CanteenResult('102');</script>";
			exit();
		}else {
			//echo '<audio id="alert" src="../img/media/buzzer.mp3" type="audio/mpeg"></audio><script>var audio = document.getElementById("alert").play();audio.volume = 0.9;setTimeout(function(){ javascript:history.back(1);}, 1300);</script>';
			//echo '<span class="btn No_money rounded">No payment!!</span><script>setTimeout(function(){ javascript:history.back(1);}, 1000);</script>';
			echo "<script>window.top.window.CanteenResult('502');</script>";
			exit();
		}
	}

}else {
	//echo '<audio id="alert" src="../img/media/again_Alto.mp3" type="audio/mpeg"></audio><script>var audio = document.getElementById("alert").play();audio.volume = 0.9;setTimeout(function(){ javascript:history.back(1);}, 1300);</script>';
	echo "<script>window.top.window.CanteenResult('103');</script>";
	exit();
}

	}else {
		echo "<script>window.close();</script>";
		exit();
    }

//sqlsrv_close($connCanteen);
?>
