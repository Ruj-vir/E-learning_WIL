

<?php include "templates/header_login.php";?>

    <div class="cover-container d-flex h-100 p-3 mx-auto flex-column">
      <header class="masthead mb-auto">
        <div class="inner">
          <div class="d-block d-lg-none"><h1 class="masthead-brand">TDA</h1></div>
          <div class="d-none d-lg-block"><h1 class="cover-heading">THAI DAIZO AEROSOL CO., LTD.</h1></div>
        </div>
      </header>

      <main role="main" class="inner cover">

		<div class="d-none d-lg-block">
        <p class="lead">
		  <img class="img-fluid anima1" style="width: 600px; height: 350px;" src="../img/background/anima.png" alt="">
		  <img class="img-fluid anima2" style="width: 600px; height: 350px;" src="../img/background/anima.gif" alt="">
		</p>
		</div>

		<div class="d-block d-lg-none">
        <p class="lead">
		  <img class="img-fluid anima1" style="width: 600px; height: 300px;" src="../img/background/anima.png" alt="">
		  <img class="img-fluid anima2" style="width: 600px; height: 300px;" src="../img/background/anima.gif" alt="">
		</p>
		</div>

        <p class="lead">
          <button type="button" id="BTenter" class="btn btn-secondary btn-lg entry" data-toggle="modal" data-target="#MyModal"><span class="">ENTER</span></button>
        </p>
      </main>

      <footer class="mastfoot mt-auto">
        <div class="inner">
          <p>&copy; 2019 - Thai Daizo Aerosol Co.Ltd</p>
        </div>
      </footer>
    </div>

  <!-- Modal HTML -->
  <div id="MyModal" class="modal fade">
	<div class="modal-dialog modal-login modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
        <div class="avatar"><img class="img-fluid" style="width: 100px; height: 75px;" src="../img/icon/home/bos.png" alt=""></div>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<form action="check/check_login.php" autocomplete="off" method="post" target="iframe_target">
					<div class="form-group">
						<input type="text" id="txtUsername" name="txtUsername" class="form-control EngOnly" placeholder="Username" required="required" onchange="TextUser();">
					</div>
					<div class="form-group">
						<input type="password" id="txtPassword" name="txtPassword" class="form-control EngOnly" placeholder="Password" required="required" onchange="TextPass();">
					</div>
					<div class="form-group">
						<input type="submit" class="btn btn-primary btn-block btn-lg" value="Login">
          </div>
          <iframe id="iframe_target" name="iframe_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
				</form>
				<!--<div class="hint-text small"><a href="#">Register?</a></div>-->
			</div>
		</div>
	</div>
  </div>
  
  <!-- Modal HTML -->
  <div id="NewPass" class="modal fade">
	<div class="modal-dialog modal-login modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
        <div class="avatar"><img class="img-fluid" style="width: 100px; height: 75px;" src="../img/icon/home/bos.png" alt=""></div>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<form action="#" id="ChangePass" name="ChangePass" autocomplete="off" method="post" target="iframe_NewPass">
					<div class="form-group">
						<input type="text" id="Username" name="Username" class="form-control EngOnly" placeholder="Username" required="required" readonly>
					</div>
					<div class="form-group">
						<input type="password" id="Current"  name="Current" class="form-control EngOnly" placeholder="Current Password" pattern=".{8,}" title="Please enter at least 8 codes." readonly>
					</div>
					<hr>
					<div class="form-group">
						<input type="password" id="NewPass1"  name="NewPass1" class="form-control EngOnly" placeholder="New password" pattern=".{8,}" title="Please enter at least 8 codes." >
					</div>
					<div class="form-group">
						<input type="password" id="NewPass2" name="NewPass2" class="form-control EngOnly" placeholder="Confirm password" pattern=".{8,}" title="Please enter at least 8 codes." >
					</div>					
					<div class="form-group">
						<div id="error"></div>
					</div>
					<div class="form-group">
						<input type="submit" id="login" name="submit" class="btn btn-primary btn-block btn-lg" value="Update" onclick="return PassCheck();">
					</div>
				<iframe id="iframe_NewPass" name="iframe_NewPass" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
				</form>
				<!--<div class="hint-text small"><a href="#">Register?</a></div>-->
			</div>
		</div>
	</div>
  </div>

<?php include "templates/footer_login.php";?>

