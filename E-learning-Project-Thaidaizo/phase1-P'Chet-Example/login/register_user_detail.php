<?php include "templates/header.php"; ?>


<style>
  .boxhide {
    display: none;
  }
</style>

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
    WHERE (dbo.ReqInfo.ReqNo = '$ItemReqNo') 
    AND (dbo.ReqInfo.ReqType = 4) 
    AND (EducationSystem.dbo.TrainRecHdr.TrainHdrStatus = 1) ";

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
?>


<div class="container">
  <div class="row">

    <div class="col-lg-12 col-md-6 mb-4">
      <div class="card shadow my-4">
        <div class="card-header text-uppercase">
          <i class="fas fa-chalkboard-teacher"></i> Register
        </div>
        <div class="card-body">

          <!-- Portfolio Item Heading -->
          <h2 class="mb-4"><?php print $ListResult["ReqRemark"]; ?></h2>

          <!-- Portfolio Item Row -->
          <div class="row">
            <div class="col-md-8 mb-2">
              <?php
              if (substr($ListResult["PicturePath"], 18) == NULL) {
                echo '<img class="img-fluid img-thumbnail" src="../assets/img/icon/mortarboard.png" alt="image">';
              } else {
                echo '              
              <div class="embed-responsive embed-responsive-4by3">
                <iframe class="embed-responsive-item" src="../assets/img/request/' . $ListResult["PicturePath"] . '"></iframe>
              </div>';
              }
              ?>

            </div>

            <div class="col-md-4 mb-2">
              <h3 class="mb-2 text-greenblue">Training Description</h3>
              <ul class="mb-2">
                <li>Trainer: <strong><?php print $ListResult["TrainRecTrainer"]; ?></strong></li>
                <li>Type:
                  <strong>
                    <?php
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
                    print $TrainRecType;
                    ?>
                  </strong>
                </li>
                <li>Evaluation:
                  <strong>
                    <?php
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
                    print $TrainRecEvl;
                    ?>
                  </strong>
                </li>
                <div class="my-2">
                  <li>Date: <strong><?php echo date_format($ListResult["ReqDate"], 'd M. Y') . " - " . date_format($ListResult["TrnTime"], 'd M. Y'); ?></strong></li>
                  <li>Time: <strong><?php echo date_format($ListResult["ReqDate"], 'H:i') . " - " . date_format($ListResult["TrnTime"], 'H:i'); ?></strong></li>
                </div>
                <div class="my-2">
                  <li>Object: <strong><?php $EleData = explode('|', $ListResult["UserDefine1"]);
                                      print $EleData[1]; ?></strong></li>
                  <li>Organizer: <strong><?php print $EleData[2]; ?></strong></li>
                </div>
                <div class="my-2">
                  <li>Duration: <strong><?php print round($ListResult["ReqDay"], 2) . "Day, " . round($ListResult["ReqHour"], 2) . "Hrs" ?></strong></li>
                  <li>Cost: <strong><?php print number_format($ListResult["ReqSumTime"], 2) ?> THB</strong></li>
                </div>
                <li>Location: <strong><?php print $ListResult["TrainRecPlace"]; ?></strong></li>
                <li>Trainees Total: <strong><?php print $ListIRow; ?></strong>
                  <button type="button" class="btn btn-sm btn-dark" id="BttLookModal" title="Trainees list" data-id="<?php echo $ListResult["ReqNo"]; ?>"><i class="fas fa-external-link-alt"></i></button>
                </li>

              </ul>

            </div>
          </div>
          <!-- /.row -->



          <div class="form-row">
            <div class="col-lg-12">

              <?php
              //echo "<script>window.top.window.LoadingResult('1');</script>";
              //! Check DateTIme \\
              $PeriodQuery = "SELECT convert(varchar(10), GETDATE(), 111) AS DateCurrent, 
                convert(varchar(10), GETDATE(), 108) AS TimeCurrent ";
              $PeriodObj = sqlsrv_query($connRequest, $PeriodQuery);
              $PeriodResult = sqlsrv_fetch_array($PeriodObj, SQLSRV_FETCH_ASSOC);

              $DateCurrent = $PeriodResult["DateCurrent"];
              $TimeCurrent = $PeriodResult["TimeCurrent"];
              $DateStart = str_replace('/', '-', $DateCurrent);
              $TimeStart = str_replace(':', '', $TimeCurrent);
              //! Check DateTIme \\

              $AllOpenCountSQL = "SELECT COUNT(DISTINCT TrainRecNo) AS NumRegister,CreateDate,PicturePath FROM TrainRecDtl 
                WHERE (TrainRecNo = '$ItemReqNo') 
                AND (EmployeeID = '$SesUserID') 
                AND (TrainRecDate = '$DateStart') 
                AND (TrainDtlStatus >= 1) 
                GROUP BY CreateDate,PicturePath";
              $AllOpenCountQuery = sqlsrv_query($connEducation, $AllOpenCountSQL);
              $AllOpenCountResult = sqlsrv_fetch_array($AllOpenCountQuery, SQLSRV_FETCH_ASSOC);
              $NumAllOpen = $AllOpenCountResult["NumRegister"];

              if ($NumAllOpen > 0) {
                echo '
                  <div class="alert alert-success text-center" role="alert">Joined on: <strong>' . date_format($AllOpenCountResult['CreateDate'], 'd/m/Y H:i:s') . '</strong></div>
                  ';

                $AttFileCountSQL = "SELECT COUNT(DISTINCT TrainRecNo) AS NumAttFile FROM TrainRecDtl 
                  WHERE (TrainRecNo = '$ItemReqNo') 
                  AND (EmployeeID = '$SesUserID') 
                  --AND (TrainRecDate = '$DateStart') 
                  AND (PicturePath <> '' OR PicturePath IS NOT NULL) 
                  AND (TrainDtlStatus >= 1) ";
                $AttFileCountQuery = sqlsrv_query($connEducation, $AttFileCountSQL);
                $AttFileCountResult = sqlsrv_fetch_array($AttFileCountQuery, SQLSRV_FETCH_ASSOC);
                $NumAttFile = $AttFileCountResult["NumAttFile"];
                if ($NumAttFile > 0) {
              ?>
          <div class="form-group">
              <button type="button" class="btn btn-dark btn-block btn-lg" data-toggle="modal" data-target="#AttachmentModal"><i class="fas fa-paperclip"></i> View files</button>
          </div>
                <?php
                } else {
                ?>
                  <form id="formAttach" name="formAttach" action="save/save_attach_user.php" enctype="multipart/form-data" autocomplete="off" method="POST" target="iframe_upload_file">
                    <input type="hidden" id="inputItemNo" name="inputItemNo" value="<?php print $ListResult["ReqNo"]; ?>" readonly required>
                    <div class="AddResultAttach">
                      <fieldset class="border p-2 my-3 rounded">
                        <legend class="w-auto"><small>Attach File :</small></legend>
                        <div class="form-group">
                          <!-- <div class="mr-2">Attach File :</div> -->
                          <label for="inpuAttach" class="mr-3">
                            <input type="radio" class="pointer" id="Attach0" name="inputAttach" value="0" checked autocomplete="off"> None
                          </label>
                          <label for="inpuAttach" class="mr-3">
                            <input type="radio" class="pointer" id="Attach1" name="inputAttach" value="1" autocomplete="off"> .JPG
                          </label>
                          <label for="inpuAttach" class="mr-3">
                            <input type="radio" class="pointer" id="Attach2" name="inputAttach" value="2" autocomplete="off"> .PDF
                          </label>
                          <div class="Attach1 boxhide">
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="inputImgFile" name="inputImgFile" maxlength="50" accept=".jpg, .JPG, .jpeg, JPEG, png, PNG, gif, GIF">
                              <label class="custom-file-label" for="inputImgFile">Choose .JPG</label>
                            </div>
                          </div>
                          <div class="Attach2 boxhide">
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="inputPdfFile" name="inputPdfFile" maxlength="50" accept="application/pdf">
                              <label class="custom-file-label" for="inputPdfFile">Choose .PDF</label>
                            </div>
                          </div>

                          <div class="Attach1 Attach2 boxhide">
                            <div class="text-danger">
                              <small>* The file size limit is 2MB or less.</small>
                              <div><small>* The file name should not exceed 50 characters.</small></div>
                            </div>
                            <div class="form-group">
                              <button type="submit" value="1" name="BttSubmitAttFile" class="btn btn-success btn-block" onclick="return BttSubmit();"><i class="fas fa-cloud-upload-alt"></i> Upload file</button>
                            </div>
                          </div>
                        </div>
                      </fieldset>
                    </div>
                  </form>
                <?php
                }
              } else {
                ?>
                <form id="formRegister" name="formRegister" action="save/save_register_user.php" autocomplete="off" method="POST" target="iframe_register_form">
                  <input type="hidden" id="inputItemKey" name="inputItemKey" value="<?php print $ListResult["ReqNo"]; ?>" readonly required>
                  <div class="AddResultRegister">
                    <button type="submit" value="1" name="BttSubmitRegister" class="btn btn-success btn-block" onclick="return BttRegister();"><i class="fas fa-save"></i> Register now!</button>
                  </div>
                </form>
              <?php
              }
              ?>

            </div>
          </div>
          <?php
          $AllOpenSQL = "SELECT COUNT(DISTINCT TrainRecNo) AS NumRegister,CreateDate,PostReport1,PostReport2,PostReport3 FROM TrainRecDtl 
              WHERE (TrainRecNo = '$ItemReqNo') 
              AND (EmployeeID = '$SesUserID') 
              AND (TrainRecDate = '$DateStart') 
              AND (TrainDtlStatus >= 1) 
              GROUP BY CreateDate,PostReport1,PostReport2,PostReport3";
          $AllOpenQuery = sqlsrv_query($connEducation, $AllOpenSQL);
          $AllOpenResult = sqlsrv_fetch_array($AllOpenQuery, SQLSRV_FETCH_ASSOC);
          $AllOpen = $AllOpenResult["NumRegister"];

          if ($AllOpen > 0) {
            $AttFileSQL = "SELECT COUNT(DISTINCT TrainRecNo) AS NumAttFile FROM TrainRecDtl 
              WHERE (TrainRecNo = '$ItemReqNo') 
              AND (EmployeeID = '$SesUserID') 
              --AND (TrainRecDate = '$DateStart') 
              AND (PostReport1 IS NOT NULL) 
              AND (TrainDtlStatus >= 1) ";
            $AttFileQuery = sqlsrv_query($connEducation, $AttFileSQL);
            $AttFileResult = sqlsrv_fetch_array($AttFileQuery, SQLSRV_FETCH_ASSOC);
            $AttFile = $AttFileResult["NumAttFile"];
            if ($AttFile > 0) {
          ?>
          <div class="form-group">
              <button type="button" class="btn btn-dark btn-block btn-lg" data-toggle="modal" data-target="#AttachmentTxTModal"><i class="fas fa-file-alt"></i> View post</button>
          </div>
            <?php
            } else {
            ?>
              <form action="save/save_attachtext_user.php" autocomplete="off" method="POST" target="iframe_upload_text">
                <input type="hidden" id="inputItemID" name="inputItemID" value="<?php print $ListResult["ReqNo"]; ?>" readonly required>
                <div class="AddResultText">
                  <fieldset class="border p-2 my-3 rounded">
                    <legend class="w-auto"><small>Training report :</small></legend>
                    <div class="form-group">
                      <!-- <label for="inputPost">Training report :</label> cols="30" -->
                      <textarea id="inputPost1" name="inputPost1" class="form-control" rows="10" maxlength="1000" placeholder="Submit your text post here..." required></textarea>
                    </div>
                    <div class="form-group">
                      <textarea id="inputPost2" name="inputPost2" class="form-control" rows="10" maxlength="1000" placeholder="Submit your text post here..."></textarea>
                    </div>
                    <div class="form-group">
                      <textarea id="inputPost3" name="inputPost3" class="form-control" rows="10" maxlength="1000" placeholder="Submit your text post here..."></textarea>
                    </div>
                    <div class="form-group">
                      <button type="submit" value="1" name="BttSubmitText" class="btn btn-success btn-block" onclick="return BttSubmitTxT();"><i class="fas fa-save"></i> Submit post</button>
                    </div>
                  </fieldset>
                </div>
              </form>

          <?php
            }
          }
          ?>
        </div>
      </div>
    </div>

  </div><!-- .row -->
