<?php
    include "../alert/alert_session.php";
    include "../../database/conn_sqlsrv.php";
    //include "../database/conn_odbc.php";
    include "../../database/conn_mysql.php";
    include "../alert/alert_user.php";
	include "../alert/data_detail.php";
	

    if(isset($_POST["DateTo"])) {

        $DateFrom = $_POST["DateFrom"];//'2020-04-18 06:00:00';//
        $DateTo = $_POST["DateTo"];//'2020-04-18 18:00:00';//
  
        if(($DateFrom == date('Y-m-d',strtotime($DateFrom))) && ($DateTo == date('Y-m-d',strtotime($DateTo)))) {
  
            $output .= '<div class="hidden-scroll-y custom-scrollbar">
              <div class="blog-card">';

				$sql = "SELECT DISTINCT ReqInfo.ReqNo, ReqInfo.ReqRemark, ReqInfo.ReqDay, ReqInfo.ReqHour, 
                ReqInfo.ReqSumTime, ReqInfo.ReqIssuer, ReqUser.EmpUserName, ReqUser.EmpUserSurname, 
                ReqUser.EmpUserPosition, ReqUser.EmpUserSection, ReqUser.EmpUserDepartment
				
				FROM dbo.ReqInfo 
				INNER JOIN dbo.ReqUser ON dbo.ReqInfo.ReqIssuer = dbo.ReqUser.EmpUserID
				WHERE (dbo.ReqInfo.UpdateBy = '$SesUserID') AND (dbo.ReqInfo.ReqType = 4) AND (dbo.ReqInfo.UpdateDate IS NOT NULL)
				AND ((dbo.ReqInfo.ReqDate >= '$DateFrom 00:00:00' AND dbo.ReqInfo.TrnTime <= '$DateTo 23:59:59')
				OR (dbo.ReqInfo.TrnTime >= '$DateFrom 00:00:00' AND dbo.ReqInfo.ReqDate <= '$DateTo 23:59:59'))
				--OR (dbo.ReqInfo.ReqCheckDate >= '$DateStart 00:00:00' AND dbo.ReqInfo.ReqCheckDate <= '$DateEnd 00:00:00')
  
				ORDER BY dbo.ReqInfo.ReqNo DESC";
				$params = array();
				$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
				$stmt = sqlsrv_query( $connRequest, $sql , $params, $options );
				$row_count = sqlsrv_num_rows( $stmt );
	
				if($row_count > 0 ){
					
				  $i=1;
				  $query = sqlsrv_query($connRequest, $sql);
				  while($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
				
				  $output .= '
						  <div class="description">
						  <div class="border-card border-right-0 border-left-0 border-bottom-0">
							<div class="card-type-icon"><strong class="mr-2">'.$i++.' )</strong></div>
					  <!--<img class="card-type-icon with-border" src="../img/user_photo/#.jpg" alt="No picture">-->
						  <div class="content-wrapper">
							<div class="min-width-name">
							<p class="title"><strong class="caption">ID:</strong> '.$result["ReqIssuer"].'</p>
							<p class="title"><strong class="caption">Name:</strong> '.$result["EmpUserName"]."\n".$result["EmpUserSurname"].'</p>
							</div>
							<div class="min-gap"></div>
							<div class="label-group min-width-dept">
							  <p class="title"><strong class="caption">Dept.:</strong> '.$result["EmpUserDepartment"].'</p>
							  <p class="title"><strong class="caption">Section:</strong> '.$result["EmpUserSection"].'</p>
							</div>
							<div class="min-gap"></div>
							<div class="label-group min-width-req">
							  <p class="title"><strong class="caption">Course:</strong> '.$result["ReqRemark"].'</p>
							  <p class="title"><strong class="caption">Duration:</strong> '.round($result["ReqDay"], 2).'Day, '.round($result["ReqHour"], 2).'Hrs</p>
							</div>
						  </div>
						  <button type="button" class="btn btn-greenblue end-icon BttLookModalChecked" data-toggle="modal" data-id="'.$result["ReqNo"].'"><i class="fa fa-eye"></i></button>
						  </div>
						  </div>';
					  }
					}else {
					  $output .= '
				  <div class="alert alert-white text-center" role="alert">
					No data available in table
				  </div>';
				 
					}
		  $output .= '
				</div>
		  </div>';

		}
		echo $output;
	}


?>



<script type="text/javascript">

  $(document).ready(function() {
    $('.BttLookModalChecked').click(function() {
      var ids = $(this).attr('data-id');
      $("#txtNoDetail").val(ids);
      $('.ModalChecked').modal('show');
      var Item_ReqNo = $('#txtNoDetail').val();
      if (Item_ReqNo != '') {
        $.ajax({
          url: "return/return_approved.php",
          method: "POST",
          data: {
            Item_ReqNo: Item_ReqNo
          },
          success: function(data) {
            $('#emp_Detail').html("" + $.trim(data) + "");
          }
        });
      }
      /*else {
        alert("Please select the employee!!");
      }*/
    });
  });


  /*$(document).ready(function(){
    $('.BttChecked').click(function(){
      var Item_ReqNo = $('#txtNoDetail').val();
      if(Item_ReqNo != ''){
        $.ajax({
          url:"return/return_checked.php",
          method:"POST",
          data:{ Item_ReqNo:Item_ReqNo },
          success:function(data){
            $('#emp_Detail').html( "" + $.trim(data) + "" );
          }
        });
      }
      else {
        alert("Please select the employee!!");
      }
    });
  });

    $(".BttChecked").click(function () {
      var ids = $(this).attr('data-id');
      $("#txtNoDetail").val( ids );
      $('.ModalChecked').modal('show');
    });*/

  </script>