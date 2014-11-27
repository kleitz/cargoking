<?php 
	include('protect.php');
	include 'dbconnect.php'; 

	$first_name = "";
	$last_name = "";
	if( isset($_REQUEST['first_name']) ) $first_name = trim($_REQUEST['first_name']);
	if( isset($_REQUEST['last_name']) ) $last_name = trim($_REQUEST['last_name']);

	$query = mysqli_query($conn, "SELECT * FROM vw_loginusers WHERE firstname = '$first_name' and lastname = '$last_name'");

	if( mysqli_num_rows($query) > 0 ) {
		$valid = "false";
	}
	else {
		$valid = "true";
	}

	echo $valid;
?>