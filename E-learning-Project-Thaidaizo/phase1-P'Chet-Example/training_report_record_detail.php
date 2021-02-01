<?php
include "alert/alert_session.php";
include "../database/conn_sqlsrv.php";
//include "../database/conn_odbc.php";
//include "../../database/conn_mysql.php";
include "alert/alert_user.php";
include "alert/data_detail.php";

include "alert/alert_authority.php";

if (!isset($_REQUEST['html'])) {
    $_REQUEST['html'] = '';
}

if (isset($_GET["BtPDF"]) == "PDF" && trim($_GET["FineID"]) != NULL && trim($_GET["EmpID"]) != NULL) {

    $str = trim($_GET["EmpID"]);
    //$FineDataEmp = addslashes($str);
    $vowels = array("'");
    $SearchID = str_replace($vowels, '', $str);

    $ListSql = "SELECT DISTINCT 
    dbo.ReqUser.EmpUserSection, 
    dbo.ReqUser.EmpUserName, 
    dbo.ReqUser.EmpUserSurname, 
    dbo.ReqUser.EmpUserPosition, 
    dbo.ReqUser.EmpUserDepartment, 
    dbo.ReqUser.LvApprove, 

    EducationSystem.dbo.TrainRecHdr.TrainRecName, 
    EducationSystem.dbo.TrainRecHdr.TrainRecDateFrom, 
    EducationSystem.dbo.TrainRecHdr.TrainRecDateTo, 
    EducationSystem.dbo.TrainRecHdr.TrainRecTotalDay, 
    EducationSystem.dbo.TrainRecHdr.TrainRecTotalHour, 
    EducationSystem.dbo.TrainRecHdr.TrainRecTrainer, 
    EducationSystem.dbo.TrainRecHdr.TrainRecPlace,  
    EducationSystem.dbo.TrainRecHdr.TrainRecCost,  
    
    EducationSystem.dbo.TrainRecDtl.EmployeeID,
    EducationSystem.dbo.TrainRecDtl.TrainRecResult,
    EducationSystem.dbo.TrainRecDtl.TrainRecNo

    FROM dbo.ReqUser INNER JOIN
    EducationSystem.dbo.TrainRecDtl ON dbo.ReqUser.EmpUserID = EducationSystem.dbo.TrainRecDtl.EmployeeID INNER JOIN
    EducationSystem.dbo.TrainRecHdr ON EducationSystem.dbo.TrainRecDtl.TrainRecNo = EducationSystem.dbo.TrainRecHdr.TrainRecNo
    WHERE (EducationSystem.dbo.TrainRecHdr.TrainHdrStatus = 3) 
    AND (EducationSystem.dbo.TrainRecDtl.TrainDtlStatus = 6) 
    AND (EducationSystem.dbo.TrainRecDtl.EmployeeID = '$SearchID')
    -- OR dbo.ReqUser.EmpUserName LIKE '%$FineID%' 
    -- OR dbo.ReqUser.EmpUserSurname LIKE '%$FineID%')
    ORDER BY EducationSystem.dbo.TrainRecDtl.TrainRecNo DESC";

    $ListQuary = sqlsrv_query($connRequest, $ListSql);
    $ListRow = sqlsrv_fetch_array($ListQuary, SQLSRV_FETCH_ASSOC);
    $Leader = $ListRow["LvApprove"];

    $LeaderSql = "SELECT EmpUserName,EmpUserSurname FROM ReqUser WHERE (EmpUserID = '$Leader') ";
    $LeaderQuary = sqlsrv_query($connRequest, $LeaderSql);
    $LeaderRow = sqlsrv_fetch_array($LeaderQuary, SQLSRV_FETCH_ASSOC);
    $LeaderName = $LeaderRow["EmpUserName"]."\n".$LeaderRow["EmpUserSurname"];

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

