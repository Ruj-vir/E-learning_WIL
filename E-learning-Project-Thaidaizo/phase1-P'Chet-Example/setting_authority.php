<?php include "templates/header.php"; ?>
<?php include "templates/navber.php"; ?>

<?php include "alert/alert_admin.php"; ?>

<?php
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

?>

<div class="container-fluid">
    <div class="row mt-4">

        <div class="col-xl-12 col-md-6 mb-4">
            <div class="card shadow">
                <h5 class="card-header text-uppercase"><strong>Authority</strong></h5>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="d-flex">
                                <div class="mr-auto">
                                    <div class="d-flex align-items-center">
                                        <img class="rounded border border-secondary mr-3" src="../img/photo_emp/square/<?php echo (($LvVerifyResult["EmpUserID"] == NULL) ? "10000" : $LvVerifyResult["EmpUserID"]); ?>.jpg" alt="Images" width="48" height="48">
                                        <div class="lh-100">
                                            <small><?php echo (($LvVerifyResult["EmpUserID"] == NULL) ? "None" : $LvVerifyResult["EmpUserID"]); ?></small> - <small class="badge badge-greenblue power">Verify</small>
                                            <div class="text-truncate">
                                                <small class="mb-0 lh-100"><?php echo $LvVerifyResult["EmpUserName"] . "\n" . $LvVerifyResult["EmpUserSurname"]; ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-dark btn-sm btmodal" data-id="<?php print $LvVerifyResult["EmpUserID"]; ?>" data-author="Verify"><i class="fa fa-edit"></i>&nbsp; Edit</button>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex">
                                <div class="mr-auto">
                                    <div class="d-flex align-items-center">
                                        <img class="rounded border border-secondary mr-3" src="../img/photo_emp/square/<?php echo (($LvPsdResult["EmpUserID"] == NULL) ? "10000" : $LvPsdResult["EmpUserID"]); ?>.jpg" alt="Images" width="48" height="48">
                                        <div class="lh-100">
                                            <small><?php echo (($LvPsdResult["EmpUserID"] == NULL) ? "None" : $LvPsdResult["EmpUserID"]); ?></small> - <small class="badge badge-greenblue power">Approve</small>
                                            <div class="text-truncate">
                                                <small class="mb-0 lh-100"><?php echo $LvPsdResult["EmpUserName"] . "\n" . $LvPsdResult["EmpUserSurname"]; ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-dark btn-sm btmodal" data-id="<?php print $LvPsdResult["EmpUserID"]; ?>" data-author="Approve"><i class="fa fa-edit"></i>&nbsp; Edit</button>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex">
                                <div class="mr-auto">
                                    <div class="d-flex align-items-center">
                                        <img class="rounded border border-secondary mr-3" src="../img/photo_emp/square/<?php echo (($LvVerifyCostResult["EmpUserID"] == NULL) ? "10000" : $LvVerifyCostResult["EmpUserID"]); ?>.jpg" alt="Images" width="48" height="48">
                                        <div class="lh-100">
                                            <small><?php echo (($LvVerifyCostResult["EmpUserID"] == NULL) ? "None" : $LvVerifyCostResult["EmpUserID"]); ?></small> - <small class="badge badge-greenblue power">Verify Cost</small>
                                            <div class="text-truncate">
                                                <small class="mb-0 lh-100"><?php echo $LvVerifyCostResult["EmpUserName"] . "\n" . $LvVerifyCostResult["EmpUserSurname"]; ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-dark btn-sm btmodal" data-id="<?php print $LvVerifyCostResult["EmpUserID"]; ?>" data-author="Verify-Cost"><i class="fa fa-edit"></i>&nbsp; Edit</button>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex">
                                <div class="mr-auto">
                                    <div class="d-flex align-items-center">
                                        <img class="rounded border border-secondary mr-3" src="../img/photo_emp/square/<?php echo (($LvPsdCostResult["EmpUserID"] == NULL) ? "10000" : $LvPsdCostResult["EmpUserID"]); ?>.jpg" alt="Images" width="48" height="48">
                                        <div class="lh-100">
                                            <small><?php echo (($LvPsdCostResult["EmpUserID"] == NULL) ? "None" : $LvPsdCostResult["EmpUserID"]); ?></small> - <small class="badge badge-greenblue power">Approve Cost</small>
                                            <div class="text-truncate">
                                                <small class="mb-0 lh-100"><?php echo $LvPsdCostResult["EmpUserName"] . "\n" . $LvPsdCostResult["EmpUserSurname"]; ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-dark btn-sm btmodal" data-id="<?php print $LvPsdCostResult["EmpUserID"]; ?>" data-author="Approve-Cost"><i class="fa fa-edit"></i>&nbsp; Edit</button>
                                </div>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </div>

    </div><!-- .row -->
</div><!-- .container-fluid -->


<?php include "templates/footer.php"; ?>


  <!-- Modal -->
  <form id="frmAdd" name="frmAdd" action="save/save_edit_flow.php" autocomplete="off" method="POST" target="iframe_flow">
    <div class="modal fade" id="EditRalated" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Related persons</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <input type="hidden" id="inputId" name="inputId" readonly />
            <input type="hidden" id="inputAuthor" name="inputAuthor" readonly />

            <div class="form-group row">
              <label for="inputCheck" class="col-sm-4 col-form-label"><span id="identity"></span> :</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="inputCheck" name="inputCheck" value="" placeholder="" required>
              </div>
            </div>
            <div class="ResultUpdateProfile"></div>

          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success" name="save" onclick="return BTSubmit();"><i class="fa fa-check-circle"></i>&nbsp; Save</button>
            <!--<button type="reset" class="btn btn-dark" name="cancel"><i class="fa fa-refresh"></i>&nbsp; Reset</button>-->
          </div>
        </div>
      </div>
    </div>
  </form>

  <iframe id="iframe_flow" name="iframe_flow" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>

<script type="text/javascript">
    $(".btmodal").click(function() {
        var ids = $(this).attr('data-id');
        var authors = $(this).attr('data-author');
        $("#inputCheck").val(ids);
        $("#inputId").val(ids);
        $("#inputAuthor").val(authors);
        $("#identity").html(authors);
        $('#EditRalated').modal('show');
    });
</script>