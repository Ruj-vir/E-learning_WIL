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

if (isset($_GET["BtPDF"]) == "PDF" && trim($_GET["DateFrom"]) != NULL && trim($_GET["DateTo"]) != NULL) {

    $DateFrom = $_GET["DateFrom"];
    $DateTo = $_GET["DateTo"];

    if (($DateFrom == date('Y-m-d', strtotime($DateFrom))) && ($DateTo == date('Y-m-d', strtotime($DateTo)))) {
        /////////\\\\\\\\
    } else {
        echo "<script>window.close();</script>";
        exit();
    }

    $str = trim($_GET["SearchID"]);
    //$FineDataEmp = addslashes($str);
    $vowels = array("'");
    $SearchID = str_replace($vowels, '', $str);
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
    {PAGENO} of {nb}
</td>
</tr>
</table>

<table style="padding: 0px 0px 0px 0px;" width="100%">
<tr>
    <td style="text-align: center; font-weight: bold; font-size: 12pt; text-transform: uppercase;">
    <span>Training Plan</span>
    <div style="font-weight: normal;">' . date('d F Y', strtotime($DateFrom)) . " - " . date('d F Y', strtotime($DateTo)) . '</div>
    </td>
</tr>
</table>
</htmlpageheader>

<htmlpagefooter name="myfooter">
<table width="100%" style="vertical-align: bottom; padding-top: 0mm; border-top: 0.0mm solid #000000;"><tr>
<td width="50%" style="font-size: 9pt; text-align: right;">
FM-N031Q : Rev.01, 4 Oct. 2007
</td>
</tr></table>
<!--<div style="border-top: 0px solid #000000; font-size: 9pt; text-align: right; padding-top: 1mm; ">-->
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->


<table class="items" width="100%" style="font-size: 9pt; text-transform: uppercase; border-collapse: collapse; " cellpadding="8">
<thead>
<tr>
<td width="4%" rowspan="2">ที่<div>NO.</div></td>
<td width="20%" rowspan="2">หัวข้อการฝึกอบรม<div>COURSE NAME</div></td>
<td width="15%" rowspan="2">วันที่เข้าฝึกอบรม<div>Training date</div></td>
<td width="8%" rowspan="2">แผนก/ฝ่าย<div>SEC./DPT.</div></td>
<td width="12%" rowspan="2">ผู้ให้การฝึกอบรม<div>TRAINER/ORGANIZE</div></td>
<td width="10%" rowspan="2">สถานที่<div>PLACE</div></td>
<td width="7%" rowspan="2">ประเภท<div>TYPE</div></td>
<td width="8%" colspan="2">ผลประเมิน<div>RESULT</div></td>
<td width="8%" rowspan="2">ระยะเวลา<div>PERIOD</div></td>
<td width="8%" align="right" rowspan="2">ค่าใช้จ่าย<div>COST (THB)</div></td>
<tr>
<td style="font-size: 8pt;">PASS</td>
<td style="font-size: 8pt;">FAIL</td>
</tr>
</tr>
</thead>
<tbody>
<!-- ITEMS HERE -->';

$ListSql = "SELECT DISTINCT 
dbo.ReqInfo.ReqNo, 
-- dbo.ReqInfo.ReqDate, 
-- dbo.ReqInfo.TrnTime, 
dbo.ReqInfo.ReqDay, 
dbo.ReqInfo.ReqHour, 
dbo.ReqInfo.ReqSumTime, 
dbo.ReqInfo.ReqRemark,

EducationSystem.dbo.TrainRecHdr.TrainRecType, 
EducationSystem.dbo.TrainRecHdr.TrainRecEvl, 
EducationSystem.dbo.TrainRecHdr.TrainRecDateFrom, 
EducationSystem.dbo.TrainRecHdr.TrainRecDateTo, 
EducationSystem.dbo.TrainRecHdr.TrainRecTrainer, 
EducationSystem.dbo.TrainRecHdr.TrainRecPlace, 
dbo.ReqUser.EmpUserSection
FROM EducationSystem.dbo.TrainRecHdr INNER JOIN
dbo.ReqInfo ON EducationSystem.dbo.TrainRecHdr.TrainRecNo = dbo.ReqInfo.ReqNo INNER JOIN
dbo.ReqUser ON dbo.ReqInfo.ReqIssuer = dbo.ReqUser.EmpUserID
WHERE (dbo.ReqInfo.ReqType = 4) AND (EducationSystem.dbo.TrainRecHdr.TrainHdrStatus = 3) 
AND ((dbo.ReqInfo.ReqDate >= '$DateFrom 00:00:00' AND dbo.ReqInfo.TrnTime <= '$DateTo 23:59:59')
OR (dbo.ReqInfo.TrnTime >= '$DateFrom 00:00:00' AND dbo.ReqInfo.ReqDate <= '$DateTo 23:59:59'))
--OR (dbo.ReqInfo.ReqCheckDate >= '$DateStart 00:00:00' AND dbo.ReqInfo.ReqCheckDate <= '$DateEnd 00:00:00')";

$ListIParams = array();
$ListIOptions =  array("Scrollable" => SQLSRV_CURSOR_KEYSET);
$ListIStmt = sqlsrv_query($connRequest, $ListSql, $ListIParams, $ListIOptions);
$ListIRow = sqlsrv_num_rows($ListIStmt);

if ($ListIRow > 0) {
    $iScore = 1;
    $ListObj = sqlsrv_query($connRequest, $ListSql);
    while ($ListResult = sqlsrv_fetch_array($ListObj, SQLSRV_FETCH_ASSOC)) {
        switch ($ListResult["TrainRecType"]) {
            case 1:
                $TrainRecType = 'Orientation';
                break;
            case 2:
                $TrainRecType = 'OJT';
                break;
            case 3:
                $TrainRecType = 'Reskill';
                break;
            case 4:
                $TrainRecType = 'Upskill';
                break;
            case 5:
                $TrainRecType = 'Public';
                break;
            case 6:
                $TrainRecType = 'Other';
                break;

            default:
                $TrainRecType = '';
        }

        $ItemReqNo = $ListResult["ReqNo"];

        $PassDtlSql = "SELECT COUNT(EmployeeID) AS TraineePass
        FROM dbo.ReqInfo AS ReqInfo
        WHERE (EmployeeID IN
        (SELECT EmployeeID
        FROM EducationSystem.dbo.TrainRecDtl
        WHERE (TrainDtlStatus = 6) 
        AND (TrainRecResult = 1))) 
        AND (ReqType = 4) 
        AND (ReqNo = '$ItemReqNo')";
        $PassDtlObj = sqlsrv_query($connRequest, $PassDtlSql);
        $PassDtlResult = sqlsrv_fetch_array($PassDtlObj, SQLSRV_FETCH_ASSOC);

        $FailDtlSql = "SELECT COUNT(EmployeeID) AS TraineeFail
        FROM dbo.ReqInfo AS ReqInfo
        WHERE (EmployeeID NOT IN
        (SELECT EmployeeID
        FROM EducationSystem.dbo.TrainRecDtl
        WHERE (TrainDtlStatus = 6) 
        AND (TrainRecResult = 1))) 
        AND (ReqType = 4) 
        AND (ReqNo = '$ItemReqNo')";
        $FailDtlObj = sqlsrv_query($connRequest, $FailDtlSql);
        $FailDtlResult = sqlsrv_fetch_array($FailDtlObj, SQLSRV_FETCH_ASSOC);

        $html .= '
        <tr>
        <td align="center">' . $iScore++ . '</td>
        <td>' . $ListResult["ReqRemark"] . '</td>
        <td align="center">
        ' . date_format($ListResult["TrainRecDateFrom"], 'd/m/Y') . " - " . date_format($ListResult["TrainRecDateTo"], 'd/m/Y') . '
        <div>' . date_format($ListResult["TrainRecDateFrom"], 'H:i') . " - " . date_format($ListResult["TrainRecDateTo"], 'H:i') . '</div>
        </td>
        <td align="center">' . $ListResult["EmpUserSection"] . '</td>
        <td>' . $ListResult["TrainRecTrainer"] . '</td>
        <td align="center">' . $ListResult["TrainRecPlace"] . '</td>
        <td align="center">' . $TrainRecType . '</td>
        <td align="center">' . $PassDtlResult["TraineePass"] . '</td>
        <td align="center">' . $FailDtlResult["TraineeFail"] . '</td>
        <td align="center">' . round($ListResult["ReqDay"], 2) . "Day, " . round($ListResult["ReqHour"], 2) . "Hrs" . '</td>
        <td align="right">' . number_format($ListResult["ReqSumTime"], 2) . '</td>
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
    'margin_top' => 34,
    'margin_bottom' => 7,
    'margin_header' => 7,
    'margin_footer' => 7,
    'customProperties' => [
        'IT Section' => 'E-LEARNING',
        'IT Section' => 'TRAINING PLAN',
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
$mpdf->SetTitle("E-Learning - Training plan");
$mpdf->SetAuthor("TRAINING PLAN");
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

$mpdf->Output('E-Learning - Training plan.pdf', \Mpdf\Output\Destination::INLINE);
die;
