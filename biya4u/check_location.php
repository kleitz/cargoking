<?php 
	include('protect.php');
	include 'dbconnect.php'; 

	$location = "";
	if( isset($_REQUEST['location']) ) $location = trim($_REQUEST['location']);

	$query = mysqli_query($conn, "SELECT * FROM bplace WHERE cat = '$location'");

	if( mysqli_num_rows($query) > 0 ) {
		$valid = "false";
	}
	else {
		$valid = "true";
	}

	echo $valid;
?>