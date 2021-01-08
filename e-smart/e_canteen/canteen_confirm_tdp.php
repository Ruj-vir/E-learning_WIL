<?php include "templates/headerAdmin.php";?>



	<!-- Page Content -->
	<div class="container">
	  <div class="card">
		<div class="card-header h3">
		  <strong>Confirm <span class="badge badge-primary">TDP</span></strong>
		</div>
		<div class="card-body">

		<div id="printbar"></div>

				<form action="save/update_confirm.php" autocomplete="off" method="post" target="iframe_update_confirm">
				
				<div class="d-flex my-2">
				<div class="mr-auto">
					<div class="input-group-text"><span id="select_count">0 Selected</span></div>
				</div>
				<div class="mr-1"><button type="button" id="update_records" class="btn btn-secondary"><i class="fa fa-check-circle"></i> Confirm</button></div>
				<div class="mr-1"><button type="submit" class="btn btn-secondary" name="CancelOrder" onclick="return BttCancel();"><i class="fa fa-times-circle"></i> Cancel</button></div>
				<div><button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#AddConfirm"><i class="fa fa-plus-circle"></i> Add</button></div>
				</div>

				<div class="ConfirmResult"></div>

						 <div class="table-responsive">
						  <table id="CanteenConfirm" class="table table-hover nowrap" style="width:100%">
							<thead>
							  <tr>
								<th>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input" id="select_all">
								  <label class="custom-control-label" for="select_all"></label>
								</div>
								</th>
								<th scope="col">Item number</th>
								<th scope="col">ID</th>
								<th scope="col">Name</th>
								<th scope="col">Date.Time</th>
								<th scope="col">Pay</th>
								<th scope="col">Remark</th>
							  </tr>
							</thead>
							<tbody>
							<?php
							$stmt = "SELECT dbo.Cnt_TrnDetail.TrnNo, dbo.Cnt_TrnDetail.EmpID, HRSystem.dbo.eEmployee.sEmpFirstName, HRSystem.dbo.eEmployee.sEmpLastName, HRSystem.dbo.eEmployee.sEmpEngFirstName,
							HRSystem.dbo.eEmployee.sEmpEngLastName, dbo.Cnt_TrnDetail.Qta_Qty, dbo.Cnt_TrnDetail.Qta_Value, dbo.Cnt_TrnDetail.TrnTime, dbo.Cnt_TrnDetail.UserDefine1, dbo.Cnt_TrnDetail.TrnNo AS Expr1
							FROM dbo.Cnt_TrnDetail INNER JOIN HRSystem.dbo.eEmployee ON dbo.Cnt_TrnDetail.EmpID = HRSystem.dbo.eEmployee.sEmpID WHERE (dbo.Cnt_TrnDetail.Status = 1) AND (dbo.Cnt_TrnDetail.MakeBy = 'Canteen TDP')";
							$query = sqlsrv_query($connCanteen, $stmt);
							while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
							?>
							 <tr id="<?php echo $row['TrnNo'];?>" >
								<td><input type="checkbox" class="emp_confirm pointer" name="TrnNoCancel[]" value="<?php echo $row['TrnNo'];?>" data-emp-id="<?php echo $row['TrnNo'];?>"></td>
							    <td><?php echo $row['TrnNo']; ?></td>
							    <td><?php echo $row['EmpID']; ?></td>
							    <td class="text-uppercase"><?php echo $row['sEmpEngFirstName']."\n".$row['sEmpEngLastName']; ?></td>
								<td><?php echo date_format($row["TrnTime"], 'd-M-Y H:i');?></td>
								<td class="text-right"><?php echo number_format($row["Qta_Value"],2);?></td>
								<td><?php echo $row["UserDefine1"];?></td>
							 </tr>
							<?php }
							$stmt00 = "SELECT SUM(Qta_Value) AS total FROM Cnt_TrnDetail WHERE (Status = 1) AND (MakeBy = 'Canteen TDP')";
							$query00 = sqlsrv_query($connCanteen, $stmt00);
							$row00 = sqlsrv_fetch_array($query00, SQLSRV_FETCH_ASSOC);
							?>
							</tbody>
								<tfoot>
									<tr>
										<th colspan="5" class="text-right text-green h5">Total/list</th>
										<th class="h5 text-right"></th>
										<th></th>
								  </tr>
								  <tr>
										<th colspan="5" class="text-right text-green h4">Total/unconfirmed</th>
										<th class="h4 text-right"><?php echo number_format($row00["total"],2);?></th>
										<th></th>
								  </tr>
								</tfoot>
						  </table>
							<?php
							//sqlsrv_close($conn);
							?>
						 </div>
					</form>
			  </div>
		</div>
	  </div>


