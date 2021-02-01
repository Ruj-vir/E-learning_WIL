<?php include "templates/header.php"; ?>
<?php include "templates/navber.php"; ?>

<?php
if (isset($_GET["ItemReqNo"]) != "") {

  $str = trim($_GET["ItemReqNo"]);
  //$FineDataEmp = addslashes($str);
  $vowels = array("'");
  $ItemReqNo = str_replace($vowels, '', $str);
  
  $ListSql = "SELECT 
    dbo.ReqInfo.ReqNo, 
    dbo.ReqInfo.ReqDate, 
    dbo.ReqInfo.TrnTime, 
    dbo.ReqInfo.ReqDay, 
    dbo.ReqInfo.ReqHour, 
    dbo.ReqInfo.ReqSumTime, 
    dbo.ReqInfo.ReqRemark, 
    dbo.ReqInfo.PicturePath, 
    dbo.ReqInfo.UserDefine1, 

    EducationSystem.dbo.TrainRecHdr.TrainRecType, 
    EducationSystem.dbo.TrainRecHdr.TrainRecEvl, 
    EducationSystem.dbo.TrainRecHdr.TrainRecTrainer, 
    EducationSystem.dbo.TrainRecHdr.TrainRecPlace, 
    EducationSystem.dbo.TrainRecHdr.TrainHdrStatus
    FROM EducationSystem.dbo.TrainRecHdr 
    INNER JOIN dbo.ReqInfo 
    ON EducationSystem.dbo.TrainRecHdr.TrainRecNo = dbo.ReqInfo.ReqNo
    WHERE (dbo.ReqInfo.ReqNo = '$ItemReqNo') AND (dbo.ReqInfo.ReqType = 4) AND (EducationSystem.dbo.TrainRecHdr.TrainHdrStatus = 1) ";

  $ListIParams = array();
  $ListIOptions =  array("Scrollable" => SQLSRV_CURSOR_KEYSET);
  $ListIStmt = sqlsrv_query($connRequest, $ListSql, $ListIParams, $ListIOptions);
  $ListIRow = sqlsrv_num_rows($ListIStmt);

  if ($ListIRow > 0) {
    $iScore = 1;
    $ListObj = sqlsrv_query($connRequest, $ListSql);
    $ListResult = sqlsrv_fetch_array($ListObj, SQLSRV_FETCH_ASSOC);
  } else {
    echo "<script>window.location.href='index.php'</script>";
    exit();
  }
} else {
  echo "<script>window.location.href='index.php'</script>";
  exit();
}

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

switch ($ListResult["TrainRecEvl"]) {
  case 1:
    $TrainRecEvl = 'Work shop';
    break;
  case 2:
    $TrainRecEvl = 'Theory';
    break;
  case 3:
    $TrainRecEvl = 'Other';
    break;

  default:
    $TrainRecEvl = '';
}


?>

<div class="container-fluid">
  <div class="row">

    <div class="col-xl-12 col-md-6 mb-4">
      <div class="card my-4">
        <div class="card-header text-uppercase">
          <i class="fas fa-id-card-alt"></i> Register Card
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-sm-6 mb-2">
              Trainer: <span class="font-weight-bold h6"><?php print $ListResult["TrainRecTrainer"]; ?></span>
            </div>
            <div class="col-sm-6 mb-2">
              Type: <span class="font-weight-bold h6"><?php print $TrainRecEvl; ?></span>
            </div>
            <div class="col-sm-6 mb-2">
              Evaluation: <span class="font-weight-bold h6"><?php print $TrainRecType; ?></span>
            </div>
            <div class="col-sm-6 mb-2">
              Course: <span class="font-weight-bold h6"><?php print $ListResult["ReqRemark"]; ?></span>
            </div>
            <div class="col-sm-6 mb-2">
              Date: <span class="font-weight-bold h6"><?php print date_format($ListResult["ReqDate"], 'd M. Y') . " - " . date_format($ListResult["TrnTime"], 'd M. Y') ?></span>
            </div>
            <div class="col-sm-6 mb-2">
              Time: <span class="font-weight-bold h6"><?php print date_format($ListResult["ReqDate"], 'H:i') . " - " . date_format($ListResult["TrnTime"], 'H:i') ?></span>
            </div>
            <div class="col-sm-6 mb-2">
              Duration: <span class="font-weight-bold h6"><?php print round($ListResult["ReqDay"], 2) . "Day, " . round($ListResult["ReqHour"], 2) . "Hrs" ?></span>
            </div>
            <div class="col-sm-6 mb-2">
              Cost: <span class="font-weight-bold h6"><?php print number_format($ListResult["ReqSumTime"], 2) ?> THB</span>
            </div>
            <div class="col-sm-6 mb-2">
              Object: <span class="font-weight-bold h6"><?php $EleData = explode('|', $ListResult["UserDefine1"] ); print $EleData[1]; ?></span>
            </div>
            <div class="col-sm-6 mb-2">
              Organizer: <span class="font-weight-bold h6"><?php print $EleData[2]; ?></span>
            </div>
            <div class="col-sm-6 mb-2">
              Location: <span class="font-weight-bold h6"><?php print $EleData[3]; ?></span>
            </div>
            <div class="col-sm-6 mb-2">
              Trainees Total: <span class="font-weight-bold h6 mr-3"><?php print $ListIRow; ?></span>
              <button type="button" class="btn btn-sm btn-dark" id="BttLookModal" title="Trainees list" data-id="<?php echo $ListResult["ReqNo"]; ?>"><i class="fas fa-external-link-alt"></i></button>
            </div>
          </div>

          <hr>

          <form id="RegisterForm" name="RegisterForm" action="save/save_register_card_training.php" autocomplete="off" method="POST" target="iframe_register">
            <div class="form-group row">
              <label for="inputDescription" class="col-sm-3 col-form-label">Register card:</label>
              <div class="col-sm-9">
                <input type="hidden" id="InputKeyID" name="InputKeyID" value="<?php print $ListResult["ReqNo"]; ?>" required readonly>
                <input type="text" class="form-control" id="InputRFID" name="InputRFID" placeholder="Enter RFID" pattern=".{10,}" title="Please enter at least 10 codes." required>
              </div>
            </div>
            <div class="row justify-content-end">
              <div class="col-sm-9">
                <div div id="PickingRFID"></div>
              </div>
            </div>
          </form>

          <div id="PickingMain"></div>

        </div>
      </div>
    </div>

  </div><!-- .row -->
