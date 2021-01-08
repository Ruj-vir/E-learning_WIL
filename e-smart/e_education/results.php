

<?php include "templates/header.php" ;?>
<?php include "templates/navber.php" ;?>
<?php include "alert/alert_admin.php" ;?>

  <link href="assets/dataTable/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="assets/dataTable/export/buttons.bootstrap4.min.css" rel="stylesheet">

<style>

</style>

<div class="container">

<div class="card my-4">
  <div class="card-header">
  <h5>Manage documents</h5>
  </div>
  <div class="card-body">

  <button type="submit" name="SubmitAddAssess" class="btn btn-purple mb-4" data-toggle="modal" data-target="#BttAddFormModal"><i class="far fa-plus-square"></i> Add form</button>
  <div class="table-responsive">
	<table id="reqTable" class="table table-hover table-striped nowrap text-truncate" style="width:100%">
	  <thead>
		<tr>
		  <th scope="col">#</th>
		  <th scope="col">Form ID</th>
		  <th scope="col">Form name</th>
		  <th scope="col">Period</th>
		  <th scope="col">Status</th>
		  <th scope="col" class="text-center">Actions</th>
		</tr>
	  </thead>
	  <tbody>
<?php
    $ListUserSQL = "SELECT surveytypeId,surveytypeKey,surveytypeMain,surveySecondary,surveyDateFrom,surveyDateTo,Status
    FROM surveytype ";
    $ListUserQuery = mysqli_query($connBoardcast, $ListUserSQL);
    $iNum = 1;
    if(mysqli_num_rows($ListUserQuery) > 0) {
    while ($ListUserResult = mysqli_fetch_array($ListUserQuery, MYSQLI_ASSOC)) {

        switch ($ListUserResult["Status"]) {
        case 0: $StateRoom = 'disabled'; $StateColor = 'secondary';
            break;
        case 1: $StateRoom = 'enabled'; $StateColor = 'success';
            break;
        default:
        $StateRoom = ''; $StateColor = '';
        }
?>
    <tr>
      <th scope="row"><?php print $iNum ;?></th>
      <td><?php echo $ListUserResult["surveytypeKey"] ;?></td>
      <td><?php echo $ListUserResult["surveytypeMain"] ;?></td>
      <td><?php echo date("d/m/Y H:i", strtotime($ListUserResult["surveyDateFrom"]))." - ".date("d/m/Y H:i", strtotime($ListUserResult["surveyDateTo"])) ;?></td>
      <td><span class="badge badge-pill badge-<?php echo $StateColor ;?>"><?php echo $StateRoom ;?></span></td>

		<td class="text-center">
		  <button type="button" class="btn btn-dark btn-sm" onclick="location.href='report_activity_annual.php?FormCode=<?php echo $ListUserResult['surveytypeId'] ;?>&Scmojf84jfmoisef0'"><i class="fas fa-file-export"></i></button>
		  <button type="button" class="btn btn-dark btn-sm" onclick="location.href='results_detail.php?FormCode=<?php echo $ListUserResult['surveytypeId'];?>&Scmojf84jfmoisef0'"><i class="fas fa-pen-square"></i></button>
		</td>
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

  <script src="assets/dataTable/jquery.dataTables.min.js"></script>
  <script src="assets/dataTable/dataTables.bootstrap4.min.js"></script>

  <script type="text/javascript">
    $(document).ready(function () {
    var table = $('#reqTable').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        //'order': [0, 'desc'],
        //'order': [1,2, 'desc'],
        //'order': false,
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
        'columnDefs': [{'targets': 5,'searchable':false,'orderable':false,}]
        });
    });
  </script>


<!-- Modal ADD -->
<form action="save/save_add_survey.php" autocomplete="off" method="POST" target="iframe_Add_form">

<div class="modal fade" id="BttAddFormModal" tabindex="-1" role="dialog" aria-labelledby="BttAddFormModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="BttAddFormModalLongTitle">Add form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<div class="form-row">

		  <div class="form-group col-md-6">
			<label for="inputID">Form ID:</label>
			<input type="text" class="form-control " id="inputID" name="inputID" required placeholder="" >
		  </div>
		  <div class="form-group col-md-12">
			<label for="inputName">Form name:</label>
			<input type="text" class="form-control " id="inputName" name="inputName" required placeholder="" >
		  </div>

		  <div class="form-group col-md-6">
			<label for="inputDateFrom">Date from:</label>
			<input type="date" class="form-control " id="inputDateFrom" name="inputDateFrom" required placeholder="" >
		  </div>
		  <div class="form-group col-md-6">
			<label for="inputTimeFrom">Time from:</label>
			<input type="time" class="form-control " id="inputTimeFrom" name="inputTimeFrom" required placeholder="" >
		  </div>

		  <div class="form-group col-md-6">
			<label for="inputDateTo">Date to:</label>
			<input type="date" class="form-control " id="inputDateTo" name="inputDateTo" required placeholder="" >
		  </div>
		  <div class="form-group col-md-6">
			<label for="inputTimeTo">Time to:</label>
			<input type="time" class="form-control " id="inputTimeTo" name="inputTimeTo" required placeholder="" >
		  </div>

		  <div class="form-group col-md-12">
			<label for="inputTimeTo">File:</label>
			<div class="custom-file">
			  <input type="file" class="custom-file-input" id="customFile" accept=".php">
			  <label class="custom-file-label" for="customFile">Choose file</label>
			</div>
		  </div>

		  <div class="form-group">
			<div id="AddResultAssessor"></div>
		  </div>

		</div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="submit" class="btn btn-purple">Save changes</button>
      </div>
    </div>
  </div>
</div>

</form>
<iframe id="iframe_Add_form" name="iframe_Add_form" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>

    <script type="text/javascript">
    function ServiceAddResult(AddResult) {
        if(AddResult == 1) {
          $("#AddResultAssessor").html("<div class='alert alert-success' role='alert'>เรียบร้อยแล้ว</div>");
          setInterval('window.location.href = "results.php"', 1000);
        }else {
          $('#AddResultAssessor').html("<div class='alert alert-danger text-center' role='alert'>ไม่สำเร็จ</div>");
        }
    }

    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

    $(function VeriFile() {
        $('input[type=file]').change(function () {
            var val = $(this).val().toLowerCase();
            regex = new RegExp("(.*?)\.(php|PHP)$");
            if(!(regex.test(val))) {
                $(this).val('');
                alert('Please select correct file format');
                return false;
            }
        });
    });

    </script>