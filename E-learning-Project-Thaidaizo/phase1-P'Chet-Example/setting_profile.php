  <?php include "templates/header.php"; ?>
  <?php include "templates/navber.php"; ?>

  <?php include "alert/alert_admin.php"; ?>

  <div class="container-fluid">
    <div class="row mt-4">


      <div class="col-lg-12 col-md-6 mb-4">
        <div class="card shadow">
          <h5 class="card-header text-uppercase"><strong>Profile</strong></h5>
          <div class="card-body">

            <?php
            if (isset($_GET["Empedit"])) {

              $EmployeeID = $_GET["Empedit"];
              //$FineDataUser = addslashes($str);
              $VowelsUser = array("'", ",");
              $FineDataUser = str_replace($VowelsUser, '', $EmployeeID);

              $stmt10 = "SELECT EmpUserID,EmpUserName,EmpUserSurname,EmpUserPosition,
    EmpUserSection,EmpUserDepartment,EmpUserEmail,Authentication 
    FROM ReqUser WHERE (EmpUserID = '$FineDataUser')";
              $query = sqlsrv_query($connRequest, $stmt10);
              $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
            }
            ?>
            <div class="row">
              <div class="col-lg-4 mb-4">
                <img class="img-fluid img-thumbnail" width="100%" height="200" src="../img/photo_emp/rectangle/<?php echo ($result["EmpUserID"] != NULL) ? $result["EmpUserID"] : '10000'; ?>.jpg" alt="Images">
              </div>
              <div class="col-lg-8 mb-4">
                <form action="" autocomplete="off" method="GET">
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="Empedit" id="Empedit" value="<?php echo $_GET["Empedit"]; ?>" placeholder="Employee ID" required="required">
                      <div class="input-group-append">
                        <button type="submit" class="btn btn-dark"><i class="fa fa-search"></i> Search</button>
                      </div>
                    </div>
                  </div>
                </form>
                <div class="row">
                  <div class="col-lg-12 mb-2"><b>ID:</b> <?php echo $result["EmpUserID"]; ?></div>
                  <div class="col-lg-6 mb-2"><b>Name:</b> <?php echo $result["EmpUserName"]; ?></div>
                  <div class="col-lg-6 mb-2"><b>Surname:</b> <?php echo $result["EmpUserSurname"]; ?></div>
                  <div class="col-lg-6 mb-2"><b>Position:</b> <?php echo $result["EmpUserPosition"]; ?></div>
                  <div class="col-lg-6 mb-2"><b>Section:</b> <?php echo $result["EmpUserSection"]; ?></div>
                  <div class="col-lg-6 mb-2"><b>Department:</b> <?php echo $result["EmpUserDepartment"]; ?></div>
                  <div class="col-lg-6 mb-2"><b>Email:</b> <?php echo $result["EmpUserEmail"]; ?></div>
                  <div class="col-lg-6 mb-2"><b>Status:</b>
                    <span class="badge badge-pill badge-dark">
                      <?php
                      switch ($result["Authentication"]) {
                        case 1:
                          echo "Requestor";
                          break;
                        case 2:
                          echo "Inspector";
                          break;
                        case 3:
                          echo "Approvers";
                          break;
                        case 6:
                          echo "Verify";
                          break;
                        case 9:
                          echo "IT";
                          break;
                        default:
                          echo 'None';
                      }
                      ?>
                    </span>
                  </div>
                </div>
              </div>
            </div>

            <?php
            $strSQL22 = "SELECT EmpUserID,EmpUserName,EmpUserSurname,LvCheck,LvApprove,EduVerify,EduApprove FROM ReqUser WHERE EmpUserID = '" . $result["EmpUserID"] . "' ";
            $objQuery22 = sqlsrv_query($connRequest, $strSQL22);
            $objResult22 = sqlsrv_fetch_array($objQuery22, SQLSRV_FETCH_ASSOC);

            $strSQL23 = "SELECT EmpUserID,EmpUserName,EmpUserSurname FROM ReqUser WHERE EmpUserID = '" . $objResult22["LvApprove"] . "' ";
            $objQuery23 = sqlsrv_query($connRequest, $strSQL23);
            $objResult23 = sqlsrv_fetch_array($objQuery23, SQLSRV_FETCH_ASSOC);

            // $strSQL24 = "SELECT EmpUserID,EmpUserName,EmpUserSurname FROM ReqUser WHERE EmpUserID = '" . $objResult22["EduVerify"] . "' ";
            // $objQuery24 = sqlsrv_query($connRequest, $strSQL24);
            // $objResult24 = sqlsrv_fetch_array($objQuery24, SQLSRV_FETCH_ASSOC);

            // $strSQL25 = "SELECT EmpUserID,EmpUserName,EmpUserSurname FROM ReqUser WHERE EmpUserID = '" . $objResult22["EduApprove"] . "' ";
            // $objQuery25 = sqlsrv_query($connRequest, $strSQL25);
            // $objResult25 = sqlsrv_fetch_array($objQuery25, SQLSRV_FETCH_ASSOC);
            ?>


