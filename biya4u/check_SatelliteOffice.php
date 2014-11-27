<?php 
	include('protect.php');
	include('dbconnect.php'); 

	$so_name = "";
	if( isset($_REQUEST['so_name']) ) $so_name = trim($_REQUEST['so_name']);

	$query = mysqli_query($conn, "SELECT * FROM delivery_area WHERE area = '$so_name'");

	if( mysqli_num_rows($query) > 0 ) {
		$valid = "false";
	}
	else {
		$valid = "true";
	}

	echo $valid;
?>