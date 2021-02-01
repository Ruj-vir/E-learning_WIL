<?php include "templates/header.php"; ?>
<?php include "templates/navber.php"; ?>

<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12 col-md-6 mb-4">
            <div class="card shadow my-4">
                <div class="card-header text-uppercase">
                    <i class="fab fa-discourse"></i> Course request
                </div>
                <div class="card-body">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><i class="far fa-calendar-alt"></i></a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"><i class="fas fa-table"></i></a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <div class="mt-2" id="calendar_list"></div>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <!-- /* Start Table */ -->
                            <div class="form-row mt-2">
                                <div class="col-md-4">
                                    <div class="input-group mb-2 mr-sm-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">From date:</div>
                                        </div>
                                        <input type="date" class="form-control" id="DateFrom" name="DateFrom" value="<?php //print $DateFrom = date('Y-m-d'); 
                                                                                                                        ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group mb-2 mr-sm-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">To date:</div>
                                        </div>
                                        <input type="date" class="form-control" id="DateTo" name="DateTo" value="<?php //print $DateTo = date('Y-m-d', strtotime('today')); 
                                                                                                                    ?>">
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
                                            <tr>
                                                <th scope="col">No.</th>
                                                <th scope="col">Course name</th>
                                                <th scope="col">Training date</th>
                                                <th scope="col">Period</th>
                                                <th scope="col" class="text-center">Status</th>
                                                <th scope="col" class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="tbody">
                                            <?php
                                            $ListSql = "SELECT DISTINCT TOP (20)
                                    ReqNo, ReqDate, TrnTime, ReqDay, ReqHour, ReqRemark,
                                    -- ReqIssuer, ReqIssueDate, ReqSumTime, UserDefine1, PicturePath, 
                                    Status
                                    FROM ReqInfo 
                                    WHERE (EmployeeID = '$SesUserID') 
                                    AND (ReqType = 4)
                                    -- ORDER BY ReqNo DESC";

                                            $ListIParams = array();
                                            $ListIOptions =  array("Scrollable" => SQLSRV_CURSOR_KEYSET);
                                            $ListIStmt = sqlsrv_query($connRequest, $ListSql, $ListIParams, $ListIOptions);
                                            $ListIRow = sqlsrv_num_rows($ListIStmt);

                                            if ($ListIRow > 0) {
                                                $iScore = 1;
                                                $ListObj = sqlsrv_query($connRequest, $ListSql);
                                                while ($ListResult = sqlsrv_fetch_array($ListObj, SQLSRV_FETCH_ASSOC)) {

                                                    switch ($ListResult["Status"]) {
                                                        case 0:
                                                            $Status = 'Rejected';
                                                            $Color = 'danger';
                                                            break;
                                                        case 1:
                                                            $Status = 'Pending';
                                                            $Color = 'warning';
                                                            break;
                                                        case 2:
                                                            $Status = 'Checked';
                                                            $Color = 'success';
                                                            break;
                                                        case 3:
                                                            $Status = 'Verify';
                                                            $Color = 'success';
                                                            break;
                                                        case 6:
                                                            $Status = 'Approve';
                                                            $Color = 'success';
                                                            break;
                                                        case 9:
                                                            $Status = 'Approve';
                                                            $Color = 'success';
                                                            break;

                                                        default:
                                                            $Status = '';
                                                    }
                                            ?>
                                                    <tr class="tr">
                                                        <th scope="row"><?php echo $iScore; ?>)</th>
                                                        <td><?php echo $ListResult["ReqRemark"]; ?></td>
                                                        <td>
                                                            <div style="font-size: 14px;"><span class="text-muted mr-4">Date:</span> <?php echo date_format($ListResult["ReqDate"], 'd/m/Y') . " - " . date_format($ListResult["TrnTime"], 'd/m/Y'); ?></div>
                                                            <div style="font-size: 14px;"><span class="text-muted mr-4">Time:</span> <?php echo date_format($ListResult["ReqDate"], 'H:i') . " - " . date_format($ListResult["TrnTime"], 'H:i'); ?></div>
                                                        </td>
                                                        <td><?php print round($ListResult["ReqDay"], 2) . "Day, " . round($ListResult["ReqHour"], 2) . "Hrs"; ?></td>
                                                        <td class="text-center">
                                                            <?php //print number_format($ListResult["ReqSumTime"], 2) ?>
                                                            <span class="badge badge-<?php print $Color; ?>"><?php print $Status; ?></span>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                                <a href="profile_user_course_detail.php?ItemReqNo=<?php print $ListResult["ReqNo"]; ?>&cijm36oiemf8weut9w8480rj3W0JfimP7C" class="btn btn-outline-dark btn-sm"><i class="fas fa-eye"></i> View</a>
                                                                <!-- <button type="button" class="btn btn-outline-dark btn-sm" title="" onclick="window.open('profile_user_course_detail.php?ItemReqNo=<?php //echo $ListResult['ReqNo']; ?>&j0dsu36gpd9gsu9sdj9')"><i class="fas fa-eye"></i> View</button> -->
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
            </div>
        </div>

    </div><!-- .row -->
</div><!-- .container-fluid -->

<?php include "templates/footer.php"; ?>

<link href='assets/fullcalendar/core/main.min.css' rel='stylesheet' />
<link href='assets/fullcalendar/daygrid/main.min.css' rel='stylesheet' />
<link href='assets/fullcalendar/list/main.min.css' rel='stylesheet' />

<script src='assets/fullcalendar/core/main.min.js'></script>
<script src='assets/fullcalendar/daygrid/main.min.js'></script>
<script src='assets/fullcalendar/list/main.min.js'></script>
<script src='assets/fullcalendar/interaction/main.min.js'></script>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar_list');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: ['interaction', 'dayGrid', 'list'],
            plugins: ['interaction', 'dayGrid', 'list'],
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,listMonth'
            },
            //defaultDate: '2020-02-12',
            navLinks: true, // can click day/week names to navigate views
            businessHours: true, // display business hours
            editable: false,
            weekNumbers: true,
            eventLimit: true, // allow "more" link when too many events
            events: 'return/return_course_calendar.php',
            eventTimeFormat: { // 24 hour
                hour: '2-digit',
                minute: '2-digit',
                //second: '2-digit',
                hour12: false
            }
        });
        calendar.render();
    });
</script>


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
                    url: "return/return_searchuser_course.php",
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