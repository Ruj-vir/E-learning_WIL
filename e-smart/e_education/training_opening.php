<?php include "templates/header.php"; ?>
<?php include "templates/navber.php"; ?>


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
                                    <th scope="col">Location</th>
                                    <th scope="col">Status</th>
                                    <th class="text-center" scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $ListSql = "SELECT DISTINCT ReqNo, ReqDate, TrnTime, ReqRemark, UserDefine1, Status
                                FROM ReqInfo WHERE (ReqIssuer = '$SesUserID') AND (ReqType = 4) AND (Status = 9) ORDER BY ReqNo ASC";

                                $ListIParams = array();
                                $ListIOptions =  array("Scrollable" => SQLSRV_CURSOR_KEYSET);
                                $ListIStmt = sqlsrv_query($connRequest, $ListSql, $ListIParams, $ListIOptions);
                                $ListIRow = sqlsrv_num_rows($ListIStmt);

                                //if($ListIRow > 0) {
                                $iScore = 1;
                                $ListObj = sqlsrv_query($connRequest, $ListSql);
                                while ($ListResult = sqlsrv_fetch_array($ListObj, SQLSRV_FETCH_ASSOC)) {

                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $iScore; ?></th>
                                        <td><?php echo $ListResult["ReqRemark"]; ?></td>
                                        <td>
                                            <div style="font-size: 14px;"><span class="text-muted mr-4">Date:</span> <?php echo date_format($ListResult["ReqDate"], 'd/m/Y') . " - " . date_format($ListResult["TrnTime"], 'd/m/Y'); ?></div>
                                            <div style="font-size: 14px;"><span class="text-muted mr-4">Time:</span> <?php echo date_format($ListResult["ReqDate"], 'H:i') . " - " . date_format($ListResult["TrnTime"], 'H:i'); ?></div>
                                        </td>

                                        <td><?php echo $ListResult["UserDefine1"]; ?></td>

                                        <td>
                                            <?php
                                            switch ($ListResult["Status"]) {
                                                case 0:
                                                    $StatusReq = 'Cancel';
                                                    $StatusColor = 'danger';
                                                    break;
                                                case 1:
                                                    $StatusReq = 'Verify';
                                                    $StatusColor = 'warning';
                                                    break;
                                                case 2:
                                                    $StatusReq = 'Reply';
                                                    $StatusColor = 'warning';
                                                    break;
                                                case 3:
                                                    $StatusReq = 'Check';
                                                    $StatusColor = 'warning';
                                                    break;

                                                case 4:
                                                    $StatusReq = 'Return';
                                                    $StatusColor = 'warning';
                                                    break;

                                                case 6:
                                                    $StatusReq = 'Approve';
                                                    $StatusColor = 'warning';
                                                    break;
                                                case 9:
                                                    $StatusReq = 'Approved';
                                                    $StatusColor = 'success';
                                                    break;

                                                default:
                                                    $StatusReq = '';
                                                    $StatusColor = '';
                                            }
                                            ?>
                                            <span class="badge w-100 badge-<?php echo $StatusColor; ?>"><?php echo $StatusReq; ?></span>
                                        </td>

                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button type="button" class="btn btn-dark btn-sm" onclick="location.href='profile_daizo_mylist_detail.php?ItemReqNo=<?php echo $ListResult['ReqNo']; ?>&j0dsu36gpd9gsu9sdj9'"><i class="far fa-eye"></i></button>
                                                <?php
                                                if (($ListResult["Status"] == 0) ||
                                                    ($ListResult["Status"] == 2) ||
                                                    ($ListResult["Status"] == 3) ||
                                                    ($ListResult["Status"] == 6) ||
                                                    ($ListResult["Status"] == 9)
                                                ) {
                                                    $block = 'disabled';
                                                } else {
                                                    $block = NULL;
                                                }
                                                ?>
                                                <button type="button" class="btn btn-danger btn-sm UserCancel" data-id="<?php echo $ListResult["ReqNo"]; ?>" <?php print $block; ?> title="Cancel"><i class="far fa-window-close"></i></button>
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

    //! Modal cancel list leave*
    $(".UserCancel").click(function() {
        var ids = $(this).attr('data-id');
        $("#inputQloNo").val(ids);
        $('#ModalUserCancel').modal('show');
    });
</script>

<script type="text/javascript">
    //! 
    function UserCancel() {
        if (confirm('Are you sure you want to cancel the request form ?') == true) {
            return true;
        } else {
            return false;
        }
    }

    //!
    function QloReqReturn(ResultReturn) {
        if (ResultReturn == 1) {
            $("#ResultReturn").html("<div class='alert alert-success' role='alert'>Successfully.</div>");
            setInterval('window.location.href = "profile_daizo_mylist_table.php"', 1000);
            //$('#ModalSuccess').modal('show');
        } else {
            $('#ResultReturn').html("<div class='alert alert-danger text-center' role='alert'>Unsuccessful.</div>");
        }
    }
</script>


<!-- Modal User Cancel -->
<form id="frmStatus" name="frmStatus" action="save/cancel_daizo_list_user.php" enctype="multipart/form-data" autocomplete="off" method="POST" target="iframe_UserCancel_Req">
    <div class="modal fade" id="ModalUserCancel" tabindex="-1" role="dialog" aria-labelledby="Status_title" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-light" id="Status_title">Cancel request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="inputPetition">Petition number</label>
                        <input type="text" id="inputQloNo" name="inputQloNo" class="form-control" placeholder="" readonly="readonly" required="required">
                    </div>
                    <div class="form-group">
                        <label for="inputReason">Reason for cancellation</label>
                        <textarea class="form-control" id="inputReject" name="inputReject" rows="3" required placeholder="Enter.."></textarea>
                    </div>

                    <div id="ResultReturn"></div>

                </div>
                <div class="modal-footer">
                    <button type="submit" name="BttUserCancelOT" value="3" class="btn btn-danger" onclick="return UserCancel();">Confirm</button>
                </div>
            </div>
        </div>
    </div>
</form>
<iframe id="iframe_UserCancel_Req" name="iframe_UserCancel_Req" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
<!-- Modal -->