<?php 
	include('protect.php');
	include('dbconnect.php'); 

	$modeOfPayment = "";
	if( isset($_REQUEST['mop']) ) $modeOfPayment = trim($_REQUEST['mop']);

	$query = mysqli_query($conn, "SELECT * FROM payment_mode WHERE payment_mode = '$modeOfPayment'");

	if( mysqli_num_rows($query) > 0 ) {
		$valid = "false";
	}
	else {
		$valid = "true";
	}

	echo $valid;
?>