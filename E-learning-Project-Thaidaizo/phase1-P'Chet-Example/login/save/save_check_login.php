<?php
    include "../alert/alert_session.php";
	include ("../../../database/conn_sqlsrv.php");
	
if(isset($_POST["inputUsername"], $_POST["inputPassword"])) {

	$User = strip_tags(htmlspecialchars($_POST['inputUsername']));
	$Pass = strip_tags(htmlspecialchars($_POST['inputPassword']));
	

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
	
		if(!$objResult) {
				echo 101;
				exit();
		}else {
				$_SESSION["UserID@Learning"] = $objResult["EmpUserID"];
				$_SESSION["Authorize@Learning"] = $objResult["Authentication"];
				$_SESSION["Status@Learning"] = $objResult["Status"];

				session_write_close();

				if ($objResult["Authentication"] != "" AND $objResult["Status"] == "1"){
					echo 500;
					exit();
				}
				else {
					echo 102;
					exit();
				}
		}
	
	}else {
		echo 103;
		exit();
	}
	
}
	sqlsrv_close($connRequest);
?>
