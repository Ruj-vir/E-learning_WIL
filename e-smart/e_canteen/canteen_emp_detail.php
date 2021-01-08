
<?php include "templates/headerAdmin.php";?>


  <?php
  
  $inputSearchEmp = $_GET["IdEmp"];
  
  if (isset($inputSearchEmp) && trim($inputSearchEmp) != NULL) {

    $FineEmpID = strip_tags(htmlspecialchars($inputSearchEmp));
    $FineEmpID = trim($FineEmpID);
    //$FineDataEmp = addslashes($str);
    $vowels = array("'");
    $FineEmpID = str_replace($vowels,'', $FineEmpID);

	  $CanRegisSql = "SELECT EmpUserID,EmpUserName,EmpUserSurname,EmpUserPosition,EmpUserSection,EmpUserDepartment
	  FROM ReqUser WHERE (EmpUserID = '$FineEmpID')";
    $CanRegisObj = sqlsrv_query($connRequest, $CanRegisSql);

    $params = array();
    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    $CanRegisObj = sqlsrv_query( $connRequest, $CanRegisSql , $params, $options );
    $num_rows = sqlsrv_num_rows($CanRegisObj);
    
    if ($num_rows > 0) {
    $CanRegisResult = sqlsrv_fetch_array($CanRegisObj, SQLSRV_FETCH_ASSOC);
	?>
	<!-- Page Content -->
	<div class="container">
	  <div class="card shadow-sm">
    <div class="card-header">
      <div class="d-flex">
        <div class="h3 mr-auto">
        <strong>Edit card</strong>
        </div>
      </div>
    </div>
		<div class="card-body">

    <div class="row">
      <div class="col-lg-3">
      <div class="d-flex align-items-center p-3 text-white-50 bg-green rounded box-shadow">
        <img class="mr-3" src="../img/photo_emp/square/<?php echo $CanRegisResult["EmpUserID"] ;?>.jpg" alt="" width="48" height="48">
        <div class="lh-100">
		      <small class="text-white"><?php echo $CanRegisResult["EmpUserID"];?></small>
          <h6 class="mb-0 text-white text-uppercase lh-100"><?php echo $CanRegisResult['EmpUserName']."\n".$CanRegisResult['EmpUserSurname'];?></h6>
        </div>
      </div>
      <div class="form-group mt-3">
        <ul style="/*margin: 0px 0px 0px -25px;*/">
          <li><small>Position:</small> <?php echo $CanRegisResult["EmpUserPosition"];?></li>
          <li><small>Section:</small> <?php echo $CanRegisResult["EmpUserSection"];?></li>
          <li><small>Dept:</small> <?php echo $CanRegisResult["EmpUserDepartment"];?></li>
        </ul>
      </div>

      <hr>

      </div>
      <div class="col-lg-9">


    <form action="save/update_canteen_register.php" autocomplete="off" method="POST" target="iframe_AddRFID">
    <div class="form-group row">
      <label for="inputAddRFID" class="col-sm-2 col-form-label">Add new RFID:</label>
      <div class="col-sm-10">
        <div class="input-group">
          <input type="text" class="form-control" id="InputRFID" name="InputRFID" placeholder="Enter RFID" required>
            <div class="input-group-append">
              <button type="submit" name="AddNewRFID" class="btn btn-green btn-block"><i class="fas fa-save"></i> Save</button>
            </div>
        </div>
      </div>
    </div>
      <input type="hidden" id="InputEmpID" name="InputEmpID" value="<?php echo $CanRegisResult["EmpUserID"];?>" readonly />
      <div id="Panel_EmpRFID"></div><div class="AddResult"></div>
  	</form>


  <div class="table-responsive-lg">
    <table class="table table-hover">
      <thead class="text-truncate">
        <tr>
          <th scope="col">No.</th>
          <th scope="col">RFID</th>
          <th scope="col">Status</th>
          <th scope="col" class="text-center">Actions</th>
        </tr>
      </thead>
      <tbody class="text-truncate">
<?php
	$RfidSQL = "SELECT EmpID,RFIDNo,Status FROM RFID_Master WHERE (EmpID = '$FineEmpID') ";
	$RfidQuery = sqlsrv_query($connCanteen, $RfidSQL);
	$NumNo = 1;
	while ($RfidResult = sqlsrv_fetch_array($RfidQuery, SQLSRV_FETCH_ASSOC)) {
?>
        <tr>
          <th scope="row"><?php echo $NumNo;?></th>
          <td><?php echo $RfidResult["RFIDNo"] ;?></td>
          <td>
			<div class="d-inline p-0">
			  <span class="dot Status0<?php echo $RfidResult["Status"];?>"></span>
				<small class="text-<?php echo ($RfidResult["Status"] == 1) ? 'green' : 'secondary';?>">
				  <?php echo ($RfidResult["Status"] == 1) ? 'Enabled' : 'Disabled';?>
				</small>
			</div>
		  </td>
          <td class="text-center">
		  	    <div class="btn-group" role="group" aria-label="Basic example">
              <button type="button" class="btn btn-sm btn-outline-dark BttEdit_RFID" data-id="<?php echo $RfidResult["RFIDNo"] ;?>"><i class="fas fa-id-card"></i></button>
              <button type="button" class="btn btn-sm btn-outline-dark BttEdit_State" data-id="<?php echo $RfidResult["RFIDNo"] ;?>"><i class="fas fa-lock"></i></button>
              <button type="button" class="btn btn-sm btn-outline-dark" onclick="if (confirm('Are you sure you want to delete.?')) window.location.href='save/update_canteen_register.php?InputEmpID=<?php echo $RfidResult["EmpID"];?>&InputRFID=<?php echo $RfidResult["RFIDNo"];?>&DeleteKey=3';"><i class="fas fa-trash"></i></button>
            </div>
		      </td>
        </tr>
<?php $NumNo++; } ?>
      </tbody>
    </table>
   </div>
  </div>

      </div>
    </div>
		</form>

	    </div>
	  </div>
	</div>

<?php
}else {

	echo "<script type=text/javascript>window.close();</script>";
	exit();
  	
  }
}else {

	echo "<script type=text/javascript>window.close();</script>";
	exit();
  	
  }
