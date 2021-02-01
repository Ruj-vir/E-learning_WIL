
<?php
  include "alert/alert_session.php";
  
  if(isset($_SESSION['UserID@Learning']) && isset($_SESSION['Authorize@Learning']) && isset($_SESSION['Status@Learning'])) {
    header("location:register_user.php"); 
    exit();
  }else{
    //header("location:login.php"); 
    //exit();
  } 

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

<div class="container-fluid">
  <div class="row no-gutter">
    <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>
    <div class="col-md-8 col-lg-6">
      <div class="login d-flex align-items-center py-5">
        <div class="container">
          <div class="row">
            <div class="col-md-9 col-lg-8 mx-auto">
              <h3 class="login-heading mb-4">Welcome to <span class="text-greenblue font-weight-bold">e-Learning</span></h3>
              <!--<form autocomplete="off" action="save/save_check_login.php" method="POST" target="#">-->
              <form autocomplete="off" target="iframe_login">
                <div class="form-label-group">
                  <input type="text" id="inputUsername" name="inputUsername" class="form-control" placeholder="Username" required autofocus>
                  <label for="inputUsername">Username</label>
                </div>

                <div class="form-label-group">
                  <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required>
                  <label for="inputPassword">Password</label>
                </div>

                <div id="error"></div>
                <!--<div class="custom-control custom-checkbox mb-3">
                  <input type="checkbox" class="custom-control-input" id="customCheck1">
                  <label class="custom-control-label" for="customCheck1">Remember password</label>
                </div>-->

                <button class="btn btn-lg btn-block btn-greenblue text-uppercase font-weight-bold mb-2" type="submit" id="login">Sign in</button>
                <hr>
                
                <div class="text-center">
                  <a href="https://www.thaidaizo.com/main/e-smart">TDA E-SMART</a>
                </div>

              </form>
              <iframe id="iframe_login" name="iframe_login" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>


<script src="../assets/js/font-awesome.min.js" crossorigin="anonymous"></script>
<script src="../assets/js/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
<script src="../assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>



<script type="text/javascript">
$('#login').click(function(){
  var inputUsername = $('#inputUsername').val();
  var inputPassword = $('#inputPassword').val();
    if(($.trim(inputUsername).length > 0) && ($.trim(inputPassword).length > 0)) {
	  

	    $.ajax({
		url:"save/save_check_login.php",
		method:"POST",
		data:{inputUsername:inputUsername, inputPassword:inputPassword},
		/*cache:false,
		beforeSend:function(){
		 $('#login').val("Loading...");
		},*/
		success:function(data) {
		 if(data == 500) {
			setInterval('window.location.href = "index.php"', 100);
			//$("body").load("home.php").hide().fadeIn(1500);
			//$('#loginModal').hide();  
			//location.reload();
			//window.location.href = ('index.php');
			//alert(data);
		 }else {
			//$('#ChangePass').trigger("reset");
			$('#error').html("<div class='alert alert-danger' role='alert'>Username and Password Incorrect!</div>");
		 }
		}
        });


    }else{
        //document.formRequest.NewPass2.focus();
        $('#error').html("<div class='alert alert-danger' role='alert'>Enter your username and password.</div>");
    }
});
</script>

