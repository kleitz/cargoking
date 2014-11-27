<?php 
	include('protect.php');
	include('dbconnect.php'); 

	$username = "";
	if( isset($_REQUEST['username']) ) $username = trim($_REQUEST['username']);

	$query = mysqli_query($conn, "SELECT * FROM vw_loginusers WHERE username = '$username'");

	if( mysqli_num_rows($query) > 0 ) {
		$valid = "false";
	}
	else {
		$valid = "true";
	}

	echo $valid;
?>