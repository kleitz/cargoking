<?php 
	include('protect.php');
	include 'dbconnect.php'; 

	$searchKey = trim($_REQUEST['searchKey']);
	$searchValue = trim($_REQUEST['searchValue']);

	$query = mysqli_query($conn, "select * from users where " . $searchKey . " ='" . $searchValue . "'");

	if( mysqli_num_rows($query) > 0 ) {
		$valid = "false";
	}
	else {
		$valid = "true";
	}

	echo $valid;
?>