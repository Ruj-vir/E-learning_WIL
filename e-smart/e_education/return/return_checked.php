<?php
    include "../alert/alert_session.php";
    include "../../database/conn_sqlsrv.php";
    //include "../database/conn_odbc.php";
    include "../../database/conn_mysql.php";
    include "../alert/alert_user.php";
    include "../alert/data_detail.php";

if(isset($_POST["Item_Detail"])){

  $output = '';

  $sql = "SELECT dbo.ReqInfo.ReqNo, dbo.ReqInfo.ReqDate, dbo.ReqInfo.TrnTime, dbo.ReqInfo.EmployeeID, dbo.ReqInfo.ReqDay, dbo.ReqInfo.ReqLeaveType, 
  dbo.ReqInfo.ReqIssuer, dbo.ReqInfo.ReqIssueDate, dbo.ReqInfo.ReqRemark, dbo.ReqInfo.UserDefine2, dbo.ReqInfo.PicturePath, dbo.ReqUser.EmpUserName, 
  dbo.ReqUser.EmpUserSurname, dbo.ReqUser.EmpUserPosition, dbo.ReqUser.EmpUserSection, dbo.ReqUser.EmpUserDepartment, dbo.ReqInfo.Status
  FROM dbo.ReqInfo INNER JOIN dbo.ReqUser ON dbo.ReqInfo.EmployeeID = dbo.ReqUser.EmpUserID
  WHERE (ReqNo='".$_POST["Item_Detail"]."')AND (ReqType=2)
  AND (ReqChecker='$SesUserID') AND (ReqCheckDate IS NOT NULL)";
  $result = sqlsrv_query($connRequest, $sql);
  $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
  
  $CalTypeDay = $row["ReqDay"];
  $CalTypeLeave = $row["ReqLeaveType"];
  $IssueDate = date_format($row["ReqIssueDate"], 'd-m-Y H:i:s');
  $BeginDate = date_format($row["ReqDate"], 'd-m-Y H:i:s');

  $reqDay = round($CalTypeDay,2);

  if($reqDay > 1) {
    $daysum = 'days';
  }else {
    $daysum = 'day';
  }

  $SQL1 = "SELECT NameTH,NameEN FROM leavetype WHERE (LeavType = '$CalTypeLeave')";
  $Execute1 = mysqli_query($connRequestType, $SQL1);
  $row1 = mysqli_fetch_array($Execute1, MYSQLI_ASSOC);
  $LeaveType = $row1["NameEN"];
  
  switch ($row["UserDefine2"]) {
    case 1:
      $Duaration = 'Full Day';
      break;
    case 3:
      $Duaration = 'Half Morning';
      break;
    case 6:
      $Duaration = 'Half Afternoon';
      break;
  }

  //$ImgError = (($row["PicturePath"])== NULL) ? 'whiteboard.png' : $row["PicturePath"];
  //$stmt10 = "SELECT EmpUserName,EmpUserSurname,EmpUserSection,EmpUserDepartment FROM ReqUser WHERE (EmpUserID='".$row["ReqIssuer"]."')";
  //$query10 = sqlsrv_query($connRequest, $stmt10);
  //$result10 = sqlsrv_fetch_array($query10, SQLSRV_FETCH_ASSOC);

  /*
      $TimeCheck = date_format($row["ReqCheckDate"], 'Y-m-d H:i:s');
      $TimeApprove = date_format($row["ReqApproveDate"], 'Y-m-d H:i:s');
      $TimeVerify = date_format($row["UpdateDate"], 'Y-m-d H:i:s');
  
      $TimeChecked = strtotime($TimeCheck);
      $TimeApprovd = strtotime($TimeApprove);
      $TimeVerifed = strtotime($TimeVerify);
  
    if(trim($row["Status"] == 0) && (($TimeChecked > $TimeApprovd) && ($TimeChecked > $TimeVerifed))){
        $person01 = 'Check';
      }else{
        $person01 = '';
      }
      if(trim($row["Status"] == 0) && (($TimeApprovd > $TimeChecked) && ($TimeApprovd > $TimeVerifed))){
        $person02 = 'Approve';
      }else{
        $person02 = '';
      }
      if(trim($row["Status"] == 0) && (($TimeVerifed > $TimeChecked) && ($TimeVerifed > $TimeApprovd))){
        $person03 = 'System';
      }else{
        $person03 = '';
      }
  */
  
  $origin = date_create($IssueDate);
  $target = date_create($BeginDate);
  $interval = date_diff($origin, $target);
  $NumDate = $interval->format('%R%a days');

  if($NumDate > 0) {
    $DateLeaveState = 'in advance';
    $ColorLeaveState = 'success';
  }else {
    $DateLeaveState = 'Not in advance';
    $ColorLeaveState = 'danger';
  }


      switch ($row["Status"]) {
        case 0:
          $StatusReq = 'Rejected';
          break;
        case 1:
          $StatusReq = 'Pending Check';
          break;
        case 2:
          $StatusReq = 'Pending Appove';
          break;
        case 3:
          $StatusReq = 'Manager Appove';
          break;
        case 6:
          $StatusReq = 'Appoved';
          break;
        case 9:
          $StatusReq = 'Appoved';
          break;
        }
        $string =$row["ReqRemark"];
        
   $output .= '
  
   <div class="row mb-3">
     <div class="col-md-12">
       <div class="d-flex flex-row border-0 rounded">
           <div class="p-3 w-100">
              <div class="d-flex align-items-center p-3 text-white-50 bg-dark rounded box-shadow">
                <img class="mr-3" src="../img/photo_emp/square/'.$row["ReqIssuer"].'.jpg" alt="Images" width="48" height="48">
                <div class="lh-100">
                  <h5 class="mb-0 text-white lh-100">'.$row["ReqIssuer"].'</h5>
                  <h5 class="mb-0 text-white lh-100">'.$row["EmpUserName"]."\n".$row["EmpUserSurname"].'</h5>
                </div>
              </div>
               <hr class="">
               <ul>
                 <li><strong>Req no:</strong> '.$row["ReqNo"].'</li>
                 <li><strong>Issue date:</strong> '.date_format($row["ReqIssueDate"], 'd-m-Y H:i:s').'</li>
               </ul>

               <h5>
                <span class="badge badge-'.$ColorLeaveState.'">'.$DateLeaveState.' - <span class="badge badge-light">'.$NumDate.'</span></span>
               </h5>
               <hr class="">
               <h5 class="mt-3">
                <span class="badge badge-dark">'.$LeaveType.' - <span class="badge badge-light">'.$Duaration.'</span></span>
               </h5>

               <ul>
                 <li><strong>Leave date:</strong> '.date_format($row["ReqDate"], 'd M. Y')." - ".date_format($row["TrnTime"], 'd M. Y').'</li>
                 <li><strong>Duration:</strong> '.round($reqDay,2)."\n".$daysum.'</li>
                 <li><strong>Details:</strong> '.preg_replace("/\([^)]+\)/","",$string).'</li>
                 <li><strong>Attach File:</strong>';
                 if(trim($row["PicturePath"]) != NULL) {
                  $output .= '<a target="_blank" href="assets/file/'.$row["PicturePath"].'"> See more..</a>';
                 }else {
                  $output .= '
                  <span>No attachment</span>';
                 }
                 $output .= '
                 </li>
                 <li>';
    if(trim($row["PicturePath"]) != NULL) {
    $output .= '	
      <div class="embed-responsive embed-responsive-1by1 mt-2">
        <iframe class="embed-responsive-item border border-dark rounded" src="assets/file/'.$row["PicturePath"].'"></iframe>
      </div>';
    }else {

    }
    $output .= '
           </li>
                 <li class="mt-3"><strong>Status:</strong> <span class="badge badge-0'.$row["Status"].'">'.$StatusReq.'</span></li>
               </ul>
         </div>
       </div>
     </div>
   </div>';
  echo $output;
  }





  //sqlsrv_close($conn);
