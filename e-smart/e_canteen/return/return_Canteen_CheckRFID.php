<?php
    include "../alert/alert_session.php";
    include "../../database/conn_sqlsrv.php";
    //include "../database/conn_mysql.php";
    include "../alert/alert_user.php";
    include "../alert/data_detail.php";

    
    $InputEmpID = $_POST["InputEmpID"];
    $InputRFID = $_POST["InputRFID"];
  
    if (isset($InputEmpID) && trim($InputRFID) != NULL) {
  
      $FineRFID = strip_tags(htmlspecialchars($InputRFID));
      $FineRFID = trim($FineRFID);
      //$FineDataEmp = addslashes($str);
      $vowels = array("'");
      $FineRFID = str_replace($vowels,'', $FineRFID);

      if(strlen($FineRFID) >= 10){
  
        $CanRegisSql = "SELECT RFIDNo
        FROM RFID_Master WHERE (EmpID = '$InputEmpID') AND (RFIDNo = '$FineRFID') AND (Status = 1)";
        $params = array();
        $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
        $CanRegisObj = sqlsrv_query( $connCanteen, $CanRegisSql , $params, $options );
        $num_rows = sqlsrv_num_rows($CanRegisObj);
        
        if ($num_rows > 0) {
            echo 0;
            exit();
        }else {
          echo 1;
          exit();
        }
        
      }else {
        echo 0;
        exit();
      }


    }


?>