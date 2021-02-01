<?php
include "../alert/alert_session.php";
include "../alert/alert_user.php";
include "../../database/conn_sqlsrv.php";
//include "../database/conn_odbc.php";
include "../../database/conn_mysql.php";
include "../alert/data_detail.php";


if (isset($_POST["Item_ReqNo"], $_POST["Item_Emp"])) {

    $ItemReqNo = $_POST["Item_ReqNo"];
    $ItemEmp = $_POST["Item_Emp"];

    $output = '';
    $sqler = "SELECT PostReport1,PostReport2,PostReport3,TrainDtlStatus
    FROM TrainRecDtl WHERE (TrainRecNo = '$ItemReqNo') AND (EmployeeID = '$ItemEmp')";
    $resulter = sqlsrv_query($connEducation, $sqler);
    $rower = sqlsrv_fetch_array($resulter, SQLSRV_FETCH_ASSOC);

    $output .= '<p>'.((($rower["PostReport1"]) != NULL) ? $rower["PostReport1"] : 'Topic 1')
    .'</p>
    <hr>
    <p>'.
    ((($rower["PostReport2"]) != NULL) ? $rower["PostReport2"] : 'Topic 2')
    .'</p>
    <hr>
    <p>'.
    ((($rower["PostReport3"]) != NULL) ? $rower["PostReport3"] : 'Topic 3')
    .'</p>';


    echo $output;
}
