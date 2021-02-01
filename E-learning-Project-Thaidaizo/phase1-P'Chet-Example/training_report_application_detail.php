<?php
include "alert/alert_session.php";
include "alert/alert_user.php";
include "../database/conn_sqlsrv.php";
//include "../database/conn_odbc.php";
//include "../../database/conn_mysql.php";
include "alert/data_detail.php";

//include "alert/alert_authority.php";

if (!isset($_REQUEST['html'])) {
  $_REQUEST['html'] = '';
}

include "form/include_report_app_employee_author.php";

$html = '
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
body {font-family: THSarabun;
	font-size: 10pt;
}

.tg  {
    border-collapse:collapse;
    border-spacing:0;
    text-align: center;
    font-size: 9pt; 
}
.tg td  {
    border-color:black;
    border-style:solid;
    border-width:0.1mm;
    font-weight:normal;
    overflow:hidden;
    word-break:normal;
    background-color: #FFFFFF;
}
.tg th  {
    border:0.1mm solid black;
    overflow:hidden;
    word-break:normal;
    background-color: #EEEEEE;
}

.tgbody  {
    border-collapse:separate;
    border-spacing:0;
}
.tgbody td  {
    border:0.1mm solid black;
    font-weight:normal;
    overflow:hidden;
    word-break:normal;
    text-align: left;
    font-size: 9pt; 
}
.tgbody th  {
    border:0.1mm solid black;
    overflow:hidden;
    word-break:normal;
    text-align: left;
    font-size: 9pt; 
}

.tgbody .signature {
  text-align: center;
  background-color: #EEEEEE;
  font-weight: bold;
}

table .Trainee {
  border-collapse:collapse; 
  border-spacing:0; 
  border:0mm solid #FFFFFF; 
  padding: 0px;
}

td .Trainee-list {
  border-collapse:collapse; 
  border-spacing:0; 
  border:0mm solid #FFFFFF; 
  padding: 0px 0px 6px 0px;
  text-transform: uppercase;
}

