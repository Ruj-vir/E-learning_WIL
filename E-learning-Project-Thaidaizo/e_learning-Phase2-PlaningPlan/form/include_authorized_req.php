<?php

  $LvApprove = $resultSQL["LvApprove"];
  $EduVerify = $resultSQL["EduVerify"];
  $EduApprove = $resultSQL["EduApprove"];

  $LvApproveSql = "SELECT EmpUserID,EmpUserName,EmpUserSurname FROM ReqUser WHERE (EmpUserID = '$LvApprove') ";
  $LvApproveQuery = sqlsrv_query($connRequest, $LvApproveSql);
  $LvApproveResult = sqlsrv_fetch_array($LvApproveQuery, SQLSRV_FETCH_ASSOC);

  $LvVerifySql = "SELECT EmpUserID,EmpUserName,EmpUserSurname FROM ReqUser WHERE (EmpUserID = '$EduVerify') ";
  $LvVerifyQuery = sqlsrv_query($connRequest, $LvVerifySql);
  $LvVerifyResult = sqlsrv_fetch_array($LvVerifyQuery, SQLSRV_FETCH_ASSOC);

  $LvPsdSql = "SELECT EmpUserID,EmpUserName,EmpUserSurname FROM ReqUser WHERE (EmpUserID = '$EduApprove') ";
  $LvPsdQuery = sqlsrv_query($connRequest, $LvPsdSql);
  $LvPsdResult = sqlsrv_fetch_array($LvPsdQuery, SQLSRV_FETCH_ASSOC);

?>
<style>
  .power {
    width: 62px;
    font-size: 12px;
}
</style>
      <div class="d-flex align-items-center">
        <img class="rounded border border-secondary mr-3" src="../img/photo_emp/square/<?php echo (($SesUserID == NULL) ? "10000" : $SesUserID) ;?>.jpg"  alt="Images" width="48" height="48">
          <div class="lh-100">
		        <small><?php echo (($SesUserID == NULL) ? "None" : $SesUserID) ;?></small> - <small class="badge badge-greenblue power">Requset</small>
            <div class="text-truncate">
              <small class="mb-0 lh-100"><?php echo $resultSQL["EmpUserName"]."\n".$resultSQL["EmpUserSurname"] ;?></small>
            </div>
          </div>
      </div>
      <hr>
      <div class="d-flex align-items-center">
        <img class="rounded border border-secondary mr-3" src="../img/photo_emp/square/<?php echo (($LvApproveResult["EmpUserID"] == NULL) ? "10000" : $LvApproveResult["EmpUserID"]) ;?>.jpg"  alt="Images" width="48" height="48">
          <div class="lh-100">
		        <small><?php echo (($LvApproveResult["EmpUserID"] == NULL) ? "None" : $LvApproveResult["EmpUserID"]) ;?></small> - <small class="badge badge-greenblue power">Check</small>
            <div class="text-truncate">
              <small class="mb-0 lh-100"><?php echo $LvApproveResult["EmpUserName"]."\n".$LvApproveResult["EmpUserSurname"] ;?></small>
            </div>
          </div>
      </div>
      <hr>
      <div class="d-flex align-items-center">
        <img class="rounded border border-secondary mr-3" src="../img/photo_emp/square/<?php echo (($LvVerifyResult["EmpUserID"] == NULL) ? "10000" : $LvVerifyResult["EmpUserID"]) ;?>.jpg"  alt="Images" width="48" height="48">
          <div class="lh-100">
		        <small><?php echo (($LvVerifyResult["EmpUserID"] == NULL) ? "None" : $LvVerifyResult["EmpUserID"]) ;?></small> - <small class="badge badge-greenblue power">Verify</small>
            <div class="text-truncate">
              <small class="mb-0 lh-100"><?php echo $LvVerifyResult["EmpUserName"]."\n".$LvVerifyResult["EmpUserSurname"] ;?></small>
            </div>
          </div>
      </div>
      <hr>
      <div class="d-flex align-items-center">
        <img class="rounded border border-secondary mr-3" src="../img/photo_emp/square/<?php echo (($LvPsdResult["EmpUserID"] == NULL) ? "10000" : $LvPsdResult["EmpUserID"]) ;?>.jpg"  alt="Images" width="48" height="48">
          <div class="lh-100">
		        <small><?php echo (($LvPsdResult["EmpUserID"] == NULL) ? "None" : $LvPsdResult["EmpUserID"]) ;?></small> - <small class="badge badge-greenblue power">Approve</small>
            <div class="text-truncate">
              <small class="mb-0 lh-100"><?php echo $LvPsdResult["EmpUserName"]."\n".$LvPsdResult["EmpUserSurname"] ;?></small>
            </div>
          </div>
      </div>
