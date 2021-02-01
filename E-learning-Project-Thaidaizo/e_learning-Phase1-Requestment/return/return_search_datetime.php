<?php
    include "../alert/alert_session.php";
    include "../../database/conn_sqlsrv.php";
    //include "../database/conn_odbc.php";
    include "../../database/conn_mysql.php";
    include "../alert/alert_user.php";
	include "../alert/data_detail.php";
    
    if(isset($_POST["TimeFrom"], $_POST["TimeTo"])) {

        $TimeFrom = trim($_POST["TimeFrom"]);
        $TimeTo = trim($_POST["TimeTo"]);

        $start_date = new DateTime($TimeFrom);
        $since_start = $start_date->diff(new DateTime($TimeTo));
        //$since_start->days.' days total<br>';
        //$since_start->y;
        //$since_start->m;
        //$since_start->d;
        $Hours = $since_start->h;
        $Minute = $since_start->i;
        //$since_start->s;
        $output = $Hours.".".$Minute;
        echo $output;
    }