<div class="card">
  <div class="card-body">
                <div class="d-flex">
                  <div class="mr-auto">
                    <div class="d-flex align-items-center">
                      <img class="rounded-circle border border-secondary mr-2" src="../img/photo_emp/square/<?php echo ($objResult23["EmpUserID"] != NULL) ? $objResult23["EmpUserID"] : '10000'; ?>.jpg" alt="Images" width="48" height="48">
                      <div class="lh-100">
                        <div><?php echo ($objResult23["EmpUserID"] != NULL) ? $objResult23["EmpUserID"] : 'none'; ?>&nbsp;: <span class="badge badge-pill badge-dark" style="width: 60px;">Check</span></div>
                        <div class="font-weight-bold"><?php echo $objResult23["EmpUserName"] . "\n" . $objResult23["EmpUserSurname"]; ?></div>
                      </div>
                    </div>
                  </div>
                  <div>
                    <button type="button" class="btn btn-dark Amodal" data-id="<?php echo $objResult22["LvApprove"]; ?>"><i class="fa fa-edit"></i>&nbsp; Edit</button>
                  </div>
                </div>
  </div>
</div>

            <!-- <nav>
              <div class="nav nav-tabs mt-3" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Flow</a>
                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Authority</a>
                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Change</a>
              </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
              <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"> -->
            <!-- <ul class="list-group list-group-flush"> -->

              <!-- <li class="list-group-item">
                <div class="d-flex align-items-center">
                  <img class="rounded-circle border border-secondary mr-2" src="../img/photo_emp/square/<?php //echo ($result["EmpUserID"] != NULL) ? $result["EmpUserID"] : '10000'; ?>.jpg" alt="Images" width="48" height="48">
                  <div class="lh-100">
                    <div><?php //echo ($result["EmpUserID"] != NULL) ? $result["EmpUserID"] : 'none'; ?>&nbsp;: <span class="badge badge-pill badge-dark" style="width: 60px;">Request</span></div>
                    <div class="font-weight-bold"><?php //echo $objResult22["EmpUserName"] . "\n" . $objResult22["EmpUserSurname"]; ?></div>
                  </div>
                </div>
              </li> -->
              <!-- <li class="list-group-item">

              </li> -->
              <!-- <li class="list-group-item">
                    <div class="d-flex align-items-center">
                      <img class="rounded-circle border border-secondary mr-2" src="../img/photo_emp/square/<?php //echo ($objResult24["EmpUserID"] != NULL) ? $objResult24["EmpUserID"] : '10000'; 
                                                                                                            ?>.jpg" alt="Images" width="48" height="48">
                      <div class="lh-100">
                        <div><?php //echo ($objResult24["EmpUserID"] != NULL) ? $objResult24["EmpUserID"] : 'none'; 
                              ?>&nbsp;: <span class="badge badge-pill badge-dark" style="width: 60px;">Verify</span></div>
                        <div class="font-weight-bold"><?php //echo $objResult24["EmpUserName"] . "\n" . $objResult24["EmpUserSurname"]; 
                                                      ?></div>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="d-flex align-items-center">
                      <img class="rounded-circle border border-secondary mr-2" src="../img/photo_emp/square/<?php //echo ($objResult25["EmpUserID"] != NULL) ? $objResult25["EmpUserID"] : '10000'; 
                                                                                                            ?>.jpg" alt="Images" width="48" height="48">
                      <div class="lh-100">
                        <div><?php //echo ($objResult25["EmpUserID"] != NULL) ? $objResult25["EmpUserID"] : 'none'; 
                              ?>&nbsp;: <span class="badge badge-pill badge-dark" style="width: 60px;">Approve</span></div>
                        <div class="font-weight-bold"><?php //echo $objResult25["EmpUserName"] . "\n" . $objResult25["EmpUserSurname"]; 
                                                      ?></div>
                      </div>
                    </div>
                  </li> -->

            <!-- </ul> -->

            <!-- <div class="text-center">
                  
                </div> -->
            <!-- </div> -->

            <!-- <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
					
  <?php
  // if(trim($result["EmpUserID"]) != NULL) {

  // $stmt11 = "SELECT COUNT(EmpUserID) AS CountID FROM ReqUser WHERE (LvApprove = '".$result["EmpUserID"]."')";
  // $query11 = sqlsrv_query($connRequest, $stmt11);
  // $result11 = sqlsrv_fetch_array($query11, SQLSRV_FETCH_ASSOC);

  // $stmt10 = "SELECT COUNT(EmpUserID) AS CountID FROM ReqUser WHERE (EduVerify = '".$result["EmpUserID"]."')";
  // $query10 = sqlsrv_query($connRequest, $stmt10);
  // $result10 = sqlsrv_fetch_array($query10, SQLSRV_FETCH_ASSOC);

  // $stmt09 = "SELECT COUNT(EmpUserID) AS CountID FROM ReqUser WHERE (EduApprove = '".$result["EmpUserID"]."')";
  // $query09 = sqlsrv_query($connRequest, $stmt09);
  // $result09 = sqlsrv_fetch_array($query09, SQLSRV_FETCH_ASSOC);

  // }
  ?>
  
