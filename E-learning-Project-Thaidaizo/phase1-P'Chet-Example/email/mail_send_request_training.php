<html>

<head>
    <title>Sending Email</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>

	<?php
	
	$stmt03 = "SELECT DISTINCT ReqChecker FROM ReqInfo WHERE (ReqNo = $KeyID)";
	$query03 = sqlsrv_query($connRequest, $stmt03);                             
	while($result03 = sqlsrv_fetch_array($query03, SQLSRV_FETCH_ASSOC)){
    $Checking = $result03["ReqChecker"];

	$stmt02 = "SELECT EmpUserID,EmpUserName,EmpUserSurname,EmpUserEmail FROM ReqUser WHERE (EmpUserID = $Checking)";
	$query02 = sqlsrv_query($connRequest, $stmt02);                              
	while ($result02 = sqlsrv_fetch_array($query02, SQLSRV_FETCH_ASSOC)){
	$leader = $result02["EmpUserName"]."\n".$result02["EmpUserSurname"];
	$Email = $result02["EmpUserEmail"];

	//ini_set("SMTP","203.146.237.138");
	//ini_set("SMTP","203.150.7.197");
	ini_set("SMTP","onerelay.one.th");
	ini_set("port","25"); //587	//465

	$itsystem = "https://www.thaidaizo.com/main/e-smart/";
	$strTo = $Email;//"s-surachet@thaidaizo.com";//
	$strSubject = "Request for Checking.";
	//$strHeader .= "MIME-Version: 1.0' . \r\n";
	//$strHeader = "Content-type: text/html; charset=windows-874\r\n";
	//$strHeader .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
	$strHeader = "Content-type: text/html; charset=utf-8\r\n";
	$strHeader .= "From: E-LEARNING REQUEST SYSTEM<it-th@thaidaizo.com>\r\nReply-To: it-th@thaidaizo.com";

    $strLeader = $leader;
	$strItemCourse = $inputCourse;
    $inputDateFrom = date("d M. Y",strtotime($inputDateFrom));
    $inputDateTo = date("d M. Y",strtotime($inputDateTo));
	$strItemDate = $inputDateFrom." - ".$inputDateTo;
	$strItemTime = $inputTimeFrom." - ".$inputTimeTo;
	$strItemHrs = $inputDurationDay."Day, ".$inputDurationTime ."Hrs";

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

		   $stmt04 = "SELECT EmployeeID FROM ReqInfo WHERE (ReqNo = $KeyID) AND (ReqChecker = $Checking)";
		   $query04 = sqlsrv_query($connRequest, $stmt04);
		   $i = 1;
		   while($result04 = sqlsrv_fetch_array($query04, SQLSRV_FETCH_ASSOC)){

			$Queryer14 = "SELECT TOP 1 EmpUserID,EmpUserName,EmpUserSurname FROM ReqUser WHERE (EmpUserID='".$result04["EmployeeID"]."') ";
			$objQueryer14 = sqlsrv_query($connRequest, $Queryer14);
			$objResulty14 = sqlsrv_fetch_array($objQueryer14,SQLSRV_FETCH_ASSOC);
		
			$OtEmpID_R2 = $objResulty14["EmpUserID"];
			$OtEmployee = $objResulty14["EmpUserName"]."\n".$objResulty14["EmpUserSurname"];

$strMessage .= "<tr style='height: 40px; font-size: 16px;'>
            <td style='border-left: thin solid #1de9b6; border-bottom: thin solid #1de9b6; text-align: center;'><b>".$i."."."</b></td>
            <td style='border-bottom: thin solid #1de9b6;'>".$OtEmpID_R2."</td>
            <td style='border-bottom: thin solid #1de9b6;'>".$OtEmployee."</td>
            <td style='border-right: thin solid #1de9b6; border-bottom: thin solid #1de9b6; text-align: center;'><b>รอดำเนินการ</b> <span style='font-size: 14px;'>(Pending)</span></td>
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

	$flgSend = @mail($strTo,$strSubject,$strMessage,$strHeader);
		}}
	if($flgSend){
        //alert('Successfully.');
		echo "<script type=text/javascript>window.top.window.TrainingResult('1');</script>";
		exit();
	}
	else{
		echo "<script type=text/javascript>alert('The request was sent, but the email destination was not found.');window.top.window.TrainingResult('1');</script>";
		exit();
	}
?>

</body>

</html>