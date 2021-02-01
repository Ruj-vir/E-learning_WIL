<?php
include "../alert/alert_session.php";
include "../alert/alert_user.php";
include "../../database/conn_sqlsrv.php";
//include "../database/conn_odbc.php";
//include "../../database/conn_mysql.php";
include "../alert/data_detail.php";



if (isset($_POST["BttSubmitReq"])) {

    echo "<script>window.top.window.LoadingResult('1');</script>";

    $inputKeyID = strip_tags(htmlspecialchars($_POST['inputKeyID']));

    $inputCourse = strip_tags(htmlspecialchars($_POST['inputCourse']));
    $inputObject = strip_tags(htmlspecialchars($_POST['inputObject']));
    $inputOrganizer = strip_tags(htmlspecialchars($_POST['inputOrganizer']));

    $inputDateFrom = strip_tags(htmlspecialchars($_POST['inputDateFrom']));
    $inputDateTo = strip_tags(htmlspecialchars($_POST['inputDateTo']));
    $inputTimeFrom = strip_tags(htmlspecialchars($_POST['inputTimeFrom']));
    $inputTimeTo = strip_tags(htmlspecialchars($_POST['inputTimeTo']));

    $inputDurationDay = strip_tags(htmlspecialchars($_POST['inputDurationDay']));
    $inputDurationTime = strip_tags(htmlspecialchars($_POST['inputDurationTime']));

    $inputLocation = strip_tags(htmlspecialchars($_POST['inputLocation']));
    $inputCost = strip_tags(htmlspecialchars($_POST['inputCost']));
    $inputType = strip_tags(htmlspecialchars($_POST['inputType']));

    $inputAttach = strip_tags(htmlspecialchars($_POST['inputAttach']));
    $inputImgFile = $_FILES['inputImgFile']['name'];
    $inputPdfFile = $_FILES['inputPdfFile']['name'];
    //$Trainees = strip_tags(htmlspecialchars($_POST['inputTrainees']));


    $Trainees = ((isset($_POST['inputTrainees'])) ? $_POST['inputTrainees'] : NULL);
    foreach ($Trainees as $TraineesComm) {
        $TraineesMark .= "'".$TraineesComm."'" . ",";
    }
    $InTrainees = substr($TraineesMark, 0, -1);

    //! เช็คผู้ตรวจสอบ \\
    $AuthorCheckSQL = "SELECT COUNT(EmpUserID) AS NumAuthorCheck FROM ReqUser WHERE EmpUserID IN ($InTrainees) AND (LvApprove = '' OR LvApprove IS NULL)";
    $AuthorCheckQuery = sqlsrv_query($connRequest, $AuthorCheckSQL);
    $AuthorCheckResult = sqlsrv_fetch_array($AuthorCheckQuery, SQLSRV_FETCH_ASSOC);

    // $AuthorVerifySQL = "SELECT COUNT(EmpUserID) AS NumAuthorVerify FROM ReqUser WHERE EmpUserID IN ($InTrainees) AND (EduVerify = '' OR EduVerify IS NULL)";
    // $AuthorVerifyQuery = sqlsrv_query($connRequest, $AuthorVerifySQL);
    // $AuthorVerifyResult = sqlsrv_fetch_array($AuthorVerifyQuery, SQLSRV_FETCH_ASSOC);

    // $AuthorApproveSQL = "SELECT COUNT(EmpUserID) AS NumAuthorApprove FROM ReqUser WHERE EmpUserID IN ($InTrainees) AND (EduApprove = '' OR EduApprove IS NULL)";
    // $AuthorApproveQuery = sqlsrv_query($connRequest, $AuthorApproveSQL);
    // $AuthorApproveResult = sqlsrv_fetch_array($AuthorApproveQuery, SQLSRV_FETCH_ASSOC);

    $NumAuthorCheck = $AuthorCheckResult["NumAuthorCheck"];
    // $NumAuthorVerify = $AuthorVerifyResult["NumAuthorVerify"];
    // $NumAuthorApprove = $AuthorApproveResult["NumAuthorApprove"];
    //! เช็คผู้ตรวจสอบ \\

	if ($NumAuthorCheck > 0) {
		echo "<script>alert('Error!! There are employees without inspector.');window.top.window.TrainingResult('0');</script>";
		exit();
	} 
	// else if ($NumAuthorVerify > 0) {
	// 	echo "<script>alert('Error!! There are employees without verify.');window.top.window.TrainingResult('0');</script>";
	// 	exit();
	// } else if ($NumAuthorApprove > 0) {
	// 	echo "<script>alert('Error!! There are employees without approver.');window.top.window.TrainingResult('0');</script>";
	// 	exit();
	// } 
	else {

        //! Gen ID \\
        $PeriodQuery = "SELECT convert(varchar(10), GETDATE(), 111) AS DateCurrent, convert(varchar(10), GETDATE(), 108) AS TimeCurrent ";
        $PeriodObj = sqlsrv_query($connRequest, $PeriodQuery);
        $PeriodResult = sqlsrv_fetch_array($PeriodObj, SQLSRV_FETCH_ASSOC);

        $DateCurrent = $PeriodResult["DateCurrent"];
        $TimeCurrent = $PeriodResult["TimeCurrent"];

        $KeyQuery = "SELECT TOP (1) ReqNo,ReqIssueDate FROM ReqInfo ORDER BY ReqNo DESC";
        $KeyObj = sqlsrv_query($connRequest, $KeyQuery);
        $KeyResult = sqlsrv_fetch_array($KeyObj, SQLSRV_FETCH_ASSOC);

        $KeyTime = str_replace(':', '', $TimeCurrent);

        if (isset($KeyResult["ReqIssueDate"]) == NULL) {
            $Key = str_replace('/', '', $DateCurrent);
            $KeyID = (trim($Key . '0001'));
        } else {
            $KeyDate = date_format($KeyResult["ReqIssueDate"], 'Y/m/d');
            $KeyNo = (isset($KeyResult["ReqNo"])) ? $KeyResult["ReqNo"] : NULL;

            if ($KeyDate == $DateCurrent) {
                $KeyID = (trim($KeyNo + 1));
            } else {
                $Key = str_replace('/', '', $DateCurrent);
                $KeyID = (trim($Key . '0001'));
            }
        }
        // $KeyID = $inputKeyID;
        //! Gen ID \\


        $FromPeriod = $inputDateFrom . " " . $inputTimeFrom;
        $ToPeriod = $inputDateTo . " " . $inputTimeTo;

        $vowels = array("|");
        $inputObject = str_replace($vowels, '', $inputObject);
        $inputOrganizer = str_replace($vowels, '', $inputOrganizer);
        $inputLocation = str_replace($vowels, '', $inputLocation);
        $SendInfo = "|" . $inputObject . "|" . $inputOrganizer . "|" . $inputLocation;


        //! เช็ควันเวลา การขอล่วงหน้า \\
        //$date = strtotime($date);
        //$date = strtotime("+1 week", $date);
        //$week = date('Y-m-d', $date);
        $TimeFrom = strtotime($inputTimeFrom);
        $TimeTo = strtotime($inputTimeTo);
        $TimeFix = strtotime("15:00:00");
        $TimeCur = strtotime($TimeCurrent);
        $nextWeek = date('Y-m-d', strtotime($DateCurrent . '+3 day'));
        $Month = strtotime($DateCurrent) + (30 * 24 * 60 * 60);
        $nextMonth = date('Y-m-d H:i:s', $Month);

        // if(($nextMonth >= $GetFrom) && ($GetTo <= $nextMonth)) {
        // }else {
        //     echo "<script type=text/javascript>alert('Error.!! You must book no later than 3 days.');window.top.window.TrainingResult('0');</script>";
        //     exit();
        // }

        //! เช็ควันเวลา การขอล่วงหน้า \\
        if (($inputDateFrom <= $inputDateTo) && ($TimeFrom <= $TimeTo)) {
            if (($inputDateFrom >= $nextWeek) && ($inputDateTo >= $nextWeek)) {

                // if (($TimeCur <= $TimeFix)) {
                // } else {
                //     echo "<script type=text/javascript>alert('Error.!! You have made a booking transaction over 3pm.');window.top.window.TrainingResult('0');</script>";
                //     exit();
                // }

                //! เช็คการแนบไฟล์ & บันทึกข้อมูล \\
                if ($inputAttach == 0) {
                    foreach ($Trainees as $InputTrainees) {
                        $RecAythorSql = "SELECT LvApprove FROM ReqUser WHERE (EmpUserID = $InputTrainees)";
                        $RecAythorQuery = sqlsrv_query($connRequest, $RecAythorSql);
                        $RecAythorResult = sqlsrv_fetch_array($RecAythorQuery, SQLSRV_FETCH_ASSOC);
                        $Authen = $RecAythorResult["LvApprove"];

                        $SaveOneSql = "INSERT INTO ReqInfo 
                        (ReqNo, ReqType, EmployeeID, 
                        ReqDate, TrnTime, ReqDay, 
                        ReqHour, ReqSumTime, ReqOTType, 
                        ReqIssuer, ReqIssueDate, ReqChecker, 
                        ReqRemark, UserDefine1, Status) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?, ?, ?, ?)";
                        $SaveOneParams = array(
                            $KeyID, 4, $InputTrainees, 
                            $FromPeriod, $ToPeriod, $inputDurationDay, 
                            $inputDurationTime, $inputCost, $inputType, 
                            $SesUserID, $Authen, $inputCourse, 
                            $SendInfo, 1
                        );
                        $SaveOneStmt = sqlsrv_query($connRequest, $SaveOneSql, $SaveOneParams);
                    }
                    if ($SaveOneStmt == true) {
                        include_once "../email/mail_send_request_training.php";
                    } else {
                        //or die ("Error Query [".$SaveOneSql."]");
                        //or die( print_r( sqlsrv_errors(), true));
                        echo "<script type=text/javascript>alert('Error!! Incorrect information.');window.top.window.TrainingResult('0');</script>";
                        exit();
                    }
                } else if ($inputAttach == 1) {
                    if (strlen($inputImgFile) <= 50) {
                        define("MAX_SIZE", 2097152);    //กำหนดขนาดภาพสูงสุด Bytes
                        if ($_FILES['inputImgFile']['size'] > 0) { //เมื่อมีการอัพโหลดภาพเกิดขึ้น
                            if ($_FILES['inputImgFile']['size'] > MAX_SIZE) {    //ตรวจสอบขนาด
                                //echo "ขนาดรูปใหญ่เกินกว่า 2MB<br><br>";
                                echo "<script language=JavaScript>alert('Error!! The file size limit is 2MB or less.');window.top.window.TrainingResult('0');</script>";
                                exit();
                            } else {
                                $mImg_name = $_FILES['inputImgFile']['name'];
                                $array_last = explode(".", $mImg_name);
                                $c = count($array_last) - 1;
                                $lastname = strtolower($array_last[$c]);
                                if (($lastname == "jpg") or ($lastname == "jpeg") or ($lastname == "JPEG") or ($lastname == "JPG") or ($lastname == "png") or ($lastname == "PNG") or ($lastname == "gif") or ($lastname == "GIF")) {

                                    if (move_uploaded_file($_FILES['inputImgFile']["tmp_name"], "../assets/img/request/" . $KeyID . $KeyTime . $_FILES['inputImgFile']['name'])) {
                                        $ImgNew = $KeyID . $KeyTime . $_FILES['inputImgFile']['name'];

                                        foreach ($Trainees as $InputTrainees) {
                                            $RecAythorSql = "SELECT LvApprove FROM ReqUser WHERE (EmpUserID = $InputTrainees)";
                                            $RecAythorQuery = sqlsrv_query($connRequest, $RecAythorSql);
                                            $RecAythorResult = sqlsrv_fetch_array($RecAythorQuery, SQLSRV_FETCH_ASSOC);
                                            $Authen = $RecAythorResult["LvApprove"];

                                            $SaveOneSql = "INSERT INTO ReqInfo 
                                            (ReqNo, ReqType, EmployeeID, 
                                            ReqDate, TrnTime, ReqDay, 
                                            ReqHour, ReqSumTime, ReqOTType, 
                                            ReqIssuer, ReqIssueDate, ReqChecker, 
                                            ReqRemark, UserDefine1, PicturePath, Status) 
                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?, ?, ?, ?, ?)";
                                            $SaveOneParams = array(
                                                $KeyID, 4, $InputTrainees, 
                                                $FromPeriod, $ToPeriod, $inputDurationDay, 
                                                $inputDurationTime, $inputCost, $inputType,
                                                $SesUserID, $Authen, 
                                                $inputCourse, $SendInfo, $ImgNew, 1
                                            );
                                            $SaveOneStmt = sqlsrv_query($connRequest, $SaveOneSql, $SaveOneParams);
                                        }
                                        if ($SaveOneStmt == true) {
                                            include_once "../email/mail_send_request_training.php";
                                        } else {
                                            //or die ("Error Query [".$SaveOneSql."]");
                                            //or die( print_r( sqlsrv_errors(), true));
                                            echo "<script type=text/javascript>alert('Error!! Incorrect information.');window.top.window.TrainingResult('0');</script>";
                                            exit();
                                        }
                                    } else {
                                        echo "<script language=JavaScript>alert('Error!! File upload failed.');window.top.window.TrainingResult('0');</script>";
                                        exit();
                                    }
                                } else {
                                    //echo "รูปต้องเป็นชนิด gif หรือ jpg หรือ png เท่านั้น <br><br>";   
                                    echo "<script language=JavaScript>alert('Error!! Images must be of type (jpeg, jpeg, png, gif) only.');window.top.window.TrainingResult('0');</script>";
                                    exit();
                                }
                            }
                        }
                    } else {
                        echo "<script language=JavaScript>alert('Error!! The file name is longer than 50 characters.');window.top.window.TrainingResult('0');</script>";
                        exit();
                    }
                } else if ($inputAttach == 2) {
                    if (strlen($inputPdfFile) <= 50) {
                        define("MAX_SIZE", 2097152);    //กำหนดขนาดภาพสูงสุด Bytes
                        if ($_FILES['inputPdfFile']['size'] > 0) { //เมื่อมีการอัพโหลดภาพเกิดขึ้น
                            if ($_FILES['inputPdfFile']['size'] > MAX_SIZE) {    //ตรวจสอบขนาด
                                //echo "ขนาดรูปใหญ่เกินกว่า 2MB<br><br>";
                                echo "<script language=JavaScript>alert('Error!! The file size limit is 2MB or less.');window.top.window.TrainingResult('0');</script>";
                                exit();
                            } else {
                                $mImg_name = $_FILES['inputPdfFile']['name'];
                                $array_last = explode(".", $mImg_name);
                                $c = count($array_last) - 1;
                                $lastname = strtolower($array_last[$c]);
                                if (($lastname == "pdf") or ($lastname == "PDF")) {

                                    if (move_uploaded_file($_FILES['inputPdfFile']["tmp_name"], "../assets/img/request/" . $KeyID . $KeyTime . $_FILES['inputPdfFile']['name'])) {
                                        $PDFNew = $KeyID . $KeyTime . $_FILES['inputPdfFile']['name'];

                                        foreach ($Trainees as $InputTrainees) {
                                            $RecAythorSql = "SELECT LvApprove FROM ReqUser WHERE (EmpUserID = $InputTrainees)";
                                            $RecAythorQuery = sqlsrv_query($connRequest, $RecAythorSql);
                                            $RecAythorResult = sqlsrv_fetch_array($RecAythorQuery, SQLSRV_FETCH_ASSOC);
                                            $Authen = $RecAythorResult["LvApprove"];

                                            $SaveOneSql = "INSERT INTO ReqInfo 
                                            (ReqNo, ReqType, EmployeeID, 
                                            ReqDate, TrnTime, ReqDay, 
                                            ReqHour, ReqSumTime, ReqOTType,
                                            ReqIssuer, ReqIssueDate, ReqChecker, 
                                            ReqRemark, UserDefine1, PicturePath, Status) 
                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?, ?, ?, ?, ?)";
                                            $SaveOneParams = array(
                                                $KeyID, 4, $InputTrainees, 
                                                $FromPeriod, $ToPeriod, $inputDurationDay, 
                                                $inputDurationTime, $inputCost, $inputType,
                                                $SesUserID, $Authen, 
                                                $inputCourse, $SendInfo, $PDFNew, 1
                                            );
                                            $SaveOneStmt = sqlsrv_query($connRequest, $SaveOneSql, $SaveOneParams);
                                        }
                                        if ($SaveOneStmt == true) {
                                            include_once "../email/mail_send_request_training.php";
                                        } else {
                                            //or die ("Error Query [".$SaveOneSql."]");
                                            //or die( print_r( sqlsrv_errors(), true));
                                            echo "<script type=text/javascript>alert('Error!! Incorrect information.');window.top.window.TrainingResult('0');</script>";
                                            exit();
                                        }
                                    } else {
                                        echo "<script language=JavaScript>alert('Error!! File upload failed.');window.top.window.TrainingResult('0');</script>";
                                        exit();
                                    }
                                } else {
                                    //echo "รูปต้องเป็นชนิด gif หรือ jpg หรือ png เท่านั้น <br><br>";   
                                    echo "<script language=JavaScript>alert('Error!! Images must be of type PDF only.');window.top.window.TrainingResult('0');</script>";
                                    exit();
                                }
                            }
                        }
                    } else {
                        echo "<script language=JavaScript>alert('Error!! The file name is longer than 50 characters.');window.top.window.TrainingResult('0');</script>";
                        exit();
                    }
                } else if ($inputAttach == 3) {

        $PathQuery = "SELECT TOP (1) ReqNo,PicturePath FROM ReqInfo WHERE (ReqNo = '$inputKeyID') ";
        $PathObj = sqlsrv_query($connRequest, $PathQuery);
        $PathResult = sqlsrv_fetch_array($PathObj, SQLSRV_FETCH_ASSOC);

        if(trim($PathResult["PicturePath"]) != NULL) {
            foreach ($Trainees as $InputTrainees) {
                $RecAythorSql = "SELECT LvApprove FROM ReqUser WHERE (EmpUserID = $InputTrainees)";
                $RecAythorQuery = sqlsrv_query($connRequest, $RecAythorSql);
                $RecAythorResult = sqlsrv_fetch_array($RecAythorQuery, SQLSRV_FETCH_ASSOC);
                $Authen = $RecAythorResult["LvApprove"];
    
                $SaveOneSql = "INSERT INTO ReqInfo 
                (ReqNo, ReqType, EmployeeID, 
                ReqDate, TrnTime, ReqDay, 
                ReqHour, ReqSumTime, ReqOTType, 
                ReqIssuer, ReqIssueDate, ReqChecker, 
                ReqRemark, UserDefine1, PicturePath, Status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?, ?, ?, ?, ?)";
                $SaveOneParams = array(
                    $KeyID, 4, $InputTrainees, 
                    $FromPeriod, $ToPeriod, $inputDurationDay, 
                    $inputDurationTime, $inputCost, $inputType, 
                    $SesUserID, $Authen, $inputCourse, 
                    $SendInfo, $PathResult["PicturePath"], 1
                );
                $SaveOneStmt = sqlsrv_query($connRequest, $SaveOneSql, $SaveOneParams);
            }
            if ($SaveOneStmt == true) {
                include_once "../email/mail_send_request_training.php";
            } else {
                //or die ("Error Query [".$SaveOneSql."]");
                //or die( print_r( sqlsrv_errors(), true));
                echo "<script type=text/javascript>alert('Error!! Incorrect information1.');window.top.window.TrainingResult('0');</script>";
                exit();
            }
        }else {
            foreach ($Trainees as $InputTrainees) {
                $RecAythorSql = "SELECT LvApprove FROM ReqUser WHERE (EmpUserID = $InputTrainees)";
                $RecAythorQuery = sqlsrv_query($connRequest, $RecAythorSql);
                $RecAythorResult = sqlsrv_fetch_array($RecAythorQuery, SQLSRV_FETCH_ASSOC);
                $Authen = $RecAythorResult["LvApprove"];

                $SaveOneSql = "INSERT INTO ReqInfo 
                (ReqNo, ReqType, EmployeeID, 
                ReqDate, TrnTime, ReqDay, 
                ReqHour, ReqSumTime, ReqOTType, 
                ReqIssuer, ReqIssueDate, ReqChecker, 
                ReqRemark, UserDefine1, Status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?, ?, ?, ?)";
                $SaveOneParams = array(
                    $KeyID, 4, $InputTrainees, 
                    $FromPeriod, $ToPeriod, $inputDurationDay, 
                    $inputDurationTime, $inputCost, $inputType, 
                    $SesUserID, $Authen, $inputCourse, 
                    $SendInfo, 1
                );
                $SaveOneStmt = sqlsrv_query($connRequest, $SaveOneSql, $SaveOneParams);
            }
            if ($SaveOneStmt == true) {
                include_once "../email/mail_send_request_training.php";
            } else {
                //or die ("Error Query [".$SaveOneSql."]");
                //or die( print_r( sqlsrv_errors(), true));
                echo "<script type=text/javascript>alert('Error!! Incorrect information2.');window.top.window.TrainingResult('0');</script>";
                exit();
            }
        }

                } else {
                    echo "<script>window.close();</script>";
                    exit();
                }
                //! เช็คการแนบไฟล์ & บันทึกข้อมูล \\

            } else {
                echo "<script type=text/javascript>alert('Error.!! You must book the reservation 3 days in advance.');window.top.window.TrainingResult('0');</script>";
                exit();
            }
        } else {
            echo "<script type=text/javascript>alert('Error.!! Invalid date range.');window.top.window.TrainingResult('0');</script>";
            exit();
        }
    }
    // else {
    //     echo "<script type=text/javascript>alert('Error!! Invalid approval.');window.top.window.TrainingResult('0');</script>";
    //     exit();
    // }
} else {
    echo "<script>window.close();</script>";
    exit();
}
