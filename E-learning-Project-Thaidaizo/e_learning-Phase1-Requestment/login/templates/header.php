<?php
    include "alert/alert_session.php";
    include "../../database/conn_sqlsrv.php";
    //include "../database/conn_odbc.php";
    //include "../database/conn_mysql.php";
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

        <title>E-Learning</title>
        <link rel="icon" href="../../img/icon/e_smart.ico" type="image/x-icon">
        
        <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
        <link href="../assets/font-standard/css/font-standard.css" rel="stylesheet" />
        <link href="../assets/css/styles-login.css" rel="stylesheet" />
		
    </head>
<body>

    <nav class="navbar navbar-expand navbar-light bg-light shadow static-top">
	<div class="container">
      <a class="navbar-brand" href="index.php"><strong class="text-greenblue">E-Learning</strong></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample02" aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExample02">
        <div class="mr-auto"></div>
        <div class="form-inline my-2 my-md-0">
          <a href="logout.php" class="btn btn-greenblue">Logout <i class="fas fa-sign-out-alt"></i></a>
        </div>
      </div>
    </div>
    </nav>