Staet ตาราง ผู้ใต้บังคับบัญชา
<div class="row my-3">
 <div class="col-lg-4 mb-4">
 
   <div class="row justify-content-between">
    <div class="col-6">
      <span class="h5 font-weight-bold text-uppercase">Check</span>
    </div>
    <div class="col-6 text-right">
      <span class="h5 font-weight-bold text-greenblue"><?php //echo $result11["CountID"];
                                                        ?></span>
    </div>
  </div>
  
  <div class="table-responsive">
   <div class="table-wrapper-scroll-y my-custom-scrollbar">
	<table class="table table-hover text-truncate" style="width:100%">
	  <thead>
		<tr>
		  <th scope="col">ID</th>
		  <th scope="col">Name</th>
		  <th scope="col">Position</th>
		  <th scope="col">Section</th>
		  <th scope="col">Ac.</th>
		</tr>
	  </thead>
	  <tbody>
	  <?php
    // if(trim($result["EmpUserID"]) != NULL) {
    // $stmt02 = "SELECT EmpUserID,EmpUserName,EmpUserSurname,EmpUserPosition,EmpUserSection,EmpUserDepartment FROM ReqUser WHERE (LvApprove = '".$result["EmpUserID"]."') ORDER BY EmpUserID ASC";
    // $query02 = sqlsrv_query($connRequest, $stmt02);
    // while($result02 = sqlsrv_fetch_array($query02, SQLSRV_FETCH_ASSOC)){
    ?>
		<tr>
		  <th scope="row"><?php //echo $result02["EmpUserID"];
                      ?></th>
		  <td><?php //echo $result02["EmpUserName"]."\n".$result02["EmpUserSurname"];
          ?></td>
		  <td><?php //echo $result02["EmpUserPosition"];
          ?></td>
		  <td><?php //echo $result02["EmpUserSection"];
          ?></td>
		  <td><a href="save/save_remove_user.php?txtEmpUserID=<?php //echo $result02["EmpUserID"];
                                                          ?>&txtFlow=Check&txtAuthor=<?php //echo $result["EmpUserID"];
                                                                                      ?>" onclick="return confirm('Are you sure you want to Remove?');" class="btn btn-dark btn-sm"><i class="fa fa-times-circle"></i></a></td>
		</tr>
	  <?php //}} 
    ?>
	  </tbody>
	</table>
   </div>
  </div>
 </div>

 <div class="col-lg-4 mb-4">
 
 <div class="row justify-content-between">
  <div class="col-6">
    <span class="h5 font-weight-bold text-uppercase">Verify</span>
  </div>
  <div class="col-6 text-right">
    <span class="h5 font-weight-bold text-greenblue"><?php //echo $result10["CountID"];
                                                      ?></span>
  </div>
