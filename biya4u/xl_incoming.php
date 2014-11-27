<?php
	include('protect.php');
	include "dbconnect.php";

	session_start();

	$stationId = "";
	if( isset($_SESSION['stationId']) ) $stationId = $_SESSION['stationId'];

	$SQLBooking = "SELECT * FROM vw_booking_details WHERE hawb_status <> 3 ";
	$strOrderBy = " ORDER BY id desc ";

	$strStationFilter = "";
	if( $stationId != "" ) $strStationFilter = "destination_id = $stationId";

	/* START: Report download parameters (filters) */
	$fromDate  = "";
	$toDate    = "";
	$searchKey = "";
	$strDateRangeFilter = "";
	$strBookingFullTextSearchFilter = "";
	$hasDateRangeFilter = false;
	$hasSearchKeyFilter = false;

	if( isset($_GET['from']) )      $fromDate  = $_GET['from'];
	if( isset($_GET['to']) )        $toDate    = $_GET['to'];
	if( isset($_GET['searchKey']) ) $searchKey = $_GET['searchKey'];

	if( (isset($_GET['from']) && strlen(trim($_GET['from'])) > 0) && (isset($_GET['to']) && strlen(trim($_GET['to'])) > 0) ) {
		$strDateRangeFilter = " hawb_date between '" . $fromDate . "' AND '" . $toDate . "'";
		$hasDateRangeFilter = true;
	}

	if ( isset($_GET['searchKey']) ) {
		$searchKey = $_GET['searchKey'];
		$strBookingFullTextSearchFilter = " concat(id, lower(booking_code), lower(receiver_name), receiver_phone, lower(receiver_address), lower(customer_code), lower(sender_name), sender_phone, lower(sender_city), lower(sender_address), lower(origin), lower(destination)) like '%" . strtolower($searchKey) . "%'";		
		$hasSearchKeyFilter = true;
	}

	$strFilters = " AND ";
	if( $hasDateRangeFilter || $hasSearchKeyFilter ) {
		if( $hasDateRangeFilter ) $strFilters .= $strDateRangeFilter;
		if( $hasDateRangeFilter && $hasSearchKeyFilter ) $strFilters .= " AND ";
		if( $hasSearchKeyFilter ) $strFilters .= $strBookingFullTextSearchFilter;
		if( $stationId > 0 ) $strFilters .= " AND " . $strStationFilter;
	}
	else {
		$strFilters .= $strStationFilter;
	}

	$SQLCount = $SQLBooking . $strFilters;
	$SQLBookingResult = $SQLCount . $strOrderBy;

	echo "[SQL]: " . $SQLBookingResult;
	/* END */
		
	$result = mysqli_query($conn, $SQLBookingResult);

	//echo $SQL;

	$header = "Date \t HAWB No \t Shipper Name \t Origin \t Destination \t Weight \t Mode of Payment \t Total Weight \t Rate / Kilo \t Quantity \t Due to Cargo King \t Commission \t Grand Total";

	while($row = mysqli_fetch_array($result)){
		$line = '';
		$bido   = $row['booking_code'];
		$value  = $row['formatted_date'] . "\t" . $row['booking_code'] . "\t" . $row['sender_name'] . "\t";
		$value .= $row['origin'] . "\t" . $row['destination'] . "\t";
		$value .= $row['total_weight'] . "\t" . $row['payment_mode'] . "\t";

		$tot_wei  = $row['total_weight'];
		$quantity = $row['no_of_items'];
		$rateKG   = $row['rate'];
		$gTotal   = $row['total_price'];
		$comm     = $row['commission'];
		$duecar   = $row['amount_due'];

		$value .= $tot_wei . "\t" . $rateKG . "\t" . $quantity . "\t" . $duecar . "\t" . $comm . "\t" . $gTotal; 

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

	$header=$header."\n";

	$F= date("j-F-Y");
	$filename = "CargoKing.$F.xls";
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=$filename");
	header("Cache-Control: public");

	header("Expires: 0");
	print "$header\n$data";
?>