<?php include "templates/footer.php";?>

</body>
</html>


<iframe id="iframe_update_confirm" name="iframe_update_confirm" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
<iframe id="iframe_add_transaction" name="iframe_add_transaction" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>


<!-- Modal -->
<div class="modal fade" id="AddConfirm" tabindex="-1" role="dialog" aria-labelledby="ConfirmTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title text-green" id="ConfirmTitle">Add transaction <span class="badge badge-primary">TDP</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
		<form action="save/save_add_transaction.php" autocomplete="off" method="POST" target="iframe_add_transaction">
      	<div class="modal-body">
			<div class="form-row">
					<div class="form-group col-md-6">
					  <label for="inputID">Employee ID</label>
					  <input type="text" class="form-control" id="inputID" name="inputID" required placeholder="" >
					</div>
					<div class="form-group col-md-6"></div>
					<div class="form-group col-md-6">
					  <label for="inputDate">Date</label>
					  <input type="date" class="form-control" id="inputDate" name="inputDate" required placeholder="">
					</div>
					<div class="form-group col-md-6">
					  <label for="inputTime">Time</label>
					  <input type="time" class="form-control" id="inputTime" name="inputTime" required placeholder="">
					</div>

					<div class="form-group col-md-12">
					  <label for="inputDetail">Details</label>
					  <textarea type="text" class="form-control" id="inputDetail" name="inputDetail" rows="3" required placeholder=""></textarea>
					</div>
		  </div>
		  <div class="ConfirmResult"></div>
		</div>
			<div class="modal-footer border-0">
				<button type="submit" name="addlisttdp" class="btn btn-green w-25" onclick="return BttAdd();">Save</button>
			</div>
		</form>
    </div>
  </div>
</div>




  <script type="text/javascript">
	$('document').ready(function() {
		// select all checkbox
		$(document).on('click', '#select_all', function() {
			$(".emp_confirm").prop("checked", this.checked);
			$("#select_count").html($("input.emp_confirm:checked").length+" Selected");
		});
		$(document).on('click', '.emp_confirm', function() {
			if ($('.emp_confirm:checked').length == $('.emp_confirm').length) {
				$('#select_all').prop('checked', true);
			} else {
				$('#select_all').prop('checked', false);
			}
			$("#select_count").html($("input.emp_confirm:checked").length+" Selected");
		});

		// selected records
		jQuery('#update_records').on('click', function(e) {
			var employee = [];
			$(".emp_confirm:checked").each(function() {
				employee.push($(this).data('emp-id'));
			});
			if(employee.length <=0)  {
				alert("Please select an item.");
			}else {
				WRN_PROFILE_UPDATE = "Are you sure you want to confirm "+(employee.length>1?"these":"this")+" row?";
				var checked = confirm(WRN_PROFILE_UPDATE);
				if(checked == true) {
					var selected_values = employee.join(",");
					$.ajax({
						type: "POST",
						url: "save/update_confirm.php",
						cache:false,
						data: 'TrnNo_id='+selected_values,
						success: function(response) {
							// remove deleted employee rows
							//var emp_ids = response.split(",");
							//for (var i=0; i<emp_ids.length; i++ ) {
								//$("#"+emp_ids[i]).remove();
							//}
							if(response == 1) {
								$(".ConfirmResult").html("<div class='alert alert-success' role='alert'>Successfully</div>");
								setInterval('window.location.href = "canteen_confirm_tda.php"', 1000);
							}else {
								$(".ConfirmResult").html("<div class='alert alert-danger' role='alert'>Error Unsuccessful</div>");
							}
						}
					});
				}
			}
		});
	});
  </script>










  <link href="assets/dataTable/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="assets/dataTable/export/buttons.bootstrap4.min.css" rel="stylesheet">
  
  <script src="assets/dataTable/jquery.dataTables.min.js"></script>
  <script src="assets/dataTable/dataTables.bootstrap4.min.js"></script>

  <script src="assets/dataTable/export/dataTables.buttons.min.js"></script>
  <script src="assets/dataTable/export/buttons.bootstrap4.min.js"></script>
  <script src="assets/dataTable/export/jszip.min.js"></script>
  <!--<script src="../tools/dataTable/export/pdfmake.min.js"></script>-->
  <script src="assets/dataTable/export/vfs_fonts.js"></script>
  <script src="assets/dataTable/export/buttons.html5.min.js"></script>
  <script src="assets/dataTable/export/buttons.print.min.js"></script>
  <script src="assets/dataTable/export/buttons.colVis.min.js"></script>

  <script src="assets/js/Ex.calculator.Confirm.js"></script>



  <script type="text/javascript">
	/*$(document).ready(function (){
	   var table = $('#canteen').DataTable({
	      'columnDefs': [{
	         'targets': 0,
	         'searchable':false,
	         'orderable':false,
	      }],
	      'order': [1, 'asc'],
		  'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]]
	   });
	});*/

	function CanteenResult(Confirm) {
      if(Confirm == 1) {
    	$(".ConfirmResult").html("<div class='alert alert-success' role='alert'>Successfully</div>");
        setInterval('window.location.href = "canteen_confirm_tda.php"', 1000);
      }else {
    	$(".ConfirmResult").html("<div class='alert alert-danger' role='alert'>Error Unsuccessful</div>");
	  }
    }

	function BttAdd() {
		if(confirm('Are you sure you want to submit the item?')==true){
			return true;
		}else{
			return false;
		}
	}

	function BttCancel() {
		if (!$('.emp_confirm').is(':checked')){
			alert('Please select an item.');
			return false;
		}else if(confirm('Are you sure you want to cancel the item?')==true){
			return true;
		}else{
			return false;
		}
	}
  </script>






























