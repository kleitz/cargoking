<?php
	include('protect.php');
	include('dbconnect.php');
	include('paging.class.php');
	include('utilities.php');
	include('constants.php');

	session_start();

	$downloadUrl = "xl_station_daily.php?";

	$stationId = "";
	$station_name = "";
	if( isset($_SESSION['stationId']) ){
		$stationId = $_SESSION['stationId'];
		$station_name = getStationNameById($conn, $stationId);
	}

	$SQLBooking = "SELECT *, amount_due + declared_value_insurance as ckdue_w_insurance, commission - discount as commission_net FROM vw_booking_daily WHERE origin_id = " . $stationId;
	$strOrderBy = " ORDER BY hawb_date desc ";

	$sqlTotalCount = " select count(id) as row_count from vw_booking_daily WHERE origin_id = " . $stationId . " limit 1 ";
	$total_results = (mysqli_query($conn,  $sqlTotalCount )); 
	$row = mysqli_fetch_assoc($total_results);
	$totalCount = $row['row_count'];

	$pager = new pager($_GET['p'], 15, $totalCount, 4);
	$offset = $pager->get_start_offset();
	$limit = 15;
	$strOffsetLimit = " LIMIT " . $offset . ", $limit";

	$SQLBookingResult = "";

	/* Get Results count */
	$SQLCount         = $SQLBooking;
	$totalCount       = mysqli_num_rows( mysqli_query($conn, $SQLCount) );	

	/* Get Booking Results */
	$SQLBookingResult = $SQLCount . $strOrderBy . $strOffsetLimit;
	$result           = mysqli_query($conn,  $SQLBookingResult);
	//echo "[SQL]: " . $SQLBookingResult . "<br>";

	$SQLStationTotals = " SELECT b.*, (b.insured_rate - b.discounted_total) as discounts FROM vw_booking_station_totals_daily b WHERE b.origin_id = " . $stationId;
	$rsStationTotals = mysqli_fetch_assoc(mysqli_query($conn, $SQLStationTotals));
	//echo "[SQL]: " . $SQLStationTotals . "<br>";

	$dueToCKTotals = $rsStationTotals["total_insured_ckdue"];
	$grossTotals = $rsStationTotals["insured_rate"];
	$discountedTotal = $rsStationTotals["discounted_total"];
	$discountTotals = $rsStationTotals["discounts"];
	$commissionTotals = $rsStationTotals["total_commission_net"];
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
				var sf = $('#menuCKNavigation').superfish();
				$("#tab_bg tr:even").css("background-color", "#EBEBE0");
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
												<span class="textShadow" style="font-size: 14px; font-weight: bold;">
												Station Daily Sales Report for ( <?php echo $station_name; ?> )
												</span>
											</td>
										</tr>
										<tr><td colspan="2" align="center">&nbsp;</td></tr>
										<tr>
											<td colspan="2">
												<table width="98%" border="0" align="center" cellpadding="3" cellspacing="3">
													<tr>
														<td width="54%" align="right"><span class="Closed"><strong><a href="<?php echo $downloadUrl; ?>">Export in Excel</a></strong></span></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr><td colspan="2" align="center">&nbsp;</td></tr>
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
												<table id="tab_bg" width="98%" border="0"  cellspacing="0" cellpadding="5" align="center" style="border:1px solid #181818; margin-bottom: 5px; box-shadow: 3px 3px 3px #888888;">
													<tr  id="head_bg"  bgcolor="#F4F4F4">
														<td class="displayAllTableHeader" width="10%"><div align="left"><strong>HAWB No</strong></div></td>
														<td class="displayAllTableHeader" width="16%"><div align="left"><strong>Shipper Name</strong></div></td>
														<td class="displayAllTableHeader" width="6%"><div align="left"><strong>Origin</strong></div></td>
														<td class="displayAllTableHeader" width="9%"><div align="left"><strong>Destination</strong></div></td>
														<td class="displayAllTableHeader" width="5%"><div align="left"><strong>W</strong></div></td>
														<td class="displayAllTableHeader" width="7%"><div align="left"><strong>Rate</strong></div></td>
														<td class="displayAllTableHeader" width="10%"><div align="left"><strong>Total</strong></div></td>
														<td class="displayAllTableHeader" width="8%"><div align="left"><strong>Discounted</strong></div></td>
														<td class="displayAllTableHeader" width="9%"><div align="left"><strong>Commission</strong></div></td>
														<td class="displayAllTableHeader" width="10%"><div align="left"><strong>Due to CK</strong></div></td>
													</tr>
													<?php
														if($totalCount > 0) {
															while($fet_2=mysqli_fetch_array($result)) {
													?>
													<tr>
														<td width="10%" class="small"><?php echo $fet_2['booking_code']; ?></td>
														<td width="16%" class="small"><?php echo $fet_2['sender_name']; ?></td>
														<td width="6%" class="small"><?php echo $fet_2['origin']; ?></td>
														<td width="9%" class="small"><?php echo $fet_2['destination']; ?></td>
														<td width="5%"><?php echo number_format((float) $fet_2['total_weight'], 2, '.', ','); ?></td>
														<td width="7%"><?php echo number_format((float) $fet_2['computed_rate'], 2, '.', ','); ?></td>
														<td width="10%"><?php echo number_format((float) $fet_2['total_price'], 2, '.', ','); ?></td>
														<td width="8%"><?php echo number_format((float) $fet_2['discounted_price'], 2, '.', ','); ?></td>
														<td width="9%"><?php echo number_format((float) $fet_2['commission_net'], 2, '.', ','); ?></td>
														<td width="10%"><?php echo number_format((float) $fet_2['ckdue_w_insurance'], 2, '.', ','); ?></td>
													</tr>
													<?php 
															}
														}
														else {
													?>
														<tr><td colspan="11" align="center"><span class="dataNotFound">Data not found.</span></td></tr>
													<?php
														}
													?>
												</table>
											</td>
										</tr>
										<!-- START: TOTALS -->
										<tr>
											<td align="center">
												<table style="width: 98%;" cellpadding="0" cellspacing="0">
													<tr>
														<td width="50%" class="totalTopRow">&nbsp;</td>
														<td width="50%" align="right" class="totalTopRow">
															<span class="totalsHeader">Due to Cargo King Total:</span>
															<span id="spnDueToCKTotals" class="totalsData">Php&nbsp;<?php echo number_format((float) $dueToCKTotals, 2, '.', ','); ?></span>
														</td>
													</tr>
													<tr>
														<td width="50%" class="totalRows">&nbsp;</td>
														<td width="50%" align="right" class="totalRows">
															<span class="totalsHeader">Gross Total:</span>
															<span id="spnGrossTotals" class="totalsData">Php&nbsp;<?php echo number_format((float) $grossTotals, 2, '.', ','); ?></span>
														</td>
													</tr>
													<tr>
														<td width="50%" class="totalRows">&nbsp;</td>
														<td width="50%" align="right" class="totalRows">
															<span class="totalsHeader">Discounted Total:</span>
															<span id="spnCommissionTotals" class="totalsData">Php&nbsp;<?php echo number_format((float) $discountedTotal, 2, '.', ','); ?></span>
														</td>
													</tr>
													<tr>
														<td width="50%" class="totalRows">&nbsp;</td>
														<td width="50%" align="right" class="totalRows">
															<span class="totalsHeader">Discounts:</span>
															<span id="spnDiscountTotals" class="totalsData">Php&nbsp;<?php echo number_format((float) $discountTotals, 2, '.', ','); ?></span>
														</td>
													</tr>
													<tr>
														<td width="50%" class="GrandTotalRows">
															<span class="GrandTotalHeader">Sales Total:</span>
														</td>
														<td width="50%" align="right" class="GrandTotalRows">
															<span id="GrandTotalData" class="totalsData">Php&nbsp;<?php echo number_format((float) $commissionTotals, 2, '.', ','); ?></span>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<!-- END -->
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