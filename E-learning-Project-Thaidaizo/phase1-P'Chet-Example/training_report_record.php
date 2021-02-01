<?php include "templates/header.php"; ?>
<?php include "templates/navber.php"; ?>

<?php include "alert/alert_authority.php";?>

<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12 col-md-6 mb-4">
            <form action="training_report_record_detail.php" autocomplete="off" method="GET" target="_blank">
                <div class="card shadow my-4">
                    <div class="card-header text-uppercase">
                        <i class="fas fa-print"></i> Training Record
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-3 mb-2">
                                <input type="text" class="form-control" id="FineID" name="FineID" placeholder="Search for.." required>
                            </div>
                            <div class="col-md-9 mb-2 text-right">
                                <button type="submit" name="BtPDF" value="PDF" class="btn btn-outline-danger" title="PDF File"><i class="far fa-file-pdf"></i>
                                    PDF
                                </button>
                            </div>

                        </div>

                        <div id="Finebook">

                            <div class="form-row">
                                <div class="col-md-3 mb-2">
                                    <div class="d-flex align-items-center p-3 text-white-50 bg-dark rounded">
                                        <img class="rounded mr-3" src="../img/photo_emp/square/10000.jpg" alt="Images" width="48" height="48">
                                        <div class="lh-100">
                                            <small class="text-white">-</small>
                                            <h6 class="mb-0 text-white text-uppercase lh-100">-</h6>
                                        </div>
                                    </div>
                                    <div class="form-group mt-2">
                                        <ul>
                                            <li><small>Position:</small> -</li>
                                            <li><small>Section:</small> -</li>
                                            <li><small>Dept:</small> -</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-9 mb-2">
                                    <!-- /* Start Table */ -->
                                    <div class="table-responsive">
                                        <table class="table text-truncate" id="reqTableMyList" width="100%" cellspacing="0">
                                            <thead class="text-uppercase thead-light">
                                                <tr>
                                                    <th scope="col">No.</th>
                                                    <th scope="col">Training date</th>
                                                    <th scope="col">Subject</th>
                                                    <th scope="col">Period</th>
                                                    <th scope="col">Trainer</th>
                                                    <th scope="col">Result</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row"></th>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /* End Table */ -->
                                </div>
                            </div>

                        </div>

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
        $('#FineID').on('keyup change', function() {
            var FineID = $('#FineID').val();
            if (FineID != "") {
                $.ajax({
                    url: "return/return_searchreport_record.php",
                    method: "POST",
                    data: {
                        FineID: FineID
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