</div>

<div class="table-responsive">
 <div class="table-wrapper-scroll-y my-custom-scrollbar">
<table class="table table-hover text-truncate" style="width:100%">
  <thead>
  <tr>
    <th scope="col">ID</th>
    <th scope="col">Name</th>
    <th scope="col">Position</th>
    <th scope="col">Section</th>
    <th scope="col">Ac.</th>
  </tr>
  </thead>
  <tbody>
  <?php
  // if(trim($result["EmpUserID"]) != NULL) {
  // $stmt02 = "SELECT EmpUserID,EmpUserName,EmpUserSurname,EmpUserPosition,EmpUserSection,EmpUserDepartment FROM ReqUser WHERE (EduVerify = '".$result["EmpUserID"]."') ORDER BY EmpUserID ASC";
  // $query02 = sqlsrv_query($connRequest, $stmt02);
  // while($result02 = sqlsrv_fetch_array($query02, SQLSRV_FETCH_ASSOC)){
  ?>
  <tr>
    <th scope="row"><?php //echo $result02["EmpUserID"];
                    ?></th>
    <td><?php //echo $result02["EmpUserName"]."\n".$result02["EmpUserSurname"];
        ?></td>
    <td><?php //echo $result02["EmpUserPosition"];
        ?></td>
    <td><?php //echo $result02["EmpUserSection"];
        ?></td>
    <td><a href="save/save_remove_user.php?txtEmpUserID=<?php //echo $result02["EmpUserID"];
                                                        ?>&txtFlow=Check&txtAuthor=<?php //echo $result["EmpUserID"];
                                                                                    ?>" onclick="return confirm('Are you sure you want to Remove?');" class="btn btn-dark btn-sm"><i class="fa fa-times-circle"></i></a></td>
  </tr>
  <?php //}} 
  ?>
  </tbody>
</table>
 </div>
</div>

</div>
 
 <div class="col-lg-4 mb-4">
   <div class="row justify-content-between">
    <div class="col-6">
      <span class="h5 font-weight-bold text-uppercase">Approvers</span>
    </div>
    <div class="col-6 text-right">
      <span class="h5 font-weight-bold text-greenblue"><?php //echo $result09["CountID"];
                                                        ?></span>
    </div>
  </div>
  <div class="table-responsive">
   <div class="table-wrapper-scroll-y my-custom-scrollbar">
