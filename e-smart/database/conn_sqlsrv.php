<?php
  session_start();
  ini_set('display_errors', 1);
  error_reporting(~0);
  error_reporting (E_ALL ^ E_NOTICE);
  date_default_timezone_set('asia/bangkok');

  // $serverName_Request = "192.168.107.169\SQLEXPRESS";
  // $userName_Request = "sa";
  // $userPassword_Request = "";
  // $dbName_Request = "E-RequestSystem";
  // $connectionInfo_Request = array("Database"=>$dbName_Request, "UID"=>$userName_Request, "PWD"=>$userPassword_Request, "MultipleActiveResultSets"=>true, "CharacterSet"  => 'UTF-8');
  // $connRequest = sqlsrv_connect($serverName_Request, $connectionInfo_Request);
  // if($connRequest === false) {
  //   //die( print_r( sqlsrv_errors(), true));
	// echo "404 NOT FOUND 1";
  // }

  // $serverName_Education = "localhost";
  // $userName_Education = "";
  // $userPassword_Education = "";
  // $dbName_Education = "EducationSystem";
  // $connectionInfo_Request = array("Database"=>$dbName_Education, "UID"=>$userName_Education, "PWD"=>$userPassword_Education, "MultipleActiveResultSets"=>true, "CharacterSet"  => 'UTF-8');
  // $connEducation = sqlsrv_connect($serverName_Education, $connectionInfo_Education);
  // if($connEducation === false) {
  //   //die( print_r( sqlsrv_errors(), true));
	// echo "404 NOT FOUND 1";
  // }
  
  // ******************************************************************************************


  $serverName_Request = "DESKTOP-0DGMVD8\PATTARAPONG";
  $userName_Request = "sa";
  $userPassword_Request = "p@ssw0rd";
  $dbName_Request = "E-RequestSystem";
  $connectionInfo_Request = array("Database"=>$dbName_Request, "UID"=>$userName_Request, "PWD"=>$userPassword_Request, "MultipleActiveResultSets"=>true, "CharacterSet"  => 'UTF-8');
  $connRequest = sqlsrv_connect($serverName_Request, $connectionInfo_Request);
  if($connRequest === false) {
    //die( print_r( sqlsrv_errors(), true));
	echo "404 NOT FOUND 1";
  }

  $serverName_Education = "DESKTOP-0DGMVD8\PATTARAPONG";
  $userName_Education = "sa";
  $userPassword_Education = "p@ssw0rd";
  $dbName_Education = "EducationSystem";
  $connectionInfo_Education = array("Database"=>$dbName_Education, "UID"=>$userName_Education, "PWD"=>$userPassword_Education, "MultipleActiveResultSets"=>true, "CharacterSet"  => 'UTF-8');
  $connEducation = sqlsrv_connect($serverName_Education, $connectionInfo_Education);
  if($connEducation === false) {
    //die( print_r( sqlsrv_errors(), true));
	echo "404 NOT FOUND 1";
  }

  $serverName_Canteen = "192.168.1.253\BKUPEXEC";
  $userName_Canteen = "sa";
  $userPassword_Canteen = "p@ssw0rd";
  $dbName_Canteen = "CanteenSystem";
  $connectionInfo_Canteen = array("Database"=>$dbName_Canteen, "UID"=>$userName_Canteen, "PWD"=>$userPassword_Canteen, "MultipleActiveResultSets"=>true, "CharacterSet"  => 'UTF-8');
  $connCanteen = sqlsrv_connect($serverName_Canteen, $connectionInfo_Canteen);
  if($connCanteen === false) {
    //die( print_r( sqlsrv_errors(), true));
	echo "404 NOT FOUND 2";
  }
  
  
  /*$serverName_Qlo = "TEMPLATE2019";
  $userName_Qlo = "sa";
  $userPassword_Qlo = "p@ssw0rd";
  $dbName_Qlo = "EQloSystem";
  $connectionInfo_Qlo = array("Database"=>$dbName_Qlo, "UID"=>$userName_Qlo, "PWD"=>$userPassword_Qlo, "MultipleActiveResultSets"=>true, "CharacterSet"  => 'UTF-8');
  $connQlo = sqlsrv_connect($serverName_Qlo, $connectionInfo_Qlo);
  if($connQlo === false) {
    //die( print_r( sqlsrv_errors(), true));
	echo "404 NOT FOUND 3";
  }*/
  
  
