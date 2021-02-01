<?php
include "../alert/alert_session.php";
include "../../database/conn_sqlsrv.php";
//include "../database/conn_odbc.php";
include "../../database/conn_mysql.php";
include "../alert/alert_user.php";
include "../alert/data_detail.php";


if (isset($_POST["FineID"]) && trim($_POST["FineID"]) != NULL) {

    $str = trim($_POST["FineID"]);
    //$FineDataEmp = addslashes($str);
    $vowels = array("'");
    $FineID = str_replace($vowels, '', $str);


    $ListSql = "SELECT DISTINCT 
        dbo.ReqInfo.ReqNo, 
        dbo.ReqInfo.EmployeeID, 
        dbo.ReqInfo.ReqDate, 
        dbo.ReqInfo.TrnTime, 
        dbo.ReqInfo.ReqRemark, 
        dbo.ReqInfo.ReqDay, 
        dbo.ReqInfo.ReqHour,
        
        dbo.ReqUser.EmpUserSection, 
        dbo.ReqUser.EmpUserName, 
        dbo.ReqUser.EmpUserSurname, 
        dbo.ReqUser.EmpUserPosition, 
        dbo.ReqUser.EmpUserDepartment, 
        
        EducationSystem.dbo.TrainRecHdr.TrainRecTrainer, 
        EducationSystem.dbo.TrainRecDtl.TrainRecResult
        
        FROM EducationSystem.dbo.TrainRecHdr 
        INNER JOIN dbo.ReqInfo ON EducationSystem.dbo.TrainRecHdr.TrainRecNo = dbo.ReqInfo.ReqNo 
        INNER JOIN EducationSystem.dbo.TrainRecDtl ON dbo.ReqInfo.EmployeeID = EducationSystem.dbo.TrainRecDtl.EmployeeID 
        AND dbo.ReqInfo.ReqNo = EducationSystem.dbo.TrainRecDtl.TrainRecNo 
        INNER JOIN dbo.ReqUser ON EducationSystem.dbo.TrainRecDtl.EmployeeID = dbo.ReqUser.EmpUserID
        
        WHERE (dbo.ReqInfo.ReqType = 4) 
        AND (EducationSystem.dbo.TrainRecHdr.TrainHdrStatus = 3) 
        AND (dbo.ReqInfo.EmployeeID = '$FineID' OR dbo.ReqUser.EmpUserName LIKE '%$FineID%' OR dbo.ReqUser.EmpUserSurname LIKE '%$FineID%')
        --AND (dbo.ReqInfo.EmployeeID = '11363') ";

    $ListQuary = sqlsrv_query($connRequest, $ListSql);
    $ListRow = sqlsrv_fetch_array($ListQuary, SQLSRV_FETCH_ASSOC);

    $output .= '

    <input type="hidden" id="EmpID" name="EmpID" value="' . $ListRow["EmployeeID"] . '" required>
<div class="form-row">
<div class="col-md-3 mb-2">
<div class="d-flex align-items-center p-3 text-white-50 bg-dark rounded">
<img class="rounded mr-3" src="../img/photo_emp/square/' . (($ListRow["EmployeeID"] == NULL) ? "10000" : $ListRow["EmployeeID"]) . '.jpg" alt="Images" width="48" height="48">
<div class="lh-100">
    <small class="text-white">' . $ListRow["EmployeeID"] . '</small>
    <h6 class="mb-0 text-white text-uppercase lh-100">' . $ListRow['EmpUserName'] . "\n" . $ListRow['EmpUserSurname'] . '</h6>
</div>
</div>
<div class="form-group mt-2">
<ul>
    <li><small>Position:</small> ' . $ListRow["EmpUserPosition"] . '</li>
    <li><small>Section:</small> ' . $ListRow["EmpUserSection"] . '</li>
    <li><small>Dept:</small> ' . $ListRow["EmpUserDepartment"] . '</li>
</ul>
</div>
</div>
<div class="col-md-9 mb-2">
<!-- /* Start Table */ -->
<div class="table-responsive">
  <table class="table text-truncate" id="reqTableMyList" width="100%" cellspacing="0">
    <thead class="text-uppercase thead-light">
        <tr>
            <th scope="col">No.</th>
            <th scope="col">Training date</th>
            <th scope="col">Subject</th>
            <th scope="col">Period</th>
            <th scope="col">Trainer</th>
            <th scope="col">Result</th>
        </tr>
    </thead>
    <tbody>';

    $ListIParams = array();
    $ListIOptions =  array("Scrollable" => SQLSRV_CURSOR_KEYSET);
    $ListIStmt = sqlsrv_query($connRequest, $ListSql, $ListIParams, $ListIOptions);
    $ListIRow = sqlsrv_num_rows($ListIStmt);

    if ($ListIRow > 0) {
        $iScore = 1;
        $ListObj = sqlsrv_query($connRequest, $ListSql);
        while ($ListResult = sqlsrv_fetch_array($ListObj, SQLSRV_FETCH_ASSOC)) {

            $output .= '
                <tr>
                    <th scope="row">' . $iScore++ . '</th>
                    <td>' . date_format($ListResult["ReqDate"], 'd/m/Y') . " - " . date_format($ListResult["TrnTime"], 'd/m/Y') . '</td>
                    <td>' . $ListResult["ReqRemark"] . '</td>
                    <td>' . round($ListResult["ReqDay"], 2) . "Day, " . round($ListResult["ReqHour"], 2) . "Hrs" . '</td>
                    <td>' . $ListResult["TrainRecTrainer"] . '</td>
                    <td>' . (($ListResult["TrainRecResult"] == 1) ? "PASS" : "FAIL") . '</td>
                </tr>';
        }
    } else {
        $output .= '<tr><td colspan="6" class="text-center">No data available in table</td></tr>';
    }
    $output .= '
    </tbody>
</table>
</div>
<!-- /* End Table */ -->
</div>
</div>
        ';

    echo $output;
} else {
    echo "<script>window.close();</script>";
    exit();
}
