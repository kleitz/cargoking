<?php 
	include('protect.php');
	include 'dbconnect.php'; 

	$satelliteOfficeName = "";
	if( isset($_REQUEST['satelliteOfficeName']) ) $satelliteOfficeName = trim($_REQUEST['satelliteOfficeName']);

	$query = mysqli_query($conn, "SELECT * FROM deliveryarea WHERE city = '$satelliteOfficeName'");

	if( mysqli_num_rows($query) > 0 ) {
		$valid = "false";
	}
	else {
		$valid = "true";
	}

	echo $valid;
?>