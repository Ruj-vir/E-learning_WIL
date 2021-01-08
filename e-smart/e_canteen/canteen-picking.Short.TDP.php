<?php
	//include ("../database/conn_canteen.php");
	//include ("alert-all.php");
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



  <style type="text/css">
	/*body,html {width: 100%; height: 100%; background: none !important}*/
  body,html {
    width: 100%; 
    height: 100%; 
    /*background-color: #343a40 !important*/
  }
  body {
    background: linear-gradient(to right, #263238, #263238);
  }
  .blackID {
    text-align: center; 
    position: absolute; 
    left: 0; 
    right: 0; 
    top: 15px; 
    z-index: -999; 
    cursor: none; 
    background: linear-gradient(to right, #263238, #263238);
  }
  .invite {
    width: 100%; 
    height: 50px; 
    text-align: center; 
    background: linear-gradient(to right, #263238, #263238);
  }
	/*.invite {width: 100%; height: 50px; color: #1c313a;background-color: #fff;border-radius: 0px;font-size: 24px;text-transform: uppercase;text-align: center; font-weight: 900; letter-spacing: 2px; margin-bottom: 29px; border-radius: 5px;}
	@keyframes flickerAnimation{0%{opacity:1}50%{opacity:0}100%{opacity:1}}@-o-keyframes flickerAnimation{0%{opacity:1}50%{opacity:0}100%{opacity:1}}@-moz-keyframes flickerAnimation{0%{opacity:1}50%{opacity:0}100%{opacity:1}}@-webkit-keyframes flickerAnimation{0%{opacity:1}50%{opacity:0}100%{opacity:1}}.animate_text{-webkit-animation:flickerAnimation 1s infinite;-moz-animation:flickerAnimation 1s infinite;-o-animation:flickerAnimation 1s infinite;animation:flickerAnimation 1s infinite}
  */
  </style>

</head>

<body translate="no" Onload="zoom();">
  <!-- Navigation -->
  <a class="menu-toggle rounded" href="#">
    <i class="fa fa-bars"></i>
  </a>
  <nav id="sidebar-wrapper">
    <ul class="sidebar-nav">

	  <?php include "templates/menu_pinking_tv.php";?>
	  
        <li class="sidebar-nav-item">
          <div class="col-sm-4 col-sm-offset-4">
            <audio controls autoplay loop volume="" id="myAudio" style="width: 220px;">
              <source src="assets/media/sound/piano.mp3" type="audio/mpeg">
            </audio>
          </div>
        </li>
      </ul>
    </nav>
  <!-- ./Navigation -->



  <!-- Header -->
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-6"><h1 class="font-weight-bold text-primary">CANTEEN PICKING <span class="badge badge-primary">TDP</span></h1></div>
      <div class="col-lg-6">
        <!--<span class="btn invite">
        <span class="animate_text"><img class="img-fluid" src="../img/icon/canteen/rfid_line.png" alt="" style="height: 200px;width: 50%"> </span>
        </span>-->
        <span class="btn invite"></span>
        <form class="blackID" id="frmMain" name="frmMain" action="save/checktime.php" autocomplete="off" method="POST" target="iframe_target">
        <input type="password" onkeyup="CopyText();" id="txtRFID" name="txtRFID" maxlength="" required="required" autofocus="autofocus"/>
        <input type="password" id="txtCopy" name="txtCopy" value="" required readonly />
        <input type="password" id="reserve" name="reserve" value="" required readonly />
        <input type="hidden" id="plant" name="plant" value="Canteen TDP" required readonly />
        </form>
      </div>
    </div>
  </div>

  <div class="container-fluid p-0">
	  <div class="card border-0 bg-transparent">
		  <div class="card-body">
        <div id="PickingMain"></div>
		  </div>
	  </div>
  </div>


  <audio id="Okey" src="assets/media/sound/Thank.mp3" type="audio/mpeg"></audio>
  <audio id="alert" src="assets/media/sound/buzzer.mp3" type="audio/mpeg"></audio>
  <audio id="again" src="assets/media/sound/try_again.mp3" type="audio/mpeg"></audio>
  <iframe id="iframe_target" name="iframe_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>

  <!-- ./Header -->

</body>
</html>



  <script src="assets/js/jquery-2.1.3.min.js"></script>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/font-awesome.min.js"></script>
  <script src="assets/js/board.js"></script>

  <script language="JavaScript">
  $(function(){
      setInterval(function(){ // เขียนฟังก์ชัน javascript ให้ทำงานทุก ๆ 30 วินาที
          // 1 วินาที่ เท่า 1000
          // คำสั่งที่ต้องการให้ทำงาน ทุก ๆ 3 วินาที
          var getData = $.ajax({ // ใช้ ajax ด้วย jQuery ดึงข้อมูลจากฐานข้อมูล
                  url:"return/return_pinking_tv_TDP.php",
                  data:"Receive=1",
                  async:false,
                  success:function(getData){
                      $("div#PickingMain").html(getData); // ส่วนที่ 3 นำข้อมูลมาแสดง
                  }
          }).responseText;
      },1000);    
  });
  </script>

  <script language="javascript">

  $(function(){$('#txtRFID').bind('change keyup',function(){
    if (($(this).val().length >= 10) && ($(this).val().value != document.getElementById("reserve").value)) {
      setTimeout(function(){document.frmMain.submit()},0);
  }else if (($(this).val().length >= 10) && ($(this).val().value = document.getElementById("reserve").value)) {
    var alert = document.getElementById("alert").pause();alert.volume = 1.0;
    var again = document.getElementById("again").play();again.volume = 1.0;
    document.getElementById("txtRFID").value = "";
    document.getElementById("reserve").value = "";
    //setTimeout(function(){document.getElementById("reserve").value=""},2000);
  }else {
    setTimeout(function(){document.getElementById("reserve").value=""},2000);
  }
  })});

    function showResult(result) {
    if(result == 1) {
		    var Okey = document.getElementById("Okey").play();Okey.volume = 1.0;
        document.getElementById("txtRFID").value = "";
        document.getElementById("reserve").value = document.getElementById("txtCopy").value;
    }else if(result == 0){
		    var alert = document.getElementById("alert").play();alert.volume = 1.0;
		    document.getElementById("txtRFID").value = "";
		    document.getElementById("reserve").value = document.getElementById("txtCopy").value;
	  }
    else if(result == 4) {
        var again = document.getElementById("again").play();again.volume = 1.0;
        document.getElementById("txtRFID").value = "";
        document.getElementById("reserve").value = document.getElementById("txtCopy").value;
    }
    else{
      //location.reload();
      //window.location.href = 'canteen-picking.TV.TDP.php';
      window.location.href = window.location.href;
      }
    }
    function CopyText() {document.getElementById("txtCopy").value  = document.getElementById("txtRFID").value;}

    $(window).load(function(){
		$(document).ready(function() {
			$("#txtRFID").focus().bind('blur', function() {
				$(this).focus();
			});
			//disable tabindex on elements
			$("input").attr("tabindex", "-1");

			$("html").click(function() {
				$("#txtRFID").val($("#txtRFID").val()).focus();
			});
		});
    });

    function zoom() {
      document.body.style.zoom = "75%";
    }

    var vid = document.getElementById("myAudio");
    vid.volume = 0.001;
    //vid.muted = true;

	/*setInterval(function(){
	  var dt = new Date();
	  var clock_time = dt.getHours() + ":" + dt.getMinutes();
	  if ( clock_time === '00:00' ){
		 location.reload();
		 //window.location.href = '';
	  }
	},59000);*/
  </script>

