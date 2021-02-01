<?php
    include "../alert/alert_session.php";
    include "../alert/alert_user.php";
    include "../../database/conn_sqlsrv.php";
    //include "../database/conn_odbc.php";
    //include "../../database/conn_mysql.php";
    include "../alert/data_detail.php";



  if(isset($_POST["save"])) {
    if(trim($_POST["inputCheck"]) != NULL) {

        $inputCheck = strip_tags(htmlspecialchars($_POST['inputCheck']));
        $inputId = strip_tags(htmlspecialchars($_POST['inputId']));
        $inputAuthor = strip_tags(htmlspecialchars($_POST['inputAuthor']));
        
        if($inputAuthor == "Verify") {
            $sql = "UPDATE ReqUser SET 
            EduVerify = ? ,
            -- EduApprove = ? ,
            UpdateBy = ? ,
            UpdateDate = GETDATE()
            WHERE EmpUserID = ? ";
            $params = array(NULL, $SesUserID, $inputId);
            $stmt = sqlsrv_query($connRequest, $sql, $params);
            if( $stmt === false ) {
                echo "<script>window.top.window.ResultUpdateRelated('0');</script>";
                exit();
            }else {
                $VerifyNewSql = "UPDATE ReqUser SET 
                EduVerify = ? ,
                UpdateBy = ? ,
                UpdateDate = GETDATE()
                WHERE EmpUserID = ? ";
                $VerifyNewParams = array(NULL, $SesUserID, $inputId);
                $VerifyNewStmt = sqlsrv_query($connRequest, $VerifyNewSql, $VerifyNewParams);
                if( $VerifyNewStmt === false ) {
                    echo "<script>window.top.window.ResultUpdateRelated('0');</script>";
                    exit();
                }else {
                    echo "<script>window.top.window.ResultUpdateRelated('1');</script>";
                    exit();
                }
            }
        }else if ($inputAuthor == "Approve") {

        }else if ($inputAuthor == "Verify-Cost") {

        }else if ($inputAuthor == "Approve-Cost") {

        }else {
            
        }

        //sqlsrv_close($conn);
    }else {
      echo "<script>window.top.window.ResultUpdateRelated('0');</script>";
      exit();
    }
  }else {
    echo "<script>window.close();</script>";
    exit();
  }

?>