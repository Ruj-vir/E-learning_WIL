<?php
include "alert/alert_session.php";
include "../database/conn_sqlsrv.php";
//include "../database/conn_odbc.php";
//include "../../database/conn_mysql.php";
include "alert/alert_user.php";
include "alert/data_detail.php";

//include "alert/alert_authority.php";

if (!isset($_REQUEST['html'])) {
    $_REQUEST['html'] = '';
}

if (isset($_GET["ItemReqNo"]) && trim($_GET["ItemReqNo"]) != NULL) {

    $str = trim($_GET["ItemReqNo"]);
    //$FineDataEmp = addslashes($str);
    $vowels = array("'");
    $ItemReqNo = str_replace($vowels, '', $str);

    $AuthenReq = $resultSQL['Authentication'];
    $Arr_Access = array("6","9");
    
    if(in_array($AuthenReq, $Arr_Access)){

    $ListSql = "SELECT 
    dbo.ReqInfo.ReqNo, 
    -- dbo.ReqInfo.ReqDate, 
    -- dbo.ReqInfo.TrnTime, 
    dbo.ReqInfo.ReqDay, 
    dbo.ReqInfo.ReqHour, 
    dbo.ReqInfo.ReqRemark, 
    dbo.ReqInfo.UserDefine1, 

    EducationSystem.dbo.TrainRecHdr.TrainRecType, 
    EducationSystem.dbo.TrainRecHdr.TrainRecEvl, 
    EducationSystem.dbo.TrainRecHdr.TrainRecDateFrom, 
    EducationSystem.dbo.TrainRecHdr.TrainRecDateTo, 
    EducationSystem.dbo.TrainRecHdr.TrainRecTrainer, 
    EducationSystem.dbo.TrainRecHdr.TrainRecPlace, 
    EducationSystem.dbo.TrainRecHdr.TrainHdrStatus, 
    EducationSystem.dbo.TrainRecHdr.UpdateDate

    FROM EducationSystem.dbo.TrainRecHdr 
    INNER JOIN dbo.ReqInfo 
    ON EducationSystem.dbo.TrainRecHdr.TrainRecNo = dbo.ReqInfo.ReqNo
    WHERE (dbo.ReqInfo.ReqNo = '$ItemReqNo') 
    AND (dbo.ReqInfo.ReqType = 4) 
    AND (EducationSystem.dbo.TrainRecHdr.TrainHdrStatus = 3) ";

    }else {
        $ListSql = "SELECT 
        dbo.ReqInfo.ReqNo, 
        -- dbo.ReqInfo.ReqDate, 
        -- dbo.ReqInfo.TrnTime, 
        dbo.ReqInfo.ReqDay, 
        dbo.ReqInfo.ReqHour, 
        dbo.ReqInfo.ReqRemark, 
        dbo.ReqInfo.UserDefine1, 
    
        EducationSystem.dbo.TrainRecHdr.TrainRecType, 
        EducationSystem.dbo.TrainRecHdr.TrainRecEvl, 
        EducationSystem.dbo.TrainRecHdr.TrainRecDateFrom, 
        EducationSystem.dbo.TrainRecHdr.TrainRecDateTo, 
        EducationSystem.dbo.TrainRecHdr.TrainRecTrainer, 
        EducationSystem.dbo.TrainRecHdr.TrainRecPlace, 
        EducationSystem.dbo.TrainRecHdr.TrainHdrStatus, 
        EducationSystem.dbo.TrainRecHdr.UpdateDate
    
        FROM EducationSystem.dbo.TrainRecHdr 
        INNER JOIN dbo.ReqInfo 
        ON EducationSystem.dbo.TrainRecHdr.TrainRecNo = dbo.ReqInfo.ReqNo
        WHERE (dbo.ReqInfo.ReqNo = '$ItemReqNo') 
        AND (dbo.ReqInfo.ReqIssuer = '$SesUserID')
        AND (dbo.ReqInfo.ReqType = 4) 
        AND (EducationSystem.dbo.TrainRecHdr.TrainHdrStatus = 3) ";
    }

    $ListIParams = array();
    $ListIOptions =  array("Scrollable" => SQLSRV_CURSOR_KEYSET);
    $ListIStmt = sqlsrv_query($connRequest, $ListSql, $ListIParams, $ListIOptions);
    $ListIRow = sqlsrv_num_rows($ListIStmt);

    if ($ListIRow > 0) {
        //$iScore = 1;
        $ListObj = sqlsrv_query($connRequest, $ListSql);
        $ListResult = sqlsrv_fetch_array($ListObj, SQLSRV_FETCH_ASSOC);
        $EleData = explode('|', $ListResult["UserDefine1"]);
    } else {
        echo "<script>window.close();</script>";
        exit();
    }

} else {
    echo "<script>window.close();</script>";
    exit();
}




