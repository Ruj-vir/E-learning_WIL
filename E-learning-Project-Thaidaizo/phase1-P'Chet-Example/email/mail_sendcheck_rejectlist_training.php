
<html>
<head>
<title>Sending Email</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>

<?php
	foreach($_POST["listStaff1"] as $EmpReq){

	}
    $Queryer12 = "SELECT DISTINCT ReqIssuer FROM ReqInfo 
	WHERE (ReqNo=$EmpReq) 
	AND (ReqChecker='$SesUserID') 
	AND (ReqCheckDate IS NOT NULL)
	AND (ReqType = 4) 
	AND (Status=0)";
    $objQueryer12 = sqlsrv_query($connRequest, $Queryer12);
    while($objResulty12 = sqlsrv_fetch_array($objQueryer12,SQLSRV_FETCH_ASSOC)){

		//!
		$sql = "SELECT EmployeeID,ReqFleg FROM ReqInfo 
		WHERE (ReqNo=$EmpReq) 
		AND (ReqIssuer='".$objResulty12["ReqIssuer"]."') 
		AND (ReqChecker='$SesUserID') 
		AND (ReqCheckDate IS NOT NULL)
		AND (ReqType = 4) 
		AND (Status = 0)";
		$oop = sqlsrv_query($connRequest, $sql);
		while($CR = sqlsrv_fetch_array($oop, SQLSRV_FETCH_ASSOC)){

			$Fleg = $CR["ReqFleg"];
			$EmpID = $CR["EmployeeID"];

			if(trim($Fleg) == NULL){
				$InputFleg = 'C1';
			}else{
				$vowels = array("C");
				$CutFleg = str_replace($vowels,"", $Fleg);
				$SumFleg = $CutFleg + 1;
				$InputFleg = 'C'.$SumFleg;
			}

			$str = "UPDATE ReqInfo SET ReqFleg = '$InputFleg' WHERE (ReqNo = $EmpReq) AND (EmployeeID = $EmpID)";
			$obj = sqlsrv_query($connRequest, $str);
			if( $obj === false ) {
				echo "<script>alert('Error!! ReqFleg.');window.top.window.TrainingResult('0');</script>";
				exit();
			}

		}

    $Queryer14 = "SELECT EmpUserName,EmpUserSurname,EmpUserEmail FROM ReqUser WHERE (EmpUserID='".$objResulty12["ReqIssuer"]."') ";
    $objQueryer14 = sqlsrv_query($connRequest, $Queryer14);
    $objResulty14 = sqlsrv_fetch_array($objQueryer14,SQLSRV_FETCH_ASSOC);
    $leader = $objResulty14["EmpUserName"]."\n".$objResulty14["EmpUserSurname"];
	$Email_Reject = $objResulty14["EmpUserEmail"];

	$Queryer11 = "SELECT ReqDate,TrnTime,ReqDay,ReqHour,ReqSumTime,ReqRemark FROM ReqInfo 
	WHERE (ReqNo = $EmpReq) AND (ReqChecker='$SesUserID') AND (Status=0)";
	$objQueryer11 = sqlsrv_query($connRequest, $Queryer11);
	$objResulty11 = sqlsrv_fetch_array($objQueryer11, SQLSRV_FETCH_ASSOC);


	//ini_set("SMTP","203.146.237.138");
	//ini_set("SMTP","203.150.7.197");
	ini_set("SMTP","onerelay.one.th");
	ini_set("port","25"); //587	//465

	//$itsystem = "http://192.168.1.11/prinfo/request_OT";
	$strTo = $Email_Reject;//"s-surachet@thaidaizo.com";//
	$strSubject = "Reject a request to requester (from Check).";
	//$strHeader .= "MIME-Version: 1.0' . \r\n";
	//$strHeader = "Content-type: text/html; charset=windows-874\r\n";
	//$strHeader .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$strHeader = "Content-type: text/html; charset=utf-8\r\n";
	$strHeader .= "From: E-LEARNING REQUEST SYSTEM<it-th@thaidaizo.com>\r\nReply-To: it-th@thaidaizo.com";

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
		<div style='font-size: 20px;'>เนื่องด้วยผู้บังคับบัญชาของท่าน ได้<span style='color: #ff1744; text-decoration: underline;'>ปฏิเสธ</span>ได้ทำการร้องขอการฝึกอบรม ตามรายละเอียด ดังนี้</div>
		<div style='font-size: 16px;'>AS your commander has rejected for Training as below.</div>
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

		   if($obj){
            $Queryer6 = "SELECT EmployeeID FROM ReqInfo 
			WHERE (ReqNo=$EmpReq) 
			AND (ReqChecker = '$SesUserID') 
			AND (ReqCheckDate IS NOT NULL)
			AND (ReqIssuer = '".$objResulty12["ReqIssuer"]."') 
			AND (ReqType = 4) 
			AND (ReqFleg = 'C1') 
			AND (Status = 0)";
			$objQueryer6 = sqlsrv_query($connRequest, $Queryer6);
			$i = 1;
            while($objResulty6 = sqlsrv_fetch_array($objQueryer6,SQLSRV_FETCH_ASSOC)){

            $Queryer16 = "SELECT EmpUserID,EmpUserName,EmpUserSurname FROM ReqUser WHERE (EmpUserID='".$objResulty6["EmployeeID"]."') ";
            $objQueryer16 = sqlsrv_query($connRequest, $Queryer16);
            $objResulty16 = sqlsrv_fetch_array($objQueryer16,SQLSRV_FETCH_ASSOC);

            $OtEmpID_R2 = $objResulty16["EmpUserID"];
            $OtEmployee = $objResulty16["EmpUserName"]."\n".$objResulty16["EmpUserSurname"];

$strMessage .= "<tr style='height: 40px; font-size: 16px;'>
            <td style='border-left: thin solid #1de9b6; border-bottom: thin solid #1de9b6; text-align: center;'><b>".$i."."."</b></td>
            <td style='border-bottom: thin solid #1de9b6;'>".$OtEmpID_R2."</td>
            <td style='border-bottom: thin solid #1de9b6;'>".$OtEmployee."</td>
            <td style='border-right: thin solid #1de9b6; border-bottom: thin solid #1de9b6; text-align: center;'><span style='color: #ff1744;'><b>ไม่อนุมัติ</b> <span style='font-size: 14px;'>(Rejected)</span></span></td>
		   </tr>";
		   $i++;
           }}

$strMessage .= "</table>

	<br/><br/>
	<div line-height: 4px;>
	<div style='font-size: 20px;'><b>เรียนมาเพื่อทราบ</b></div>
	<div style='font-size: 18px;'><b>Best Regards.</b></div>
	</div>

    <br/>
    <hr align='left' style='width: 100%;'>
    <hr align='left' style='width: 100%;'>
    <br/><br/>";

	$flgSend = @mail($strTo,$strSubject,$strMessage,$strHeader);  // @ = No Show Error // #3D5AFE
	}
	if($flgSend){
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