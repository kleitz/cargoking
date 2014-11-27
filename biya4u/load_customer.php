<?php 
	include('protect.php');
	include 'dbconnect.php'; 
	$customerId = trim($_REQUEST['customerId']);

	$query = mysqli_query($conn, "select * from vw_customers where cust_id = '$customerId'");
	$row = mysqli_fetch_assoc($query);

	echo json_encode($row);
?>
