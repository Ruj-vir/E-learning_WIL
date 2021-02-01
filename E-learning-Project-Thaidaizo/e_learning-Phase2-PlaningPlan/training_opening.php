<?php include "templates/header.php"; ?>
<?php include "templates/navber.php"; ?>

<?php include "alert/alert_authority.php";?>

<div class="container-fluid">
    <div class="row">

        <div class="col-xl-12 col-md-6 mb-4">
            <div class="card my-4">
                <div class="card-header text-uppercase">
                    <i class="fas fa-border-all"></i> Course Opening
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="reqTableMyList" class="table table-hover text-truncate nowrap" style="width:100%">
                            <thead class="text-truncate text-orange">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Course name</th>
                                    <th scope="col">Date/Time</th>
                                    <th scope="col">Duration</th>
                                    <th scope="col">Cost</th>
                                    <th class="text-center" scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $ListSql = "SELECT DISTINCT ReqNo, ReqDate, TrnTime, ReqDay, 
                                ReqHour, ReqRemark, ReqSumTime, ReqRemark, Status
                                
                                FROM ReqInfo
                                WHERE (ReqNo NOT IN (SELECT TrainRecNo FROM EducationSystem.dbo.TrainRecHdr)) 
                                AND (ReqType = 4) AND (Status = 6)";

                                $ListIParams = array();
                                $ListIOptions =  array("Scrollable" => SQLSRV_CURSOR_KEYSET);
                                $ListIStmt = sqlsrv_query($connRequest, $ListSql, $ListIParams, $ListIOptions);
                                $ListIRow = sqlsrv_num_rows($ListIStmt);

                                //if($ListIRow > 0) {
                                $iScore = 1;
                                $ListObj = sqlsrv_query($connRequest, $ListSql);
                                while ($ListResult = sqlsrv_fetch_array($ListObj, SQLSRV_FETCH_ASSOC)) {
                                    $Status = $ListResult["Status"];
                                ?>
                                    <tr>
                                        <th scope="row"><?php print $iScore; ?></th>
                                        <td><?php print $ListResult["ReqRemark"]; ?></td>
                                        <td>
                                            <div style="font-size: 14px;"><span class="text-muted mr-4">Date:</span> <?php print date_format($ListResult["ReqDate"], 'd/m/Y') . " - " . date_format($ListResult["TrnTime"], 'd/m/Y'); ?></div>
                                            <div style="font-size: 14px;"><span class="text-muted mr-4">Time:</span> <?php print date_format($ListResult["ReqDate"], 'H:i') . " - " . date_format($ListResult["TrnTime"], 'H:i'); ?></div>
                                        </td>
                                        <td><?php print round($ListResult["ReqDay"], 2) . "Day, " . round($ListResult["ReqHour"], 2) . "Hrs"; ?></td>
                                        <td><?php print number_format($ListResult["ReqSumTime"], 2) ?> THB</td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button type="button" class="btn btn-dark btn-sm" onclick="location.href='training_opening_detail.php?ItemReqNo=<?php print $ListResult['ReqNo']; ?>&j0dsu36gpd9gsu9sdj9'"><i class="fas fa-eye"></i> View</button>
                                            </div>
                                        </td>

                                    </tr>
                                <?php
                                    $iScore++;
                                }
                                /*}else {
      echo "<tr><td class='text-center' colspan='6'>No matching records found</td></tr>";
    }*/
                                ?>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div><!-- .row -->
</div><!-- .container-fluid -->

<?php include "templates/footer.php"; ?>


<link href="assets/dataTable/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="assets/dataTable/export/buttons.bootstrap4.min.css" rel="stylesheet">

<script src="assets/dataTable/jquery.dataTables.min.js"></script>
<script src="assets/dataTable/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#reqTableMyList').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            //'order': [0, 'desc'],
            //'order': [1,2, 'desc'],
            //'order': false,
            'lengthMenu': [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            'columnDefs': [{
                'targets': 5,
                'searchable': false,
                'orderable': false,
            }]
        });
    });
</script>

