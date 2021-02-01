<?php
    include "../alert/alert_session.php";
    include "../alert/alert_user.php";
    include "../../database/conn_sqlsrv.php";
    //include "../database/conn_odbc.php";
    include "../../database/conn_mysql.php";
    include "../alert/data_detail.php";
    

if(isset($_POST["action"])){

 $output = '';

 if($_POST["action"] == "brand"){
    if($_POST["query"] == 2){
        $query = "SELECT PositionNameEN FROM positionoffice WHERE (Status = 1) ORDER BY PositionNameEN ASC";
        $result = mysqli_query($connWorkplace, $query);
        $output .= '<option value="">Select Position</option>';
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
        {
         $output .= '<option value="'.$row["PositionNameEN"].'">'.$row["PositionNameEN"].'</option>';
        }
     }
     else if($_POST["query"] == 3){
        $query = "SELECT SectionNameEN FROM sectionoffice WHERE (Status = 1) ORDER BY SectionNameEN ASC";
        $result = mysqli_query($connWorkplace, $query);
        $output .= '<option value="">Select Section</option>';
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
        {
         $output .= '<option value="'.$row["SectionNameEN"].'">'.$row["SectionNameEN"].'</option>';
        }
     }else {
        $output .= '<option value="">All</option>';
     }
 }

 echo $output;
}
?>

