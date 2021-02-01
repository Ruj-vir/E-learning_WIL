<?php
include "../alert/alert_session.php";
include "../alert/alert_user.php";
include "../../database/conn_sqlsrv.php";
//include "../database/conn_odbc.php";
//include "../../database/conn_mysql.php";
include "../alert/data_detail.php";

//echo "<script>window.top.window.LoadingResult('1');</script>";
$inputItemKey = strip_tags(htmlspecialchars($_POST['inputItemKey']));
//$iScore = strip_tags(htmlspecialchars($_POST['iScore']));
$inputEmpID = ((isset($_POST['inputEmpID'])) ? $_POST['inputEmpID'] : NULL);
$inputScore = ((isset($_POST['inputScore'])) ? $_POST['inputScore'] : NULL);
$inputResult = ((isset($_POST['inputResult'])) ? $_POST['inputResult'] : NULL);

foreach ($inputEmpID as $EmpID) {
    $count++;
}
if ($count > 0) {
    if (isset($_POST["BttCourseClosing"]) == "6") {
        foreach ($inputEmpID as $i => $EmpID) {
            // echo $EmpID."<br>";
            // echo $inputScore[$i]."<br>";
            // echo $inputItemKey."<br>";
            // echo $inputResult[$i]."<br>";

            $UpdateDtlSql = "UPDATE TrainRecDtl SET 
            TrainRecScore = ? , 
            TrainRecResult = ? , 
            TrainDtlStatus = ? , 
            UpdateBy = ? , 
            UpdateDate = GETDATE() 
            WHERE TrainRecNo = ? AND EmployeeID = ? AND TrainDtlStatus = ?";
            $UpdateDtlParams = array($inputScore[$i], $inputResult[$i], 6, $SesUserID, $inputItemKey, $EmpID, 3);
            $UpdateDtlStmt = sqlsrv_query($connEducation, $UpdateDtlSql, $UpdateDtlParams);
        }

        if ($UpdateDtlStmt === false) {
            echo "<script>alert('Failed to record employee details.');window.top.window.TrainingResult('0');</script>";
            exit();
        } else {

            $UpdateHdrSql = "UPDATE TrainRecHdr SET 
                TrainHdrStatus = ? , 
                UpdateBy = ? , 
                UpdateDate = GETDATE() 
                WHERE TrainRecNo = ?";
            $UpdateHdrParams = array(3, $SesUserID, $inputItemKey);
            $UpdateHdrStmt = sqlsrv_query($connEducation, $UpdateHdrSql, $UpdateHdrParams);

            if ($UpdateDtlStmt === false) {
                echo "<script>alert('The training topic was not recorded.');window.top.window.TrainingResult('0');</script>";
                exit();
            } else {
                echo "<script>window.top.window.TrainingResult('1');</script>";
                exit();
            }
        }
    }
} else {
    echo "<script>alert('ไม่มีข้อมูลพนักงาน.');window.top.window.TrainingResult('0');</script>";
    exit();
}
