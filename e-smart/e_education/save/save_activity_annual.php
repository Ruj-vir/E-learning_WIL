<?php
    include "../alert/alert_session.php";
    include "../../database/conn_sqlsrv.php";
    include "../../database/conn_mysql.php";
    include "../alert/alert_user.php";
    include "../alert/data_detail.php";
  
  
    if(isset($_POST['SubmitAddAssess'])){

      $ListUserSQL = "SELECT CreatedBy FROM surveyannual WHERE (CreatedBy = '$SesUserID') AND (Status = 1)";
      $ListUserQuery = mysqli_query($connBoardcast, $ListUserSQL);
      $ListUserResult = mysqli_fetch_array($ListUserQuery, MYSQLI_ASSOC);
  
      if(mysqli_num_rows($ListUserQuery) > 0) {
          echo "<script>window.top.window.ServiceAddResult('101');</script>";
          //echo 0;
          exit();
      }else {

        ////////////////////////////////////////////////
        $AssesSql = "SELECT Max(substr(annualId,-4))+1 AS MaxID FROM surveyannual";
        $AssesQuery = mysqli_query($connBoardcast, $AssesSql);
        $AssesResult = mysqli_fetch_array($AssesQuery, MYSQLI_ASSOC);
        $newId = $AssesResult["MaxID"];
        if($newId == NULL) { 
            $IDVisitor = "C0001";
        }else {
            $IDVisitor = "C".sprintf("%04d", $newId);
        }
        /////////////////////////////////////////////////

        $organize = strip_tags(htmlspecialchars($_POST['organize']));
        $InputReasonDoing = strip_tags(htmlspecialchars($_POST['InputReasonDoing']));
        $InputReasonNotDoing = strip_tags(htmlspecialchars($_POST['InputReasonNotDoing']));
        $choice = strip_tags(htmlspecialchars($_POST['choice']));
        $InputOther = $_POST['InputOther'];
        $inputComment = strip_tags(htmlspecialchars($_POST['inputComment']));

        if(($organize == '1')) {
          $InputReason = $InputReasonDoing;
        }else {
          $InputReason = $InputReasonNotDoing;
        }

        if(trim($choice) == "5") {

            $vowels = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0", ".", "(", ")");
            $nameSend = str_replace($vowels,'', $InputOther);
            $i=0;
            while($i < count($nameSend)) {
              $a++;
                $allname .= $a.".)".$nameSend[$i];
              $i++;
            }
  
                //$SesUserID
                $ChangeSQL = "INSERT INTO surveyannual (annualId,annualTypeOne,annualReasonOne,
                annualTypeTwo,annualReasonTwo,annualComment,
                Status, CreatedBy, CreatedDate) 
                VALUES ('$IDVisitor','$organize','$InputReason',
                '$choice','$allname','$inputComment',
                '1','$SesUserID',NOW() )";
                $ChangeQuery = mysqli_query($connBoardcast, $ChangeSQL);
        
                if(!$ChangeQuery) {
                    echo "<script>window.top.window.ServiceAddResult('0');</script>";
                    //echo 0;
                    exit();
                }else {
                    echo "<script>window.top.window.ServiceAddResult('1');</script>";
                    //echo 1;
                    exit();
                }

        }else {

              $ChangeSQL = "INSERT INTO surveyannual (annualId,annualTypeOne,annualReasonOne,
              annualTypeTwo,annualComment,
              Status, CreatedBy, CreatedDate) 
              VALUES ('$IDVisitor','$organize','$InputReason',
              '$choice','$inputComment',
              '1','$SesUserID',NOW() )";
              $ChangeQuery = mysqli_query($connBoardcast, $ChangeSQL);
      
              if(!$ChangeQuery) {
                  echo "<script>window.top.window.ServiceAddResult('0');</script>";
                  //echo 0;
                  exit();
              }else {
                  echo "<script>window.top.window.ServiceAddResult('1');</script>";
                  //echo 1;
                  exit();
              }

        }

      }

    }else {
      echo "<script>window.close();</script>";
      exit();
    }

  
  //sqlsrv_close($conn);
?>