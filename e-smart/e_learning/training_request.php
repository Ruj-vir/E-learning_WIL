<?php include "templates/header.php"; ?>
<?php include "templates/navber.php"; ?>

<link href="assets/duallistbox/duallistbox.css" rel="stylesheet">
<script src="assets/duallistbox/duallistbox.js" type="text/javascript"></script>

<style>
    .boxhide {
        display: none;
    }
</style>

<div class="container-fluid">
    <div class="row">

        <div class="col-xl-9 col-md-6 mb-4">

            <form id="formRequest" name="formRequest" class="form" action="save/save_request_training.php" enctype="multipart/form-data" autocomplete="off" method="post" target="iframe_Req">
                <div class="card my-4">
                    <div class="card-header text-uppercase">
                        <i class="fas fa-file-signature"></i> Request
                    </div>
                    <div class="card-body">

                        <div class="row justify-content-center">
                            <div class="col-lg-8">

                                <div class="form-group">
                                    <label for="inputCourse">Training Course :</label>
                                    <input type="text" class="form-control" id="inputCourse" name="inputCourse" maxlength="200" placeholder="Enter Course name" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputObject">Object :</label>
                                    <textarea class="form-control" id="inputObject" name="inputObject" rows="3" maxlength="150" required placeholder="Enter Objective"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="inputOrganizer">Organizer :</label>
                                    <input type="text" class="form-control" id="inputOrganizer" name="inputOrganizer" maxlength="100" placeholder="Enter Organizer name" required>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="inputDateFrom">From date :</label>
                                        <input type="date" class="form-control" id="inputDateFrom" name="inputDateFrom" value="<?php echo date('Y-m-d', strtotime('+3 day')); ?>" required placeholder="">
                                    </div>
                                    <div class="form-group col">
                                        <label for="inputDateTo">To date :</label>
                                        <input type="date" class="form-control" id="inputDateTo" name="inputDateTo" value="<?php echo date('Y-m-d', strtotime('+3 day')); ?>" required placeholder="">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="inputTimeFrom">From time :</label>
                                        <input type="time" class="form-control" id="inputTimeFrom" name="inputTimeFrom" value="<?php echo date('H:i'); ?>" required placeholder="">
                                    </div>
                                    <div class="form-group col">
                                        <label for="inputTimeTo">To time :</label>
                                        <input type="time" class="form-control" id="inputTimeTo" name="inputTimeTo" value="" required placeholder="">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="inputDurationDay">Duration Day :</label>
                                        <input type="number" required class="form-control" id="inputDurationDay" name="inputDurationDay" min="0" step="0.5" placeholder="" require>
                                    </div>
                                    <div class="form-group col">
                                        <label for="inputDurationTime">Duration Hour :</label>
                                        <input type="number" class="form-control" required id="inputDurationTime" name="inputDurationTime" min="0" step="0.01" placeholder="" require>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputLocation">Location :</label>
                                    <input type="text" class="form-control" id="inputLocation" name="inputLocation" maxlength="100" placeholder="Enter Location" required>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label for="inputCost">Training Cost :</label>
                                        <input type="number" required class="form-control" id="inputCost" name="inputCost" min="0" placeholder="THB" require>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="inpuAttach" class="mr-2">Attach File :</label>
                                    <label for="inputAttachNone" class="mr-3">
                                        <input type="radio" class="pointer" id="Attach0" name="inputAttach" value="0" checked autocomplete="off"> None
                                    </label>
                                    <label for="inputAttachJPG" class="mr-3">
                                        <input type="radio" class="pointer" id="Attach1" name="inputAttach" value="1" autocomplete="off"> .JPG
                                    </label>
                                    <label for="inputAttachPDF" class="mr-3">
                                        <input type="radio" class="pointer" id="Attach2" name="inputAttach" value="2" autocomplete="off"> .PDF
                                    </label>
                                    <div class="Attach1 boxhide">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="inputImgFile" name="inputImgFile" maxlength="50" accept=".jpg, .JPG, .jpeg, .JPEG, .png, .PNG, .gif, .GIF">
                                            <label class="custom-file-label" for="inputImgFile">Choose .JPG</label>
                                        </div>
                                        <div class="text-danger">
                                            <small>* The file size limit is 2MB or less.</small>
                                            <div><small>* The file name should not exceed 50 characters.</small></div>
                                        </div>
                                    </div>
                                    <div class="Attach2 boxhide">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="inputPdfFile" name="inputPdfFile" maxlength="50" accept="application/pdf">
                                            <label class="custom-file-label" for="inputPdfFile">Choose .PDF</label>
                                        </div>
                                        <div class="text-danger">
                                            <small>* The file size limit is 2MB or less.</small>
                                            <div><small>* The file name should not exceed 50 characters.</small></div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>



                        <hr>
                        <select name="inputTrainees[]" id="inputTrainees" multiple required onchange="getValues()">
                            <?php
                            $TraineesSQL = "SELECT EmpUserID,EmpUserName,EmpUserSurname FROM ReqUser WHERE (Status <> 0) ORDER BY EmpUserID ASC";
                            $Traineesobj = sqlsrv_query($connRequest, $TraineesSQL);
                            while ($TraineesResult = sqlsrv_fetch_array($Traineesobj, SQLSRV_FETCH_ASSOC)) {
                            ?>
                                <option value="<?php print $TraineesResult["EmpUserID"]; ?>"><?php print $TraineesResult["EmpUserID"] . " - " . $TraineesResult["EmpUserName"] . " " . $TraineesResult["EmpUserSurname"]; ?></option>
                            <?php } ?>
                        </select>
                        <div class="border bg-secondary text-light mt-3 rounded p-3">
                            <div class="text-greenblue"><strong>Trainees : </strong></div>
                            <span style="font-size: 14px;" id="values"></span>
                        </div>

                    </div>
                    <div class="card-footer">
                        <div class="float-right">
                            <button type="submit" name="BttSubmitReq" class="btn btn-success" onclick="return BttSubmit();"><i class="fa fa-check-circle"></i> Save</button>
                            <button type="button" class="btn btn-danger" onclick="return BttReset();"><i class="fa fa-times-circle"></i> Reset</button>
                        </div>
                    </div>
                </div>

            </form>
            <iframe id="iframe_Req" name="iframe_Req" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>

        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card my-4">
                <div class="card-header text-uppercase"><i class="fas fa-users"></i> Related</div>
                <div class="card-body">
                    <?php include "form/include_authorized_req.php"; ?>
                </div>
            </div>
        </div>

    </div><!-- .row -->
