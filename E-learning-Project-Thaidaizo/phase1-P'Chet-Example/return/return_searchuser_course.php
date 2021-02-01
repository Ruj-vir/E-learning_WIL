<?php
include "../alert/alert_session.php";
include "../alert/alert_user.php";
include "../../database/conn_sqlsrv.php";
//include "../database/conn_odbc.php";
include "../../database/conn_mysql.php";
include "../alert/data_detail.php";


if (isset($_POST["DateFrom"], $_POST["DateTo"])) {

    $DateFrom = $_POST["DateFrom"]; //'2020-04-18 06:00:00';//
    $DateTo = $_POST["DateTo"]; //'2020-04-18 18:00:00';//


    if (($DateFrom == date('Y-m-d', strtotime($DateFrom))) && ($DateTo == date('Y-m-d', strtotime($DateTo)))) {

        $output .= '                        
                  <div class="table-responsive">
                  <table class="table table-hover text-truncate" id="reqTableMyList" width="100%" cellspacing="0">
                      <thead class="text-uppercase thead-light">
                                    <tr>
                                        <th scope="col">No.</th>
                                        <th scope="col">Course name</th>
                                        <th scope="col">Training date</th>
                                        <th scope="col">Period</th>
                                        <th scope="col" class="text-center">Status</th>
                                        <th scope="col" class="text-center">Actions</th>
                                    </tr>
                      </thead>
                      <tbody class="tbody">';

        $ListSql = "SELECT DISTINCT 
        ReqNo, ReqDate, TrnTime, ReqDay, ReqHour, ReqRemark,
        -- ReqIssuer, ReqIssueDate, ReqSumTime, UserDefine1, PicturePath, 
        Status
        FROM ReqInfo 
        WHERE (EmployeeID = '$SesUserID') 
        AND (ReqType = 4)
        AND ((ReqDate >= '$DateFrom 00:00:00' AND TrnTime <= '$DateTo 23:59:59')
        OR (TrnTime >= '$DateFrom 00:00:00' AND ReqDate <= '$DateTo 23:59:59'))
        -- ORDER BY ReqNo DESC";

        $ListIParams = array();
        $ListIOptions =  array("Scrollable" => SQLSRV_CURSOR_KEYSET);
        $ListIStmt = sqlsrv_query($connRequest, $ListSql, $ListIParams, $ListIOptions);
        $ListIRow = sqlsrv_num_rows($ListIStmt);

        if ($ListIRow > 0) {
            $iScore = 1;
            $ListObj = sqlsrv_query($connRequest, $ListSql);
            while ($ListResult = sqlsrv_fetch_array($ListObj, SQLSRV_FETCH_ASSOC)) {
                // number_format($ListResult["TrainRecCost"], 2);
                switch ($ListResult["Status"]) {
                    case 0:
                        $Status = 'Rejected';
                        $Color = 'danger';
                        break;
                    case 1:
                        $Status = 'Pending';
                        $Color = 'warning';
                        break;
                    case 2:
                        $Status = 'Checked';
                        $Color = 'success';
                        break;
                    case 3:
                        $Status = 'Verify';
                        $Color = 'success';
                        break;
                    case 6:
                        $Status = 'Approve';
                        $Color = 'success';
                        break;
                    case 9:
                        $Status = 'Approve';
                        $Color = 'success';
                        break;

                    default:
                        $Status = '';
                }
                $output .= '
                              <tr class="tr">
                                  <th scope="row">' . $iScore . ')</th>
                                  <td>' . $ListResult["ReqRemark"] . '</td>
                                  <td>
                                    <div style="font-size: 14px;"><span class="text-muted mr-4">Date:</span> ' .  date_format($ListResult["ReqDate"], 'd/m/Y') . " - " . date_format($ListResult["TrnTime"], 'd/m/Y') . '</div>
                                    <div style="font-size: 14px;"><span class="text-muted mr-4">Time:</span> ' .  date_format($ListResult["ReqDate"], 'H:i') . " - " . date_format($ListResult["TrnTime"], 'H:i') . '</div>
                                  </td>
                                  <td>' . round($ListResult["ReqDay"], 2) . "Day, " . round($ListResult["ReqHour"], 2) . "Hrs" . '</td>
                                  <td class="text-center"><span class="badge badge-' . $Color . '">' . $Status . '</span></td>
                                  <td class="text-center">
                                  <div class="btn-group" role="group" aria-label="Basic example">
                                      <a href="profile_user_course_detail.php?ItemReqNo=' . $ListResult['ReqNo'] . '&j0dsu36gpd9gsu9sdj9" target="_blank" class="btn btn-outline-dark btn-sm" title=""><i class="fas fa-eye"></i> View</a>
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