<!-- Modal
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="adjust_title" aria-hidden="true">
	<div class="modal-dialog modal-sm modal-dialog-centered" role="document">
	<div class="modal-content rounded-0">
		<div class="modal-header border-0">
		<h5 class="modal-title" id="adjust_title">EMPLOYEE - DETAIL</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		</div>
		<div class="modal-body">
		<form>
				 <div class="form-row">
					<div class="container-fluid">
					 <div class="row">
						<div class="col-lg-12">
						<div class="form-holder">
						<i class="fa fa-"></i>
						<input type="text" class="form-control" placeholder="Item" id="TrnNo" readonly="readonly">
						</div>
					</div>
						<div class="col-lg-12">
						<div class="form-holder">
						<i class="fa fa-"></i>
						<input type="text" class="form-control" placeholder="Employee ID" id="EmpID" readonly="readonly">
						</div>
					</div>
						<div class="col-lg-12">
						<div class="form-holder">
						<i class="fa fa-"></i>
						<input type="text" class="form-control" placeholder="ID" id="firstName" readonly="readonly">
						</div>
					</div>
						<div class="col-lg-12">
						<div class="form-holder">
						<i class="fa fa-"></i>
						<input type="text" class="form-control" placeholder="Name" id="lastName" readonly="readonly">
						</div>
					</div>

					 </div>
					</div>
				 </div>
		</form>
		</div>
		<div class="modal-footer border-0">
		</div>
	</div>
	</div>
</div>
<script type="text/javascript">
		$(document).ready(function(){
				$(document).on('click','a[data-role=Show]',function(){
					var id  = $(this).data('id');
					var TrnNo  = $('#'+id).children('td[data-target=TrnNo]').text();
					var EmpID  = $('#'+id).children('th[data-target=EmpID]').text();
					var firstName  = $('#'+id).children('td[data-target=firstName]').text();
					//var lastName  = $('#'+id).children('td[data-target=lastName]').text();
					//Show in Modal
					$('#TrnNo').val(TrnNo);
					$('#EmpID').val(EmpID);
					$('#firstName').val(firstName);
					//$('#lastName').val(lastName);
					$('#userId').val(id);
					$('#myModal').modal('toggle');
				});
			});
</script>-->