</div><!-- .container-fluid -->


<?php include "templates/footer.php"; ?>

<!-- <link rel="stylesheet" type="text/css" href="assets/css/all.min.css" />
<script type="text/javascript" src="assets/js/shieldui-all.min.js"></script> -->


<iframe id="iframe_register_form" name="iframe_register_form" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
<iframe id="iframe_upload_file" name="iframe_upload_file" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
<iframe id="iframe_upload_text" name="iframe_upload_text" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>


<!-- Modal AttachmentTxTModal -->
<div class="modal fade" id="AttachmentTxTModal" tabindex="-1" role="dialog" aria-labelledby="AttachmentTxTTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header text-greenblue">
        <h5 class="modal-title" id="AttachmentTxTTitle">Post</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <p><?php print((($AllOpenResult["PostReport1"]) != NULL) ? $AllOpenResult["PostReport1"] : 'Topic 1') ;?></p>
        <p><?php print((($AllOpenResult["PostReport2"]) != NULL) ? $AllOpenResult["PostReport2"] : 'Topic 2') ;?></p>
        <p><?php print((($AllOpenResult["PostReport3"]) != NULL) ? $AllOpenResult["PostReport3"] : 'Topic 3') ;?></p>

      </div>
    </div>
  </div>
</div>
<!-- Modal AttachmentTxTModal -->


