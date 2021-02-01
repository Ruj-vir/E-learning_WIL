
<?php
    include "../alert/alert_session.php";
    include "../alert/alert_user.php";
    include "../../database/conn_sqlsrv.php";
    //include "../database/conn_odbc.php";
    //include "../../database/conn_mysql.php";
    include "../alert/data_detail.php";


if(trim($_POST["TypeRadio"])){

  $LvVerifySql = "SELECT EmpUserID,EmpUserName,EmpUserSurname FROM ReqUser WHERE (EduVerify = 1) ";
  $LvVerifyQuery = sqlsrv_query($connRequest, $LvVerifySql);
  $LvVerifyResult = sqlsrv_fetch_array($LvVerifyQuery, SQLSRV_FETCH_ASSOC);

  $LvVerifyCostSql = "SELECT EmpUserID,EmpUserName,EmpUserSurname FROM ReqUser WHERE (EduVerify = 3) ";
  $LvVerifyCostQuery = sqlsrv_query($connRequest, $LvVerifyCostSql);
  $LvVerifyCostResult = sqlsrv_fetch_array($LvVerifyCostQuery, SQLSRV_FETCH_ASSOC);

  $LvPsdSql = "SELECT EmpUserID,EmpUserName,EmpUserSurname FROM ReqUser WHERE (EduApprove = 1) ";
  $LvPsdQuery = sqlsrv_query($connRequest, $LvPsdSql);
  $LvPsdResult = sqlsrv_fetch_array($LvPsdQuery, SQLSRV_FETCH_ASSOC);

  $LvPsdCostSql = "SELECT EmpUserID,EmpUserName,EmpUserSurname FROM ReqUser WHERE (EduApprove = 3) ";
  $LvPsdCostQuery = sqlsrv_query($connRequest, $LvPsdCostSql);
  $LvPsdCostResult = sqlsrv_fetch_array($LvPsdCostQuery, SQLSRV_FETCH_ASSOC);


  $output = '';


  if(($_POST["TypeRadio"] == 4) OR ($_POST["TypeRadio"] == 5)) {
    $output .='<hr>
    <div class="d-flex align-items-center">
      <img class="rounded border border-secondary mr-3" src="../img/photo_emp/square/'.(($LvVerifyCostResult["EmpUserID"] == NULL) ? "10000" : $LvVerifyCostResult["EmpUserID"]) .'.jpg"  alt="Images" width="48" height="48">
        <div class="lh-100">
          <small>'.(($LvVerifyCostResult["EmpUserID"] == NULL) ? "None" : $LvVerifyCostResult["EmpUserID"]) .'</small> - <small class="badge badge-greenblue power">Verify Cost</small>
          <div class="text-truncate">
            <small class="mb-0 lh-100">'.$LvVerifyCostResult["EmpUserName"]."\n".$LvVerifyCostResult["EmpUserSurname"] .'</small>
          </div>
        </div>
    </div>
    <hr>
    <div class="d-flex align-items-center">
      <img class="rounded border border-secondary mr-3" src="../img/photo_emp/square/'.(($LvPsdCostResult["EmpUserID"] == NULL) ? "10000" : $LvPsdCostResult["EmpUserID"]) .'.jpg"  alt="Images" width="48" height="48">
        <div class="lh-100">
          <small>'.(($LvPsdCostResult["EmpUserID"] == NULL) ? "None" : $LvPsdCostResult["EmpUserID"]) .'</small> - <small class="badge badge-greenblue power">Approve Cost</small>
          <div class="text-truncate">
            <small class="mb-0 lh-100">'.$LvPsdCostResult["EmpUserName"]."\n".$LvPsdCostResult["EmpUserSurname"] .'</small>
          </div>
        </div>
    </div>';
  }else {
    $output .='<hr>
    <div class="d-flex align-items-center">
      <img class="rounded border border-secondary mr-3" src="../img/photo_emp/square/'.(($LvVerifyResult["EmpUserID"] == NULL) ? "10000" : $LvVerifyResult["EmpUserID"]) .'.jpg"  alt="Images" width="48" height="48">
        <div class="lh-100">
          <small>'.(($LvVerifyResult["EmpUserID"] == NULL) ? "None" : $LvVerifyResult["EmpUserID"]) .'</small> - <small class="badge badge-greenblue power">Verify</small>
          <div class="text-truncate">
            <small class="mb-0 lh-100">'.$LvVerifyResult["EmpUserName"]."\n".$LvVerifyResult["EmpUserSurname"] .'</small>
          </div>
        </div>
    </div>
    <hr>
    <div class="d-flex align-items-center">
      <img class="rounded border border-secondary mr-3" src="../img/photo_emp/square/'.(($LvPsdResult["EmpUserID"] == NULL) ? "10000" : $LvPsdResult["EmpUserID"]) .'.jpg"  alt="Images" width="48" height="48">
        <div class="lh-100">
          <small>'.(($LvPsdResult["EmpUserID"] == NULL) ? "None" : $LvPsdResult["EmpUserID"]) .'</small> - <small class="badge badge-greenblue power">Approve</small>
          <div class="text-truncate">
            <small class="mb-0 lh-100">'.$LvPsdResult["EmpUserName"]."\n".$LvPsdResult["EmpUserSurname"] .'</small>
          </div>
        </div>
    </div>';
  }
  echo $output;
}
?>



