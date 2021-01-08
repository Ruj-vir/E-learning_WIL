<?php
    include "alert/alert_session.php";
    include "../database/conn_sqlsrv.php";
    //include "../database/conn_odbc.php";
    include "../database/conn_mysql.php";
    include "alert/alert_user.php";
    include "alert/data_detail.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />

        <title>E-Education</title>
        <link rel="icon" href="../img/icon/e_smart.ico" type="image/x-icon">

        <link href="assets/css/styles.css" rel="stylesheet" />
        <link href="assets/font-standard/css/font-standard.css" rel="stylesheet">
        <link href="assets/css/styles-customs.css" rel="stylesheet" />
		
    </head>
	
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-light bg-light">
            <a class="navbar-brand" href="index.php"><strong class="text-greenblue">E-Education</strong></a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
			<!-- Navbar Search-->
            <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">

            </div>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $resultSQL['EmpUserName']; ?></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="profile_user.php">Profile</a>
                        <a class="dropdown-item" href="#">Setting</a>
                        <a class="dropdown-item" href="#">Activity Log</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>

