<?php
include "../alert/alert_session.php";
include "../../../database/conn_sqlsrv.php";
//include "../database/conn_odbc.php";
//include "../../database/conn_mysql.php";
include "../alert/alert_user.php";
include "../alert/data_detail.php";


if (isset($_POST["ItemReqNo"])) {

  $ItemReqNo = $_POST["ItemReqNo"];
  $output .= '

 <div class="table-responsive mt-2">
<div class="table-wrapper-scroll-y-01 my-custom-scrollbar-01">
  <table class="table table-hover nowrap text-truncate" style="width:100%">
   <thead>
     <tr>
       <th scope="col">#</th>
       <th scope="col">ID</th>
       <th scope="col">Name/Surname</th>
     </tr>
   </thead><tbody>';

   $sql = "SELECT dbo.ReqInfo.ReqNo, dbo.ReqInfo.EmployeeID, dbo.ReqUser.EmpUserName, dbo.ReqUser.EmpUserSurname, dbo.ReqUser.EmpUserSection, dbo.ReqUser.EmpUserDepartment
   FROM dbo.ReqInfo INNER JOIN dbo.ReqUser ON dbo.ReqInfo.EmployeeID = dbo.ReqUser.EmpUserID
   WHERE (dbo.ReqInfo.ReqNo = '$ItemReqNo') AND (dbo.ReqInfo.ReqType = 4) AND (dbo.ReqInfo.Status <> 0)";

    $i = 1;
    $result = sqlsrv_query($connRequest, $sql);
    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
      $output .= '<tr>
        <th>' . $i . '</th>
        <td>' . $row["EmployeeID"] . '</td>
        <td>' . $row["EmpUserName"] . ' ' . $row["EmpUserSurname"] . '</td></tr>';
    $i++;
    }

  $output .= '</tbody></table></div></div>';
  echo $output;
}

//sqlsrv_close($conn);
?>
