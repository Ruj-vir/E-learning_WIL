<html>
<head>
<title>Sending Email</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>

<?php
	foreach($_POST["CheckStaff"] as $ItemID){
		
	$stmt10 = "SELECT DISTINCT UpdateBy FROM ReqInfo WHERE (ReqNo=$ItemID) AND (ReqApprover='$SesUserID') AND (Status=3)";
	$query10 = sqlsrv_query($connRequest, $stmt10);
	while($result10 = sqlsrv_fetch_array($query10, SQLSRV_FETCH_ASSOC)){

	$stmt03 = "SELECT EmpUserID,EmpUserName,EmpUserSurname,EmpUserEmail FROM ReqUser WHERE (EmpUserID='".$result10["UpdateBy"]."')";
	$query03 = sqlsrv_query($connRequest, $stmt03);
	$result03 = sqlsrv_fetch_array($query03, SQLSRV_FETCH_ASSOC);
	$leader = $result03["EmpUserName"]."\n".$result03["EmpUserSurname"];
	$Email = $result03["EmpUserEmail"];

	$Queryer11 = "SELECT ReqDate,TrnTime,ReqDay,ReqHour,ReqSumTime,ReqRemark FROM ReqInfo 
	WHERE (ReqNo = $ItemID) AND (Status = 3)";
	$objQueryer11 = sqlsrv_query($connRequest, $Queryer11);
	$objResulty11 = sqlsrv_fetch_array($objQueryer11, SQLSRV_FETCH_ASSOC);

	ini_set("SMTP","203.146.237.138");
	//ini_set("SMTP","203.150.7.197");
	//ini_set("SMTP","onerelay.one.th");
	ini_set("port","25"); //587	//465

	$itsystem = "https://www.thaidaizo.com/main/e-smart/";
	$strTo = $Email;//"s-surachet@thaidaizo.com";//
	$strSubject = "Request for Approval.";
	//$strHeader .= "MIME-Version: 1.0' . \r\n";
	//$strHeader = "Content-type: text/html; charset=windows-874\r\n";
	//$strHeader .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$strHeader = "Content-type: text/html; charset=utf-8\r\n";
	$strHeader .= "From: E-EDUCATION REQUEST SYSTEM<it-th@thaidaizo.com>\r\nReply-To: it-th@thaidaizo.com";

    $strLeader = $leader;
	$strItemCourse = $objResulty11["ReqRemark"];
    $inputDateFrom = date_format($objResulty11["ReqDate"], 'd M. Y');
	$inputDateTo = date_format($objResulty11["TrnTime"], 'd M. Y');
	$inputTimeFrom = date_format($objResulty11["ReqDate"], 'H:i');
	$inputTimeTo = date_format($objResulty11["TrnTime"], 'H:i');

	$strItemDate = $inputDateFrom." - ".$inputDateTo;
	$strItemTime = $inputTimeFrom." - ".$inputTimeTo;
	$strItemHrs = round($objResulty11["ReqDay"], 2)."Day, ".round($objResulty11["ReqHour"], 2)."Hrs";

	$strMessage = "
	<span style='font-size: 20px;'>เรียน/<span style='font-size: 14px;'>Dear</span> คุณ/<span style='font-size: 14px;'>K</span>: <b><span style='font-size: 18px;'>".$strLeader."</span></b></span><br/><br/>

	<div line-height: 4px;>
		<div style='font-size: 20px;'>เนื่องด้วยผู้ใต้บังคับบัญชาของท่าน ได้ทำการร้องขอการฝึกอบรม ตามรายละเอียด ดังนี้</div>
		<div style='font-size: 16px;'>AS your subordinate has requested for Training as below.</div>
	</div>
	<br/>

		<table style='width: 100%;'cellspacing='0' cellpadding='0'>

		   <tr style='height: 40px; font-size: 18px; color: #343a40; background-color: #1de9b6; '>
            <td><div align='center'><strong>หลักสูตร </strong><span style='font-size: 14px;'>(Course)</span></div></td>
			<td><div align='center'><strong>วันที่ </strong><span style='font-size: 14px;'>(Date)</span></div></td>
			<td><div align='center'><strong>เวลา </strong><span style='font-size: 14px;'>(Time)</span></div></td>
            <td><div align='center'><strong>รวมเวลา </strong><span style='font-size: 14px;'>(Duration)</span></div></td>
           </tr>

		   <tr style='height: 40px; font-size: 16px;'>
            <td style='border-left: thin solid #1de9b6; border-bottom: thin solid #1de9b6; text-align: center;'>".$strItemCourse."</td>
			<td style='border-bottom: thin solid #1de9b6; text-align: center;'>".$strItemDate."</td>
			<td style='border-bottom: thin solid #1de9b6; text-align: center;'>".$strItemTime."</td>
            <td style='border-right: thin solid #1de9b6; border-bottom: thin solid #1de9b6; text-align: center;'>".$strItemHrs."</td>
           </tr>

		</table>

		<br/><br/><span style='font-size: 20px;'>รายชื่อพนักงาน/<span style='font-size: 16px;'>List name</span></span>

		<table style='width: 100%;'cellspacing='0' cellpadding='0'>

		   <tr style='height: 40px; font-size: 18px; color: #343a40; background-color: #1de9b6; '>
            <td><div align='center'><span style='font-size: 14px;'>No.</span></div></td>
            <td><div align=''><strong>รหัส </strong><span style='font-size: 14px;'>(ID)</span></div></td>
            <td><strong>ชื่อ-สกุล </strong><span style='font-size: 14px;'>(Name-Surname)</span></td>
            <td><div align='center'><strong>สถานะ </strong><span style='font-size: 14px;'>(Status)</span></div></td>
		   </tr>";

		   $Queryer12 = "SELECT EmployeeID FROM ReqInfo WHERE (ReqNo=$ItemID) AND (ReqApprover='$SesUserID') AND (UpdateBy='".$result10["UpdateBy"]."') AND (Status=3)";
		   $objQueryer12 = sqlsrv_query($connRequest, $Queryer12);
		   $i = 1;
		   while($objResulty12 = sqlsrv_fetch_array($objQueryer12, SQLSRV_FETCH_ASSOC)){

		   $Queryer16 = "SELECT EmpUserID,EmpUserName,EmpUserSurname FROM ReqUser WHERE (EmpUserID='".$objResulty12["EmployeeID"]."') ";
		   $objQueryer16 = sqlsrv_query($connRequest, $Queryer16);
		   $objResulty16 = sqlsrv_fetch_array($objQueryer16,SQLSRV_FETCH_ASSOC);

		   $OtEmpID_R2 = $objResulty16["EmpUserID"];
		   $OtEmployee = $objResulty16["EmpUserName"]."\n".$objResulty16["EmpUserSurname"];

$strMessage .= "<tr style='height: 40px; font-size: 16px;'>
            <td style='border-left: thin solid #1de9b6; border-bottom: thin solid #1de9b6; text-align: center;'><b>".$i."."."</b></td>
            <td style='border-bottom: thin solid #1de9b6;'>".$OtEmpID_R2."</td>
            <td style='border-bottom: thin solid #1de9b6;'>".$OtEmployee."</td>
            <td style='border-right: thin solid #1de9b6; border-bottom: thin solid #1de9b6; text-align: center;'><b>ตรวจสอบแล้ว</b> <span style='font-size: 14px;'>(Verified)</span></td>
           </tr>";
		   $i++;
           }

$strMessage .= "</table>

	<br/><br/>
	<div line-height: 4px;>
	<div style='font-size: 20px;'>ขอความกรุณาดำเนินการเพื่อตรวจสอบคำร้องดังกล่าว</div>
	<div style='font-size: 18px;'>Please check the requisition as <a href = ".$itsystem."><span style='color: #3d5afe; text-decoration: underline;'><b>Click here..</b></span></a>
	</div>
	</div>


	<br/><br/>
	<div line-height: 4px;>
	<div style='font-size: 20px;'><b>เรียนมาเพื่อดำเนินการ</b></div>
	<div style='font-size: 18px;'><b>Best Regards.</b></div>
	</div>

	<br/>
    <hr align='left' style='width: 100%;'>
    <hr align='left' style='width: 100%;'>
	<br/><br/>";

	$flgSend = @mail($strTo,$strSubject,$strMessage,$strHeader);  // @ = No Show Error // #3D5AFE
}}
	if($flgSend){
		echo 1;
		//echo "Email Sending.";
		echo "<script type=text/javascript>window.top.window.TrainingResult('1');</script>";
		exit();
	}else{
		//echo "Email Can Not Send.";
		echo "<script type=text/javascript>alert('Error!! Email Can Not Send.');window.top.window.TrainingResult('0');</script>";
		exit();
    }


?>

</body>
</html>
