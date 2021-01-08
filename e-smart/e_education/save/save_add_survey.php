<?php
    include "../alert/alert_session.php";
    include "../../database/conn_sqlsrv.php";
    include "../../database/conn_mysql.php";
    include "../alert/alert_user.php";
    include "../alert/data_detail.php";


    if(isset($_POST['submit'])){

	$inputID = strip_tags(htmlspecialchars($_POST['inputID']));
	$inputName = strip_tags(htmlspecialchars($_POST['inputName']));
	$inputDateFrom = strip_tags(htmlspecialchars($_POST['inputDateFrom']));
	$inputTimeFrom = strip_tags(htmlspecialchars($_POST['inputTimeFrom']));
    $inputDateTo = strip_tags(htmlspecialchars($_POST['inputDateTo']));
    $inputTimeTo = strip_tags(htmlspecialchars($_POST['inputTimeTo']));
    
    $DateFrom = $inputDateFrom." ".$inputTimeFrom.":00";
    $DateTo = $inputDateTo." ".$inputTimeTo.":00";

    ////////////////////////////////////////////////
    $AssesSql = "SELECT Max(substr(surveytypeId,-4))+1 AS MaxID FROM surveytype";
    $AssesQuery = mysqli_query($connBoardcast, $AssesSql);
    $AssesResult = mysqli_fetch_array($AssesQuery, MYSQLI_ASSOC);
    $newId = $AssesResult["MaxID"];
    if($newId == NULL) { 
        $IDVisitor = "C0001";
    }else {
        $IDVisitor = "C".sprintf("%04d", $newId);
    }
    /////////////////////////////////////////////////
        //$SesUserID
        $ChangeSQL = "INSERT INTO surveytype (surveytypeId,surveytypeKey,surveytypeMain,surveyDateFrom,surveyDateTo,Status,CreatedBy,CreatedDate) 
        VALUES ( '$IDVisitor', '$inputID', '$inputName', '$DateFrom', '$DateTo', '1', '$SesUserID', NOW() )";
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
    echo "<script>window.close();</script>";
    exit();
    }


    //mysqli_close($connBoardcast);
?>