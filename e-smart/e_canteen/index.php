
<?php include "templates/headerUser.php";?>

<div class="py-3 text-center">
  <h2 class="text-muted">Accounting Card</h2>
</div>

<div class="row justify-content-center">
<div class="col-md-6">
<div class="d-flex align-items-center p-3 my-3 text-white-50 bg-green rounded box-shadow">
  <img class="mr-3" src="../img/photo_emp/square/<?php echo $SesUserID ;?>.jpg" alt="" width="48" height="48">
  <div class="lh-100">
	<h5 class="mb-0 text-white lh-100"><?php echo $resultSQL['EmpUserName']."\n".$resultSQL['EmpUserSurname'];?></h5>
	<small class="text-dark h6">Available Bal. <?php echo number_format($QuotaObjResult["Qta_Value"],2);?></small>
  </div>
</div>

<div class="my-3 p-3 bg-white rounded box-shadow">
  <h6 class="border-bottom border-gray pb-2 mb-0">Activity</h6>
<?php
$CnTimelineSQL = "SELECT TOP (5) TrnTime FROM Cnt_TrnDetail WHERE (EmpID = '$SesUserID') AND (Status != 0) ORDER BY TrnTime DESC";
$CnTimelineQuery = sqlsrv_query($connCanteen, $CnTimelineSQL);
while($CnTimelineResult = sqlsrv_fetch_array($CnTimelineQuery, SQLSRV_FETCH_ASSOC)) {
?>
  <div class="media text-muted pt-3">
	<div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
	  <div class="d-flex justify-content-between align-items-center w-100">
		<strong class="text-gray-dark h6"><?php echo date_format($CnTimelineResult["TrnTime"], 'd M. Y');?></strong>
		<span class="text-danger h6">-20</span>
	  </div>
	  <span class="d-block"><?php echo date_format($CnTimelineResult["TrnTime"], 'h:i a');?></span>
	</div>
  </div>
<?php } ?>
  <small class="d-block text-right mt-3">
	<?php if(trim($UserCanResult["EmpUserID"] == $SesUserID)){$canteen = 'canteen_index.php';}else{$canteen = '#';}?>
	<a href="<?php echo $canteen; ?>">Controller <i class="fa fa-chevron-circle-right"></i></a>
  </small>
</div>
</div>
</div>


<?php include "templates/footer.php";?>