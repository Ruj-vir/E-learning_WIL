<?php
include "../alert/alert_session.php";
include "../alert/alert_user.php";
include "../../database/conn_sqlsrv.php";
//include "../database/conn_odbc.php";
include "../../database/conn_mysql.php";
include "../alert/data_detail.php";


if (isset($_POST["DateFrom"], $_POST["DateTo"], $_POST["inputAccess"])) {

    $DateFrom = $_POST["DateFrom"]; //'2020-04-18 06:00:00';//
    $DateTo = $_POST["DateTo"]; //'2020-04-18 18:00:00';//
    $inputAccess = $_POST["inputAccess"]; 


    if (($DateFrom == date('Y-m-d', strtotime($DateFrom))) && ($DateTo == date('Y-m-d', strtotime($DateTo)))) {

        $output .= '                        
                  <div class="table-responsive">
                  <table class="table table-hover text-truncate" id="reqTableMyList" width="100%" cellspacing="0">
                      <thead class="text-uppercase thead-light">
                          <tr>
                          <th scope="col">#</th>
                          <th scope="col">Course name</th>
                          <th scope="col">Training date</th>
                          <th scope="col">Period</th>
                          <th scope="col">Requestor</th>
                          <th scope="col" class="text-center">Export</th>
                          </tr>
                      </thead>
                      <tbody class="tbody">';

$AuthenReq = $resultSQL['Authentication'];
$Arr_Owner = array("6","9");
// $Arr_Sign = array("3");
// if(in_array($AuthenReq, $Arr_Owner)){

if(trim($inputAccess) == 1){

    $ListSql = "SELECT DISTINCT ReqInfo.ReqNo, ReqInfo.ReqRemark, 
    ReqInfo.ReqDay, ReqInfo.ReqHour, 
    ReqInfo.ReqSumTime, ReqOTType, 
    ReqInfo.ReqDate, ReqInfo.TrnTime,
    ReqUser.EmpUserID, ReqUser.EmpUserName, ReqUser.EmpUserSurname, 
    ReqUser.EmpUserPosition, ReqUser.EmpUserSection, ReqUser.EmpUserDepartment
    FROM ReqInfo 
    INNER JOIN ReqUser ON ReqInfo.ReqIssuer = ReqUser.EmpUserID
    WHERE (ReqInfo.ReqType = 4) 
    AND (ReqInfo.ReqIssuer = '$SesUserID') 
    AND (ReqInfo.Status <> 0) 
    AND ((ReqDate >= '$DateFrom 00:00:00' AND TrnTime <= '$DateTo 23:59:59') 
    OR (ReqDate <= '$DateTo 23:59:59' AND TrnTime >= '$DateFrom 00:00:00'))
    ORDER BY ReqInfo.ReqNo";

} else if(trim($inputAccess) == 2){

    $ListSql = "SELECT DISTINCT ReqInfo.ReqNo, ReqInfo.ReqRemark, 
    ReqInfo.ReqDay, ReqInfo.ReqHour, 
    ReqInfo.ReqSumTime, ReqOTType, 
    ReqInfo.ReqDate, ReqInfo.TrnTime,
    ReqUser.EmpUserID, ReqUser.EmpUserName, ReqUser.EmpUserSurname, 
    ReqUser.EmpUserPosition, ReqUser.EmpUserSection, ReqUser.EmpUserDepartment
    FROM ReqInfo 
    INNER JOIN ReqUser ON ReqInfo.ReqIssuer = ReqUser.EmpUserID
    WHERE (ReqInfo.ReqType = 4) 
    AND (ReqInfo.ReqChecker = '$SesUserID') 
    AND (ReqInfo.Status <> 0) 
    AND ((ReqDate >= '$DateFrom 00:00:00' AND TrnTime <= '$DateTo 23:59:59') 
    OR (ReqDate <= '$DateTo 23:59:59' AND TrnTime >= '$DateFrom 00:00:00'))
    ORDER BY ReqInfo.ReqNo";

} else if(trim($inputAccess) == 3){

    $ListSql = "SELECT DISTINCT ReqInfo.ReqNo, ReqInfo.ReqRemark, 
    ReqInfo.ReqDay, ReqInfo.ReqHour, 
    ReqInfo.ReqSumTime, ReqOTType, 
    ReqInfo.ReqDate, ReqInfo.TrnTime,
    ReqUser.EmpUserID, ReqUser.EmpUserName, ReqUser.EmpUserSurname, 
    ReqUser.EmpUserPosition, ReqUser.EmpUserSection, ReqUser.EmpUserDepartment
    FROM ReqInfo 
    INNER JOIN ReqUser ON ReqInfo.ReqIssuer = ReqUser.EmpUserID
    WHERE (ReqInfo.ReqType = 4) 
    AND (ReqInfo.ReqApprover = '$SesUserID') 
    AND (ReqInfo.Status <> 0) 
    AND ((ReqDate >= '$DateFrom 00:00:00' AND TrnTime <= '$DateTo 23:59:59') 
    OR (ReqDate <= '$DateTo 23:59:59' AND TrnTime >= '$DateFrom 00:00:00'))
    ORDER BY ReqInfo.ReqNo";

} else if(trim($inputAccess) == 4){

    $ListSql = "SELECT DISTINCT ReqInfo.ReqNo, ReqInfo.ReqRemark, 
    ReqInfo.ReqDay, ReqInfo.ReqHour, 
    ReqInfo.ReqSumTime, ReqOTType, 
    ReqInfo.ReqDate, ReqInfo.TrnTime,
    ReqUser.EmpUserID, ReqUser.EmpUserName, ReqUser.EmpUserSurname, 
    ReqUser.EmpUserPosition, ReqUser.EmpUserSection, ReqUser.EmpUserDepartment
    FROM ReqInfo 
    INNER JOIN ReqUser ON ReqInfo.ReqIssuer = ReqUser.EmpUserID
    WHERE (ReqInfo.ReqType = 4) 
    AND (ReqInfo.UpdateBy = '$SesUserID') 
    AND (ReqInfo.Status <> 0) 
    AND ((ReqDate >= '$DateFrom 00:00:00' AND TrnTime <= '$DateTo 23:59:59') 
    OR (ReqDate <= '$DateTo 23:59:59' AND TrnTime >= '$DateFrom 00:00:00'))
    ORDER BY ReqInfo.ReqNo";

}else if(trim($inputAccess) == 5){
    if(in_array($AuthenReq, $Arr_Owner)){

        $ListSql = "SELECT DISTINCT ReqInfo.ReqNo, ReqInfo.ReqRemark, 
        ReqInfo.ReqDay, ReqInfo.ReqHour, 
        ReqInfo.ReqSumTime, ReqOTType, 
        ReqInfo.ReqDate, ReqInfo.TrnTime,
        ReqUser.EmpUserID, ReqUser.EmpUserName, ReqUser.EmpUserSurname, 
        ReqUser.EmpUserPosition, ReqUser.EmpUserSection, ReqUser.EmpUserDepartment
        FROM ReqInfo 
        INNER JOIN ReqUser ON ReqInfo.ReqIssuer = ReqUser.EmpUserID
        WHERE (ReqInfo.ReqType = 4) 
        AND (ReqInfo.Status <> 0) 
        AND ((ReqDate >= '$DateFrom 00:00:00' AND TrnTime <= '$DateTo 23:59:59') 
        OR (ReqDate <= '$DateTo 23:59:59' AND TrnTime >= '$DateFrom 00:00:00'))
        ORDER BY ReqInfo.ReqNo";

    }
}else {

}

        $ListIParams = array();
        $ListIOptions =  array("Scrollable" => SQLSRV_CURSOR_KEYSET);
        $ListIStmt = sqlsrv_query($connRequest, $ListSql, $ListIParams, $ListIOptions);
        $ListIRow = sqlsrv_num_rows($ListIStmt);

        if ($ListIRow > 0) {
            $iScore = 1;
            $ListObj = sqlsrv_query($connRequest, $ListSql);
            while ($ListResult = sqlsrv_fetch_array($ListObj, SQLSRV_FETCH_ASSOC)) {

                $ReqNo = $ListResult["ReqNo"];

                $issuedSql = "SELECT TOP (1) ReqIssueDate FROM ReqInfo WHERE (ReqType = 4) AND (ReqNo = '$ReqNo') ";
                $issuedObj = sqlsrv_query($connRequest, $issuedSql);
                $issuedResult = sqlsrv_fetch_array($issuedObj, SQLSRV_FETCH_ASSOC);

                $output .= '
                              <tr class="tr text-uppercase">
                                  <th scope="row">' . $iScore . ')</th>
                                  <td>
                                    <div class="text-truncate" style="width:200px">' . $ListResult["ReqRemark"] . '</div>
                                  </td>
                                  <td>
                                    <div style="font-size: 14px;"><span class="text-muted mr-4">Date:</span> ' .  date_format($ListResult["ReqDate"], 'd/m/Y') . " - " . date_format($ListResult["TrnTime"], 'd/m/Y') . '</div>
                                    <div style="font-size: 14px;"><span class="text-muted mr-4">Time:</span> ' .  date_format($ListResult["ReqDate"], 'H:i') . " - " . date_format($ListResult["TrnTime"], 'H:i') . '</div>
                                  </td>
                                  <td>' . round($ListResult["ReqDay"], 2) . "Day, " . round($ListResult["ReqHour"], 2) . "Hrs" . '</td>
                                  <td>
                                    <div class="text-truncate">'. $ListResult["EmpUserID"]." - ".$ListResult["EmpUserName"]."\n".$ListResult["EmpUserSurname"] .'</div>
                                    <small>'. date_format($issuedResult["ReqIssueDate"], 'd/m/Y H:i a') .'</small>
                                  </td>
                                  <td class="text-center">
                                  <div class="btn-group" role="group" aria-label="Basic example">
                                      <a href="training_report_application_detail.php?ItemReqNo='.$ListResult['ReqNo'].'&j0dsu36gpd&AccessNo='.$inputAccess.'&9gsu4sdj" target="_blank" class="btn btn-outline-danger btn-sm" title="PDF File"><i class="far fa-file-pdf"></i> PDF</a>
                                  </div>
                                  </td>
                              </tr>';

                $iScore++;
            }
        } else {
            $output .= '
            <tr><td colspan="10" class="text-center">No data available in table</td></tr>
            ';
        }

        $output .= '
                      </tbody>
                      <!--<tfoot>
                          <tr>
                              <th scope="col">#</th>
                              <th scope="col">Course name</th>
                              <th scope="col">Date/Time</th>
                              <th scope="col">Duration</th>
                              <th scope="col">Cost</th>
                              <th class="text-center" scope="col">Export</th>
                          </tr>
                      </tfoot>-->
                  </table>
              </div>';

        echo $output;
    } else {
        exit();
    }
} else {
    exit();
}
//sqlsrv_close($conn);
//$_SESSION["UserID_OT"]
