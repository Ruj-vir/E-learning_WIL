<?php
include "../alert/alert_session.php";
include "../alert/alert_user.php";
include "../../database/conn_sqlsrv.php";
//include "../database/conn_odbc.php";
//include "../../database/conn_mysql.php";
include "../alert/data_detail.php";

$ReqNoID = $_POST["txtReqNo"];
$ItemKey = ((isset($_POST['listStaff1'])) ? $_POST['listStaff1'] : NULL);
$Trainees = ((isset($_POST['listStaff2'])) ? $_POST['listStaff2'] : NULL);

$inputRejectList = strip_tags(htmlspecialchars($_POST['inputRejectList']));
$inputRejectGroup = strip_tags(htmlspecialchars($_POST['inputRejectGroup']));

if (trim($_POST["BttReject"]) == 1) {

	echo "<script>window.top.window.LoadingResult('1');</script>";

	for ($i = 0, $a = 0; $i < count($ItemKey) && $a < count($Trainees); $i++, $a++) {
		if (isset($ItemKey[$i], $Trainees[$a])) {

			$RecItemKey = $ItemKey[$i];
			$RecTrainees = $Trainees[$a];

			$CommentSql = "SELECT ReqRemark,UserDefine1 FROM ReqInfo WHERE (ReqNo='$RecItemKey') AND (EmployeeID='$RecTrainees') AND (Status <> 0 AND Status <= 1) ";
			$CommentQuery = sqlsrv_query($connRequest, $CommentSql);
			$CommentResult = sqlsrv_fetch_array($CommentQuery, SQLSRV_FETCH_ASSOC);

			$vowels = array("|");
			$SendReject = str_replace($vowels, '', $inputRejectList);
			$ReasonReject = $CommentResult["UserDefine1"] . "|" . $SendReject;

			$SqlReject = "UPDATE ReqInfo SET 
				UserDefine1 = ?, 
				CreateBy = ?, 
				CreateDate = GETDATE(), 
				Status = ? 
			WHERE ReqNo = ? AND EmployeeID = ? ";
			$ParamsReject = array($ReasonReject, $SesUserID, 0, $RecItemKey, $RecTrainees);
			$StmtReject = sqlsrv_query($connRequest, $SqlReject, $ParamsReject);

		} else {
			echo "<script>alert('Error!! Wrong request number.');window.top.window.TrainingResult('0');</script>";
			exit();
		}
	}

	if ($StmtReject == true) {
		echo "<script>window.top.window.TrainingResult('1');</script>";
		exit();
	} else {
        //or die ("Error Query [".$strSQL11."]");
		//or die( print_r( sqlsrv_errors(), true));
		echo "<script type=text/javascript>alert('Error Unsuccessful');window.top.window.TrainingResult('0');</script>";
		exit();
    }
    
}




if (trim($_POST["BttReject"]) == 3) {

	echo "<script>window.top.window.LoadingResult('1');</script>";

		$RecItemKey = $_POST["inputKeyCancel"];
		if (trim($RecItemKey) != NULL) {

			$EmpIDSql = "SELECT EmployeeID,UserDefine1 FROM ReqInfo WHERE (ReqNo = '$RecItemKey') AND (ReqIssuer='$SesUserID') AND (Status <> 0 AND Status <= 1) ";
			$EmpIDQuery = sqlsrv_query($connRequest, $EmpIDSql);
			while ($EmpIDResult = sqlsrv_fetch_array($EmpIDQuery, SQLSRV_FETCH_ASSOC)) {

				$vowels = array("|");
				$SendReject = str_replace($vowels, '', $inputRejectGroup);
				$ReasonReject = $EmpIDResult["UserDefine1"] . "|" . $SendReject;

				$SqlReject = "UPDATE ReqInfo SET 
				UserDefine1 = ?, 
				CreateBy = ?, 
				CreateDate = GETDATE(), 
				Status = ? 
				WHERE (ReqNo = ?) AND (EmployeeID = ?) AND (ReqIssuer = ?) AND (Status <> ? AND Status <= ?) ";
				$ParamsReject = array($ReasonReject, $SesUserID, 0, $RecItemKey, $EmpIDResult['EmployeeID'], $SesUserID, 0, 1);
                $StmtReject = sqlsrv_query($connRequest, $SqlReject, $ParamsReject);
                
			}
		} else {
			echo "<script>alert('Error!! Wrong request number.');window.top.window.TrainingResult('0');</script>";
			exit();
		}

	if ($StmtReject == true) {
		echo "<script>window.top.window.TrainingResult('1');</script>";
		exit();
	} else {
        //or die ("Error Query [".$strSQL11."]");
		//or die( print_r( sqlsrv_errors(), true));
		echo "<script type=text/javascript>alert('Error ยกเลิกคำร้องนี้ไม่ได้ เนื่องจากอนุมัติคำร้องแล้ว');window.top.window.TrainingResult('0');</script>";
		exit();
    }
    
}
