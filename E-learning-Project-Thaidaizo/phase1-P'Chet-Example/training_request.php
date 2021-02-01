<?php include "templates/header.php"; ?>
<?php include "templates/navber.php"; ?>

<style>
    .boxhide {
        display: none;
    }

    label {
        font-size: 14px;
        color: #6c757d;
    }

    .custom-scrollbar {
        position: relative;
        height: 340px;
        overflow: auto;
        /* border: 0.5px solid #e6e6e6; border-radius: 0px; */
    }

    .table-wrapper-scroll-y {
        display: block;
    }

    .pointer {
        cursor: pointer;
    }
</style>

<div class="container-fluid">
    <div class="row my-4">

        <div class="col-lg-9 col-md-6">

            <form id="formRequest" name="formRequest" class="form" action="save/save_request_training.php" enctype="multipart/form-data" autocomplete="off" method="post" target="iframe_Req">
                <div class="card shadow">
                    <div class="card-header text-uppercase">
                        <i class="fas fa-file-signature"></i> Request
                    </div>
                    <div class="card-body">

                        <div class="row justify-content-center">
                            <div class="col-lg-8">

                                <div class="form-group">
                                    <label for="inputCourse">Training Course :</label>
                                    <input type="text" class="form-control" id="inputCourse" name="inputCourse" maxlength="250" placeholder="" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputObject">Object :</label>
                                    <textarea class="form-control" id="inputObject" name="inputObject" rows="3" maxlength="150" required placeholder=""></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="inputOrganizer">Organizer :</label>
                                    <input type="text" class="form-control" id="inputOrganizer" name="inputOrganizer" maxlength="80" placeholder="" required>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="inputDateFrom">From date :</label>
                                        <input type="date" class="form-control" id="inputDateFrom" name="inputDateFrom" value="<?php echo date('Y-m-d', strtotime('+3 day')); ?>" required placeholder="">
                                    </div>
                                    <div class="form-group col">
                                        <label for="inputDateTo">To date :</label>
                                        <input type="date" class="form-control" id="inputDateTo" name="inputDateTo" value="<?php echo date('Y-m-d', strtotime('+3 day')); ?>" required placeholder="">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="inputTimeFrom">From time :</label>
                                        <input type="time" class="form-control" id="inputTimeFrom" name="inputTimeFrom" value="<?php echo date('H:i'); ?>" required placeholder="">
                                    </div>
                                    <div class="form-group col">
                                        <label for="inputTimeTo">To time :</label>
                                        <input type="time" class="form-control" id="inputTimeTo" name="inputTimeTo" value="" required placeholder="">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="inputDurationDay">Training Day :</label>
                                        <input type="number" required class="form-control" id="inputDurationDay" name="inputDurationDay" min="0" step="0.5" placeholder="" require>
                                    </div>
                                    <div class="form-group col">
                                        <label for="inputDurationTime">Training Hour :</label>
                                        <input type="number" class="form-control" required id="inputDurationTime" name="inputDurationTime" min="0" step="0.01" placeholder="" require>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputLocation">Location :</label>
                                    <input type="text" class="form-control" id="inputLocation" name="inputLocation" maxlength="80" placeholder="" required>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label for="inputCost">Training Cost :</label>
                                        <input type="number" required class="form-control" id="inputCost" name="inputCost" min="0" step="0.01" placeholder="THB" require>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="table-responsive">
                                        <div class="form-group col-6">
                                            <label for="inputType">Training Type :</label>
                                            <!-- <div class="btn-group btn-group-toggle" data-toggle="buttons"> -->
                                            <div class="btn-group">
                                                <label class="btn btn-outline-dark">
                                                    <input type="radio" name="inputType" id="inputType1" value="1" autocomplete="off" required> Orientation
                                                </label>
                                                <label class="btn btn-outline-dark">
                                                    <input type="radio" name="inputType" id="inputType2" value="2" autocomplete="off"> OJT
                                                </label>
                                                <label class="btn btn-outline-dark">
                                                    <input type="radio" name="inputType" id="inputType3" value="3" autocomplete="off"> Reskill
                                                    <!--Refreshing-->
                                                </label>
                                                <label class="btn btn-outline-dark">
                                                    <input type="radio" name="inputType" id="inputType4" value="4" autocomplete="off"> Upskill
                                                    <!--On going-->
                                                </label>
                                                <label class="btn btn-outline-dark">
                                                    <input type="radio" name="inputType" id="inputType5" value="5" autocomplete="off"> Public
                                                </label>
                                                <label class="btn btn-outline-dark">
                                                    <input type="radio" name="inputType" id="inputType6" value="6" autocomplete="off"> Other
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <fieldset class="border rounded">
                                        <legend class="w-auto text-muted" style="font-size: 14px;">Attach File :</legend>
                                        <div style="padding: 10px;">
                                            <label for="Attach0" class="pointer mr-3">
                                                <input type="radio" class="pointer" id="Attach0" name="inputAttach" value="0" checked autocomplete="off"> None
                                            </label>
                                            <label for="Attach1" class="pointer mr-3">
                                                <input type="radio" class="pointer" id="Attach1" name="inputAttach" value="1" autocomplete="off"> .JPG
                                            </label>
                                            <label for="Attach2" class="pointer mr-3">
                                                <input type="radio" class="pointer" id="Attach2" name="inputAttach" value="2" autocomplete="off"> .PDF
                                            </label>
                                            <div class="Attach1 boxhide">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="inputImgFile" name="inputImgFile" maxlength="50" accept=".jpg, .JPG, .jpeg, .JPEG, .png, .PNG, .gif, .GIF">
                                                    <label class="custom-file-label" for="inputImgFile">Choose .JPG</label>
                                                </div>
                                                <div class="text-danger">
                                                    <small>* The file size limit is 2MB or less.</small>
                                                    <div><small>* The file name should not exceed 50 characters.</small></div>
                                                </div>
                                            </div>
                                            <div class="Attach2 boxhide">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="inputPdfFile" name="inputPdfFile" maxlength="50" accept="application/pdf">
                                                    <label class="custom-file-label" for="inputPdfFile">Choose .PDF</label>
                                                </div>
                                                <div class="text-danger">
                                                    <small>* The file size limit is 2MB or less.</small>
                                                    <div><small>* The file name should not exceed 50 characters.</small></div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>

                            </div>
                        </div>

                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Employee</a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Report</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

                                <div class="form-group mt-2">
                                    <fieldset class="border rounded" style="padding: 10px;">
                                        <legend class="w-auto text-danger" style="font-size: 14px;">
                                            <!-- คลิก Filter เพื่อค้นหา รหัส, ชื่อ-สกุล, ตำแหน่ง, แผนก -->
                                            <div class="input-group">
                                                <select class="custom-select custom-select-sm action" name="Position" id="Position">
                                                    <?php
                                                    $query = "SELECT PositionNameEN FROM positionoffice WHERE (Status = 1) ORDER BY PositionNameEN ASC";
                                                    $result = mysqli_query($connWorkplace, $query);
                                                    echo '<option value="all">Choose Position</option>';
                                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                                        echo '<option value="' . $row["PositionNameEN"] . '">' . $row["PositionNameEN"] . '</option>';
                                                    }
                                                    ?>
                                                </select>

                                                <select class="custom-select custom-select-sm action" name="Section" id="Section">
                                                    <!-- <option value="">All</option> -->
                                                    <?php
                                                    $query = "SELECT SectionNameEN FROM sectionoffice WHERE (Status = 1) ORDER BY SectionNameEN ASC";
                                                    $result = mysqli_query($connWorkplace, $query);
                                                    echo '<option value="all">Choose Section</option>';
                                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                                        echo '<option value="' . $row["SectionNameEN"] . '">' . $row["SectionNameEN"] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </legend>

                                        <div id="GetTrainees">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text" for="inputFilter" id="select_count">0 Selected</label>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="inputFilter" name="inputFilter" placeholder="Filter">
                                            </div>
                                            <div class="table-responsive custom-scrollbar">
                                                <table id="TableEmployee" class="table table-striped table-sm table-hover">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th scope="col" width="30"></th>
                                                            <th scope="col">ID</th>
                                                            <th scope="col">Name/Surname</th>
                                                            <th scope="col">Position</th>
                                                            <th scope="col">Section</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="tbody">
                                                        <?php
                                            //             $TraineesSQL = "SELECT 
                                            // dbo.ReqUser.EmpUserID, HRSystem.dbo.eEmployee.sEmpEngNamePrefix,
                                            // dbo.ReqUser.EmpUserName, dbo.ReqUser.EmpUserSurname,
                                            // dbo.ReqUser.EmpUserPosition, dbo.ReqUser.EmpUserSection
                                            // FROM dbo.ReqUser INNER JOIN
                                            // HRSystem.dbo.eEmployee ON dbo.ReqUser.EmpUserID 
                                            // COLLATE SQL_Latin1_General_CP1_CI_AS = HRSystem.dbo.eEmployee.sEmpID
                                            // WHERE (dbo.ReqUser.Status <> 0)
                                            // AND (LEN(dbo.ReqUser.EmpUserID) <= 7)
                                            // AND (dbo.ReqUser.EmpUserID NOT LIKE '%SUB%')";
                                                        $TraineesSQL = "SELECT 
                                            dbo.ReqUser.EmpUserID, dbo.Requser.EmpUserSection,
                                            dbo.ReqUser.EmpUserName, dbo.ReqUser.EmpUserSurname,
                                            dbo.ReqUser.EmpUserPosition, dbo.ReqUser.EmpUserSection
                                            FROM dbo.ReqUser ";
                                                        $i = 1;
                                                        $Traineesobj = sqlsrv_query($connRequest, $TraineesSQL);
                                                        while ($TraineesResult = sqlsrv_fetch_array($Traineesobj, SQLSRV_FETCH_ASSOC)) {
                                                        ?>
                                                            <tr class="tr text-uppercase">
                                                                <td><input type="checkbox" class="emp_checkbox pointer" name="inputDemo[]" id="inputDemo" value="<?php echo $TraineesResult["EmpUserID"]; ?>"></td>
                                                                <td><?php print $TraineesResult["EmpUserID"]; ?></td>
                                                                <td><?php print $TraineesResult["sEmpEngNamePrefix"] . "\n" . $TraineesResult["EmpUserName"] . "\n" . $TraineesResult["EmpUserSurname"]; ?></td>
                                                                <td><?php print $TraineesResult["EmpUserPosition"]; ?></td>
                                                                <td><?php print $TraineesResult["EmpUserSection"]; ?></td>
                                                            </tr>
                                                        <?php
                                                            $i++;
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div id="GetEmployee">
                                            <div class="border bg-dark text-light mt-3 rounded p-3">
                                                <div class="text-greenblue"><strong>Trainees : 0</strong></div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <div class="form-group mt-2">
                                    <fieldset class="border rounded" style="padding: 10px;">
                                        <legend class="w-auto text-danger" style="font-size: 14px;">

                                        </legend>

                                        <div id="GetTrainees">
                                            <input type="text" class="form-control form-control-sm" id="inputReport" name="inputReport" placeholder="Filter">
                                            <div class="table-responsive custom-scrollbar">
                                                <table class="table table-report table-striped table-sm table-hover">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th scope="col" width="30">#</th>
                                                            <th scope="col">Course</th>
                                                            <th scope="col">Date/Time</th>
                                                            <th scope="col" class="text-center">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="tbody-report">
                                                        <?php
                                                        $sql = "SELECT DISTINCT ReqInfo.ReqNo, ReqInfo.ReqRemark, 
                                                        ReqInfo.ReqDay, ReqInfo.ReqHour, 
                                                        ReqInfo.ReqSumTime, ReqInfo.UserDefine1,
                                                        ReqInfo.ReqDate, ReqInfo.TrnTime
                                                        FROM ReqInfo 
                                                        WHERE (ReqInfo.ReqType = 4) 
                                                        AND (ReqInfo.Status <> 0)
                                                        AND (ReqInfo.ReqIssuer = '$SesUserID') 
                                                        ORDER BY ReqInfo.ReqNo DESC";

                                                        $params = array();
                                                        $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
                                                        $stmt = sqlsrv_query($connRequest, $sql, $params, $options);
                                                        $row_count = sqlsrv_num_rows($stmt);

                                                        if ($row_count > 0) {
                                                            $iScore = 1;
                                                            $query = sqlsrv_query($connRequest, $sql);
                                                            while ($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                                                                $EleData = explode('|', $result["UserDefine1"]);
                                                        ?>
                                                                <tr class="tr-report text-uppercase">
                                                                    <th scope="row"><?php print $iScore++; ?>)</th>
                                                                    <td>
                                                                        <div class="text-truncate" style="width:250px"><?php print $result["ReqRemark"]; ?></div>
                                                                    </td>
                                                                    <td>
                                                                        <div><?php echo date_format($result["ReqDate"], 'd/m/Y') . " - " . date_format($result["TrnTime"], 'd/m/Y'); ?></div>
                                                                        <div><?php echo date_format($result["ReqDate"], 'H:i') . " - " . date_format($result["TrnTime"], 'H:i'); ?></div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="btn-group" role="group" aria-label="report">
                                                                            <button type="button" class="btn btn-dark btn-sm BttLookModalCheck" data-toggle="modal" data-id="<?php echo $result["ReqNo"]; ?>"><i class="fas fa-eye"></i></button>
                                                                            <button type="button" class="btn btn-danger btn-sm BttLookModalCancel" data-toggle="modal" data-id="<?php echo $result["ReqNo"]; ?>"><i class="fas fa-trash"></i></button>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            <?php
                                                            }
                                                        } else {
                                                            ?>
                                                            <tr>
                                                            <td colspan="4">
                                                            <div class="alert alert-white text-center" role="alert">
                                                                No data available in table
                                                            </div>
                                                            </td>
                                                            </tr>
                                                        <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </fieldset>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <div class="float-right">
                            <button type="submit" name="BttSubmitReq" class="btn btn-success" onclick="return BttSubmit();"><i class="fa fa-check-circle"></i> Save</button>
                            <button type="button" class="btn btn-danger" onclick="return BttReset();"><i class="fa fa-times-circle"></i> Reset</button>
                        </div>
                    </div>
                </div>

            </form>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header text-uppercase"><i class="fas fa-users"></i> Related persons</div>
                <div class="card-body">
                    <?php include "form/include_authorized_req.php"; ?>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header text-uppercase"><i class="fas fa-history"></i> History</div>
                <div class="card-body">
                    <div class="table-responsive custom-scrollbar">
                        <table class="table table-sm">
                            <?php
                            $sql = "SELECT DISTINCT TOP (20) ReqNo,ReqRemark
                            FROM ReqInfo 
                            WHERE (ReqType = 4) AND (ReqIssuer = '$SesUserID')
                            ORDER BY ReqNo DESC";

                            $params = array();
                            $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
                            $stmt = sqlsrv_query($connRequest, $sql, $params, $options);
                            $row_count = sqlsrv_num_rows($stmt);

                            if ($row_count > 0) {
                                $iScore = 1;
                                $query = sqlsrv_query($connRequest, $sql);
                                while ($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                                    // $EleData = explode('|', $result["UserDefine1"]);
                            ?>
                                    <tr class="text-uppercase">
                                        <td><?php print $result["ReqRemark"]; ?></td>
                                        <td><a href="training_request_history.php?TrainingID=<?php print $result["ReqNo"]; ?>&cijm36oiemf8weut9w8480rj3W0JfimP7C" class="btn btn-dark btn-sm"><i class="fas fa-arrow-alt-circle-right"></i></a></td>
                                    </tr>
                                <?php
                                    $iScore++;
                                }
                            } else {
                                ?>
                                <div class="alert alert-white text-center" role="alert">
                                    No data available in table
                                </div>
                            <?php
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- .row -->
</div><!-- .container-fluid -->


<?php include "templates/footer.php"; ?>


<!-- Modal Check -->
<form action="save/save_cancel_reuest.php" autocomplete="off" method="POST" target="iframe_cancel_Req">
    <div class="modal fade ModalCheckOTList" tabindex="-1" role="dialog" aria-labelledby="reque_title" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header text-greenblue">
                    <h5 class="modal-title" id="reque_title">Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="txtReqNo" name="txtReqNo" readonly>
                    <div id="emp_order"></div>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-danger" data-toggle="modal" onclick="return BttSubmitRejectList();"><i class="fa fa-times-circle"></i>&nbsp; Reject</button>

                    <!-- Modal -->
                    <div class="modal fade" id="Cancel_list" tabindex="-1" role="dialog" aria-labelledby="Status_title" aria-hidden="true">
                        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header text-greenblue">
                                    <h5 class="modal-title" id="Status_title">Rejected</h5>
                                    <button type="button" class="close Cancel-list-close" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="inputReason">Reason for cancellation</label>
                                        <textarea class="form-control" id="inputRejectList" name="inputRejectList" rows="3" maxlength="50" placeholder="Enter.."></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="BttReject" value="1" class="btn btn-danger" onclick="return BttCancellist();">Confirm</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                </div>
            </div>
        </div>
    </div>
</form>


<!-- Modal Cancel -->
<form action="save/save_cancel_reuest.php" autocomplete="off" method="POST" target="iframe_cancel_Req">
    <div class="modal fade" id="Cancel_Group" tabindex="-1" role="dialog" aria-labelledby="Cancel_Group_title" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header text-greenblue">
                    <h5 class="modal-title" id="Cancel_Group_title">Rejected</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="inputKeyCancel" name="inputKeyCancel">
                    <div class="form-group">
                        <label for="inputReason">Reason for cancellation</label>
                        <textarea class="form-control" id="inputRejectGroup" name="inputRejectGroup" rows="3" maxlength="50" placeholder="Enter.."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="BttReject" value="3" class="btn btn-danger" onclick="return BttCancelGroup();">Confirm</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- Modal -->


<iframe id="iframe_Req" name="iframe_Req" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
<iframe id="iframe_cancel_Req" name="iframe_cancel_Req" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>


<script type="text/javascript">
    $(document).ready(function() {
        $("#Position,#Section").on("change", function() {
            var Position = $('#Position').find("option:selected").val();
            var Section = $('#Section').find("option:selected").val();
            SearchData(Position, Section)
        });
    });

    function SearchData(Position, Section) {
        if (Position.toUpperCase() == 'ALL' && Section.toUpperCase() == 'ALL') {
            $('#TableEmployee tbody tr').show();
        } else {
            $('#TableEmployee tbody tr:has(td)').each(function() {
                var rowPosition = $.trim($(this).find('td:eq(3)').text());
                var rowSection = $.trim($(this).find('td:eq(4)').text());
                if (Position.toUpperCase() != 'ALL' && Section.toUpperCase() != 'ALL') {
                    if (rowPosition.toUpperCase() == Position.toUpperCase() && rowSection == Section) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                } else if ($(this).find('td:eq(3)').text() != '' || $(this).find('td:eq(3)').text() != '') {
                    if (Position != 'all') {
                        if (rowPosition.toUpperCase() == Position.toUpperCase()) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    }
                    if (Section != 'all') {
                        if (rowSection == Section) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    }
                }

            });
        }
    }
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.emp_checkbox').on('click change', function() {
            //$(".emp_checkbox").click(function(){
            //   var StateCamera = $("#StateCamera").val();
            var inputDemo = [];
            $("input[name='inputDemo[]']:checked").each(function() {
                inputDemo.push(this.value);
            });
            if (inputDemo != '') {
                $.ajax({
                    url: 'return/return_selected_employee.php',
                    type: 'POST',
                    data: {
                        inputDemo: inputDemo
                    },
                    success: function(data) {
                        $('#GetEmployee').html("" + $.trim(data) + "");
                    }
                });
            } else {
                // $('.box-authorize').empty();
                $('#GetEmployee').html('<div class="border bg-dark text-light mt-3 rounded p-3"><div class="text-greenblue"><strong>Trainees : 0</strong></div></div>');
            }
        });
    });
