<!--<%@ Page Language="vb" AutoEventWireup="false" CodeBehind="index.aspx.vb" Inherits="prinfo.index" %>-->

<?php

  include "alert/alert_session.php";
  if(isset($SesUserID, $SesState, $SesAuthor)) {
	header("location:e_planing-plan/");
	exit();	
  }

?>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <?php include ('../title.php') ;?>

  <link href="../tools/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style-login.css" rel="stylesheet">

  <script src="../tools/jquery/jquery.min.js"></script>
  <script src="../tools/bootstrap/js/bootstrap.min.js"></script>

</head>

  <body class="text-center">