.text-uppercase {
  text-transform: uppercase;
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

<table style="padding: 0px 0px 8px 0px;" width="100%">
<tr>
    <td style="text-align: center; font-weight: bold; font-size: 12pt; text-transform: uppercase;">
    <span>ใบคำร้องขอเข้ารับการฝึกอบรม</span>
    <div style="font-weight: normal;">(TRAINING  APPLICATION  FORM)</div>
    </td>
</tr>
</table>

<table class="tg" width="100%" cellpadding="8">
<thead>
  <tr>
    <th>ผู้ยื่นคำร้อง<div>Applicant</div></th>
    <td class="text-uppercase">' . $ListResult["sEmpEngNamePrefix"] . "\n" . $ListResult["EmpUserName"] . "\n" . $ListResult["EmpUserSurname"] . '</td>
    <th>ตำแหน่ง<div>Position</div></th>
    <td>' . $ListResult["EmpUserPosition"] . '</td>
    <th>ฝ่าย/แผนก<div>Dpt./Section</div></th>
    <td>' . $ListResult["EmpUserDepartment"] . ' <strong>/</strong> ' . $ListResult["EmpUserSection"] . '</td>
    <th>วันที่ยื่น<div>Date</div></th>
    <td>' .  date_format($ListResult["ReqIssueDate"], 'd  F  Y') . '</td>
  </tr>
</thead>
</table>
</htmlpageheader>

<htmlpagefooter name="myfooter">
<table width="100%" style="vertical-align: bottom; padding-top: 0mm; border-top: 0.0mm solid #000000;">
<tr>
<td width="50%" style="font-size: 9pt; text-align: right;">
FM-N015Q : Rev.08, 1 Jan. 2021
</td>
</tr>
</table>
<!--<div style="border-top: 0px solid #000000; font-size: 9pt; text-align: right; padding-top: 1mm; ">-->
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->


<table class="tgbody" width="100%" style="padding: 10px 0px 0px 0px;" cellpadding="8">
<tbody>
  <tr>
    <th width="25%">หัวข้อที่เข้ารับการฝึกอบรม<div>Subject of Training</div></th>
    <td colspan="3">' . $ListResult["ReqRemark"] . '</td>
  </tr>
</tbody>
<tbody>
  <tr>
    <th width="25%">หน่วยงานที่จัดอบรม<div>Training company / Organization</div></th>
    <td colspan="3">' . $EleData[2] . '</td>
  </tr>
  <tr>
    <th width="25%">วัตถุประสงค์<div>Objective</div></th>
    <td colspan="3">' . $EleData[1]. '</td>
  </tr>
  <tr>
    <th width="25%">วันที่เข้ารับการฝึกอบรม / Training Date<div>เวลาที่เข้ารับการฝึกอบรม /Training  Time</div></th>
    <td colspan="3">' .  date_format($ListResult["ReqDate"], 'd F Y') . " - " . date_format($ListResult["TrnTime"], 'd F Y') . '
    <div>' .  date_format($ListResult["ReqDate"], 'h:ia') . " - " . date_format($ListResult["TrnTime"], 'h:ia') . '</div>
    </td>
  </tr>
  <tr>
    <th width="25%">สถานที่ที่เข้ารับการฝึกอบรม<div>Location of Training</div></th>
    <td colspan="3">' . $EleData[3] . '</td>
  </tr>
  <tr>
    <th width="25%">ค่าใช้จ่ายในการเข้ารับการฝึกอบรม<div>Training Cost</div></th>
    <td colspan="3">' . ((round($ListResult["ReqSumTime"], 2) == 0) ? "No expense" : number_format($ListResult["ReqSumTime"], 3) . " THB") . '</td>
  </tr>
  <tr>
    <th width="25%" style="vertical-align: top;">จำนวนผู้เข้ารับการฝึกอบรม<div>Number of trainees</div></th>
    <td colspan="3">
    <table class="Trainee" cellpadding="0">';

$ReqIssuer = $ListResult["ReqIssuer"];

include "form/include_report_app_employee.php";
include "form/include_report_app_employee_attached.php";

$iScore = 1;

$ListLoopParams = array();
$ListLoopOptions =  array("Scrollable" => SQLSRV_CURSOR_KEYSET);
$ListLoopStmt = sqlsrv_query($connRequest, $ListLoop, $ListLoopParams, $ListLoopOptions);
$ListLoopRow = sqlsrv_num_rows($ListLoopStmt);

if ($ListLoopRow < 6) {
$ListQuery = sqlsrv_query($connRequest, $ListLoop);
while ($ListRow = sqlsrv_fetch_array($ListQuery, SQLSRV_FETCH_ASSOC)) {
  $html .= '
    <tr>
      <td width="100%" class="Trainee-list">
        ' . $iScore++ . ") " . $ListRow["EmpUserID"] . " - " . $ListRow["sEmpEngNamePrefix"] . "\n" . $ListRow["EmpUserName"] . "\n" . $ListRow["EmpUserSurname"] . '
      </td>
    </tr>
    ';
}
for ($i = $iScore; $i <= 5; $i++) {
  $html .= '<tr><td width="100%" class="Trainee-list">&nbsp;</td></tr>';
}

}else {
  $ListQuery = sqlsrv_query($connRequest, $ListLoopAt);
  while ($ListRow = sqlsrv_fetch_array($ListQuery, SQLSRV_FETCH_ASSOC)) {
    $html .= '
      <tr>
        <td width="100%" class="Trainee-list">
          ' . $iScore++ . ") " . $ListRow["EmpUserID"] . " - " . $ListRow["sEmpEngNamePrefix"] . "\n" . $ListRow["EmpUserName"] . "\n" . $ListRow["EmpUserSurname"] . '
        </td>
      </tr>
      ';
  }
  $html .= '<tr><td width="100%" class="Trainee-list"><b>ตามเอกสารแนบ (As attached)</b></td></tr>';

}

$FlowSql = "SELECT LvApprove FROM ReqUser WHERE (EmpUserID='$ReqIssuer') ";
$FlowQuery = sqlsrv_query($connRequest, $FlowSql);
$FlowRow = sqlsrv_fetch_array($FlowQuery, SQLSRV_FETCH_ASSOC);

$LvApprove = $FlowRow["LvApprove"];
$EduVerify = $ListResult["ReqApprover"];
$EduApprove = $ListResult["UpdateBy"];

$TimeCheckSql = "SELECT ReqCheckDate FROM ReqInfo 
WHERE (ReqType = 4) 
AND (ReqNo = '$ItemReqNo') 
AND (ReqIssuer='$ReqIssuer') 
AND (ReqChecker='$LvApprove') ";
$TimeCheckQuery = sqlsrv_query($connRequest, $TimeCheckSql);
$TimeCheckRow = sqlsrv_fetch_array($TimeCheckQuery, SQLSRV_FETCH_ASSOC);

$DateCheck = date_format($TimeCheckRow["ReqCheckDate"], 'd / F / Y');
$DateVerify = date_format($ListResult["ReqApproveDate"], 'd / F / Y');
$DateApprove = date_format($ListResult["UpdateDate"], 'd / F / Y');

$CheckSql = "SELECT HRSystem.dbo.eEmployee.sEmpEngNamePrefix, 
dbo.ReqUser.EmpUserID, 
dbo.ReqUser.EmpUserName, 
dbo.ReqUser.EmpUserSurname
FROM ReqUser 
INNER JOIN HRSystem.dbo.eEmployee ON dbo.ReqUser.EmpUserID COLLATE SQL_Latin1_General_CP1_CI_AS = HRSystem.dbo.eEmployee.sEmpID
WHERE (EmpUserID='$LvApprove') ";
$CheckQuery = sqlsrv_query($connRequest, $CheckSql);
$CheckRow = sqlsrv_fetch_array($CheckQuery, SQLSRV_FETCH_ASSOC);
$Check = $CheckRow["sEmpEngNamePrefix"] . $CheckRow["EmpUserName"] . "\n" . $CheckRow["EmpUserSurname"];

$VerifySql = "SELECT HRSystem.dbo.eEmployee.sEmpEngNamePrefix, 
dbo.ReqUser.EmpUserID, 
dbo.ReqUser.EmpUserName, 
dbo.ReqUser.EmpUserSurname
FROM ReqUser 
INNER JOIN HRSystem.dbo.eEmployee ON dbo.ReqUser.EmpUserID COLLATE SQL_Latin1_General_CP1_CI_AS = HRSystem.dbo.eEmployee.sEmpID
WHERE (EmpUserID='$EduVerify') ";
$VerifyQuery = sqlsrv_query($connRequest, $VerifySql);
$VerifyRow = sqlsrv_fetch_array($VerifyQuery, SQLSRV_FETCH_ASSOC);
$Verify = $VerifyRow["sEmpEngNamePrefix"] . $VerifyRow["EmpUserName"] . "\n" . $VerifyRow["EmpUserSurname"];

$ApproveSql = "SELECT HRSystem.dbo.eEmployee.sEmpEngNamePrefix, 
dbo.ReqUser.EmpUserID, 
dbo.ReqUser.EmpUserName, 
dbo.ReqUser.EmpUserSurname
FROM ReqUser 
INNER JOIN HRSystem.dbo.eEmployee ON dbo.ReqUser.EmpUserID COLLATE SQL_Latin1_General_CP1_CI_AS = HRSystem.dbo.eEmployee.sEmpID
WHERE (EmpUserID='$EduApprove') ";
$ApproveQuery = sqlsrv_query($connRequest, $ApproveSql);
$ApproveRow = sqlsrv_fetch_array($ApproveQuery, SQLSRV_FETCH_ASSOC);
$Approve = $ApproveRow["sEmpEngNamePrefix"] . $ApproveRow["EmpUserName"] . "\n" . $ApproveRow["EmpUserSurname"];

$html .= '
    </table>
    </td>
  </tr>
  <tr>
    <td rowspan="2" class="signature">Requested  by</td>
    <td colspan="2" class="signature">Acknowledge  by</td>
    <td rowspan="2" class="signature">Approved  by</td>
  </tr>
  <tr>
    <td class="signature">Supervisor / Manager</td>
    <td class="signature">Administration</td>
  </tr>
  <tr>
    <td align="center" class="text-uppercase" style="padding: 18px 0px 18px 0px;">' . $ListResult["sEmpEngNamePrefix"] . "\n" . $ListResult["EmpUserName"] . "\n" . $ListResult["EmpUserSurname"] . '</td>
    <td align="center" class="text-uppercase" style="padding: 18px 0px 18px 0px;">' . (($DateCheck == NULL) ? "" : $Check) . '</td>
    <td align="center" class="text-uppercase" style="padding: 18px 0px 18px 0px;">' . (($DateVerify == NULL) ? "" : $Verify) . '</td>
    <td align="center" class="text-uppercase" style="padding: 18px 0px 18px 0px;">' . (($DateApprove == NULL) ? "" : $Approve) . '</td>
  </tr>
  <tr>
    <td align="center">Date : ' . date_format($ListResult["ReqIssueDate"], 'd / F / Y') . '</td>
    <td align="center">Date : ' . (($DateCheck == NULL) ? ".... / .... / ...." : $DateCheck) . '</td>
    <td align="center">Date : ' . (($DateVerify == NULL) ? ".... / .... / ...." : $DateVerify) . '</td>
    <td align="center">Date : ' . (($DateApprove == NULL) ? ".... / .... / ...." : $DateApprove) . '</td>
  </tr>
</tbody>
</table>

<!-- END ITEMS HERE -->

</tbody>
</table>';

if ($ListLoopRow >= 6) {
  include "form/include_report_app_employee_attach.php";
}

$html .= '
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
  'margin_top' => 44,
  'margin_bottom' => 7,
  'margin_header' => 7,
  'margin_footer' => 7,
  'customProperties' => [
    'IT Section' => 'E-LEARNING',
    'IT Section' => 'TRAINING APPLICATION',
  ],
  'fontDir' => array_merge($fontDirs, [__DIR__]),
  'fontdata' => $fontData + ['THSarabun' => [
    'R' => 'assets/font-standard/fonts/Sarabun-Regular.ttf',
  ]],
  'default_font' => 'THSarabun'
]);

// $mpdf->mirrorMargins = 1;
// $mpdf->mirrorMargins = true;
$mpdf->autoScriptToLang = true;
$mpdf->baseScript = 1;
$mpdf->autoVietnamese = true;
$mpdf->autoArabic = true;
$mpdf->autoLangToFont = true;


//$mpdf->SetProtection(array('print'));
$mpdf->SetTitle("E-Learning - Training application");
$mpdf->SetAuthor("TRAINING APPLICATION");
//$mpdf->SetWatermarkText("E-Learning");
$mpdf->showWatermarkText = true;
$mpdf->watermark_font = 'DejaVuSansCondensed';
$mpdf->watermarkTextAlpha = 0.1;

// $mpdf->SetDisplayMode('fullpage', 'two');
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

$mpdf->Output('E-Learning - Training application.pdf', \Mpdf\Output\Destination::INLINE);
die;



