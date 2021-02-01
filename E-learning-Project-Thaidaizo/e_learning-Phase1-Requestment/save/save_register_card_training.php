<?php
include "../alert/alert_session.php";
include "../../database/conn_sqlsrv.php";
//include "../database/conn_odbc.php";
//include "../../database/conn_mysql.php";
include "../alert/alert_user.php";
include "../alert/data_detail.php";

if (isset($_POST["InputKeyID"]) != '') {
    if (trim($_POST["InputRFID"]) != NULL) {

        $InputKeyID = strip_tags(htmlspecialchars($_POST['InputKeyID']));
        $InputRFID = strip_tags(htmlspecialchars($_POST['InputRFID']));

        //echo "<script>window.top.window.LoadingResult('1');</script>";
        //! Check DateTime \\
        $InfoSql = "SELECT CONVERT(varchar(10), GETDATE(), 111) AS DateCurrent, 
        CONVERT(varchar(10), GETDATE(), 108) AS TimeCurrent, 
        dbo.RFID_Master.EmpID
        FROM dbo.RFID_Master 
        WHERE (dbo.RFID_Master.RFIDNo = '$InputRFID') 
        AND (dbo.RFID_Master.Status = 1) ";
        $InfoQuery = sqlsrv_query($connCanteen, $InfoSql);
        $InfoResult = sqlsrv_fetch_array($InfoQuery, SQLSRV_FETCH_ASSOC);

        echo $EmpID = $InfoResult['EmpID'];
        $DateCurrent = $InfoResult['DateCurrent'];
        $TimeCurrent = $InfoResult['TimeCurrent'];
        $DateStart = str_replace('/', '-', $DateCurrent);
        $TimeStart = str_replace(':', '', $TimeCurrent);
        //! Check DateTime \\

        if($EmpID != NULL) {
            $AllOpenCountSQL = "SELECT COUNT(DISTINCT TrainRecNo) AS NumRegister FROM TrainRecDtl 
            WHERE (TrainRecNo = '$InputKeyID') 
            AND (EmployeeID = '$EmpID') 
            AND (TrainRecDate = '$DateStart 00:00:00') 
            AND (TrainDtlStatus = 1) ";
            $AllOpenCountQuery = sqlsrv_query($connEducation, $AllOpenCountSQL);
            $AllOpenCountResult = sqlsrv_fetch_array($AllOpenCountQuery, SQLSRV_FETCH_ASSOC);
            $NumAllOpen = $AllOpenCountResult["NumRegister"];
    
            if ($NumAllOpen > 0) {
                echo "<script>window.top.window.TrainingResult('99');</script>";
                exit();
            } else {
                $SaveOneSql = "INSERT INTO TrainRecDtl (TrainRecNo, EmployeeID, TrainRecDate, TrainDtlStatus, CreateBy, CreateDate) 
                VALUES (?, ?, DATEADD(DAY,0,DATEDIFF(DAY,0,GETDATE())), ?, ?, GETDATE())";
                $SaveOneParams = array($InputKeyID, $EmpID, 1, $SesUserID);
                $SaveOneStmt = sqlsrv_query($connEducation, $SaveOneSql, $SaveOneParams);
                if ($SaveOneStmt === false) {
                    //echo ("Error Query [".$SaveOneSql."]");
                    //echo ( print_r( sqlsrv_errors(), true));
                    echo "<script>window.top.window.TrainingResult('98');</script>";
                    exit();
                } else {
                    echo "<script>window.top.window.TrainingResult('1');</script>";
                    exit();
                }
            }
        }else {
            echo "<script>window.top.window.TrainingResult('97');</script>";
            exit();
        }

        //sqlsrv_close($conn);
    } else {
        echo "<script>window.top.window.TrainingResult('0');</script>";
        exit();
    }
} else {
    echo "<script>window.close();</script>";
    exit();
}
