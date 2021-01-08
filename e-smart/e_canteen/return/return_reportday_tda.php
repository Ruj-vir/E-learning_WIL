<?php
include "../alert/alert_session.php";
include "../../database/conn_sqlsrv.php";
//include "../database/conn_mysql.php";
include "../alert/alert_user.php";
include "../alert/data_detail.php";


// Range.php
if (isset($_POST["From"], $_POST["to"])) {

	$vowels1 = array("T");
	$SendSend1 = str_replace($vowels1, ' ', $_POST["From"]);
	$vowels2 = array("T");
	$SendSend2 = str_replace($vowels2, ' ', $_POST["to"]);

	//if(($DateFrom == date('Y-m-d H:i:s',strtotime($DateFrom))) && ($DateTo == date('Y-m-d H:i:s',strtotime($DateTo)))) {
	$DateFrom = date('Y-m-d', strtotime($SendSend1));
	$DateTo = date('Y-m-d', strtotime($SendSend2));

	$result = '';
	//$query = "SELECT * FROM View_Picking WHERE TrnDate BETWEEN '".$_POST["From"]."' AND '".$_POST["to"]."'";
	$query = 	"SELECT dbo.Cnt_TrnDetail.TrnNo, dbo.Cnt_TrnDetail.EmpID, HRSystem.dbo.eEmployee.sEmpFirstName, HRSystem.dbo.eEmployee.sEmpLastName, HRSystem.dbo.eEmployee.sEmpEngFirstName,
	HRSystem.dbo.eEmployee.sEmpEngLastName, dbo.Cnt_TrnDetail.Qta_Qty, dbo.Cnt_TrnDetail.Qta_Value, dbo.Cnt_TrnDetail.TrnTime, dbo.Cnt_TrnDetail.Status, dbo.Cnt_TrnDetail.CreatedBy, dbo.Cnt_TrnDetail.UserDefine1
  	FROM dbo.Cnt_TrnDetail 
	INNER JOIN HRSystem.dbo.eEmployee ON dbo.Cnt_TrnDetail.EmpID = HRSystem.dbo.eEmployee.sEmpID 
	WHERE (dbo.Cnt_TrnDetail.Status = 3) 
	AND (dbo.Cnt_TrnDetail.MakeBy = 'Canteen TDA') 
	AND (dbo.Cnt_TrnDetail.TrnTime BETWEEN '$SendSend1' AND '$SendSend2') ORDER BY dbo.Cnt_TrnDetail.TrnTime DESC";
	$sql = sqlsrv_query($connCanteen, $query);

	// $TimeFromOne = $DateFrom . " 04:00";
	// $TimeToOne = $DateTo . " 07:00";

	// $TimeFromTwo = $DateFrom . " 09:00";
	// $TimeToTwo = $DateTo . " 14:00";

	// $TimeFromThree = $DateFrom . " 14:30";
	// $TimeToThree = $DateTo . " 18:30";


	// $stmtOne = "SELECT COUNT(EmpID) AS SumOne FROM Cnt_TrnDetail WHERE (Status = 3) AND (LEN(EmpID) = 5) AND (MakeBy = 'Canteen TDA') AND (TrnTime BETWEEN '$TimeFromOne' AND '$TimeToOne' )";
	// $queryOne = sqlsrv_query($connCanteen, $stmtOne);
	// $resultOne = sqlsrv_fetch_array($queryOne, SQLSRV_FETCH_ASSOC);
	// $RowCountOne = $resultOne["SumOne"];

	// $stmtTwo = "SELECT COUNT(EmpID) AS SumTwo FROM Cnt_TrnDetail WHERE (Status = 3) AND (LEN(EmpID) = 5) AND (MakeBy = 'Canteen TDA') AND (TrnTime BETWEEN '$TimeFromTwo' AND '$TimeToTwo' )";
	// $queryTwo = sqlsrv_query($connCanteen, $stmtTwo);
	// $resultTwo = sqlsrv_fetch_array($queryTwo, SQLSRV_FETCH_ASSOC);
	// $RowCountTwo = $resultTwo["SumTwo"];

	// $stmtThree = "SELECT COUNT(EmpID) AS SumThree FROM Cnt_TrnDetail WHERE (Status = 3) AND (LEN(EmpID) = 5)  AND (MakeBy = 'Canteen TDA') AND (TrnTime BETWEEN '$TimeFromThree' AND '$TimeToThree' )";
	$queryThree = sqlsrv_query($connCanteen, $stmtThree);
	$resultThree = sqlsrv_fetch_array($queryThree, SQLSRV_FETCH_ASSOC);
	$RowCountThree = $resultThree["SumThree"];

	//!

	$stmtOneSub = "SELECT COUNT(EmpID) AS SumOne FROM Cnt_TrnDetail WHERE (Status = 3) AND (LEN(EmpID) = 7) AND (MakeBy = 'Canteen TDA') AND (TrnTime BETWEEN '$TimeFromOne' AND '$TimeToOne' )";
	$queryOneSub = sqlsrv_query($connCanteen, $stmtOneSub);
	$resultOneSub = sqlsrv_fetch_array($queryOneSub, SQLSRV_FETCH_ASSOC);
	$RowCountOneSub = $resultOneSub["SumOne"];

	$stmtTwoSub = "SELECT COUNT(EmpID) AS SumTwo FROM Cnt_TrnDetail WHERE (Status = 3) AND (LEN(EmpID) = 7) AND (MakeBy = 'Canteen TDA') AND (TrnTime BETWEEN '$TimeFromTwo' AND '$TimeToTwo' )";
	$queryTwoSub = sqlsrv_query($connCanteen, $stmtTwoSub);
	$resultTwoSub = sqlsrv_fetch_array($queryTwoSub, SQLSRV_FETCH_ASSOC);
	$RowCountTwoSub = $resultTwoSub["SumTwo"];

	$stmtThreeSub = "SELECT COUNT(EmpID) AS SumThree FROM Cnt_TrnDetail WHERE (Status = 3) AND (LEN(EmpID) = 7)  AND (MakeBy = 'Canteen TDA') AND (TrnTime BETWEEN '$TimeFromThree' AND '$TimeToThree' )";
	$queryThreeSub = sqlsrv_query($connCanteen, $stmtThreeSub);
	$resultThreeSub = sqlsrv_fetch_array($queryThreeSub, SQLSRV_FETCH_ASSOC);
	$RowCountThreeSub = $resultThreeSub["SumThree"];

	$result .= '
<div class="row">
	<div class="col-lg-6 mb-2">
		<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
			<li class="nav-item">
			<a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">TDA</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="canteen_reportday_tdp.php" role="tab">TDP</a>
			</li>
		</ul>
	</div>
	<div class="col-lg-6 mb-2">
		<div id="printbar" style="float:right"></div>
	</div>
</div>



<!-- Employee -->
<fieldset class="border p-2 rounded">
	<legend class="w-auto">Employee</legend>
<div class="row">
<div class="col-md-4">
  <div class="card mb-2">
    <div class="card-body">
	 <div class="d-flex">
	  <div class="mr-auto">
		<div class="font-weight-bold h3">' . $RowCountOne . '</div>
	  </div>
	 <div>04:00 - 07:00</div>
	</div>
    </div>
  </div>
</div>
<div class="col-md-4">
  <div class="card mb-2">
    <div class="card-body">
	 <div class="d-flex">
	  <div class="mr-auto">
		<div class="font-weight-bold h3">' . $RowCountTwo . '</div>
	  </div>
	 <div>09:00 - 14:00</div>
	</div>
    </div>
  </div>
</div>
<div class="col-md-4">
  <div class="card mb-2">
    <div class="card-body">
	 <div class="d-flex">
	  <div class="mr-auto">
		<div class="font-weight-bold h3">' . $RowCountThree . '</div>
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
							<div class="font-weight-bold h3">' . $RowCountOneSub . '</div>
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
							<div class="font-weight-bold h3">' . $RowCountTwoSub . '</div>
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
							<div class="font-weight-bold h3">' . $RowCountThreeSub . '</div>
						</div>
						<div>14:30 - 18:30</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</fieldset>
<!-- Subcontract -->

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
		<tbody class="tbody">';

	while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
		$result .= '
		  <tr class="tr">
			<th>' . $row["EmpID"] . '</th>
			<td class="text-uppercase">' . $row["sEmpEngFirstName"] . "\n" . $row["sEmpEngLastName"] . '</td>
			<td>' . date_format($row["TrnTime"], 'Y-m-d H:i') . '</td>
			<td>' . $row["Qta_Qty"] . '</td>
			<td>' . $row["Qta_Value"] . '</td>
			<td>' . $row["UserDefine1"] . '</td>
		  </tr>';
	}

	$result .= '</tbody>
								<tfoot class="">
								  <tr>
									<th>&nbsp;</th>
									<th class="text-right"></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
								  </tr>
								</tfoot>
	</table></div>';
	echo $result;
}
?>

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