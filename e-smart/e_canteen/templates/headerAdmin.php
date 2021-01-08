<?php
    include "alert/alert_session.php";
    include "../database/conn_sqlsrv.php";
    //include "../database/conn_mysql.php";
    include "alert/alert_user.php";
	include "alert/data_detail.php";
	
	if(trim($SesUserID) != $UserCanResult["EmpUserID"]){
		echo "<script type=text/javascript>window.location='../index.php';</script>";
		exit();
	}

?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head runat="server">

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="google" value="notranslate">
  <meta name="robots" content="noindex, nofollow">
  <meta name="googlebot" content="noindex, nofollow">

  <?php include "../title.php" ?>

  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/font-awesome/css/all.min.css" rel="stylesheet">
  <link href="assets/css/style-canteen.css" rel="stylesheet">

</head>
<body class="d-flex flex-column bg-index" translate="no" onload="CheckInput()">
  <div id="page-content">


    <?php
	//$strSQL = "SELECT EmpUserID,EmpUserName FROM Cnt_User WHERE EmpUserID = '".$_SESSION['UserID']."' ";
	//$objQuery = sqlsrv_query($conn, $strSQL);
	//$objResult = sqlsrv_fetch_array($objQuery,SQLSRV_FETCH_ASSOC);
    ?>


	<!-- Navigation CANTEEN SYTEM -->
	<nav class="navbar navbar-expand-lg navbar-light bg-light static-top mb-5 shadow-sm">
	  <div class="container">
		<a class="navbar-brand" href=""><span class="sr-only">(current)</span><img class="img-fluid" src="../img/icon/canteen/logo.png" alt=""></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
			  <span class="navbar-toggler-icon"></span>
			</button>
		<div class="collapse navbar-collapse" id="navbarResponsive">
		  <ul class="navbar-nav ml-auto">
			<li class="nav-item active">
			  <a class="nav-link" href="../index.php">Home</a>
			</li>
			<li class="nav-item active-2">
			  <a class="nav-link" href="canteen_register.php">Register</a>
			</li>
			<li class="nav-item dropdown active-3">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Generate
				</a>
				<div class="dropdown-menu dropdown-menu-right animate slideIn" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="canteen_generate_tda.php">TDA</a>
					<a class="dropdown-item" href="canteen_generate_tdp.php">TDP</a>
					<a class="dropdown-item" href="canteen_generate_subcontract.php">Subcontract</a>
				</div>
			</li>
			<li class="nav-item dropdown active-4">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Picking
				</a>
				<div class="dropdown-menu dropdown-menu-right animate slideIn" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="canteen_picking_tda.php">TDA</a>
					<a class="dropdown-item" href="canteen_picking_tdp.php">TDP</a>
				</div>
			</li>
			<li class="nav-item dropdown active-5">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Confirm
				</a>
				<div class="dropdown-menu dropdown-menu-right animate slideIn" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="canteen_confirm_tda.php">TDA</a>
					<a class="dropdown-item" href="canteen_confirm_tdp.php">TDP</a>
				</div>
			</li>
			<li class="nav-item dropdown active-6">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Finalize
				</a>
				<div class="dropdown-menu dropdown-menu-right animate slideIn" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="canteen_reportday_tda.php">Daily</a>
					<a class="dropdown-item" href="canteen_reportmonth_tda.php">Monthly</a>
				</div>
			</li>

			<li class="nav-item dropdown">
			  <button type="button" class="btn btn-green dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<?php echo $resultSQL["EmpUserName"];?>
			  </button>
			  <div class="dropdown-menu dropdown-menu-right animate slideIn" aria-labelledby="navbarDropdown">
				<a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
			  </div>
			</li>
		  </ul>
		</div>
	  </div>
	</nav>
