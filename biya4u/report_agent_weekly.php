<?php
	include('protect.php');
	include('dbconnect.php');
	include('paging.class.php');
	include('utilities.php');
	include('constants.php');

	session_start();

	$login_id = "";
	$login_name = "";
	$type_code = "";
	$stationId = "";
	if( isset($_SESSION['login_id']) )  $login_id   = $_SESSION['login_id'];
	if( isset($_SESSION['name']) )      $login_name = $_SESSION['name'];
	if( isset($_SESSION['type_code']) ) $type_code  = $_SESSION['type_code'];
	if( isset($_SESSION['stationId']) ) $stationId  = $_SESSION['stationId'];

	$searchAgentId = "";
	if( isset($_SESSION['login_id']) ){
		$login_id 		 = $_SESSION['login_id'];
	}

	if(isset($_GET['submit'])) {
		if( isset($_GET['soAgents']) ) {
			$searchAgentId = $_GET['soAgents'];
		}
	}

	$agentName = "";

	$dueToCKTotals = 0;
	$grossTotals = 0;
	$discountedTotal = 0;
	$discountTotals = 0;
	$commissionTotals = 0;

	$downloadUrl = "xl_agent_weekly.php";
	$SQLBooking  = " SELECT *, amount_due + declared_value_insurance as ckdue_w_insurance, commission - discount as commission_net ";
	$SQLBooking .= " FROM vw_booking_previous_week WHERE origin_id = " . $stationId;
	$strOrderBy  = " ORDER BY hawb_date desc ";
	$SQLAgentFilter = "";

	if( "" != $searchAgentId ) {
		$SQLAgentFilter .= " AND agent_id = " . $searchAgentId;
		$agentName = getAgentNameById($conn, $searchAgentId);
		$downloadUrl .= "?agentId=" . $searchAgentId;

		$SQLAgentTotals = " SELECT b.*, (b.insured_rate - b.discounted_total) as discounts FROM vw_booking_agent_totals_weekly b WHERE origin_id = " . $stationId . " and agent_id = " . $searchAgentId;
		$rsAgentTotals = mysqli_fetch_assoc(mysqli_query($conn, $SQLAgentTotals));
		//echo "[SQL]: " . $SQLAgentTotals . "<br>";

		$dueToCKTotals = $rsAgentTotals["total_insured_ckdue"];
		$grossTotals = $rsAgentTotals["insured_rate"];
		$discountedTotal = $rsAgentTotals["discounted_total"];
		$discountTotals = $rsAgentTotals["discounts"];
		$commissionTotals = $rsAgentTotals["total_commission_net"];
	}

	/* START: Paging Codes */
	$SQLBooking .= $SQLAgentFilter;
	$sqlTotalCount = " select count(id) as row_count from vw_booking_previous_week WHERE origin_id = " . $stationId;
	if( "" != $searchAgentId ) $sqlTotalCount .= " and agent_id = " . $searchAgentId . " limit 1 ";
	$total_results = (mysqli_query($conn,  $sqlTotalCount )); 
	$row = mysqli_fetch_assoc($total_results);
	$totalCount = $row['row_count'];
	
	$pager = new pager($_GET['p'], 15, $totalCount, 4);
	$offset = $pager->get_start_offset();
	$limit = 15;
	$strOffsetLimit = " LIMIT " . $offset . ", $limit";
	/* END */

	$SQLBookingResult = "";

	/* Get Results count */
	$SQLCount         = $SQLBooking;
	$totalCount       = mysqli_num_rows( mysqli_query($conn, $SQLCount) );	

	/* Get Booking Results */
	$SQLBookingResult = $SQLCount . $strOrderBy . $strOffsetLimit;
	$result           = mysqli_query($conn,  $SQLBookingResult);
	//echo "[SQL]: " . $SQLBookingResult . "<br>";

	$sqlSOAgents = " SELECT id as value, concat(name, ' (', code, ')') as label FROM vw_satellite_office_agents WHERE station_id = " . $stationId . " order by name";
	$rsSOAgents  = mysqli_query($conn,  $sqlSOAgents);
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
				$("#btnSubmitSearchByKey").button();
				$("#tab_bg tr:even").css("background-color", "#EBEBE0");
				$("#selSOAgents").val(<?php echo $searchAgentId; ?>);
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
												Agent Weekly Sales Report
												<?php
													if( "" != $agentName) {
														echo " for (" . $agentName . ")";
													}
												?>
												</span>
											</td>
										</tr>
										<tr><td colspan="2" align="center">&nbsp;</td></tr>
										<?php
											if( $type_code == MANAGER ) {
										?>
										<tr>
											<td colspan="2">
												<form name="formReportFilters" id="formReportFilters" method="get">
													<div style="width: 550px; display: inline-block; padding-left: 15px;">
														<label for="selSOAgents" style="font-weight: bold;">Agent:</label>
														<select id="selSOAgents" name="soAgents" class="form-field" style="width: 400px; display: inline-block;">
															<option value="-1">Please select a branch agent</option>
															<?php
																while( $fet_2 = mysqli_fetch_array($rsSOAgents) ) {
																	echo "<option value=\"" . $fet_2["value"] . "\">" . $fet_2["label"] . "</option>";
																}
															?>
														</select>
														<input id="btnSubmitSearchByKey" type="submit" name="submit" value="Submit" />
													</div>
												</form>
											</td>
										</tr>
										<?php
											}
										?>
										<tr><td colspan="2" align="center">&nbsp;</td></tr>
										<tr>
											<td colspan="2">
												<table width="98%" border="0" align="center" cellpadding="3" cellspacing="3">
													<tr>
														<td width="54%" align="right"><span class="Closed"><strong><a href="javascript:void(0)" onclick="location.href='<?php echo $downloadUrl; ?>'">Export in Excel</a></strong></span></td>
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
														<td width="50%" class="totalTopRow">
															<b><u>Note:</u></b><br>
															<i>Total values are generated after selecting and submitting an agent.</i>
														</td>
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