

		<!--<footer class="footer">
		  <div class="container-fluid">
			<span class="text-light">© 2020 - Thai Daizo Aerosol Co.Ltd</span>
		  </div>
		</footer>-->
	  </div>

	
  <script src="../tools/jquery/jquery.min.js"></script>
  <script src="../tools/vendor/js/popper.min.js"></script>
  <script src="../tools/bootstrap/js/bootstrap.min.js"></script>
  
  
  <script type="text/javascript">
  
      //! //////////////////////////////////////
	  function ProfileResult(result_NewProfile) {
        if(result_NewProfile == 1) {
          window.location.href = "../profile.php";
          //location.reload();2
          //location.href = location.href;
        }else {
          //window.location.href = "ot-request.php";
        }
      }
  
  
	$(function() {
	  // Sidebar toggle behavior
	  $('#sidebarCollapse').on('click', function() {
		$('#sidebar, #content').toggleClass('active');
	  });
	});
	
	var dropdown = document.getElementsByClassName("dropdown-btn");
	var i;

	for (i = 0; i < dropdown.length; i++) {
	  dropdown[i].addEventListener("click", function() {
	  this.classList.toggle("active");
	  var dropdownContent = this.nextElementSibling;
	  if (dropdownContent.style.display === "block") {
	  dropdownContent.style.display = "none";
	  } else {
	  dropdownContent.style.display = "block";
	  }
	  });
	}
	
	function MailCheck(){
	if(document.ChangeMail.mailnew_01.value==""){
		alert('Please enter a new email.');
	    document.ChangeMail.mailnew_01.focus();
		return false;
	}else if(document.ChangeMail.mailfirm_01.value==""){
		alert('Please confirm the new email.');
	    document.ChangeMail.mailfirm_01.focus();
		return false;
	}else if(document.ChangeMail.mailnew_01.value != document.ChangeMail.mailfirm_01.value){
		alert('You do not match the email.');
		document.ChangeMail.mailfirm_01.focus();
		return false;
	}
    else if(confirm('Are you sure you want to submit the form ?')==true){
        return true;
    }else{
        return false;
    }
	return true;
	}

	function PassCheck(){
	if(document.ChangePass.passold.value==""){
		alert('Please enter the current password.');
	    document.ChangePass.passold.focus();
		return false;
	}else if(document.ChangePass.passnew.value==""){
		alert('Please enter a new password.');
	    document.ChangePass.passnew.focus();
		return false;
	}else if(document.ChangePass.passnew1.value==""){
		alert('Please confirm the new password.');
	    document.ChangePass.passnew1.focus();
		return false;
	}else if(document.ChangePass.passnew.value != document.ChangePass.passnew1.value){
		alert('You do not match the password.');
		document.ChangePass.passnew1.focus();
		return false;
	}
    else if(confirm('Are you sure you want to submit the form ?')==true){
        return true;
    }else{
        return false;
    }
	return true;
	}
	
  </script>

</body>
</html>

