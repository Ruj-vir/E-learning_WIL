<?php
include "../alert/alert_session.php";
include "../../database/conn_sqlsrv.php";
//include "../database/conn_odbc.php";
include "../../database/conn_mysql.php";
include "../alert/alert_user.php";
include "../alert/data_detail.php";


if (isset($_POST["Item_ReqNo"])) {

  $ItemReqNo = $_POST["Item_ReqNo"];

  $output = '';
  $sqler = "SELECT dbo.ReqInfo.ReqNo, dbo.ReqInfo.ReqDate, dbo.ReqInfo.TrnTime, dbo.ReqInfo.ReqRemark, 
ReqInfo.ReqDay, ReqInfo.ReqHour, dbo.ReqInfo.ReqSumTime, dbo.ReqInfo.PicturePath, dbo.ReqInfo.UserDefine1
--dbo.ReqInfo.EmployeeID, dbo.ReqUser.EmpUserName, dbo.ReqUser.EmpUserSurname, dbo.ReqUser.EmpUserSection, dbo.ReqUser.EmpUserDepartment
FROM dbo.ReqInfo INNER JOIN dbo.ReqUser ON dbo.ReqInfo.EmployeeID = dbo.ReqUser.EmpUserID
WHERE (dbo.ReqInfo.ReqNo = '$ItemReqNo') AND (dbo.ReqInfo.ReqApprover = '$SesUserID') 
AND (dbo.ReqInfo.ReqType = 4)";
  $resulter = sqlsrv_query($connRequest, $sqler);
  $rower = sqlsrv_fetch_array($resulter, SQLSRV_FETCH_ASSOC);

  //preg_match('#\<(.*?)\>#', $rower["UserDefine1"] . "()", $MatchObject); $Object = $MatchObject[1]
  //preg_match('#\|(.*?)\|#', $rower["UserDefine1"] . "()", $MatchOrganizer); $Organizer = $MatchOrganizer[1]
  //preg_match('#\@(.*?)\@#', $rower["UserDefine1"] . "()", $match); $Location = $match[1]

  $EleData = explode('|', $rower["UserDefine1"]);

  $output .= '

  <div class="row">
      <div class="col-sm-12 mb-2">
    Course: <span class="font-weight-bold h6">' . $rower["ReqRemark"] . '</span>
    </div>
    <div class="col-sm-6 mb-2">
    Date: <span class="font-weight-bold h6">' . date_format($rower["ReqDate"], 'd M. Y') . " - " . date_format($rower["TrnTime"], 'd M. Y') . '</span>
    </div>
    <div class="col-sm-6 mb-2">
    Time: <span class="font-weight-bold h6">' . date_format($rower["ReqDate"], 'H:i') . " - " . date_format($rower["TrnTime"], 'H:i')  . '</span>
    </div>
    <div class="col-sm-6 mb-2">
    Duration: <span class="font-weight-bold h6">' . round($rower["ReqDay"], 2) . "Day, " . round($rower["ReqHour"], 2) . "Hrs" . '</span>
    </div>
    <div class="col-sm-6 mb-2">
    Cost: <span class="font-weight-bold h6">' . number_format($rower["ReqSumTime"], 2) . ' THB</span>
    </div>
    <div class="col-sm-6 mb-2">
    Object: <span class="font-weight-bold h6">' . $EleData[1] . '</span>
    </div>    
    <div class="col-sm-6 mb-2">
    Organizer: <span class="font-weight-bold h6">' . $EleData[2] . '</span>
    </div>
    <div class="col-sm-6 mb-2">
    Location: <span class="font-weight-bold h6">' . $EleData[3] . '</span>
    </div>    
    <div class="col-sm-6 mb-2">
    Attachment: ';
  if (substr($rower["PicturePath"], 18) != NULL) {
    $output .= '
    <button type="button" class="btn btn-greenblue btn-sm" data-toggle="modal" data-target="#AttachmentModal"><i class="fas fa-paperclip"></i></button>';
  } else {
    $output .= '<span class="font-weight-bold h6">none</span>';
  }
  $output .= '
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="AttachmentModal" tabindex="-1" role="dialog" aria-labelledby="AttachmenTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header text-greenblue">
          <h5 class="modal-title" id="AttachmenTitle">Attachment</h5>
          <button type="button" class="close attachment-close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        
              <div class="embed-responsive embed-responsive-4by3 mb-3">
                <iframe class="embed-responsive-item" src="assets/img/request/' . ((substr($rower["PicturePath"], 18) != NULL) ? $rower["PicturePath"] : 'index.html') . '"  ></iframe>
              </div>
              <a href="assets/img/request/' . ((substr($rower["PicturePath"], 18) != NULL) ? $rower["PicturePath"] : 'index.html') . '" target="_blank"><i class="far fa-window-restore"></i> More..</a> 

        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->

 <div class="table-responsive mt-2">
<div class="table-wrapper-scroll-y-01 my-custom-scrollbar-01">
  <table class="table table-hover nowrap text-truncate" style="width:100%">
   <thead>
     <tr>
       <th scope="col">#</th>
       <th scope="col">ID</th>
       <th scope="col">Name/Surname</th>
       <th scope="col" class="text-center">Status</th>
     </tr>
   </thead><tbody>';

  $sql = "SELECT dbo.ReqInfo.ReqNo, dbo.ReqInfo.EmployeeID, dbo.ReqUser.EmpUserName, dbo.ReqUser.EmpUserSurname, 
  dbo.ReqUser.EmpUserSection, dbo.ReqUser.EmpUserDepartment, dbo.ReqInfo.Status
   FROM dbo.ReqInfo INNER JOIN dbo.ReqUser ON dbo.ReqInfo.EmployeeID = dbo.ReqUser.EmpUserID
   WHERE (dbo.ReqInfo.ReqNo = '$ItemReqNo') AND (dbo.ReqInfo.ReqApprover = '$SesUserID') AND (dbo.ReqInfo.ReqType = 4)";

  $i = 1;
  $result = sqlsrv_query($connRequest, $sql);
  while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $Status = $row["Status"];
    switch ($Status) {
      case 0:
          $StatusReq = 'Cancel';
          $StatusColor = 'danger';
          break;
      case 1:
          $StatusReq = 'Check';
          $StatusColor = 'warning';
          break;
      case 2:
          $StatusReq = 'Verify';
          $StatusColor = 'warning';
          break;
      case 3:
          $StatusReq = 'Approve';
          $StatusColor = 'warning';
          break;
      case 6:
          $StatusReq = 'Approved';
          $StatusColor = 'success';
          break;
      case 9:
          $StatusReq = 'Approved';
          $StatusColor = 'success';
          break;
      default:
          $StatusReq = '';
          $StatusColor = '';
  }

    $output .= '<tr>
        <th scope="row">' . $i . '</th>
        <td>' . $row["EmployeeID"] . '</td>
        <td>' . $row["EmpUserName"] . ' ' . $row["EmpUserSurname"] . '</td>
        <td class="text-center"><span class="badge w-50 badge-'.$StatusColor.'">'.$StatusReq.'</span></td>';
    $i++;
  }

  $output .= '</tbody></table></div></div>';
  echo $output;
}





//sqlsrv_close($conn);
?>


<script type="text/javascript">
  $(function() {
    $(".attachment-close").on('click', function() {
      $('#AttachmentModal').modal('hide');
    });
  });
</script>