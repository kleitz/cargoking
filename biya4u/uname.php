<?php 
	include('protect.php');
	include 'dbconnect.php'; 

	$sug = trim($_REQUEST['uname']);
	$query = mysqli_query($conn, "select * from users where username ='$sug'");

	if( mysqli_num_rows($query) > 0 ) {
		$valid = "false";
	}
	else {
		$valid = "true";
	}

	echo $valid;
?>