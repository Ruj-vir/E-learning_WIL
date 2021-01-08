<?php
    include "../alert/alert_session.php";
    include "../../database/conn_sqlsrv.php";
    //include "../database/conn_mysql.php";
    include "../alert/alert_user.php";
    include "../alert/data_detail.php";



    //! ///////////////////////////////////////
	if(isset($_POST["EditRFID"])) {

        $EmpID = trim($_POST["IdPanel_Emp"]);
        $RFIDOld = trim($_POST["IdPanel_RFID"]);
        $RFIDNew = trim($_POST["inputRFID"]);


        $EmpID = strip_tags(htmlspecialchars($EmpID));
        $RFIDOld = strip_tags(htmlspecialchars($RFIDOld));
        $RFIDNew = strip_tags(htmlspecialchars($RFIDNew));
        //$FineDataEmp = addslashes($str);
        $vowels = array("'");
        $RFIDNew = str_replace($vowels,'', $RFIDNew);
        
        if(strlen($RFIDNew) == 10){

		$EditRFIDSql = "SELECT RFIDNo FROM RFID_Master WHERE (RFIDNo = '$RFIDNew') AND (Status = 1) ";
		$EditRFIDParams = array();
		$EditRFIDOptions =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
		$EditRFIDStmt = sqlsrv_query( $connCanteen, $EditRFIDSql , $EditRFIDParams, $EditRFIDOptions );
		$row_count = sqlsrv_num_rows( $EditRFIDStmt );

		if ($row_count > 0) {
            echo "<script type=text/javascript>alert('This RFID has already been used.');window.top.window.CanteenResult('0');</script>";
            exit();
		}else {
			$sql = "UPDATE RFID_Master SET
			RFIDNo = ? ,
			UpdatedBy = ?,
			UpdatedDate = GETDATE()
			WHERE EmpID = ? AND RFIDNo = ?";
			$param = array($RFIDNew, $SesUserID, $EmpID, $RFIDOld);

			$stmt = sqlsrv_query( $connCanteen, $sql, $param);
			if( $stmt === false ) {
                //die( print_r( sqlsrv_errors(), true));
				echo "<script type=text/javascript>alert('Unsuccessful error!');window.top.window.CanteenResult('0');</script>";
				exit();
			}
			else{
				echo "<script type=text/javascript>window.top.window.CanteenResult('1');</script>";
				exit();
			}
        }
        
        }else {
            echo "<script type=text/javascript>alert('Can enter no more than 10 characters.');window.top.window.CanteenResult('0');</script>";
            exit(); 
        }

    }
    



    //! ///////////////////////////////////////
    else if(isset($_POST["EditStateRFID"])) {

        $EmpID = trim($_POST["IdPanel_State_Emp"]);
        $RFIDOld = trim($_POST["IdPanel_State_RFID"]);
        $StatusRFID = trim($_POST["StatusRFID"]);

        $EmpID = strip_tags(htmlspecialchars($EmpID));
        $RFIDOld = strip_tags(htmlspecialchars($RFIDOld));
        $StatusRFID = strip_tags(htmlspecialchars($StatusRFID));

        if($StatusRFID == 0) {
            $StatusSql = "UPDATE RFID_Master SET
            RFIDNo = ? ,
            Status = ? ,
            UpdatedBy = ?,
            UpdatedDate = GETDATE()
            WHERE EmpID = ? AND RFIDNo = ?";
            $StatusParam = array($RFIDOld, $StatusRFID, $SesUserID, $EmpID, $RFIDOld);
    
            $StatusStmt = sqlsrv_query($connCanteen, $StatusSql, $StatusParam);
            if( $StatusStmt === false ) {
                //die( print_r( sqlsrv_errors(), true));
                echo "<script type=text/javascript>alert('Unsuccessful error!');window.top.window.CanteenResult('0');</script>";
                exit();
            }else {
                echo "<script type=text/javascript>window.top.window.CanteenResult('1');</script>";
                exit();
            }
        }else {
            $EditStatusSql = "SELECT RFIDNo FROM RFID_Master WHERE (RFIDNo = '$RFIDOld') AND (Status = 1) ";
            $EditStatusParams = array();
            $EditStatusOptions =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
            $EditStatusStmt = sqlsrv_query( $connCanteen, $EditStatusSql , $EditStatusParams, $EditStatusOptions );
            $row_count_Status = sqlsrv_num_rows( $EditStatusStmt );
    
            if ($row_count_Status > 0) {
                echo "<script type=text/javascript>alert('This RFID has already been used.');window.top.window.CanteenResult('0');</script>";
                exit();
            }else {
                $StatusSql = "UPDATE RFID_Master SET
                RFIDNo = ? ,
                Status = ? ,
                UpdatedBy = ?,
                UpdatedDate = GETDATE()
                WHERE EmpID = ? AND RFIDNo = ?";
                $StatusParam = array($RFIDOld, $StatusRFID, $SesUserID, $EmpID, $RFIDOld);
        
                $StatusStmt = sqlsrv_query($connCanteen, $StatusSql, $StatusParam);
                if( $StatusStmt === false ) {
                    //die( print_r( sqlsrv_errors(), true));
                    echo "<script type=text/javascript>alert('Unsuccessful error!');window.top.window.CanteenResult('0');</script>";
                    exit();
                }else {
                    echo "<script type=text/javascript>window.top.window.CanteenResult('1');</script>";
                    exit();
                }
            }
        }

    }


    //! ///////////////////////////////////////
    else if(isset($_POST["AddNewRFID"])) {

        $InputEmpID = trim($_POST["InputEmpID"]);
        $InputRFID = trim($_POST["InputRFID"]);

        $InputEmpID = strip_tags(htmlspecialchars($InputEmpID));
        $InputRFID = strip_tags(htmlspecialchars($InputRFID));
        //$FineDataEmp = addslashes($str);
        $vowels = array("'");
        $InputRFID = str_replace($vowels,'', $InputRFID);

        if(strlen($InputRFID) == 10){
    
            $CanRegisSql = "SELECT RFIDNo
            FROM RFID_Master WHERE (EmpID = '$InputEmpID') AND (RFIDNo = '$InputRFID') AND (Status = 1)";
            $params = array();
            $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
            $CanRegisObj = sqlsrv_query( $connCanteen, $CanRegisSql , $params, $options );
            $num_rows = sqlsrv_num_rows($CanRegisObj);
            
            if ($num_rows > 0) {
                echo "<script type=text/javascript>alert('This RFID cannot be used.');window.top.window.CanteenResult('0');</script>";
                exit();
            }else {
                $RFIDAddSql = "INSERT INTO RFID_Master (RFIDNo, Status, UpdatedBy, UpdatedDate, EmpID) VALUES (?, ?, ?, GETDATE(), ?)";
                $RFIDAddParam = array($InputRFID, 1, $SesUserID, $InputEmpID);
                $RFIDAddStmt = sqlsrv_query($connCanteen, $RFIDAddSql, $RFIDAddParam);
        
                if( $RFIDAddStmt === false ) {
                    //die( print_r( sqlsrv_errors(), true));
                    echo "<script type=text/javascript>alert('Unsuccessful error!');window.top.window.CanteenResult('0');</script>";
                    exit();
                }
                else{
                    echo "<script type=text/javascript>window.top.window.CanteenResult('1');</script>";
                    exit();
                }
            }

        }else {
            echo "<script type=text/javascript>alert('Can enter no more than 10 characters.');window.top.window.CanteenResult('0');</script>";
            exit(); 
        }

    }





    //! ///////////////////////////////////////
    else if(isset($_GET["DeleteKey"]) == "3") {

        $DropEmpID = trim($_GET["DropEmpID"]);
        $DropRFID = trim($_GET["DropRFID"]);

        $DropEmpID = strip_tags(htmlspecialchars($DropEmpID));
        $DropRFID = strip_tags(htmlspecialchars($DropRFID));
        //$FineDataEmp = addslashes($str);
        $vowels = array("'");
        $DropRFID = str_replace($vowels,'', $DropRFID);

	    $DropSql = "DELETE RFID_Master WHERE EmpID = ? AND RFIDNo = ?";
		$DropParam = array($DropEmpID, $DropRFID);
        $DropStm = sqlsrv_query($connCanteen, $DropSql, $DropParam);
        
			if($DropStm === false) {
				echo "<script type=text/javascript>alert('Unsuccessful error!');javascript:history.back(1);</script>";
				exit();
			}else{
				echo "<script type=text/javascript>javascript:history.back(1);</script>";
				exit();
			}
	}

?>