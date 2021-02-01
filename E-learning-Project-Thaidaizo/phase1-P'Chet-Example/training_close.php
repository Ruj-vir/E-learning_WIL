<?php include "templates/header.php"; ?>
<?php include "templates/navber.php"; ?>

<?php include "alert/alert_authority.php";?>

<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12 col-md-6 mb-4">
            <div class="card shadow my-4">
                <div class="card-header text-uppercase">
                    <i class="fas fa-door-closed"></i> Course Closing
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="reqTableMyList" class="table table-hover text-truncate nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Course name</th>
                                    <th scope="col">Date/Time</th>
                                    <th scope="col">Period</th>
                                    <th scope="col">Requestor</th>
                                    <th class="text-center" scope="col">Actions</th>
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
    EducationSystem.dbo.TrainRecHdr.TrainRecType, 
    EducationSystem.dbo.TrainRecHdr.TrainRecEvl, 
    EducationSystem.dbo.TrainRecHdr.TrainRecTrainer, 
    EducationSystem.dbo.TrainRecHdr.TrainRecPlace, 
    EducationSystem.dbo.TrainRecHdr.TrainHdrStatus, 
    dbo.ReqUser.EmpUserID, dbo.ReqUser.EmpUserName, 
    dbo.ReqUser.EmpUserSurname
    
    FROM EducationSystem.dbo.TrainRecHdr 
    INNER JOIN dbo.ReqInfo ON EducationSystem.dbo.TrainRecHdr.TrainRecNo = dbo.ReqInfo.ReqNo 
    INNER JOIN dbo.ReqUser ON dbo.ReqInfo.ReqIssuer = dbo.ReqUser.EmpUserID
    WHERE (dbo.ReqInfo.ReqType = 4) AND (EducationSystem.dbo.TrainRecHdr.TrainHdrStatus = 1) ";

    $ListIParams = array();
    $ListIOptions =  array("Scrollable" => SQLSRV_CURSOR_KEYSET);
    $ListIStmt = sqlsrv_query($connRequest, $ListSql, $ListIParams, $ListIOptions);
    $ListIRow = sqlsrv_num_rows($ListIStmt);

    //if($ListIRow > 0) {
    $iScore = 1;
    $ListObj = sqlsrv_query($connRequest, $ListSql);
    while ($ListResult = sqlsrv_fetch_array($ListObj, SQLSRV_FETCH_ASSOC)) {

        $ReqNo = $ListResult["ReqNo"];

        $issuedSql = "SELECT TOP (1) ReqIssueDate FROM ReqInfo WHERE (ReqType = 4) AND (ReqNo = '$ReqNo') ";
        $issuedObj = sqlsrv_query($connRequest, $issuedSql);
        $issuedResult = sqlsrv_fetch_array($issuedObj, SQLSRV_FETCH_ASSOC);

                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $iScore; ?>)</th>
                                        <td><div class="text-truncate" style="width:200px"><?php echo $ListResult["ReqRemark"]; ?></div></td>
                                        <td>
                                            <div style="font-size: 14px;"><span class="text-muted mr-4">Date:</span> <?php echo date_format($ListResult["ReqDate"], 'd/m/Y') . " - " . date_format($ListResult["TrnTime"], 'd/m/Y'); ?></div>
                                            <div style="font-size: 14px;"><span class="text-muted mr-4">Time:</span> <?php echo date_format($ListResult["ReqDate"], 'H:i') . " - " . date_format($ListResult["TrnTime"], 'H:i'); ?></div>
                                        </td>
                                        <td><?php print round($ListResult["ReqDay"], 2) . "Day, " . round($ListResult["ReqHour"], 2) . "Hrs"; ?></td>
                                        <td><?php //print number_format($ListResult["ReqSumTime"], 2); ?>
                                            <div class="text-truncate"><?php echo $ListResult["EmpUserID"]." - ".$ListResult["EmpUserName"]."\n".$ListResult["EmpUserSurname"]; ?></div>
                                            <small><?php echo date_format($issuedResult["ReqIssueDate"], 'd/m/Y H:i a') ;?></small>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button type="button" class="btn btn-dark btn-sm" onclick="location.href='training_closing_detail.php?ItemReqNo=<?php echo $ListResult['ReqNo']; ?>&j0dsu36gpd9gsu9sdj9'"><i class="fas fa-eye"></i> View</button>
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
            'order': false,
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


