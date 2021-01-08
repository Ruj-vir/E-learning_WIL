<?php
    include "../alert/alert_session.php";
    include "../../database/conn_sqlsrv.php";
    //include "../database/conn_mysql.php";
    include "../alert/alert_user.php";
    include "../alert/data_detail.php";
                    
                    
    header("Content-type:text/html; charset=UTF-8");        
    header("Cache-Control: no-store, no-cache, must-revalidate");       
    header("Cache-Control: post-check=0, pre-check=0", false);
    
    //if(isset($_POST["mySort"])){
    if(isset($_GET["Receive"]) == 1){      
?>         

<div class="row">
  <div class="col-lg-3 md-4">
	<div class="card">
<?php

	$QDate = "SELECT convert(varchar(10), GETDATE(), 111) AS Datelimit";
	$objDate = sqlsrv_query($connCanteen, $QDate);
	$sumDate = sqlsrv_fetch_array($objDate, SQLSRV_FETCH_ASSOC);
	$Datelimit = $sumDate['Datelimit'];
	$Datelimit = str_replace('/', '-', $Datelimit);

	$strSQL = "SELECT TOP (1) dbo.Cnt_TrnDetail.TrnNo, dbo.Cnt_TrnDetail.EmpID, HRSystem.dbo.eEmployee.sEmpFirstName, HRSystem.dbo.eEmployee.sEmpEngFirstName, dbo.Cnt_TrnDetail.Qta_Value, dbo.Cnt_TrnDetail.Status,CONVERT(varchar, dbo.Cnt_TrnDetail.TrnTime, 100) AS CurrentDay,
	DATEDIFF(hour, CONVERT(varchar, dbo.Cnt_TrnDetail.TrnTime, 120), CONVERT(varchar, GETDATE(), 120)) AS Result, CASE WHEN DATEDIFF(hour, CONVERT(varchar, dbo.Cnt_TrnDetail.TrnTime, 120),
	CONVERT(varchar, GETDATE(), 120)) < 8 THEN 'OnTime' ELSE 'Late' END AS shipment, CASE WHEN DATEDIFF(hour, CONVERT(varchar, dbo.Cnt_TrnDetail.TrnTime, 120), CONVERT(varchar, GETDATE(), 120)) < 8 THEN 'OnTime' ELSE 'Late' END AS showemp
	FROM dbo.Cnt_TrnDetail INNER JOIN HRSystem.dbo.eEmployee ON dbo.Cnt_TrnDetail.EmpID = HRSystem.dbo.eEmployee.sEmpID
	WHERE (CASE WHEN DATEDIFF(hour, CONVERT(varchar, dbo.Cnt_TrnDetail.TrnTime, 120), CONVERT(varchar, GETDATE(), 120)) < 8 THEN 'OnTime' ELSE 'Late' END = 'OnTime') AND (dbo.Cnt_TrnDetail.Status = 0 OR
	dbo.Cnt_TrnDetail.Status = 1) AND (dbo.Cnt_TrnDetail.TrnDate = '$Datelimit') AND (dbo.Cnt_TrnDetail.MakeBy = 'Canteen TDP')
	ORDER BY dbo.Cnt_TrnDetail.TrnTime DESC";
	$params = array();
	$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
	$stmt = sqlsrv_query( $connCanteen, $strSQL , $params, $options );
	$row_count = sqlsrv_num_rows( $stmt );
	   
	if($row_count > 0) {

	$objQuery = sqlsrv_query($connCanteen, $strSQL);
    $obResult = sqlsrv_fetch_array($objQuery, SQLSRV_FETCH_ASSOC);

?>

        <img class="card-img-top" src="../img/photo_emp/rectangle/<?php echo $obResult["EmpID"] ;?>.jpg" alt="Image">
        <div class="card-body">
		  <small>ID:</small>
          <h5 class="card-title text-uppercase"><?php echo $obResult["EmpID"] ;?></h5>
		  <small>Name(TH):</small>
          <h5 class="card-title text-uppercase"><?php echo $obResult["sEmpFirstName"] ;?></h5>
		  <small>Name(EN):</small>
          <h5 class="card-title"><?php echo $obResult["sEmpEngFirstName"] ;?></h5>
          <p class="card-text"><h2><span class="badge badge-pay0<?php echo $obResult["Status"] ;?> w-100"><?php echo ($obResult["Qta_Value"] == 20) ? "20 THB" : "No Payment" ;?></span></h2></p>
		</div>
<?php
	}else {
?>
        <img class="card-img-top" src="https://placehold.it/750x500" alt="Image">
        <div class="card-body">
		  <small>ID:</small>
          <h5 class="card-title">-</h5>
		  <small>Name(TH):</small>
          <h5 class="card-title">-</h5>
		  <small>Name(EN):</small>
          <h5 class="card-title">-</h5>
          <p class="card-text"><h2><span class="badge badge-secondary w-100">-</span></h2></p>
		</div>
<?php } ?>
      </div>
  </div>

	<div class="col-lg-9 md-4">
	<div class="table-wrapper-scroll-y my-custom-scrollbar">
      <div class="table-responsive">
		<table class="table nowrap" style="width:100%">
		  <thead>
			<tr>
			  <th scope="col">ID</th>
			  <th scope="col">Name</th>
			  <th scope="col" class="text-center">Bl.QTY</th>
			  <th scope="col" class="text-center">Images</th>
			</tr>
		  </thead>
			<tbody>
<?php

	$strSQL = "SELECT TOP (7) dbo.Cnt_TrnDetail.TrnNo, dbo.Cnt_TrnDetail.EmpID, HRSystem.dbo.eEmployee.sEmpFirstName, HRSystem.dbo.eEmployee.sEmpEngFirstName, dbo.Cnt_TrnDetail.Qta_Value, dbo.Cnt_TrnDetail.Status,CONVERT(varchar, dbo.Cnt_TrnDetail.TrnTime, 100) AS CurrentDay,
	DATEDIFF(hour, CONVERT(varchar, dbo.Cnt_TrnDetail.TrnTime, 120), CONVERT(varchar, GETDATE(), 120)) AS Result, CASE WHEN DATEDIFF(hour, CONVERT(varchar, dbo.Cnt_TrnDetail.TrnTime, 120),
	CONVERT(varchar, GETDATE(), 120)) < 8 THEN 'OnTime' ELSE 'Late' END AS shipment, CASE WHEN DATEDIFF(hour, CONVERT(varchar, dbo.Cnt_TrnDetail.TrnTime, 120), CONVERT(varchar, GETDATE(), 120)) < 8 THEN 'OnTime' ELSE 'Late' END AS showemp
	FROM dbo.Cnt_TrnDetail INNER JOIN HRSystem.dbo.eEmployee ON dbo.Cnt_TrnDetail.EmpID = HRSystem.dbo.eEmployee.sEmpID
	WHERE (CASE WHEN DATEDIFF(hour, CONVERT(varchar, dbo.Cnt_TrnDetail.TrnTime, 120), CONVERT(varchar, GETDATE(), 120)) < 8 THEN 'OnTime' ELSE 'Late' END = 'OnTime') AND (dbo.Cnt_TrnDetail.Status = 0 OR
	dbo.Cnt_TrnDetail.Status = 1) AND (dbo.Cnt_TrnDetail.TrnDate = '$Datelimit') AND (dbo.Cnt_TrnDetail.MakeBy = 'Canteen TDP')
	ORDER BY dbo.Cnt_TrnDetail.TrnTime DESC";
	$params = array();
	$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
	$stmt = sqlsrv_query( $connCanteen, $strSQL , $params, $options );
	$row_count = sqlsrv_num_rows( $stmt );
	   
	if($row_count > 0) {

	$objQuery = sqlsrv_query($connCanteen, $strSQL);
    while ($obResult = sqlsrv_fetch_array($objQuery, SQLSRV_FETCH_ASSOC)) {

?>
			  <tr>
				<th scope="row"><?php echo $obResult["EmpID"] ;?></th>
				<td><div><?php echo $obResult["sEmpFirstName"] ;?></div><div><?php echo $obResult["sEmpEngFirstName"] ;?></div></td>
				<td class="text-center">
					<h5><span class="badge badge-pay0<?php echo $obResult["Status"] ;?>"><?php echo ($obResult["Qta_Value"] == 20) ? "20 THB" : "None" ;?></span></h5>
					<small><?php echo $obResult["CurrentDay"] ;?></small>
				</td>
				<td class="text-center">
				  <img class="img-fluid img-thumbnail" src="../img/photo_emp/rectangle/<?php echo $obResult["EmpID"] ;?>.jpg" width="80" height="60" alt="Images">
				</td>
			  </tr>
<?php
	}
	}else {
?>
			  <tr>
				<td colspan="4" class="text-center">ไม่มีข้อมูลที่ตรงกัน</td>
			  </tr>
<?php } ?>
		  	</tbody>
		</table>
	  </div>
	</div>
	</div>
</div>

<?php
    }

?>