$html = '
<html>
<head>
<style>
body {font-family: THSarabun;
	font-size: 10pt;
}
p {	margin: 0pt; }
table.items {
	border: 0.1mm solid #000000;
}
td { vertical-align: top; }
.items td {
	/*border-left: 0.1mm solid #000000;
    border-right: 0.1mm solid #000000;*/
    border: 0.1mm solid #000000;
}
table thead td { background-color: #EEEEEE;
	text-align: center;
	border: 0.1mm solid #000000;
	font-variant: small-caps;
}
.items td.blanktotal {
	background-color: #EEEEEE;
	border: 0.1mm solid #000000;
	background-color: #FFFFFF;
	border: 0mm none #000000;
	border-top: 0.1mm solid #000000;
	border-right: 0.1mm solid #000000;
}
.items td.totals {
	text-align: right;
	border: 0.1mm solid #000000;
}
.items td.cost {
	text-align: "." center;
}

.font-topic {
    font-size: 8pt;
}
.font-topic-bold {
    font-weight: bold;
}

</style>
</head>
<body>

<!--mpdf
<htmlpageheader name="myheader">
<table width="100%">
<tr>
<td width="5%">
    <img src="assets/img/icon/DAIZO_Bk.jpg" alt="" width="80" height="38">
</td>
<td width="45%" style="padding: 0px 0px 0px 5px; color:#000000; ">
    <div>บริษัท ไทย ไดโซ แอโรโซล จำกัด</div>
    <div>Thai Daizo Aerosol Co., Ltd.</div>
</td>
<td width="50%" style="text-align: right;">
    <!--<div>Request No.</div>
    <div><strong></strong></div>-->
    {PAGENO} of {nb}
</td>
</tr>
</table>

<table style="padding: 14px 0px 7px 0px;" width="100%">
<tr>
    <td style="text-align: center; font-weight: bold; font-size: 12pt; text-transform: uppercase;">
    <span>รายชื่อผู้เข้าร่วมฝึกอบรม</span>
    <div style="font-weight: normal;">(Training Attendance)</div>
    </td>
</tr>
</table>

<table width="100%">
<tr>
    <td width="200" class="font-topic-bold">ชื่อหลักสูตร/<span class="font-topic">COURSE NAME :</span></td>
    <td>' . $ListResult["ReqRemark"] . '</td>
</tr>
<tr>
    <td width="200" class="font-topic-bold">วันที่/<span class="font-topic">DATE</span> :</td>
    <td>'.date_format($ListResult["TrainRecDateFrom"], 'd F Y') . " - " . date_format($ListResult["TrainRecDateTo"], 'd F Y').'</td>
</tr>
<tr>
    <td width="200" class="font-topic-bold">เวลา/<span class="font-topic">TIME</span> :</td>
    <td>'.date_format($ListResult["TrainRecDateFrom"], 'H:i') . " - " . date_format($ListResult["TrainRecDateTo"], 'H:i').'</td>
</tr>
<tr>
    <td width="200" class="font-topic-bold">ผู้อบรม/<span class="font-topic">TRAINER</span> :</td>
    <td>' . $ListResult["TrainRecTrainer"] . '</td>
</tr>
<tr>
    <td width="200" class="font-topic-bold">สถานที่อบรม/<span class="font-topic">TRAINING PLACE</span> :</td>
    <td>' . $EleData[3] . '</td>
</tr>

<tr>
    <td width="200" class="font-topic-bold">ประเภทการฝึกอบรม/<span class="font-topic">TYPE OF TRAINING</span> :</td>
    <td>
    <input type="radio" name="TypeTraining" value="1" '.(($ListResult["TrainRecType"] == 1) ? 'checked="checked"' : "").' > Orientation &nbsp;&nbsp;&nbsp;
    <input type="radio" name="TypeTraining" value="2" '.(($ListResult["TrainRecType"] == 2) ? 'checked="checked"' : "").' > OJT &nbsp;&nbsp;&nbsp;
    <input type="radio" name="TypeTraining" value="3" '.(($ListResult["TrainRecType"] == 3) ? 'checked="checked"' : "").' > Reskill<!--Refreshing--> &nbsp;&nbsp;&nbsp;
    <input type="radio" name="TypeTraining" value="4" '.(($ListResult["TrainRecType"] == 4) ? 'checked="checked"' : "").' > Upskill<!--On going--> &nbsp;&nbsp;&nbsp;
    <input type="radio" name="TypeTraining" value="5" '.(($ListResult["TrainRecType"] == 5) ? 'checked="checked"' : "").' > Public &nbsp;&nbsp;&nbsp;
    <input type="radio" name="TypeTraining" value="6" '.(($ListResult["TrainRecType"] == 6) ? 'checked="checked"' : "").' > Other
    </td>
