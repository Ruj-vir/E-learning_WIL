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
    ReqHour, ReqRemark, ReqSumTime, ReqRemark, UserDefine1, Status
    
    FROM ReqInfo
    WHERE (ReqNo NOT IN (SELECT TrainRecNo FROM EducationSystem.dbo.TrainRecHdr)) 
    AND (ReqType = 4) AND (Status = 6)";

    $ListIParams = array();
    $ListIOptions =  array("Scrollable" => SQLSRV_CURSOR_KEYSET);
    $ListIStmt = sqlsrv_query($connRequest, $ListSql, $ListIParams, $ListIOptions);
    $ListIRow = sqlsrv_num_rows($ListIStmt);

    if ($ListIRow > 0) {

        $ListObj = sqlsrv_query($connRequest, $ListSql);
        $ListResult = sqlsrv_fetch_array($ListObj, SQLSRV_FETCH_ASSOC);
        
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
        <input type="hidden" id="inputLocation" name="inputLocation" value="<?php $EleData = explode('|', $ListResult["UserDefine1"] ); print $EleData[3] ;?>" readonly required>
        <input type="hidden" id="inputCourse" name="inputCourse" value="<?php print $ListResult["ReqRemark"]; ?>" readonly required>


        <div class="card my-4">
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
                        Trainees Total: <span class="font-weight-bold h6 mr-3"><?php print $ListIRow; ?></span>
                        <button type="button" class="btn btn-sm btn-dark" id="BttLookModal" title="Trainees list" data-id="<?php echo $ListResult["ReqNo"]; ?>"><i class="fas fa-external-link-alt"></i></button>
                    </div>
                </div>

                <hr>

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
                            <option value="" disabled="disabled" selected="selected">- Please select menu -</option>
                            <option value="1">Orientation</option>
                            <option value="2">OJT</option>
                            <option value="3">Refreshing</option>
                            <option value="4">On going</option>
                            <option value="5">Public</option>
                            <option value="6">Other</option>
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
                    <button type="submit" name="BttSubmitOpen" value="1" class="btn btn-success" onclick="return BttSubmit();"><i class="fa fa-check-circle"></i> Save</button>
                    <button type="reset" class="btn btn-danger" onclick="return BttReset();"><i class="fa fa-times-circle"></i> Reset</button>
                </div>
            </div>
        </div>

    </form>
    <iframe id="iframe_edit_form" name="iframe_edit_form" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>

</div><!-- .container -->


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
        if (confirm('Are you sure you want to cancel ?') == true) {
            //window.location.reload();
            $('#formOpening')[0].reset();
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