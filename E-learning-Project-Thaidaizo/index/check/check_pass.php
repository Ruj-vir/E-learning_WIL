<?php
    include "../alert/alert_session.php";
    include "../../database/conn_sqlsrv.php";
    //include "../database/conn_mysql.php";
    include "../alert/alert_user.php";
    include "../alert/data_detail.php";
	

	if(isset($_POST['submit'])){
		
	$Username = strip_tags(htmlspecialchars($SesUserID));
	$passOld = strip_tags(htmlspecialchars($_POST['inputCurrent']));
	$passNew = strip_tags(htmlspecialchars($_POST['inputConfirmPassword']));
	
	$sql = "SELECT EmpUserID,EmpUserPassword,Authentication,Status FROM ReqUser WHERE EmpUserID = ? AND EmpUserPassword = ? COLLATE Latin1_General_CS_AS";
	$params = array($Username, $passOld);
	$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
	$stmt = sqlsrv_query( $connRequest, $sql , $params, $options );
	$row_count = sqlsrv_num_rows( $stmt );

	if($row_count > 0) {
	
		$strSQL = "SELECT EmpUserID,EmpUserPassword FROM ReqUser WHERE EmpUserID = ? AND EmpUserPassword = ? COLLATE Latin1_General_CS_AS";
		$parameters = [$Username, $passOld];
		$objQuery = sqlsrv_query($connRequest, $strSQL, $parameters);
		$objResult = sqlsrv_fetch_array($objQuery,SQLSRV_FETCH_ASSOC);

		if(!$objResult){
			//echo "<script type=text/javascript>alert('Incorrect password!');javascript:history.back(1);</script>";
			echo "<script type=text/javascript>alert('Incorrect password!');window.top.window.ProfileResult('0');</script>";
			exit();
		}else {
			//sql = "UPDATE ReqUser SET EmpUserPassword =  ?  WHERE EmpUserID = ? ";
			//$params = array($_POST['passnew'], $_POST["txtEmpID"]);
			//$stmt = sqlsrv_query( $connRequest, $sql, $params);

			$UpSql = "UPDATE ReqUser SET EmpUserPassword = ?, UpdateBy = ?, UpdateDate = GETDATE() WHERE EmpUserID = ? ";
			$UpParams = array($passNew, $Username, $Username);
			$UpStmt = sqlsrv_query($connRequest, $UpSql, $UpParams);
			
			if( $UpStmt === false ) {
				echo "<script type=text/javascript>alert('Unsuccessful error!');window.top.window.ProfileResult('0');</script>";
				exit();
			}else{
				echo "<script type=text/javascript>alert('Password changed successfully');window.top.window.ProfileResult('1');</script>";
				exit();
			}
		}
	
	}else {
		echo "<script type=text/javascript>alert('Unsuccessful error!');window.top.window.ProfileResult('0');</script>";
		exit();
	}
	
	}else {
		echo "<script type=text/javascript>alert('Unsuccessful error!');window.top.window.ProfileResult('0');</script>";
		exit();
	}
	
	sqlsrv_close($connRequest);
?>



<?php
/*
	include "connect.php";
	$strSQL = "select EmpUserID,EmpUserPassword from ReqUser where id = '".trim($_SESSION['id'])."'and pass = '".$_POST['passold']."'";
	$objQuery = mysql_query($strSQL);
	$objResult = mysql_fetch_array($objQuery);
	if(!$objResult){
		echo "<script>alert('Password เดิมไม่ถูกต้อง!')</script>";
		echo "<meta http-equiv='refresh' content='1; url=ChangePass.php'>";
	}else{
		$sql = "update member set pass = '".$_POST[passnew]."' where id = '".$_SESSION['id']."' ";
		$result = mysql_query($sql);
		echo "<script>alert('เปลี่ยน Password เสร็จเรียบร้อบ')</script>";
		echo "<meta http-equiv='refresh' content='1; url=Login.php'>";
	}
	mysql_close();
*/
?>
<?php
/*
	$oldpassword 	= trim($_POST["oldpassword"]);
	$password 		= trim($_POST["password"]);
	$repassword 	= trim($_POST["repassword"]);


	$sql = "select username from member where username='$username' and password='$oldpassword'";
	$result = mysql_query($sql);
	$num = mysql_num_rows($result);

	if ($num==0)
		die("<script>
				alert('Old password incorrect');
				history.back();
			 </script>");

	// 2.2 password = repassword
	if ($password != $repassword)
		die("<script>
				alert('Password is not same');
				history.back();
			 </script>");

	// 6. save data
	$password = md5($password);

	$sql = "update member set
			password='$password'
			where username='$username'
			";
	$result = mysql_query($sql) or die("Err : $sql");

	echo "<script>
			alert('Update Password');
			window.location='login.php';
		  </script>";
*/
?>
