

<?php include "templates/header.php" ;?>
<?php include "templates/navber.php" ;?>
<?php include "alert/alert_admin.php" ;?>

<style>
.inline {
  display: inline-block;
  padding: 0
}
</style>

<div class="container">

<div class="card my-4">
  <div class="card-body">
    <a class="btn btn-warning" href="report_canteen_commitee.php?linkIdReport=TDA" role="button">TDA</a>
    <a class="btn btn-primary" href="report_canteen_commitee.php?linkIdReport=TDP" role="button">TDP</a>
  </div>
</div>

<?php
  if(trim($_GET["linkIdReport"]) == NULL) {
    $linkIdReport = 'TDA';
  }else {
    if((trim($_GET["linkIdReport"]) == 'TDA') || (trim($_GET["linkIdReport"]) == 'TDP')) {
      $linkIdReport = $_GET["linkIdReport"];
    }else {
      echo "<script type=text/javascript>window.location='index.php';</script>";
      exit();
    }
  }
?>

<div class="card">
  <div class="card-header">
  <h5>Canteen commitee (<?php echo $linkIdReport ;?>)</h5>
  </div>
  <div class="card-body">

  <div class="table-responsive">
	<table id="CanteenCommiteeTable" class="table table-hover table-striped nowrap text-truncate" style="width:100%">
	  <thead>
		<tr>
		  <th scope="col">#</th>
		  <!--<th scope="col">ไอดี</th>-->
		  <th scope="col">1.1</th>
		  <th scope="col">1.2</th>
		  <th scope="col">1.3</th>
		  <th scope="col">1.4</th>
		  <th scope="col">1.5</th>
		  <th scope="col">1.6</th>
		  <th scope="col">1.7</th>
		  
		  <th scope="col">2.1</th>
		  <th scope="col">2.2</th>
		  <th scope="col">2.3</th>

		  <th scope="col">3.1</th>
		  <th scope="col">3.2</th>
		  <th scope="col">3.3</th>
		  <th scope="col">3.4</th>
		  <th scope="col">3.5</th>
		  <th scope="col">3.6</th>
		  <th scope="col">3.7</th>
		  <th scope="col">3.8</th>
		  <th scope="col">3.9</th>
		  <th scope="col">3.10</th>

		  <th scope="col">4.1</th>
		  <th scope="col">4.2</th>
		  <th scope="col">4.3</th>
		  <th scope="col">4.4</th>
		  <th scope="col">4.5</th>
		  <th scope="col">4.6</th>
		  <th scope="col">4.7</th>
		  <th scope="col">4.8</th>

		  <th scope="col">5.1</th>
		  <th scope="col">5.2</th>
		  <th scope="col">5.3</th>

		  <th scope="col">ความคิดเห็น</th>
		</tr>
	  </thead>
	  <tbody>
