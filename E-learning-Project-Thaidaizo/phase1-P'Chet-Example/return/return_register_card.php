<?php
include "../alert/alert_session.php";
include "../alert/alert_user.php";
include "../../database/conn_sqlsrv.php";
//include "../database/conn_odbc.php";
//include "../../database/conn_mysql.php";
include "../alert/data_detail.php";

header("Content-type:text/html; charset=UTF-8");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);

//if(isset($_POST["mySort"])){
if (isset($_GET["Item_InputKeyID"]) != "") {
    $ItemReqNo = $_GET["Item_InputKeyID"];
?>

    <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="card mb-2">
                <?php
                $QDate = "SELECT convert(varchar(10), GETDATE(), 111) AS Datelimit, 
                convert(varchar(10), GETDATE(), 108) AS Timelimit, 
                convert(nvarchar, GETDATE(), 120) AS Datetimelimit ";
                $objDate = sqlsrv_query($connEducation, $QDate);
                $sumDate = sqlsrv_fetch_array($objDate, SQLSRV_FETCH_ASSOC);

                $DateTimeFix = $sumDate['Datetimelimit'];
                //$DateTimeFix = strtotime($Datetimelimit);
                $Datelimit = $sumDate['Datelimit'];
                $DateFix = str_replace('/', '-', $Datelimit);


                $strSQL = "SELECT TOP (15) dbo.ReqUser.EmpUserID, 
                dbo.ReqUser.EmpUserName, 
                dbo.ReqUser.EmpUserSurname, 
                dbo.ReqUser.EmpUserPosition, 
                dbo.ReqUser.EmpUserSection, 
                dbo.ReqUser.EmpUserDepartment,
                
                EducationSystem.dbo.TrainRecDtl.CreateDate, 
                EducationSystem.dbo.TrainRecDtl.TrainDtlStatus
                FROM dbo.ReqUser 
                INNER JOIN EducationSystem.dbo.TrainRecDtl 
                ON dbo.ReqUser.EmpUserID = EducationSystem.dbo.TrainRecDtl.EmployeeID
                WHERE (EducationSystem.dbo.TrainRecDtl.TrainRecNo = '$ItemReqNo') 
                AND (EducationSystem.dbo.TrainRecDtl.TrainRecDate = '$DateFix 00:00:00') 
                AND (EducationSystem.dbo.TrainRecDtl.TrainDtlStatus <> 0) 
                ORDER BY EducationSystem.dbo.TrainRecDtl.CreateDate DESC";
				
                $NumRecDtlSql = "SELECT CreateDate, TrainDtlStatus
				FROM TrainRecDtl
				WHERE (TrainRecNo = '$ItemReqNo') 
				AND (TrainRecDate = '$DateFix 00:00:00') 
				AND (TrainDtlStatus <> 0)
				ORDER BY CreateDate DESC";

                $RegiSingParams = array();
                $RegiSingOptions =  array("Scrollable" => SQLSRV_CURSOR_KEYSET);
                $RegiSingStmt = sqlsrv_query($connEducation, $NumRecDtlSql, $RegiSingParams, $RegiSingOptions);
                $RegiRow_count = sqlsrv_num_rows($RegiSingStmt);

                if ($RegiRow_count > 0) {

                    $SingObjQuery = sqlsrv_query($connRequest, $strSQL);
                    $SingObResult = sqlsrv_fetch_array($SingObjQuery, SQLSRV_FETCH_ASSOC);

                    $TimePresent = date_format($SingObResult["CreateDate"], 'Y-m-d H:i:s');
                    $Change = "SELECT datediff(s, '$TimePresent' , '$DateTimeFix') AS TimeMOve";
                    $ChangeTime = sqlsrv_query($connEducation, $Change);
                    $sumChange = sqlsrv_fetch_array($ChangeTime, SQLSRV_FETCH_ASSOC);
                    $ResultMove = $sumChange['TimeMOve'];

                    if ($ResultMove <= 30) {
                ?>
                        <img class="card-img-top" src="../img/photo_emp/rectangle/<?php echo $SingObResult["EmpUserID"]; ?>.jpg" alt="Image">
                        <div class="card-body">
                            <small>ID:</small>
                            <h5 class="card-title"><?php echo $SingObResult["EmpUserID"]; ?></h5>
                            <small>Name:</small>
                            <h5 class="card-title text-uppercase"><?php echo $SingObResult["EmpUserName"]; ?></h5>
                            <small>Surname:</small>
                            <h5 class="card-title text-uppercase"><?php echo $SingObResult["EmpUserSurname"]; ?></h5>
                            <hr>
                            <div class='alert alert-success text-center' role='alert'>Registered <i class='far fa-laugh-wink'></i></div>
                        </div>
                    <?php
                    } else {
                    ?>
                        <img class="card-img-top" src="assets/img/icon/card_spin.gif" alt="Image">
                        <div class="card-body">
                            <small>ID:</small>
                            <h5 class="card-title">-</h5>
                            <small>Name:</small>
                            <h5 class="card-title">-</h5>
                            <small>Surname:</small>
                            <h5 class="card-title">-</h5>
                            <hr>
                            <div class='alert alert-secondary text-center' role='alert'>Employee card.</div>
                        </div>
                    <?php
                    }
                } else {
                    ?>
                    <img class="card-img-top" src="assets/img/icon/card_spin.gif" alt="Image">
                    <div class="card-body">
                        <small>ID:</small>
                        <h5 class="card-title">-</h5>
                        <small>Name:</small>
                        <h5 class="card-title">-</h5>
                        <small>Surname:</small>
                        <h5 class="card-title">-</h5>
                        <hr>
                        <div class='alert alert-secondary text-center' role='alert'>Employee card.</div>
                    </div>
                <?php } ?>
            </div>
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Participants
                    <span class="badge badge-warning badge-pill"><?php echo $RegiRow_count; ?></span>
                </li>
            </ul>
        </div>

        <div class="col-lg-9 mb-4">
            <div class="table-wrapper-scroll-y my-custom-scrollbar">
                <div class="table-responsive">
                    <table class="table nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">ID</th>
                                <th scope="col">Name/Surname</th>
                                <th scope="col">Joined on</th>
                                <th scope="col" class="text-center">Images</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            /*$strSQL = "SELECT TOP (8) dbo.ReqUser.EmpUserID, 
                      dbo.ReqUser.EmpUserName, 
                      dbo.ReqUser.EmpUserSurname, 
                      dbo.ReqUser.EmpUserPosition, 
                      dbo.ReqUser.EmpUserSection, 
                      dbo.ReqUser.EmpUserDepartment,
                      
                      EducationSystem.dbo.TrainRecDtl.CreateDate, 
                      EducationSystem.dbo.TrainRecDtl.TrainDtlStatus
                      FROM dbo.ReqUser 
                      INNER JOIN EducationSystem.dbo.TrainRecDtl 
                      ON dbo.ReqUser.EmpUserID = EducationSystem.dbo.TrainRecDtl.EmployeeID
                      WHERE (EducationSystem.dbo.TrainRecDtl.TrainRecNo = '$ItemReqNo') 
                      AND (EducationSystem.dbo.TrainRecDtl.TrainRecDate = '$Datelimit 00:00:00') 
                      AND (EducationSystem.dbo.TrainRecDtl.TrainDtlStatus <> 0) 
                      ORDER BY EducationSystem.dbo.TrainRecDtl.CreateDate DESC";

                            $RegiTableParams = array();
                            $RegiTableOptions =  array("Scrollable" => SQLSRV_CURSOR_KEYSET);
                            $RegiTableStmt = sqlsrv_query($connRequest, $strSQL, $RegiTableParams, $RegiTableOptions);
                            $RegiTableRow_count = sqlsrv_num_rows($RegiTableStmt);*/

                            if ($RegiRow_count > 0) {
                                $i = 1;
                                $RegiTableObjQuery = sqlsrv_query($connRequest, $strSQL);
                                while ($RegiTableObResult = sqlsrv_fetch_array($RegiTableObjQuery, SQLSRV_FETCH_ASSOC)) {

                            ?>
                                    <tr>
                                        <th scope="row"><?php echo $i++; ?>)</th>
                                        <td><?php echo $RegiTableObResult["EmpUserID"]; ?></td>
                                        <td>
                                            <div><?php echo $RegiTableObResult["EmpUserName"]; ?></div>
                                            <div><?php echo $RegiTableObResult["EmpUserSurname"]; ?></div>
                                        </td>
                                        <td>
                                            <div><?php echo date_format($RegiTableObResult["CreateDate"], 'd/m/Y'); ?></div>
                                            <div><?php echo date_format($RegiTableObResult["CreateDate"], 'H:i:s'); ?></div>
                                        </td>
                                        <td class="text-center">
                                            <img class="img-fluid img-thumbnail" src="../img/photo_emp/rectangle/<?php echo $RegiTableObResult["EmpUserID"]; ?>.jpg" width="80" height="60" alt="Images">
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="4" class="text-center">No matching records found</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php
}

?>