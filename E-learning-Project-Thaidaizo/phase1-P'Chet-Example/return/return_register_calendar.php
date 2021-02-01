<?php
include "../alert/alert_session.php";
include "../alert/alert_user.php";
include "../../database/conn_sqlsrv.php";
// include "../database/conn_odbc.php";
// include "../../database/conn_mysql.php";
include "../alert/data_detail.php";



$data = array();
$query = "SELECT DISTINCT 
dbo.TrainRecHdr.TrainRecName, 
dbo.TrainRecHdr.TrainRecDateFrom, 
dbo.TrainRecHdr.TrainRecDateTo, 
dbo.TrainRecHdr.TrainRecTotalDay, 
dbo.TrainRecHdr.TrainRecTotalHour, 
dbo.TrainRecDtl.TrainRecResult, 
dbo.TrainRecDtl.TrainRecNo
FROM dbo.TrainRecDtl INNER JOIN dbo.TrainRecHdr ON dbo.TrainRecDtl.TrainRecNo = dbo.TrainRecHdr.TrainRecNo
WHERE (dbo.TrainRecDtl.EmployeeID = '$SesUserID')
ORDER BY dbo.TrainRecDtl.TrainRecNo DESC";

$statement = $connEduPDO->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
foreach($result as $row){

switch ($row["TrainRecResult"]) {
 case 0: $Color = '#ff1744';
 break;
 case 1: $Color = '#ffff00';
 break;
 case 2: $Color = '#ffff00';
 break;
 case 3: $Color = '#00c853';
 break;
 case 6: $Color = '#00c853';
 break;
 case 9: $Color = '#00c853';
 break;
}
 $data[] = array(
  'id'      => $row["TrainRecNo"],
  'title'   => $row["TrainRecName"],
  'start'   => date("Y-m-d H:i:s", strtotime($row["TrainRecDateFrom"])),
  'end'     => date("Y-m-d H:i:s", strtotime($row["TrainRecDateTo"])),
  //'url'     => 'http://google.com/',
  'color'   => $Color
 );
}

echo json_encode($data);
?>