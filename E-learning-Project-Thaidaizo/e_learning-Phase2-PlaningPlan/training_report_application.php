<?php include "templates/header.php"; ?>
<?php include "templates/navber.php"; ?>

<?php include "alert/alert_authority.php";?>

<div class="container-fluid">
    <div class="row">

        <div class="col-xl-12 col-md-6 mb-4">
            <div class="card my-4">
                <div class="card-header text-uppercase">
                    <i class="fas fa-print"></i> Training Application
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
                                <input type="date" class="form-control" id="DateTo" name="DateTo" value="<?php print $DateTo = date('Y-m-d', strtotime('+1 year'));; ?>">
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
                            <table id="reqTableMyList" class="table table-hover text-truncate nowrap" style="width:100%">
                                <thead class="text-uppercase thead-light">
                                    <tr class="text-center">
                                        <th scope="col">No.</th>
                                        <th scope="col" class="text-left">Course name</th>
                                        <th scope="col" class="text-left">Training date</th>
                                        <th scope="col">Period</th>
                                        <th scope="col" class="text-right">Cost</th>
                                        <th scope="col">Export</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ListSql = "SELECT DISTINCT
    dbo.ReqInfo.ReqNo, 
    dbo.ReqInfo.ReqDate, 
    dbo.ReqInfo.TrnTime, 
    dbo.ReqInfo.ReqDay, 
    dbo.ReqInfo.ReqHour, 
    dbo.ReqInfo.ReqSumTime, 
    dbo.ReqInfo.ReqRemark, 
    dbo.ReqInfo.PicturePath, 
    --dbo.ReqInfo.UserDefine1, 

    EducationSystem.dbo.TrainRecHdr.TrainRecType, 
    EducationSystem.dbo.TrainRecHdr.TrainRecEvl, 
    EducationSystem.dbo.TrainRecHdr.TrainRecTrainer, 
    EducationSystem.dbo.TrainRecHdr.TrainRecPlace, 
    EducationSystem.dbo.TrainRecHdr.TrainHdrStatus
    FROM EducationSystem.dbo.TrainRecHdr 
    INNER JOIN dbo.ReqInfo 
    ON EducationSystem.dbo.TrainRecHdr.TrainRecNo = dbo.ReqInfo.ReqNo
    WHERE (dbo.ReqInfo.ReqType = 4) AND (dbo.ReqInfo.Status = 9) 
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
                                    ?>
                                            <tr class="tr text-center text-uppercase">
                                                <th scope="row"><?php echo $iScore; ?></th>
                                                <td class="text-left"><?php echo $ListResult["ReqRemark"]; ?></td>
                                                <td class="text-left">
                                                    <div style="font-size: 14px;"><span class="text-muted mr-4">Date:</span> <?php echo date_format($ListResult["ReqDate"], 'd/m/Y') . " - " . date_format($ListResult["TrnTime"], 'd/m/Y'); ?></div>
                                                    <div style="font-size: 14px;"><span class="text-muted mr-4">Time:</span> <?php echo date_format($ListResult["ReqDate"], 'H:i') . " - " . date_format($ListResult["TrnTime"], 'H:i'); ?></div>
                                                </td>
                                                <td><?php print round($ListResult["ReqDay"], 2) . "Day, " . round($ListResult["ReqHour"], 2) . "Hrs"; ?></td>
                                                <td class="text-right"><?php print number_format($ListResult["ReqSumTime"], 2) ?> THB</td>
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <button type="button" class="btn btn-outline-danger btn-sm" title="PDF File" onclick="window.open('training_report_application_detail.php?ItemReqNo=<?php echo $ListResult['ReqNo']; ?>&j0dsu36gpd9gsu9sdj9')"><i class="far fa-file-pdf"></i> PDF</button>
                                                    </div>
                                                </td>
                                            </tr>
                                    <?php
                                            $iScore++;
                                        }
                                    } else {
                                        echo "<tr><td class='text-center' colspan='6'>No matching records found</td></tr>";
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
        $('#DateFrom, #DateTo').on('keyup change', function() {
            var DateFrom = $('#DateFrom').val();
            var DateTo = $('#DateTo').val();
            if (((DateFrom != "" && DateTo != "") && (DateFrom <= DateTo))) {
                $.ajax({
                    url: "return/return_searchreport_application.php",
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