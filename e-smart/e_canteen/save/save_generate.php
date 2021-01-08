
<?php
include "../alert/alert_session.php";
include "../../database/conn_sqlsrv.php";
//include "../database/conn_mysql.php";
include "../alert/alert_user.php";
include "../alert/data_detail.php";


$FixMag = strip_tags(htmlspecialchars("Adjust"));
$QtyMoney = strip_tags(htmlspecialchars($_POST["txtQTY"]));
$EmpID = strip_tags(htmlspecialchars($_POST["txtempID"]));
$Detail = strip_tags(htmlspecialchars($_POST["txtDetail"]));


//! Gen ID \\
$PeriodQuery = "SELECT convert(varchar(10), GETDATE(), 111) AS DateCurrent, 
                convert(varchar(10), GETDATE(), 108) AS TimeCurrent ";
$PeriodObj = sqlsrv_query($connCanteen, $PeriodQuery);
$PeriodResult = sqlsrv_fetch_array($PeriodObj, SQLSRV_FETCH_ASSOC);

$DateCurrent = $PeriodResult["DateCurrent"];
$TimeCurrent = $PeriodResult["TimeCurrent"];

$KeyQuery = "SELECT TOP (1) AdjustNo,AdjustDate FROM Cnt_Adjust ORDER BY AdjustNo DESC";
$KeyObj = sqlsrv_query($connCanteen, $KeyQuery);
$KeyResult = sqlsrv_fetch_array($KeyObj, SQLSRV_FETCH_ASSOC);

$KeyTime = str_replace(':', '', $TimeCurrent);

if (isset($KeyResult["AdjustDate"]) == NULL) {
	$Key = str_replace('/', '', $DateCurrent);
	$KeyID = (trim($Key . '0001'));
} else {
	$KeyDate = date_format($KeyResult["AdjustDate"], 'Y/m/d');
	$KeyNo = (isset($KeyResult["AdjustNo"])) ? $KeyResult["AdjustNo"] : NULL;

	if ($KeyDate == $DateCurrent) {
		$KeyID = (trim($KeyNo + 1));
	} else {
		$Key = str_replace('/', '', $DateCurrent);
		$KeyID = (trim($Key . '0001'));
	}
}
//! Gen ID \\

if (isset($_POST["GeneSingle"])) {

	$stmt = "SELECT UserDefine1 FROM Cnt_Quota WHERE (EmpID = '$EmpID')";
	$query = sqlsrv_query($connCanteen, $stmt);
	$result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
	
	$DetailTxT = str_replace("|", "", $Detail);
	$vowels = array("ot", "Ot", "OT", "oT", "โอที");
	$DetailSend = str_replace($vowels, 'OT', $DetailTxT);

	if($DetailSend == "OT") {
		$DetailSend = "OT Request";
	}
	
	if (isset($result['UserDefine1']) == NULL) {
		$SetQuota = $DetailSend;
	} else {
		$SetQuota = $result['UserDefine1'] . "|" . $DetailSend;
	}

	$SaveOneSql = "INSERT INTO Cnt_Adjust (AdjustNo, AdjustEmpID, AdjustDate, 
          AdjustQty, AdjustValue, Remark, Status,
          CreatedBy, CreatedDate) 
          VALUES (?, ?, DATEADD(DAY,0,DATEDIFF(DAY,0,GETDATE())), 
          ?, ?, ?, ?, 
          ?, GETDATE() )";
	$SaveOneParams = array(
		$KeyID, $EmpID,
		$QtyMoney, $QtyMoney * 20, $SetQuota, 1,
		$SesUserID
	);

	$SaveOneStmt = sqlsrv_query($connCanteen, $SaveOneSql, $SaveOneParams);
	if ($SaveOneStmt === false) {
		//die(print_r( sqlsrv_errors(), true));
		//echo ("Error Query [".$SaveOneSql."]");
		echo "<script>window.top.window.CanteenResult('0');</script>";
		//echo 0;
		exit();
	} else {
		//echo "<script>window.top.window.CanteenResult('1');</script>";
		//echo 1;
		//exit();

		$QuotaSigSql = "UPDATE Cnt_Quota SET
				Qta_Qty = Qta_Qty + ? ,
				Qta_Value = Qta_Value + ?,
				UserDefine1 = ? ,
				UserDefine2 = ? ,
				UpdateDate = GETDATE() ,
				UpdateBy = ?
				WHERE EmpID = ? ";
		$QuotaSigParam = array($QtyMoney, $QtyMoney * 20, $SetQuota, $FixMag, $SesUserID, $EmpID);
		$QuotaSigStmt = sqlsrv_query($connCanteen, $QuotaSigSql, $QuotaSigParam);
		if ($QuotaSigStmt === false) {
			echo "<script type=text/javascript>window.top.window.CanteenResult('0');</script>";
			exit();
		} else {
			echo "<script type=text/javascript>window.top.window.CanteenResult('1');</script>";
			exit();
		}
	}
}



