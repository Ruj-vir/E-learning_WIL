<?php
    include "../alert/alert_session.php";
    include "../../database/conn_sqlsrv.php";
    //include "../database/conn_odbc.php";
    //include "../../database/conn_mysql.php";
    include "../alert/alert_user.php";
    include "../alert/data_detail.php";



  if(isset($_POST["BttSubmitRegister"]) == '1') {
    if(trim($_POST["inputItemKey"]) != NULL) {

        //echo "<script>window.top.window.LoadingResult('1');</script>";
        //! Check DateTIme \\
        $PeriodQuery = "SELECT convert(varchar(10), GETDATE(), 111) AS DateCurrent, 
        convert(varchar(10), GETDATE(), 108) AS TimeCurrent ";
        $PeriodObj = sqlsrv_query($connRequest, $PeriodQuery);
        $PeriodResult = sqlsrv_fetch_array($PeriodObj, SQLSRV_FETCH_ASSOC);

        $DateCurrent = $PeriodResult["DateCurrent"];
        $TimeCurrent = $PeriodResult["TimeCurrent"];
        $DateStart = str_replace('/', '-', $DateCurrent);
        $TimeStart = str_replace(':', '', $TimeCurrent);
         //! Check DateTIme \\

        $inputItemKey = strip_tags(htmlspecialchars($_POST['inputItemKey']));

        $CheckFileSQL = "SELECT COUNT(DISTINCT TrainRecNo) AS NumCheckFile,PicturePath FROM TrainRecDtl 
        WHERE (TrainRecNo = '$inputItemKey') 
        AND (EmployeeID = '$SesUserID') 
        AND (TrainDtlStatus >= 1) 
        GROUP BY PicturePath";
        $CheckFileQuery = sqlsrv_query($connEducation, $CheckFileSQL);
        $CheckFileResult = sqlsrv_fetch_array($CheckFileQuery, SQLSRV_FETCH_ASSOC);
        $NumCheckFile = $CheckFileResult["NumCheckFile"];
        $PicturePath = $CheckFileResult["PicturePath"];

        if($NumCheckFile > 0) {
          $AllOpenCountSQL = "SELECT COUNT(DISTINCT TrainRecNo) AS NumRegister FROM TrainRecDtl 
          WHERE (TrainRecNo = '$inputItemKey') 
          AND (EmployeeID = '$SesUserID') 
          AND (TrainRecDate = '$DateStart 00:00:00') 
          AND (TrainDtlStatus = 1) ";
          $AllOpenCountQuery = sqlsrv_query($connEducation, $AllOpenCountSQL);
          $AllOpenCountResult = sqlsrv_fetch_array($AllOpenCountQuery, SQLSRV_FETCH_ASSOC);
          $NumAllOpen = $AllOpenCountResult["NumRegister"];
  
          if($NumAllOpen > 0) {
              echo "<script>alert('You have successfully registered');window.top.window.TrainingResult('0');</script>";
              exit();
          }else {
              $SaveOneSql = "INSERT INTO TrainRecDtl (TrainRecNo, EmployeeID, TrainRecDate, PicturePath, TrainDtlStatus, CreateBy, CreateDate) 
              VALUES (?, ?, DATEADD(DAY,0,DATEDIFF(DAY,0,GETDATE())), ?, ?, ?, GETDATE())";
              $SaveOneParams = array($inputItemKey, $SesUserID, $PicturePath, 1, $SesUserID);
              $SaveOneStmt = sqlsrv_query($connEducation, $SaveOneSql, $SaveOneParams);
              if( $SaveOneStmt === false ) {
                  //echo ("Error Query [".$SaveOneSql."]");
                  //echo ( print_r( sqlsrv_errors(), true));
                  echo "<script>window.top.window.TrainingResult('0');</script>";
                  exit();
              }else {
                  echo "<script>window.top.window.TrainingResult('1');</script>";
                  exit();
              }
          }
        }else {
          $AllOpenCountSQL = "SELECT COUNT(DISTINCT TrainRecNo) AS NumRegister FROM TrainRecDtl 
          WHERE (TrainRecNo = '$inputItemKey') 
          AND (EmployeeID = '$SesUserID') 
          AND (TrainRecDate = '$DateStart 00:00:00') 
          AND (TrainDtlStatus = 1) ";
          $AllOpenCountQuery = sqlsrv_query($connEducation, $AllOpenCountSQL);
          $AllOpenCountResult = sqlsrv_fetch_array($AllOpenCountQuery, SQLSRV_FETCH_ASSOC);
          $NumAllOpen = $AllOpenCountResult["NumRegister"];
  
          if($NumAllOpen > 0) {
              echo "<script>alert('You have successfully registered');window.top.window.TrainingResult('0');</script>";
              exit();
          }else {
              $SaveOneSql = "INSERT INTO TrainRecDtl (TrainRecNo, EmployeeID, TrainRecDate, TrainDtlStatus, CreateBy, CreateDate) 
              VALUES (?, ?, DATEADD(DAY,0,DATEDIFF(DAY,0,GETDATE())), ?, ?, GETDATE())";
              $SaveOneParams = array($inputItemKey, $SesUserID, 1, $SesUserID);
              $SaveOneStmt = sqlsrv_query($connEducation, $SaveOneSql, $SaveOneParams);
              if( $SaveOneStmt === false ) {
                  //echo ("Error Query [".$SaveOneSql."]");
                  //echo ( print_r( sqlsrv_errors(), true));
                  echo "<script>window.top.window.TrainingResult('0');</script>";
                  exit();
              }else {
                  echo "<script>window.top.window.TrainingResult('1');</script>";
                  exit();
              }
          }
        }

        //sqlsrv_close($conn);
    }else {
      echo "<script>window.top.window.TrainingResult('0');</script>";
      exit();
    }
  }else {
    echo "<script>window.close();</script>";
    exit();
  }