?>
  
<?php include "templates/footer.php";?>


<form action="save/update_canteen_register.php" autocomplete="off" method="POST" target="iframe_EditRFID">
<!-- Modal Edit RFID -->
<div class="modal fade" id="Modal_edit_RFID" tabindex="-1" role="dialog" aria-labelledby="ModalEditRFIDTitleTitle" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title text-green" id="ModalEditRFIDTitle"><strong>Edit RFID</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
  
      <input type="hidden" id="IdPanel_Emp" name="IdPanel_Emp" value="<?php echo $CanRegisResult["EmpUserID"];?>" readonly required />
      <input type="hidden" id="IdPanel_RFID" name="IdPanel_RFID" readonly required />
      <div id="Panel_RFID"></div>

      <div class="form-group">
        <div class="AddResult"></div>
      </div>
  
      </div>
      <div class="modal-footer border-0">
        <button type="submit" class="btn btn-green" name="EditRFID">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- End Form Save Camera -->
</form>


<form action="save/update_canteen_register.php" autocomplete="off" method="POST" target="iframe_Edit_State_RFID">
<!-- Modal Edit RFID -->
<div class="modal fade" id="Modal_edit_State" tabindex="-1" role="dialog" aria-labelledby="ModalEditStateRFIDTitleTitle" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title text-green" id="ModalEditStateRFIDTitle"><strong>Edit Status</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
  
      <input type="hidden" id="IdPanel_State_Emp" name="IdPanel_State_Emp" value="<?php echo $CanRegisResult["EmpUserID"];?>" readonly required />
      <input type="hidden" id="IdPanel_State_RFID" name="IdPanel_State_RFID" readonly required />
      <div id="Panel_State_RFID"></div>
  
      <div class="form-group">
        <div class="AddResult"></div>
      </div>

      </div>
      <div class="modal-footer border-0">
        <button type="submit" class="btn btn-green" name="EditStateRFID">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- End Form Save Camera -->
</form>



<iframe id="iframe_AddRFID" name="iframe_AddRFID" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
<iframe id="iframe_EditRFID" name="iframe_EditRFID" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
<iframe id="iframe_Edit_State_RFID" name="iframe_Edit_State_RFID" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>



<script type="text/javascript">

    function CanteenResult(result_EditRFID) {
      if(result_EditRFID == 1) {
        //alert('Successfully'),
        //window.location.href = "../canteen_add_card.php?FineID=<?php //echo $inputSearchEmp ;?>";
        $("#Panel_EmpRFID").val(''),
        $("#Panel_EmpRFID").empty(),
        $(".AddResult").html("<div class='alert alert-success text-center' role='alert'>Successfully</div>"),
        setInterval('window.location.href = "canteen_emp_detail.php?IdEmp=<?php echo $inputSearchEmp ;?>"', 500);
      }else {
        //window.location.href = "ot-request.php";
      }
    }

</script>
