<?php 
	include('protect.php');
	include 'dbconnect.php'; 

	$soId = "";
	$satelliteOfficeName = "";
	if( isset($_REQUEST['satelliteOfficeName']) ) $satelliteOfficeName = trim($_REQUEST['satelliteOfficeName']);
	if( isset($_REQUEST['soId']) ) $soId = trim($_REQUEST['soId']);

	$query = mysqli_query($conn, "SELECT * FROM deliveryarea WHERE city = '$satelliteOfficeName' and id <> $soId");

	if( mysqli_num_rows($query) > 0 ) {
		$valid = "false";
	}
	else {
		$valid = "true";
	}

	echo $valid;
?>