<?php
    include "../alert/alert_session.php";
    include "../../database/conn_sqlsrv.php";
    //include "../database/conn_mysql.php";
    include "../alert/alert_user.php";
    include "../alert/data_detail.php";


if(isset($_POST["IDPanelIDEmp"])) {
    $FineEmpID = $_POST["IDPanelIDEmp"];
    $FineRFID = $_POST["IDPanelRFID"];

	$RfidSQL = "SELECT RFIDNo FROM RFID_Master WHERE (EmpID = '$FineEmpID') AND (RFIDNo = '$FineRFID')";
	$RfidQuery = sqlsrv_query($connCanteen, $RfidSQL);
	$NumNo = 1;
    $RfidResult = sqlsrv_fetch_array($RfidQuery, SQLSRV_FETCH_ASSOC);
    
    $output .= '
  <div class="form-group">
    <label for="formGroupRFID">RFID</label>
    <input type="text" class="form-control" name="inputRFID" value="'.$RfidResult["RFIDNo"].'" placeholder="Enter RFID" required>
  </div>
  ';
  echo $output;
}

if(isset($_POST["IDPanelIDEmp_State"])) {
    $FineEmpID_State = $_POST["IDPanelIDEmp_State"];
    $FineRFID_State = $_POST["IDPanelRFID_State"];

	$RfidSQL = "SELECT Status FROM RFID_Master WHERE (EmpID = '$FineEmpID_State') AND (RFIDNo = '$FineRFID_State')";
	$RfidQuery = sqlsrv_query($connCanteen, $RfidSQL);
	$NumNo = 1;
    $RfidResult = sqlsrv_fetch_array($RfidQuery, SQLSRV_FETCH_ASSOC);
    
    $output .= '
  <div class="form-group">
  <label for="formGroupRFID">Status</label>
    <select class="custom-select form-control" name="StatusRFID" required>
      <option value="1" '.(($RfidResult["Status"] == "1") ? 'selected' : '' ).'>Enabled</option>
      <option value="0" '.(($RfidResult["Status"] == "0") ? 'selected' : '' ).'>Disabled</option>
    </select>
  </div>
  ';
  echo $output;
}

?>