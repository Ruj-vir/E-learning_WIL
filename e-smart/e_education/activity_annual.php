

<?php include "templates/header.php";?>
<?php include "templates/navber.php";?>

<style>

</style>

<div class="container">

<form action="save/save_activity_annual.php" autocomplete="off" method="post" target="iframe_save_activity_annual">

  <div class="card my-4">
    <div class="card-header">
    <h5>
	แบบสำรวจการจัดกิจกรรมของบริษัท ไทย ไดโซ แอโรโซล จำกัด ประจำปี 2563
	<p><small>Thai Daizo Aerosol Co., Ltd. Activities survey on year 2020</small></p>
	</h5><small class="text-danger">หมดเขต (expired): 8/10/2020 23:59</small>
    </div>
    <div class="card-body">
	  
      <p class="card-text">เนื่องด้วยสถานการณ์ Covid-2019 ที่แพร่ระบาดอย่างหนักและต่อเนื่องทั่วโลก และประเทศไทยยังคงเฝ้าระวังและป้องกันอย่างสม่ำเสมอ </p>
      <small class="card-text">According to COVID-19 was happended in worldwide and now, Thailand has surveillance and prevention control regulary.</small>
      <p class="card-text">ทางบริษัทฯจึงขอความร่วมมือพนักงานทำแบบสำรวจความคิดเห็นการจัดกิจกรรมท่องเที่ยวประจำปี กีฬาสี และ งานเลี้ยงปีใหม่ ประจำปี 2563 ของบริษัท ไทย ไดโซ แอโรโซล จำกัด ดังต่อไปนี้</p>
      <small class="card-text">Therefore, company would like to request to fill out the questionaire survey about Thai Daizo Aerosol Co., Ltd. Annual Trip, Sports Day and New Year Party on 2020. As questionaire survey below.</small>
      <hr class="mt-2 mb-4">

      <div class="row">
        <div class="col">
          <img class="img-fluid img-thumbnail" src="assets/img/system/annual.jpg" alt="">
        </div>
        <div class="col">
          <img class="img-fluid img-thumbnail" src="assets/img/system/sport.jpg" alt="">
        </div>
        <div class="col">
          <img class="img-fluid img-thumbnail" src="assets/img/system/new_year.jpg" alt="">
        </div>
      </div>

      <div class="my-3">
        <strong>1. ท่านคิดเห็นเกี่ยวกับการจัดกิจกรรมท่องเที่ยวประจำปี กีฬาสี และ งานเลี้ยงปีใหม่ ประจำปี 2563</strong>
		<p>Do you think that company should provide the annual trip, sports day and new year party on 2020?</p>
      </div>

  <div class="row no-gutters">
    <div class="col-lg-4">
	  <div class="input-group-text">
		<div class="custom-control custom-radio">
		  <input type="radio" class="custom-control-input" id="organize1" name="organize" value="1" required="required">
		  <label class="custom-control-label pointer" for="organize1">ควรจัดให้มีกิจกรรม - <small>Yes, I'd love to, because</small></label>
		</div>
	  </div>
    </div>
    <div class="col-lg-8 mb-4">
	  <input type="text" class="form-control" id="InputReasonDoing" name="InputReasonDoing" placeholder="ระบุเหตุผล..">
    </div>
  </div>
  <div class="row no-gutters">
    <div class="col-lg-4">
	  <div class="input-group-text">
		<div class="custom-control custom-radio">
		  <input type="radio" class="custom-control-input" id="organize2" name="organize" value="2" required="required">
		  <label class="custom-control-label pointer" for="organize2">ยังไม่สมควรจัด - <small>No, I don't agree because</small></label>
		</div>
	  </div>
    </div>
    <div class="col-lg-8 mb-4">
	  <input type="text" class="form-control" id="InputReasonNotDoing" name="InputReasonNotDoing" placeholder="ระบุเหตุผล..">
    </div>
  </div>
		
      <div class="my-3">
        <strong>2. หากบริษัทฯ จัดกิจกรรมการท่องเที่ยวประจำปี กีฬาสี และ งานเลี้ยงปีใหม่ ควรจัดกิจกรรมแบบใด</strong>
		<p>If company provide the the annual trip, sport days and New Year Party, what kind of activities do you interest?</p>
      </div>

		<div class="form-group">
		  <label class="container-checkbox">
			 <div>จัดกิจกรรมแยกกัน ท่องเที่ยวปีใหม่ ( 2 วัน 1 คืน ) กีฬาสี ( 1 วัน ) และงานเลี้ยงปีใหม่ ( หลังเลิกงาน )</div>
			 <small>Separate all activities by annual trip (2 days 1 night), sports day (1 Day) and New Year Party (after finished work)</small> 
			<input type="radio" id="choice1" name="choice" value="1" onclick="CheckRoomBook();" required>
			<span class="checkmark-box"></span>
		  </label>
		</div>
		<div class="form-group">
		  <label class="container-checkbox">
		    <div>จัดกิจกรรมท่องเที่ยวประจำปี  กีฬาสี และ งานเลี้ยงปีใหม่รวมกัน ( 3 วัน 2 คืน )</div>
			<small>Company annual trip, sports day and new year party in 3 days 2 nights.</small>
			<input type="radio" id="choice2" name="choice" value="2" onclick="CheckRoomBook();" required>
			<span class="checkmark-box"></span>
		  </label>
		</div>
		<div class="form-group">
		  <label class="container-checkbox">
		    <div>จัดกิจกรรมท่องเที่ยวประจำปีกับงานเลี้ยงปีใหม่รวมกัน ( 2 วัน 1 คืน ) และแยกกีฬาสี ( 1 วัน )</div>
			<small>Company annual trip and new year party in 2 days 1 night, separate  sports day (1 day).</small>
			<input type="radio" id="choice3" name="choice" value="3" onclick="CheckRoomBook();" required>
			<span class="checkmark-box"></span>
		  </label>
		</div>
		<div class="form-group">
		  <label class="container-checkbox">
		    <div>จัดกิจกรรมท่องเที่ยวประจำปี ( 2 วัน 1 คืน ) และรวมกีฬาสีกับงานเลี้ยงปีใหม่ ( 1 วัน )</div>
			<small>Company annual trip (2 days 1 night) and combine sports day and new year party in one day.</small>
			<input type="radio" id="choice4" name="choice" value="4" onclick="CheckRoomBook();" required>
			<span class="checkmark-box"></span>
		  </label>
		</div>
		<div class="form-group">
		  <label class="container-checkbox">
		    <div>วิธีการอื่น ๆ โดยมีข้อเสนอแนะดังนี้</div>
			<small>Others.</small>
			<input type="radio" id="choice5" name="choice" value="5" onclick="CheckRoomBook();" required>
			<span class="checkmark-box"></span>
		  </label>
		</div>

	<div id="dvPassport" style="display: none;">
	  <div class="form-group">
		  <div class="input-group md-4" id="dynamic_field">
			<div class="input-group-prepend">
			  <button type="button" class="btn btn-sm btn-success" name="add" id="add"><i class="fas fa-plus-square"></i></button>
			</div>
			<input type="text" class="form-control form-control-sm nameList" id="InputOther" name="InputOther[]" value="" placeholder="">
		  </div>
	  </div>
	</div>

	<div class="form-group">
      <div class="my-3">
        <strong>3. ข้อเสนอแนะอื่น ๆ </strong>
		<p>Suggestions on below.</p>
      </div>
		<textarea class="form-control" id="inputComment" name="inputComment" rows="3" placeholder="(ถ้ามี)"></textarea>
	</div>
	
	<div class="form-group">
      <div id="AddResultAssessor"></div>
	</div>
	
    </div>
  <div class="card-footer text-muted">
    <button type="submit" name="SubmitAddAssess" class="btn btn-purple btn-block" ><i class="fas fa-save"></i> บันทึก(save)</button>
  </div>
  </div>
  
