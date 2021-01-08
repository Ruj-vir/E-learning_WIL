<?php
include "../alert/alert_session.php";
include "../../database/conn_sqlsrv.php";
//include "../database/conn_odbc.php";
//include "../../database/conn_mysql.php";
include "../alert/alert_user.php";
include "../alert/data_detail.php";

$ReqNoID = $_POST["txtReqNo"];
echo "<script>window.top.window.LoadingResult('1');</script>";
$ItemKey = ((isset($_POST['listStaff1'])) ? $_POST['listStaff1'] : NULL);
$Trainees = ((isset($_POST['listStaff2'])) ? $_POST['listStaff2'] : NULL);

if (isset($_POST["SubmitCheckedList"]) == '1') {

	foreach ($Trainees as $TraineesComm) {
		$TraineesMark .= $TraineesComm . ",";
	}
	$InTrainees = substr($TraineesMark, 0, -1);

	//! เช็คผู้ตรวจสอบ \\
	$AuthorCheckSQL = "SELECT COUNT(EmpUserID) AS NumAuthorCheck FROM ReqUser WHERE EmpUserID IN ($InTrainees) AND (LvApprove IS NULL)";
	$AuthorCheckQuery = sqlsrv_query($connRequest, $AuthorCheckSQL);
	$AuthorCheckResult = sqlsrv_fetch_array($AuthorCheckQuery, SQLSRV_FETCH_ASSOC);

	$AuthorVerifySQL = "SELECT COUNT(EmpUserID) AS NumAuthorVerify FROM ReqUser WHERE EmpUserID IN ($InTrainees) AND (EduVerify IS NULL)";
	$AuthorVerifyQuery = sqlsrv_query($connRequest, $AuthorVerifySQL);
	$AuthorVerifyResult = sqlsrv_fetch_array($AuthorVerifyQuery, SQLSRV_FETCH_ASSOC);

	$AuthorApproveSQL = "SELECT COUNT(EmpUserID) AS NumAuthorApprove FROM ReqUser WHERE EmpUserID IN ($InTrainees) AND (EduApprove IS NULL)";
	$AuthorApproveQuery = sqlsrv_query($connRequest, $AuthorApproveSQL);
	$AuthorApproveResult = sqlsrv_fetch_array($AuthorApproveQuery, SQLSRV_FETCH_ASSOC);

	$NumAuthorCheck = $AuthorCheckResult["NumAuthorCheck"];
	$NumAuthorVerify = $AuthorVerifyResult["NumAuthorVerify"];
	$NumAuthorApprove = $AuthorApproveResult["NumAuthorApprove"];
	//! เช็คผู้ตรวจสอบ \\

	if ($NumAuthorCheck > 0) {
		echo "<script>alert('Error!! There are employees without inspector.');window.top.window.TrainingResult('0');</script>";
		exit();
	} else if ($NumAuthorVerify > 0) {
		echo "<script>alert('Error!! There are employees without verify.');window.top.window.TrainingResult('0');</script>";
		exit();
	} else if ($NumAuthorApprove > 0) {
		echo "<script>alert('Error!! There are employees without approver.');window.top.window.TrainingResult('0');</script>";
		exit();
	} else {
		for ($i = 0, $a = 0; $i < count($ItemKey) && $a < count($Trainees); $i++, $a++) {
			if (isset($ItemKey[$i]) && ($Trainees[$a])) {
				$RecItemKey = $ItemKey[$i];
				$RecTrainees = $Trainees[$a];

				$FineApproveSql = "SELECT EduApprove FROM ReqUser WHERE (EmpUserID='$RecTrainees')";
				$FineApproveQuery = sqlsrv_query($connRequest, $FineApproveSql);
				$FineApproveResult = sqlsrv_fetch_array($FineApproveQuery, SQLSRV_FETCH_ASSOC);
				$FineApproveID = $FineApproveResult["EduApprove"];

				$ApproveSql = "UPDATE ReqInfo SET
				Status = ? ,
				ReqApprover = ?,
				UpdateDate = GETDATE(),
				UpdateBy = ? 
				WHERE ReqNo = ? AND EmployeeID = ? ";
				$ApproveParams = array(4, $FineApproveID, $SesUserID, $RecItemKey, $RecTrainees);
				$ApproveStmt = sqlsrv_query($connRequest, $ApproveSql, $ApproveParams);
			}
		}
		if ($ApproveStmt === false) {
			echo "<script>alert('Error!! Incorrect information.');window.top.window.TrainingResult('0');</script>";
			exit();
		} else {
			//or die ("Error Query [".$strSQL11."]");
			//or die( print_r( sqlsrv_errors(), true));
			//echo "<script>window.top.window.TrainingResult('1');</script>";
			include_once "../email/mail_sendApprovelist_training.php";
			exit();
		}
	}

	//for($i=0;$i<count($_POST["CheckStaff"]);$i++) {
	//foreach($_POST["listStaff2"] as $iA){
	//$SQLReq= "SELECT EmpUserID,EmpUserName,EmpUserSurname FROM ReqUser WHERE (EmpUserID=$iA) AND (OtApprove IS NULL)";
	//$QueryReq = sqlsrv_query($connRequest, $SQLReq);
	//while ($ResultReq = sqlsrv_fetch_array($QueryReq,SQLSRV_FETCH_ASSOC)){
	//echo $ResultReq["EmpUserID"]."\n".$ResultReq["EmpUserName"]."\n".$ResultReq["EmpUserSurname"]."<br>";
	//}

}
if (isset($_POST["RejectCheckedList"]) == '3') {

	for ($i = 0, $a = 0; $i < count($ItemKey) && $a < count($Trainees); $i++, $a++) {
		if (isset($ItemKey[$i], $Trainees[$a])) {
			$RecItemKey = $ItemKey[$i];
			$RecTrainees = $Trainees[$a];

			$CommentSql = "SELECT ReqRemark FROM ReqInfo WHERE (ReqNo='$RecItemKey') AND (EmployeeID='$RecTrainees')";
			$CommentQuery = sqlsrv_query($connRequest, $CommentSql);
			$CommentResult = sqlsrv_fetch_array($CommentQuery, SQLSRV_FETCH_ASSOC);

			$vowels = array("|");
			$SendReject = str_replace($vowels, '', $_POST["txtReject"]);
			$ReasonReject = $EmpIDResult["UserDefine1"] . "Cancel: " . $SendReject;

			$SqlReject = "UPDATE ReqInfo SET 
				UserDefine1 = ?, 
				UpdateDate = GETDATE(),
				UpdateBy = ?, 
				Status = ? 
				WHERE ReqNo = ? AND EmployeeID = ? AND ReqApprover = ? AND Status = ? ";
			$ParamsReject = array($ReasonReject, $SesUserID, 0, $RecItemKey, $RecTrainees, $SesUserID, 3);
			$StmtReject = sqlsrv_query($connRequest, $SqlReject, $ParamsReject);
		} else {
			echo "<script>alert('Error!! Wrong request number.');window.top.window.TrainingResult('0');</script>";
			exit();
		}
	}

	if ($StmtReject == true) {
		echo 1;
		include_once "../email/mail_sendApproverejectlist_training.php";
	} else {

		print_r(sqlsrv_errors(), true);
		echo "<script type=text/javascript>alert('Error Unsuccessful');window.top.window.TrainingResult('0');</script>";
		exit();
	}
}
