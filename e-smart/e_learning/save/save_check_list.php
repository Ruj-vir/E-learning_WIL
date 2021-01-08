<?php
include "../alert/alert_session.php";
include "../../database/conn_sqlsrv.php";
//include "../database/conn_odbc.php";
//include "../../database/conn_mysql.php";
include "../alert/alert_user.php";
include "../alert/data_detail.php";


$ReqNoID = $_POST["txtReqNo"];
$ItemKey = ((isset($_POST['listStaff1'])) ? $_POST['listStaff1'] : NULL);
$Trainees = ((isset($_POST['listStaff2'])) ? $_POST['listStaff2'] : NULL);


if (isset($_POST["SubmitCheckedList"]) == '1') {
	echo "<script>window.top.window.LoadingResult('1');</script>";

	foreach ($Trainees as $TraineesComm) {
        $TraineesMark .= "'".$TraineesComm."'" . ",";
	}
	$InTrainees = substr($TraineesMark, 0, -1);

    //! เช็คผู้ตรวจสอบ \\
    $AuthorCheckSQL = "SELECT COUNT(EmpUserID) AS NumAuthorCheck FROM ReqUser WHERE EmpUserID IN ($InTrainees) AND (LvApprove = '' OR LvApprove IS NULL)";
    $AuthorCheckQuery = sqlsrv_query($connRequest, $AuthorCheckSQL);
    $AuthorCheckResult = sqlsrv_fetch_array($AuthorCheckQuery, SQLSRV_FETCH_ASSOC);

    $AuthorVerifySQL = "SELECT COUNT(EmpUserID) AS NumAuthorVerify FROM ReqUser WHERE EmpUserID IN ($InTrainees) AND (EduVerify = '' OR EduVerify IS NULL)";
    $AuthorVerifyQuery = sqlsrv_query($connRequest, $AuthorVerifySQL);
    $AuthorVerifyResult = sqlsrv_fetch_array($AuthorVerifyQuery, SQLSRV_FETCH_ASSOC);

    $AuthorApproveSQL = "SELECT COUNT(EmpUserID) AS NumAuthorApprove FROM ReqUser WHERE EmpUserID IN ($InTrainees) AND (EduApprove = '' OR EduApprove IS NULL)";
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
			if (isset($ItemKey[$i], $Trainees[$a])) {
				$RecItemKey = $ItemKey[$i];
				$RecTrainees = $Trainees[$a];

				$FineApproveSql = "SELECT EduVerify FROM ReqUser WHERE (EmpUserID='$RecTrainees')";
				$FineApproveQuery = sqlsrv_query($connRequest, $FineApproveSql);
				$FineApproveResult = sqlsrv_fetch_array($FineApproveQuery, SQLSRV_FETCH_ASSOC);
				$FineApproveID = $FineApproveResult["EduVerify"];

				$ApproveSql = "UPDATE ReqInfo SET
				Status = ? ,
				ReqApprover = ?,
				ReqChecker = ? ,
				ReqCheckDate = GETDATE()
				WHERE ReqNo = ? AND EmployeeID = ? ";
				$ApproveParams = array(2, $FineApproveID, $SesUserID, $RecItemKey, $RecTrainees);
				$ApproveStmt = sqlsrv_query($connRequest, $ApproveSql, $ApproveParams);
			} else {
				echo "<script>alert('Error!! Wrong request number.');window.top.window.TrainingResult('0');</script>";
				exit();
			}
		}
		if ($ApproveStmt === false) {
			echo "<script>alert('Error!! Incorrect information.');window.top.window.TrainingResult('0');</script>";
			exit();
		} else {
			//or die ("Error Query [".$strSQL11."]");
			//or die( print_r( sqlsrv_errors(), true));
			//echo "<script>window.top.window.TrainingResult('1');</script>";
			include_once "../email/mail_sendcheck_list_training.php";
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
	echo "<script>window.top.window.LoadingResult('1');</script>";

	for ($i = 0, $a = 0; $i < count($ItemKey) && $a < count($Trainees); $i++, $a++) {
		if (isset($ItemKey[$i], $Trainees[$a])) {
			$RecItemKey = $ItemKey[$i];
			$RecTrainees = $Trainees[$a];

			$CommentSql = "SELECT ReqRemark,UserDefine1 FROM ReqInfo WHERE (ReqNo='$RecItemKey') AND (EmployeeID='$RecTrainees')";
			$CommentQuery = sqlsrv_query($connRequest, $CommentSql);
			$CommentResult = sqlsrv_fetch_array($CommentQuery, SQLSRV_FETCH_ASSOC);

			$vowels = array("|");
			$SendReject = str_replace($vowels, '', $_POST["txtReject"]);
			$ReasonReject = $CommentResult["UserDefine1"] . "|" . $SendReject;

			$SqlReject = "UPDATE ReqInfo SET 
			Status = ? , 
			UserDefine1 = ?, 
			ReqChecker = ?, 
			ReqCheckDate = GETDATE()
			WHERE ReqNo = ? AND EmployeeID = ? ";
			$ParamsReject = array(0, $ReasonReject, $SesUserID, $RecItemKey, $RecTrainees);
			$StmtReject = sqlsrv_query($connRequest, $SqlReject, $ParamsReject);
		} else {
			echo "<script>alert('Error!! Wrong request number.');window.top.window.TrainingResult('0');</script>";
			exit();
		}
	}

	if ($StmtReject == true) {
		include_once "../email/mail_sendcheck_rejectlist_training.php";
		exit();
	} else {
		echo "<script type=text/javascript>alert('Error Unsuccessful');window.top.window.TrainingResult('0');</script>";
		exit();
	}
}
