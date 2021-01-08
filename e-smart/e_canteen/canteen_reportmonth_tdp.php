<?php include "templates/headerAdmin.php";?>

	<!-- Page Content -->
	<div class="container">
	  <div class="card">
		<div class="card-header h3">
		  <strong>MONTHLY <span class="badge badge-primary">TDP</span></strong>
		</div>
		<div class="card-body">

<div class="row">
<div class="col-lg-6 mb-2">
  <div class="form-group">
    <label for="InputDateForm">Date Form:</label>
    <input type="datetime-local" name="From" id="From" class="form-control" autocomplete="off" />
  </div>
</div>
<div class="col-lg-6 mb-2">
  <div class="form-group">
    <label for="InputDateForm">Date To:</label>
    <input type="datetime-local" name="to" id="to" class="form-control" autocomplete="off" />
  </div>
</div>
</div>


						 <div id="purchase_order">

					 <div class="row">
						 <div class="col-lg-6 mb-2">
							 <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
								 <li class="nav-item">
								 <a class="nav-link" href="canteen_reportmonth_tda.php" role="tab">TDA</a>
								 </li>
								 <li class="nav-item">
								 <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">TDP</a>
								 </li>
							 </ul>
						 </div>
						 <div class="col-lg-6 mb-2">
							 <div id="printbar" style="float:right"></div>
						 </div>
					 </div>

						 	<div class="table-responsive">
							  <table id="canteen_report" class="table table-hover nowrap" style="width:100%">
								<thead>
								  <tr>
									<th scope="col">ID</th>
									<th scope="col">Name</th>
									<th scope="col">QTY</th>
									<th scope="col">THB</th>
								  </tr>
								</thead>
								<tbody>
							<?php
								$stmt = "SELECT dbo.Cnt_TrnDetail.EmpID, SUM(dbo.Cnt_TrnDetail.Qta_Qty) AS 'Qta_Qty', SUM(dbo.Cnt_TrnDetail.Qta_Value) AS 'Qta_Value', dbo.Cnt_TrnDetail.Status, HRSystem.dbo.eEmployee.sEmpEngFirstName,
                         HRSystem.dbo.eEmployee.sEmpEngLastName, dbo.Cnt_TrnDetail.MakeBy, dbo.Cnt_TrnDetail.TrnDate
FROM dbo.Cnt_TrnDetail INNER JOIN HRSystem.dbo.eEmployee ON dbo.Cnt_TrnDetail.EmpID = HRSystem.dbo.eEmployee.sEmpID
GROUP BY dbo.Cnt_TrnDetail.EmpID, dbo.Cnt_TrnDetail.Status, HRSystem.dbo.eEmployee.sEmpEngFirstName, HRSystem.dbo.eEmployee.sEmpEngLastName, dbo.Cnt_TrnDetail.MakeBy, dbo.Cnt_TrnDetail.TrnDate
HAVING (dbo.Cnt_TrnDetail.Status = 3) AND (dbo.Cnt_TrnDetail.MakeBy = 'Canteen TDP') AND (dbo.Cnt_TrnDetail.TrnDate = '".$date."')";
							  $query = sqlsrv_query($connCanteen, $stmt);
							  while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
							?>
							 <tr id="<?php echo $row['EmpID'];?>" >
							    <th data-target="EmpID" scope="row"><a href="#" class="Amodal" data-role="Show" data-id="<?php echo $row['EmpID'] ;?>"><?php echo $row['EmpID']; ?></a></th>
							    <td data-target="firstName" class="text-uppercase"><?php echo $row['sEmpEngFirstName']."\n".$row['sEmpEngLastName']; ?></td>
							    <!--<td data-target="lastName"><?php //echo $row['sEmpEngLastName']; ?></td>-->
									<td><?php echo $row["Qta_Qty"];?></td>
									<td><?php echo number_format($row["Qta_Value"],2); ?></td>
							 </tr>
							<?php } ?>
								</tbody>
								<tfoot class="">
								  <tr>
									<th>&nbsp;</th>
									<th class="text-right"></th>
									<th></th>
									<th></th>
								  </tr>
								</tfoot>
							  </table>
							<?php
							//sqlsrv_close($conn);
							?>
							 </div>
						  </div>



		</div>
	  </div>
	</div>

  
  
<?php include "templates/footer.php";?>



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

  <script src="assets/js/Ex.calculator.tableMonth.js"></script>

	<script type="text/javascript">
		$(document).ready(function(){
		  $('#From, #to').on('keyup change', function(){
			var From = $('#From').val();
			var to = $('#to').val();
	      if((From != '' && to != '') && (From <= to)) {
	        $.ajax({
	          url:"return/return_reportmonth_tdp.php",
	          method:"POST",
	          data:{From:From, to:to},
	          success:function(data)
	          {
	            $('#purchase_order').html( "" + $.trim(data) + "" );
	          }
	        });
	      }else {
	        //alert("There was an error with the date.!!");
	      }
	    });
	  });
	</script>

</body>
</html>














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
			var EmpID  = $('#'+id).children('th[data-target=EmpID]').text();
			var firstName  = $('#'+id).children('td[data-target=firstName]').text();
			//var lastName  = $('#'+id).children('td[data-target=lastName]').text();
			//Show in Modal
			$('#EmpID').val(EmpID);
			$('#firstName').val(firstName);
			//$('#lastName').val(lastName);
			$('#userId').val(id);
			$('#myModal').modal('toggle');
		});
	});
</script>-->