<table class="table table-hover" style="width:100%">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Name</th>
      <th scope="col">Position</th>
      <th scope="col">Section</th>
      <th scope="col">Ac.</th>
    </tr>
  </thead>
  <tbody>
  <?php
  // if(trim($result["EmpUserID"]) != NULL) {
  // $stmt03 = "SELECT EmpUserID,EmpUserName,EmpUserSurname,EmpUserPosition,EmpUserSection,EmpUserDepartment FROM ReqUser WHERE (EduApprove = '".$result["EmpUserID"]."') ORDER BY EmpUserID ASC";
  // $query03 = sqlsrv_query($connRequest, $stmt03);
  // while($result03 = sqlsrv_fetch_array($query03, SQLSRV_FETCH_ASSOC)){

  ?>
    <tr>
      <th scope="row"><?php //echo $result03["EmpUserID"];
                      ?></th>
      <td class="text-truncate"><?php //echo $result03["EmpUserName"]."\n".$result03["EmpUserSurname"];
                                ?></td>
      <td class="text-truncate"><?php //echo $result03["EmpUserPosition"];
                                ?></td>
      <td class="text-truncate"><?php //echo $result03["EmpUserSection"];
                                ?></td>
	  <td><a href="save/save_remove_user.php?txtEmpUserID=<?php //echo $result03["EmpUserID"];
                                                        ?>&txtFlow=Approve&txtAuthor=<?php //echo $result["EmpUserID"];
                                                                                      ?>" onclick="return confirm('Are you sure you want to Remove?');" class="btn btn-dark btn-sm"><i class="fa fa-times-circle"></i></td>
    </tr>
  <?php //}} 
  ?>
  </tbody>
</table>
   </div>
  </div>
 </div>
 
</div>
End ตาราง ผู้ใต้บังคับบัญชา
</div> -->


            <!-- <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">

  <form class="mt-3" id="frmChange" name="frmChange" action="save/save_change_authen.php" autocomplete="off" method="POST" target="iframe_transfer">
	<input type="hidden" value="<?php //echo $result["EmpUserID"];
                              ?>" id="txtEmpCurrent" name="txtEmpCurrent" readonly>

	  <div class="form-row">
		<div class="form-group col-md-4">
      <label for="InputEmployeeID">Employee ID:</label>
		  <input type="text" class="form-control" name="EmpTransfer" id="EmpTransfer" value="" required placeholder="Enter employee id">
		</div>
		<div class="form-group col-md-4">
    <label for="InputEmployeeID">Allow access:</label>
			<select name="txtAccess" class="custom-select" required="required">
			  <option value="">Choos...</option>
			  <option value="1">Request</option>
			  <option value="2">Check</option>
			  <option value="3">Verify</option>
			  <option value="4">Approver</option>
			</select>
		</div>
		<div class="form-group col-md-4">
    <label for="InputEmployeeID">Save change:</label>
		  <button type="submit" name="change" class="btn btn-dark btn-block" onclick="return BTSubmit();"><i class="fa fa-retweet"></i></button>
		</div>
    </div>
    
    <div class="ResultUpdateProfile"></div>
	
	<div id="emp_order">
	  <div class="row">
		<div class="col-lg-4">
		  <img class="img-fluid rounded mx-auto" style="width: 100%; height: 200px; background-color: #eceff1; border: solid 3px #eceff1;" src="assets/img/icon/10000.jpg" alt="">	
		</div>
        <div class="col-lg-8">
          <div class="row">
              <div class="col-lg-12 my-2"><b>ID:</b> </div>
              <div class="col-lg-6 my-2"><b>Name:</b> </div>
              <div class="col-lg-6 my-2"><b>Surname:</b> </div>
              <div class="col-lg-6 my-2"><b>Position:</b> </div>
              <div class="col-lg-6 my-2"><b>Section:</b> </div>
              <div class="col-lg-6 my-2"><b>Department:</b> </div>
              <div class="col-lg-6 my-2"><b>Email:</b> </div>
              <div class="col-lg-6 my-2"><b>Status:</b> </div>
          </div>
        </div>
	  </div>
	</div>
  </form>

