<?php 
	include('protect.php');
	include('dbconnect.php'); 

	$movementType = "";
	if( isset($_REQUEST['movementType']) ) $movementType = trim($_REQUEST['movementType']);

	$query = mysqli_query($conn, "SELECT * FROM movement_type WHERE movement_type = '$movementType'");

	if( mysqli_num_rows($query) > 0 ) {
		$valid = "false";
	}
	else {
		$valid = "true";
	}

	echo $valid;
?>