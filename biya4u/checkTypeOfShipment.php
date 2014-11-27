<?php 
	include('protect.php');
	include 'dbconnect.php'; 

	$typeOfShipment = "";
	if( isset($_REQUEST['typeOfShipment']) ) $typeOfShipment = trim($_REQUEST['typeOfShipment']);

	$query = mysqli_query($conn, "SELECT * FROM ty_ship WHERE category = '$typeOfShipment'");

	if( mysqli_num_rows($query) > 0 ) {
		$valid = "false";
	}
	else {
		$valid = "true";
	}

	echo $valid;
?>