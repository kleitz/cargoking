<?php
	include('protect.php');
	include('dbconnect.php');
	//include('paging.class.php');
	include('utilities.php');
	include('constants.php');

	session_start();

	$stationId = "";
	$station_name = "";
	if( isset($_SESSION['stationId']) ){
		$stationId = $_SESSION['stationId'];
		$SQLStation = "select id, category as station_name from bplace where id = " . $stationId;
		$station = mysqli_fetch_assoc(mysqli_query($conn, $SQLStation));
		$station_name = $station["station_name"];
	}

	//$pager = new pager($_GET['p'], 15, $totalCount, 4);
	//$offset = $pager->get_start_offset();
	//$limit = 15;
	//$strOffsetLimit = " LIMIT " . $offset . ", $limit";

	$SQLBooking = "SELECT * FROM vw_booking_chart_monthly WHERE origin_id = " . $stationId;
	$strOrderBy = " ORDER BY so_branch asc"; 

	$SQLBookingResult = "";

	/* Get Results count */
	$SQLCount         = $SQLBooking;
	$totalCount       = mysqli_num_rows( mysqli_query($conn, $SQLCount) );	

	/* Get Booking Results */
	$SQLBookingResult = $SQLCount . $strOrderBy;
	$result           = mysqli_query($conn,  $SQLBookingResult);

	$bFirst = true;
	$strChartData = "";
	$chartData = array();
	while($row = mysqli_fetch_array($result)) {
		$chartData[ $row["so_branch"] ] = floatval($row["sales"]);
		if( $bFirst )
			$bFirst = false;
		else
			$strChartData .= ", ";
			
		$strChartData .= "[\"" . $row["so_branch"] . "\", " . floatval($row["sales"]) . "]";
	}
	
	$strChartData = "[ [ " . $strChartData . "] ]";
	
	//echo "[SQL]: " . $SQLBookingResult . "<br>";
	//echo "[JSON-Data]: " .$strChartData . "<br>";

	$monthlyStationSales = 0;
?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link href="css/style.css" type="text/css"  rel="stylesheet"/>
		<link href="css/superfish.css" rel="stylesheet" media="screen">
		<link href="css/blitzer/jquery-ui-1.10.4.custom.css" rel="stylesheet">
		<link href="css/jquery.jqplot.min.css" type="text/css" rel="stylesheet"  />
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
		<script src="js/jquery.jqplot.min.js"></script>
		<script src="js/jqplot.pieRenderer.min.js"></script>
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
				var SF = $('#menuCKNavigation').superfish();

				$("#tab_bg tr:even").css("background-color", "#EBEBE0");
				$("#formReportFilters").validate({
					rules: {
						searchKey: {
							required:true
						}
					},

					messages: {
						searchKey: {
							required:"Please enter keyword to search."
						}
					},

					errorContainer: $('#errorContainer'),
					errorLabelContainer: $('#errorContainer ul'),
					wrapper: 'li'
				});

				//START: Pie Chart
				plot2 = jQuery.jqplot(
							'divStationBranchesComparator', 
							<?php echo $strChartData; ?>, 
							{
							  title: '', 
							  seriesDefaults: {
								shadow: false, 
								renderer: jQuery.jqplot.PieRenderer, 
								rendererOptions: { 
								  startAngle: 180, 
								  sliceMargin: 4, 
								  showDataLabels: true } 
							  }, 
							  legend: { show:true, location: 'w' }
							}
				);
				//END: Pie Chart


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
												Monthly Branches Sales Comparator Report for ( <?php echo $station_name; ?> )
												</span>
											</td>
										</tr>
										<tr><td colspan="2" align="center">&nbsp;</td></tr>
										<tr>
											<td colspan="2" align="center">
												<div id="divStationBranchesComparator" style="margin-top:20px; width:500px; height:300px; border: 2px solid black; text-align: center;"></div>
											</td>
										</tr>
										<tr><td colspan="2" align="center">&nbsp;</td></tr>
										<tr>
											<td colspan="2">
												<table width="500" border="0" align="center" cellpadding="3" cellspacing="3">
													<tr>
														<td width="54%"><span class="Closed"><strong><?php echo $totalCount; ?> </strong></span><strong>Results Found</strong>.</td>
														<td width="46%"><div align="right">&nbsp;</div></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<table id="tab_bg" width="500" border="0"  cellspacing="0" cellpadding="5" align="center" style="border:1px solid #181818; margin-bottom: 5px; box-shadow: 3px 3px 3px #888888;">
													<tr  id="head_bg"  bgcolor="#F4F4F4">
														<td class="displayAllTableHeader" style="width: 75%; padding: 3px 20px; text-align: left;"><b>Satellite Office</b></td>
														<td class="displayAllTableHeader" style="width: 25%; padding: 3px 20px; text-align: center;"><b>Sales</b></td>
													</tr>
													<?php
														if(count($chartData) > 0) {
															foreach($chartData as $key => $value) {
																$monthlyStationSales += $value;
													?>
													<tr>
														<td width="10%" style="padding: 6px 20px; text-align: left;"><?php echo $key; ?></td>
														<td width="16%" style="padding: 6px 20px; text-align: center;">Php&nbsp;<?php echo number_format((float) $value, 2, '.', ','); ?></td>
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
										<tr><td colspan="2">&nbsp;</td></tr>
										<!-- START: TOTALS -->
										<tr>
											<td colspan="2" align="center">
												<table style="width: 500px;" cellpadding="0" cellspacing="0">
													<tr>
														<td width="50%" class="GrandTotalRows">
															<span class="GrandTotalHeader">Total Sales for <?php echo $station_name; ?>:</span>
														</td>
														<td width="50%" align="right" class="GrandTotalRows">
															<span id="GrandTotalData" class="totalsData">Php&nbsp;<?php echo number_format((float) $monthlyStationSales, 2, '.', ''); ?></span>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<!-- END -->
										<tr><td colspan="2">&nbsp;</td></tr>
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