<!-- Modal Attachment -->
<div class="modal fade" id="AttachmentModal" tabindex="-1" role="dialog" aria-labelledby="AttachmenTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header text-greenblue">
        <h5 class="modal-title" id="AttachmenTitle">Attachment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="embed-responsive embed-responsive-4by3 mb-3">
          <iframe class="embed-responsive-item" src="../assets/img/request/<?php print((substr($AllOpenCountResult["PicturePath"], 18) != NULL) ? $AllOpenCountResult["PicturePath"] : 'index.html') ?>"></iframe>
        </div>
        <a href="../assets/img/request/<?php print((substr($AllOpenCountResult["PicturePath"], 18) != NULL) ? $AllOpenCountResult["PicturePath"] : 'index.html') ?>" target="_blank"><i class="far fa-window-restore"></i> More..</a>

      </div>
    </div>
  </div>
</div>
<!-- Modal Attachment -->


<!-- Modal trainees -->
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
<!-- Modal trainees -->

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
  function BttRegister() {
    if (confirm('Are you sure you want to submit the form ?') == true) {
      return true;
    } else {
      return false;
    }
  }
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $('input[type="radio"]').click(function() {
      var inputValue = $(this).attr("id");
      var targetBox = $("." + inputValue);
      $(".boxhide").not(targetBox).hide();
      $(targetBox).show();
    });
  });

  // Add the following code if you want the name of the file appear on select
  $(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
  });
