	<?php include "templates/header.php";?>
	<?php include "templates/navber.php";?>
  <?php include "alert/alert_check.php";?>

    <div class="container-fluid">
      <div class="row mt-4">


        <div class="col-xl-12 col-md-6 mb-4">
          <div class="card rounded shadow-sm">
            <div class="card-header">
            <div class="row justify-content-between">
              <div class="col">
                <h5 class="text-uppercase"><strong>Checked</strong></h5>
              </div>
              <div class="col text-right">
                <div class="btn-group">
                  <button type="button" class="btn btn-secondary btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-sort-down"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="training_check.php">Check</a>
                    <a class="dropdown-item" href="training_checked.php">Checked</a>
                  </div>
                </div>
              </div>
            </div>
            </div>

            <div class="card-body">
			        <?php include "form/include_checked_req.php" ;?>
            </div>
          </div>
        </div>



      
    </div><!-- .row -->
 </div><!-- .container-fluid -->


  <?php include "templates/footer.php";?>


  <!-- Modal -->
	<div class="modal fade ModalChecked" tabindex="-1" role="dialog" aria-labelledby="reque_title" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
		  <div class="modal-header bg-dark text-primary">
			<h5 class="modal-title" id="reque_title">Leave checked</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		    <div class="modal-body">

          <input type="hidden" id="txtNoDetail" name="txtNoDetail" >
          <div id="emp_Detail"></div>

		    </div>
		</div>
	  </div>
  </div>
    
