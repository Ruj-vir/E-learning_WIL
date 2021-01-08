<?php include "templates/headerAdmin.php";?>



<?php
	$stmt1 = "SELECT Qta_Date FROM dbo.Cnt_Quota ORDER BY Qta_Date DESC";
	$query1 = sqlsrv_query($connCanteen, $stmt1);
	$result1 = sqlsrv_fetch_array($query1, SQLSRV_FETCH_ASSOC);
?>
	<!-- Page Content -->
	<div class="container">
	  <div class="card shadow-sm">
		<div class="card-header">
		  <div class="d-flex">
			<div class="h3 mr-auto">
			  <strong>Generate <span class="badge badge-info">Subcontract</span></strong>
		  	</div>
			  <div><small class="text-muted">Latest update:</small> <span class="h6 font-weight-bold"><?php echo date_format($result1["Qta_Date"], 'd M. Y H:i:s') ;?></span></div>
		  </div>
		</div>
		<div class="card-body">


<div class="d-flex">
  <div class="mr-auto">
	<div class="input-group">
	  <div class="input-group">
		<div class="input-group-text mr-1"><span class="rows_selected" id="select_count">0 Selected</span></div>
		<button type="button" class="btn btn-green" onclick="return BttAdjust();"><i class="fas fa-money-bill-wave"></i></button>
	  </div>
	</div>
  </div>
  	<div class="mr-1"><button type="button" class="btn btn-green" data-toggle="modal" data-target="#AddUser"><i class="fa fa-plus-circle"></i> Add</button></div>
  	<div><button type="button" class="btn btn-green" data-toggle="modal" data-target="#ChangePlanUser"><i class="fas fa-exchange-alt"></i> Change plant</button></div>
  </div>


	<form action="save/save_generate.php" autocomplete="off" method="POST" target="iframe_generate_many">
		<div class="table-responsive mt-3">
		   <table id="TableGen" class="table table-hover text-truncate nowrap" style="width:100%">
			 <thead>
			  <tr>
				 <th>
				   <div class="custom-control custom-checkbox">
					 <input type="checkbox" class="custom-control-input" id="select_all">
					 <label class="custom-control-label" for="select_all"></label>
				   </div>
				 </th>
				 <th scope="col">ID</th>
				 <th scope="col">Name</th>
				 <th scope="col">Surname</th>
				 <th scope="col">QTY</th>
				 <th scope="col">THB</th>
				 <th scope="col">Remark</th>
			  </tr>
			 </thead>
			 <tbody class="tbody">
			 <?php
$stmt = "SELECT dbo.Cnt_Quota.EmpID, HRSystem.dbo.eEmployee.sEmpFirstName, 
HRSystem.dbo.eEmployee.sEmpLastName, HRSystem.dbo.eEmployee.sEmpEngFirstName, 
HRSystem.dbo.eEmployee.sEmpEngLastName, dbo.Cnt_Quota.Qta_Date, 
dbo.Cnt_Quota.UserDefine1, dbo.Cnt_Quota.Qta_Qty, dbo.Cnt_Quota.Qta_Value
FROM dbo.Cnt_Quota 
INNER JOIN HRSystem.dbo.eEmployee ON dbo.Cnt_Quota.EmpID = HRSystem.dbo.eEmployee.sEmpID
WHERE (LEN(dbo.Cnt_Quota.EmpID) = 7)
ORDER BY dbo.Cnt_Quota.EmpID";
$query = sqlsrv_query($connCanteen, $stmt);
while($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)){
			 ?>
				<tr class="tr">
				 <th><input type="checkbox" class="emp_checkbox pointer" name="EmpID[]" value="<?php echo $result['EmpID'];?>"></th>
				 <th scope="row"><a href="#" class="Amodal" data-id="<?php echo $result["EmpID"];?>"><?php echo $result["EmpID"];?></a></th>
				 <td class="text-uppercase"><?php echo $result["sEmpEngFirstName"];?></td>
				 <td class="text-uppercase"><?php echo $result["sEmpEngLastName"];?></td>
				 <td><?php echo $result["Qta_Qty"];?></td>
				 <td><?php echo number_format($result["Qta_Value"],2); ?></td>
				 <td><?php echo $result["UserDefine1"];?></td><!-- Adjust:  -->
				</tr>
			 <?php
			 }
			 ?>
			</tbody>
		  </table>
		</div>
			<!-- Modal -->
			<div class="modal fade" id="adjust_multi" tabindex="-1" role="dialog" aria-labelledby="Multi_title" aria-hidden="true">
			  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
				<div class="modal-content">
				  <div class="modal-header border-0">
					<h5 class="modal-title text-green" id="Multi_title">Adjust many people</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body">
						<div class="form-row">
						  <div class="container-fluid">
						    <div class="row">
						      <div class="col-lg-12">
								  <div class="form-holder">
									<i class="fa fa-money"></i>
									  <input type="text" id="" name="txtQTY" maxlength="" class="form-control x02" placeholder="QTY" value="" required="required">
								  </div>
							  </div>
							  <div class="col-lg-12">
							   <div class="form-holder">
								   <textarea type="text" id="" name="txtDetail" rows="3" class="form-control x02" placeholder="Detailed.." value="" required="required"></textarea>
								 </div>
							  </div>
						    </div>
						  </div>
						</div>
						<div class="GenerateResult my-2"></div>
				  </div>
					<div class="modal-footer border-0">
					  <button type="submit" name="GeneMulti" class="btn btn-green w-50" onclick="return BttSubmit_AJ();">Save</button>
					</div>
					</div>
				  </div>
				</div>
			</form>



			</div>
	      </div>
		</div>


