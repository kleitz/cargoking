<?php 
	include('protect.php');
	include 'dbconnect.php'; 

	$soHawbPrefixCode = "";
	if( isset($_REQUEST['soHawbPrefixCode']) ) $soHawbPrefixCode = trim($_REQUEST['soHawbPrefixCode']);

	$query = mysqli_query($conn, "SELECT * FROM deliveryarea WHERE station_hawb_prefix = '$soHawbPrefixCode'");

	if( mysqli_num_rows($query) > 0 ) {
		$valid = "false";
	}
	else {
		$valid = "true";
	}

	echo $valid;
?>