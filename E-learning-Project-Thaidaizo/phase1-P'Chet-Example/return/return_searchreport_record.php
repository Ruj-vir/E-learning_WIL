<?php
include "../alert/alert_session.php";
include "../alert/alert_user.php";
include "../../database/conn_sqlsrv.php";
//include "../database/conn_odbc.php";
include "../../database/conn_mysql.php";
include "../alert/data_detail.php";


if (isset($_POST["FineID"]) && trim($_POST["FineID"]) != NULL) {

    $str = trim($_POST["FineID"]);
    //$FineDataEmp = addslashes($str);
    $vowels = array("'");
    $FineID = str_replace($vowels, '', $str);


    $ListSql = "SELECT DISTINCT 
    dbo.ReqUser.EmpUserSection, 
    dbo.ReqUser.EmpUserName, 
    dbo.ReqUser.EmpUserSurname, 
    dbo.ReqUser.EmpUserPosition, 
    dbo.ReqUser.EmpUserDepartment, 

    EducationSystem.dbo.TrainRecHdr.TrainRecName, 
    EducationSystem.dbo.TrainRecHdr.TrainRecDateFrom, 
    EducationSystem.dbo.TrainRecHdr.TrainRecDateTo, 
    EducationSystem.dbo.TrainRecHdr.TrainRecTotalDay, 
    EducationSystem.dbo.TrainRecHdr.TrainRecTotalHour, 
    EducationSystem.dbo.TrainRecHdr.TrainRecTrainer, 
    EducationSystem.dbo.TrainRecHdr.TrainRecPlace,  
    EducationSystem.dbo.TrainRecHdr.TrainRecCost,  
    
    EducationSystem.dbo.TrainRecDtl.EmployeeID,
    EducationSystem.dbo.TrainRecDtl.TrainRecResult,
    EducationSystem.dbo.TrainRecDtl.TrainRecNo

    FROM dbo.ReqUser INNER JOIN
    EducationSystem.dbo.TrainRecDtl ON dbo.ReqUser.EmpUserID = EducationSystem.dbo.TrainRecDtl.EmployeeID INNER JOIN
    EducationSystem.dbo.TrainRecHdr ON EducationSystem.dbo.TrainRecDtl.TrainRecNo = EducationSystem.dbo.TrainRecHdr.TrainRecNo
    WHERE (EducationSystem.dbo.TrainRecHdr.TrainHdrStatus = 3) 
    AND (EducationSystem.dbo.TrainRecDtl.TrainDtlStatus = 6) 
    AND (EducationSystem.dbo.TrainRecDtl.EmployeeID = '$FineID' 
    OR dbo.ReqUser.EmpUserName LIKE '%$FineID%' 
    OR dbo.ReqUser.EmpUserSurname LIKE '%$FineID%')
    ORDER BY EducationSystem.dbo.TrainRecDtl.TrainRecNo DESC";

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
                    <td>' . date_format($ListResult["TrainRecDateFrom"], 'd/m/Y') . " - " . date_format($ListResult["TrainRecDateTo"], 'd/m/Y') . '</td>
                    <td>' . $ListResult["TrainRecName"] . '</td>
                    <td>' . round($ListResult["TrainRecTotalDay"], 2) . "Day, " . round($ListResult["TrainRecTotalHour"], 2) . "Hrs" . '</td>
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
