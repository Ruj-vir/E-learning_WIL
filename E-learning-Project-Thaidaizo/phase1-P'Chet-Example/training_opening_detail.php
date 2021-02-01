<?php include "templates/header.php"; ?>
<?php include "templates/navber.php"; ?>

<?php include "alert/alert_authority.php";?>

<?php
if (isset($_GET["ItemReqNo"]) && trim($_GET["ItemReqNo"]) != NULL) {
    
    $str = trim($_GET["ItemReqNo"]);
    //$FineDataEmp = addslashes($str);
    $vowels = array("'");
    $ItemReqNo = str_replace($vowels, '', $str);
    
    $ListSql = "SELECT DISTINCT ReqNo, ReqDate, TrnTime, ReqDay, 
    ReqHour, ReqRemark, ReqSumTime, ReqOTType, ReqRemark, UserDefine1, PicturePath, Status
    FROM ReqInfo
    WHERE (ReqNo NOT IN (SELECT TrainRecNo FROM EducationSystem.dbo.TrainRecHdr)) 
    AND (ReqType = 4) AND (Status = 6) AND (ReqNo='$ItemReqNo')";

    $ListIParams = array();
    $ListIOptions =  array("Scrollable" => SQLSRV_CURSOR_KEYSET);
    $ListIStmt = sqlsrv_query($connRequest, $ListSql, $ListIParams, $ListIOptions);
    $ListIRow = sqlsrv_num_rows($ListIStmt);

    if ($ListIRow > 0) {

        $ListObj = sqlsrv_query($connRequest, $ListSql);
        $ListResult = sqlsrv_fetch_array($ListObj, SQLSRV_FETCH_ASSOC);

        $CountSql = "SELECT COUNT(ReqNo) AS ReqEmployee FROM ReqInfo WHERE (ReqType = 4) AND (ReqNo='$ItemReqNo')";
        $CountObj = sqlsrv_query($connRequest, $CountSql);
        $CountResult = sqlsrv_fetch_array($CountObj, SQLSRV_FETCH_ASSOC);
        $ReqEmployee = $CountResult["ReqEmployee"];

        $EleData = explode('|', $ListResult["UserDefine1"] );

        switch ($ListResult["ReqOTType"]) {
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
        
    } else {
        echo "<script>window.location.href='training_opening.php'</script>";
        exit();
    }
} else {
    echo "<script>window.location.href='training_opening.php'</script>";
    exit();
}
?>

<div class="container-fluid">

    <form id="formOpening" name="formOpening" action="save/save_opening_training.php" autocomplete="off" method="POST" target="iframe_edit_form">
    
    <input type="hidden" id="inputItemKey" name="inputItemKey" value="<?php print $ListResult["ReqNo"] ;?>" readonly required>
    <input type="hidden" id="inputDateFrom" name="inputDateFrom" value="<?php print date_format($ListResult["ReqDate"], 'Y-m-d H:i') ;?>" readonly required>
    <input type="hidden" id="inputDateTo" name="inputDateTo" value="<?php print date_format($ListResult["TrnTime"], 'Y-m-d H:i') ;?>" readonly required>
    <input type="hidden" id="inputObject" name="inputObject" value="<?php print $EleData[1] ;?>" readonly required>
    <input type="hidden" id="inputOrganizer" name="inputOrganizer" value="<?php print $EleData[2] ;?>" readonly required>
    <input type="hidden" id="inputLocation" name="inputLocation" value="<?php print $EleData[3] ;?>" readonly required>
    <input type="hidden" id="inputCourse" name="inputCourse" value="<?php print $ListResult["ReqRemark"]; ?>" readonly required>

    <input type="hidden" id="inputTotalDay" name="inputTotalDay" value="<?php print round($ListResult["ReqDay"], 2); ?>" readonly required>
    <input type="hidden" id="inputTotalHour" name="inputTotalHour" value="<?php print round($ListResult["ReqHour"], 2); ?>" readonly required>
    <input type="hidden" id="inputCost" name="inputCost" value="<?php print number_format($ListResult["ReqSumTime"], 2); ?>" readonly required>
    <input type="hidden" id="inputPicture" name="inputPicture" value="<?php print $ListResult["PicturePath"]; ?>" readonly required>


        <div class="card shadow my-4">
            <div class="card-header text-uppercase">
                <i class="fas fa-border-all"></i> Course Opening
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 mb-2">
                        Course: <span class="font-weight-bold h6"><?php print $ListResult["ReqRemark"] ?></span>
                    </div>
                    <div class="col-sm-6 mb-2">
                        Date: <span class="font-weight-bold h6"><?php print date_format($ListResult["ReqDate"], 'd M. Y') . " - " . date_format($ListResult["TrnTime"], 'd M. Y') ?></span>
                    </div>
                    <div class="col-sm-6 mb-2">
                        Time: <span class="font-weight-bold h6"><?php print date_format($ListResult["ReqDate"], 'H:i') . " - " . date_format($ListResult["TrnTime"], 'H:i') ?></span>
                    </div>
                    <div class="col-sm-6 mb-2">
                        Duration: <span class="font-weight-bold h6"><?php print round($ListResult["ReqDay"], 2) . "Day, " . round($ListResult["ReqHour"], 2) . "Hrs" ?></span>
                    </div>
                    <div class="col-sm-6 mb-2">
                        Cost: <span class="font-weight-bold h6"><?php print number_format($ListResult["ReqSumTime"], 2) ?> THB</span>
                    </div>
                    <div class="col-sm-6 mb-2">
                        Object: <span class="font-weight-bold h6"><?php print $EleData[1] ;?></span>
                    </div>
                    <div class="col-sm-6 mb-2">
                        Organizer: <span class="font-weight-bold h6"><?php print $EleData[2] ;?></span>
                    </div>
                    <div class="col-sm-6 mb-2">
                        Location: <span class="font-weight-bold h6"><?php print $EleData[3] ;?></span>
                    </div>
                    <div class="col-sm-6 mb-2">
                        Type: <span class="font-weight-bold h6 mr-3"><?php print $TrainRecType; ?></span>
                    </div>
                    <div class="col-sm-6 mb-2">
                        Trainees Total: <span class="font-weight-bold h6 mr-3"><?php print $ReqEmployee; ?></span>
                        <button type="button" class="btn btn-sm btn-greenblue" id="BttLookModal" title="Trainees list" data-id="<?php echo $ListResult["ReqNo"]; ?>"><i class="fas fa-external-link-alt"></i></button>
                    </div>
    <div class="col-sm-6 mb-2">
    Attachment:
    <?php
    if (substr($ListResult["PicturePath"], 18) != NULL) {
        echo '<button type="button" class="btn btn-greenblue btn-sm" data-toggle="modal" data-target="#AttachmentModal"><i class="fas fa-paperclip"></i></button>';
    } else {
        echo '<span class="font-weight-bold h6">none</span>';
    }
    ?>
    </div>
                </div>

  <!-- AttachmentModal -->
  <div class="modal fade" id="AttachmentModal" tabindex="-1" role="dialog" aria-labelledby="AttachmenTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header text-greenblue">
          <h5 class="modal-title" id="AttachmenTitle">Attachment</h5>
          <button type="button" class="close attachment-close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        
              <div class="embed-responsive embed-responsive-4by3 mb-3">
                <iframe class="embed-responsive-item" src="assets/img/request/<?php echo ((substr($ListResult["PicturePath"], 18) != NULL) ? $ListResult["PicturePath"] : 'index.html') ;?>"  ></iframe>
              </div>
              <a href="assets/img/request/<?php echo ((substr($ListResult["PicturePath"], 18) != NULL) ? $ListResult["PicturePath"] : 'index.html') ;?>" target="_blank"><i class="far fa-window-restore"></i> More..</a> 

        </div>
      </div>
    </div>
  </div>
  <!-- AttachmentModal -->

                <hr class="border border-secondary">

                <div class="form-group row justify-content-center">
                    <label for="inputTrainer" class="col-sm-3 col-form-label">Trainer:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="inputTrainer" name="inputTrainer" required placeholder="Enter Name Surname">
                    </div>
                </div>
                <div class="form-group row justify-content-center">
                    <label for="inputTrainingType" class="col-sm-3 col-form-label">Training Type:</label>
                    <div class="col-sm-6">
                        <select id="inputTrainingType" name="inputTrainingType" class="custom-select" required>
                            <!-- <option value="" disabled="disabled" selected="selected">- Please select menu -</option> -->
                            <option value="1" <?php print (($ListResult["ReqOTType"] == 1) ? 'selected="selected"' : "") ;?>>Orientation</option>
                            <option value="2" <?php print (($ListResult["ReqOTType"] == 2) ? 'selected="selected"' : "") ;?>>OJT</option>
                            <option value="3" <?php print (($ListResult["ReqOTType"] == 3) ? 'selected="selected"' : "") ;?>>Reskill<!--Refreshing--></option>
                            <option value="4" <?php print (($ListResult["ReqOTType"] == 4) ? 'selected="selected"' : "") ;?>>Upskill<!--On going--></option>
                            <option value="5" <?php print (($ListResult["ReqOTType"] == 5) ? 'selected="selected"' : "") ;?>>Public</option>
                            <option value="6" <?php print (($ListResult["ReqOTType"] == 6) ? 'selected="selected"' : "") ;?>>Other</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row justify-content-center">
                    <label for="inputEvaluation" class="col-sm-3 col-form-label">Evaluation:</label>
                    <div class="col-sm-6">
                        <select id="inputEvaluation" name="inputEvaluation" class="custom-select" required>
                            <option value="" disabled="disabled" selected="selected">- Please select menu -</option>
                            <option value="1">Work shop</option>
                            <option value="2">Theory</option>
                            <option value="3">Other</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div id="AddResultOpening"></div>
                </div>

            </div>
            <div class="card-footer">
                <div class="float-right">
                    <button type="submit" name="BttSubmitOpen" value="1" class="btn btn-success" onclick="return BttSubmit();"><i class="fa fa-check-circle"></i> Opening Course</button>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#Cancel_modal"><i class="fa fa-times-circle"></i> Reject</button>
                </div>
            </div>
        </div>

    </form>


<form id="formRejected" name="formRejected" action="save/save_opening_training.php" autocomplete="off" method="POST" target="iframe_reject_form">

    <input type="hidden" id="" name="inputItemKey" value="<?php print $ListResult["ReqNo"] ;?>" readonly required>
    <input type="hidden" id="" name="inputDateFrom" value="<?php print date_format($ListResult["ReqDate"], 'Y-m-d H:i') ;?>" readonly required>
    <input type="hidden" id="" name="inputDateTo" value="<?php print date_format($ListResult["TrnTime"], 'Y-m-d H:i') ;?>" readonly required>
    <input type="hidden" id="" name="inputObject" value="<?php print $EleData[1] ;?>" readonly required>
    <input type="hidden" id="" name="inputOrganizer" value="<?php print $EleData[2] ;?>" readonly required>
    <input type="hidden" id="" name="inputLocation" value="<?php print $EleData[3] ;?>" readonly required>
    <input type="hidden" id="" name="inputCourse" value="<?php print $ListResult["ReqRemark"]; ?>" readonly required>

    <input type="hidden" id="" name="inputTotalDay" value="<?php print round($ListResult["ReqDay"], 2); ?>" readonly required>
    <input type="hidden" id="" name="inputTotalHour" value="<?php print round($ListResult["ReqHour"], 2); ?>" readonly required>
    <input type="hidden" id="" name="inputCost" value="<?php print number_format($ListResult["ReqSumTime"], 2); ?>" readonly required>
    <input type="hidden" id="" name="inputPicture" value="<?php print $ListResult["PicturePath"]; ?>" readonly required>

            <!-- Modal -->
            <div class="modal fade" id="Cancel_modal" tabindex="-1" role="dialog" aria-labelledby="Status_title" aria-hidden="true">
              <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header text-greenblue">
                    <h5 class="modal-title" id="Status_title">Rejected</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">

                    <div class="form-group">
                      <label for="inputReason">Reason for cancellation</label>
                      <textarea class="form-control" id="inputReject" name="inputReject" rows="3" maxlength="50" placeholder="Enter.."></textarea>
                    </div>

                  </div>
                  <div class="modal-footer">
                    <button type="submit" name="BttSubmitOpen" value="0" class="btn btn-danger" onclick="return BttReset();">Confirm</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- Modal -->
</form>


</div><!-- .container -->

<iframe id="iframe_edit_form" name="iframe_edit_form" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
<iframe id="iframe_reject_form" name="iframe_reject_form" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>

<?php include "templates/footer.php"; ?>


<script type="text/javascript">
    function TrainingResult(AddResult) {
        if (AddResult == 1) {
            $("#AddResultOpening").html("<div class='alert alert-success text-center' role='alert'>Successfully</div>");
            setInterval('window.location.href = "training_opening.php"', 1000);
        } else {
            $('#AddResultOpening').html("<div class='alert alert-danger text-center' role='alert'>Unsuccessful</div>");
        }
    }
</script>


<script type="text/javascript">
    function BttSubmit() {
        if (confirm('Are you sure you want to submit the form ?') == true) {
            return true;
        } else {
            return false;
        }
    }

    function BttReset() {
        if (confirm('Are you sure you want to reject the form ?') == true) {
            //window.location.reload();
            //$('#formOpening')[0].reset();
            return true;
        } else {
            return false;
        }
    }
</script>



<div class="modal fade" id="ModalTraineesList" tabindex="-1" role="dialog" aria-labelledby="reque_title" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header text-greenblue">
                <h5 class="modal-title" id="reque_title">Requested trainees</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="inputReqNo" name="inputReqNo" readonly>
                <div id="emp_order"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    //! Check Modal Start
    $(document).ready(function() {
        $('#BttLookModal').click(function() {
            var ids = $(this).attr('data-id');
            $("#inputReqNo").val(ids);
            $('#ModalTraineesList').modal('show');
            var ItemReqNo = $('#inputReqNo').val();
            if (ItemReqNo != '') {
                $.ajax({
                    url: "return/return_course_opening.php",
                    method: "POST",
                    data: {
                        ItemReqNo: ItemReqNo
                    },
                    success: function(data) {
                        $('#emp_order').html("" + $.trim(data) + "");
                    }
                });
            }
            /*else {
              alert("Please select the employee!!");
            }*/
        });
    });
    //! Check Modal End
</script>