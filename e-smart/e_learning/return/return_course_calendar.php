<?php
include "../alert/alert_session.php";
include "../../database/conn_sqlsrv.php";
//include "../database/conn_odbc.php";
include "../../database/conn_mysql.php";
include "../alert/alert_user.php";
include "../alert/data_detail.php";



$data = array();
$query = "SELECT ReqNo, ReqDate, TrnTime, ReqRemark, Status FROM ReqInfo 
WHERE (EmployeeID = '$SesUserID') 
AND (ReqType = 4) 
--AND (Status = 6)
ORDER BY ReqNo DESC";

$statement = $connReqPDO->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
foreach($result as $row){

switch ($row["Status"]) {
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
  'id'      => $row["ReqNo"],
  'title'   => $row["ReqRemark"],
  'start'   => date("Y-m-d H:i:s", strtotime($row["ReqDate"])),
  'end'     => date("Y-m-d H:i:s", strtotime($row["TrnTime"])),
  //'url'     => 'http://google.com/',
  'color'   => $Color
 );
}

echo json_encode($data);
?>