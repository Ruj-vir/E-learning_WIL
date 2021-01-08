<?php
    include "../alert/alert_session.php";
    include "../../database/conn_sqlsrv.php";
    //include "../database/conn_mysql.php";
    include "../alert/alert_user.php";
    include "../alert/data_detail.php";

  if(!filter_var($_POST['inputConfirmEmail'],FILTER_VALIDATE_EMAIL)){
	   echo "<script type=text/javascript>alert('Unsuccessful error!');javascript:history.back(1);</script>";
	   //exit();
	   return false;
  }
  
  if(isset($_POST["inputConfirmEmail"])) {

	$NewMail = strip_tags(htmlspecialchars($_POST['inputConfirmEmail']));
	$UserMail = strip_tags(htmlspecialchars($SesUserID));
	
	$sql = "UPDATE ReqUser SET EmpUserEmail = ?, UpdateBy = ?, UpdateDate = GETDATE() WHERE (EmpUserID = ?) ";
	$params = array($NewMail, $UserMail, $UserMail);
	$stmt = sqlsrv_query($connRequest, $sql, $params);
	
	
	if( $stmt === false ) {
		//echo "<script type=text/javascript>alert('Unsuccessful error!');javascript:history.back(1);</script>";
		echo "<script type=text/javascript>alert('Unsuccessful error!');window.top.window.ProfileResult('0');</script>";
		exit();
	}
	else{
		//echo "<script type=text/javascript>alert('Successfully updated');javascript:history.back(1);</script>";
		echo "<script type=text/javascript>alert('Successfully updated');window.top.window.ProfileResult('1');</script>";
		exit();
	}

  }
  sqlsrv_close($connRequest);
?>
