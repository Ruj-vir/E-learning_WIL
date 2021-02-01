<?php include "templates/header.php"; ?>
<?php include "templates/navber.php"; ?>

<?php //include "alert/alert_authority.php";?>

<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12 col-md-6 mb-4">
            <div class="card shadow my-4">
                <div class="card-header text-uppercase">
                    <i class="fas fa-print"></i> Training Application
                </div>
                <div class="card-body">

                    <!-- /* Start Table */ -->
                    <div class="form-row">
                        <div class="col-md-3">
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-low-vision"></i></div>
                                </div>
                                <select class="custom-select" id="inputAccess" name="inputAccess">
                                    <option value="1">Request</option>
                                    <option value="2">Check</option>
                                    <option value="3">Verify</option>
                                    <option value="4">Approve</option>
                                    <option value="5">Admin</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">From:</div>
                                </div>
                                <input type="date" class="form-control" id="DateFrom" name="DateFrom" value="<?php print $DateFrom = date('Y-m-d'); ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">To:</div>
                                </div>
                                <input type="date" class="form-control" id="DateTo" name="DateTo" value="<?php print $DateTo = date('Y-m-d', strtotime('today'));; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-search"></i></div>
                                </div>
                                <input type="text" class="form-control" id="SearchID" name="SearchID" placeholder="keyword">
                            </div>
                        </div>
                    </div>

                    <div id="Finebook">
                        <div class="table-responsive">
                            <table id="reqTableMyList" class="table table-hover text-truncate nowrap" style="width:100%">
                                <thead class="text-uppercase thead-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Course name</th>
                                        <th scope="col">Training date</th>
                                        <th scope="col">Period</th>
                                        <th scope="col">Requestor</th>
                                        <th scope="col" class="text-center">Export</th>
                                    </tr>
                                </thead>
                                <tbody class="tbody">
                                <?php
                                    $ListSql = "SELECT DISTINCT TOP (20) dbo.ReqInfo.ReqNo, 
                                    dbo.ReqInfo.ReqRemark, 
                                    dbo.ReqInfo.ReqDay, 
                                    dbo.ReqInfo.ReqHour, 
                                    dbo.ReqInfo.ReqSumTime, 
                                    dbo.ReqInfo.ReqOTType, 
                                    -- dbo.ReqInfo.UserDefine1, 
                                    dbo.ReqInfo.ReqDate, 
                                    dbo.ReqInfo.TrnTime, 
                                    dbo.ReqInfo.PicturePath, 
                                  
                                    dbo.ReqUser.EmpUserID, 
                                    dbo.ReqUser.EmpUserName, 
                                    dbo.ReqUser.EmpUserSurname, 
                                    dbo.ReqUser.EmpUserPosition, 
                                    dbo.ReqUser.EmpUserSection, 
                                    dbo.ReqUser.EmpUserDepartment
                                  
                                    FROM dbo.ReqInfo 
                                    INNER JOIN dbo.ReqUser ON dbo.ReqInfo.ReqIssuer = dbo.ReqUser.EmpUserID
                                    WHERE (dbo.ReqInfo.ReqType = 4) 
                                    AND (dbo.ReqInfo.ReqIssuer = '$SesUserID') 
                                    AND (dbo.ReqInfo.Status <> 0)
                                    ORDER BY dbo.ReqInfo.ReqNo";

                                    $ListIParams = array();
                                    $ListIOptions =  array("Scrollable" => SQLSRV_CURSOR_KEYSET);
                                    $ListIStmt = sqlsrv_query($connRequest, $ListSql, $ListIParams, $ListIOptions);
                                    $ListIRow = sqlsrv_num_rows($ListIStmt);

                                    if ($ListIRow > 0) {
                                        $iScore = 1;
                                        $ListObj = sqlsrv_query($connRequest, $ListSql);
                                        while ($ListResult = sqlsrv_fetch_array($ListObj, SQLSRV_FETCH_ASSOC)) {

                                            $ReqNo = $ListResult["ReqNo"];

                                            $issuedSql = "SELECT TOP (1) ReqIssueDate FROM ReqInfo WHERE (ReqType = 4) AND (ReqNo = '$ReqNo') ";
                                            $issuedObj = sqlsrv_query($connRequest, $issuedSql);
                                            $issuedResult = sqlsrv_fetch_array($issuedObj, SQLSRV_FETCH_ASSOC);

                                    ?>
                                            <tr class="tr text-uppercase">
                                                <th scope="row"><?php echo $iScore; ?>)</th>
                                                <td><div class="text-truncate" style="width:200px"><?php echo $ListResult["ReqRemark"]; ?></div></td>
                                                <td>
                                                    <div style="font-size: 14px;"><span class="text-muted mr-4">Date:</span> <?php echo date_format($ListResult["ReqDate"], 'd/m/Y') . " - " . date_format($ListResult["TrnTime"], 'd/m/Y'); ?></div>
                                                    <div style="font-size: 14px;"><span class="text-muted mr-4">Time:</span> <?php echo date_format($ListResult["ReqDate"], 'H:i') . " - " . date_format($ListResult["TrnTime"], 'H:i'); ?></div>
                                                </td>
                                                <td><?php print round($ListResult["ReqDay"], 2) . "Day, " . round($ListResult["ReqHour"], 2) . "Hrs"; ?></td>
                                                <td><?php //print number_format($ListResult["ReqSumTime"], 2) ?>
                                                    <div class="text-truncate"><?php echo $ListResult["EmpUserID"]." - ".$ListResult["EmpUserName"]."\n".$ListResult["EmpUserSurname"]; ?></div>
                                                    <small><?php echo date_format($issuedResult["ReqIssueDate"], 'd/m/Y H:i a') ;?></small>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <button type="button" class="btn btn-outline-danger btn-sm" title="PDF File" onclick="window.open('training_report_application_detail.php?ItemReqNo=<?php echo $ListResult['ReqNo']; ?>&j0dsu36gpd&AccessNo=1&9gsu4sdj')"><i class="far fa-file-pdf"></i> PDF</button>
                                                    </div>
                                                </td>
                                            </tr>
                                    <?php
                                            $iScore++;
                                        }
                                    } else {
                                        echo "<tr><td class='text-center' colspan='6'>No data available in table</td></tr>";
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div><!-- .row -->
</div><!-- .container-fluid -->

<?php include "templates/footer.php"; ?>

<script type="text/javascript">
    $(document).ready(function() {
        $("#SearchID").on("keyup change", function() {
            var value = $(this).val().toLowerCase();
            $("table.table tbody.tbody tr.tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });


    $(document).ready(function() {
        $('#DateFrom, #DateTo, #inputAccess').on('keyup change', function() {
            var DateFrom = $('#DateFrom').val();
            var DateTo = $('#DateTo').val();
            var inputAccess = $('#inputAccess').val();
            if (((DateFrom != "" && DateTo != "") && (DateFrom <= DateTo))) {
                $.ajax({
                    url: "return/return_searchreport_application.php",
                    method: "POST",
                    data: {
                        DateFrom: DateFrom,
                        DateTo: DateTo,
                        inputAccess: inputAccess
                    },
                    success: function(data) {
                        $('#Finebook').html("" + $.trim(data) + "");
                    }
                });
            } else {
                //alert("Please check the date/time.!!");
                //$('#Finebook').empty();
            }
        });
    });
</script>