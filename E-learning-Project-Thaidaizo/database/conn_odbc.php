<?php 
	session_start();
	ini_set('display_errors', 1);
	error_reporting(~0);
	error_reporting (E_ALL ^ E_NOTICE);
	date_default_timezone_set('asia/bangkok');


	$serverName_As400 = "Driver={Client Access ODBC Driver (32-bit)};System=192.168.1.234;Uid=user;Pwd=password;CharSet=utf8;";
	$userName_As400 = "IT";
	$userPassword_As400 = "it@2015";
	$connAs400 = odbc_connect($serverName_As400, $userName_As400, $userPassword_As400); //or die("Error Connect to Database");
	if($connAs400 === false) {
	  //die( print_r( sqlsrv_errors(), true));
	  echo "404 NOT FOUND";
	}

?>