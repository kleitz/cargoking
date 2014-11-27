<?php 
	include('protect.php');
	include 'dbconnect.php'; 

	$soId = "";
	$soHawbPrefixCode = "";
	if( isset($_REQUEST['soHawbPrefixCode']) ) $soHawbPrefixCode = trim($_REQUEST['soHawbPrefixCode']);
	if( isset($_REQUEST['soId']) ) $soId = trim($_REQUEST['soId']);

	$query = mysqli_query($conn, "SELECT * FROM deliveryarea WHERE station_hawb_prefix = '$soHawbPrefixCode' and id <> $soId");

	if( mysqli_num_rows($query) > 0 ) {
		$valid = "false";
	}
	else {
		$valid = "true";
	}

	echo $valid;
?>