</script>

<script type="text/javascript">
  function BttSubmit() {
    var fileImg = document.formAttach.inputImgFile.value; //var patt = /(.gif|.jpg|.png)/;
    var pathImg = /(.jpg|.jpeg|.JPEG|.JPG|.png|.PNG|.gif|.GIF)/;
    var resultImg = pathImg.test(fileImg);
    if (document.formAttach.inputImgFile.value != "" && resultImg == false) {
      alert("file type is wrong (.jpg only)");
      return false;
    }
    var filePdf = document.formAttach.inputPdfFile.value; //var patt = /(.gif|.jpg|.png)/;
    var pathPdf = /(.pdf|.PDF)/;
    var resultPdf = pathPdf.test(filePdf);
    if (document.formAttach.inputPdfFile.value != "" && resultPdf == false) {
      alert("file type is wrong (.pdf only)");
      return false;
    }

    if ((document.formAttach.inputAttach.value == "1") && (document.formAttach.inputImgFile.value == "")) {
      alert("Please attach an image file.");
      document.getElementById("inputImgFile").required = true;
      return false;
    }
    if ((document.formAttach.inputAttach.value == "2") && (document.formAttach.inputPdfFile.value == "")) {
      alert("Please attach an PDF file.");
      document.getElementById("inputPdfFile").required = true;
      return false;
    }

    if ((document.formAttach.inputTrainees.value == "")) {
      alert("Please select trainees.");
      //document.getElementById("inputTrainees").required = true;
      return false;
    }
    if (confirm('Are you sure you want to submit the form ?') == true) {
      return true;
    } else {
      return false;
    }
  }

  function BttSubmitTxT() {
    if (confirm('Are you sure you want to submit the form ?') == true) {
      return true;
    } else {
      return false;
    }
  }

  function BttReset() {
    if (confirm('Are you sure you want to cancel ?') == true) {
      window.location.reload();
    } else {
      return false;
    }
  }