</tr>
<tr>
    <td width="200" class="font-topic-bold">วิธีการประเมินผล/<span class="font-topic">EVALUATION</span> :</td>
    <td>
    <input type="radio" name="EvalutionTraining" value="1" '.(($ListResult["TrainRecEvl"] == 1) ? 'checked="checked"' : "").' > ทดสอบภาคปฎิบัติ/Work Shop  &nbsp;&nbsp;&nbsp;&nbsp;
    <input type="radio" name="EvalutionTraining" value="2" '.(($ListResult["TrainRecEvl"] == 2) ? 'checked="checked"' : "").' > ทดสอบภาคทฤษฎี/Theory &nbsp;&nbsp;&nbsp;&nbsp;
    <input type="radio" name="EvalutionTraining" value="3" '.(($ListResult["TrainRecEvl"] == 3) ? 'checked="checked"' : "").' > อื่นๆ/Other
</tr>

</table>
</htmlpageheader>

<htmlpagefooter name="myfooter">
<table width="100%" style="vertical-align: bottom; padding-top: 2mm; border-top: 0.1mm solid #000000;"><tr>
<td width="50%">
TRAINER SIGNATURE: ' . $ListResult["TrainRecTrainer"] . '
<div>DATE: '.date_format($ListResult["UpdateDate"], 'd/m/Y').'</div>
</td>
<td width="50%" style="font-size: 9pt; text-align: right;">
FM-N017Q : Rev.08, 1 Jan. 2021
</td>
</tr></table>
<!--<div style="border-top: 0px solid #000000; font-size: 9pt; text-align: right; padding-top: 1mm; ">-->
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->


<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
<thead>
<tr>
<td width="5%">ที่<div>No.</div></td>
<td width="11%">รหัส<div>ID CODE</div></td>
<td width="35%">ชื่อ/สกุล<div>NAME/LAST NAME</div></td>
<td width="10%">ตำแหน่ง<div>POSITION</div></td>
<td width="15%">แผนก<div>SECTION/DPT.</div></td>
<td width="8%">คะแนน<div>SCORE</div></td>
<td width="8%">ผลการ<div>ประเมิน</div><div>RESULT</div></td>
<td width="10%">หมายเหตุ<div>REMARK</div></td>
</tr>
</thead>
<tbody>
<!-- ITEMS HERE -->';

// $EmpReqSql = "SELECT 
// dbo.ReqUser.EmpUserID, 
// dbo.ReqUser.EmpUserName, 
// dbo.ReqUser.EmpUserSurname,
// dbo.ReqUser.EmpUserPosition, 
// dbo.ReqUser.EmpUserSection, 
// dbo.ReqUser.EmpUserDepartment
// FROM dbo.ReqUser 
// INNER JOIN dbo.ReqInfo 
// ON dbo.ReqUser.EmpUserID = dbo.ReqInfo.EmployeeID
// WHERE (dbo.ReqInfo.ReqNo = '$ItemReqNo') 
// AND (dbo.ReqInfo.ReqType = 4) 
// AND (dbo.ReqInfo.Status = 9)";
// $iEmpReqNum = 1;
// $EmpReqObj = sqlsrv_query($connRequest, $EmpReqSql);
// while($EmpReqResult = sqlsrv_fetch_array($EmpReqObj, SQLSRV_FETCH_ASSOC)) {

//     $EmpUserID = $EmpReqResult["EmpUserID"];
//     $EmpDtlSql = "SELECT  
//     TrainRecScore, 
//     TrainRecResult
//     FROM TrainRecDtl 
//     WHERE (TrainRecNo = '$ItemReqNo') 
//     AND (EmployeeID = '$EmpUserID')
//     AND (TrainDtlStatus = 6)";
//     $EmpDtlObj = sqlsrv_query($connEducation, $EmpDtlSql);
//     $EmpDtlResult = sqlsrv_fetch_array($EmpDtlObj, SQLSRV_FETCH_ASSOC);
$EmpReqSql = "SELECT DISTINCT 
dbo.ReqUser.EmpUserID, 
dbo.ReqUser.EmpUserName, 
dbo.ReqUser.EmpUserSurname, 
dbo.ReqUser.EmpUserPosition, 
dbo.ReqUser.EmpUserSection, 
dbo.ReqUser.EmpUserDepartment, 

EducationSystem.dbo.TrainRecDtl.TrainRecNo, 
EducationSystem.dbo.TrainRecDtl.TrainRecScore, 
EducationSystem.dbo.TrainRecDtl.TrainRecResult

