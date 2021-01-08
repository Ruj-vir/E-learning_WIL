




  $(".BttEdit_RFID").click(function () {
      var ids = $(this).attr('data-id');
      $("#IdPanel_RFID").val( ids );
      $('#Modal_edit_RFID').modal('show');
    });

    $(document).ready(function(){
      $('.BttEdit_RFID').click(function(){
        var IDPanelIDEmp = $('#IdPanel_Emp').val();
        var IDPanelRFID = $('#IdPanel_RFID').val();
        if(IDPanelRFID != ''){
          $.ajax({
            url:"return/return_edit_RFID.php",
            method:"POST",
            data:{ IDPanelRFID:IDPanelRFID, IDPanelIDEmp:IDPanelIDEmp },
            success:function(data){
              $('#Panel_RFID').html( "" + $.trim(data) + "" );
            }
          });
        }
        /*else {
          alert("Please select the employee!!");
        }*/
      });
    });

	//! /////////////////////////////////////////////////
  $(".BttEdit_State").click(function () {
      var ids = $(this).attr('data-id');
      $("#IdPanel_State_RFID").val( ids );
      $('#Modal_edit_State').modal('show');
    });

    $(document).ready(function(){
      $('.BttEdit_State').click(function(){
        var IDPanelIDEmp_State = $('#IdPanel_State_Emp').val();
        var IDPanelRFID_State = $('#IdPanel_State_RFID').val();
        if(IDPanelRFID_State != ''){
          $.ajax({
            url:"return/return_edit_RFID.php",
            method:"POST",
            data:{ IDPanelRFID_State:IDPanelRFID_State, IDPanelIDEmp_State:IDPanelIDEmp_State },
            success:function(data){
              $('#Panel_State_RFID').html( "" + $.trim(data) + "" );
            }
          });
        }
        /*else {
          alert("Please select the employee!!");
        }*/
      });
    });


    //! //////////////////////////////////////
    /*function CanteenResult(result_EditRFID) {
        if(result_EditRFID == 1) {
        //window.location.href = "../canteen_add_card.php";
		  	//window.location.reload(false);
			  //window.location.reload();
        //location.reload();
			  //return false;
			
			  //For Sene method="GET"
        //window.location.href = window.location.href;
        alert('Successfully');
        //location.href = location.href;
        window.location.href = window.location.href;
        }else {
          //window.location.href = "ot-request.php";
        }
      }*/


        //! ////////////////////////////////////////////
        $(document).ready(function(){
          $('#InputRFID').keyup(function(){
          var InputRFID = $(this).val();
          var InputEmpID = $("#InputEmpID").val();
          if ((InputEmpID != '') && $.trim(InputRFID).length == 10){ 
             $.ajax({
                url:"return/return_Canteen_CheckRFID.php",
                method:"POST",
                data:{ InputRFID:InputRFID, InputEmpID:InputEmpID },
              success:function(data){
                if(data == 1) {
                  $('#Panel_EmpRFID').html("<div class='alert alert-success text-center' role='alert'>This RFID is available.</div>");
                }else {
                  $('#Panel_EmpRFID').html("<div class='alert alert-danger text-center' role='alert'>This RFID cannot be used.</div>");
                }
              }
            });
          }else{
            $("#Panel_EmpRFID").empty();
            //$("#Panel_EmpRFID").html('<div class="table-responsive"><table class="table table-hover text-truncate nowrap" style="width:100%"><thead><tr><th scope="col">Name/Surname</th><th scope="col">Office</th><th scope="col">RFID</th><th scope="col">Status</th><th scope="col" class="text-center">Action</th></tr></thead><tbody><tr><td class="text-center" colspan="5">No matching records found</td></tr></tbody></table></div>');
          }
          });
      });




    //! ////////////////////////////////////////////
    $(document).ready(function(){
      $('#inputSearchEmp').keyup(function(){
      var inputSearchEmp = $(this).val();
      if ((inputSearchEmp != '') && $.trim(inputSearchEmp).length > 0){ 
          $.ajax({
          url:"return/return_CanteenEmp_view.php",
          method:"POST",
          data:{ inputSearchEmp:inputSearchEmp },
          //dataType:"text",
          success:function(data){
            /*$('#txtEmpID').val(data);*/
            $("#Panel_CanteenEmp").html($.trim(data));
          }
        });
      }else{
        $("#Panel_CanteenEmp").empty();
        $("#Panel_CanteenEmp").html('<div class="table-responsive"><table class="table table-hover text-truncate nowrap" style="width:100%"><thead><tr><th scope="col">Name/Surname</th><th scope="col">Office</th><th scope="col">RFID</th><th scope="col">Status</th><th scope="col" class="text-center">Action</th></tr></thead><tbody><tr><td class="text-center" colspan="5">No matching records found</td></tr></tbody></table></div>');
      }
      });
	});





