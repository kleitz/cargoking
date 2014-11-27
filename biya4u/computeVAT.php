<?php 
	include('protect.php');
	include('dbconnect.php');

	$rate = trim($_REQUEST['rate']);
	$has_vat = trim($_REQUEST['has_vat']);

	/* TODO: Convert this code to return JSON Objects and will be processed via Javascript instead of returning HTML codes. */
	
	$formattedFreightCharge = "";
	$formattedVAT = "";
 	if($has_vat == "withVAT") { 
		$freightCharge = ($rate * 100 ) / 112;
		$vat = $rate - $freightCharge;

		$formattedFreightCharge = number_format($freightCharge,'2','.',',');
		$formattedVAT = number_format($vat,'2','.',',');
	}
	else {
		$formattedFreightCharge = number_format($rate,'2','.',',');
	}

	$freightChargeAndVAT = array("freightCharge" => $formattedFreightCharge, "vat" => $formattedVAT);
	echo json_encode($freightChargeAndVAT);
?>