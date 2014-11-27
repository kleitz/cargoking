<?php 
	include('protect.php');
	include('dbconnect.php'); 

	$serviceMode = "";
	if( isset($_REQUEST['serviceMode']) ) $serviceMode = trim($_REQUEST['serviceMode']);

	$query = mysqli_query($conn, "SELECT * FROM service_mode WHERE service_mode = '$serviceMode'");

	if( mysqli_num_rows($query) > 0 ) {
		$valid = "false";
	}
	else {
		$valid = "true";
	}

	echo $valid;
?>