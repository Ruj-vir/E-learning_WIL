<?php include "templates/header.php"; ?>
<?php include "templates/navber.php"; ?>

<?php include "alert/alert_authority.php";?>

<div class="container-fluid">

  <div class="row mt-4">
    <div class="col-lg-12 col-md-6 mb-4">
      <div class="card shadow">
        <div class="card-header text-uppercase">
          <div class="row justify-content-between">
            <div class="col">
              <i class="fas fa-file-alt"></i> Verify
            </div>
            <div class="col text-right">
              <a href="training_verified.php">Verified <i class="fas fa-arrow-alt-circle-right"></i></a>
            </div>
          </div>
        </div>

        <div class="card-body">
          <form id="formCheck" name="formCheck" class="form" action="save/save_verify_group.php" autocomplete="off" method="POST" target="iframe_check_ReqGroup">

            <div class="form-row my-2">
              <div class="col">
                <h4><span class="badge badge-light"><span class="badge badge-dark" id="select_count">0</span> Selected</span></h4>
              </div>
              <div class="col">
                <input type="text" id="SearchExaminer" class="form-control " placeholder="Search.." autocomplete="off">
              </div>
            </div>


            <div class="hidden-scroll-y custom-scrollbar">
              <div class="blog-card">

                <?php

                $sql = "SELECT DISTINCT 
                dbo.ReqInfo.ReqNo, 
                dbo.ReqInfo.ReqRemark, 
                dbo.ReqInfo.ReqDay, 
                dbo.ReqInfo.ReqHour, 
                dbo.ReqInfo.ReqSumTime, 
                dbo.ReqInfo.UserDefine1, 
                dbo.ReqInfo.ReqDate, 
                dbo.ReqInfo.TrnTime, 

                dbo.ReqUser.EmpUserID, 
                dbo.ReqUser.EmpUserName, 
                dbo.ReqUser.EmpUserSurname, 
                dbo.ReqUser.EmpUserPosition, 
                dbo.ReqUser.EmpUserSection, 
                dbo.ReqUser.EmpUserDepartment

                FROM dbo.ReqInfo 
                INNER JOIN dbo.ReqUser ON dbo.ReqInfo.ReqIssuer = dbo.ReqUser.EmpUserID
                WHERE (dbo.ReqInfo.ReqType = 4) 
                AND (dbo.ReqInfo.ReqApprover = '$SesUserID') 
                AND (dbo.ReqInfo.Status = 2)
                ORDER BY dbo.ReqInfo.ReqNo ";


                $params = array();
                $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
                $stmt = sqlsrv_query($connRequest, $sql, $params, $options);
                $row_count = sqlsrv_num_rows($stmt);

                if ($row_count > 0) {
                  $iScore = 1;
                  $query = sqlsrv_query($connRequest, $sql);
                  while ($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                    $EleData = explode('|', $result["UserDefine1"]);

                ?>
                    <div class="description">
                      <div class="border-card border-right-0 border-left-0 border-bottom-0">
                        <div class="card-type-icon">
                          <!--<strong class="mr-2"><?php //echo $iScore; 
                                                    ?></strong>-->
                          <input type="checkbox" class="emp_checkbox pointer" value="<?php echo $result["ReqNo"]; ?>" name="CheckStaff[]">
                        </div>
                        <!--<img class="card-type-icon with-border" src="../img/user_photo/<?php //echo $result["ReqIssuer"];
                                                                                            ?>.jpg" alt="No picture">-->
                        <div class="content-wrapper">
                          <div class="min-width-name">
                            <p class="title text-truncate"><strong class="caption">Course:</strong> <?php echo $result["ReqRemark"]; ?></p>
                            <p class="title text-truncate"><strong class="caption">Requestor :</strong> <?php echo $result["EmpUserID"]." - ".$result["EmpUserName"]."\n".$result["EmpUserSurname"]; ?></p>
                          </div>
                          <div class="min-gap"></div>
                          <div class="label-group min-width-dept">
                            <p class="title"><strong class="caption">Date:</strong> <?php echo date_format($result["ReqDate"], 'd/m/Y') . " - " . date_format($result["TrnTime"], 'd/m/Y'); ?></p>
                            <p class="title"><strong class="caption">Time:</strong> <?php echo date_format($result["ReqDate"], 'H:i') . " - " . date_format($result["TrnTime"], 'H:i'); ?></p>
                          </div>
                          <div class="min-gap"></div>
                          <div class="label-group min-width-req">
                            <p class="title"><strong class="caption">Location:</strong> <?php echo $EleData[3]; ?></p>
                            <p class="title"><strong class="caption">Cost:</strong> <?php echo number_format($result["ReqSumTime"], 2). " THB"; ?></p>
                          </div>
                        </div>
                        <button type="button" class="btn btn-greenblue end-icon BttLookModalCheck" data-toggle="modal" data-id="<?php echo $result["ReqNo"]; ?>"><i class="fas fa-pen-square"></i></button>
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

            <!-- Modal -->
            <div class="modal fade" id="Cancel_modal" tabindex="-1" role="dialog" aria-labelledby="Status_title" aria-hidden="true">
              <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header text-greenblue">
                    <h5 class="modal-title" id="Status_title">Rejected</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">

                    <div class="form-group">
                      <label for="inputReason">Reason for cancellation</label>
                      <textarea class="form-control" id="RejectForm" name="txtReject" rows="3" maxlength="50" placeholder="Enter.."></textarea>
                    </div>

                  </div>
                  <div class="modal-footer">
                    <button type="submit" name="RejectCheckedGroup" value="3" class="btn btn-danger" onclick="return BttCancel();">Confirm</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- Modal -->

            <div class="card-footer border-light bg-white cart-panel-foo-fix">
              <div class="d-flex mt-3">
                <div class="mr-auto">
                  <strong class="mr-2">Total: <?php echo $row_count; ?></strong>
                </div>
                <div class="mr-1"><button type="submit" name="SubmitCheckedGroup" value="1" class="btn btn-success" onclick="return BttSubmitCheck();"><i class="fa fa-check-circle"></i> Verify</button></div>
                <div><button type="button" class="btn btn-danger" onclick="return BttSubmitReject();"><i class="fa fa-times-circle"></i> Reject</button></div>
              </div>
            </div>

          </form>
        </div>
      </div>
    </div>

  </div><!-- .row -->
</div><!-- .container-fluid -->


<?php include "templates/footer.php"; ?>


<!-- Modal Check -->
<form id="frmrequest" name="frmrequest" class="form" action="save/save_verify_list.php" autocomplete="off" method="POST" target="iframe_check_Reqlist">
  <div class="modal fade ModalCheckOTList" tabindex="-1" role="dialog" aria-labelledby="reque_title" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header text-greenblue">
          <h5 class="modal-title" id="reque_title">Verify</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="txtReqNo" name="txtReqNo" readonly>
          <div id="emp_order"></div>
        </div>
        <div class="modal-footer">
          <!--
        <div class="input-group my-2">
          <div class="input-group-prepend">
            <div class="input-group-text rounded"><span class="rows_selected" id="select_counter">0 Selected</span></div>
          </div>
        </div>
        -->

          <button type="submit" name="SubmitCheckedList" value="1" class="btn btn-success" onclick="return BttSubmitCheckList();"><i class="fa fa-check-circle"></i>&nbsp; Verify</button>
          <button type="button" class="btn btn-danger" data-toggle="modal" onclick="return BttSubmitRejectList();"><i class="fa fa-times-circle"></i>&nbsp; Reject</button>

          <!-- Modal -->
          <div class="modal fade" id="Cancel_list" tabindex="-1" role="dialog" aria-labelledby="Status_title" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header text-greenblue">
                  <h5 class="modal-title" id="Status_title">Rejected</h5>
                  <button type="button" class="close Cancel-list-close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label for="inputReason">Reason for cancellation</label>
                    <textarea class="form-control" id="RejectList" name="txtReject" rows="3" maxlength="50" placeholder="Enter.."></textarea>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" name="RejectCheckedList" value="3" class="btn btn-danger" onclick="return Bttlist();">Confirm</button>
                </div>
              </div>
            </div>
          </div>
          <!-- Modal -->
        </div>
      </div>
    </div>
  </div>
</form>


<iframe id="iframe_check_ReqGroup" name="iframe_check_ReqGroup" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
<iframe id="iframe_check_Reqlist" name="iframe_check_Reqlist" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>




<!-- Start Modal Success -->
<div id="ModalSuccess" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="icon-box">
                    <i class="far fa-check-circle" style="font-size: 60px;"></i>
                </div>
                <h4 class="modal-title w-100">successfully</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">Your assessment has been successful.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-block" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#ModalSuccess').on('hidden.bs.modal', function() {
        window.location.href = 'training_verify.php';
        //window.location.reload();
        //$('#formAssessment')[0].reset();
    });
