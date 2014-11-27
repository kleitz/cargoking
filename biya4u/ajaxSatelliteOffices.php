<?php 
	include('protect.php');
	include 'dbconnect.php'; 

	$station_id = "";
	if( isset($_REQUEST['station_id']) ) $station_id = trim($_REQUEST['station_id']);

	$query = mysqli_query($conn, "select * from deliveryarea where station=" . $station_id . " order by city");

	$returnHtml = "<option value=''>--[Select]--</option>\n";
	while( $row = mysqli_fetch_assoc( $query ) ) {
		$returnHtml .= "<option value='" . $row['id'] ."'>" . $row['city'] . "</option>\n";
	}

	echo $returnHtml;
?>