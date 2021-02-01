<?php
    include "../alert/alert_session.php";
    include "../alert/alert_user.php";
    include "../../database/conn_sqlsrv.php";
    //include "../database/conn_odbc.php";
    include "../../database/conn_mysql.php";
	include "../alert/data_detail.php";
	

    if(isset($_POST["DateTo"])) {

        $DateFrom = $_POST["DateFrom"];//'2020-04-18 06:00:00';//
        $DateTo = $_POST["DateTo"];//'2020-04-18 18:00:00';//
  
        if(($DateFrom == date('Y-m-d',strtotime($DateFrom))) && ($DateTo == date('Y-m-d',strtotime($DateTo)))) {
  
            $output .= '<div class="hidden-scroll-y custom-scrollbar">
              <div class="blog-card">';

				$sql = "SELECT DISTINCT
                dbo.ReqInfo.ReqNo, 
                dbo.ReqInfo.ReqRemark, 
                dbo.ReqInfo.ReqDay, 
                dbo.ReqInfo.ReqHour, 
                dbo.ReqInfo.ReqSumTime, 
                dbo.ReqInfo.UserDefine1, 
                dbo.ReqInfo.ReqDate, 
                dbo.ReqInfo.TrnTime, 

                dbo.ReqUser.EmpUserID, 
                dbo.ReqUser.EmpUserName, 
                dbo.ReqUser.EmpUserSurname, 
                dbo.ReqUser.EmpUserPosition, 
                dbo.ReqUser.EmpUserSection, 
                dbo.ReqUser.EmpUserDepartment
				
				FROM dbo.ReqInfo 
				INNER JOIN dbo.ReqUser ON dbo.ReqInfo.ReqIssuer = dbo.ReqUser.EmpUserID
				WHERE (dbo.ReqInfo.ReqChecker = '$SesUserID') AND (dbo.ReqInfo.ReqType = 4) AND (dbo.ReqInfo.ReqCheckDate IS NOT NULL)
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
            $EleData = explode('|', $result["UserDefine1"]);
            
				  $output .= '
						  <div class="description">
						  <div class="border-card border-right-0 border-left-0 border-bottom-0">
							<div class="card-type-icon"><strong class="mr-2">'.$i++.' )</strong></div>
					  <!--<img class="card-type-icon with-border" src="../img/user_photo/#.jpg" alt="No picture">-->
						  <div class="content-wrapper">
							<div class="min-width-name">
							<p class="title text-truncate"><strong class="caption">Course:</strong> '.$result["ReqRemark"].'</p>
							<p class="title text-truncate"><strong class="caption">Requestor:</strong> '.$result["EmpUserID"]." - ".$result["EmpUserName"]."\n".$result["EmpUserSurname"].'</p>
							</div>
							<div class="min-gap"></div>
							<div class="label-group min-width-dept">
							  <p class="title"><strong class="caption">Date:</strong> '.date_format($result["ReqDate"], 'd/m/Y') . " - " . date_format($result["TrnTime"], 'd/m/Y').'</p>
							  <p class="title"><strong class="caption">Time:</strong> '.date_format($result["ReqDate"], 'H:i') . " - " . date_format($result["TrnTime"], 'H:i').'</p>
							</div>
							<div class="min-gap"></div>
							<div class="label-group min-width-req">
							  <p class="title"><strong class="caption">Location:</strong> '.$EleData[3].'</p>
							  <p class="title"><strong class="caption">Cost:</strong> '.number_format($result["ReqSumTime"], 2). ' THB</p>
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
          url: "return/return_checked.php",
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