
<?php
include "alert/alert_session.php";
include "alert/alert_user.php";
include "../database/conn_sqlsrv.php";
//include "../database/conn_odbc.php";
//include "../../database/conn_mysql.php";
include "alert/data_detail.php";

//include "alert/alert_authority.php";


$html .= '

<style>
body {
  font-family: THSarabun;
	font-size: 10pt;
}
p {	
  margin: 0pt; 
}
table.items {
	border: 0.1mm solid #000000;
}
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


<htmlpageheader name="myHTMLHeader1">
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
    <span>ใบแจ้งรายชื่อผู้เข้ารับการอบรม</span>
    <div style="font-weight: normal;">(TRAINEE NAME LIST FORM)</div>
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
    <td>'.date_format($ListResult["ReqDate"], 'd F Y') . " - " . date_format($ListResult["TrnTime"], 'd F Y').'</td>
</tr>
<tr>
    <td width="200" class="font-topic-bold">เวลา/<span class="font-topic">TIME</span> :</td>
    <td>'.date_format($ListResult["ReqDate"], 'h:ia') . " - " . date_format($ListResult["TrnTime"], 'h:ia').'</td>
</tr>';

$ListTrainerSql = "SELECT TrainRecTrainer FROM TrainRecHdr WHERE (TrainRecNo = '$ItemReqNo') ";
$ListTrainerObj = sqlsrv_query($connEducation, $ListTrainerSql);
$ListTrainerResult = sqlsrv_fetch_array($ListTrainerObj, SQLSRV_FETCH_ASSOC);

$html .= '
<tr>
    <td width="200" class="font-topic-bold">ผู้อบรม/<span class="font-topic">TRAINER</span> :</td>
    <td>' . (($ListTrainerResult["TrainRecTrainer"] == NULL) ? "-" : $ListTrainerResult["TrainRecTrainer"]) . '</td>
</tr>
<tr>
    <td width="200" class="font-topic-bold">สถานที่อบรม/<span class="font-topic">TRAINING PLACE</span> :</td>
    <td>' . $EleData[3] . '</td>
</tr>
</table>
</htmlpageheader>


<pagebreak orientation="portrait" type="NEXT-ODD" sheet-size="A4" margin-top="63mm" margin-bottom="5mm" odd-header-name="html_myHTMLHeader1" odd-header-value="1" even-header-name="myHeader1Even" even-header-value="1" odd-footer-name="myFooter1" odd-footer-value="1" even-footer-name="myFooter1Even" even-footer-value="1" />

<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
<thead>
<tr>
<td width="5%">ที่<div>No.</div></td>
<td width="12%">รหัส<div>ID CODE</div></td>
<td width="40%">ชื่อ/สกุล<div>NAME/LAST NAME</div></td>
<td width="15%">ตำแหน่ง<div>POSITION</div></td>
<td width="18%">แผนก<div>SECTION/DPT.</div></td>
<td width="12%">หมายเหตุ<div>REMARK</div></td>
</tr>
</thead>
<tbody>';

$iEmp = 1;
$ListQuery = sqlsrv_query($connRequest, $ListLoop);
while ($ListRow = sqlsrv_fetch_array($ListQuery, SQLSRV_FETCH_ASSOC)) {
  $html .= '
  <tr>
    <td align="center">'.$iEmp++.'</td>
    <td align="center">'. $ListRow["EmpUserID"] .'</td>
    <td align="left">'. $ListRow["sEmpEngNamePrefix"] . "\n" . $ListRow["EmpUserName"] . "\n" . $ListRow["EmpUserSurname"] . '</td>
    <td align="left">'. $ListRow["EmpUserPosition"] .'</td>
    <td align="left">'. $ListRow["EmpUserSection"] .'</td>
    <td align="center">&nbsp;</td>
  </tr>
    ';
}

// for ($i = 1; $i <= 40; $i++) {
//   $html .= '
//   <tr>
//   <td align="center">'.$i.'</td>
//   <td align="center">&nbsp;</td>
//   <td align="center">&nbsp;</td>
//   <td align="center">&nbsp;</td>
//   <td align="center">&nbsp;</td>
//   <td align="center">&nbsp;</td>
//   </tr>';
// }

$html .= '

</tbody>
</table>

';