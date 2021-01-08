

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
  <div class="card-header">
  <h5>Annual activities</h5>
  </div>
  <div class="card-body">

  <div class="table-responsive">
	<table id="AnnualTable" class="table table-hover table-striped nowrap text-truncate" style="width:100%">
	  <thead>
		<tr>
		  <th scope="col">#</th>
		  <th scope="col">ไอดี</th>
		  <th scope="col">การจัดกิจกรรม</th>
		  <th scope="col">เหตุผล</th>
		  <th scope="col">วิธีการจัดกิจกรรม</th>
		  <th scope="col">วิธีการอื่นๆ</th>
		  <th scope="col">ความคิดเห็น</th>
		</tr>
	  </thead>
	  <tbody>
<?php
    $ListUserSQL = "SELECT annualId,annualKey,annualTypeOne,annualReasonOne,annualTypeTwo,annualReasonTwo,annualComment,Status, CreatedBy
    FROM surveyannual WHERE (Status = 1) ";
    $ListUserQuery = mysqli_query($connBoardcast, $ListUserSQL);
    $iNum = 1;
    if(mysqli_num_rows($ListUserQuery) > 0) {
    while ($ListUserResult = mysqli_fetch_array($ListUserQuery, MYSQLI_ASSOC)) {

        switch ($ListUserResult["annualTypeOne"]) {
        case 2: $StateRoom = 'Should not'; $StateColor = 'danger';
            break;
        case 1: $StateRoom = 'Should'; $StateColor = 'success';
            break;
        default:
        $StateRoom = ''; $StateColor = '';
        }

?>
    <tr>
      <th scope="row"><?php print $iNum ;?></th>
      <td><?php print $ListUserResult["CreatedBy"] ;?></td>
      <td><span class="badge badge-pill badge-<?php echo $StateColor ;?>"><?php echo $StateRoom ;?></span></td>
      <td><div class="text-truncate" style="width:120px"><?php echo $ListUserResult["annualReasonOne"] ;?></div></td>
      <td><div class="text-truncate" style="width:120px"><?php echo $ListUserResult["annualTypeTwo"] ;?></div></td>
      <td><div class="text-truncate" style="width:120px"><?php echo $ListUserResult["annualReasonTwo"] ;?></div></td>
      <td><div class="text-truncate" style="width:120px"><?php echo $ListUserResult["annualComment"] ;?></div></td>
    </tr>
      <?php 
      $iNum++;
        }     
    }else {
  ?>
        <tr><td class="text-center" colspan="5">No data available in table</td></tr>
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
  var table = $('#AnnualTable').DataTable({
    "paging": true,
    "lengthChange": true,
    "searching": false,
    "ordering": false,
    "info": true,
    "autoWidth": true,
	  //'order': [1,2, 'desc'],
    'order': false,
    'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
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
          columns: [0, 1, 2, 3, 4, 5, 6] } },
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
          columns: [0, 1, 2, 3, 4, 5, 6] } },
      {
        extend: 'csvHtml5',
		    footer: 'true',
        text: '<i class="fas fa-file-csv"></i> CSV',
        title: 'E-SURVEY',
        titleAttr: 'CSV',
        className: 'btn btn-app export csv',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6] } },
      {
        extend: 'print',
		    footer: 'true',
        text: '<i class="fa fa-print"></i> Print',
        title: 'E-SURVEY',
        titleAttr: 'Print',
        className: 'btn btn-app export print',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6] } },
      {
        extend: 'pageLength',
        titleAttr: 'Show',
        className: 'btn btn-app selectTable' }] ,
		
		
		
	});
    table.buttons().container().appendTo($('#printbar'));
  });
  </script>



