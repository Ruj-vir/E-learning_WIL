<?php include "templates/header.php"; ?>
<?php include "templates/navber.php"; ?>

<?php include "alert/alert_authority.php";?>

<?php
if (isset($_GET["ItemReqNo"]) && trim($_GET["ItemReqNo"]) != NULL) {

    $str = trim($_GET["ItemReqNo"]);
    //$FineDataEmp = addslashes($str);
    $vowels = array("'");
    $ItemReqNo = str_replace($vowels, '', $str);

    $ListSql = "SELECT ReqNo, ReqDate, TrnTime, ReqDay, ReqHour, ReqSumTime, 
    ReqIssuer, ReqIssueDate, ReqRemark, UserDefine1, Status,
    convert(nvarchar, GETDATE(), 108) AS Datetimelimit
    FROM ReqInfo WHERE (ReqNo = '$ItemReqNo') AND (ReqType = 4) AND (Status = 9) ";

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

    } else {
        echo "<script>window.location.href='training_confirm.php'</script>";
        exit();
    }
} else {
    echo "<script>window.location.href='training_confirm.php'</script>";
    exit();
}

?>

<div class="container-fluid">

    <form id="formOpening" name="formOpening" action="save/save_confirm_training.php" autocomplete="off" method="POST" target="iframe_confirm_form">

        <input type="hidden" id="inputItemKey" name="inputItemKey" value="<?php print $ListResult["ReqNo"]; ?>" readonly required>
        <input type="hidden" id="inputDateFrom" name="inputDateFrom" value="<?php print date_format($ListResult["ReqDate"], 'Y-m-d H:i'); ?>" readonly required>
        <input type="hidden" id="inputDateTo" name="inputDateTo" value="<?php print date_format($ListResult["TrnTime"], 'Y-m-d H:i'); ?>" readonly required>
        <input type="hidden" id="inputLocation" name="inputLocation" value="<?php print $EleData[3] ;?>" readonly required>
        <input type="hidden" id="inputCourse" name="inputCourse" value="<?php print $ListResult["ReqRemark"]; ?>" readonly required>


        <div class="card shadow my-4">
            <div class="card-header text-uppercase">
                <i class="fas fa-check-double"></i> Course Confirm
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
                        Trainees Total: <span class="font-weight-bold h6 mr-3"><?php print $ReqEmployee; ?></span>
                        <button type="button" class="btn btn-sm btn-dark" id="BttLookModal" title="Trainees list" data-id="<?php echo $ListResult["ReqNo"]; ?>"><i class="fas fa-external-link-alt"></i></button>
                    </div>
                </div>

                <hr>
                <button type="button" class="btn btn-light" onClick="window.location.reload();"><i class="fas fa-sync-alt"></i> Updated at <?php print $ListResult["Datetimelimit"]; ?></button>

                <div class="table-responsive mt-2">
                    <table id="TableConfirm" class="table table-hover nowrap text-truncate" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col"><input type="checkbox" id="select_all" name="select_all[]" value="<?php echo $row["EmpUserID"]; ?>"></th>
                                <th scope="col">#</th>
                                <th scope="col">Name/Surname</th>
                                <th scope="col">Office</th>
                                <th scope="col">Joined on</th>
                                <th scope="col" class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $ConfirmSql = "SELECT dbo.ReqUser.EmpUserID, dbo.ReqUser.EmpUserName, dbo.ReqUser.EmpUserSurname, 
                                dbo.ReqUser.EmpUserPosition, dbo.ReqUser.EmpUserSection, dbo.ReqUser.EmpUserDepartment,
                                EducationSystem.dbo.TrainRecDtl.TrainRecDate, 
                                EducationSystem.dbo.TrainRecDtl.CreateDate, 
                                EducationSystem.dbo.TrainRecDtl.TrainDtlStatus
                                FROM dbo.ReqUser 
                                INNER JOIN EducationSystem.dbo.TrainRecDtl 
                                ON dbo.ReqUser.EmpUserID = EducationSystem.dbo.TrainRecDtl.EmployeeID
                                WHERE (EducationSystem.dbo.TrainRecDtl.TrainRecNo = '$ItemReqNo')
                                ORDER BY EducationSystem.dbo.TrainRecDtl.TrainRecDate ASC";

                            $ConfirmParams = array();
                            $ConfirmOptions =  array("Scrollable" => SQLSRV_CURSOR_KEYSET);
                            $ConfirmStmt = sqlsrv_query($connRequest, $ConfirmSql, $ConfirmParams, $ConfirmOptions);
                            $ConfirmRow = sqlsrv_num_rows($ConfirmStmt);

                            if ($ConfirmRow > 0) {

                                $iNum = 1;
                                $ConfirmQuery = sqlsrv_query($connRequest, $ConfirmSql);
                                while ($ConfirmResult = sqlsrv_fetch_array($ConfirmQuery, SQLSRV_FETCH_ASSOC)) {

                                    switch ($ConfirmResult["TrainDtlStatus"]) {
                                        case 0:
                                            $State = 'Rejected';
                                            $StateColor = 'danger';
                                            break;
                                        case 1:
                                            $State = 'Pending';
                                            $StateColor = 'warning';
                                            break;
                                        case 3:
                                            $State = 'Confirmed';
                                            $StateColor = 'success';
                                            break;
                                    }
                            ?>
                                    <tr class="tr">
                                        <th scope="row">
                                            <input type="checkbox" class="emp_checkbox pointer" name="inputTrainees[]" value="<?php echo $ConfirmResult["EmpUserID"]; ?>">
                                            <input type="checkbox" class="checkdate" name="inputDate[]" value="<?php echo date_format($ConfirmResult["TrainRecDate"], 'Y-m-d') ;?>" readonly required hidden>
                                        </th>
                                        <th scope="row"><?php print $iNum . " )"; ?></th>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img class="rounded-circle border border-secondary mr-2" src="../img/photo_emp/square/<?php echo (($ConfirmResult["EmpUserID"] == NULL) ? '1000' : $ConfirmResult["EmpUserID"]); ?>.jpg" alt="Images" width="48" height="48">
                                                <div class="lh-100">
                                                    <div><?php echo $ConfirmResult["EmpUserID"]; ?></div>
                                                    <div><?php echo $ConfirmResult["EmpUserName"] . "\n" . $ConfirmResult["EmpUserSurname"]; ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div><?php echo $ConfirmResult["EmpUserSection"]; ?></div>
                                            <div><?php echo $ConfirmResult["EmpUserDepartment"]; ?></div>
                                        </td>
                                        <td><?php echo date_format($ConfirmResult["CreateDate"], 'd/m/Y H:i:s'); ?></td>
                                        <td class="text-center">
                                            <span class="badge badge-<?php echo $StateColor; ?>"><?php echo $State; ?></span>
                                        </td>
                                    </tr>
                                <?php
                                    $iNum++;
                                }
                            } else {
                                ?>
                                <tr>
                                    <td class="text-center" colspan="7">No data available in table</td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="form-group">
                    <div id="AddResultOpening"></div>
                </div>

            </div>
            <div class="card-footer">
                <div class="d-flex">
                    <div class="mr-auto">
                        <div class="input-group">
                            <div class="input-group-text"><span id="select_count">0 Selected</span></div>
                        </div>
                    </div>
                    <div class="mr-1"><button type="submit" name="BttConfirmOpen" value="3" class="btn btn-success" onclick="return BttSubmit();"><i class="fa fa-check-circle"></i> Confirm</button></div>
                    <div><button type="submit" name="BttRejectOpen" value="0" class="btn btn-danger" onclick="return BttReset();"><i class="fa fa-times-circle"></i> Reject</button></div>

                    <!--<div class="mr-1"><button type="submit" name="BttSubmitOpen" value="1" class="btn btn-success" onclick="return BttSubmit();"><i class="fa fa-check-circle"></i> Confirm</button></div>
  <div><button type="reset" class="btn btn-danger" onclick="return BttReset();"><i class="fa fa-times-circle"></i> Reject</button></div>-->
                </div>
            </div>
        </div>

    </form>


</div><!-- .container -->


<?php include "templates/footer.php"; ?>


<iframe id="iframe_confirm_form" name="iframe_confirm_form" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>

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

<link href="assets/dataTable/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="assets/dataTable/export/buttons.bootstrap4.min.css" rel="stylesheet">

<script src="assets/dataTable/jquery.dataTables.min.js"></script>
<script src="assets/dataTable/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#TableConfirm').DataTable({
            "paging": false,
            "lengthChange": true,
            "searching": false,
            "ordering": true,
            "info": false,
            "autoWidth": true,
            //'order': [2, 'asc'],
            //'order': [1,2, 'desc'],
            //'order': false,
            'lengthMenu': [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            'columnDefs': [{
                    'targets': [0],
                    'searchable': false,
                    'orderable': false
                },
                //{'targets': [ 4 ],"visible": false}
            ]
        });
    });
