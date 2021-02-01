<?php
    include "../alert/alert_session.php";
    include "../alert/alert_user.php";
    include "../../database/conn_sqlsrv.php";
    //include "../database/conn_odbc.php";
    //include "../../database/conn_mysql.php";
    include "../alert/data_detail.php";

    if(isset($_POST["inputDemo"])) {

        // $str = trim($_POST["inputDemo"]);
        // $FineDataEmp = addslashes($str);
        // $vowels = array("'");
        // $inputDemo = str_replace($vowels, '', $str);

        // $inputDemo = strip_tags(htmlspecialchars($_POST['inputDemo']));
        // $inputDemo = ((isset($_POST['inputDemo'])) ? $_POST['inputDemo'] : NULL);

        $inputDemo = $_POST["inputDemo"];

        foreach($inputDemo as $SuppComm) {
            $SuppMark .= "'".$SuppComm."',";
        }
        $SuppInsert = substr($SuppMark, 0, -1);

        // $ListSql = "SELECT 
        // dbo.ReqUser.EmpUserID, HRSystem.dbo.eEmployee.sEmpEngNamePrefix,
        // dbo.ReqUser.EmpUserName, dbo.ReqUser.EmpUserSurname,
        // dbo.ReqUser.EmpUserPosition, dbo.ReqUser.EmpUserSection
        // FROM dbo.ReqUser INNER JOIN
        // HRSystem.dbo.eEmployee ON dbo.ReqUser.EmpUserID 
        // COLLATE SQL_Latin1_General_CP1_CI_AS = HRSystem.dbo.eEmployee.sEmpID
        // WHERE (dbo.ReqUser.Status <> 0)
        // AND (dbo.ReqUser.EmpUserID IN ($SuppInsert))";

        $ListSql = "SELECT 
        dbo.ReqUser.EmpUserID, dbo.Requser.EmpUserSection,
        dbo.ReqUser.EmpUserName, dbo.ReqUser.EmpUserSurname,
        dbo.ReqUser.EmpUserPosition, dbo.ReqUser.EmpUserSection
        FROM dbo.ReqUser WHERE (dbo.ReqUser.Status <> 0)
        AND (dbo.ReqUser.EmpUserID IN ($SuppInsert)) ";
		
		
// SELECT dbo.ReqUser.EmpUserID, dbo.ReqUser.EmpUserName, dbo.ReqUser.EmpUserSurname, dbo.ReqUser.EmpUserPosition, dbo.ReqUser.EmpUserSection, HRSystem.dbo.eEmployee.sEmpEngNamePrefix
// FROM dbo.ReqUser INNER JOIN
// HRSystem.dbo.eEmployee ON dbo.ReqUser.EmpUserID = HRSystem.dbo.eEmployee.sEmpID
// WHERE (dbo.ReqUser.EmpUserID IN ('11374')) 
// AND (dbo.ReqUser.Status <> 0) 
// AND (LEN(dbo.ReqUser.EmpUserID) <= 7)
// AND (dbo.ReqUser.EmpUserID NOT LIKE '%SUB%')

        $ListIParams = array();
        $ListIOptions =  array("Scrollable" => SQLSRV_CURSOR_KEYSET);
        $ListIStmt = sqlsrv_query($connRequest, $ListSql, $ListIParams, $ListIOptions);
        $ListIRow = sqlsrv_num_rows($ListIStmt);

        $output = '
            <div class="border bg-dark text-light mt-3 rounded p-3">
                <div class="text-greenblue"><strong>Trainees : '.$ListIRow.'</strong></div>
            <div class="form-row">
        ';

        if ($ListIRow > 0) {
            $iScore = 1;
            $ListObj = sqlsrv_query($connRequest, $ListSql);
            while ($ListResult = sqlsrv_fetch_array($ListObj, SQLSRV_FETCH_ASSOC)) {
        
        $output .= '
          <div class="col-lg-6 text-uppercase">
            <span style="font-size: 14px;">'.$iScore++.') '.$ListResult["EmpUserID"]." - ".$ListResult["sEmpEngNamePrefix"] . "\n" . $ListResult["EmpUserName"] . "\n" . $ListResult["EmpUserSurname"].'</span>
            <input type="checkbox" name="inputTrainees[]" id="inputTrainees" value="'.$ListResult["EmpUserID"].'" hidden checked>
          </div>
        ';
            }
        }

        $output .= '
            </div>
        </div>
        ';

        print $output;

    }

    ?>