</script>

<script type="text/javascript">
    $(function() {
        $(".Cancel-list-close").on('click', function() {
            $('#Cancel_list').modal('hide');
        });
    });

    function BttSubmitRejectList() {
        if (!$('.item_checkbox').is(':checked')) {
            alert('Please select employee!');
            return false;
        }
        if ($('.item_checkbox').is(':checked')) {
            $('#Cancel_list').modal('show');
        }
    }

    function BttCancellist() {
        if (document.getElementById('inputRejectList').value == "") {
            document.getElementById("inputRejectList").required = true;
        } else if (confirm('Are you sure you want to reject employee ?') == true) {
            return true;
        } else {
            return false;
        }
    }

    function BttCancelGroup() {
        if (document.getElementById('inputRejectGroup').value == "") {
            document.getElementById("inputRejectGroup").required = true;
        } else if (confirm('Are you sure you want to reject form ?') == true) {
            return true;
        } else {
            return false;
        }
    }

    $(document).ready(function() {
        $('.BttLookModalCancel').click(function() {
            var ids = $(this).attr('data-id');
            $("#inputKeyCancel").val(ids);
            $('#Cancel_Group').modal('show');
        });
    });

    //! Check Modal Start
    $(document).ready(function() {
        $('.BttLookModalCheck').click(function() {
            var ids = $(this).attr('data-id');
            $("#txtReqNo").val(ids);
            $('.ModalCheckOTList').modal('show');
            var ItemReqNo = $('#txtReqNo').val();
            if (ItemReqNo != '') {
                $.ajax({
                    url: "return/return_report_request.php",
                    method: "POST",
                    data: {
                        Item_ReqNo: ItemReqNo
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

<script type="text/javascript">
    $(document).ready(function() {
        $("#inputFilter").on("keyup change", function() {
            var value = $(this).val().toLowerCase();
            $("table.table tbody.tbody tr.tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

    $(document).ready(function() {
        $("#inputReport").on("keyup change", function() {
            var value = $(this).val().toLowerCase();
            $("table.table-report tbody.tbody-report tr.tr-report").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>

<!-- Start Modal Success -->
<div id="ModalSuccess" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="icon-box">
                    <i class="far fa-check-circle" style="font-size: 60px;"></i>
                </div>
                <h4 class="modal-title w-100">successfully</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">Your assessment has been successful.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-block" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#ModalSuccess').on('hidden.bs.modal', function() {
        window.location.href = 'training_request.php';
        //window.location.reload();
        //$('#formAssessment')[0].reset();
    });
</script>
<!-- End Modal Success -->

<!-- Start Modal Load -->
<div id="LoadModal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content" style="background: none !important;border: none;">
            <div class="modal-body text-center">
                <div class="spinner-grow text-light" role="status" style="width: 5rem; height: 5rem;">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="text-center text-light">Please wait...</div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function LoadingResult(Loading) {
        if (Loading == 1) {
            $('#LoadModal').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
        }
    }

    function TrainingResult(Request) {
        if (Request == 1) {
            //$('#LoadModal').modal('hide'),
            setInterval("$('.ModalCheckOTList').modal('hide')", 100);
            setInterval("$('#Cancel_list').modal('hide')", 100);
            setInterval("$('#Cancel_Group').modal('hide')", 100);
            /////////////////////////////////////////////////////
            setInterval("$('#LoadModal').modal('hide')", 1000);
            setInterval("$('#ModalSuccess').modal('show')", 1500);
            //alert('Successfully.');
            //setInterval('window.location.href = "../training_request.php"', 1500);
        } else {
            setInterval("$('#LoadModal').modal('hide')", 100);
            //window.location.href = "../training_request.php";
        }
    }
</script>
<!-- End Modal Load -->


<script type="text/javascript">
    $(window).ready(function() {
        $('input[name="inputType"]').on('click load', function() {
            var TypeRadio = $('input[name="inputType"]:checked').val();
            if (TypeRadio != "") { //alert("HHOT");
                $.ajax({
                    url: "return/return_authorize.php",
                    method: "POST",
                    data: {
                        TypeRadio: TypeRadio
                    },
                    success: function(data) {
                        $('.box-authorize').html("" + $.trim(data) + "");
                    }
                });
            } else {
                $('.box-authorize').empty();
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        // $('input[type="radio"]').click(function() {
        $('input[name="inputAttach"]').click(function() {
            var inputValue = $(this).attr("id");
            var targetBox = $("." + inputValue);
            $(".boxhide").not(targetBox).hide();
            $(targetBox).show();
        });
    });

    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>

<script type="text/javascript">
    function BttSubmit() {
        var fileImg = document.formRequest.inputImgFile.value; //var patt = /(.gif|.jpg|.png)/;
        var pathImg = /(.jpg|.jpeg|.JPEG|.JPG|.png|.PNG|.gif|.GIF)/;
        var resultImg = pathImg.test(fileImg);
        if (document.formRequest.inputImgFile.value != "" && resultImg == false) {
            alert("file type is wrong (.jpg only)");
            return false;
        }
        var filePdf = document.formRequest.inputPdfFile.value; //var patt = /(.gif|.jpg|.png)/;
        var pathPdf = /(.pdf|.PDF)/;
        var resultPdf = pathPdf.test(filePdf);
        if (document.formRequest.inputPdfFile.value != "" && resultPdf == false) {
            alert("file type is wrong (.pdf only)");
            return false;
        }

        if ((document.formRequest.inputAttach.value == "1") && (document.formRequest.inputImgFile.value == "")) {
            alert("Please attach an image file.");
            document.getElementById("inputImgFile").required = true;
            return false;
        }
        if ((document.formRequest.inputAttach.value == "2") && (document.formRequest.inputPdfFile.value == "")) {
            alert("Please attach an PDF file.");
            document.getElementById("inputPdfFile").required = true;
            return false;
        }

        // if ((document.formRequest.inputTrainees.value == "")) {
        if (!$('.emp_checkbox').is(':checked')) {
            alert("Please select trainees.");
            //document.getElementById("inputTrainees").required = true;
            return false;
        }
        if (confirm('Are you sure you want to submit the form ?') == true) {
            return true;
        } else {
            return false;
        }
    }

    function BttReset() {
        if (confirm('Are you sure you want to cancel ?') == true) {
            window.location.reload();
        } else {
            return false;
        }
    }
</script>

<script type="text/javascript">
    $(document).ready(function() {
        //$('#time1, #time2').keyup(function(){
        //$('#time1, #time2').change(function(){
        $('#inputTimeFrom, #inputTimeTo').on('keyup change', function() {
            var TimeFrom = $('#inputTimeFrom').val();
            var TimeTo = $('#inputTimeTo').val();
            if ((TimeFrom != '' && TimeTo != '') && (TimeFrom <= TimeTo)) {
                $.ajax({
                    url: "return/return_search_datetime.php",
                    method: "POST",
                    data: {
                        TimeFrom: TimeFrom,
                        TimeTo: TimeTo
                    },
                    dataType: "text",
                    success: function(data) {
                        /*$('#txtEmpID').val(data);*/
                        $("#inputDurationTime").val($.trim(data));
                    }
                });
            } else {
                $("#inputDurationTime").val('');
            }
        });
    });
</script>