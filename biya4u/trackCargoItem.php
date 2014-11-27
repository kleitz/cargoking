<?php
	/* include('protect.php'); */
	include('dbconnect.php');

	$hawb_code = "";
	if( isset($_REQUEST['hawb_code']) ) $hawb_code = trim($_REQUEST['hawb_code']);

	$cargoInfos = array();
	if( strlen($hawb_code) > 0 ) {
		$result = mysqli_query($conn, " select * from vw_track_booking where booking_code = '" . $hawb_code . "' LIMIT 1 ");
		$cargoInfos = mysqli_fetch_assoc($result);
	}

	//$sampleJSONData = array("hawb_code" => "CK-DVO-BUHANGIN-1039", "freightChargeAndVAT" => "Php 1250.00");
	//echo json_encode($sampleJSONData);

	echo json_encode($cargoInfos);
?>