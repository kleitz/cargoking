<?php 
	include('protect.php');
	include 'dbconnect.php'; 

	$customerName = "";
	if( isset($_REQUEST['customerName']) ) $customerName = trim($_REQUEST['customerName']);

	$query = mysqli_query($conn, "SELECT * FROM vw_customers WHERE cust_name = '$customerName'");

	if( mysqli_num_rows($query) > 0 ) {
		$valid = "false";
	}
	else {
		$valid = "true";
	}

	echo $valid;
?>