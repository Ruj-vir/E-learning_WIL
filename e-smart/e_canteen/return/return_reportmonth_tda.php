<?php
    include "../alert/alert_session.php";
    include "../../database/conn_sqlsrv.php";
    //include "../database/conn_mysql.php";
    include "../alert/alert_user.php";
    include "../alert/data_detail.php";

// Range.php
if(isset($_POST["From"], $_POST["to"])){

	$vowels1 = array("T");$SendSend1 = str_replace($vowels1,' ', $_POST["From"]);
	$vowels2 = array("T");$SendSend2 = str_replace($vowels2,' ', $_POST["to"]);
	$result = '';
	//$query = "SELECT * FROM View_Picking WHERE TrnDate BETWEEN '".$_POST["From"]."' AND '".$_POST["to"]."'";
	$query = 	"SELECT dbo.Cnt_TrnDetail.EmpID, SUM(CASE WHEN TrnTime BETWEEN '$SendSend1' AND '$SendSend2' THEN Qta_Qty ELSE 0 END) AS 'Qta_Qty', SUM(CASE WHEN TrnTime BETWEEN
'$SendSend1' AND '$SendSend2' THEN Qta_Value ELSE 0 END) AS 'Qta_Value', dbo.Cnt_TrnDetail.Status, HRSystem.dbo.eEmployee.sEmpEngFirstName,
HRSystem.dbo.eEmployee.sEmpEngLastName
FROM dbo.Cnt_TrnDetail INNER JOIN HRSystem.dbo.eEmployee ON dbo.Cnt_TrnDetail.EmpID = HRSystem.dbo.eEmployee.sEmpID
WHERE (dbo.Cnt_TrnDetail.Status = 3) AND (dbo.Cnt_TrnDetail.MakeBy = 'Canteen TDA')
GROUP BY dbo.Cnt_TrnDetail.EmpID, dbo.Cnt_TrnDetail.Status, HRSystem.dbo.eEmployee.sEmpEngFirstName, HRSystem.dbo.eEmployee.sEmpEngLastName";

	$sql = sqlsrv_query($connCanteen, $query);
	$result .='
<div class="row">
	<div class="col-lg-6 mb-2">
		<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
			<li class="nav-item">
			<a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">TDA</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="canteen_reportmonth_tdp.php" role="tab">TDP</a>
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
								</thead><tbody>';
	//if(sqlsrv_num_fields($sql) > 0) {
		while($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)){
			$result .='
		  <tr>
			<th>'.$row["EmpID"].'</th>
			<td class="text-uppercase">'.$row["sEmpEngFirstName"]."\n".$row["sEmpEngLastName"].'</td>
			<td>'.$row["Qta_Qty"].'</td>
			<td>'.$row["Qta_Value"].'</td>
			</tr>';
		}
	$result .='</tbody>
								<tfoot class="">
								  <tr>
									<th>&nbsp;</th>
									<th class="text-right">Total : </th>
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

  <script src="assets/js/Ex.calculator.tableMonth.js"></script>
