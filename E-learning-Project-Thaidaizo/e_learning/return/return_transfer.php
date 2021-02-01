
<?php
    include "../alert/alert_session.php";
    include "../../database/conn_sqlsrv.php";
    //include "../database/conn_odbc.php";
    //include "../../database/conn_mysql.php";
    include "../alert/alert_user.php";
    include "../alert/data_detail.php";

if(trim($_POST["EmpTransfer"])){
  
  $result = '';
  $query = "SELECT EmpUserID,EmpUserName,EmpUserSurname,EmpUserPosition,EmpUserSection,EmpUserDepartment,EmpUserEmail,Authentication FROM ReqUser WHERE EmpUserID = '".$_POST["EmpTransfer"]."' ";
  $sql = sqlsrv_query($connRequest, $query);
  $row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC);
  switch ($row["Authentication"]){
	case 1: $Author = "Requestor"; break;
	case 2: $Author = "Inspector"; break;
	case 3: $Author = "Approvers"; break;
	case 6: $Author = "Verify"; break;
	case 9: $Author = "IT"; break;
  }
  $result .='
		<div class="row">
		<div class="col-lg-4">
		<div class="form-row">
		<div class="container-fluid p-0">
		<div class="row">
		<div class="col-lg-12">
		<img class="card-img-top img-fluid img-profile rounded-0 mx-auto" style="width: 100%; height: 200px; background-color: #eceff1; border: solid 3px #eceff1;" src="../img/photo_emp/rectangle/'.$row["EmpUserID"].'.jpg" alt="">	
		</div>
		</div>
		</div>
		</div>
		</div>
        <input type="hidden" id="txtChange" name="txtChange" value="'.$row["EmpUserID"].'" readonly>
          <div class="col-lg-8">
            <div class="row">
              <div class="col-lg-12 my-2"><b>ID:</b> '.$row["EmpUserID"].'</div>
              <div class="col-lg-6 my-2"><b>Name:</b> '.$row["EmpUserName"].'</div>
              <div class="col-lg-6 my-2"><b>Surname:</b> '.$row["EmpUserSurname"].'</div>
              <div class="col-lg-6 my-2"><b>Position:</b> '.$row["EmpUserPosition"].'</div>
              <div class="col-lg-6 my-2"><b>Section:</b> '.$row["EmpUserSection"].'</div>
              <div class="col-lg-6 my-2"><b>Department:</b> '.$row["EmpUserDepartment"].'</div>
              <div class="col-lg-6 my-2"><b>Email:</b> '.$row["EmpUserEmail"].'</div>
              <div class="col-lg-6 my-2"><b>Status:</b> <span class="badge badge-pill badge-dark">
			  '.$Author.'</span></span></div>
            </div>
          </div>';
  echo $result;
}
?>



