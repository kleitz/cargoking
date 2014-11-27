<?php 
	include('protect.php');
	include('dbconnect.php'); 

	$statusCode = "";
	if( isset($_REQUEST['statusCode']) ) $statusCode = trim($_REQUEST['statusCode']);

	$query = mysqli_query($conn, "SELECT * FROM status WHERE status_code = '$statusCode'");

	if( mysqli_num_rows($query) > 0 ) {
		$valid = "false";
	}
	else {
		$valid = "true";
	}

	echo $valid;
?>