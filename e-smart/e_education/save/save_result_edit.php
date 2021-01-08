<?php
    include "../alert/alert_session.php";
    include "../../database/conn_sqlsrv.php";
    include "../../database/conn_mysql.php";
    include "../alert/alert_user.php";
    include "../alert/data_detail.php";

if(isset($_POST["submit"])) {
	
	$inputID = strip_tags(htmlspecialchars($_POST['inputID']));
	$inputName = strip_tags(htmlspecialchars($_POST['inputName']));
	$inputDateFrom = strip_tags(htmlspecialchars($_POST['inputDateFrom']));
	$inputTimeFrom = strip_tags(htmlspecialchars($_POST['inputTimeFrom']));
    $inputDateTo = strip_tags(htmlspecialchars($_POST['inputDateTo']));
    $inputTimeTo = strip_tags(htmlspecialchars($_POST['inputTimeTo']));
    $inputStatus = strip_tags(htmlspecialchars($_POST['inputStatus']));
    $inputAutoID = strip_tags(htmlspecialchars($_POST['inputAutoID']));
    
    $DateFrom = $inputDateFrom." ".$inputTimeFrom.":00";
    $DateTo = $inputDateTo." ".$inputTimeTo.":00";

    $SubInfoSql = "UPDATE surveytype SET
            surveytypeKey = '$inputID' ,
            surveytypeMain = '$inputName' ,
            surveyDateFrom = '$DateFrom' ,
            surveyDateTo = '$DateTo' ,
            Status = '$inputStatus' ,
            UpdatedDate = NOW() ,
            UpdatedBy = '$SesUserID'
            WHERE surveytypeId = '$inputAutoID' ";
    $SubInfoStmt = mysqli_query($connBoardcast, $SubInfoSql);

    if($SubInfoStmt === false) {
        echo "<script>window.top.window.ServiceAddResult('0');</script>";
        exit();
    }else{
        echo "<script>window.top.window.ServiceAddResult('1');</script>";
        exit();
    }

    }else {
    echo "<script>window.close();</script>";
    exit();
    }


    //mysqli_close($connBoardcast);
?>