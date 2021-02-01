<?php
include "../alert/alert_session.php";
include "../alert/alert_user.php";
include "../../database/conn_sqlsrv.php";
//include "../database/conn_odbc.php";
//include "../../database/conn_mysql.php";
include "../alert/data_detail.php";



if (isset($_POST["SubmitCheckedGroup"]) == '1') {
	echo "<script>window.top.window.LoadingResult('1');</script>";

	foreach ($_POST["CheckStaff"] as $iNum => $ItemKey) {
		$SQLCheck = "SELECT EmployeeID FROM ReqInfo WHERE (ReqNo=$ItemKey) AND (ReqApprover='$SesUserID') AND (Status=2)";
		$QueryCheck = sqlsrv_query($connRequest, $SQLCheck);
		while ($ResultCheck = sqlsrv_fetch_array($QueryCheck, SQLSRV_FETCH_ASSOC)) {
			$CheckerMark .= "'".$ResultCheck["EmployeeID"]."'" . ",";
		}
	}
	$InTrainees = substr($CheckerMark, 0, -1);

    //! เช็คผู้ตรวจสอบ \\
    $AuthorCheckSQL = "SELECT COUNT(EmpUserID) AS NumAuthorCheck FROM ReqUser WHERE EmpUserID IN ($InTrainees) AND (LvApprove = '' OR LvApprove IS NULL)";
    $AuthorCheckQuery = sqlsrv_query($connRequest, $AuthorCheckSQL);
    $AuthorCheckResult = sqlsrv_fetch_array($AuthorCheckQuery, SQLSRV_FETCH_ASSOC);

    // $AuthorVerifySQL = "SELECT COUNT(EmpUserID) AS NumAuthorVerify FROM ReqUser WHERE EmpUserID IN ($InTrainees) AND (EduVerify = '' OR EduVerify IS NULL)";
    // $AuthorVerifyQuery = sqlsrv_query($connRequest, $AuthorVerifySQL);
    // $AuthorVerifyResult = sqlsrv_fetch_array($AuthorVerifyQuery, SQLSRV_FETCH_ASSOC);

    // $AuthorApproveSQL = "SELECT COUNT(EmpUserID) AS NumAuthorApprove FROM ReqUser WHERE EmpUserID IN ($InTrainees) AND (EduApprove = '' OR EduApprove IS NULL)";
    // $AuthorApproveQuery = sqlsrv_query($connRequest, $AuthorApproveSQL);
    // $AuthorApproveResult = sqlsrv_fetch_array($AuthorApproveQuery, SQLSRV_FETCH_ASSOC);

    $NumAuthorCheck = $AuthorCheckResult["NumAuthorCheck"];
    // $NumAuthorVerify = $AuthorVerifyResult["NumAuthorVerify"];
    // $NumAuthorApprove = $AuthorApproveResult["NumAuthorApprove"];
    //! เช็คผู้ตรวจสอบ \\

	if ($NumAuthorCheck > 0) {
		echo "<script>alert('Error!! There are employees without inspector.');window.top.window.TrainingResult('0');</script>";
		exit();
	} 
	// else if ($NumAuthorVerify > 0) {
	// 	echo "<script>alert('Error!! There are employees without verify.');window.top.window.TrainingResult('0');</script>";
	// 	exit();
	// } else if ($NumAuthorApprove > 0) {
	// 	echo "<script>alert('Error!! There are employees without approver.');window.top.window.TrainingResult('0');</script>";
	// 	exit();
	// } 
	else {
		for ($i = 0; $i < count($_POST["CheckStaff"]); $i++) {
			$RecItemKey = $_POST["CheckStaff"][$i];

			$StmtEmpID = "SELECT EmployeeID FROM ReqInfo WHERE (ReqNo='$RecItemKey') AND (ReqApprover='$SesUserID') AND (Status=2)";
			$QueryEmpID = sqlsrv_query($connRequest, $StmtEmpID);
			while ($ResultEmpID = sqlsrv_fetch_array($QueryEmpID, SQLSRV_FETCH_ASSOC)) {
				
				$RecTrainees = $ResultEmpID["EmployeeID"];
				// $FineApproveSql = "SELECT EduApprove FROM ReqUser WHERE (EmpUserID='$RecTrainees')";
				// $FineApproveQuery = sqlsrv_query($connRequest, $FineApproveSql);
				// $FineApproveResult = sqlsrv_fetch_array($FineApproveQuery, SQLSRV_FETCH_ASSOC);
				// $FineApproveID = $FineApproveResult["EduApprove"];

				$TypeSql = "SELECT ReqOTType FROM ReqInfo WHERE (ReqNo='$RecItemKey') AND (ReqType = 4) ";
				$TypeQuery = sqlsrv_query($connRequest, $TypeSql);
				$TypeResult = sqlsrv_fetch_array($TypeQuery, SQLSRV_FETCH_ASSOC);
				$TypeID = $TypeResult["ReqOTType"];

				if (trim($TypeID) == 4 || trim($TypeID) == 5) {
					$FineApproveSql = "SELECT EmpUserID FROM ReqUser WHERE (EduApprove=3)";
					$FineApproveQuery = sqlsrv_query($connRequest, $FineApproveSql);
					$FineApproveResult = sqlsrv_fetch_array($FineApproveQuery, SQLSRV_FETCH_ASSOC);
					$FineApproveID = $FineApproveResult["EmpUserID"];
				}else {
					$FineApproveSql = "SELECT EmpUserID FROM ReqUser WHERE (EduApprove=1)";
					$FineApproveQuery = sqlsrv_query($connRequest, $FineApproveSql);
					$FineApproveResult = sqlsrv_fetch_array($FineApproveQuery, SQLSRV_FETCH_ASSOC);
					$FineApproveID = $FineApproveResult["EmpUserID"];
				}

				$ApproveSql = "UPDATE ReqInfo SET
				Status = ? ,
				UpdateBy = ?,
				ReqApprover = ? ,
				ReqApproveDate = GETDATE()
				WHERE ReqNo = ? AND EmployeeID = ? ";
				$ApproveParams = array(3, $FineApproveID, $SesUserID, $RecItemKey, $RecTrainees);
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
			include_once "../email/mail_sendverify_group_training.php";
			exit();
		}
	}
}





if (isset($_POST["RejectCheckedGroup"]) == '3') {
	echo "<script>window.top.window.LoadingResult('1');</script>";

	for ($i = 0; $i < count($_POST["CheckStaff"]); $i++) {
		$RecItemKey = $_POST["CheckStaff"][$i];
		if (trim($RecItemKey) != NULL) {

			$EmpIDSql = "SELECT EmployeeID,UserDefine1 FROM ReqInfo WHERE (ReqNo = '$RecItemKey') AND (ReqApprover='$SesUserID') AND (Status=2) ";
			$EmpIDQuery = sqlsrv_query($connRequest, $EmpIDSql);
			while ($EmpIDResult = sqlsrv_fetch_array($EmpIDQuery, SQLSRV_FETCH_ASSOC)) {

				$vowels = array("|");
				$SendReject = str_replace($vowels, '', $_POST["txtReject"]);
				$ReasonReject = $EmpIDResult["UserDefine1"] . "|" . $SendReject;

				$SqlReject = "UPDATE ReqInfo SET 
				UserDefine1 = ?, 
				ReqApprover = ?, 
				ReqApproveDate = GETDATE(), 
				Status = ? 
				WHERE ReqNo = ? AND EmployeeID = ? AND ReqApprover = ? AND Status = ? ";
				$ParamsReject = array($ReasonReject, $SesUserID, 0, $RecItemKey, $EmpIDResult['EmployeeID'], $SesUserID, 2);
				$StmtReject = sqlsrv_query($connRequest, $SqlReject, $ParamsReject);
			}
		} else {
			echo "<script>alert('Error!! Wrong request number.');window.top.window.TrainingResult('0');</script>";
			exit();
		}
	}

    if ($StmtReject == TRUE) {
        include_once "../email/mail_sendverify_rejectgroupTocheck_training.php";
        if ($flgSendCheck == TRUE) {
            include_once "../email/mail_sendverify_rejectgroupTorequest_training.php";
        }
        if ($flgSendRequest == TRUE) {
            echo "<script type=text/javascript>window.top.window.TrainingResult('1');</script>";
            exit();
        }
    } else {
        //or die ("Error Query [".$SaveOneSql."]");
        //or die( print_r( sqlsrv_errors(), true));
        echo "<script type=text/javascript>alert('Error!! Incorrect information.');window.top.window.TrainingResult('0');</script>";
        exit();
    }
}