</script>
<!-- End Modal Success -->

<!-- Start Modal Load -->
<div id="LoadModal" class="modal fade">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content" style="background: none !important;border: none;">
      <div class="modal-body text-center">
        <div class="spinner-grow text-light" role="status" style="width: 5rem; height: 5rem;">
          <span class="sr-only">Loading...</span>
        </div>
        <div class="text-center text-light">Please wait...</div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  function LoadingResult(Loading) {
    if (Loading == 1) {
      $('#LoadModal').modal({
        backdrop: 'static',
        keyboard: false,
        show: true
      });
    }
  }

  function TrainingResult(Request) {
    if (Request == 1) {
      $('#Cancel_modal').modal('hide'),
      $('#Cancel_list').modal('hide'),
      $('.ModalCheckOTList').modal('hide'),
      //alert('Successfully.'),
      setInterval("$('#LoadModal').modal('hide')", 1500),
      setInterval("$('#ModalSuccess').modal('show')", 2000);
      //$("#ResultAccept").html("<div class='alert alert-success' role='alert'>Successfully.</div>"),
      //setInterval('window.location.href = "training_check.php', 1000);
    } else {
      setInterval("$('#LoadModal').modal('hide')", 0);
      //window.location.href = "../training_request.php";
    }
  }
</script>
<!-- End Modal Load -->



