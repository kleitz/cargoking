<?php 
	include('protect.php');
	include('dbconnect.php'); 

	$station_name = "";
	if( isset($_REQUEST['station_name']) ) $station_name = trim($_REQUEST['station_name']);

	$query = mysqli_query($conn, "SELECT * FROM area_location WHERE area_name = '$station_name'");

	if( mysqli_num_rows($query) > 0 ) {
		$valid = "false";
	}
	else {
		$valid = "true";
	}

	echo $valid;
?>