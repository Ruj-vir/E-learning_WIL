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

    } else {
        echo "<script>window.location.href='training_close.php'</script>";
        exit();
    }
} else {
    echo "<script>window.location.href='training_close.php'</script>";
    exit();
}

?>

<div class="container-fluid">

    <form id="formClosing" name="formClosing" action="save/save_closing_training.php" autocomplete="off" method="POST" target="iframe_closing_form">

        <input type="hidden" id="inputItemKey" name="inputItemKey" value="<?php print $ListResult["ReqNo"]; ?>" readonly required>
        <input type="hidden" id="inputDateFrom" name="inputDateFrom" value="<?php print date_format($ListResult["ReqDate"], 'Y-m-d H:i'); ?>" readonly required>
        <input type="hidden" id="inputDateTo" name="inputDateTo" value="<?php print date_format($ListResult["TrnTime"], 'Y-m-d H:i'); ?>" readonly required>
        <input type="hidden" id="inputLocation" name="inputLocation" value="<?php $EleData = explode('|', $ListResult["UserDefine1"] ); print $EleData[3] ;?>" readonly required>
        <input type="hidden" id="inputCourse" name="inputCourse" value="<?php print $ListResult["ReqRemark"]; ?>" readonly required>

        <div class="card my-4">
            <div class="card-header text-uppercase">
                <i class="fas fa-door-closed"></i> Course Closing
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
                <button type="button" class="btn btn-light" onClick="window.location.reload();"><i class="fas fa-sync-alt"></i> Updated at <?php print $ListResult["Datetimelimit"]; ?></button>

                <div class="table-responsive mt-2">
                    <table id="TableClosing" class="table table-hover nowrap text-truncate" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name/Surname</th>
                                <th scope="col">Office</th>
                                <th scope="col" class="text-center">Attach</th>
                                <th scope="col" style="width: 140px;">Score</th>
                                <th scope="col">Result</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $ClosingSql = "SELECT DISTINCT 
                                dbo.ReqUser.EmpUserID, 
                                dbo.ReqUser.EmpUserName, 
                                dbo.ReqUser.EmpUserSurname, 
                                dbo.ReqUser.EmpUserPosition, 
                                dbo.ReqUser.EmpUserSection, 
                                dbo.ReqUser.EmpUserDepartment,
                                EducationSystem.dbo.TrainRecDtl.PicturePath
                                FROM dbo.ReqUser 
                                INNER JOIN EducationSystem.dbo.TrainRecDtl 
                                ON dbo.ReqUser.EmpUserID = EducationSystem.dbo.TrainRecDtl.EmployeeID
                                WHERE (EducationSystem.dbo.TrainRecDtl.TrainRecNo = '$ItemReqNo')
                                AND (EducationSystem.dbo.TrainRecDtl.TrainDtlStatus = 3)
                                ORDER BY dbo.ReqUser.EmpUserID ASC";

                            $ClosingParams = array();
                            $ClosingOptions =  array("Scrollable" => SQLSRV_CURSOR_KEYSET);
                            $ClosingStmt = sqlsrv_query($connRequest, $ClosingSql, $ClosingParams, $ClosingOptions);
                            $ClosingRow = sqlsrv_num_rows($ClosingStmt);

                            if ($ClosingRow > 0) {

                                $iNum = 1;
                                $ClosingQuery = sqlsrv_query($connRequest, $ClosingSql);
                                while ($ClosingResult = sqlsrv_fetch_array($ClosingQuery, SQLSRV_FETCH_ASSOC)) {

                            ?>
                                    <tr class="tr">
                                        <th scope="row"><?php print $iNum . " )"; ?></th>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img class="rounded-circle border border-secondary mr-2" src="../img/photo_emp/square/<?php echo (($ClosingResult["EmpUserID"] == NULL) ? '1000' : $ClosingResult["EmpUserID"]); ?>.jpg" alt="Images" width="48" height="48">
                                                <div class="lh-100">
                                                    <div><?php echo $ClosingResult["EmpUserID"]; ?></div>
                                                    <div><?php echo $ClosingResult["EmpUserName"] . "\n" . $ClosingResult["EmpUserSurname"]; ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div><?php echo $ClosingResult["EmpUserSection"]; ?></div>
                                            <div><?php echo $ClosingResult["EmpUserDepartment"]; ?></div>
                                        </td>
                                        <td class="text-center"><button type="button" class="btn btn-sm btn-outline-dark BttAttachFile" title="Attach file" data-id="<?php echo $ItemReqNo; ?>" data-emp="<?php echo $ClosingResult["EmpUserID"]; ?>"><i class="fas fa-paperclip"></i></button></td>
                                        <td>
                                            <div style="width: 140px;">
                                                <input type="hidden" class="form-control form-control-sm" id="inputEmpID" name="inputEmpID[<?php echo $ClosingResult["EmpUserID"]; ?>]" required placeholder="" value="<?php echo $ClosingResult["EmpUserID"]; ?>">
                                                <input type="number" class="form-control form-control-sm" id="inputScore" name="inputScore[<?php echo $ClosingResult["EmpUserID"]; ?>]" required min="0" placeholder="">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-toggle w-50" data-toggle="buttons">
                                                <label class="btn btn-outline-success btn-sm">
                                                    <input type="radio" name="inputResult[<?php echo $ClosingResult["EmpUserID"]; ?>]" value="1" autocomplete="off" required><i class="fas fa-check-circle"></i> Pass
                                                </label>
                                                <label class="btn btn-outline-danger btn-sm">
                                                    <input type="radio" name="inputResult[<?php echo $ClosingResult["EmpUserID"]; ?>]" value="0" autocomplete="off" required><i class="fa fa-times-circle"></i> Fail
                                                </label>
                                            </div>
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
                    <div id="AddResultClosing"></div>
                </div>

            </div>
            <div class="card-footer">
                <div class="d-flex">
                    <div class="mr-auto">
                        <strong class="mr-2">Total: <?php echo $ClosingRow; ?></strong>
                    </div>
                    <div class="mr-1"><button type="submit" name="BttCourseClosing" value="6" class="btn btn-success" onclick="return BttSubmit();"><i class="fa fa-check-circle"></i> Save & Course closing</button></div>
                    <div><button type="button" class="btn btn-danger" onclick="return BttReset();"><i class="fa fa-times-circle"></i> Reset</button></div>

                    <!--<div class="mr-1"><button type="submit" name="BttSubmitOpen" value="1" class="btn btn-success" onclick="return BttSubmit();"><i class="fa fa-check-circle"></i> Confirm</button></div>
  <div><button type="reset" class="btn btn-danger" onclick="return BttReset();"><i class="fa fa-times-circle"></i> Reject</button></div>-->
                </div>
            </div>
        </div>

    </form>


</div><!-- .container -->


<?php include "templates/footer.php"; ?>


<iframe id="iframe_closing_form" name="iframe_closing_form" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>

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

  <!-- Modal -->
  <div class="modal fade" id="AttachmentModal" tabindex="-1" role="dialog" aria-labelledby="AttachmenTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header text-greenblue">
          <h5 class="modal-title" id="AttachmenTitle">Attachment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        
            <input type="hidden" id="ItemReqNo" name="ItemReqNo" readonly>
            <input type="hidden" id="ItemEmp" name="ItemEmp" readonly>
            <div id="attach_order"></div>
            
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->

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

<script type="text/javascript">
//! Check Modal AttachFile'
  $(document).ready(function() {
    $('.BttAttachFile').click(function() {
      var ids = $(this).attr('data-id');
      var emps = $(this).attr('data-emp');
      $("#ItemReqNo").val(ids);
      $("#ItemEmp").val(emps);
      $('#AttachmentModal').modal('show');
      var ItemReqNo = $('#ItemReqNo').val();
      var ItemEmp = $('#ItemEmp').val();
      if (ItemReqNo != '' && ItemEmp != '') {
        $.ajax({
          url: "return/return_closing_attach.php",
          method: "POST",
          data: {
            Item_ReqNo: ItemReqNo,
            Item_Emp: ItemEmp
          },
          success: function(data) {
            $('#attach_order').html("" + $.trim(data) + "");
          }
        });
      }
      /*else {
        alert("Please select the employee!!");
      }*/
    });
  });
  //! Check Modal AttachFile'
</script>

<link href="assets/dataTable/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="assets/dataTable/export/buttons.bootstrap4.min.css" rel="stylesheet">

<script src="assets/dataTable/jquery.dataTables.min.js"></script>
<script src="assets/dataTable/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#TableClosing').DataTable({
            "paging": false,
            "lengthChange": true,
            "searching": false,
            "ordering": true,
            "info": false,
            "autoWidth": true,
            'order': [1, 'asc'],
            //'order': [1,2, 'desc'],
            //'order': false,
            'lengthMenu': [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            'columnDefs': [{
                    'targets': [3,4,5],
                    'searchable': false,
                    'orderable': false
                },
                //{'targets': [ 4 ],"visible": false}
            ]
        });
    });
</script>

<script type="text/javascript">
    function TrainingResult(AddResult) {
        if (AddResult == 1) {
            $("#AddResultClosing").html("<div class='alert alert-success text-center' role='alert'>Successfully</div>");
            setInterval('window.location.href = "training_close.php?ItemReqNo=<?php echo $ItemReqNo; ?>&j0dsu36gpd9gsu9sdj9"', 1000);
        } else {
            $('#AddResultClosing').html("<div class='alert alert-danger text-center' role='alert'>Unsuccessful</div>");
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
            window.location.reload();
            //$('#formClosing')[0].reset();
            //return true;
        } else {
            return false;
        }
    }
</script>