</div><!-- .container-fluid -->

<?php include "templates/footer.php"; ?>


<iframe id="iframe_register" name="iframe_register" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>

<script type="text/javascript">
  $(function() {
    setInterval(function() { // เขียนฟังก์ชัน javascript ให้ทำงานทุก ๆ 30 วินาที
      var InputKeyID = $('#InputKeyID').val();
      // 1 วินาที่ เท่า 1000
      // คำสั่งที่ต้องการให้ทำงาน ทุก ๆ 3 วินาที
      var getData = $.ajax({ // ใช้ ajax ด้วย jQuery ดึงข้อมูลจากฐานข้อมูล
        url: "return/return_register_card.php",
        data: {
          Item_InputKeyID: InputKeyID
        },
        async: false,
        success: function(getData) {
          $("div#PickingMain").html(getData); // ส่วนที่ 3 นำข้อมูลมาแสดง
        }
      }).responseText;
    }, 1000);
  });
</script>

<div class="modal fade" id="ModalTraineesList" tabindex="-1" role="dialog" aria-labelledby="reque_title" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header text-greenblue">
        <h5 class="modal-title" id="reque_title">Requested trainees</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="inputReqNo" name="inputReqNo" readonly>
        <div id="emp_order"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  //! Check Modal Start
  $(document).ready(function() {
    $('#BttLookModal').click(function() {
      var ids = $(this).attr('data-id');
      $("#inputReqNo").val(ids);
      $('#ModalTraineesList').modal('show');
      var ItemReqNo = $('#inputReqNo').val();
      if (ItemReqNo != '') {
        $.ajax({
          url: "return/return_course_opening.php",
          method: "POST",
          data: {
            ItemReqNo: ItemReqNo
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
  //! Focus Input RFID Start
  $(window).load(function() {
    $(document).ready(function() {
      $("#InputRFID").focus().bind('blur', function() {
        $(this).focus();
      });
      //disable tabindex on elements
      $("input").attr("tabindex", "-1");

      $("html").click(function() {
        $("#InputRFID").val($("#InputRFID").val()).focus();
      });
    });
  });
  //! Focus Input RFID End
</script>

<audio id="alert" src="assets/media/sound/buzzer.mp3" type="audio/mpeg"></audio>
<audio id="Okey" src="assets/media/sound/thank_you.mp3" type="audio/mpeg"></audio>
<audio id="again" src="assets/media/sound/try_again.mp3" type="audio/mpeg"></audio>

<script type="text/javascript">
  //! Record register Start
  $(function() {
    $('#InputRFID').bind('change keyup', function() {
      var InputKeyID = $('#InputKeyID').val();
      var InputRFID = $('#InputRFID').val();
      if (($.trim(InputKeyID).length == 12) && $.trim(InputRFID).length >= 10) {
        setTimeout(function() {
          //document.getElementById("again").pause();
          document.getElementById("InputRFID").readOnly = true;
          document.RegisterForm.submit();
        }, 0);
      } else {
        setTimeout(function() {
          //document.getElementById("InputRFID").value = "";
          //$('#RegisterForm').trigger("reset");
          $('#InputRFID').val('');
          $('#PickingRFID').empty();
          //$('#InputRFID').val(InputKeyID);
        }, 3000);
      }
    })
  });
  //! Record register End
</script>

<script type="text/javascript">
  //! Record register Start
  function TrainingResult(PickingRFID) {

    var AutoFocus = document.getElementById("InputRFID");
    var Okey = document.getElementById("Okey");
    var again = document.getElementById("again");

    if (PickingRFID == 1) {

      $('#InputRFID').val('');
      $('#PickingRFID').empty();
      Okey.play();
      Okey.volume = 0.9;
      AutoFocus.readOnly = false;

    } else if (PickingRFID == 99) {

      $('#InputRFID').val('');
      $('#PickingRFID').html("<div class='alert alert-danger text-center' role='alert'>You have successfully registered.</div>");
      again.play();
      again.volume = 0.9;
      AutoFocus.readOnly = false;

    } else if (PickingRFID == 98) {

      $('#InputRFID').val('');
      $('#PickingRFID').html("<div class='alert alert-danger text-center' role='alert'>Error Save is not successful.</div>");
      again.play();
      again.volume = 0.9;
      AutoFocus.readOnly = false;

    } else if (PickingRFID == 97) {

      $('#InputRFID').val('');
      $('#PickingRFID').html("<div class='alert alert-danger text-center' role='alert'>Error Data does not match.</div>");
      again.play();
      again.volume = 0.9;
      AutoFocus.readOnly = false;

    } else {

      $('#InputRFID').val('');
      $('#PickingRFID').html("<div class='alert alert-danger text-center' role='alert'>Error Incomplete information.</div>");
      again.play();
      again.volume = 0.9;
      AutoFocus.readOnly = false;

    }
  }
  //! Record register End
</script>