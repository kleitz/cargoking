<?php 
	include('protect.php');
	include 'dbconnect.php'; 

	$stationAdminId = "";
	$searchKey = "";
	$searchValue = "";
	
	if( isset($_REQUEST['stationAdminId']) ) $stationAdminId = $_REQUEST['stationAdminId'];
	if( isset($_REQUEST['searchKey']) )      $searchKey      = trim($_REQUEST['searchKey']);
	if( isset($_REQUEST['searchValue']) )    $searchValue    = trim($_REQUEST['searchValue']);
	
	

	$query = mysqli_query($conn, "SELECT * FROM users WHERE " . $searchKey . " ='" . $searchValue . "' AND id <> " . $stationAdminId);

	if( mysqli_num_rows($query) > 0 ) {
		$valid = "false";
	}
	else {
		$valid = "true";
	}

	echo $valid;
?>