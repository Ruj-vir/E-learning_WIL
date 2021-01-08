<?php
  session_start();
  ini_set('display_errors', 1);
  error_reporting(~0);
  error_reporting (E_ALL ^ E_NOTICE);
  date_default_timezone_set('asia/bangkok');

	// $serverName_BoardcastOld = "localhost";
	// $userName_BoardcastOld = "root";
	// $userPassword_BoardcastOld = "";
	// $dbName_BoardcastOld = "boardcast";
	// $connBoardcastOld = mysqli_connect($serverName_BoardcastOld, $userName_BoardcastOld, $userPassword_BoardcastOld, $dbName_BoardcastOld);
	// mysqli_set_charset($connBoardcastOld, "utf8");
	// if(!$connBoardcastOld) {
	//   echo "404 NOT FOUND";
	// }
	

	// $serverName_Boardcast = "localhost";
	// $userName_Boardcast = "root";
	// $userPassword_Boardcast = "";
	// $dbName_Boardcast = "Boardcastsystem";
	// $connBoardcast = mysqli_connect($serverName_Boardcast, $userName_Boardcast, $userPassword_Boardcast, $dbName_Boardcast);
	// mysqli_set_charset($connBoardcast, "utf8");
	// if(!$connBoardcast) {
	//   echo "404 NOT FOUND";
	// }
	
	
	// $serverName_Covid19 = "localhost";
	// $userName_Covid19 = "root";
	// $userPassword_Covid19 = "";
	// $dbName_Covid19 = "covid19";
	// $connCovid19 = mysqli_connect($serverName_Covid19, $userName_Covid19, $userPassword_Covid19, $dbName_Covid19);
	// mysqli_set_charset($connCovid19, "utf8");
	// if(!$connCovid19) {
	//   echo "404 NOT FOUND";
	// }
	
	
	// $serverName_Cctv = "localhost";
	// $userName_Cctv = "root";
	// $userPassword_Cctv = "";
	// $dbName_Cctv = "cctvsystem";
	// $connCctv = mysqli_connect($serverName_Cctv, $userName_Cctv, $userPassword_Cctv, $dbName_Cctv);
	// mysqli_set_charset($connCctv, "utf8");
	// if(!$connCctv) {
	//   echo "404 NOT FOUND";
	// }
	
	
	// $serverName_Workplace = "localhost";
	// $userName_Workplace = "root";
	// $userPassword_Workplace = "";
	// $dbName_Workplace = "epositiontypes";
	// $connWorkplace = mysqli_connect($serverName_Workplace, $userName_Workplace, $userPassword_Workplace, $dbName_Workplace);
	// mysqli_set_charset($connCctv, "utf8");
	// if(!$connWorkplace) {
	//   echo "404 NOT FOUND";
	// }


	$serverName_RequestType = "localhost";
	$userName_RequestType = "root";
	$userPassword_RequestType = "";
	$dbName_RequestType = "erequesttypes";
	$connRequestType = mysqli_connect($serverName_RequestType, $userName_RequestType, $userPassword_RequestType, $dbName_RequestType);
	mysqli_set_charset($connRequestType, "utf8");
	if(!$connRequestType) {
	  echo "404 NOT FOUND";
	}
?>