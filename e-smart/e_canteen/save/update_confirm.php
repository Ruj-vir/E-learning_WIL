<?php
    include "../alert/alert_session.php";
    include "../../database/conn_sqlsrv.php";
    //include "../database/conn_mysql.php";
    include "../alert/alert_user.php";
    include "../alert/data_detail.php";

	if(isset($_POST['TrnNo_id'])) {

		$TrnNo_id = trim($_POST['TrnNo_id']);
		$sql = "UPDATE Cnt_TrnDetail SET Status = 3, UpdatedBy = '$SesUserID', UpdatedDate = GETDATE()  WHERE TrnNo IN ($TrnNo_id) ";
		$stmt = sqlsrv_query($connCanteen, $sql);
		//echo $TrnNo_id;
		//exit();
		if( $stmt === false ) {
			echo 0;
			exit();
		}else {
			echo 1;
			exit();
		}
	}


	if(isset($_POST['CancelOrder'])) {
			//for($i=0;$i<count($_POST["TrnNoCancel"]);$i++) {

		foreach($_POST["TrnNoCancel"] as $i){
			$sql = "UPDATE Cnt_TrnDetail SET
			Status = ? ,
			UpdatedBy = ?,
			UpdatedDate = GETDATE()
			WHERE TrnNo = ? ";
			$param = array(0, $SesUserID, $i);
			$stmt = sqlsrv_query( $connCanteen, $sql, $param);
		}
			if( $stmt === false ) {
                //die( print_r( sqlsrv_errors(), true));
				echo "<script type=text/javascript>window.top.window.CanteenResult('0');</script>";
				exit();
			}
			else{
				echo "<script type=text/javascript>window.top.window.CanteenResult('1');</script>";
				exit();
			}

	}

	//sqlsrv_close($conn);
?>





























<?php
/*
	ini_set('display_errors', 0);
	error_reporting(~0);

    $serverName = "WIN-ANKL2J7VOPI\BKUPEXEC";
    $userName = "sa";
    $userPassword = "p@ssw0rd";
    $dbName = "CanteenSystem";

    $connectionInfo = array("Database"=>$dbName, "UID"=>$userName, "PWD"=>$userPassword, "MultipleActiveResultSets"=>true, "CharacterSet" => 'UTF-8');

    $conn = sqlsrv_connect( $serverName, $connectionInfo);

    if( $conn === false ) {
      die( print_r( sqlsrv_errors(), true));
    }

	session_start();
	if($_SESSION['UserID'] == "")
	{
		echo "<script type=text/javascript>alert('Please Login!');window.location='index.php';</script>";
		exit();
	}

	if(!$_SESSION['Authorize'])
	{
		echo "<script type=text/javascript>alert('Only those involved!');javascript:history.back(1);</script>";
		exit();
	}


	$strSQL = "SELECT * FROM Cnt_User WHERE EmpUserID = '".$_SESSION['UserID']."' ";
	$objQuery = sqlsrv_query($conn, $strSQL);
	$objResult = sqlsrv_fetch_array($objQuery,SQLSRV_FETCH_ASSOC);


	if(isset($_POST['TrnNo_id'])) {
	$TrnNo_id = trim($_POST['TrnNo_id']);

	$sql = "UPDATE Cnt_TrnDetail SET Status = '3', UpdatedBy = 'CANTEEN', UpdatedDate = (GETDATE())  WHERE TrnNo IN ($TrnNo_id) ";
	$stmt = sqlsrv_query( $conn, $sql);
	echo $TrnNo_id;
	}

	sqlsrv_close($conn);
	*/
?>
