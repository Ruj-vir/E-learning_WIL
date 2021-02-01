<?php include "templates/header.php"; ?>
<?php include "templates/navber.php"; ?>

<?php include "alert/alert_authority.php";?>

<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12 col-md-6 mb-4">
            <form action="training_report_plan_detail.php" autocomplete="off" method="GET" target="_blank">
                <div class="card shadow my-4">
                    <div class="card-header text-uppercase">
                        <div class="row justify-content-between">
                            <div class="col">
                                <i class="fas fa-print"></i> Training Plan
                            </div>
                            <div class="col text-right">
                                <button type="submit" name="BtPDF" value="PDF" class="btn btn-outline-danger btn-sm" title="PDF File"><i class="far fa-file-pdf"></i>
                                    PDF
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <!-- /* Start Table */ -->
                        <div class="form-row">
                            <div class="col-md-4">
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">From date:</div>
                                    </div>
                                    <input type="date" class="form-control" id="DateFrom" name="DateFrom" value="<?php print $DateFrom = date('Y-m-d'); ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">To date:</div>
                                    </div>
                                    <input type="date" class="form-control" id="DateTo" name="DateTo" value="<?php print $DateTo = date('Y-m-d', strtotime('today'));; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
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
                                <table class="table table-bordered text-truncate" id="reqTableMyList" width="100%" cellspacing="0">
                                    <thead class="text-uppercase thead-light">
                                        <tr class="text-center">
                                            <th scope="col" rowspan="2">No.</th>
                                            <th scope="col" rowspan="2">Course name</th>
                                            <th scope="col" rowspan="2">Training date</th>
                                            <th scope="col" rowspan="2">Sec./Dpt.</th>
                                            <th scope="col" rowspan="2">Trainer/Organize</th>
                                            <th scope="col" rowspan="2">Place</th>
                                            <th scope="col" rowspan="2">Type</th>
                                            <th scope="col" colspan="2">Result</th>
                                            <th scope="col" rowspan="2">Period</th>
                                            <th scope="col" rowspan="2" class="text-right">Cost (THB)</th>
                                        <tr class="text-center">
                                            <td scope="col" class="bg-success" style="font-size: 11px;">Pass</td>
                                            <td scope="col" class="bg-danger" style="font-size: 11px;">Fail</td>
                                        </tr>
                                    </thead>
                                    <tbody class="tbody">
                                        <?php
                                        $ListSql = "SELECT DISTINCT 
                        dbo.ReqInfo.ReqNo, 
                        dbo.ReqInfo.ReqDate, 
                        dbo.ReqInfo.TrnTime, 
                        dbo.ReqInfo.ReqDay, 
                        dbo.ReqInfo.ReqHour, 
                        dbo.ReqInfo.ReqSumTime, 
                        dbo.ReqInfo.ReqRemark,

                        EducationSystem.dbo.TrainRecHdr.TrainRecType, 
                        EducationSystem.dbo.TrainRecHdr.TrainRecEvl, 
                        -- EducationSystem.dbo.TrainRecHdr.TrainRecDateFrom, 
                        -- EducationSystem.dbo.TrainRecHdr.TrainRecDateTo, 
                        EducationSystem.dbo.TrainRecHdr.TrainRecTrainer, 
                        EducationSystem.dbo.TrainRecHdr.TrainRecPlace, 
                        dbo.ReqUser.EmpUserSection

                        FROM EducationSystem.dbo.TrainRecHdr INNER JOIN
                        dbo.ReqInfo ON EducationSystem.dbo.TrainRecHdr.TrainRecNo = dbo.ReqInfo.ReqNo INNER JOIN
                        dbo.ReqUser ON dbo.ReqInfo.ReqIssuer = dbo.ReqUser.EmpUserID
                        WHERE (dbo.ReqInfo.ReqType = 4) AND (EducationSystem.dbo.TrainRecHdr.TrainHdrStatus = 3) 
                        AND ((dbo.ReqInfo.ReqDate >= '$DateFrom 00:00:00' AND dbo.ReqInfo.TrnTime <= '$DateTo 23:59:59')
				        OR (dbo.ReqInfo.TrnTime >= '$DateFrom 00:00:00' AND dbo.ReqInfo.ReqDate <= '$DateTo 23:59:59'))
				        --OR (dbo.ReqInfo.ReqCheckDate >= '$DateStart 00:00:00' AND dbo.ReqInfo.ReqCheckDate <= '$DateEnd 00:00:00')";

                                        $ListIParams = array();
                                        $ListIOptions =  array("Scrollable" => SQLSRV_CURSOR_KEYSET);
                                        $ListIStmt = sqlsrv_query($connRequest, $ListSql, $ListIParams, $ListIOptions);
                                        $ListIRow = sqlsrv_num_rows($ListIStmt);

                                        if ($ListIRow > 0) {
                                            $iScore = 1;
                                            $ListObj = sqlsrv_query($connRequest, $ListSql);
                                            while ($ListResult = sqlsrv_fetch_array($ListObj, SQLSRV_FETCH_ASSOC)) {
                                                switch ($ListResult["TrainRecType"]) {
                                                    case 1:
                                                        $TrainRecType = 'Orientation';
                                                        break;
                                                    case 2:
                                                        $TrainRecType = 'OJT';
                                                        break;
                                                    case 3:
                                                        $TrainRecType = 'Refreshing';
                                                        break;
                                                    case 4:
                                                        $TrainRecType = 'On going';
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
                                                    $ItemReqNo = $ListResult["ReqNo"];
                                                    
                                                    $PassDtlSql = "SELECT COUNT(EmployeeID) AS TraineePass
                                                    FROM dbo.ReqInfo AS ReqInfo
                                                    WHERE (EmployeeID IN
                                                    (SELECT EmployeeID
                                                    FROM EducationSystem.dbo.TrainRecDtl
                                                    WHERE (TrainDtlStatus = 6) 
                                                    AND (TrainRecResult = 1))) 
                                                    AND (ReqType = 4) 
                                                    AND (ReqNo = '$ItemReqNo')";
                                                    $PassDtlObj = sqlsrv_query($connRequest, $PassDtlSql);
                                                    $PassDtlResult = sqlsrv_fetch_array($PassDtlObj, SQLSRV_FETCH_ASSOC);
                                    
                                                    $FailDtlSql = "SELECT COUNT(EmployeeID) AS TraineeFail
                                                    FROM dbo.ReqInfo AS ReqInfo
                                                    WHERE (EmployeeID NOT IN
                                                    (SELECT EmployeeID
                                                    FROM EducationSystem.dbo.TrainRecDtl
                                                    WHERE (TrainDtlStatus = 6) 
                                                    AND (TrainRecResult = 1))) 
                                                    AND (ReqType = 4) 
                                                    AND (ReqNo = '$ItemReqNo')";
                                                    $FailDtlObj = sqlsrv_query($connRequest, $FailDtlSql);
                                                    $FailDtlResult = sqlsrv_fetch_array($FailDtlObj, SQLSRV_FETCH_ASSOC);

                                        ?>
                                                    <tr class="tr text-center text-uppercase">
                                                        <th scope="row"><?php print $iScore++; ?></th>
                                                        <td class="text-left"><?php print $ListResult["ReqRemark"]; ?></td>
                                                        <td>
                                                            <?php print date_format($ListResult["ReqDate"], 'd/m/Y') . " - " . date_format($ListResult["TrnTime"], 'd/m/Y'); ?>
                                                            <div><?php print date_format($ListResult["ReqDate"], 'H:i') . " - " . date_format($ListResult["TrnTime"], 'H:i'); ?></div>
                                                        </td>
                                                        <td><?php print $ListResult["EmpUserSection"]; ?></td>
                                                        <td class="text-left"><?php print $ListResult["TrainRecTrainer"]; ?></td>
                                                        <td><?php print $ListResult["TrainRecPlace"]; ?></td>
                                                        <td><?php print $TrainRecType; ?></td>
                                                        <td><?php print $PassDtlResult["TraineePass"]; ?></td>
                                                        <td><?php print $FailDtlResult["TraineeFail"]; ?></td>
                                                        <td><?php print round($ListResult["ReqDay"], 2) . "Day, " . round($ListResult["ReqHour"], 2) . "Hrs" ?></td>
                                                        <td class="text-right"><?php print number_format($ListResult["ReqSumTime"], 2) ?></td>
                                                    </tr>
                                        <?php
                                            }
                                        } else {
                                            echo '<tr><td colspan="11" class="text-center">No data available in table</td></tr>';
                                        }
                                        ?>
                                    </tbody>
                                    <!--<tfoot>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Course name</th>
                                        <th scope="col">Date/Time</th>
                                        <th scope="col">Duration</th>
                                        <th scope="col">Cost</th>
                                        <th class="text-center" scope="col">Export</th>
                                    </tr>
                                </tfoot>-->
                                </table>
                            </div>

                        </div>
                        <!-- /* End Table */ -->

                    </div>
                </div>
            </form>
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
        $('#DateFrom, #DateTo').on('keyup change', function() {
            var DateFrom = $('#DateFrom').val();
            var DateTo = $('#DateTo').val();
            if (((DateFrom != "" && DateTo != "") && (DateFrom <= DateTo))) {
                $.ajax({
                    url: "return/return_searchreport_plan.php",
                    method: "POST",
                    data: {
                        DateFrom: DateFrom,
                        DateTo: DateTo
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