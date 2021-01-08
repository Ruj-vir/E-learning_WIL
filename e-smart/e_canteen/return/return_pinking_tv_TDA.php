<?php
    //include "../alert/alert_session.php";
    include "../../database/conn_sqlsrv.php";
    //include "../database/conn_mysql.php";
    //include "../alert/alert_user.php";
	//include "../alert/data_detail.php";

                    
                    
    header("Content-type:text/html; charset=UTF-8");        
    header("Cache-Control: no-store, no-cache, must-revalidate");       
    header("Cache-Control: post-check=0, pre-check=0", false);
    
    //if(isset($_POST["mySort"])){
    if(isset($_GET["Receive"]) == 1){      

	$QDate = "SELECT convert(nvarchar, GETDATE(), 120) AS Datelimit, convert(nvarchar, GETDATE(), 120) AS Timelimit";
	$objDate = sqlsrv_query($connCanteen, $QDate);
	$sumDate = sqlsrv_fetch_array($objDate, SQLSRV_FETCH_ASSOC);
  	$limit01 = $sumDate['Datelimit'];

	$limit00 = date('Y-m-d', strtotime($limit01));
	$Datelimit = str_replace('/', '-', $limit00);
  	$Today = date('d M. Y H:i:s', strtotime($limit01));

	//$QTime = "SELECT convert(nvarchar, GETDATE(), 120) AS Timelimit";
	//$objTime = sqlsrv_query($connCanteen, $QTime);
	//$sumTime = sqlsrv_fetch_array($objTime,SQLSRV_FETCH_ASSOC);
	$Timelimit = $sumDate['Timelimit'];

	//$strSort = $_POST["mySort"];
	$strSQL = "SELECT TOP (1) CONVERT(nvarchar, dbo.Cnt_TrnDetail.TrnTime, 100) AS CurrentDay, dbo.Cnt_TrnDetail.TrnNo, dbo.Cnt_TrnDetail.EmpID, HRSystem.dbo.eEmployee.sEmpFirstName, HRSystem.dbo.eEmployee.sEmpEngFirstName,
    dbo.Cnt_TrnDetail.Qta_Value, dbo.Cnt_TrnDetail.TrnTime, dbo.Cnt_TrnDetail.MakeBy, dbo.Cnt_TrnDetail.Status
    FROM dbo.Cnt_TrnDetail INNER JOIN HRSystem.dbo.eEmployee ON dbo.Cnt_TrnDetail.EmpID = HRSystem.dbo.eEmployee.sEmpID
		WHERE (dbo.Cnt_TrnDetail.Status = 0 OR dbo.Cnt_TrnDetail.Status = 1 OR dbo.Cnt_TrnDetail.Status = 3) AND (dbo.Cnt_TrnDetail.TrnDate = '$Datelimit') AND (dbo.Cnt_TrnDetail.MakeBy = 'Canteen TDA') ORDER BY dbo.Cnt_TrnDetail.TrnTime DESC";
	$objQuery = sqlsrv_query($connCanteen, $strSQL);
	$obResult = sqlsrv_fetch_array($objQuery,SQLSRV_FETCH_ASSOC);

  $TimeFrom10 = $Datelimit." "."04:00";
  $TimeTo10 = $Datelimit." "."07:00";
  $stmt10 = "SELECT COUNT(EmpID) AS Summer FROM Cnt_TrnDetail WHERE (Status = 1 OR Status = 3) AND (MakeBy = 'Canteen TDA') AND (TrnTime BETWEEN '$TimeFrom10' AND '$TimeTo10')";
  $query10 = sqlsrv_query($connCanteen, $stmt10);
  $result10 = sqlsrv_fetch_array($query10, SQLSRV_FETCH_ASSOC);

  $TimeFrom20 = $Datelimit." "."09:00";
  $TimeTo20 = $Datelimit." "."14:00";
  $stmt20 = "SELECT COUNT(EmpID) AS Summer FROM Cnt_TrnDetail WHERE (Status = 1 OR Status = 3) AND (MakeBy = 'Canteen TDA') AND (TrnTime BETWEEN '".$TimeFrom20."' AND '$TimeTo20')";
  $query20 = sqlsrv_query($connCanteen, $stmt20);
  $result20 = sqlsrv_fetch_array($query20, SQLSRV_FETCH_ASSOC);

  $TimeFrom30 = $Datelimit." "."14:30";
  $TimeTo30 = $Datelimit." "."18:30";
  $stmt30 = "SELECT COUNT(EmpID) AS Summer FROM Cnt_TrnDetail WHERE (Status = 1 OR Status = 3) AND (MakeBy = 'Canteen TDA') AND (TrnTime BETWEEN '".$TimeFrom30."' AND '$TimeTo30')";
  $query30 = sqlsrv_query($connCanteen, $stmt30);
  $result30 = sqlsrv_fetch_array($query30, SQLSRV_FETCH_ASSOC);
?>
<div class="row">
   <div class="col-lg-4">
<?php
	if($obResult["TrnTime"] != NULL){
	$TimePresent = date_format($obResult["TrnTime"], 'Y-m-d H:i:s');
	$Change = "SELECT datediff(s, '$TimePresent' , '$Timelimit') AS TimeMOve";
	$ChangeTime = sqlsrv_query($connCanteen, $Change);
	$sumChange = sqlsrv_fetch_array($ChangeTime,SQLSRV_FETCH_ASSOC);
	$ResultMove = $sumChange['TimeMOve'];

	if($ResultMove <= 30){
?>
					<div class='post-module border rounded-sm mt-2'>
						<div class='thumbnail bg-light'>
						  <div class='date badge-pay0<?php echo $obResult["Status"];?>'>
							<div class='day'>
							  <i class='far fa-thumbs-<?php echo (($obResult["Status"] == 1) || ($obResult["Status"] == 3)) ? 'up' : 'down';?>'></i>
							</div>
						  </div>
						  <img src='../img/photo_emp/rectangle/<?php echo $obResult["EmpID"];?>.jpg' alt='no picture'/>
						</div>
						<div class='post-content'>
						  <div class='category badge-pay0<?php echo $obResult["Status"];?>'><?php echo ($obResult["Qta_Value"] == 20) ? '20 THB' : 'No payment!!';?></div>
							<h1 class='title'><span class='sub_title txt-pay0<?php echo $obResult["Status"];?>'><b>ID:</b> </span><?php echo $obResult["EmpID"];?></h1>
						  <span class='sub_title txt-pay0<?php echo $obResult["Status"];?>'><b>Name<small class='text-muted h6'>(EN)</small>:</b> </span>
							<h1 class='title'><?php echo $obResult["sEmpEngFirstName"];?></h1>
						  <span class='sub_title txt-pay0<?php echo $obResult["Status"];?>'><b>Name<small class='text-muted h6'>(TH)</small>:</b> </span>
							<h1 class='title'><?php echo $obResult["sEmpFirstName"];?></h1>
						  <div class='post-meta'><span class='timestamp'>
						  	<i class="fas fa-clock"></i> <?php echo $obResult["CurrentDay"];?></span>
							<span class='comments'><i class='fa fa-compass'></i> <?php echo $obResult["MakeBy"];?></span>
						  </div>
						</div>
					</div>
          <div style="height: 5px;"></div>
<?php
}else {
?>
<div class='post-module border rounded-sm mt-2'>
	<div class='thumbnail bg-light'>
		<div class='date badge-secondary'>
		<div class='day'>
			<i class='fas fa-laugh-wink font-weight-bold h3'></i>
		</div>
		</div>
		<img src='assets/img/icon/card_spin.gif' style="height: 500px" alt=''/>
	</div>
	<div class='post-content'>
		<div class='category badge-secondary'><span class="">standby mode</span></div>
		<h1 class='title'><span class='sub_title text-secondary'><b>ID:</b> </span>&nbsp;</h1>
		<span class='sub_title text-secondary'><b>Name<small class='text-muted h6'>(EN)</small>:</b> </span>
		<h1 class='title'>&nbsp;</h1>
		<span class='sub_title text-secondary'><b>Name<small class='text-muted h6'>(TH)</small>:</b> </span>
		<h1 class='title'>&nbsp;</h1>
		<div class='post-meta'><span class='timestamp'>
		<i class="fas fa-clock"></i> *******************</span>
		<span class='comments'><i class='fa fa-compass'></i> *******************</span>
		</div>
	</div>
</div>
<div style="height: 5px;"></div>
<?php }} ?>

<div class="card rounded-sm shadow-lg mt-1">
<div class="card-header text-muted h6">
<div class="d-flex">
  <div class="mr-auto">
  	<?php echo $Today;?>
  </div>
  <div>Amount</div>
</div>
</div>

	<ul class="list-group list-group-flush">
		<li style="height: 53px;" class="list-group-item text-right border-0 font-weight-bold h3"><span class="float-left font-weight-bold h5">04:00 - 07:00</span><?php echo $result10['Summer'];?></li>
		<li style="height: 53px;" class="list-group-item text-right border-0 font-weight-bold h3"><span class="float-left font-weight-bold h5">09:00 - 14:00</span><?php echo $result20['Summer'];?></li>
		<li style="height: 53px;" class="list-group-item text-right border-0 font-weight-bold h3"><span class="float-left font-weight-bold h5">14:30 - 18:30</span><?php echo $result30['Summer'];?></li>
	</ul>
</div>

</div>
<div class="col-lg-8">
 <div class="row">
   <div class="col-lg-12">
<?php
$strSQL02 = "SELECT TOP (7) dbo.Cnt_TrnDetail.TrnNo, dbo.Cnt_TrnDetail.EmpID, HRSystem.dbo.eEmployee.sEmpFirstName, HRSystem.dbo.eEmployee.sEmpEngFirstName,
    dbo.Cnt_TrnDetail.Qta_Value, dbo.Cnt_TrnDetail.TrnTime, dbo.Cnt_TrnDetail.MakeBy, dbo.Cnt_TrnDetail.Status, CONVERT(varchar, dbo.Cnt_TrnDetail.TrnTime, 100) AS CurrentDay
    FROM dbo.Cnt_TrnDetail INNER JOIN HRSystem.dbo.eEmployee ON dbo.Cnt_TrnDetail.EmpID = HRSystem.dbo.eEmployee.sEmpID
		WHERE (dbo.Cnt_TrnDetail.Status = 0 OR dbo.Cnt_TrnDetail.Status = 1 OR dbo.Cnt_TrnDetail.Status = 3) AND (dbo.Cnt_TrnDetail.TrnDate = '$Datelimit') AND (dbo.Cnt_TrnDetail.MakeBy = 'Canteen TDA') ORDER BY dbo.Cnt_TrnDetail.TrnTime DESC";
$objQuery02 = sqlsrv_query($connCanteen, $strSQL02);
while($obResult02 = sqlsrv_fetch_array($objQuery02,SQLSRV_FETCH_ASSOC)){
?>
     <div class='card rounded-sm shadow-lg mt-2'>
     <div class='row text-center text-lg-left'>
     <div class='col-lg-9 col-md-4 col-6'>
     <div class='row text-center text-lg-left'>
     <div class='col-lg-8 col-md-4 col-6'>
     <span class='d-block mb-4 h-100'>
     <div class='card-body'>
       <h4 class='title text-truncate'><span class='sub_title txt-pay0<?php echo $obResult02["Status"];?>'>ID: </span><b><?php echo $obResult02["EmpID"];?></b></h4>
       <h4 class='title text-truncate'><span class='sub_title txt-pay0<?php echo $obResult02["Status"];?>'>Name: </span><b><?php echo $obResult02["sEmpEngFirstName"];?></b></h4>
     </div>
     </span>
     </div>
     <div class='col-lg-4 col-md-4 col-6'>
     <span class='d-block mb-4 h-100'>
     <div class='card-body'>
       <h3><span class='badge badge-pay0<?php echo $obResult02["Status"];?>'><?php echo ($obResult02["Qta_Value"] == 20 ? "20 THB" : "None");?></span></h3>
       <h6 class='title text-truncate'><?php echo $obResult02["CurrentDay"];?><h6>
     </div>
     </span>
     </div>
     </div>
     </div>
     <div class='col-lg-3 col-md-4 col-6'>
       <img src='../img/photo_emp/rectangle/<?php echo $obResult02["EmpID"];?>.jpg' style='height: 120px; background-color: ;' class='card-img' alt='no picture'>
     </div>
     </div>
     </div>
<?php } ?>
   </div>
 </div>
</div>
</div>

<?php
	}
//sqlsrv_close($conn);
?>
