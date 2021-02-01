<?php include "templates/header.php"; ?>
<?php include "templates/navber.php"; ?>

<?php include "alert/alert_authority.php"; ?>

<?php
if (trim($_GET["Type"]) == "1" || trim($_GET["Type"]) == "2" || trim($_GET["Type"]) == "3") {
    $str = trim($_GET["Type"]);
    //$FineDataEmp = addslashes($str);
    $vowels = array("'");
    $Type = str_replace($vowels, '', $str);

    switch ($Type) {
        case 1:
            $ShowType = 'Check';
            break;
        case 2:
            $ShowType = 'Verify';
            break;
        case 3:
            $ShowType = 'Approve';
            break;
        default:
            $ShowType = '';
    }
} else {
    echo "<script>javascript:history.back(1);</script>";
    //echo "<script>window.location.href='index.php'</script>";
    exit();
}

?>

<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12 col-md-6 mb-4">
            <div class="card shadow my-4">
                <div class="card-header text-uppercase">
                    <i class="fas fa-tachometer-alt"></i> Pending <?php print $ShowType; ?>
                </div>
                <div class="card-body">

                    <div class="table-responsive">

                        <div class="row">
                            <div class="col-lg-9 mb-2">
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-outline-dark active">
                                        <input type="radio" name="inputType" id="inputType0" value="all" autocomplete="off" checked="checked"> All
                                    </label>
                                    <label class="btn btn-outline-dark">
                                        <input type="radio" name="inputType" id="inputType1" value="1" autocomplete="off"> Orientation
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
                            <div class="col-lg-3 mb-2">
                                <input type="text" class="form-control" id="SearchID" placeholder="keyword">
                            </div>
                        </div>

                        <table class="table table-bordered table-hover text-center text-truncate nowrap" style="width:100%">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <!-- <th scope="col">Req ID</th> -->
                                    <th scope="col" class="text-left">Training Course</th>
                                    <th scope="col">Period</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="tbody">
                                <?php

                                $sql = "SELECT DISTINCT ReqInfo.ReqNo, ReqInfo.ReqRemark, 
                                ReqInfo.ReqDay, ReqInfo.ReqHour, 
                                ReqInfo.ReqSumTime, ReqOTType, ReqInfo.UserDefine1,
                                ReqInfo.ReqDate, ReqInfo.TrnTime,
                                ReqUser.EmpUserID, ReqUser.EmpUserName, ReqUser.EmpUserSurname, 
                                ReqUser.EmpUserPosition, ReqUser.EmpUserSection, ReqUser.EmpUserDepartment
                                FROM ReqInfo 
                                INNER JOIN ReqUser ON ReqInfo.ReqIssuer = ReqUser.EmpUserID
                                WHERE (ReqInfo.ReqType = 4) 
                                -- AND (ReqInfo.ReqChecker = '$SesUserID') 
                                AND (ReqInfo.Status = '$Type')
                                ORDER BY ReqInfo.ReqNo";

                                $params = array();
                                $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
                                $stmt = sqlsrv_query($connRequest, $sql, $params, $options);
                                $row_count = sqlsrv_num_rows($stmt);

                                if ($row_count > 0) {
                                    $iScore = 1;
                                    $query = sqlsrv_query($connRequest, $sql);
                                    while ($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                                        $EleData = explode('|', $result["UserDefine1"]);

                                        switch ($result["ReqOTType"]) {
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

                                        $ItemReqNo = $result["ReqNo"];
                                        $issuedSql = "SELECT ReqNo,ReqIssueDate FROM ReqInfo WHERE (ReqNo = '$ItemReqNo') AND (ReqType = 4)";
                                        $issuedObj = sqlsrv_query($connRequest, $issuedSql);
                                        $issuedResult = sqlsrv_fetch_array($issuedObj, SQLSRV_FETCH_ASSOC);

                                ?>
                                        <tr class="tr" data-status="<?php echo $result["ReqOTType"]; ?>">
                                            <th scope="row"><?php echo $iScore; ?>)</th>
                                            <!-- <td><?php //echo $result["ReqNo"]; 
                                                        ?></td> -->
                                            <td>
                                                <div class="text-truncate text-left" style="width:250px"><?php echo $result["ReqRemark"]; ?></div>
                                                <div class="text-truncate text-left"><span class="text-muted">by:</span> <?php echo $result["EmpUserID"] . " - " . $result["EmpUserName"] . "\n" . $result["EmpUserSurname"]; ?></div>
                                                <div class="text-truncate text-left"><small><?php echo date_format($issuedResult["ReqIssueDate"], 'd/m/Y H:i a') ;?></small></div>
                                            </td>
                                            <td>
                                                <div><strong>Date:</strong> <?php echo date_format($result["ReqDate"], 'd/m/Y') . " - " . date_format($result["TrnTime"], 'd/m/Y'); ?></div>
                                                <div><strong>Time:</strong> <?php echo date_format($result["ReqDate"], 'H:i') . " - " . date_format($result["TrnTime"], 'H:i'); ?></div>
                                            </td>
                                            <td><span class="label badge badge-greenblue"><?php echo $TrainRecType; ?></span></td>
                                            <td><button type="button" class="btn btn-outline-dark btn-sm BttLookModalCheck" title="View" data-toggle="modal" data-id="<?php echo $result["ReqNo"]; ?>"><i class="fas fa-eye"></i> View</button></td>
                                        </tr>
                                    <?php
                                        $iScore++;
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="6">No data available in table</td>
                    </div>
                <?php
                                }
                ?>
                </tbody>
                </table>


                </div>
            </div>
        </div>

    </div><!-- .row -->
</div><!-- .container-fluid -->

<?php include "templates/footer.php"; ?>


<div class="modal fade ModalCheckOTList" tabindex="-1" role="dialog" aria-labelledby="reque_title" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header text-greenblue">
                <h5 class="modal-title" id="reque_title">Pending <?php print $ShowType; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="txtReqNo" name="txtReqNo" readonly>
                <div id="emp_order"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
        $(".btn-group .btn").click(function() {
            var inputValue = $(this).find("input").val();
            if (inputValue != 'all') {
                var target = $('table tr[data-status="' + inputValue + '"]');
                $("table tbody tr").not(target).hide();
                target.fadeIn();
            } else {
                $("table tbody tr").fadeIn();
            }
        });
        // Changing the class of status label to support Bootstrap 4
        var bs = $.fn.tooltip.Constructor.VERSION;
        var str = bs.split(".");
        if (str[0] == 4) {
            $(".label").each(function() {
                var classStr = $(this).attr("class");
                var newClassStr = classStr.replace(/label/g, "badge");
                $(this).removeAttr("class").addClass(newClassStr);
            });
        }
    });


    $(document).ready(function() {
        $("#SearchID").keyup(function() {
            _this = this;
            $.each($("table.table tbody.tbody tr.tr"), function() {
                if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                    $(this).hide();
                else
                    $(this).show();
            });
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
                    url: "return/return_pending.php",
                    method: "POST",
                    data: {
                        Item_ReqNo: ItemReqNo,
                        Item_Type: <?php print $Type; ?>
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