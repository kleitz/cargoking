<?php 
	include('protect.php');
	include 'dbconnect.php'; 

	$customerId = "";
	$customerName = "";
	if( isset($_REQUEST['customerId']) )   $customerId   = trim($_REQUEST['customerId']);
	if( isset($_REQUEST['customerName']) ) $customerName = trim($_REQUEST['customerName']);

	$query = mysqli_query($conn, "SELECT * FROM vw_customers WHERE cust_name = '$customerName' and id <> $customerId ");

	if( mysqli_num_rows($query) > 0 ) {
		$valid = "false";
	}
	else {
		$valid = "true";
	}

	echo $valid;
?>