<?php
include "../alert/alert_session.php";
include "../../../database/conn_sqlsrv.php";
//include "../database/conn_odbc.php";
//include "../../database/conn_mysql.php";
include "../alert/alert_user.php";
include "../alert/data_detail.php";


if (isset($_POST["BttSubmitText"]) == '1') {
    if (trim($_POST["inputPost1"]) != NULL) {

        //echo "<script>window.top.window.LoadingResult('1');</script>";
        //! Check DateTIme \\
        // $PeriodQuery = "SELECT convert(varchar(10), GETDATE(), 111) AS DateCurrent, 
        // convert(varchar(10), GETDATE(), 108) AS TimeCurrent ";
        // $PeriodObj = sqlsrv_query($connRequest, $PeriodQuery);
        // $PeriodResult = sqlsrv_fetch_array($PeriodObj, SQLSRV_FETCH_ASSOC);

        // $DateCurrent = $PeriodResult["DateCurrent"];
        // $TimeCurrent = $PeriodResult["TimeCurrent"];
        // $DateStart = str_replace('/', '-', $DateCurrent);
        // $TimeStart = str_replace(':', '', $TimeCurrent);
        //! Check DateTIme \\

        $inputItemID = strip_tags(htmlspecialchars($_POST['inputItemID']));
        $inputPost1 = strip_tags(htmlspecialchars($_POST['inputPost1']));
        $inputPost2 = strip_tags(htmlspecialchars($_POST['inputPost2']));
        $inputPost3 = strip_tags(htmlspecialchars($_POST['inputPost3']));

        $AttFileCountSQL = "SELECT COUNT(DISTINCT TrainRecNo) AS NumAttFile FROM TrainRecDtl 
        WHERE (TrainRecNo = '$inputItemID') 
        AND (EmployeeID = '$SesUserID') 
        --AND (TrainRecDate = '$DateStart') 
        AND (PostReport1 IS NOT NULL) 
        AND (TrainDtlStatus >= 1) ";
        $AttFileCountQuery = sqlsrv_query($connEducation, $AttFileCountSQL);
        $AttFileCountResult = sqlsrv_fetch_array($AttFileCountQuery, SQLSRV_FETCH_ASSOC);
        $NumAttFile = $AttFileCountResult["NumAttFile"];

        if ($NumAttFile > 0) {
            echo "<script>alert('You have attached this post.');window.top.window.TrainingText('0');</script>";
            exit();
        } else {

            $ImgSql = "UPDATE TrainRecDtl SET 
            PostReport1 = ? ,
            PostReport2 = ? ,
            PostReport3 = ? ,
            UpdateBy = ? ,
            UpdateDate = GETDATE()
            WHERE (TrainRecNo = ?) AND (EmployeeID = ?) AND (TrainDtlStatus >= ?) ";
            $ImgParams = array($inputPost1, $inputPost2, $inputPost3, $SesUserID, $inputItemID, $SesUserID, 1);
            $ImgStmt = sqlsrv_query($connEducation, $ImgSql, $ImgParams);

            if ($ImgStmt == true) {
              echo "<script>window.top.window.TrainingText('1');</script>";
              exit();
            } else {
              //or die ("Error Query [".$SaveOneSql."]");
              //or die( print_r( sqlsrv_errors(), true));
              echo "<script type=text/javascript>alert('Error!! Incorrect information.');window.top.window.TrainingText('0');</script>";
              exit();
            }

        }
    } else {
        echo "<script>window.top.window.TrainingText('0');</script>";
        exit();
    }
} else {
    echo "<script>window.top.window.TrainingText('0');</script>";
    exit();
}
