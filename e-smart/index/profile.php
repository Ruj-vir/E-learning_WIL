
<?php include "templates/header.php";?>

  <div class="container-fluid p-4">


	<h3>My profile</h3>
	  <div class="row my-3">
		<div class="col-md-6">
		  <ul>
			<li>ID: <?php echo $objResult["EmpUserID"];?></li>
			<li>Name: <?php echo $objResult["EmpUserName"]."\n".$objResult["EmpUserSurname"];?></li>
			<li>Position: <?php echo $OfficeResult["Position"];?></li>
		  </ul>
		</div>
		<div class="col-md-6">
		  <ul>
			<li>Section: <?php echo $OfficeResult["Section"];?></li>
			<li>Department: <?php echo $OfficeResult["Department"];?></li>
			<li>Email: <?php echo $objResult["EmpUserEmail"];?></li>
		  </ul>
		</div>
	  </div>


 <div class="card shadow-lg">
  <div class="card-body">
	<nav>
	  <div class="nav nav-tabs" id="nav-tab" role="tablist">
		<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Change e-mail</a>
		<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Change password</a>
	  </div>
	</nav>
	<div class="tab-content bg-light" id="nav-tabContent">
	  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
		<form id="ChangeMail" name="ChangeMail" action="check/check_mail.php" autocomplete="off" method="post" target="iframe_check_mail" onsubmit="return MailCheck()">
		<div class="p-3">
		  <div class="form-group row">
			<label for="inputNewEmail" class="col-sm-3 col-form-label">Email</label>
			<div class="col-sm-9">
			  <input type="email" class="form-control" id="inputNewEmail" name="inputNewEmail" placeholder="">
			</div>
		  </div>
		  <div class="form-group row">
			<label for="inputConfirmEmail" class="col-sm-3 col-form-label">Confirm Email</label>
			<div class="col-sm-9">
			  <input type="email" class="form-control" id="inputConfirmEmail" name="inputConfirmEmail" placeholder="">
			</div>
		  </div>
		  <div class="form-group row">
			<label for="inputEmai3" class="col-sm-3 col-form-label"></label>
			<div class="col-sm-9">
			  <button type="submit" name="submit" value="1" class="btn btn-primary">Update mail</button>
			</div>
		  </div>
		</div>
		</form>
		<iframe id="iframe_check_mail" name="iframe_check_mail" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
	  </div>

	  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
		<form id="ChangePass" name="ChangePass" action="check/check_pass.php" autocomplete="off" method="post" target="iframe_check_pass" onsubmit="return PassCheck()">
		<div class="p-3">
		  <div class="form-group row">
			<label for="inputCurrent" class="col-sm-3 col-form-label">Current password</label>
			<div class="col-sm-9">
			  <input type="password" class="form-control" id="inputCurrent" name="inputCurrent" placeholder="" required="required">
			</div>
		  </div>
		  <div class="form-group row">
			<label for="inputNewPassword" class="col-sm-3 col-form-label">New password</label>
			<div class="col-sm-9">
			  <input type="password" class="form-control" id="inputNewPassword" name="inputNewPassword" pattern=".{8,}" title="Please enter at least 8 codes." placeholder="">
			</div>
		  </div>
		  <div class="form-group row">
			<label for="inputConfirmPassword" class="col-sm-3 col-form-label">Confirm password</label>
			<div class="col-sm-9">
			  <input type="password" class="form-control" id="inputConfirmPassword" name="inputConfirmPassword" pattern=".{8,}" title="Please enter at least 8 codes." placeholder="">
			</div>
		  </div>
		  <div class="form-group row">
			<label for="inputEmai3" class="col-sm-3 col-form-label"></label>
			<div class="col-sm-9">
			  <button type="submit" name="submit" value="3" class="btn btn-primary">Update pass</button>
			</div>
		  </div>
		</div>
		</form>
		<iframe id="iframe_check_pass" name="iframe_check_pass" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
	  </div>
	</div>
  </div>
 </div>

  </div>

<?php include "templates/footer.php";?>


