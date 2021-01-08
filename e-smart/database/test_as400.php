
<?php
/*
$server = "Driver={Client Access ODBC Driver (32-bit)}; System=192.168.1.234; Uid=user;Pwd=password;"; #the name of the iSeries
$user = "IT"; #a valid username that will connect to the DB
$pass = "it@2015"; #a password for the username

$conn = odbc_connect($server,$user,$pass); #you may have to remove quotes

#Check Connection
if($conn == false) {
	echo "Not able to connect to database...";
}
	

#Query the Database into a result set - 
$result = odbc_exec($conn, "SELECT * FROM TDAM3.M3FDBPRD.MITMAS LIMIT 30");

if(!$result) {
  exit("Error in SQL");
}

echo "<table><tr>";
echo "<th>MMITNO</th>";
echo "<th>MMITDS</th></tr>";
while(odbc_fetch_row($result)) {
	
  $ndoc = odbc_result($result,3);
  $dtdo = odbc_result($result,4);
  echo "<tr><td>$ndoc</td>";
  echo "<td>$dtdo</td></tr>";
  
  }
echo "</table>";

#close the connection
odbc_close($conn);
*/
?>

<?php
//setlocale(LC_ALL, 'de_DE');
$server = "Driver={Client Access ODBC Driver (32-bit)};System=192.168.1.234;Uid=user;Pwd=password;CharSet=utf8;"; #the name of the iSeries
$user = "IT"; #a valid username that will connect to the DB
$pass = "it@2015"; #a password for the username
$conn = odbc_connect($server,$user,$pass) or die("Error Connect to Database"); #you may have to remove quotes
//$conn = odbc_connect("mydatabase","sa","") or die("Error Connect to Database");
/*
$result = odbc_exec($conn,"SELECT * FROM TDAM3.M3FDBPRD.MITMAS LIMIT 30");
$count = 1;
while ($val = odbc_fetch_array($result)) {
        //var_dump($val);
		echo $count." - ".$val["MMITDS"]."<br>";
        $count++;
}    

odbc_close($conn);
//print "locale is :/n";
//system('locale');
*/
?>




<html>
<head>
<title>Testing Connect AS400</title>
</head>
<body>
<?php
$strSQL = "SELECT * FROM TDAM3.M3FDBPRD.MITMAS LIMIT 30";
$objExec = odbc_exec($conn, $strSQL); //or die ("Error Execute [".$strSQL."]");
?>
<table width="600" border="1">
  <tr>
    <th width="91"> <div align="center">CustomerID </div></th>
    <th width="98"> <div align="center">Name </div></th>
    <th width="198"> <div align="center">Email </div></th>
    <th width="97"> <div align="center">CountryCode </div></th>
    <th width="59"> <div align="center">Budget </div></th>
    <th width="71"> <div align="center">Used </div></th>
  </tr>
<?php
while($objResult = odbc_fetch_array($objExec))
{
?>
  <tr>
    <td><div align="center"><?php echo $objResult["MMITDS"];?></div></td>
    <td><?php echo $objResult["MMITDS"];?></td>
    <td><?php echo $objResult["MMITDS"];?></td>
    <td><div align="center"><?php echo $objResult["MMITDS"];?></div></td>
    <td align="right"><?php echo $objResult["MMITDS"];?></td>
    <td align="right"><?php echo $objResult["MMITDS"];?></td>
  </tr>
<?php
}
?>
</table>
<?php
odbc_close($conn);
?>
</body>
</html>