if (isset($_POST["GeneMulti"])) {

	foreach($_POST["EmpID"] as $EmpID) {

		$stmt = "SELECT UserDefine1 FROM Cnt_Quota WHERE (EmpID = '$EmpID')";
		$query = sqlsrv_query($connCanteen, $stmt);
		$result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
		
		$Detail = str_replace("|", "", $Detail);
		$vowels = array("ot", "Ot", "OT", "oT", "โอที");
		$DetailSend = str_replace($vowels, 'OT', $Detail);

		if($DetailSend == "OT") {
			$DetailSend = "OT Request";
		}

		if (isset($result['UserDefine1']) == NULL) {
			$SetQuota = $DetailSend;
		} else {
			$SetQuota = $result['UserDefine1'] . "|" . $DetailSend;
		}

		$SaveTwoSql = "INSERT INTO Cnt_Adjust (AdjustNo, AdjustEmpID, AdjustDate, 
			AdjustQty, AdjustValue, Remark, Status,
			CreatedBy, CreatedDate) 
			VALUES (?, ?, DATEADD(DAY,0,DATEDIFF(DAY,0,GETDATE())), 
			?, ?, ?, ?, 
			?, GETDATE() )";
		$SaveTwoParams = array(
			$KeyID, $EmpID,
			$QtyMoney, $QtyMoney * 20, $SetQuota, 1,
			$SesUserID
		);
		$SaveTwoStmt = sqlsrv_query($connCanteen, $SaveTwoSql, $SaveTwoParams);
	}

	if ($SaveTwoStmt === false) {
		//die(print_r( sqlsrv_errors(), true));
		//echo ("Error Query [".$SaveOneSql."]");
		echo "<script>window.top.window.CanteenResult('0');</script>";
		//echo 0;
		exit();
	} else {
		for ($i = 0; $i < count($_POST["EmpID"]); $i++) {
			
			$EmpID = $_POST["EmpID"][$i];

			$stmt = "SELECT UserDefine1 FROM Cnt_Quota WHERE (EmpID = '$EmpID')";
			$query = sqlsrv_query($connCanteen, $stmt);
			$result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
			
			$Detail = str_replace("|", "", $Detail);
			$vowels = array("ot", "Ot", "OT", "oT", "โอที");
			$DetailSend = str_replace($vowels, 'OT', $Detail);

			if($DetailSend == "OT") {
				$DetailSend = "OT Request";
			}

			if (isset($result['UserDefine1']) == NULL) {
				$SetQuota = $DetailSend;
			} else {
				$SetQuota = $result['UserDefine1'] . "|" . $DetailSend;
			}

			$QuotaManSql = "UPDATE Cnt_Quota SET
			Qta_Qty = Qta_Qty + ? ,
			Qta_Value = Qta_Value + ?,
			UserDefine1 = ? ,
			UserDefine2 = ? ,
			UpdateDate = GETDATE() ,
			UpdateBy = ?
			WHERE EmpID = ? ";
			$QuotaManParam = array($QtyMoney, $QtyMoney * 20, $SetQuota, $FixMag, $SesUserID, $_POST["EmpID"][$i]);
			$QuotaManStmt = sqlsrv_query($connCanteen, $QuotaManSql, $QuotaManParam);
		}
		if ($QuotaManStmt === false) {
			echo "<script type=text/javascript>window.top.window.CanteenResult('0');</script>";
			exit();
		} else {
			echo "<script type=text/javascript>window.top.window.CanteenResult('1');</script>";
			exit();
		}
	}

}


?>
