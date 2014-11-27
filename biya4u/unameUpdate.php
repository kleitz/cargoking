<?php 
	include('protect.php');
	include 'dbconnect.php'; 

	$username   = "";
	$stationAdminId   = "";
	if( isset($_REQUEST['uname']) )          $username       = trim($_REQUEST['uname']);
	if( isset($_REQUEST['stationAdminId']) ) $stationAdminId = trim($_REQUEST['stationAdminId']);

	$query = mysqli_query($conn, "select * from users where username ='$username' and id <> $stationAdminId");

	if( mysqli_num_rows($query) > 0 ) {
		$valid = "false";
	}
	else {
		$valid = "true";
	}

	echo $valid;
?>