</script>


<script type="text/javascript">
  function TrainingResult(AddResult) {
    if (AddResult == 1) {
      $(".AddResultRegister").html("<div class='alert alert-success text-center' role='alert'>Registered <i class='far fa-laugh-wink'></i></div>");
      setInterval('window.location.href = "training_register_user.php"', 1000);
    } else {
      $('.AddResultRegister').html("<div class='alert alert-danger text-center' role='alert'>Unsuccessful <i class='far fa-tired'></i></div>");
      //setInterval('window.location.href = "training_register_user.php"', 500);
    }
  }

  function TrainingAttach(AddAttach) {
    if (AddAttach == 1) {
      $(".AddResultAttach").html("<div class='alert alert-success text-center' role='alert'>File attached. <i class='far fa-laugh-wink'></i></div>");
      setInterval('window.location.href = "training_register_user.php"', 1000);
    } else {
      //$('#AddResultAttach').html("<div class='alert alert-danger text-center' role='alert'>An error occurred attaching the file. <i class='far fa-tired'></i></div>");
      //setInterval('window.location.href = "training_register_user.php"', 500);
    }
  }

  function TrainingText(AddTxT) {
    if (AddTxT == 1) {
      $(".AddResultText").html("<div class='alert alert-success text-center' role='alert'>Successful post. <i class='far fa-laugh-wink'></i></div>");
      setInterval('window.location.href = "training_register_user.php"', 1000);
    } else {
      //$('#AddResultAttach').html("<div class='alert alert-danger text-center' role='alert'>An error occurred attaching the file. <i class='far fa-tired'></i></div>");
      //setInterval('window.location.href = "training_register_user.php"', 500);
    }
  }
</script>

<script type="text/javascript">
  // $(function(){
  //     $(window).bind("beforeunload",function(event){
  //         var msg="ยืนยันการปิดหน้านี้?";
  //         event.preventDefault();
  //         $(window).bind("unload",function(event){
  //             event.stopImmediatePropagation();
  //             // แทรก ajax code ลบ session หรืออื่น ๆ
  //             alert("Bye Bye");
  //         });
  //         return msg;
  //     });
  //     $("a").click(function(){ // กรณีคลิกลิ้งค์ ไม่ต้องแสดง การแจ้งเตือน
  //         $(window).unbind("beforeunload");
  //     });     
  // });
</script>
<script language="JavaScript" type="text/javascript">
  // window.onbeforeunload = confirmExit;
  // function confirmExit(){
  //   return "คุณต้องการปิดหน้าต่างนี้ ใช่ไหม";
  // }
</script>

