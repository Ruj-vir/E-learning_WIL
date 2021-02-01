</body>

</html>


<script type="text/javascript">
	$(document).ready(function() {
		$(".anima2").hide();
		$("#BTenter").click(function() {
			$("#BTenter").hide(200);
		});
	});

	$(document).ready(function() {
		$(".close").click(function() {
			$("#BTenter").show(200);
		});
	});

	$('#MyModal').modal({
		backdrop: 'static',
		keyboard: false,
		show: false
	});

	$('#NewPass').modal({
		backdrop: 'static',
		keyboard: false,
		show: false
	});

	function TextUser() {
		document.getElementById('Username').value = document.getElementById('txtUsername').value;
	}

	function TextPass() {
		document.getElementById('Current').value = document.getElementById('txtPassword').value;
	}

	$(document).ready(function() {
		$('.EngOnly_demo').keypress(function(e) {
			var regex = new RegExp("^[a-zA-Z0-9 ]+$");
			var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
			if (regex.test(str)) {
				return true;
			}
			e.preventDefault();
			return false;
		});
	});

	/*function PassCheck(){
	if(document.ChangePass.Current.value==""){
		document.getElementById("Current").required = true;
		return false;
	}else if(document.ChangePass.NewPass1.value==""){
		document.getElementById("NewPass1").required = true;
		return false;
	}else if(document.ChangePass.NewPass2.value==""){
		document.getElementById("NewPass2").required = true;
		return false;
	}else if(document.ChangePass.NewPass1.value != document.ChangePass.NewPass2.value){
		alert('You do not match the password.');
		document.ChangePass.NewPass1.focus();
		return false;
	}
    else if(confirm('Are you sure you want to submit the form ?')==true){
        return true;
    }else{
        return false;
    }
	return true;
	}*/


	function showResult(result) {
		if (result == 1) {
			$('#MyModal').modal('hide'),
				$(".anima1").hide(),
				$(".anima2").show(),
				setTimeout(function() {
					window.location.href = "../e_learning/";
				}, 3000);
		} else if (result == 2) {


			$(document).ready(function() {

				alert('Please change your password.');
				$('#MyModal').modal('hide');
				$('#NewPass').modal('show');



				$('#login').click(function() {
					var Username = $('#Username').val();
					var Current = $('#Current').val();
					var NewPass1 = $('#NewPass1').val();
					var NewPass2 = $('#NewPass2').val();
					if ($.trim(Username).length > 0 && $.trim(Current).length > 0 && $.trim(NewPass1).length >= 8 && $.trim(NewPass2).length >= 8) {

						if (document.ChangePass.NewPass1.value == document.ChangePass.NewPass2.value) {
							$.ajax({
								url: "check_uppass.php",
								method: "POST",
								data: {
									Username: Username,
									Current: Current,
									NewPass1: NewPass1,
									NewPass2: NewPass2
								},
								/*cache:false,
								beforeSend:function(){
								 $('#login').val("Loading...");
								},*/
								success: function(data) {
									if (data == 500) {
										//$("body").load("home.php").hide().fadeIn(1500);
										//$('#loginModal').hide();  
										//location.reload();
										window.location.href = ('index.php');

									} else if (data == 10) {
										//$('#ChangePass').trigger("reset");
										$('#error').html("<div class='alert alert-danger' role='alert'>This password does not work.</div>");
									} else if (data == 20) {
										//$('#ChangePass').trigger("reset");
										$('#error').html("<div class='alert alert-danger' role='alert'>An error has occurred in the system.</div>");
									} else if (data == 30) {
										//$('#ChangePass').trigger("reset");
										$('#error').html("<div class='alert alert-danger' role='alert'>Username and Password Incorrect.</div>");
									} else if (data == 40) {
										//$('#ChangePass').trigger("reset");
										$('#error').html("<div class='alert alert-danger' role='alert'>Passwords should have 8 or more digits.</div>");
									} else if (data == 50) {
										//$('#ChangePass').trigger("reset");
										$('#error').html("<div class='alert alert-danger' role='alert'>Unsuccessful error.</div>");
									}
								}
							});
						} else {
							//alert('You do not match the password.');
							$('#error').html("<div class='alert alert-danger' role='alert'>You do not match the password.</div>");
							document.ChangePass.NewPass1.focus();
							return false;
						}

					} else {
						//document.formRequest.NewPass2.focus();
						$('#error').html("<div class='alert alert-danger' role='alert'>Passwords should have 8 or more digits.</div>");
					}
				});

			});


		}
	}
</script>