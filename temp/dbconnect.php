<?php
	ob_start();

	/*$con = mysql_connect("localhost","root","") or die ('Error Connectiong to mysql: '.mysqli_error());
	$dbname = "cargoking";
	$conn = mysqli_connect("127.0.0.1:3306","root","root", "ehi8so1c_cargoking") or die ('Error Connectiong to mysql: '.mysqli_error());
	*/

	/*
	$conn = mysqli_connect("127.0.0.1:3306","root","root") or die ('Error Connectiong to mysql: '.mysqli_error());
	$dbname = "ehi8so1c_cargoking";
	mysqli_select_db($conn, $dbname) or die ("Select Error: ".mysqli_error());
	*/

	if( !is_resource($conn) ) {
		$conn = mysqli_connect("localhost","ehi8so1c_dbadmin","letmein123", "ehi8so1c_development") or die ('Error Connectiong to mysql: '.mysqli_error());
		if (mysqli_connect_errno()) {
		    throw new Exception(mysqli_connect_error(), mysqli_connect_errno());
		}
	}
?>