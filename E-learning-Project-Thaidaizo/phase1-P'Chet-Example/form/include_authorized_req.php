<?php

  $LvApprove = $resultSQL["LvApprove"];
  // $EduVerify = $resultSQL["EduVerify"];
  // $EduApprove = $resultSQL["EduApprove"];

  $LvApproveSql = "SELECT EmpUserID,EmpUserName,EmpUserSurname FROM ReqUser WHERE (EmpUserID = '$LvApprove') ";
  $LvApproveQuery = sqlsrv_query($connRequest, $LvApproveSql);
  $LvApproveResult = sqlsrv_fetch_array($LvApproveQuery, SQLSRV_FETCH_ASSOC);

?>
<style>
.power {
  width: 74px;
  font-size: 10px;
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



      <div class="box-authorize">
      <hr>
      <div class="d-flex align-items-center">
        <img class="rounded border border-secondary mr-3" src="../img/photo_emp/square/10000.jpg"  alt="Images" width="48" height="48">
          <div class="lh-100">
		        <small>None</small> - <small class="badge badge-greenblue power">Verify</small>
            <div class="text-truncate">
              <small class="mb-0 lh-100"></small>
            </div>
          </div>
      </div>
      <hr>
      <div class="d-flex align-items-center">
        <img class="rounded border border-secondary mr-3" src="../img/photo_emp/square/10000.jpg"  alt="Images" width="48" height="48">
          <div class="lh-100">
		        <small>None</small> - <small class="badge badge-greenblue power">Approve</small>
            <div class="text-truncate">
              <small class="mb-0 lh-100"></small>
            </div>
          </div>
      </div>
      </div>














      