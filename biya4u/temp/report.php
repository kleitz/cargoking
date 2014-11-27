<?php
	include('protect.php');
	include('dbconnect.php');
	include('paging.class.php');
	include('utilities.php');
	include('constants.php');

	session_start();

	$login = "";
	$type_code = "";
	$stationId = "";

	if( isset($_SESSION['username']) ) $login = $_SESSION['username'];
	if( isset($_SESSION['type_code']) ) $type_code = $_SESSION['type_code'];
	if( isset($_SESSION['stationId']) ) $stationId = $_SESSION['stationId'];
	
	$pager = new pager($_GET['p'], 15, $totalCount, 4);
	$offset = $pager->get_start_offset();
	$limit = 15;
	$strOffsetLimit = " LIMIT " . $offset . ", $limit";

	$strStationFilter = "";
	if( $stationId != "" ) $strStationFilter = "origin_id = $stationId";

	$SQLBooking = "SELECT * FROM vw_booking_details";
	$strOrderBy = " ORDER BY id desc ";

	$SQLBookingResult = "";

	/* Get Results count */
	$SQLCount         = $SQLBooking . ( $stationId > 0 ? " WHERE " . $strStationFilter : "");
	$totalCount       = mysqli_num_rows( mysqli_query($conn, $SQLCount) );	

	/* Get Booking Results */
	$SQLBookingResult = $SQLCount . $strOrderBy . $strOffsetLimit;
	$result           = mysqli_query($conn,  $SQLBookingResult);

	//echo "[SQL]: " . $SQLBookingResult . "<br>";
	
	$stationList = getStations($conn);
	$mopList     = getModeOfPayments($conn);
	
	$downloadUrl = "xl.php";
	//$downloadUrl = "xl.php?from=" . $from . "&to=" . $to . ( $stationId > 0 ? "&city=" . $stationId : "");
	
	if(isset($_GET['submit'])) {
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
			$strBookingFullTextSearchFilter = " concat(id, lower(booking_code), lower(receiver_name), receiver_phone, lower(receiver_address), lower(customer_code), lower(sender_name), sender_phone, lower(sender_city)) like '%" . strtolower($searchKey) . "%'";		
			$hasSearchKeyFilter = true;
		}

		$strFilters = "";
		if( $hasDateRangeFilter || $hasSearchKeyFilter ) {
			$downloadUrl .= "?";
			$strFilters .= " WHERE ";
			if( $hasDateRangeFilter ){
				$strFilters .= $strDateRangeFilter;
				$downloadUrl .= "from=" . $fromDate . "&to=" . $toDate;
			}
			if( $hasDateRangeFilter && $hasSearchKeyFilter ){
				$strFilters .= " AND ";
				$downloadUrl .= "&";
			}
			if( $hasSearchKeyFilter ){
				$strFilters .= $strBookingFullTextSearchFilter;
				$downloadUrl .= "searchKey=" . $searchKey;
			}
			if( $stationId > 0 ) $strFilters .= " AND " . $strStationFilter;
		}

		$SQLCount = $SQLBooking . $strFilters;
		$SQLBookingResult = $SQLCount . $strOrderBy . $strOffsetLimit;
		
		//echo "[SQL]: " . $SQLBookingResult . "<br>";
		
		$totalCount       = mysqli_num_rows( mysqli_query($conn, $SQLCount) );
		$result           = mysqli_query($conn, $SQLBookingResult);
	}