</div><!-- .container-fluid -->

<?php include "templates/footer.php"; ?>


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
        window.location.href = 'training_request.php';
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
            //$('#LoadModal').modal('hide'),
            setInterval("$('#LoadModal').modal('hide')", 1500),
            setInterval("$('#ModalSuccess').modal('show')", 2000);
            //alert('Successfully.');
            //setInterval('window.location.href = "../training_request.php', 1500);
        } else {
            setInterval("$('#LoadModal').modal('hide')", 0);
            //window.location.href = "../training_request.php";
        }
    }
</script>
<!-- End Modal Load -->

<script type="text/javascript">
    duallistbox(document.getElementById('inputTrainees'));

    function getValues() {
        document.getElementById('values').innerText = [...document.getElementById('inputTrainees').selectedOptions].map(o => o.textContent).join(', \r')
    }
    getValues();
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
        var fileImg = document.formRequest.inputImgFile.value; //var patt = /(.gif|.jpg|.png)/;
        var pathImg = /(.jpg|.jpeg|.JPEG|.JPG|.png|.PNG|.gif|.GIF)/;
        var resultImg = pathImg.test(fileImg);
        if (document.formRequest.inputImgFile.value != "" && resultImg == false) {
            alert("file type is wrong (.jpg only)");
            return false;
        }
        var filePdf = document.formRequest.inputPdfFile.value; //var patt = /(.gif|.jpg|.png)/;
        var pathPdf = /(.pdf|.PDF)/;
        var resultPdf = pathPdf.test(filePdf);
        if (document.formRequest.inputPdfFile.value != "" && resultPdf == false) {
            alert("file type is wrong (.pdf only)");
            return false;
        }

        if ((document.formRequest.inputAttach.value == "1") && (document.formRequest.inputImgFile.value == "")) {
            alert("Please attach an image file.");
            document.getElementById("inputImgFile").required = true;
            return false;
        }
        if ((document.formRequest.inputAttach.value == "2") && (document.formRequest.inputPdfFile.value == "")) {
            alert("Please attach an PDF file.");
            document.getElementById("inputPdfFile").required = true;
            return false;
        }

        if ((document.formRequest.inputTrainees.value== "")) {
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

    function BttReset() {
        if (confirm('Are you sure you want to cancel ?') == true) {
            window.location.reload();
        } else {
            return false;
        }
    }
</script>

<script type="text/javascript">
  $(document).ready(function(){
    //$('#time1, #time2').keyup(function(){
    //$('#time1, #time2').change(function(){
    $('#inputTimeFrom, #inputTimeTo').on('keyup change', function (){
    var TimeFrom = $('#inputTimeFrom').val();
    var TimeTo = $('#inputTimeTo').val();
    if ((TimeFrom != '' && TimeTo != '') && (TimeFrom <= TimeTo)){
      $.ajax({
      url:"return/return_search_datetime.php",
      method:"POST",
      data:{TimeFrom:TimeFrom, TimeTo:TimeTo},
      dataType:"text",
      success:function(data){
        /*$('#txtEmpID').val(data);*/
        $("#inputDurationTime").val($.trim(data));}});
      }else{
        $("#inputDurationTime").val('');
      }
    });
  });
</script>