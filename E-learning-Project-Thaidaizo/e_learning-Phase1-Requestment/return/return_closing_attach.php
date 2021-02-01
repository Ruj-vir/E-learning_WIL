<?php
include "../alert/alert_session.php";
include "../../database/conn_sqlsrv.php";
//include "../database/conn_odbc.php";
include "../../database/conn_mysql.php";
include "../alert/alert_user.php";
include "../alert/data_detail.php";


if (isset($_POST["Item_ReqNo"], $_POST["Item_Emp"])) {

    $ItemReqNo = $_POST["Item_ReqNo"];
    $ItemEmp = $_POST["Item_Emp"];

    $output = '';
    $sqler = "SELECT PicturePath,TrainDtlStatus
    FROM TrainRecDtl WHERE (TrainRecNo = '$ItemReqNo') AND (EmployeeID = '$ItemEmp')";
    $resulter = sqlsrv_query($connEducation, $sqler);
    $rower = sqlsrv_fetch_array($resulter, SQLSRV_FETCH_ASSOC);

    $output .= '
              <div class="embed-responsive embed-responsive-4by3 mb-3">
                <iframe class="embed-responsive-item" src="assets/img/request/' . ((substr($rower["PicturePath"], 18) != NULL) ? $rower["PicturePath"] : 'index.html') . '"  ></iframe>
              </div>
              <a href="assets/img/request/' . ((substr($rower["PicturePath"], 18) != NULL) ? $rower["PicturePath"] : 'index.html') . '" target="_blank"><i class="far fa-window-restore"></i> More..</a> 
  ';
    echo $output;
}