?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link href="css/style.css" type="text/css"  rel="stylesheet"/>
		<link href="css/superfish.css" rel="stylesheet" media="screen">
		<link href="css/blitzer/jquery-ui-1.10.4.custom.css" rel="stylesheet">
		<title>Admin</title>
		<style type="text/css">
			.style6 {font-family: Arial, Helvetica, sans-serif; font-size: 16px; font-weight: bold; color: #000000; text-decoration:none; line-height:30px;}
			.style6 a {font-family: Arial, Helvetica, sans-serif; font-size: 16px; font-weight: bold; color: #000000; text-decoration:none; }
			.style3 {
				color:#FF0000;
			}
			.ds_box {
				background-color: #FFF;
				border: 1px solid #000;
				position: absolute;
				z-index: 32767;
			}
			.ds_tbl {
				background-color: #FFF;
			}
			.ds_head {
				background-color: #333;
				color: #FFF;
				font-family: Arial, Helvetica, sans-serif;
				font-size: 13px;
				font-weight: bold;
				text-align: center;
				letter-spacing: 2px;
			}
			.ds_subhead {
				background-color: #CCC;
				color: #000;
				font-size: 12px;
				font-weight: bold;
				text-align: center;
				font-family: Arial, Helvetica, sans-serif;
				width: 32px;
			}
			.ds_cell {
				background-color: #EEE;
				color: #000;
				font-size: 13px;
				text-align: center;
				font-family: Arial, Helvetica, sans-serif;
				padding: 5px;
				cursor: pointer;
			}
			.ds_cell:hover {
				background-color: #F3F3F3;
			} /* This hover code won't work for IE */
		</style>
		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/hoverIntent.js"></script>
		<script src="js/superfish.js"></script>
		<script src="js/jquery-ui-1.10.4.custom.min.js"></script>
		<script src="js/jquery.validate.min.js"></script>
		<script src="js/jquery.ui.datepicker.validation.min.js"></script>
		<script type="text/javascript">
			var json_stations = <?php echo getJSONStations($conn); ?>;
			function getStationNameById($conn, stationdId){
				var station_name = "";
				for(station in json_stations.stationData){
					console.log("Station-name: " + station.area_name);
				}
				return station_name;
			}

			$(document).ready(function(){
				var example = $('#menuCKNavigation').superfish();

				$( "#from" ).datepicker({ dateFormat: 'yy-mm-dd' });
				$( "#to" ).datepicker({ dateFormat: 'yy-mm-dd' });
				
				$("#tab_bg tr:even").css("background-color", "#EBEBE0");
				$("#formReportFilters").validate({
					rules: {
						from: {
							required:true,
							dpDate: true
						},
						to: {
							required:true,
							dpDate: true
						}
					},

					messages: {
						from: {
							required:"From date should not be blank."
						},
						to: {
							required:"To date should not be blank."
						}
					},

					errorContainer: $('#errorContainer'),
					errorLabelContainer: $('#errorContainer ul'),
					wrapper: 'li'
				});

			});

			function MM_openBrWindow(theURL,winName,features) { //v2.0
			  window.open(theURL,winName,features);
			}
		</script>
	</head>

	<body>
		<div align="center">
			<table width="100%" border="0" cellspacing="0" cellpadding="0"  align="center">
				<tr>
					<td>
						<table width="900" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF" >
							<tr>
								<td><?php include('adminheader.php') ?></td>
							</tr>
							<tr>
								<td>
									<div id="errorContainer">
										<p>Please fill-up all the required fields and try again:</p>
										<ul />
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<table cellpadding="0" cellspacing="0" border="0" width="900" bgcolor="#FFFFFF">
										<tr>
											<td colspan="2" align="center" style="height: 50px;">
												<span style="font-size: 12px; font-weight: bold;">Report for 
												<?php
													$query = getAssociativeArrayFromSQL($conn, "select * from bplace where id = $stationId"));
													echo $query['category'];
												?>
												</span>
											</td>
										</tr>
										<tr><td>&nbsp;</td></tr>
										<tr>
											<td colspan="2">
												<?php
													$fromDate  = "";
													$toDate    = "";
													$searchKey = "";

													if( isset($_GET['from']) )       $fromDate   = $_GET['from'];
													if( isset($_GET['to']) )         $toDate     = $_GET['to'];
													if( isset($_GET['searchKey']) )  $searchKey  = $_GET['searchKey'];

												?>
												<form name="formReportFilters" id="formReportFilters" method="get">
													<div style="width: 400px; display: inline-block; padding-left: 15px;">
														<label for="from">From: </label>
														<input type="text" id="from" name="from" value="<?php echo $fromDate; ?>" style="width: 100px; font-size: 12px; padding: 2px 5px;" title="Please follow the format 'YYYY-MM-DD'." />
														<label for="to">to</label>
														<input type="text" id="to" name="to" value="<?php echo $toDate; ?>" style="width: 100px; font-size: 12px; padding: 2px 5px;" title="Please follow the format 'YYYY-MM-DD'." />
														<span style="font-size: 10px;"><i>(YYYY-MM-DD)</i></span>
													</div>
													<div align="right" style="width: 400px; display: inline-block;">
														<label for="txtSearchKey">Search by Key:</label>
														<input type="text" id="txtSearchKey" name="searchKey" value="<?php echo (isset($searchKey) ? $searchKey : "" ); ?>" style="width: 200px; font-size: 12px; padding: 2px 5px;" />
														
													</div>
													<div style="width: 50px; display: inline-block;">
														<input type="submit" id="btnSubmitSearchByKey" name="submit" value="Submit" />
													</div>
												</form>
											</td>
										</tr>
										<tr>
											<td colspan="2" align="center">
											<?php 
												if($totalCount == 0)
													echo ("<h3>Sorry No Records Found</h3>");
												else {
											?>
											&nbsp;
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<table width="98%" border="0" align="center" cellpadding="3" cellspacing="3">
													<tr>
														<td width="54%"><span class="Closed"><strong><?php echo $totalCount; ?> </strong></span><strong>Results Found</strong>.</td>
														<td width="46%"><div align="right"><?php echo $links = $pager->get_links(); ?></div></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<table width="98%" border="0" align="center" cellpadding="3" cellspacing="3">
													<tr>
														<td width="54%" align="right"><span class="Closed"><strong><a href="<?php echo $downloadUrl; ?>">Export in Excel</a></strong></span></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<table id="tab_bg" width="98%" border="0"  cellspacing="0" cellpadding="5" align="center" style="border:1px solid #181818; margin-bottom: 5px; box-shadow: 3px 3px 3px #888888;">
													<tr  id="head_bg"  bgcolor="#F4F4F4">
														<td class="displayAllTableHeader" width="11%" height="25"><div align="left"><strong>Date</strong></div></td>
														<td class="displayAllTableHeader" width="8%"><div align="left"><strong>HAWB No</strong></div></td>
														<td class="displayAllTableHeader" width="16%"><div align="left"><strong>Shipper Name</strong></div></td>
														<td class="displayAllTableHeader" width="6%"><div align="left"><strong>Origin</strong></div></td>
														<td class="displayAllTableHeader" width="9%"><div align="left"><strong>Destination</strong></div></td>
														<td class="displayAllTableHeader" width="5%"><div align="left"><strong>W</strong></div></td>
														<td class="displayAllTableHeader" width="5%"><div align="left"><strong>QTY</strong></div></td>
														<td class="displayAllTableHeader" width="12%"><div align="left"><strong>Payment Mode</strong></div></td>
														<td class="displayAllTableHeader" width="10%"><div align="left"><strong>Due to CK</strong></div></td>
														<td class="displayAllTableHeader" width="9%"><div align="left"><strong>Commission</strong></div></td>
														<td class="displayAllTableHeader" width="8%"><div align="left"><strong>Total</strong></div></td>
													</tr>
													<?php 
														while($fet_2=mysqli_fetch_array($result)) {
														//	include('results.php');
													?>
													<tr>
														<td width="11%"><?php echo  $fet_2['formatted_date']; ?></td>
														<td width="8%" class="small"><?php echo $fet_2['booking_code']; ?></td>
														<td width="16%" class="small"><?php echo $fet_2['sender_name']; ?></td>
														<td width="6%" class="small"><?php echo $fet_2['origin']; ?></td>
														<td width="9%" class="small"><?php echo $fet_2['destination']; ?></td>
														<td width="5%"><?php echo $fet_2['total_weight']; ?></td>
														<td width="5%"><?php echo $fet_2['no_of_items']; ?></td>
														<td width="12%" class="small"><?php echo $fet_2['payment_mode']; ?></td>
														<td width="10%"><?php echo $fet_2['amount_due']; ?></td>
														<td width="9%"><?php echo $fet_2['commission']; ?></td>
														<td width="8%"><?php echo $fet_2['total_price']; ?></td>
													</tr>
													<?php 
														}
													?>
												</table>
											</td>
										</tr>
									<?php } ?>
									</table>
								</td>
							</tr>
							<tr>
								<td><?php include('adminfooter.php') ?></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>