<script type="text/javascript">
  // jQuery(function($) {
  //   $("#inputPost").shieldEditor({
  //     height: 260,
  //     commands: [
  //               "formatBlock", 
  //               // "removeFormat",
  //       {
  //         text: '<i class="fas fa-remove-format"></i>',
  //         tooltip: "Remove Format",
  //         exec: function(options, doneCallback) {
  //           this.execute("removeFormat");
  //           doneCallback();
  //         }
  //       },
  //       {
  //         text: '<i class="fas fa-strikethrough"></i>',
  //         tooltip: "Strikethrough",
  //         exec: function(options, doneCallback) {
  //           this.execute("strikeThrough");
  //           doneCallback();
  //         }
  //       },
  //               "fontName", "fontSize", "foreColor", 
  //               // "backColor",
  //               // "bold", "italic", "underline", 
  //               // "strikeThrough", "subscript", "superscript",
  //               // "justifyLeft", "justifyCenter", "justifyRight", "justifyFull",
  //               // "insertUnorderedList", "insertOrderedList", 
  //               // "indent", "outdent",
  //               // "createLink", "unlink", "insertImage",
  //               // "viewHtml",
  //       {
  //         text: '<i class="fas fa-list-ul"></i>',
  //         tooltip: "Insert Unordered List",
  //         exec: function(options, doneCallback) {
  //           this.execute("insertUnorderedList");
  //           doneCallback();
  //         }
  //       },
  //       {
  //         text: '<i class="fas fa-list-ol"></i>',
  //         tooltip: "Insert Ordered List",
  //         exec: function(options, doneCallback) {
  //           this.execute("insertOrderedList");
  //           doneCallback();
  //         }
  //       },
  //       {
  //         text: '<i class="fas fa-indent"></i>',
  //         tooltip: "Indent",
  //         exec: function(options, doneCallback) {
  //           this.execute("indent");
  //           doneCallback();
  //         }
  //       },
  //       {
  //         text: '<i class="fas fa-outdent"></i>',
  //         tooltip: "Outdent",
  //         exec: function(options, doneCallback) {
  //           this.execute("outdent");
  //           doneCallback();
  //         }
  //       },
  //       {
  //         text: '<i class="fas fa-bold"></i>',
  //         tooltip: "Bold",
  //         exec: function(options, doneCallback) {
  //           this.execute("bold");
  //           doneCallback();
  //         }
  //       },
  //       {
  //         text: '<i class="fas fa-italic"></i>',
  //         tooltip: "Italic",
  //         exec: function(options, doneCallback) {
  //           this.execute("italic");
  //           doneCallback();
  //         }
  //       },
  //       {
  //         text: '<i class="fas fa-underline"></i>',
  //         tooltip: "Italic",
  //         exec: function(options, doneCallback) {
  //           this.execute("underline");
  //           doneCallback();
  //         }
  //       },
  //       {
  //         text: '<i class="fas fa-align-left"></i>',
  //         tooltip: "Align left",
  //         exec: function(options, doneCallback) {
  //           this.execute("justifyLeft");
  //           doneCallback();
  //         }
  //       },
  //       {
  //         text: '<i class="fas fa-align-center"></i>',
  //         tooltip: "Align Center",
  //         exec: function(options, doneCallback) {
  //           this.execute("justifyCenter");
  //           doneCallback();
  //         }
  //       },
  //       {
  //         text: '<i class="fas fa-align-right"></i>',
  //         tooltip: "Align Right",
  //         exec: function(options, doneCallback) {
  //           this.execute("justifyRight");
  //           doneCallback();
  //         }
  //       },
  //       {
  //         text: '<i class="fas fa-align-justify"></i>',
  //         tooltip: "Align Full",
  //         exec: function(options, doneCallback) {
  //           this.execute("justifyFull");
  //           doneCallback();
  //         }
  //       },

  //       {
  //         text: '<i class="fas fa-undo-alt"></i>',
  //         tooltip: "Undo change",
  //         exec: function(options, doneCallback) {
  //           this.execute("undo");
  //           doneCallback();
  //         }
  //       },
  //       {
  //         text: '<i class="fas fa-redo-alt"></i>',
  //         tooltip: "Redo change",
  //         exec: function(options, doneCallback) {
  //           this.execute("redo");
  //           doneCallback();
  //         }
  //       },
  //       {
  //         text: '<i class="fas fa-arrows-alt-h"></i>',
  //         tooltip: "Insert a horizontal line",
  //         exec: function(options, doneCallback) {
  //           this.paste("<hr>");
  //           doneCallback();
  //         }
  //       }
  //     ]
  //   });
  // });
</script>