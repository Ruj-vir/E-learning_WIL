<?php
    include "../alert/alert_session.php";
    include "../alert/alert_user.php";
    include "../../database/conn_sqlsrv.php";
    //include "../database/conn_odbc.php";
    include "../../database/conn_mysql.php";
    include "../alert/data_detail.php";
    

if(isset($_POST["brand"], $_POST["item"])){

 $output = '';

 $item = $_POST["item"];

 $output .= '
 <div class="input-group input-group-sm">
 <div class="input-group-prepend">
   <label class="input-group-text" for="inputFilter" id="select_count">0 Selected</label>
 </div>
   <input type="text" class="form-control form-control-sm" id="inputFilter" name="inputFilter" placeholder="Filter">
</div>
<div class="table-responsive custom-scrollbar">
   <table class="table table-striped table-sm table-hover">
       <thead class="thead-dark">
           <tr>
               <th scope="col" width="30"></th>
               <th scope="col">ID</th>
               <th scope="col">Name/Surname</th>
               <th scope="col">Position</th>
               <th scope="col">Section</th>
           </tr>
       </thead>
       <tbody class="tbody">';
       
        if($_POST["brand"] == 1){
            $TraineesSQL = "SELECT EmpUserID,EmpUserName,EmpUserSurname,EmpUserPosition,EmpUserSection FROM ReqUser WHERE (Status <> 0) ORDER BY EmpUserID ASC";
        }else if($_POST["brand"] == 2){
            $TraineesSQL = "SELECT EmpUserID,EmpUserName,EmpUserSurname,EmpUserPosition,EmpUserSection FROM ReqUser WHERE (EmpUserPosition = '$item') AND (Status <> 0) ORDER BY EmpUserID ASC";
        }else if($_POST["brand"] == 3){
            $TraineesSQL = "SELECT EmpUserID,EmpUserName,EmpUserSurname,EmpUserPosition,EmpUserSection FROM ReqUser WHERE (EmpUserSection = '$item') AND (Status <> 0) ORDER BY EmpUserID ASC";
        }else {
            $TraineesSQL = "SELECT EmpUserID,EmpUserName,EmpUserSurname,EmpUserPosition,EmpUserSection FROM ReqUser WHERE (Status <> 0) ORDER BY EmpUserID ASC";
        }

           $Traineesobj = sqlsrv_query($connRequest, $TraineesSQL);
           while ($TraineesResult = sqlsrv_fetch_array($Traineesobj, SQLSRV_FETCH_ASSOC)) {
        $output .= '
               <tr class="tr">
                   <td><input type="checkbox" class="emp_checkbox pointer" name="inputTrainees[]" id="inputTrainees" value="'.$TraineesResult["EmpUserID"].'"></td>
                   <td>'.$TraineesResult["EmpUserID"].'</td>
                   <td>'.$TraineesResult["EmpUserName"]."\n".$TraineesResult["EmpUserSurname"].'</td>
                   <td>'.$TraineesResult["EmpUserPosition"].'</td>
                   <td>'.$TraineesResult["EmpUserSection"].'</td>
               </tr>';
            }
        $output .= '
       </tbody>
   </table>
</div>';



    // if($_POST["brand"] == 2 && $item != NULL){
    //     $TraineesSQL = "SELECT EmpUserID,EmpUserName,EmpUserSurname,EmpUserPosition,EmpUserSection FROM ReqUser WHERE (EmpUserPosition = '$item') AND (Status <> 0) ORDER BY EmpUserID ASC";
    //     $Traineesobj = sqlsrv_query($connRequest, $TraineesSQL);
    //     //$output .= '<select name="inputTrainees[]" id="inputTrainees" multiple required onchange="getValues()">';
    //     while ($TraineesResult = sqlsrv_fetch_array($Traineesobj, SQLSRV_FETCH_ASSOC)) {
    //         $output .= '
    //         <option value="'.$TraineesResult["EmpUserID"].'">
    //             '.$TraineesResult["EmpUserID"] . " - " . $TraineesResult["EmpUserName"] . " " . $TraineesResult["EmpUserSurname"].'
    //         </option>';
    //     }
    //     //$output .= '</select>';

    // }else if($_POST["brand"] == 3 && $item != NULL){
    //     $TraineesSQL = "SELECT EmpUserID,EmpUserName,EmpUserSurname,EmpUserPosition,EmpUserSection FROM ReqUser WHERE (EmpUserSection = '$item') AND (Status <> 0) ORDER BY EmpUserID ASC";
    //     $Traineesobj = sqlsrv_query($connRequest, $TraineesSQL);
    //     //$output .= '<select name="inputTrainees[]" id="inputTrainees" multiple required onchange="getValues()">';
    //     while ($TraineesResult = sqlsrv_fetch_array($Traineesobj, SQLSRV_FETCH_ASSOC)) {
    //         $output .= '
    //         <option value="'.$TraineesResult["EmpUserID"].'">
    //             '.$TraineesResult["EmpUserID"] . " - " . $TraineesResult["EmpUserName"] . " " . $TraineesResult["EmpUserSurname"].'
    //         </option>';
    //     }
    //     //$output .= '</select>';

    // }else if($_POST["brand"] == 1){
    //     $TraineesSQL = "SELECT EmpUserID,EmpUserName,EmpUserSurname,EmpUserPosition,EmpUserSection FROM ReqUser WHERE (Status <> 0) ORDER BY EmpUserID ASC";
    //     $Traineesobj = sqlsrv_query($connRequest, $TraineesSQL);
    //     //$output .= '<select name="inputTrainees[]" id="inputTrainees" multiple required onchange="getValues()">';
    //     while ($TraineesResult = sqlsrv_fetch_array($Traineesobj, SQLSRV_FETCH_ASSOC)) {
    //         $output .= '
    //         <option value="'.$TraineesResult["EmpUserID"].'">
    //             '.$TraineesResult["EmpUserID"] . " - " . $TraineesResult["EmpUserName"] . " " . $TraineesResult["EmpUserSurname"].'
    //         </option>';
    //     }
    //     //$output .= '</select>';
    // }else{

    // }



 echo $output;
}


?>

<script type="text/javascript">
    $('document').ready(function() {
        // select all checkbox
        $(document).on('click', '#select_all', function() {
            $(".emp_checkbox, .checkdate").prop("checked", this.checked);
            $("#select_count").html($("input.emp_checkbox:checked").length + " Selected");
        });
        $(document).on('click', '.emp_checkbox', function() {
            if ($('.emp_checkbox:checked').length == $('.emp_checkbox').length) {
                $('#select_all').prop('checked', true);
            } else {
                $('#select_all').prop('checked', false);
            }
            $("#select_count").html($("input.emp_checkbox:checked").length + " Selected");
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#inputFilter").on("keyup change", function() {
            var value = $(this).val().toLowerCase();
            $("table.table tbody.tbody tr.tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>

<script type="text/javascript">
    // duallistbox(document.getElementById('inputTrainees'));
    // function getValues() {
    //     document.getElementById('values').innerText = [...document.getElementById('inputTrainees').selectedOptions].map(o => o.textContent).join('')
    // }
    // getValues();
</script>