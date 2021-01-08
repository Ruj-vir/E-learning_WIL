<?php include "templates/headerAdmin.php";?>

<style>


</style>

	<!-- Page Content -->
	<div class="container">
	  <div class="card shadow-sm">
	      <div class="card-header">
			<div class="d-flex">
			<div class="mr-auto h3">
				<strong>Picking <span class="badge badge-warning">TDA</span></strong>
			</div>
				<div><button type="button" class="btn btn-green" onClick="window.location='canteen-picking.TV.TDA.php';"><i class="fas fa-tv"></i></button></div>
			</div>
		  </div>

<div class="card-body">
 <form action="save/save_picking_main.php" autocomplete="off" method="POST" target="iframe_picking">
 <input type="hidden" class="form-control" id="CanteenPlan" name="CanteenPlan" value="Canteen TDA" required>
  <div class="form-group">
      <div class="input-group">
        <input type="text" class="form-control" id="InputRFID" name="InputRFID" placeholder="Enter RFID" pattern=".{10,}" title="Please enter at least 10 codes." required>
          <div class="input-group-append">
            <button type="submit" name="AddNewRFID" class="btn btn-green btn-block"><i class="fas fa-save"></i> Save</button>
          </div>
      </div>
  </div>
  <div id="PickingRFID"></div>
 </form>
<div id="PickingMain"></div>
</div>
		
		</div>
	  </div>
	</div>




<?php include "templates/footer.php";?>

<audio id="alert" src="assets/media/sound/buzzer.mp3" type="audio/mpeg"></audio>
<audio id="Okey" src="assets/media/sound/Thank.mp3" type="audio/mpeg"></audio>
<audio id="again" src="assets/media/sound/try_again.mp3" type="audio/mpeg"></audio>

<iframe id="iframe_picking" name="iframe_picking" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>


<script type="text/javascript">
$(function(){
    setInterval(function(){ // เขียนฟังก์ชัน javascript ให้ทำงานทุก ๆ 30 วินาที
        // 1 วินาที่ เท่า 1000
        // คำสั่งที่ต้องการให้ทำงาน ทุก ๆ 3 วินาที
        var getData = $.ajax({ // ใช้ ajax ด้วย jQuery ดึงข้อมูลจากฐานข้อมูล
                url:"return/return_pinking_main_TDA.php",
                data:"Receive=1",
                async:false,
                success:function(getData){
                    $("div#PickingMain").html(getData); // ส่วนที่ 3 นำข้อมูลมาแสดง
                }
        }).responseText;
    },1000);    
});

    $(window).on('load',function(){
        var InputRFID = document.getElementById("InputRFID").focus();
    });

    function CanteenResult(PickingRFID) {
      if(PickingRFID == 501) {
		$('#InputRFID').val('');
		$('#PickingRFID').empty();
		var audio = document.getElementById("Okey").play(); audio.volume = 0.9;
      }else if(PickingRFID == 502) {
		$('#InputRFID').val('');
		$('#PickingRFID').empty();
		var audio = document.getElementById("alert").play(); audio.volume = 0.9;
      }else if(PickingRFID == 101) {
		$('#InputRFID').val('');
		$('#PickingRFID').html("<div class='alert alert-danger text-center' role='alert'>Error Picking.</div>");
		var audio = document.getElementById("again").play(); audio.volume = 0.9;
      }else if(PickingRFID == 102) {
		$('#InputRFID').val('');
		$('#PickingRFID').html("<div class='alert alert-danger text-center' role='alert'>Error Picking.</div>");
		var audio = document.getElementById("again").play(); audio.volume = 0.9;
      }else if(PickingRFID == 103) {
		$('#InputRFID').val('');
		$('#PickingRFID').html("<div class='alert alert-danger text-center' role='alert'>Error Data does not match.</div>");
		var audio = document.getElementById("again").play(); audio.volume = 0.9;
      }else {
		$('#InputRFID').val('');
		$('#PickingRFID').html("<div class='alert alert-danger text-center' role='alert'>Error Incomplete information.</div>");
		var audio = document.getElementById("again").play(); audio.volume = 0.9;
	  }
    }
</script>