<?php 
	include('protect.php');
	include 'dbconnect.php'; 

	$vehiclePlateNo = "";
	if( isset($_REQUEST['vehiclePlateNo']) ) $vehiclePlateNo = trim($_REQUEST['vehiclePlateNo']);

	$query = mysqli_query($conn, "SELECT * FROM vec WHERE plate_no = '$vehiclePlateNo'");

	if( mysqli_num_rows($query) > 0 ) {
		$valid = "false";
	}
	else {
		$valid = "true";
	}

	echo $valid;
?>