//! /////////////////////////////////
  $(".Amodal").click(function () {
    var ids = $(this).attr('data-id');
    $("#txtempID").val( ids );
    $('#adjust_model').modal('show');
  });

  /*function BttSubmit() {
  if(confirm('Are you sure you want to submit the list ?')==true){
      return true;
    }
    else{
      return false;
    }
  }*/


//! /////////////////////////////////
  function BttAdjust() {
    if (!$('.emp_checkbox').is(':checked')){
      alert('Please select employee!');
      return false;
    }if ($('.emp_checkbox').is(':checked')){
      $('#adjust_multi').modal('show');
    }
  }


//! /////////////////////////////////
$('document').ready(function() {
  // select all checkbox
  $(document).on('click', '#select_all', function() {
    $(".emp_checkbox").prop("checked", this.checked);
    $("#select_count").html($("input.emp_checkbox:checked").length+" Selected");
  });
  $(document).on('click', '.emp_checkbox', function() {
    if ($('.emp_checkbox:checked').length == $('.emp_checkbox').length) {
      $('#select_all').prop('checked', true);
    } else {
      $('#select_all').prop('checked', false);
    }
    $("#select_count").html($("input.emp_checkbox:checked").length+" Selected");
  });
});

$(document).ready(function (){
   var table = $('#TableGen').DataTable({
      'columnDefs': [{
         'targets': 0,
         'searchable':false,
         'orderable':false,
      }],
      'order': [1, 'asc'],
    'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]]
   });
});

  /*$(document).ready(function () {
  var table = $('#TableGen').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      //'order': [1, 'desc'],
      //'order': [1,2, 'desc'],
      //'order': false,
      'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
      'columnDefs': [{'targets': 0,'searchable':false,'orderable':false,}]
      });
  });*/


	/*function check_click(){
	 if(document.getElementById('CheckRFID').click){
	 document.getElementById('txtRFID').disabled = false;
	 document.getElementById("txtRFID").value = "";
	 document.getElementById("txtRFID").focus();
	 }
	}

    function BttRegister() {
      if((document.frmEmp.txtRFID.value == "") || (document.getElementById('txtRFID').disabled = true)){
      alert('Please edit RFID..');
        document.frmEmp.txtRFID.focus();
      return false;
      }
      if(document.frmEmp.txtempID.value == ""){
      alert('Please enter Employee..');
        document.frmEmp.txtempID.focus();
      return false;
      }
    }

	$(document).ready(function () {
	  $('.LanguageOnly').keypress(function (e) {
			var regex = new RegExp("^[a-zA-Z0-9 ]+$");
			var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
			if (regex.test(str)) {
				return true;
			}
			e.preventDefault();
			return false;
		});
	})

	function CheckInput() {
		var FineEmpID = document.getElementById("FineEmpID");
		var ShowCardID = document.getElementById("txtCardID");
		if (ShowCardID.value == "") {
						FineEmpID.focus();
		 }
	}

	$(document).ready(function(){
	    $("#formname").on("change", "input:checkbox", function(){
	        $("#formname").submit();
	    });
	});*/