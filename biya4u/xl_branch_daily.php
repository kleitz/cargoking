<?php
	include('protect.php');
	include "dbconnect.php";
	include('utilities.php');
	include('constants.php');

	session_start();

	$login_id = "";
	$login_name = "";
	$agentId = "";
	$stationId = "";
	$satelliteOfficeId = "";
	$type_code = "";
	$branchName = "";
	if( isset($_SESSION['login_id']) )  $login_id   = $_SESSION['login_id'];
	if( isset($_SESSION['name']) )      $login_name = $_SESSION['name'];
	if( isset($_SESSION['stationId']) ) $stationId  = $_SESSION['stationId'];
	if( isset($_SESSION['type_code']) ) $type_code  = $_SESSION['type_code'];
	if( isset($_GET['agentId']) ) 		$agentId 	= $_GET['agentId'];
	if( isset($_SESSION['satellite_office_id']) ) $satelliteOfficeId = $_SESSION['satellite_office_id'];
	
	$SQLBooking = "SELECT *, amount_due + declared_value_insurance as ckdue_w_insurance, commission - discount as commission_net FROM vw_booking_daily WHERE origin_id = " . $stationId;
	$strOrderBy = " ORDER BY hawb_date desc ";

	/* START: Report download parameters (filters) */
	$branchId = 0;
	$hasSOFilter = false;
	if ( isset($_GET['branchId']) ) {
		$branchId = $_GET['branchId'];
		$hasSOFilter = true;
		if("" == $satelliteOfficeId) $satelliteOfficeId = $branchId;
	}
	if( $hasSOFilter ) {
		$strFilters .= " AND satellite_office_id = " . $satelliteOfficeId;
	}

	$SQLCount = $SQLBooking . $strFilters;
	$SQLBookingResult = $SQLCount . $strOrderBy;

	//echo "[SQL]: " . $SQLBookingResult;
	/* END */
		
	$result = mysqli_query($conn, $SQLBookingResult);

	//echo $SQL;

	$header = "Date \t HAWB No \t Shipper Name \t Origin \t Destination \t Weight \t Rate/KG \t Gross Total \t Discounted \t Commission \t Due to Cargo King";

	while($row = mysqli_fetch_array($result)){
		$line = '';
		$value  = $row['formatted_date'] . "\t" . $row['booking_code'] . "\t" . $row['sender_name'] . "\t";
		$value .= $row['origin'] . "\t" . $row['destination'] . "\t";

		$tot_wei  = $row['total_weight'];
		$rateKG = $row['computed_rate'];
		$gTotal   = $row['total_price'];
		$discountedPrice = $row['discounted_price'];
		$comm     = $row['commission_net'];
		$duecar   = $row['ckdue_w_insurance'];

		$value .= $tot_wei . "\t" . $rateKG . "\t" . $gTotal . "\t" . $discountedPrice . "\t" . $comm . "\t" . $duecar; 

		# important to escape any quotes to preserve them in the data.
		# needed to encapsulate data in quotes because some data might be multi line.
		# the good news is that numbers remain numbers in Excel even though quoted.
		$line .= $value;
		$data .= trim($line)."\n";
	}

	# this line is needed because returns embedded in the data have "\r"
	# and this looks like a "box character" in Excel
	$data = str_replace("\r", "", $data);

	$dueToCKTotals = 0;
	$grossTotals = 0;
	$discountedTotal = 0;
	$discountTotals = 0;
	$commissionTotals = 0;

	# Nice to let someone know that the search came up empty.
	# Otherwise only the column name headers will be output to Excel.
	if ($data == "") {
		$data = "\nno matching records found\n";
	}
	else {
		$SQLBranchTotals = " SELECT b.*, (b.insured_rate - b.discounted_total) as discounts FROM vw_booking_branch_totals_daily b WHERE b.satellite_office_id = " . $satelliteOfficeId;
		$rsBranchTotals = mysqli_fetch_assoc(mysqli_query($conn, $SQLBranchTotals));

		//echo "[SQL]: " . $SQLBranchTotals . "<br>";

		$dueToCKTotals = $rsBranchTotals["total_insured_ckdue"];
		$grossTotals = $rsBranchTotals["insured_rate"];
		$discountedTotal = $rsBranchTotals["discounted_total"];
		$discountTotals = $rsBranchTotals["discounts"];
		$commissionTotals = $rsBranchTotals["total_commission_net"];

		$data .= "\n\n";
		$data .= "Due to Cargo King Total:\t" . number_format((float) $dueToCKTotals, 2, '.', ',') . "\n";
		$data .= "Gross Total:\t" . number_format((float) $grossTotals, 2, '.', ',') . "\n";
		$data .= "Discounted Total:\t" . number_format((float) $discountedTotal, 2, '.', ',') . "\n";
		$data .= "Discounts:\t" . number_format((float) $discountTotals, 2, '.', ',') . "\n";
		$data .= "\n";
		$data .= "Sales Total:\t" . number_format((float) $commissionTotals, 2, '.', ',') . "\n";
	}

	$branchName = getBranchNameById($conn, $satelliteOfficeId);
	$title = "Branch Daily Sales Report";
	if("" != $branchName)
		$title .= " for (" . $branchName . ")";

	$header = $title . "\n\n" . $header . "\n";

	$F= date("j-F-Y");
	$filename = "CargoKing.$F.xls";
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=$filename");
	header("Cache-Control: public");

	header("Expires: 0");
	print "$header\n$data";
?>