<?php include "templates/footerDataTable.php";?>



	<!-- Modal -->
	<div class="modal fade" id="adjust_model" tabindex="-1" role="dialog" aria-labelledby="adjust_title" aria-hidden="true">
	  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
		<div class="modal-content">
		  <div class="modal-header border-0">
			<h5 class="modal-title text-green" id="adjust_title">Adjust Single people</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <form action="save/save_generate.php" autocomplete="off" method="POST" target="iframe_generate_single">
		  <div class="modal-body">

				<div class="form-row">
				  <div class="container-fluid">
				    <div class="row">
				      <div class="col-lg-12">
						  <div class="form-holder">
							<i class="fa fa-user"></i>
							<input type="text" id="txtempID" name="txtempID" class="form-control x02" placeholder="ID" value="" readonly="readonly" required="required">
						  </div>
					  </div>
				      <div class="col-lg-12">
						  <div class="form-holder">
							<i class="fa fa-money"></i>
							<input type="text" id="" name="txtQTY" maxlength="" class="form-control x02" placeholder="QTY" value="" required="required">
						  </div>
					  </div>
					  <div class="col-lg-12">
					   <div class="form-holder">
						   <textarea type="text" id="" name="txtDetail" rows="3" class="form-control x02" placeholder="Detailed.." value="" required="required"></textarea>
						 </div>
					  </div>
				    </div>
				  </div>
				</div>
				<div class="GenerateResult my-2"></div>

		  </div>
			<div class="modal-footer border-0">
			  <button type="submit" name="GeneSingle" class="btn btn-green w-50" onclick="return BttSubmit();">Save</button>
			</div>
		  </form>
		</div>
	  </div>
	</div>

<!-- Modal AddUser -->
<div class="modal fade" id="AddUser" tabindex="-1" role="dialog" aria-labelledby="AddUserModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title text-green" id="AddUserModalLongTitle">Add New User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	<form action="save/save_adduser.php" autocomplete="off" method="POST" target="iframe_generate_adduser">
      <div class="modal-body">
				<div class="form-row">
				  <div class="container-fluid">
				    <div class="row">
				      <div class="col-lg-12">
						  <div class="form-holder">
							<i class="fa fa-user"></i>
							<input type="text" id="" name="txtempID" class="form-control x02" placeholder="Employee ID" value="" required="required">
						  </div>
					  </div>
				      <div class="col-lg-12">
						  <div class="form-holder">
							<i class="fa fa-money"></i>
							<input type="text" id="" name="txtQTY" maxlength="" class="form-control x02" placeholder="QTY" value="" required="required">
						  </div>
					  </div>
					  <div class="col-lg-12">
					   <div class="form-holder">
						   <textarea type="text" id="" name="txtDetail" rows="3" class="form-control x02" placeholder="Detailed.." value="" required="required"></textarea>
						 </div>
					  </div>
				    </div>
				  </div>
				</div>
				<div class="GenerateResult my-2"></div> 
      </div>
      <div class="modal-footer border-0">
        <button type="submit" name="AddUser" class="btn btn-green w-50" onclick="return BttSubmit();">Save</button>
      </div>
	</form>
    </div>
  </div>
</div>


<!-- Modal Change Plan -->
<div class="modal fade" id="ChangePlanUser" tabindex="-1" role="dialog" aria-labelledby="ChangePlanModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title text-green" id="ChangePlanModalLongTitle">Change Plant User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	<form action="save/save_change_plane.php" autocomplete="off" method="POST" target="iframe_generate_changeplan">
      <div class="modal-body">
				<div class="form-row">
				  <div class="container-fluid">
				    <div class="row">
				      <div class="col-lg-12">
						<div class="form-holder">
							<i class="fa fa-user"></i>
							<input type="text" id="PlantempID" name="PlantempID" class="form-control x02" placeholder="Employee ID" value="" required="required">
						</div>
					  </div>
				      <div class="col-lg-12">
						<div class="form-holder">
							<i class="fa fa-money"></i>
						  <select class="custom-select" name="Plant" required>
							<option value="">Choose...</option>
							<option value="TDA">TDA</option>
							<option value="TDP">TDP</option>
						  </select>
						</div>
					  </div>
				    </div>
				  </div>
				</div>
				<div class="GenerateResult my-2"></div> 
      </div>
      <div class="modal-footer border-0">
        <button type="submit" name="ChangePlanUser" class="btn btn-green w-50" onclick="return BttSubmit();">Save</button>
      </div>
	</form>
    </div>
  </div>
</div>



<iframe id="iframe_generate_many" name="iframe_generate_many" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
<iframe id="iframe_generate_single" name="iframe_generate_single" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
<iframe id="iframe_generate_adduser" name="iframe_generate_adduser" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
<iframe id="iframe_generate_changeplan" name="iframe_generate_changeplan" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>

<script type="text/javascript">
	function CanteenResult(Generate) {
      if(Generate == 1) {
    	$(".GenerateResult").html("<div class='alert alert-success' role='alert'>Successfully</div>");
        setInterval('window.location.href = "canteen_generate_subcontract.php"', 1000);
      }else {
    	$(".GenerateResult").html("<div class='alert alert-danger' role='alert'>Error Unsuccessful</div>");
	  }
    }
</script>