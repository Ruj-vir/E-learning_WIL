<?php
    include "../alert/alert_session.php";
	include ("../../database/conn_sqlsrv.php");
	
	
if(isset($_POST["txtUsername"], $_POST["txtPassword"])) {

	$User = strip_tags(htmlspecialchars($_POST['txtUsername']));
	$Pass = strip_tags(htmlspecialchars($_POST['txtPassword']));
	

	$sql = "SELECT EmpUserID,EmpUserPassword,Authentication,Status FROM ReqUser WHERE EmpUserID = ? AND EmpUserPassword = ? COLLATE Latin1_General_CS_AS";
	$params = array($User, $Pass);
	$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
	$stmt = sqlsrv_query( $connRequest, $sql , $params, $options );
	$row_count = sqlsrv_num_rows( $stmt );

	if ($row_count > 0) {
	

	$strSQL = "SELECT EmpUserID,EmpUserPassword,Authentication,Status FROM ReqUser WHERE EmpUserID = ? AND EmpUserPassword = ? COLLATE Latin1_General_CS_AS";
	$parameters = [$User, $Pass];
	$objQuery = sqlsrv_query($connRequest, $strSQL, $parameters);
	$objResult = sqlsrv_fetch_array($objQuery,SQLSRV_FETCH_ASSOC);
	
	if(($objResult["EmpUserPassword"] == 'Tda'.$User) || $objResult["EmpUserPassword"] == 'tda'.$User) {
		echo "<script language=\"JavaScript\">window.top.window.showResult('2');</script>";
		exit();
	}else {

		if(!$objResult) {
				echo "<script language=\"JavaScript\">alert('Username and Password Incorrect!');</script>";
				exit();
		}else {
				$_SESSION["UserID_OT"] = $objResult["EmpUserID"];
				$_SESSION["Authorize_OT"] = $objResult["Authentication"];
				$_SESSION["Status_OT"] = $objResult["Status"];

				session_write_close();

				if ($objResult["Authentication"] != "" AND $objResult["Status"] == "1"){
					echo "<script language=\"JavaScript\">window.top.window.showResult('1');</script>";
					exit();
				}
				else {
					echo "<script language=\"JavaScript\">alert('Status disabled!');</script>";
					exit();
				}
		}
	
	}
	
	
	}else {
		echo "<script language=\"JavaScript\">alert('Username and Password Incorrect!');</script>";
		exit();
	}
	
}
	sqlsrv_close($connRequest);
?>
