<?php include "templates/headerAdmin.php";?>

<!-- Page Content -->
<div class="container">

<div class="card shadow-sm">
  <div class="card-header">
	<div class="d-flex">
	  <div class="h3 mr-auto">
		<strong>Register</strong>
	  </div>
	    <div><button type="button" class="btn btn-green" onClick="window.location='canteen_add_card.php';"><i class="fa fa-plus"></i> Add User</button></div>
	</div>
  </div>
  <div class="card-body">

	<form id="ChangeEmp" autocomplete="off">
	  <div class="form-group row">
		  <label for="inputSearchEmp" class="col-sm-9 col-form-label"></label>
		<div class="col-sm-3">
		  <input type="text" class="form-control" id="inputSearchEmp" name="inputSearchEmp" placeholder="Search for..">
		</div>
	  </div>
	</form>


  <div id="Panel_CanteenEmp">
    
	<div class="table-responsive">
	  <table class="table table-hover text-truncate nowrap" style="width:100%">
		<thead>
		  <tr>
			<th scope="col">Name/Surname</th>
			<th scope="col">Office</th>
			<th scope="col">RFID</th>
			<th scope="col">Status</th>
			<th scope="col" class="text-center">Action</th>
		  </tr>
		</thead>
		  <tbody>
			<tr>
			  <td class="text-center" colspan="5">No matching records found</td>
			</tr>
		  </tbody>
	  </table>
	</div>
  </div>
	<div class="py-5"></div>

  </div>



  </div>
</div>
<!-- End Page Content -->



<?php include "templates/footer.php";?>




