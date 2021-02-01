<?php
    include "../alert/alert_session.php";
    include "../../database/conn_sqlsrv.php";
    //include "../database/conn_odbc.php";
    //include "../../database/conn_mysql.php";
    include "../alert/alert_user.php";
    include "../alert/data_detail.php";

    //echo "<script>window.top.window.LoadingResult('1');</script>";
    $inputItemKey = strip_tags(htmlspecialchars($_POST['inputItemKey']));
    $inputDate = ((isset($_POST['inputDate'])) ? $_POST['inputDate'] : NULL);
    $inputTrainees = ((isset($_POST['inputTrainees'])) ? $_POST['inputTrainees'] : NULL);



  if(trim($_POST["BttConfirmOpen"]) == "3") {

        foreach($inputTrainees as $i => $iTrainees) {

          $SaveOneSql = "UPDATE TrainRecDtl SET 
          TrainDtlStatus = ?,
          UpdateBy = ? ,
          UpdateDate = GETDATE()
          WHERE TrainRecNo = ? AND EmployeeID = ? AND TrainRecDate = ?";
          $SaveOneParams = array(3, $SesUserID, $inputItemKey, $iTrainees, $inputDate[$i]);
          $SaveOneStmt = sqlsrv_query($connEducation, $SaveOneSql, $SaveOneParams);
		  
        }

        if( $SaveOneStmt === false ) {
            //echo ("Error Query [".$SaveOneSql."]");
            //echo ( print_r( sqlsrv_errors(), true));
            echo "<script>alert('Error Unsuccessful.');window.top.window.TrainingResult('0');</script>";
            exit();
        }else {
            echo "<script>window.top.window.TrainingResult('1');</script>";
            exit();
        }

  }

  if(trim($_POST["BttRejectOpen"]) == "0") {

    foreach($inputTrainees as $i => $iTrainees) {
      
      $SaveOneSql = "UPDATE TrainRecDtl SET 
      TrainDtlStatus = ? ,
      UpdateBy = ? ,
      UpdateDate = GETDATE()
      WHERE TrainRecNo = ? AND EmployeeID = ? AND TrainRecDate = ?";
      $SaveOneParams = array(0, $SesUserID, $inputItemKey, $iTrainees, $inputDate[$i]);
      $SaveOneStmt = sqlsrv_query($connEducation, $SaveOneSql, $SaveOneParams);
	  
    }

    if( $SaveOneStmt === false ) {
        //echo ("Error Query [".$SaveOneSql."]");
        //echo ( print_r( sqlsrv_errors(), true));
        echo "<script>alert('Error Unsuccessful.');window.top.window.TrainingResult('0');</script>";
        exit();
    }else {
        echo "<script>window.top.window.TrainingResult('1');</script>";
        exit();
    }

  }


  //   sqlsrv_close($conn);

  // }else {
  //   echo "<script>window.close();</script>";
  //   exit();
  // }

?>