<?php include "templates/header.php"; ?>
<?php include "templates/navber.php"; ?>

<?php
if (isset($_GET["ItemReqNo"]) && trim($_GET["ItemReqNo"]) != NULL) {

    $str = trim($_GET["ItemReqNo"]);
    //$FineDataEmp = addslashes($str);
    $vowels = array("'");
    $ItemReqNo = str_replace($vowels, '', $str);

    $ListSql = "SELECT ReqNo, ReqDate, TrnTime, ReqDay, ReqHour, ReqSumTime, 
    ReqIssuer, ReqIssueDate, ReqRemark, UserDefine1, PicturePath, Status
    FROM ReqInfo 
    WHERE (EmployeeID = '$SesUserID') 
    AND (ReqNo = '$ItemReqNo') 
    AND (ReqType = 4) 
    --AND (Status = 6) ";

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

        $EleData = explode('|', $ListResult["UserDefine1"]);
        $Status = $ListResult["Status"];
        $ReqIssuer = $ListResult["ReqIssuer"];

        switch ($Status) {
            case 0:
                $StatusReq = 'Rejected';
                $StatusColor = 'danger';
                break;
            case 1:
                $StatusReq = 'Check';
                $StatusColor = 'warning';
                break;
            case 2:
                $StatusReq = 'Verify';
                $StatusColor = 'warning';
                break;
            case 3:
                $StatusReq = 'Approve';
                $StatusColor = 'warning';
                break;
            case 6:
                $StatusReq = 'Approved';
                $StatusColor = 'success';
                break;
            case 9:
                $StatusReq = 'Approved';
                $StatusColor = 'success';
                break;
            default:
                $StatusReq = '';
                $StatusColor = '';
        }
    } else {
        echo "<script type=text/javascript>javascript:history.back(1);</script>";
        // echo "<script>window.location.href='profile_user.php'</script>";
        // echo "<script>window.close();</script>";
        exit();
    }
} else {
    echo "<script type=text/javascript>javascript:history.back(1);</script>";
    // echo "<script>window.location.href='profile_user.php'</script>";
    // echo "<script>window.close();</script>";
    exit();
}
?>

<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12 col-md-6 mb-4">
            <div class="card shadow my-4">
                <div class="card-header text-uppercase">
                    <i class="fab fa-discourse"></i> Course Detail
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
                            Object: <span class="font-weight-bold h6"><?php print $EleData[1]; ?></span>
                        </div>
                        <div class="col-sm-6 mb-2">
                            Organizer: <span class="font-weight-bold h6"><?php print $EleData[2]; ?></span>
                        </div>
                        <div class="col-sm-6 mb-2">
                            Location: <span class="font-weight-bold h6"><?php print $EleData[3]; ?></span>
                        </div>
                        <div class="col-sm-6 mb-2">
                            Trainees Total: <span class="font-weight-bold h6 mr-3"><?php print $ReqEmployee; ?></span>
                            <button type="button" class="btn btn-sm btn-dark" id="BttLookModal" title="Trainees list" data-id="<?php echo $ListResult["ReqNo"]; ?>"><i class="fas fa-external-link-alt"></i></button>
                        </div>
                    </div>
                    <hr>
                    <?php
                    $EmpDtlSql = "SELECT  
    TrainRecScore, 
    TrainRecResult
    FROM TrainRecDtl 
    WHERE (TrainRecNo = '$ItemReqNo') 
    AND (EmployeeID = '$SesUserID')
    AND (TrainDtlStatus = 6)";
                    $EmpDtlObj = sqlsrv_query($connEducation, $EmpDtlSql);
                    $EmpDtlResult = sqlsrv_fetch_array($EmpDtlObj, SQLSRV_FETCH_ASSOC);
                    ?>
                    <div class="row">
                        <div class="col-sm-6 mb-2">
                            Score: <span class="font-weight-bold h6"><?php print(($EmpDtlResult["TrainRecScore"] == NULL) ? "None" : round($EmpDtlResult["TrainRecScore"], 2)); ?></span>
                        </div>
                        <div class="col-sm-6 mb-2">
                            Result: <span class="font-weight-bold h6"><?php print(($EmpDtlResult["TrainRecResult"] == 1) ? "PASS" : "FAIL"); ?></span>
                        </div>
                        <div class="col-sm-6 mb-2">
                            Status: <span class="badge badge-<?php print $StatusColor; ?>"><?php print $StatusReq; ?></span>
                        </div>
                        <div class="col-sm-6 mb-2">
                            Comment: <span class="font-weight-bold h6"><?php print(($EleData[4] == NULL) ? "None" : $EleData[4]); ?></span>
                        </div>
                        <div class="col-sm-6 mb-2">
                            <?php
                            $EmpUserSql = "SELECT  
    EmpUserID, 
    EmpUserName,
    EmpUserSurname
    FROM ReqUser 
    WHERE (EmpUserID = '$ReqIssuer')";
                            $EmpUserObj = sqlsrv_query($connRequest, $EmpUserSql);
                            $EmpUserResult = sqlsrv_fetch_array($EmpUserObj, SQLSRV_FETCH_ASSOC);
                            ?>
                            Requestor: <span class="font-weight-bold h6"><?php print $EmpUserResult["EmpUserID"] . " - " . $EmpUserResult["EmpUserName"] . "\n" . $EmpUserResult["EmpUserSurname"]; ?></span>
                        </div>
                        <div class="col-sm-6 mb-2">
                            Attachment:
                            <?php
                            if (substr($ListResult["PicturePath"], 18) != NULL) {
                            ?>
                                <a href="assets/img/request/<?php print((substr($ListResult["PicturePath"], 18) != NULL) ? $ListResult["PicturePath"] : 'index.html'); ?>" target="_blank"><i class="far fa-window-restore"></i> More..</a>
                            <?php
                            } else {
                                print "<strong>None</strong>";
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                    if (substr($ListResult["PicturePath"], 18) != NULL) {
                    ?>
                        <div class="embed-responsive embed-responsive-4by3 mb-3">
                            <iframe class="embed-responsive-item" src="assets/img/request/<?php print((substr($ListResult["PicturePath"], 18) != NULL) ? $ListResult["PicturePath"] : 'index.html'); ?>"></iframe>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>

    </div><!-- .row -->
</div><!-- .container-fluid -->

<?php include "templates/footer.php"; ?>

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