<?php
    include "../alert/alert_session.php";
    include "../alert/alert_user.php";
    include "../../database/conn_sqlsrv.php";
    //include "../database/conn_odbc.php";
    //include "../../database/conn_mysql.php";
    include "../alert/data_detail.php";



  if(isset($_POST["save"])) {
    if(trim($_POST["inputEmpID"]) != NULL) {
		
        $sql = "UPDATE ReqUser SET 
        LvApprove = ? ,
        -- EduVerify = ? ,
        -- EduApprove = ?,
        UpdateBy = ? ,
        UpdateDate = GETDATE()
        WHERE EmpUserID = ? ";
        $params = array($_POST["inputCheck"], 
        // $_POST["inputVerify"], $_POST["inputApprove"], 
        $SesUserID, $_POST["inputEmpID"]);

        $stmt = sqlsrv_query($connRequest, $sql, $params);
        if( $stmt === false ) {
            echo "<script>window.top.window.ResultUpdateRelated('0');</script>";
            exit();
        }else {
            echo "<script>window.top.window.ResultUpdateRelated('1');</script>";
            exit();
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