FROM EducationSystem.dbo.TrainRecDtl 
INNER JOIN dbo.ReqUser 
ON EducationSystem.dbo.TrainRecDtl.EmployeeID = dbo.ReqUser.EmpUserID
WHERE (EducationSystem.dbo.TrainRecDtl.TrainDtlStatus = 6)
AND (EducationSystem.dbo.TrainRecDtl.TrainRecNo = '$ItemReqNo') ";

$iEmpReqNum = 1;
$EmpReqObj = sqlsrv_query($connRequest, $EmpReqSql);
while($EmpReqResult = sqlsrv_fetch_array($EmpReqObj, SQLSRV_FETCH_ASSOC)) {
    
$html .= '
<tr style="font-size: 10pt; text-transform: uppercase;">
<td align="center">'.$iEmpReqNum++.'</td>
<td align="center">'.$EmpReqResult["EmpUserID"].'</td>
<td>'.$EmpReqResult["EmpUserName"]."\n".$EmpReqResult["EmpUserSurname"].'</td>
<td align="center">'.$EmpReqResult["EmpUserPosition"].'</td>
<td align="center">'.$EmpReqResult["EmpUserSection"].'</td>
<td align="center">'.round($EmpReqResult["TrainRecScore"], 2) .'</td>
<td align="center">'.(($EmpReqResult["TrainRecResult"] == 1) ? "PASS" : "FAIL" ).'</td>
<td align="center">'.(($EmpReqResult["TrainRecResult"] == NULL) ? "ไม่มา" : "" ).'</td>
</tr>';

}

//for ($i = $iEmpReqNum; $i <= 40; $i++) {
    $html .= '
    <!--<tr>
    <td align="center"></td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    </tr>-->';
//}

$html .= '
<!-- END ITEMS HERE -->

<!--
<tr>
<td class="blanktotal" colspan="3" rowspan="6"></td>
<td class="totals">Subtotal:</td>
<td class="totals cost">&pound;1825.60</td>
</tr>
<tr>
<td class="totals">Tax:</td>
<td class="totals cost">&pound;18.25</td>
</tr>
<tr>
<td class="totals">Shipping:</td>
<td class="totals cost">&pound;42.56</td>
</tr>
<tr>
<td class="totals"><b>TOTAL:</b></td>
<td class="totals cost"><b>&pound;1882.56</b></td>
</tr>
<tr>
<td class="totals">Deposit:</td>
<td class="totals cost">&pound;100.00</td>
</tr>
<tr>
<td class="totals"><b>Balance due:</b></td>
<td class="totals cost"><b>&pound;1782.56</b></td>
</tr>
-->

</tbody>
</table>

<!--<div style="text-align: center; font-style: italic;">Payment terms: payment due in 30 days</div>-->

</body>
</html>
';

require_once 'assets/MPDF/vendor/autoload.php';

$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4',
    'margin_left' => 7,
    'margin_right' => 7,
    'margin_top' => 80,
    'margin_bottom' => 20,
    'margin_header' => 7,
    'margin_footer' => 7,
    'customProperties' => [
		'IT Section' => 'E-LEARNING',
		'IT Section' => 'TRAINING ATTENDANCE',
	],
    'fontDir' => array_merge($fontDirs, [__DIR__]),
    'fontdata' => $fontData + ['THSarabun' => [
        'R' => 'assets/font-standard/fonts/Sarabun-Regular.ttf',
    ]],
    'default_font' => 'THSarabun'
]);

$mpdf->autoScriptToLang = true;
$mpdf->baseScript = 1;
$mpdf->autoVietnamese = true;
$mpdf->autoArabic = true;
$mpdf->autoLangToFont = true;


// $mpdf->SetProtection(array('print'));
$mpdf->SetTitle("E-Learning - Training attendance");
$mpdf->SetAuthor("TRAINING ATTENDANCE");
// $mpdf->SetWatermarkText("E-Learning");
$mpdf->showWatermarkText = true;
$mpdf->watermark_font = 'DejaVuSansCondensed';
$mpdf->watermarkTextAlpha = 0.1;

$mpdf->SetDisplayMode('fullpage');

if (isset($_REQUEST['html']) && $_REQUEST['html']) {
    echo $html;
    exit;
}

$mpdf->WriteHTML($html);

//$mpdf->AddCustomProperty('rewritten_property', 'rewritten_value');
//$mpdf->AddCustomProperty('property3', 'value of property 3');
//$mpdf->setProtection([]);
$mpdf->SetProtection(array('copy','print'), '', 'Tda@it');

$mpdf->Output('E-Learning - Training attendance.pdf', \Mpdf\Output\Destination::INLINE);
die;