<?php

    $ListUserSQL = "SELECT * FROM canteencommitee WHERE (canteenPlant = '$linkIdReport') AND Status = 1";
    $ListUserQuery = mysqli_query($connBoardcast, $ListUserSQL);
    $iNum = 1;
    if(mysqli_num_rows($ListUserQuery) > 0) {
    while ($ListUserResult = mysqli_fetch_array($ListUserQuery, MYSQLI_ASSOC)) {

?>
    <tr>
      <th scope="row"><?php print $iNum ;?> )</th>
		  <td><?php echo $ListUserResult["Satisfaction1"] ;?></td>
		  <td><?php echo $ListUserResult["Satisfaction2"] ;?></td>
		  <td><?php echo $ListUserResult["Satisfaction3"] ;?></td>
		  <td><?php echo $ListUserResult["Satisfaction4"] ;?></td>
		  <td><?php echo $ListUserResult["Satisfaction5"] ;?></td>
		  <td><?php echo $ListUserResult["Satisfaction6"] ;?></td>
		  <td><?php echo $ListUserResult["Satisfaction7"] ;?></td>

		  <td><?php echo $ListUserResult["Satisfaction8"] ;?></td>
		  <td><?php echo $ListUserResult["Satisfaction9"] ;?></td>
		  <td><?php echo $ListUserResult["Satisfaction10"] ;?></td>
		  
		  <td><?php echo $ListUserResult["Satisfaction11"] ;?></td>
		  <td><?php echo $ListUserResult["Satisfaction12"] ;?></td>
		  <td><?php echo $ListUserResult["Satisfaction13"] ;?></td>
		  <td><?php echo $ListUserResult["Satisfaction14"] ;?></td>
		  <td><?php echo $ListUserResult["Satisfaction15"] ;?></td>
		  <td><?php echo $ListUserResult["Satisfaction16"] ;?></td>		  
      <td><?php echo $ListUserResult["Satisfaction17"] ;?></td>
		  <td><?php echo $ListUserResult["Satisfaction18"] ;?></td>
		  <td><?php echo $ListUserResult["Satisfaction19"] ;?></td>
		  <td><?php echo $ListUserResult["Satisfaction20"] ;?></td>

		  <td><?php echo $ListUserResult["Satisfaction21"] ;?></td>
		  <td><?php echo $ListUserResult["Satisfaction22"] ;?></td>
		  <td><?php echo $ListUserResult["Satisfaction23"] ;?></td>
		  <td><?php echo $ListUserResult["Satisfaction24"] ;?></td>
		  <td><?php echo $ListUserResult["Satisfaction25"] ;?></td>
		  <td><?php echo $ListUserResult["Satisfaction26"] ;?></td>		  
      <td><?php echo $ListUserResult["Satisfaction27"] ;?></td>
		  <td><?php echo $ListUserResult["Satisfaction28"] ;?></td>

		  <td><?php echo $ListUserResult["Satisfaction29"] ;?></td>
		  <td><?php echo $ListUserResult["Satisfaction30"] ;?></td>
		  <td><?php echo $ListUserResult["Satisfaction31"] ;?></td>

      <td><div class="text-truncate" style="width:120px"><?php echo $ListUserResult["canteenReviews"] ;?></div></td>
    </tr>
      <?php 
      $iNum++;
        }     
    }else {
  ?>
        <tr><td class="text-center" colspan="35">No data available in table</td></tr>
  <?php
    }
  ?>
	  </tbody>
	</table>
  </div>
  </div>
</div>

</div><!-- .container -->


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

<script type="text/javascript">
$(document).ready(function () {
  var table = $('#CanteenCommiteeTable').DataTable({
    "paging": true,
    "lengthChange": true,
    "searching": false,
    "ordering": false,
    "info": true,
    "autoWidth": true,
	  //'order': [1,2, 'desc'],
    'order': false,
    'lengthMenu': [[25, 50, 75, -1], [25, 50, 75, "All"]],
	  //'columnDefs': [{'targets': 8,'searchable':false,'orderable':false,}],
    dom: 'Bfrt<"col-md-6 inline"i> <"col-md-6 inline"p>',

      buttons: [
      {
        extend: 'copyHtml5',
		    footer: 'true',
        text: '<i class="fa fa-clipboard"></i> Copy',
        title: 'E-SURVEY',
        titleAttr: 'Copy',
        className: 'btn btn-app export Copy',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32] } },
      /*{
        extend: 'pdfHtml5',
		    footer: 'true',
        text: '<i class="fa fa-file-pdf-o"></i> PDF',
        title: 'E-CAR BOOKING',
        titleAttr: 'PDF',
        className: 'btn btn-app export pdf',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8] } },

        customize: function (doc) {

          doc.styles.title = {
            color: '#8eb852',
            fontSize: '30',
            alignment: 'center' };

          doc.styles['td:nth-child(2)'] = {
            width: '100px',
            'max-width': '100px' },

          doc.styles.tableHeader = {
            fillColor: '#8eb852',
            color: 'white',
            alignment: 'center' },

          doc.content[1].margin = [100, 0, 100, 0];
        }
    },*/

      {
        extend: 'excelHtml5',
		    footer: 'true',
        text: '<i class="fas fa-file-excel"></i> Excel',
        title: 'E-SURVEY',
        titleAttr: 'Excel',
        className: 'btn btn-app export excel',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32] } },
      {
        extend: 'csvHtml5',
		    footer: 'true',
        text: '<i class="fas fa-file-csv"></i> CSV',
        title: 'E-SURVEY',
        titleAttr: 'CSV',
        className: 'btn btn-app export csv',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32] } },
      {
        extend: 'print',
		    footer: 'true',
        text: '<i class="fa fa-print"></i> Print',
        title: 'E-SURVEY',
        titleAttr: 'Print',
        className: 'btn btn-app export print',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32] } },
      {
        extend: 'pageLength',
        titleAttr: 'Show',
        className: 'btn btn-app selectTable' }] ,
		
		
		
	});
    table.buttons().container().appendTo($('#printbar'));
  });
  </script>



