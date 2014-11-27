<?php
	include('protect.php');
	include "dbconnect.php";
	include('utilities.php');

	session_start();

	$stationId = "";
	if( isset($_SESSION['stationId']) ) $stationId = $_SESSION['stationId'];
	
	$SQLBooking = "SELECT *, amount_due + declared_value_insurance as ckdue_w_insurance, commission - discount as commission_net  FROM vw_booking_previous_month WHERE origin_id = " . $stationId;
	$strOrderBy = " ORDER BY hawb_date desc ";

	/* START: Report download parameters (filters) */
	$searchKey = "";
	$strBookingFullTextSearchFilter = "";
	$hasSearchKeyFilter = false;

	if ( isset($_GET['searchKey']) ) {
		$searchKey = $_GET['searchKey'];
		$strBookingFullTextSearchFilter = " concat(id, lower(booking_code), lower(origin), lower(destination), lower(receiver_name), receiver_phone, lower(receiver_address), lower(customer_code), lower(sender_name), sender_phone, lower(sender_city)) like '%" . strtolower($searchKey) . "%'";		
		$hasSearchKeyFilter = true;
	}

	$strFilters  = "";
	if( $hasSearchKeyFilter ) {
		$strFilters  = " AND ";
		$strFilters .= $strBookingFullTextSearchFilter;
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


	# Nice to let someone know that the search came up empty.
	# Otherwise only the column name headers will be output to Excel.
	if ($data == "") {
		$data = "\nno matching records found\n";
	}
	else {
		$SQLStationTotals = " SELECT b.*, (b.insured_rate - b.discounted_total) as discounts FROM vw_booking_station_totals_monthly b WHERE b.origin_id = " . $stationId;
		$rsStationTotals = mysqli_fetch_assoc(mysqli_query($conn, $SQLStationTotals));

		$dueToCKTotals = $rsStationTotals["total_insured_ckdue"];
		$grossTotals = $rsStationTotals["insured_rate"];
		$discountedTotal = $rsStationTotals["discounted_total"];
		$discountTotals = $rsStationTotals["discounts"];
		$commissionTotals = $rsStationTotals["total_commission_net"];

		$data .= "\n\n";
		$data .= "Due to Cargo King Total:\t" . number_format((float) $dueToCKTotals, 2, '.', ',') . "\n";
		$data .= "Gross Total:\t" . number_format((float) $grossTotals, 2, '.', ',') . "\n";
		$data .= "Discounted Total:\t" . number_format((float) $discountedTotal, 2, '.', ',') . "\n";
		$data .= "Discounts:\t" . number_format((float) $discountTotals, 2, '.', ',') . "\n";
		$data .= "\n";
		$data .= "Sales Total:\t" . number_format((float) $commissionTotals, 2, '.', ',') . "\n";		
	}

	$stationName = getStationNameById($conn, $stationId);
	$title = "Station Monthly Sales Report";
	if("" != $stationName)
		$title .= " for (" . $stationName . ")";

	$header = $title . "\n\n" . $header . "\n";

	$F= date("j-F-Y");
	$filename = "CargoKing.$F.xls";
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=$filename");
	header("Cache-Control: public");

	header("Expires: 0");
	print "$header\n$data";
?>