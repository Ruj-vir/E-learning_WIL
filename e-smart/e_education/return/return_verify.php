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
ReqInfo.ReqDay, ReqInfo.ReqHour, dbo.ReqInfo.ReqSumTime, dbo.ReqInfo.UserDefine1
--dbo.ReqInfo.EmployeeID, dbo.ReqUser.EmpUserName, dbo.ReqUser.EmpUserSurname, dbo.ReqUser.EmpUserSection, dbo.ReqUser.EmpUserDepartment
FROM dbo.ReqInfo INNER JOIN dbo.ReqUser ON dbo.ReqInfo.EmployeeID = dbo.ReqUser.EmpUserID
WHERE (dbo.ReqInfo.ReqNo = '$ItemReqNo') AND (dbo.ReqInfo.ReqChecker = '$SesUserID') 
AND (dbo.ReqInfo.ReqType = 4) AND (dbo.ReqInfo.Status = 2)";
  $resulter = sqlsrv_query($connRequest, $sqler);
  $rower = sqlsrv_fetch_array($resulter, SQLSRV_FETCH_ASSOC);

  $output .= '

  <div class="row">
      <div class="col-sm-12">
    Course: <span class="font-weight-bold h6">' . $rower["ReqRemark"] . '</span>
    </div>
    <div class="col-sm-6">
    Date: <span class="font-weight-bold h6">' . date_format($rower["ReqDate"], 'd M. Y') . " - " . date_format($rower["TrnTime"], 'd M. Y') . '</span>
    </div>
    <div class="col-sm-6">
    Time: <span class="font-weight-bold h6">' . date_format($rower["ReqDate"], 'H:i') . " - " . date_format($rower["TrnTime"], 'H:i')  . '</span>
    </div>
    <div class="col-sm-6">
    Duration: <span class="font-weight-bold h6">' . round($rower["ReqDay"], 2) . "Day, " . round($rower["ReqHour"], 2) . "Hrs" . '</span>
    </div>
    <div class="col-sm-6">
    Cost: <span class="font-weight-bold h6">' . number_format($rower["ReqSumTime"], 2) . ' THB</span>
    </div>
    <div class="col-sm-12">
    Detail: <span class="font-weight-bold h6">' . $rower["UserDefine1"] . '</span>
    </div>
  </div>

 <div class="table-responsive mt-2">
<div class="table-wrapper-scroll-y-01 my-custom-scrollbar-01">
  <table class="table table-hover nowrap text-truncate" style="width:100%">
   <thead>
     <tr>
       <th scope="col">
         <input type="checkbox" id="select_list" name="select_list">
       </th>
       <th scope="col">#</th>
       <th scope="col">ID</th>
       <th scope="col">Name/Surname</th>
     </tr>
   </thead><tbody>';

  $sql = "SELECT dbo.ReqInfo.ReqNo, dbo.ReqInfo.EmployeeID, dbo.ReqUser.EmpUserName, dbo.ReqUser.EmpUserSurname, dbo.ReqUser.EmpUserSection, dbo.ReqUser.EmpUserDepartment
   FROM dbo.ReqInfo INNER JOIN dbo.ReqUser ON dbo.ReqInfo.EmployeeID = dbo.ReqUser.EmpUserID
   WHERE (dbo.ReqInfo.ReqNo = '$ItemReqNo') AND (dbo.ReqInfo.ReqChecker = '$SesUserID') AND (dbo.ReqInfo.ReqType = 4) AND (dbo.ReqInfo.Status = 2)";

  $i = 1;
  $result = sqlsrv_query($connRequest, $sql);
  while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $output .= '<tr>
        <th scope="row">
          <input type="checkbox" class="item_checkbox pointer" value="' . $row["ReqNo"] . '" name="listStaff1[]">
          <input type="checkbox" class="item_checkbox10 pointer" value="' . $row["EmployeeID"] . '" name="listStaff2[]" hidden="hidden">
        </th>
        <th>' . $i . '</th>
        <td>' . $row["EmployeeID"] . '</td>
        <td>' . $row["EmpUserName"] . ' ' . $row["EmpUserSurname"] . '</td>';
    $i++;
  }

  $output .= '</tbody></table></div></div>';
  echo $output;
}





//sqlsrv_close($conn);
?>


<script type="text/javascript">
  $('document').ready(function() {
    // select all checkbox
    $(document).on('click', '#select_list', function() {
      $(".item_checkbox").prop("checked", this.checked);
      //$("#select_counter").html($("input.item_checkbox:checked").length+" Selected");
    });
    $(document).on('click', '.item_checkbox', function() {
      if ($('.item_checkbox:checked').length == $('.item_checkbox').length) {
        $('#select_list').prop('checked', true);
      } else {
        $('#select_list').prop('checked', false);
      }
      //$("#select_counter").html($("input.item_checkbox:checked").length+" Selected");
    });
  });
</script>
<script type="text/javascript">
  $('document').ready(function() {
    // select all checkbox
    $(document).on('click', '#select_list', function() {
      $(".item_checkbox10").prop("checked", this.checked);
      //$("#select_counter").html($("input.item_checkbox10:checked").length+" Selected");
    });
    $(document).on('click', '.item_checkbox10', function() {
      if ($('.item_checkbox10:checked').length == $('.item_checkbox10').length) {
        $('#select_list').prop('checked', true);
      } else {
        $('#select_list').prop('checked', false);
      }
      //$("#select_counter").html($("input.item_checkbox10:checked").length+" Selected");
    });
  });
</script>

<script type="text/javascript">
  $(':checkbox').on('change', function() {
    $(this).closest('tr').find(':checkbox').prop('checked', this.checked);
  });
</script>