.font-topic {
    font-size: 10pt;
}
.font-topic-bold {
    font-weight: bold;
}
.font-detail {
    font-weight: normal;
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
    {PAGENO} of {nb}
</td>
</tr>
</table>

<table style="padding: 10px 0px 10px 0px;" width="100%">
<tr>
    <td style="text-align: center; font-weight: bold; font-size: 12pt; text-transform: uppercase;">
    <span>ประวัติการฝึกอบรมของพนักงาน</span>
    <div style="font-weight: normal;">(Training Record)</div>
    </td>
</tr>
</table>

<table width="100%" style="border-collapse: collapse; " cellpadding="6">
<tr>
    <td width="50%" class="font-topic-bold">รหัสพนักงาน/<span class="font-topic">(Employee ID): </span><span class="font-detail">' . $ListRow["EmployeeID"] . '</span></td>
    <td width="50%" class="font-topic-bold">ชื่อ-สกุล/<span class="font-topic">(Name-Surname): </span><span class="font-detail">' . $ListRow['EmpUserName'] . "\n" . $ListRow['EmpUserSurname']  . '</span></td>
</tr>
<tr>
    <td width="50%" class="font-topic-bold">ตำแหน่ง/<span class="font-topic">(Position): </span><span class="font-detail">' . $ListRow["EmpUserPosition"] . '</span></td>
    <td width="50%" class="font-topic-bold">แผนก/ฝ่าย<span class="font-topic">(Sec./Dpt.): </span><span class="font-detail">' . $ListRow["EmpUserSection"] . '</span></td>
</tr>
<tr>
    <td width="50%" class="font-topic-bold">รายงานถึง/<span class="font-topic">(Report to): </span><span class="font-detail">' . $LeaderName . '</span></td>
</tr>
</table>
</htmlpageheader>

<htmlpagefooter name="myfooter">
<table width="100%" style="vertical-align: bottom; padding-top: 0mm; border-top: 0.0mm solid #000000;"><tr>
<td width="50%" style="font-size: 9pt; text-align: right;">
FM-N016Q : Rev.08, 1 Jan. 2021
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
<td width="5%">ที่<div>NO.</div></td>
<td width="18%">วันที่เข้าฝึกอบรม<div>TRAINING DATE</div></td>
<td width="35%">หัวข้ออบรม<div>SUBJECT</div></td>
<td width="12%">ระยะเวลา<div>PERIOD</div></td>
<td width="20%">ผู้ให้การฝึกอบรม<div>TRAINER/ORGANIZE</div></td>
<td width="10%">ผลการ<div>ประเมิน</div><div>RESULT</div></td>
</tr>
</thead>
<tbody>
<!-- ITEMS HERE -->';

$ListIParams = array();
$ListIOptions =  array("Scrollable" => SQLSRV_CURSOR_KEYSET);
$ListIStmt = sqlsrv_query($connRequest, $ListSql, $ListIParams, $ListIOptions);
$ListIRow = sqlsrv_num_rows($ListIStmt);

if ($ListIRow > 0) {
    $iScore = 1;
    $ListObj = sqlsrv_query($connRequest, $ListSql);
    while ($ListResult = sqlsrv_fetch_array($ListObj, SQLSRV_FETCH_ASSOC)) {

        $html .= '
        <tr>
            <td align="center">' . $iScore++ . '</td>
            <td align="center">' . date_format($ListResult["TrainRecDateFrom"], 'd/m/Y') . " - " . date_format($ListResult["TrainRecDateTo"], 'd/m/Y') . '</td>
            <td>' . $ListResult["TrainRecName"] . '</td>
            <td align="center">' . round($ListResult["TrainRecTotalDay"], 2) . "Day, " . round($ListResult["TrainRecTotalHour"], 2) . "Hrs" . '</td>
            <td>' . $ListResult["TrainRecTrainer"] . '</td>
            <td align="center">' . (($ListResult["TrainRecResult"] == 1) ? "PASS" : "FAIL") . '</td>
        </tr>';
    }
} else {
    echo "<script>window.close();</script>";
    exit();
}

//for ($i = 2; $i <= 20; $i++) {
    $html .= '
    <!--<tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
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

</tbody>
</table>

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
    'format' => 'A4-L',
    //'orientation' => 'L',
    'margin_left' => 7,
    'margin_right' => 7,
    'margin_top' => 62,
    'margin_bottom' => 7,
    'margin_header' => 7,
    'margin_footer' => 7,
    'customProperties' => [
        'IT Section' => 'E-LEARNING',
        'IT Section' => 'TRAINING RECORD',
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


//$mpdf->SetProtection(array('print'));
$mpdf->SetTitle("E-Learning - Training record");
$mpdf->SetAuthor("TRAINING RECORD");
//$mpdf->SetWatermarkText("E-Learning");
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
$mpdf->SetProtection(array('copy', 'print'), '', 'Tda@it');

$mpdf->Output('E-Learning - Training record.pdf', \Mpdf\Output\Destination::INLINE);
die;
