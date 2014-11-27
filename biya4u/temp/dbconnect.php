<?php ob_start();

/*$con = mysql_connect("localhost","root","") or die ('Error Connectiong to mysql: '.mysqli_error());
$dbname = "cargoking";*/
$con = mysql_connect("localhost","ehi8so1c_dbadmin","letmein123") or die ('Error Connectiong to mysql: '.mysqli_error());
//$dbname = "ehi8so1c_track";
$dbname = "ehi8so1c_cargoking";
mysql_select_db($dbname,$con) or die ("Select Error: ".mysqli_error());

?>

