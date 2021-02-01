<?php include "templates/header.php"; ?>
<?php include "templates/navber.php"; ?>

<?php include "alert/alert_authority.php";?>

<div class="container-fluid">
  <div class="row mt-4">

    <div class="col-xl-12 col-md-6 mb-4">
      <div class="card">
        <div class="card-header text-uppercase">
          <div class="row justify-content-between">
            <div class="col">
              <i class="fas fa-file-contract"></i> Approved
            </div>
            <div class="col text-right">
              <a href="training_approve.php">Approve <i class="fas fa-arrow-alt-circle-right"></i></a>
            </div>
          </div>
        </div>

        <div class="card-body">

          <small class="text-danger">*Search by training day</small>
          <div class="form-row my-2">
            <div class="col-md-4">
              <div class="input-group mb-2 mr-sm-2">
                <div class="input-group-prepend">
                  <div class="input-group-text">From date:</div>
                </div>
                <input type="date" class="form-control DateStart" id="DateStart" name="DateStart" value="<?php $DateStart = date('Y-m-d');
                                                                                                          echo $DateStart; ?>" autocomplete="off">
              </div>
            </div>
            <div class="col-md-4">
              <div class="input-group mb-2 mr-sm-2">
                <div class="input-group-prepend">
                  <div class="input-group-text">To date:</div>
                </div>
                <input type="date" class="form-control DateEnd" id="DateEnd" name="DateEnd" value="<?php $DateEnd = date('Y-m-d');
                                                                                                    echo $DateEnd; ?>" autocomplete="off">
              </div>
            </div>
            <div class="col-md-4">
              <div class="input-group mb-2 mr-sm-2">
                <div class="input-group-prepend">
                  <div class="input-group-text"><i class="fas fa-search"></i></div>
                </div>
                <input type="text" class="form-control" id="SearchExaminer" placeholder="keyword" autocomplete="off">
              </div>
            </div>
          </div>

          <div id="FineLeaveDate">
            <div class="hidden-scroll-y custom-scrollbar">
              <div class="blog-card">

                <?php

                $sql = "SELECT DISTINCT ReqInfo.ReqNo, ReqInfo.ReqRemark, ReqInfo.ReqDay, ReqInfo.ReqHour, 
                ReqInfo.ReqSumTime, ReqInfo.ReqIssuer, ReqUser.EmpUserName, ReqUser.EmpUserSurname, 
                ReqUser.EmpUserPosition, ReqUser.EmpUserSection, ReqUser.EmpUserDepartment
FROM ReqInfo 
INNER JOIN ReqUser ON ReqInfo.ReqIssuer = ReqUser.EmpUserID
WHERE (ReqInfo.ReqType = 4) 
AND (ReqInfo.ReqChecker = '$SesUserID') 
AND (dbo.ReqInfo.ReqCheckDate IS NOT NULL)
AND ((dbo.ReqInfo.ReqDate >= '$DateStart 00:00:00' AND dbo.ReqInfo.TrnTime <= '$DateEnd 23:59:00')
OR (dbo.ReqInfo.TrnTime >= '$DateStart 00:00:00' AND dbo.ReqInfo.ReqDate <= '$DateEnd 23:59:00'))
ORDER BY ReqInfo.ReqNo DESC";

                $params = array();
                $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
                $stmt = sqlsrv_query($connRequest, $sql, $params, $options);
                $row_count = sqlsrv_num_rows($stmt);

                if ($row_count > 0) {
                  $iScore = 1;
                  $query = sqlsrv_query($connRequest, $sql);
                  while ($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {

                ?>
                    <div class="description">
                      <div class="border-card border-right-0 border-left-0 border-bottom-0">
                        <div class="card-type-icon">
                          <strong class="mr-2"><?php echo $iScore . " )"; ?></strong>
                          <!--<input type="checkbox" class="emp_checkbox pointer" value="<?php //echo $result["ReqNo"]; 
                                                                                          ?>" name="CheckStaff[]">-->
                        </div>
                        <!--<img class="card-type-icon with-border" src="../img/user_photo/<?php //echo $result["ReqIssuer"];
                                                                                            ?>.jpg" alt="No picture">-->
                        <div class="content-wrapper">
                          <div class="min-width-name">
                            <p class="title"><strong class="caption">ID:</strong> <?php echo $result["ReqIssuer"]; ?></p>
                            <p class="title"><strong class="caption">Name:</strong> <?php echo $result["EmpUserName"] . "\n" . $result["EmpUserSurname"]; ?></p>
                          </div>
                          <div class="min-gap"></div>
                          <div class="label-group min-width-dept">
                            <p class="title"><strong class="caption">Dept:</strong> <?php echo $result["EmpUserDepartment"]; ?></p>
                            <p class="title"><strong class="caption">Section:</strong> <?php echo $result["EmpUserSection"]; ?></p>
                          </div>
                          <div class="min-gap"></div>
                          <div class="label-group min-width-req">
                            <p class="title"><strong class="caption">Course:</strong> <?php echo $result["ReqRemark"]; ?></p>
                            <p class="title"><strong class="caption">Duration:</strong> <?php echo round($result["ReqDay"], 2) . "Day, " . round($result["ReqHour"], 2) . "Hrs"; ?></p>
                          </div>
                        </div>
                        <button type="button" class="btn btn-greenblue end-icon BttLookModalChecked" data-toggle="modal" data-id="<?php echo $result["ReqNo"]; ?>"><i class="far fa-eye"></i></button>
                      </div>
                    </div>
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
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>




  </div><!-- .row -->
</div><!-- .container-fluid -->


<?php include "templates/footer.php"; ?>


<!-- Modal -->
<div class="modal fade ModalChecked" tabindex="-1" role="dialog" aria-labelledby="reque_title" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header text-greenblue">
        <h5 class="modal-title" id="reque_title">Approved</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <input type="hidden" id="txtNoDetail" name="txtNoDetail">
        <div id="emp_Detail"></div>

      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  $(document).ready(function() {
    $('.BttLookModalChecked').click(function() {
      var ids = $(this).attr('data-id');
      $("#txtNoDetail").val(ids);
      $('.ModalChecked').modal('show');
      var Item_ReqNo = $('#txtNoDetail').val();
      if (Item_ReqNo != '') {
        $.ajax({
          url: "return/return_approved.php",
          method: "POST",
          data: {
            Item_ReqNo: Item_ReqNo
          },
          success: function(data) {
            $('#emp_Detail').html("" + $.trim(data) + "");
          }
        });
      }
      /*else {
        alert("Please select the employee!!");
      }*/
    });
  });
</script>

<script type="text/javascript">
  //! Checked Modal Start
  $(document).ready(function() {
    $('.DateStart, .DateEnd').on('keyup change', function() {
      var DateFrom = $('#DateStart').val();
      var DateTo = $('#DateEnd').val();
      if (((DateFrom != "" && DateTo != "") && (DateFrom <= DateTo))) { //alert(DateTo);
        $.ajax({
          url: "return/return_searchapproved.php",
          method: "POST",
          data: {
            DateFrom: DateFrom,
            DateTo: DateTo
          },
          success: function(data) {
            $('#FineLeaveDate').html("" + $.trim(data) + "");
          }
        });
      } else {
        //alert("Please check the date/time.!!");
        $('#FineLeaveDate').empty();
      }
    });
  });
  //! Checked Modal End


  $(document).ready(function() {
    $("#SearchExaminer").on("keyup change", function() {
      var value = $(this).val().toLowerCase();
      $(".blog-card .description").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });
</script>