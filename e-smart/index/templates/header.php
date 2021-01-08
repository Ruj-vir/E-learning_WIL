<?php
    include "alert/alert_session.php";
    include "../database/conn_sqlsrv.php";
    //include "../database/conn_mysql.php";
    include "alert/alert_user.php";
    include "alert/data_detail.php";
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head runat="server">

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="description" content="">
  <meta name="author" content="">

  <?php include ('../title.php') ;?>

  <link href="../tools/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../tools/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../tools/font-standard/css/font-standard.css" rel="stylesheet">
  <link href="assets/css/style-home.css" rel="stylesheet">
  

</head>

<body id="page-top">


<!-- Vertical navbar -->
<div class="vertical-nav bg-white" id="sidebar">
  <div class="py-4 px-3 mb-4 bg-light">
    <div class="media d-flex align-items-center"><img src="../img/photo_emp/square/<?php echo $SesUserID ;?>.jpg" alt="No picture" width="65" class="mr-3 rounded-circle img-thumbnail shadow-sm">
      <div class="media-body">
        <h4 class="m-0 text-truncate"><?php echo $objResult["EmpUserName"];?></h4>
        <p class="font-weight-light text-muted mb-0 text-truncate"><?php echo $objResult["EmpUserSection"];?></p>
      </div>
    </div>
  </div>

  <p class="text-gray font-weight-bold text-uppercase px-3 small pb-4 mb-0">Main</p>

  <ul class="nav flex-column bg-white mb-0">
    <li class="nav-item">
      <a href="../index" class="nav-link text-dark bg-light">
        <i class="fas fa-home mr-3 text-primary fa-fw"></i>
        Home
      </a>
    </li>
    <li class="nav-item">
      <a href="profile.php" class="nav-link text-dark bg-light">
        <i class="fa fa-user mr-3 text-primary fa-fw"></i>
        Profile
      </a>
    </li>

    <li class="nav-item">
	  <button class="dropdown-btn nav-link text-dark bg-light">
		<i class="fa fa-th-large mr-3 text-primary fa-fw"></i> Control
		<i class="fa fa-caret-down"></i>
	  </button>
	  <div class="dropdown-container">
		<a href="<?php if($SesAuthor == 9){echo '../control';}else{echo '#';}?>" class="drop-sub">E-Request</a>
		<a href="#" class="drop-sub">E-Car</a>
		<a href="#" class="drop-sub">E-Canteen</a>
		<a href="#" class="drop-sub">E-QLO</a>
	  </div>
    </li>
	
    <li class="nav-item">
      <a href="logout.php" class="nav-link text-dark bg-light">
        <i class="fas fa-sign-out-alt mr-3 text-primary fa-fw"></i>
        Logout
      </a>
    </li>
  </ul>

  <p class="text-gray font-weight-bold text-uppercase px-3 small pb-4 mb-0 mt-4">App</p>

  <ul class="nav flex-column bg-white mb-0">
    <li class="nav-item">
      <a href="#app" class="nav-link text-dark bg-light">
        <i class="fa fa-cubes mr-3 text-primary fa-fw"></i>
        Application
      </a>
    </li>
    <li class="nav-item">
      <a href="#contact" class="nav-link text-dark bg-light">
        <i class="far fa-id-card mr-3 text-primary fa-fw"></i>
        Contacts list
      </a>
    </li>
    <li class="nav-item">
      <a href="#cast" class="nav-link text-dark bg-light">
        <i class="fas fa-podcast mr-3 text-primary fa-fw"></i>
        Boardcast
      </a>
    </li>
  </ul>

</div>
<!-- End vertical navbar -->


<!-- Page content holder -->
<div class="page-content" id="content">
  <!-- Toggle button -->
    <nav class="navbar navbar-dark bg-transparent ">
      <button class="navbar-toggler" type="button" id="sidebarCollapse">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="btn-group">
		<a class="navbar-brand font-weight-bold" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">TDA E-SMART</a>
		<div class="dropdown-menu dropdown-menu-right">
		  <a class="dropdown-item" href="#">Setting</a>
		  <a class="dropdown-item" href="#">Activity log</a>
		  <div class="dropdown-divider"></div>
		  <a class="dropdown-item" href="logout.php">Logout</a>
		</div>
      </div>
    </nav>