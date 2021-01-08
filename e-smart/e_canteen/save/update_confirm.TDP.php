<?php
	session_start();
	ini_set('display_errors', 1);
	error_reporting(~0);
	include ("../database/conn_canteen.php");
	include ("alert-admin.php");

	if(isset($_POST['TrnNo_id'])) {
	$TrnNo_id = trim($_POST['TrnNo_id']);
	$sql = "UPDATE Cnt_TrnDetail SET Status = 3, UpdatedBy = '".$_SESSION["UserID_OT"]."', UpdatedDate = GETDATE()  WHERE TrnNo IN ($TrnNo_id) ";
	$stmt = sqlsrv_query($conn, $sql);
	echo $TrnNo_id;
	exit();
	}

	if(isset($_POST['cancel'])) {
			//for($i=0;$i<count($_POST["TrnNo"]);$i++) {
			foreach($_POST["TrnNo01"] as $i){
				$sql00 = "UPDATE Cnt_TrnDetail SET Status = 0, UpdatedBy = '".$_SESSION["UserID_OT"]."', UpdatedDate = GETDATE()  WHERE (TrnNo = '".$i."')";
				$stmt00 = sqlsrv_query($conn, $sql00);
			}
			if($stmt00 === false) {
					echo "<script type=text/javascript>alert('Unsuccessful updated!');javascript:history.back(1);</script>";
					exit();
			}else{
					echo "<script type=text/javascript>javascript:history.back(1);</script>";
					exit();
			}
	}

	sqlsrv_close($conn);
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