</div> -->
            <!-- </div> -->



          </div>
        </div>
      </div>

    </div><!-- .row -->
  </div><!-- .container-fluid -->


  <?php include "templates/footer.php"; ?>


  <!-- Modal -->
  <form id="frmAdd" name="frmAdd" action="save/save_edit_authen.php" autocomplete="off" method="POST" target="iframe_authen">
    <div class="modal fade" id="EditRalated" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Related persons</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" value="<?php echo $result["EmpUserID"]; ?>" id="inputEmpID" name="inputEmpID">
            <div class="form-group row">
              <label for="txtCheck" class="col-sm-4 col-form-label">Check:</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="inputCheck" name="inputCheck" value="" placeholder="">
              </div>
            </div>
            <!-- <div class="form-group row">
              <label for="txtApprove" class="col-sm-4 col-form-label">Verify:</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="inputVerify" name="inputVerify" value="" placeholder="">
              </div>
            </div>
            <div class="form-group row">
              <label for="txtVerify" class="col-sm-4 col-form-label">Approve:</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="inputApprove" name="inputApprove" value="" placeholder="">
              </div>
            </div> -->
            <div class="ResultUpdateProfile"></div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success" name="save" onclick="return BTSubmit();"><i class="fa fa-check-circle"></i>&nbsp; Save</button>
            <!--<button type="reset" class="btn btn-dark" name="cancel"><i class="fa fa-refresh"></i>&nbsp; Reset</button>-->
          </div>
        </div>
      </div>
    </div>
  </form>

  <iframe id="iframe_transfer" name="iframe_transfer" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
  <iframe id="iframe_authen" name="iframe_authen" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>


  <script type="text/javascript">
    $(".Amodal").click(function() {
      var ids = $(this).attr('data-id');
      var Apps = $(this).attr('data-App');
      var Verify = $(this).attr('data-Verify');
      $("#inputCheck").val(ids);
      // $("#inputVerify").val(Apps);
      // $("#inputApprove").val(Verify);
      $('#EditRalated').modal('show');
    });
  </script>

  <script type="text/javascript">
    // $(document).ready(function(){
    //   //$('#EmpTransfer').keyup(function(){
    //   $('#EmpTransfer').on("keyup change", function() {
    //   var EmpTransfer = $(this).val();
    //   if (EmpTransfer != ''){
    //     $.ajax({
    //     url:"return/return_transfer.php",
    //     method:"POST",
    //     data:{ EmpTransfer:EmpTransfer },
    //     //dataType:"text",
    //     success:function(data){/*$('#txtEmpID').val(data);*/$("#emp_order").html($.trim(data));}
    //     });}
    //   else{
    //     $("#EmpTransfer").val(''),
    //     $("#emp_order").empty();
    //   }
    //   });
    // });
  </script>

  <script type="text/javascript">
    function ResultUpdateRelated(UpdateRelated) {
      if (UpdateRelated == 1) {
        $(".ResultUpdateProfile").html("<div class='alert alert-success text-center' role='alert'>Successfully</div>"),
          setInterval('window.location.href = "setting_profile.php?Empedit=<?php echo $EmployeeID; ?>"', 1000);
        //$('#ModalSuccess').modal('show');
      } else {
        $('.ResultUpdateProfile').html("<div class='alert alert-danger text-center' role='alert'>Unsuccessful error!</div>");
      }
    }

    //$('#ModalSuccess').on('hidden.bs.modal', function () {
    //window.location.href = 'index.php';
    //window.location.reload();
    //$('#formAssessment')[0].reset();
    //});
  </script>

  <script type="text/javascript">
    function BTSubmit() {
      if (confirm('Are you sure you want to submit the form ?') == true) {
        return true;
      } else {
        return false;
      }
    }
  </script>




  <script type="text/javascript">
    //window.onload=function(){
    //if (document.getElementById("txtEmp").value == "") {
    //alert('Please select employee!'),
    //window.location.href = 'req-otshift.php';
    //window.history.go(-3);
    //}
    //};
  </script>