//   $serverName_Consen = "192.168.1.253\BKUPEXEC";
//   $userName_Consen = "sa";
//   $userPassword_Consen = "p@ssw0rd";
//   $dbName_Consen = "EConsentSystem";
//   $connectionInfo_Consen = array("Database"=>$dbName_Consen, "UID"=>$userName_Consen, "PWD"=>$userPassword_Consen, "MultipleActiveResultSets"=>true, "CharacterSet"  => 'UTF-8');
//   $connConsen = sqlsrv_connect($serverName_Consen, $connectionInfo_Consen);
//   if( $connConsen === false ) {
//     //die( print_r( sqlsrv_errors(), true));
// 	echo "404 NOT FOUND";
//   }
  
  
//   $serverName_CarBooking = "192.168.1.253\BKUPEXEC";
//   $userName_CarBooking = "sa";
//   $userPassword_CarBooking = "p@ssw0rd";
//   $dbName_CarBooking = "CarBookingSystem";
//   $connectionInfo_CarBooking = array("Database"=>$dbName_CarBooking, "UID"=>$userName_CarBooking, "PWD"=>$userPassword_CarBooking, "MultipleActiveResultSets"=>true, "CharacterSet"  => 'UTF-8');
//   $connCarBooking = sqlsrv_connect($serverName_CarBooking, $connectionInfo_CarBooking);
//   if( $connCarBooking === false ) {
//     //die( print_r( sqlsrv_errors(), true));
// 	echo "404 NOT FOUND";
//   }
  
 
//   $serverName_HR = "192.168.1.253\BKUPEXEC";
//   $userName_HR = "sa";
//   $userPassword_HR = "p@ssw0rd";
//   $dbName_HR = "HRSystem";
//   $connectionInfo_HR = array("Database"=>$dbName_HR, "UID"=>$userName_HR, "PWD"=>$userPassword_HR, "MultipleActiveResultSets"=>true, "CharacterSet"  => 'UTF-8');
//   $connHR = sqlsrv_connect($serverName_HR, $connectionInfo_HR);
//   if( $connHR === false ) {
//     //die( print_r( sqlsrv_errors(), true));
// 	echo "404 NOT FOUND";
//   }
  
  
//   $serverName_Room = "192.168.1.253\BKUPEXEC";
//   $userName_Room = "sa";
//   $userPassword_Room = "p@ssw0rd";
//   $dbName_Room = "RoomBookingSystem";
//   $connectionInfo_Room = array("Database"=>$dbName_Room, "UID"=>$userName_Room, "PWD"=>$userPassword_Room, "MultipleActiveResultSets"=>true, "CharacterSet"  => 'UTF-8');
//   $connRoom = sqlsrv_connect($serverName_Room, $connectionInfo_Room);
//   if( $connRoom === false ) {
//     //die( print_r( sqlsrv_errors(), true));
// 	echo "404 NOT FOUND";
//   }
  
// ?>





 <?php

// $serverName_Room_PDO = "192.168.1.253\BKUPEXEC";
// $userName_Room_PDO = "sa";
// $userPassword_Room_PDO = "p@ssw0rd";
// $dbName_Room_PDO = "RoomBookingSystem";
// $connRoomPDO = new PDO("sqlsrv:server=$serverName_Room_PDO ; Database = $dbName_Room_PDO", $userName_Room_PDO, $userPassword_Room_PDO);
// $connRoomPDO->setAttribute(PDO::SQLSRV_ATTR_ENCODING, PDO::SQLSRV_ENCODING_UTF8);
// if( $connRoomPDO === false ){
// 	echo "404 NOT FOUND";
// }


// $serverName_Req_PDO = "192.168.1.253\BKUPEXEC";
// $userName_Req_PDO = "sa";
// $userPassword_Req_PDO = "p@ssw0rd";
// $dbName_Req_PDO = "E-RequestSystem";
// $connReqPDO = new PDO("sqlsrv:server=$serverName_Req_PDO ; Database = $dbName_Req_PDO", $userName_Req_PDO, $userPassword_Req_PDO);
// $connReqPDO->setAttribute(PDO::SQLSRV_ATTR_ENCODING, PDO::SQLSRV_ENCODING_UTF8);
// if( $connReqPDO === false ){
// 	echo "404 NOT FOUND";
// }


?>