</script>

<script type="text/javascript">
  $(':checkbox').on('change', function() {
      $(this).closest('tr').find(':checkbox').prop('checked', this.checked);
  });
</script>

<script type="text/javascript">
    function TrainingResult(AddResult) {
        if (AddResult == 1) {
            $("#AddResultOpening").html("<div class='alert alert-success text-center' role='alert'>Successfully</div>");
            setInterval('window.location.href = "training_confirm_detail.php?ItemReqNo=<?php echo $ItemReqNo ;?>&j0dsu36gpd9gsu9sdj9"', 1000);
        } else {
            $('#AddResultOpening').html("<div class='alert alert-danger text-center' role='alert'>Unsuccessful</div>");
        }
    }
</script>

<script type="text/javascript">
    function BttSubmit() {
        if (!$('.emp_checkbox').is(':checked')) {
            alert('Please select trainees.');
            return false;
        } else if (confirm('Are you sure you want to submit the form ?') == true) {
            return true;
        } else {
            return false;
        }
    }

    function BttReset() {
        if (confirm('Are you sure you want to cancel ?') == true) {
            //window.location.reload();
            //$('#formOpening')[0].reset();
            return true;
        } else {
            return false;
        }
    }
</script>

<script type="text/javascript">
    $('document').ready(function() {
        // select all checkbox
        $(document).on('click', '#select_all', function() {
            $(".emp_checkbox, .checkdate").prop("checked", this.checked);
            $("#select_count").html($("input.emp_checkbox:checked").length + " Selected");
        });
        $(document).on('click', '.emp_checkbox', function() {
            if ($('.emp_checkbox:checked').length == $('.emp_checkbox').length) {
                $('#select_all').prop('checked', true);
            } else {
                $('#select_all').prop('checked', false);
            }
            $("#select_count").html($("input.emp_checkbox:checked").length + " Selected");
        });
    });
</script>