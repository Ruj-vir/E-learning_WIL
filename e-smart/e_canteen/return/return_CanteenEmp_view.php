<?php
    include "../alert/alert_session.php";
    include "../../database/conn_sqlsrv.php";
    //include "../database/conn_mysql.php";
    include "../alert/alert_user.php";
    include "../alert/data_detail.php";



if (isset($_POST["inputSearchEmp"]) && trim($_POST["inputSearchEmp"]) != NULL) {

$inputSearchEmp = strip_tags(htmlspecialchars($_POST["inputSearchEmp"]));
$inputSearchEmp = trim($inputSearchEmp);
//$FineDataEmp = addslashes($str);
$vowels = array("'");
$SearchData = str_replace($vowels,'', $inputSearchEmp);

$output .= '
<div class="table-responsive">
<table class="table table-hover text-truncate nowrap" style="width:100%">
  <thead>
    <tr>
      <th scope="col">Name/Surname</th>
      <th scope="col">Office</th>
      <th scope="col">RFID</th>
      <th scope="col">Status</th>
      <th scope="col" class="text-center">Action</th>
    </tr>
  </thead>
    <tbody>';

$EmpDetailSql = "SELECT TOP (30) A.EmpUserID, A.EmpUserName, A.EmpUserSurname, A.EmpUserPosition, A.EmpUserSection, B.RFIDNo, B.Status FROM dbo.ReqUser AS A
INNER JOIN CanteenSystem.dbo.RFID_Master AS B ON A.EmpUserID = B.EmpID
WHERE (A.EmpUserID LIKE '%".$SearchData."%' 
OR A.EmpUserName LIKE '%".$SearchData."%'
OR A.EmpUserSurname LIKE '%".$SearchData."%'
OR A.EmpUserPosition LIKE '%".$SearchData."%'
OR A.EmpUserSection LIKE '%".$SearchData."%'
OR B.RFIDNo = '$SearchData')";
$EmpDetailObj = sqlsrv_query($connRequest, $EmpDetailSql);

$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$EmpDetailObj = sqlsrv_query( $connRequest, $EmpDetailSql , $params, $options );
$num_rows = sqlsrv_num_rows($EmpDetailObj);

if ($num_rows > 0) {
while($EmpDetailRow = sqlsrv_fetch_array($EmpDetailObj, SQLSRV_FETCH_ASSOC)) {

    $output .= '
  <tr>
    <td>
      <div class="d-flex align-items-center">
        <img class="rounded-circle border border-secondary mr-3" src="../img/photo_emp/square/'.(($EmpDetailRow["EmpUserID"] == NULL) ? "10000" : $EmpDetailRow["EmpUserID"]).'.jpg"  alt="Images" width="48" height="48">
          <div class="lh-100">
		        <small>'.$EmpDetailRow["EmpUserID"].'</small>
            <h6 class="mb-0 text-uppercase lh-100">'.$EmpDetailRow["EmpUserName"]."\n".$EmpDetailRow["EmpUserSurname"].'</h6>
          </div>
      </div>
    </td>
    <td>
      <div>'.$EmpDetailRow["EmpUserPosition"].'</div>
      <div>'.$EmpDetailRow["EmpUserSection"].'</div>
    </td>

<td>'.$EmpDetailRow["RFIDNo"].'</td>
<td>
<div class="d-inline p-0">
<span class="dot Status0'.$EmpDetailRow["Status"].'"></span>
<small class="text-green">'.(($EmpDetailRow["Status"] == 1) ? "Enabled" : "Disabled").'</small>
</div>
</td>
<td class="text-center">
<div class="btn-group" role="group" aria-label="Basic example">
<a target="_blank" href="canteen_emp_detail.php?IdEmp='.$EmpDetailRow["EmpUserID"].'" class="btn btn-green btn-sm"><i class="fa fa-spin fa-cog"></i></a>
</div>

</td>
</tr>';
 }

}else {
    $output .= '			
  <tr>
    <td class="text-center" colspan="5">No matching records found</td>
  </tr>';
}

}else {
  $output .= '			
  <tr>
    <td class="text-center" colspan="5">No matching records found</td>
  </tr>';
}
    $output .= '
    </div>
';

  echo $output;


?>



