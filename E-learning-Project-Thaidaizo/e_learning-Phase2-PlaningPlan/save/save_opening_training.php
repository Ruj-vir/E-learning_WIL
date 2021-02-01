<?php
    include "../alert/alert_session.php";
    include "../../database/conn_sqlsrv.php";
    //include "../database/conn_odbc.php";
    //include "../../database/conn_mysql.php";
    include "../alert/alert_user.php";
    include "../alert/data_detail.php";



  if(isset($_POST["BttSubmitOpen"]) == '1') {
    if(trim($_POST["inputItemKey"]) != NULL) {

        //echo "<script>window.top.window.LoadingResult('1');</script>";

        $inputItemKey = strip_tags(htmlspecialchars($_POST['inputItemKey']));
        $inputTrainer = strip_tags(htmlspecialchars($_POST['inputTrainer']));
        $inputTrainingType = strip_tags(htmlspecialchars($_POST['inputTrainingType']));
        $inputEvaluation = strip_tags(htmlspecialchars($_POST['inputEvaluation']));

        $inputDateFrom = strip_tags(htmlspecialchars($_POST['inputDateFrom']));
        $inputDateTo = strip_tags(htmlspecialchars($_POST['inputDateTo']));
        $inputLocation = strip_tags(htmlspecialchars($_POST['inputLocation']));
        $inputCourse = strip_tags(htmlspecialchars($_POST['inputCourse']));

        $Sql = "UPDATE ReqInfo SET 
        Status = ? ,
        CreateBy = ? ,
        CreateDate = GETDATE()
        WHERE ReqNo = ? AND Status = ?";
        $Params = array(9, $SesUserID, $inputItemKey, 6);
        $stmt = sqlsrv_query($connRequest, $Sql, $Params);
        if( $stmt === false ) {
            echo "<script>window.top.window.TrainingResult('0');</script>";
            exit();
        }else {
          $SaveOneSql = "INSERT INTO TrainRecHdr (TrainRecNo, TrainRecType, TrainRecEvl, TrainRecTrainer, TrainRecPlace, TrainHdrStatus, CreateBy, CreateDate) VALUES (?, ?, ?, ?, ?, ?, ?, GETDATE() )";
          $SaveOneParams = array($inputItemKey, $inputTrainingType, $inputEvaluation, $inputTrainer, $inputLocation, 1, $SesUserID);
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

        //sqlsrv_close($conn);
    }else {
      echo "<script>window.top.window.TrainingResult('0');</script>";
      exit();
    }
  }else {
    echo "<script>window.close();</script>";
    exit();
  }

?>