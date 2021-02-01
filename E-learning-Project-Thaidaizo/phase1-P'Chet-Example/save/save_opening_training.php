<?php
    include "../alert/alert_session.php";
    include "../alert/alert_user.php";
    include "../../database/conn_sqlsrv.php";
    //include "../database/conn_odbc.php";
    //include "../../database/conn_mysql.php";
    include "../alert/data_detail.php";



  if(trim($_POST["BttSubmitOpen"]) == '1') {
    if(trim($_POST["inputItemKey"]) != NULL) {

        //echo "<script>window.top.window.LoadingResult('1');</script>";

        $inputItemKey = strip_tags(htmlspecialchars($_POST['inputItemKey']));
        $inputTrainer = strip_tags(htmlspecialchars($_POST['inputTrainer']));
        $inputTrainingType = strip_tags(htmlspecialchars($_POST['inputTrainingType']));
        $inputEvaluation = strip_tags(htmlspecialchars($_POST['inputEvaluation']));

        $inputDateFrom = strip_tags(htmlspecialchars($_POST['inputDateFrom']));
        $inputDateTo = strip_tags(htmlspecialchars($_POST['inputDateTo']));

        $inputObject = strip_tags(htmlspecialchars($_POST['inputObject']));
        $inputOrganizer = strip_tags(htmlspecialchars($_POST['inputOrganizer']));
        $inputLocation = strip_tags(htmlspecialchars($_POST['inputLocation']));
        $inputCourse = strip_tags(htmlspecialchars($_POST['inputCourse']));

        $inputTotalDay = strip_tags(htmlspecialchars($_POST['inputTotalDay']));
        $inputTotalHour = strip_tags(htmlspecialchars($_POST['inputTotalHour']));
        $inputCost = strip_tags(htmlspecialchars($_POST['inputCost']));
        $inputPicture = strip_tags(htmlspecialchars($_POST['inputPicture']));

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
          $SaveOneSql = "INSERT INTO TrainRecHdr (
          TrainRecNo, TrainRecType, TrainRecEvl, 
          TrainRecName, TrainRecDateFrom, TrainRecDateTo, 
          TrainRecTrainer, TrainRecPlace, TrainRecObject, TrainRecOrganizer, TrainHdrStatus, 
          TrainRecTotalDay, TrainRecTotalHour, TrainRecCost, PicturePath,
          CreateBy, CreateDate
          ) 
          VALUES (?, ?, ?, 
          ?, ?, ?, 
          ?, ?, ?, ?, ?, 
          ?, ?, ?, ?,
          ?, GETDATE() )";
          $SaveOneParams = array($inputItemKey, $inputTrainingType, $inputEvaluation, 
          $inputCourse, $inputDateFrom, $inputDateTo, 
          $inputTrainer, $inputLocation, $inputObject, $inputOrganizer, 1, 
          $inputTotalDay, $inputTotalHour, $inputCost, $inputPicture,
          $SesUserID);

          $SaveOneStmt = sqlsrv_query($connEducation, $SaveOneSql, $SaveOneParams);
          if( $SaveOneStmt === false ) {
              //die(print_r( sqlsrv_errors(), true));
              //echo ("Error Query [".$SaveOneSql."]");
              echo "<script>window.top.window.TrainingResult('0');</script>";
              //echo 0;
              exit();
          }else {
              echo "<script>window.top.window.TrainingResult('1');</script>";
              //echo 1;
              exit();
          }
        }

        //sqlsrv_close($conn);
    }else {
      echo "<script>window.top.window.TrainingResult('0');</script>";
      exit();
    }

  } else if (trim($_POST["BttSubmitOpen"]) == '0') {

    if(trim($_POST["inputItemKey"]) != NULL) {

      //echo "<script>window.top.window.LoadingResult('1');</script>";

      $inputItemKey = strip_tags(htmlspecialchars($_POST['inputItemKey']));
      $inputReject = strip_tags(htmlspecialchars($_POST['inputReject']));

			$vowels = array("|");
			$SendReject = str_replace($vowels, '', $inputReject);

      $inputDateFrom = strip_tags(htmlspecialchars($_POST['inputDateFrom']));
      $inputDateTo = strip_tags(htmlspecialchars($_POST['inputDateTo']));

      $inputObject = strip_tags(htmlspecialchars($_POST['inputObject']));
      $inputOrganizer = strip_tags(htmlspecialchars($_POST['inputOrganizer']));
      $inputLocation = strip_tags(htmlspecialchars($_POST['inputLocation']));
      $inputCourse = strip_tags(htmlspecialchars($_POST['inputCourse']));

      $inputTotalDay = strip_tags(htmlspecialchars($_POST['inputTotalDay']));
      $inputTotalHour = strip_tags(htmlspecialchars($_POST['inputTotalHour']));
      $inputCost = strip_tags(htmlspecialchars($_POST['inputCost']));
      $inputPicture = strip_tags(htmlspecialchars($_POST['inputPicture']));

      $Sql = "UPDATE ReqInfo SET 
      Status = ? ,
      CreateBy = ? ,
      CreateDate = GETDATE()
      WHERE ReqNo = ? AND Status = ?";
      $Params = array(9, $SesUserID, $inputItemKey, 6);
      $stmt = sqlsrv_query($connRequest, $Sql, $Params);
      if ( $stmt === false ) {
          echo "<script>window.top.window.TrainingResult('0');</script>";
          exit();
      }else {
        $SaveOneSql = "INSERT INTO TrainRecHdr (
        TrainRecNo, UserDefine1,
        TrainRecName, TrainRecDateFrom, TrainRecDateTo, 
        TrainRecPlace, TrainRecObject, TrainRecOrganizer, TrainHdrStatus, 
        TrainRecTotalDay, TrainRecTotalHour, TrainRecCost, PicturePath,
        CreateBy, CreateDate
        ) 
        VALUES (
        ?, ?, 
        ?, ?, ?,
        ?, ?, ?, ?, 
        ?, ?, ?, ?, 
        ?, GETDATE() )";
        $SaveOneParams = array(
        $inputItemKey, $SendReject,
        $inputCourse, $inputDateFrom, $inputDateTo, 
        $inputLocation, $inputObject, $inputOrganizer, 0, 
        $inputTotalDay, $inputTotalHour, $inputCost, $inputPicture,
        $SesUserID);

        $SaveOneStmt = sqlsrv_query($connEducation, $SaveOneSql, $SaveOneParams);
        if( $SaveOneStmt === false ) {
            //die(print_r( sqlsrv_errors(), true));
            //echo ("Error Query [".$SaveOneSql."]");
            echo "<script>window.top.window.TrainingResult('0');</script>";
            //echo 0;
            exit();
        }else {
            echo "<script>window.top.window.TrainingResult('1');</script>";
            //echo 1;
            exit();
        }
      }

      //sqlsrv_close($conn);
  }else {
    echo "<script>window.top.window.TrainingResult('0');</script>";
    exit();
  }

  }

?>