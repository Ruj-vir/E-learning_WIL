<?php
include "../alert/alert_session.php";
include "../../database/conn_sqlsrv.php";
//include "../database/conn_odbc.php";
include "../../database/conn_mysql.php";
include "../alert/alert_user.php";
include "../alert/data_detail.php";


if (isset($_POST["DateFrom"], $_POST["DateTo"])) {

    $DateFrom = $_POST["DateFrom"]; //'2020-04-18 06:00:00';//
    $DateTo = $_POST["DateTo"]; //'2020-04-18 18:00:00';//


    if (($DateFrom == date('Y-m-d', strtotime($DateFrom))) && ($DateTo == date('Y-m-d', strtotime($DateTo)))) {

        $output .= '                        
                  <div class="table-responsive">
                  <table class="table table-bordered text-truncate" id="reqTableMyList" width="100%" cellspacing="0">
                  <thead class="text-uppercase thead-light">
                  <tr class="text-center">
                      <th scope="col" rowspan="2">No.</th>
                      <th scope="col" rowspan="2">Course name</th>
                      <th scope="col" rowspan="2">Training date</th>
                      <th scope="col" rowspan="2">Sec./Dpt.</th>
                      <th scope="col" rowspan="2">Trainer/Organize</th>
                      <th scope="col" rowspan="2">Place</th>
                      <th scope="col" rowspan="2">Type</th>
                      <th scope="col" colspan="2">Result</th>
                      <th scope="col" rowspan="2">Period</th>
                      <th scope="col" rowspan="2" class="text-right">Cost (THB)</th>
                  <tr class="text-center">
                      <td scope="col" class="bg-success" style="font-size: 11px;">Pass</td>
                      <td scope="col" class="bg-danger" style="font-size: 11px;">Fail</td>
                  </tr>
              </thead>
                      <tbody class="tbody">';

        $ListSql = "SELECT DISTINCT 
                      dbo.ReqInfo.ReqNo, 
                      dbo.ReqInfo.ReqDate, 
                      dbo.ReqInfo.TrnTime, 
                      dbo.ReqInfo.ReqDay, 
                      dbo.ReqInfo.ReqHour, 
                      dbo.ReqInfo.ReqSumTime, 
                      dbo.ReqInfo.ReqRemark,

                      EducationSystem.dbo.TrainRecHdr.TrainRecType, 
                      EducationSystem.dbo.TrainRecHdr.TrainRecEvl, 
                      EducationSystem.dbo.TrainRecHdr.TrainRecTrainer, 
                      EducationSystem.dbo.TrainRecHdr.TrainRecPlace, 
                      dbo.ReqUser.EmpUserSection
                      FROM EducationSystem.dbo.TrainRecHdr INNER JOIN
                      dbo.ReqInfo ON EducationSystem.dbo.TrainRecHdr.TrainRecNo = dbo.ReqInfo.ReqNo INNER JOIN
                      dbo.ReqUser ON dbo.ReqInfo.ReqIssuer = dbo.ReqUser.EmpUserID
                      WHERE (dbo.ReqInfo.ReqType = 4) AND (EducationSystem.dbo.TrainRecHdr.TrainHdrStatus = 3) 
                      AND ((dbo.ReqInfo.ReqDate >= '$DateFrom 00:00:00' AND dbo.ReqInfo.TrnTime <= '$DateTo 23:59:59')
                      OR (dbo.ReqInfo.TrnTime >= '$DateFrom 00:00:00' AND dbo.ReqInfo.ReqDate <= '$DateTo 23:59:59')) ";

        $ListIParams = array();
        $ListIOptions =  array("Scrollable" => SQLSRV_CURSOR_KEYSET);
        $ListIStmt = sqlsrv_query($connRequest, $ListSql, $ListIParams, $ListIOptions);
        $ListIRow = sqlsrv_num_rows($ListIStmt);

        if ($ListIRow > 0) {
            $iScore = 1;
            $ListObj = sqlsrv_query($connRequest, $ListSql);
            while ($ListResult = sqlsrv_fetch_array($ListObj, SQLSRV_FETCH_ASSOC)) {

                switch ($ListResult["TrainRecType"]) {
                    case 1:
                        $TrainRecType = 'Orientation';
                        break;
                    case 2:
                        $TrainRecType = 'OJT';
                        break;
                    case 3:
                        $TrainRecType = 'Refreshing';
                        break;
                    case 4:
                        $TrainRecType = 'On going';
                        break;
                    case 5:
                        $TrainRecType = 'Public';
                        break;
                    case 6:
                        $TrainRecType = 'Other';
                        break;

                    default:
                        $TrainRecType = '';
                }

                $ItemReqNo = $ListResult["ReqNo"];

                $PassDtlSql = "SELECT COUNT(EmployeeID) AS TraineePass
                FROM dbo.ReqInfo AS ReqInfo
                WHERE (EmployeeID IN
                (SELECT EmployeeID
                FROM EducationSystem.dbo.TrainRecDtl
                WHERE (TrainDtlStatus = 6) 
                AND (TrainRecResult = 1))) 
                AND (ReqType = 4) 
                AND (ReqNo = '$ItemReqNo')";
                $PassDtlObj = sqlsrv_query($connRequest, $PassDtlSql);
                $PassDtlResult = sqlsrv_fetch_array($PassDtlObj, SQLSRV_FETCH_ASSOC);

                $FailDtlSql = "SELECT COUNT(EmployeeID) AS TraineeFail
                FROM dbo.ReqInfo AS ReqInfo
                WHERE (EmployeeID NOT IN
                (SELECT EmployeeID
                FROM EducationSystem.dbo.TrainRecDtl
                WHERE (TrainDtlStatus = 6) 
                AND (TrainRecResult = 1))) 
                AND (ReqType = 4) 
                AND (ReqNo = '$ItemReqNo')";
                $FailDtlObj = sqlsrv_query($connRequest, $FailDtlSql);
                $FailDtlResult = sqlsrv_fetch_array($FailDtlObj, SQLSRV_FETCH_ASSOC);

                $output .= '
                              <tr class="tr text-center text-uppercase">
                                  <th scope="row">' . $iScore . '</th>
                                  <td class="text-left">' . $ListResult["ReqRemark"] . '</td>
                                  <td>
                                      ' . date_format($ListResult["ReqDate"], 'd/m/Y') . " - " . date_format($ListResult["TrnTime"], 'd/m/Y') . '
                                      <div>' . date_format($ListResult["ReqDate"], 'H:i') . " - " . date_format($ListResult["TrnTime"], 'H:i') . '</div>
                                  </td>
                                  <td>' . $ListResult["EmpUserSection"] . '</td>
                                  <td class="text-left">' . $ListResult["TrainRecTrainer"] . '</td>
                                  <td>' . $ListResult["TrainRecPlace"] . '</td>
                                  <td>' . $TrainRecType . '</td>
                                  <td>' . $PassDtlResult["TraineePass"] . '</td>
                                  <td>' . $FailDtlResult["TraineeFail"] . '</td>
                                  <td>' . round($ListResult["ReqDay"], 2) . "Day, " . round($ListResult["ReqHour"], 2) . "Hrs" . '</td>
                                  <td class="text-right">' . number_format($ListResult["ReqSumTime"], 2) . '</td>
                              </tr>';

                $iScore++;
            }
        } else {
            $output .= '
            <tr><td colspan="11" class="text-center">No data available in table</td></tr>
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
