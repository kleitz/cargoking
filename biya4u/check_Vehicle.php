<?php 
	include('protect.php');
	include('dbconnect.php'); 

	$plate_no = "";
	if( isset($_REQUEST['plate_no']) ) $statusCode = trim($_REQUEST['plate_no']);

	$query = mysqli_query($conn, "SELECT * FROM vec WHERE plate_no = '$plate_no'");

	if( mysqli_num_rows($query) > 0 ) {
		$valid = "false";
	}
	else {
		$valid = "true";
	}

	echo $valid;
?>