</form>
<iframe id="iframe_save_activity_annual" name="iframe_save_activity_annual" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
  
</div><!-- .container -->


<?php include "templates/footer.php";?>



<!-- Modal HTML -->
<div id="ModalSuccess" class="modal fade">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header">
				<div class="icon-box">
          <i class="far fa-check-circle"></i>
				</div>				
				<h4 class="modal-title w-100">successfully</h4>	
			</div>
			<div class="modal-body">
				<p class="text-center">Your assessment has been successful.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success btn-block" data-dismiss="modal">OK</button>
			</div>
		</div>
	</div>
</div> 


<script type="text/javascript">
$(function(){
  $("input[name=choice]").change(function(){
    if($(this).val()=="5") {
      $('#InputOther').attr('required','required');
    }else {
      $('#InputOther').removeAttr('required');
    }
  });
});

$(function(){
  $("input[name=organize]").change(function(){
    if($(this).val()=="1") {
      $('#InputReasonDoing').attr('required','required');
      $('#InputReasonNotDoing').removeAttr('required');
    }else if($(this).val()=="2"){
      $('#InputReasonNotDoing').attr('required','required');
      $('#InputReasonDoing').removeAttr('required');
    }
  });
});
</script>


<script type="text/javascript">
	$(document).ready(function(){  
	   var i=1;  
	   $('#add').click(function(){  
			i++;  
			$('#dynamic_field').append('<div class="input-group mt-2" id="row'+i+'"><div class="input-group-prepend"><button type="button" class="btn btn-sm btn-danger btn_remove" name="remove" id="'+i+'"><i class="fas fa-minus-square"></i></button></div><input type="text" class="form-control form-control-sm nameList" name="InputOther[]" required></div>');  
	   });  
	   $(document).on('click', '.btn_remove', function(){  
			var button_id = $(this).attr("id");   
			$('#row'+button_id+'').remove();  
	   });
	}); 

    function CheckRoomBook() {
        if (document.getElementById('choice5').checked) {
            document.getElementById('dvPassport').style.display = 'block';
        }
        else {
            document.getElementById('dvPassport').style.display = 'none';
      }
    }
</script>

  <script type="text/javascript">
    function ServiceAddResult(AddResult) {
        if(AddResult == 1) {
          $("#AddResultAssessor").html("<div class='alert alert-success' role='alert'>เรียบร้อยแล้ว</div>");
          //setInterval('window.location.href = "logout.php"', 1000);
          $('#ModalSuccess').modal('show');
        }else if(AddResult == 101) {
          $('#AddResultAssessor').html("<div class='alert alert-danger text-center' role='alert'>คุณทำแบบสำรวจนี้แล้ว</div>");
        }else {
          $('#AddResultAssessor').html("<div class='alert alert-danger text-center' role='alert'>ไม่สำเร็จ</div>");
        }
    }

    $('#ModalSuccess').on('hidden.bs.modal', function () {
      window.location.href = 'index.php';
      //window.location.reload();
      //$('#formAssessment')[0].reset();
    });
  </script>
