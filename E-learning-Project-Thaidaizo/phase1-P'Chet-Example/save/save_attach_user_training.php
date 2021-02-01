<?php
include "../alert/alert_session.php";
include "../alert/alert_user.php";
include "../../database/conn_sqlsrv.php";
//include "../database/conn_odbc.php";
//include "../../database/conn_mysql.php";
include "../alert/data_detail.php";


if (isset($_POST["BttSubmitAttFile"]) == '1') {
  if (trim($_POST["inputItemNo"]) != NULL) {

    //echo "<script>window.top.window.LoadingResult('1');</script>";
    //! Check DateTIme \\
    $PeriodQuery = "SELECT convert(varchar(10), GETDATE(), 111) AS DateCurrent, 
        convert(varchar(10), GETDATE(), 108) AS TimeCurrent ";
    $PeriodObj = sqlsrv_query($connRequest, $PeriodQuery);
    $PeriodResult = sqlsrv_fetch_array($PeriodObj, SQLSRV_FETCH_ASSOC);

    $DateCurrent = $PeriodResult["DateCurrent"];
    $TimeCurrent = $PeriodResult["TimeCurrent"];
    $DateStart = str_replace('/', '-', $DateCurrent);
    $TimeStart = str_replace(':', '', $TimeCurrent);
    //! Check DateTIme \\

    $inputItemNo = strip_tags(htmlspecialchars($_POST['inputItemNo']));
    $inputAttach = strip_tags(htmlspecialchars($_POST['inputAttach']));
    $inputImgFile = $_FILES['inputImgFile']['name'];
    $inputPdfFile = $_FILES['inputPdfFile']['name'];

    $AttFileCountSQL = "SELECT COUNT(DISTINCT TrainRecNo) AS NumAttFile FROM TrainRecDtl 
        WHERE (TrainRecNo = '$inputItemNo') 
        AND (EmployeeID = '$SesUserID') 
        --AND (TrainRecDate = '$DateStart') 
        AND (PicturePath <> '' OR PicturePath IS NOT NULL) 
        AND (TrainDtlStatus >= 1) ";
    $AttFileCountQuery = sqlsrv_query($connEducation, $AttFileCountSQL);
    $AttFileCountResult = sqlsrv_fetch_array($AttFileCountQuery, SQLSRV_FETCH_ASSOC);
    $NumAttFile = $AttFileCountResult["NumAttFile"];

    if ($NumAttFile > 0) {
      echo "<script>alert('You have attached files.');window.top.window.TrainingAttach('0');</script>";
      exit();
    } else {

      //! เช็คการแนบไฟล์ & บันทึกข้อมูล \\
      if ($inputAttach == 1) {
        if (strlen($inputImgFile) <= 50) {
          define("MAX_SIZE", 2097152);    //กำหนดขนาดภาพสูงสุด Bytes
          if ($_FILES['inputImgFile']['size'] > 0) { //เมื่อมีการอัพโหลดภาพเกิดขึ้น
            if ($_FILES['inputImgFile']['size'] > MAX_SIZE) {    //ตรวจสอบขนาด
              //echo "ขนาดรูปใหญ่เกินกว่า 2MB<br><br>";
              echo "<script language=JavaScript>alert('Error!! The file size limit is 2MB or less.');window.top.window.TrainingAttach('0');</script>";
              exit();
            } else {
              $mImg_name = $_FILES['inputImgFile']['name'];
              $array_last = explode(".", $mImg_name);
              $c = count($array_last) - 1;
              $lastname = strtolower($array_last[$c]);
              if (($lastname == "jpg") or ($lastname == "jpeg") or ($lastname == "JPEG") or ($lastname == "JPG") or ($lastname == "png") or ($lastname == "PNG") or ($lastname == "gif") or ($lastname == "GIF")) {

                if (move_uploaded_file($_FILES['inputImgFile']["tmp_name"], "../assets/img/request/" . $inputItemNo . $TimeStart . $_FILES['inputImgFile']['name'])) {
                  $ImgNew = $inputItemNo . $TimeStart . $_FILES['inputImgFile']['name'];

                  $ImgSql = "UPDATE TrainRecDtl SET 
                  PicturePath = ? ,
                  UpdateBy = ? ,
                  UpdateDate = GETDATE()
                  WHERE (TrainRecNo = ?) AND (EmployeeID = ?) AND (TrainDtlStatus >= ?) ";
                  $ImgParams = array($ImgNew, $SesUserID, $inputItemNo, $SesUserID, 1);
                  $ImgStmt = sqlsrv_query($connEducation, $ImgSql, $ImgParams);

                  if ($ImgStmt == true) {
                    echo "<script>window.top.window.TrainingAttach('1');</script>";
                    exit();
                  } else {
                    //or die ("Error Query [".$SaveOneSql."]");
                    //or die( print_r( sqlsrv_errors(), true));
                    echo "<script type=text/javascript>alert('Error!! Incorrect information.');window.top.window.TrainingAttach('0');</script>";
                    exit();
                  }
                } else {
                  echo "<script language=JavaScript>alert('Error!! File upload failed.');window.top.window.TrainingAttach('0');</script>";
                  exit();
                }
              } else {
                //echo "รูปต้องเป็นชนิด gif หรือ jpg หรือ png เท่านั้น <br><br>";   
                echo "<script language=JavaScript>alert('Error!! Images must be of type (jpeg, jpeg, png, gif) only.');window.top.window.TrainingAttach('0');</script>";
                exit();
              }
            }
          }
        } else {
          echo "<script language=JavaScript>alert('Error!! The file name is longer than 50 characters.');window.top.window.TrainingAttach('0');</script>";
          exit();
        }
      } else {
        if (strlen($inputPdfFile) <= 50) {
          define("MAX_SIZE", 2097152);    //กำหนดขนาดภาพสูงสุด Bytes
          if ($_FILES['inputPdfFile']['size'] > 0) { //เมื่อมีการอัพโหลดภาพเกิดขึ้น
            if ($_FILES['inputPdfFile']['size'] > MAX_SIZE) {    //ตรวจสอบขนาด
              //echo "ขนาดรูปใหญ่เกินกว่า 2MB<br><br>";
              echo "<script language=JavaScript>alert('Error!! The file size limit is 2MB or less.');window.top.window.TrainingAttach('0');</script>";
              exit();
            } else {
              $mImg_name = $_FILES['inputPdfFile']['name'];
              $array_last = explode(".", $mImg_name);
              $c = count($array_last) - 1;
              $lastname = strtolower($array_last[$c]);
              if (($lastname == "pdf") or ($lastname == "PDF")) {

                if (move_uploaded_file($_FILES['inputPdfFile']["tmp_name"], "../assets/img/request/" . $inputItemNo . $TimeStart . $_FILES['inputPdfFile']['name'])) {
                  $PDFNew = $inputItemNo . $TimeStart . $_FILES['inputPdfFile']['name'];

                  $PDFSql = "UPDATE TrainRecDtl SET 
                  PicturePath = ? ,
                  UpdateBy = ? ,
                  UpdateDate = GETDATE()
                  WHERE (TrainRecNo = ?) AND (EmployeeID = ?) AND (TrainDtlStatus >= ?) ";
                  $PDFParams = array($PDFNew, $SesUserID, $inputItemNo, $SesUserID, 1);
                  $PDFStmt = sqlsrv_query($connEducation, $PDFSql, $PDFParams);

                  if ($PDFStmt == true) {
                    echo "<script>window.top.window.TrainingAttach('1');</script>";
                    exit();
                  } else {
                    //or die ("Error Query [".$SaveOneSql."]");
                    //or die( print_r( sqlsrv_errors(), true));
                    echo "<script type=text/javascript>alert('Error!! Incorrect information.');window.top.window.TrainingAttach('0');</script>";
                    exit();
                  }
                } else {
                  echo "<script language=JavaScript>alert('Error!! File upload failed.');window.top.window.TrainingAttach('0');</script>";
                  exit();
                }
              } else {
                //echo "รูปต้องเป็นชนิด gif หรือ jpg หรือ png เท่านั้น <br><br>";   
                echo "<script language=JavaScript>alert('Error!! Images must be of type PDF only.');window.top.window.TrainingAttach('0');</script>";
                exit();
              }
            }
          }
        } else {
          echo "<script language=JavaScript>alert('Error!! The file name is longer than 50 characters.');window.top.window.TrainingAttach('0');</script>";
          exit();
        }
      }
      //! เช็คการแนบไฟล์ & บันทึกข้อมูล \\


    }
  } else {
    echo "<script>window.top.window.TrainingAttach('0');</script>";
    exit();
  }
} else {
  echo "<script>window.top.window.TrainingAttach('0');</script>";
  exit();
}
