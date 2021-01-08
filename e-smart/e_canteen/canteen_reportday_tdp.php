<?php include "templates/headerAdmin.php"; ?>


<!-- Page Content -->
<div class="container">
	<div class="card">
		<div class="card-header h3">
			<strong>DAILY <span class="badge badge-primary">TDP</span></strong>
		</div>
		<div class="card-body">

			<!-- /* Start Table */ -->
			<div class="form-row">
				<div class="col-md-4">
					<div class="input-group mb-2 mr-sm-2">
						<div class="input-group-prepend">
							<div class="input-group-text">From date:</div>
						</div>
						<input type="datetime-local" class="form-control" id="From" name="From" value="<?php $DateStart = date('Y-m-d');
																										echo $DateStart; ?>" autocomplete="off">
					</div>
				</div>
				<div class="col-md-4">
					<div class="input-group mb-2 mr-sm-2">
						<div class="input-group-prepend">
							<div class="input-group-text">To date:</div>
						</div>
						<input type="datetime-local" class="form-control" id="to" name="to" value="<?php $DateEnd = date('Y-m-d');
																									echo $DateEnd; ?>" autocomplete="off">
					</div>
				</div>
				<div class="col-md-4">
					<div class="input-group mb-2 mr-sm-2">
						<div class="input-group-prepend">
							<div class="input-group-text"><i class="fas fa-search"></i></div>
						</div>
						<input type="text" class="form-control" id="SearchID" placeholder="keyword">
					</div>
				</div>
			</div>

			<div id="purchase_order">

				<?php

				$TimeFromOne = $DateStart . " 04:00";
				$TimeToOne = $DateStart . " 07:00";
				$TimeFromTwo = $DateStart . " 09:00";
				$TimeToTwo = $DateStart . " 14:00";
				$TimeFromThree = $DateStart . " 14:30";
				$TimeToThree = $DateStart . " 18:30";


				$stmtOne = "SELECT COUNT(EmpID) AS SumOne FROM Cnt_TrnDetail WHERE (Status = 3) AND (LEN(EmpID) = 5) AND (MakeBy = 'Canteen TDP') AND (TrnTime BETWEEN '$TimeFromOne' AND '$TimeToOne' )";
				$queryOne = sqlsrv_query($connCanteen, $stmtOne);
				$resultOne = sqlsrv_fetch_array($queryOne, SQLSRV_FETCH_ASSOC);
				$RowCountOne = $resultOne["SumOne"];

				$stmtTwo = "SELECT COUNT(EmpID) AS SumTwo FROM Cnt_TrnDetail WHERE (Status = 3) AND (LEN(EmpID) = 5) AND (MakeBy = 'Canteen TDP') AND (TrnTime BETWEEN '$TimeFromTwo' AND '$TimeToTwo' )";
				$queryTwo = sqlsrv_query($connCanteen, $stmtTwo);
				$resultTwo = sqlsrv_fetch_array($queryTwo, SQLSRV_FETCH_ASSOC);
				$RowCountTwo = $resultTwo["SumTwo"];

				$stmtThree = "SELECT COUNT(EmpID) AS SumThree FROM Cnt_TrnDetail WHERE (Status = 3) AND (LEN(EmpID) = 5)  AND (MakeBy = 'Canteen TDP') AND (TrnTime BETWEEN '$TimeFromThree' AND '$TimeToThree' )";
				$queryThree = sqlsrv_query($connCanteen, $stmtThree);
				$resultThree = sqlsrv_fetch_array($queryThree, SQLSRV_FETCH_ASSOC);
				$RowCountThree = $resultThree["SumThree"];

				//!

				$stmtOneSub = "SELECT COUNT(EmpID) AS SumOne FROM Cnt_TrnDetail WHERE (Status = 3) AND (LEN(EmpID) = 7) AND (MakeBy = 'Canteen TDP') AND (TrnTime BETWEEN '$TimeFromOne' AND '$TimeToOne' )";
				$queryOneSub = sqlsrv_query($connCanteen, $stmtOneSub);
				$resultOneSub = sqlsrv_fetch_array($queryOneSub, SQLSRV_FETCH_ASSOC);
				$RowCountOneSub = $resultOneSub["SumOne"];

				$stmtTwoSub = "SELECT COUNT(EmpID) AS SumTwo FROM Cnt_TrnDetail WHERE (Status = 3) AND (LEN(EmpID) = 7) AND (MakeBy = 'Canteen TDP') AND (TrnTime BETWEEN '$TimeFromTwo' AND '$TimeToTwo' )";
				$queryTwoSub = sqlsrv_query($connCanteen, $stmtTwoSub);
				$resultTwoSub = sqlsrv_fetch_array($queryTwoSub, SQLSRV_FETCH_ASSOC);
				$RowCountTwoSub = $resultTwoSub["SumTwo"];

				$stmtThreeSub = "SELECT COUNT(EmpID) AS SumThree FROM Cnt_TrnDetail WHERE (Status = 3) AND (LEN(EmpID) = 7)  AND (MakeBy = 'Canteen TDP') AND (TrnTime BETWEEN '$TimeFromThree' AND '$TimeToThree' )";
				$queryThreeSub = sqlsrv_query($connCanteen, $stmtThreeSub);
				$resultThreeSub = sqlsrv_fetch_array($queryThreeSub, SQLSRV_FETCH_ASSOC);
				$RowCountThreeSub = $resultThreeSub["SumThree"];

				?>
				<!-- Employee -->
				<fieldset class="border p-2 rounded">
					<legend class="w-auto">Employee</legend>
					<div class="row">
						<div class="col-lg-4 mb-2">
							<div class="card">
								<div class="card-body">
									<div class="d-flex">
										<div class="mr-auto">
											<div class="font-weight-bold h3"><?php echo $RowCountOne; ?></div>
										</div>
										<div>04:00 - 07:00</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 mb-2">
							<div class="card">
								<div class="card-body">
									<div class="d-flex">
										<div class="mr-auto">
											<div class="font-weight-bold h3"><?php echo $RowCountTwo; ?></div>
										</div>
										<div>09:00 - 14:00</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 mb-2">
							<div class="card">
								<div class="card-body">
									<div class="d-flex">
										<div class="mr-auto">
											<div class="font-weight-bold h3"><?php echo $RowCountThree; ?></div>
										</div>
										<div>14:30 - 18:30</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</fieldset>
				<!-- Employee -->

				<!-- Subcontract -->
				<fieldset class="border p-2 rounded">
					<legend class="w-auto">Subcontract</legend>
					<div class="row">
						<div class="col-lg-4 mb-2">
							<div class="card">
								<div class="card-body">
									<div class="d-flex">
										<div class="mr-auto">
											<div class="font-weight-bold h3"><?php echo $RowCountOneSub; ?></div>
										</div>
										<div>04:00 - 07:00</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 mb-2">
							<div class="card">
								<div class="card-body">
									<div class="d-flex">
										<div class="mr-auto">
											<div class="font-weight-bold h3"><?php echo $RowCountTwoSub; ?></div>
										</div>
										<div>09:00 - 14:00</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 mb-2">
							<div class="card">
								<div class="card-body">
									<div class="d-flex">
										<div class="mr-auto">
											<div class="font-weight-bold h3"><?php echo $RowCountThreeSub; ?></div>
										</div>
										<div>14:30 - 18:30</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</fieldset>
				<!-- Subcontract -->

				<div class="row mt-2">
					<div class="col-lg-6 mb-2">
						<ul class="nav nav-pills" id="pills-tab" role="tablist">
							<li class="nav-item">
								<a class="nav-link" href="canteen_reportday_tda.php" role="tab">TDA</a>
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
								<th scope="col">Date.Time</th>
								<th scope="col">QTY</th>
								<th scope="col">Pay</th>
								<th scope="col">Remark</th>
							</tr>
						</thead>
						<tbody class="tbody">
							<?php
							$stmt = "SELECT dbo.Cnt_TrnDetail.TrnNo, dbo.Cnt_TrnDetail.EmpID, HRSystem.dbo.eEmployee.sEmpFirstName, HRSystem.dbo.eEmployee.sEmpLastName, HRSystem.dbo.eEmployee.sEmpEngFirstName,
						   HRSystem.dbo.eEmployee.sEmpEngLastName, dbo.Cnt_TrnDetail.Qta_Qty, dbo.Cnt_TrnDetail.Qta_Value, dbo.Cnt_TrnDetail.TrnTime, dbo.Cnt_TrnDetail.UserDefine1
						   FROM dbo.Cnt_TrnDetail INNER JOIN HRSystem.dbo.eEmployee ON dbo.Cnt_TrnDetail.EmpID = HRSystem.dbo.eEmployee.sEmpID WHERE (dbo.Cnt_TrnDetail.Status = 3) AND (dbo.Cnt_TrnDetail.TrnDate = '$DateStart') AND (dbo.Cnt_TrnDetail.MakeBy = 'Canteen TDP') ORDER BY dbo.Cnt_TrnDetail.TrnTime DESC";
							$query = sqlsrv_query($connCanteen, $stmt);
							while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
							?>
								<tr class="tr">
									<th scope="row"><?php echo $row['EmpID']; ?></th>
									<td class="text-uppercase"><?php echo $row['sEmpEngFirstName'] . "\n" . $row['sEmpEngLastName']; ?></td>
									<td><?php echo date_format($row["TrnTime"], 'd-M-Y H:i'); ?></td>
									<td class="text-right"><?php echo $row["Qta_Qty"]; ?></td>
									<td class="text-right"><?php echo number_format($row["Qta_Value"], 2); ?></td>
									<td><?php echo $row["UserDefine1"]; ?></td>
								</tr>
							<?php
							}
							?>
						</tbody>
						<tfoot>
							<tr>
								<th>&nbsp;</th>
								<th class="text-right"></th>
								<th></th>
								<th class="h5 text-right font-weight-bold"></th>
								<th class="h5 text-right font-weight-bold"></th>
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


<?php include "templates/footer.php"; ?>



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

<script src="assets/js/Ex.calculator.tableDay.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$('#From, #to').on('keyup change', function() {
			var From = $('#From').val();
			var to = $('#to').val();
			if ((From != '' && to != '') && (From <= to)) {
				$.ajax({
					url: "return/return_reportday_tdp.php",
					method: "POST",
					data: {
						From: From,
						to: to
					},
					success: function(data) {
						$('#purchase_order').html("" + $.trim(data) + "");
					}
				});
			} else {
				//alert("There was an error with the date.!!");
			}
		});
	});

	$(document).ready(function() {
		$("#SearchID").on("keyup change", function() {
			var value = $(this).val().toLowerCase();
			$("table.table tbody.tbody tr.tr").filter(function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});
	});
</script>

</body>

</html>