<script type="text/javascript">
  $(function() {
    $(".Cancel-list-close").on('click', function() {
      $('#Cancel_list').modal('hide');
    });
  });
</script>



<script type="text/javascript">
  //! Check Start
  $(document).ready(function() {
    $("#SearchExaminer").on("keyup change", function() {
      var value = $(this).val().toLowerCase();
      $(".blog-card .description").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });

  $('document').ready(function() {
    // select all checkbox
    $(document).on('click', '#select_all', function() {
      $(".emp_checkbox").prop("checked", this.checked);
      $("#select_count").html($("input.emp_checkbox:checked").length + "");
    });
    $(document).on('click', '.emp_checkbox', function() {
      if ($('.emp_checkbox:checked').length == $('.emp_checkbox').length) {
        $('#select_all').prop('checked', true);
      } else {
        $('#select_all').prop('checked', false);
      }
      $("#select_count").html($("input.emp_checkbox:checked").length + "");
    });
  });
  //! Check End



  //! Check Modal Start
  $(document).ready(function() {
    $('.BttLookModalCheck').click(function() {
      var ids = $(this).attr('data-id');
      $("#txtReqNo").val(ids);
      $('.ModalCheckOTList').modal('show');
      var ItemReqNo = $('#txtReqNo').val();
      if (ItemReqNo != '') {
        $.ajax({
          url: "return/return_verify.php",
          method: "POST",
          data: {
            Item_ReqNo: ItemReqNo
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





<script type="text/javascript">
  //! Button Start
  function BttSubmitCheck() {
    if (!$('.emp_checkbox').is(':checked')) {
      alert('Please select request form.');
      return false;
    } else if (confirm('Are you sure you want to submit the form ?') == true) {
      return true;
    } else {
      return false;
    }
  }

  function BttSubmitReject() {
    if (!$('.emp_checkbox').is(':checked')) {
      alert('Please select request form.');
      return false;
    } else if ($('.emp_checkbox').is(':checked')) {
      $('#Cancel_modal').modal('show');
    }
  }

  ////////////////////////////////////////////////
  function Bttlist() {
    if (document.getElementById('RejectList').value == "") {
      document.getElementById("RejectList").required = true;
    } else if (confirm('Are you sure you want to reject employee ?') == true) {
      return true;
    } else {
      return false;
    }
  }

  function BttCancel() {
    if (document.getElementById('RejectForm').value == "") {
      document.getElementById("RejectForm").required = true;
    } else if (confirm('Are you sure you want to reject the form ?') == true) {
      return true;
    } else {
      return false;
    }
  }

  //////////////////////////////////////////////
  function BttSubmitCheckList() {
    if (!$('.item_checkbox').is(':checked')){
      alert('Please select employee!');
      return false;
    }
    if (confirm('Are you sure you want to submit employee ?') == true) {
      return true;
    } else {
      return false;
    }
  }
  function BttSubmitRejectList() {
      if (!$('.item_checkbox').is(':checked')){
      alert('Please select employee!');
      return false;
      }
     if ($('.item_checkbox').is(':checked')){
      $('#Cancel_list').modal('show');
    }
  }


  ////////////////////////////////////////////////
  function Bttlist() {
    if (document.getElementById('RejectList').value == "") {
      document.getElementById("RejectList").required = true;
    } else if (confirm('Are you sure you want to reject employee ?') == true) {
      return true;
    } else {
      return false;
    }
  }

  function BttCancel() {
    if (document.getElementById('RejectForm').value == "") {
      document.getElementById("RejectForm").required = true;
    } else if (confirm('Are you sure you want to reject the form ?') == true) {
      return true;
    } else {
      return false;
    }
  }
  //! Button End
</script>