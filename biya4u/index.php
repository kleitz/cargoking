<?php 
	include('protect.php');
	include('dbconnect.php');
	include('paging.class.php');
	include('constants.php');

	session_start();

	$login     = "";
	$type_code = "";
	$stationId = "";
	if( isset($_SESSION['username']) )  $login     = $_SESSION['username'];
	if( isset($_SESSION['type_code']) ) $type_code = $_SESSION['type_code'];
	if( isset($_SESSION['stationId']) ) $stationId = $_SESSION['stationId'];

	/*
	echo "[TYPE]: " . $type_code . "<br>";
	echo "[STATION-ID]: " . $stationId . "<br>";
	*/

	if( $type_code == SO_AGENT ) {
		if( isset($_GET['search']) ){
			$hawbCode = html_entity_decode($_GET['search']);
			$sqlWhereFilter = " WHERE booking_code = '$hawbCode'";

			$total_results = (mysqli_query($conn,  "SELECT COUNT(*) as row_num FROM vw_booking_details" . $sqlWhereFilter )); 		
			$row = mysqli_fetch_assoc($total_results);
			$totalCount = $row['row_num'];	

			$pager = new pager($_GET['p'], 15, $totalCount, 4);
			$offset = $pager->get_start_offset();
			$limit = 15;

			// Perform MySQL query on only the current page number's results 
			$SQLQuery = "SELECT * FROM vw_booking_details" . $sqlWhereFilter . "  ORDER BY hawb_date desc LIMIT " . $offset . ", $limit ";
			
			//echo "[SQL]: " . $SQLQuery . "<br>";
			
			$result = mysqli_query($conn, $SQLQuery);
		}
	}
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Admin</title>
    <link href="css/style.css" type="text/css"  rel="stylesheet"/>
    <link href="css/styleMenu.css" rel="stylesheet" media="screen">
    <link href="css/blitzer/jquery-ui-1.10.4.custom.css" rel="stylesheet">

	<style>
		#tblUtiltiesSettings, #tblHawb, #tblAdminSettings, #tblManageUsers, #tblReports {
			margin-top: 15px;
			width: 340px;
			font-family: "OpenSanRegular";
		}

		#tblUtiltiesSettings ul, #tblHawb ul, #tblAdminSettings ul, #tblManageUsers ul, #tblReports ul {
			list-style-type: none;
			padding-left: 0px;
		}

		.tableItems {
			width: 100%;
			border-spacing: 0px;
		}
		.tableItems:not(:last-child) {
			border-bottom: 1px dashed #BCBCBC;
		}
		.tableItems ul {
			list-style-type: none;
			padding-left: 0px;
		}

		.utilities {
			background-color: #3D3D45;
			height:25px;
			font-family: "OpenSanRegular";
			font-size:13px;
			font-weight:bold; color:#044d65;
			text-align: center;
			height: 30px;
		}
		.utilitiesLabel {
			color: #fff;
			margin-left: 10px;
		}
		.boxLineNoPadding {
			border: 3px solid #3D3D45;
			padding: 0px 15px;
		}
		.boxLineNoPadding ul li:not(:last-child) { border-bottom: 1px dashed #BCBCBC; }

		.boxLineVerticalPadding {
			border: 3px solid #3D3D45;
			padding: 10px 15px 10px 15px;
		}

		.listItem {
			font-family: "OpenSanRegular";
			font-size:14px;
			color: #333333;
		}

		.listLink {
			font-family: "OpenSanRegular";
			font-size:14px;
			color: #333333;
			text-decoration: none;
			line-height: 30px;
		}

		a.listLink:Link, a.listLink:Visited, a.listLink:Active { color: #333; }
		a.listLink:Hover { color: #000; font-weight: bold; }
	</style>

    <script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/jquery.bpopup.min.js"></script>
	<script src="js/menu.js"></script>

    <!--
    <script src="js/jquery-ui-1.10.4.custom.min.js"></script>
    -->

    <script type="text/javascript">
    	var SCROLL_TOP_LIMIT = 130;

    	$(document).ready(function(){
    		$("#menuContainerDiv").wrap("<div class=\"menuPlaceholder\"></div>");
    		$(".menuPlaceholder").height($("#menuContainerDiv").outerHeight());
    	});

    	$(document).scroll(function(evt){
    		showFloatingMenu(SCROLL_TOP_LIMIT);
    	});
    </script>
</head>

<body>
  <center>
    <!-- Header -->
    <div class="headerContainers" align="left">
      <?php include('header_flat.php'); ?>
    </div>

    <!-- Menu -->
    <div id="menuContainerDiv" class="containers menu" align="left" style="border-bottom: 5px solid #FF5151;">
      <?php include('menu_flat.php'); ?>
    </div>

    <!-- Contents -->
    <div class="containers contents">
      <div style="float: left; padding: 20px 65px;">
		<table id="tblUtiltiesSettings" border="0" align="center" cellpadding="0"  cellspacing="0">
			<tr>
				<td align="center" valign="middle" class="utilities">
					<img src="images/tools.png" class="flatIcon" />
					<span class="utilitiesLabel">Control Panel</span>
				</td>
			</tr>
			<tr>
				<td class="boxLineVerticalPadding">
					<?php if( $type_code == SO_AGENT || $type_code == MANAGER ){ ?>
					<table class="tableItems">
						<tr>
							<td width="150"><ul style=""><li class="listItem">Customer</li></ul></td>
							<td align="right">
								<a class="lnkButton" href="javascript:void(0)" onclick="location.href='customer.php'"><img src="images/flat_icons/text70.png" class="imageButtonFlat" title="Add Customer Record" /></a>
								<?php if( $type_code == MANAGER ){ ?>
									<a class="lnkButton" href="javascript:void(0)" onclick="location.href='customer_list.php'"><img src="images/flat_icons/open131.png" class="imageButtonFlat" title="Manage Customer Records" /></a>
								<?php } ?>
							</td>
						</tr>
					</table>
					<?php } ?>

					<?php if( $type_code == ADMIN ) { ?>
					<table class="tableItems">
						<tr>
							<td width="175">    
								<ul> 
									<li class="listItem">Shipment Types</li>
								</ul>
							</td>
							<td align="right">
								<a class="lnkButton" href="javascript:void(0)" onclick="location.href='add_shipment_type.php'"><img src="images/flat_icons/text70.png" class="imageButtonFlat" title="Add Shipment Type Record" /></a>
								<a class="lnkButton" href="javascript:void(0)" onclick="location.href='shipment_types_list.php'"><img src="images/flat_icons/open131.png" class="imageButtonFlat" title="Manage Shipment Type Records" /></a>
							</td>
						</tr>
					</table>
					<?php } ?>
					<?php if( $type_code == ADMIN ) { ?>
					<table class="tableItems">
						<tr>
							<td width="175">    
								<ul>
									<li class="listItem">Payment Modes</li>
								</ul>
							</td>
							<td align="right">
								<a class="lnkButton" href="javascript:void(0)" onclick="location.href='add_mode_payment.php'"><img src="images/flat_icons/text70.png" class="imageButtonFlat" title="Add Payment Mode Record" /></a>
								<a class="lnkButton" href="javascript:void(0)" onclick="location.href='payment_modes_list.php'"><img src="images/flat_icons/open131.png" class="imageButtonFlat" title="Manage Payment Mode Records" /></a>
							</td>
						</tr>
					</table>
					<table class="tableItems">
						<tr>
							<td width="175">    
								<ul>
									<li class="listItem">Movement Types</li>
								</ul>
							</td>
							<td align="right">
								<a class="lnkButton" href="javascript:void(0)" onclick="location.href='add_movement_type.php'"><img src="images/flat_icons/text70.png" class="imageButtonFlat" title="Add Movement Type Record" /></a>
								<a class="lnkButton" href="javascript:void(0)" onclick="location.href='movement_types_list.php'"><img src="images/flat_icons/open131.png" class="imageButtonFlat" title="Manage Movement Type Records" /></a>
							</td>
						</tr>
					</table>
					<table class="tableItems">
						<tr>
							<td width="175">    
								<ul> 
									<li class="listItem">Service Modes</li>
								</ul>
							</td>
							<td align="right">
								<a class="lnkButton" href="javascript:void(0)" onclick="location.href='add_service_mode.php'"><img src="images/flat_icons/text70.png" class="imageButtonFlat" title="Add Service Mode Record" /></a>
								<a class="lnkButton" href="javascript:void(0)" onclick="location.href='service_modes_list.php'"><img src="images/flat_icons/open131.png" class="imageButtonFlat" title="Manage Service Mode Records" /></a>
							</td>
						</tr>
					</table>
					<table class="tableItems">
						<tr>
							<td width="175">    
								<ul> 
									<li class="listItem">Weight Breaks</li>
								</ul>
							</td>
							<td align="right">
								<a class="lnkButton" href="javascript:void(0)" onclick="location.href='add_weight_category.php'"><img src="images/flat_icons/text70.png" class="imageButtonFlat" title="Add Weight Break Record" /></a>
								<a class="lnkButton" href="javascript:void(0)" onclick="location.href='weight_breaks_list.php'"><img src="images/flat_icons/open131.png" class="imageButtonFlat" title="Manage Weight Break Records" /></a>
							</td>
						</tr>
					</table>
					<table class="tableItems">
						<tr>
							<td width="175">    
								<ul> 
									<li class="listItem">Status</li>
								</ul>
							</td>
							<td align="right">
								<a class="lnkButton" href="javascript:void(0)" onclick="location.href='add_status_type.php'"><img src="images/flat_icons/text70.png" class="imageButtonFlat" title="Add Status Record" /></a>
								<a class="lnkButton" href="javascript:void(0)" onclick="location.href='status_types_list.php'"><img src="images/flat_icons/open131.png" class="imageButtonFlat" title="Manage Status Records" /></a>
							</td>
						</tr>
					</table>
					<table class="tableItems">
						<tr>
							<td width="175">    
								<ul>
									<li class="listItem">Stations</li>
								</ul>
							</td>
							<td align="right">
								<a class="lnkButton" href="javascript:void(0)" onclick="location.href='add_station.php'"><img src="images/flat_icons/text70.png" class="imageButtonFlat" title="Add Station Record" /></a>
								<a class="lnkButton" href="javascript:void(0)" onclick="location.href='stations_list.php'"><img src="images/flat_icons/open131.png" class="imageButtonFlat" title="Manage Station Records" /></a>
							</td>
						</tr>
					</table>
					<?php } ?>

					<?php if( $type_code == ADMIN || $type_code == STATION_ADMIN ) { ?>
					<table class="tableItems">
						<tr>
							<td width="175">    
								<ul>
									<li class="listItem">Satellite Offices</li>
								</ul>
							</td>
							<td align="right">
								<a class="lnkButton" href="javascript:void(0)" onclick="location.href='add_delivery_area.php'"><img src="images/flat_icons/text70.png" class="imageButtonFlat" title="Add Satellite Office Record" /></a>
								<a class="lnkButton" href="javascript:void(0)" onclick="location.href='delivery_area_list.php'"><img src="images/flat_icons/open131.png" class="imageButtonFlat" title="Manage Satellite Office Records" /></a>
							</td>
						</tr>
					</table>
					<?php } ?>

					<?php if( $type_code == ADMIN || $type_code == STATION_ADMIN ) { ?>
					<table class="tableItems">
						<tr>
							<td width="175">    
								<ul> 
									<li class="listItem">Cargo Vehicles</li>
								</ul>
							</td>
							<td align="right">
								<a class="lnkButton" href="javascript:void(0)" onclick="location.href='add_cargo_vehicle.php'"><img src="images/flat_icons/text70.png" class="imageButtonFlat" title="Add Cargo Vehicle" /></a>
								<a class="lnkButton" href="javascript:void(0)" onclick="location.href='cargo_vehicles_list.php'"><img src="images/flat_icons/open131.png" class="imageButtonFlat" title="Manage cargo vehicles" /></a>
							</td>
						</tr>
					</table>
					<?php } ?>
				</td>
			</tr>
		</table>
      </div>
      <div style="float: right; padding: 20px 65px;">
		<?php 	if( $type_code == MANAGER || $type_code == SO_AGENT ) { ?>
			<div>
				<table id="tblHawb" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
						<td align="center" valign="middle" class="utilities">
							<img src="images/verification5.png" class="flatIcon" />
							<span class="utilitiesLabel">HAWB</span>
						</td>
					</tr>
					<tr>
						<td class="boxLineNoPadding">
							<ul>
								<?php if( $type_code == SO_AGENT ) { ?>
								<li><a href="javascript:void(0)" onclick="location.href='newbook.php'" class="listLink">New HAWB</a></li>
								<?php } ?>
								<li><a href="javascript:void(0)" onclick="location.href='report_outgoing.php'" class="listLink">Outgoing Cargos</a></li>
								<li><a href="javascript:void(0)" onclick="location.href='report_incoming.php'" class="listLink">Incoming Cargos</a></li>
								<li><a href="javascript:void(0)" onclick="location.href='man_booking.php'" class="listLink">List of All HAWB</a></li>
								<li><a href="javascript:void(0)" onclick="location.href='report_agent_daily.php'" class="listLink">Agent Daily Sales Report</a></li>
								<li><a href="javascript:void(0)" onclick="location.href='report_agent_weekly.php'" class="listLink">Agent Weekly Sales Report</a></li>
								<li><a href="javascript:void(0)" onclick="location.href='report_agent_monthly.php'" class="listLink">Agent Monthly Sales Report</a></li>
								<?php if( $type_code == MANAGER ) { ?>
									<li><a href="javascript:void(0)" onclick="location.href='report_branch_weekly.php'" class="listLink">Branch Daily Sales Report</a></li>
									<li><a href="javascript:void(0)" onclick="location.href='report_branch_weekly.php'" class="listLink">Branch Weekly Sales Report</a></li>
									<li><a href="javascript:void(0)" onclick="location.href='report_branch_monthly.php'" class="listLink">Branch Monthly Sales Report</a></li>
									<li><a href="javascript:void(0)" onclick="location.href='pend.php'" class="listLink">Update HAWB</a></li>
									<li><a href="javascript:void(0)" onclick="location.href='deliveredhawb.php'" class="listLink">List of delivered</a></li>
									<li><a href="javascript:void(0)" onclick="location.href='search_booking.php'" class="listLink">Search &amp; Edit</a></li></li>
								<?php } ?>
							</ul>
						</td>
					</tr>
				</table>
			</div>
		<?php } ?>
		<?php 
				if( $type_code == ADMIN || $type_code == STATION_ADMIN ) {
		?>

			<style>
				.containerLabel { height: 32px; width: 230px; display: inline-block; }
				.containerControls { height: 32px; width: 70px; display: inline-block;  }
			</style>

			<div>
				<table id="tblUtiltiesSettings" border="0" align="center" cellpadding="0"  cellspacing="0">
					<tr>
						<td align="center" valign="middle" class="utilities">
							<img src="images/verification5.png" class="flatIcon" />
							<span class="utilitiesLabel">Manage Users</span>
						</td>
					</tr>
					<tr>
						<td class="boxLineVerticalPadding">
							<?php if( $type_code == SO_AGENT || $type_code == MANAGER ){ ?>
							<table class="tableItems">
								<tr>
									<td width="150"><ul style=""><li class="listItem">Customers</li></ul></td>
									<td align="right">
										<a class="lnkButton" href="javascript:void(0)" onclick="location.href='customer.php'"><img src="images/flat_icons/text70.png" class="imageButtonFlat" title="Add Customer Record" /></a>
										<?php if( $type_code == MANAGER ){ ?>
											<a class="lnkButton" href="javascript:void(0)" onclick="location.href='customer_list.php'"><img src="images/flat_icons/open131.png" class="imageButtonFlat" title="Manage Customer Records" /></a>
										<?php } ?>
									</td>
								</tr>
							</table>
							<?php } ?>
							<?php if( $type_code == ADMIN ) { ?>
							<table class="tableItems">
								<tr>
									<td width="175">    
										<ul>
											<li class="listItem">Station Administrators</li>
										</ul>
									</td>
									<td align="right">
										<a class="lnkButton" href="javascript:void(0)" onclick="location.href='add_station_administrator.php'"><img src="images/flat_icons/text70.png" class="imageButtonFlat" title="Add Station Administrator Record" /></a>
										<a class="lnkButton" href="javascript:void(0)" onclick="location.href='station_administrator_list.php'"><img src="images/flat_icons/open131.png" class="imageButtonFlat" title="Manage Station Administrator Records" /></a>
									</td>
								</tr>
							</table>
							<?php } ?>

							<?php if( $type_code == ADMIN || $type_code == STATION_ADMIN ) { ?>
							<table class="tableItems">
								<tr>
									<td width="175">    
										<ul>
											<li class="listItem">Station Managers</li>
										</ul>
									</td>
									<td align="right">
										<a class="lnkButton" href="javascript:void(0)" onclick="location.href='add_manager.php'"><img src="images/flat_icons/text70.png" class="imageButtonFlat" title="Add Manager Record" /></a>
										<a class="lnkButton" href="javascript:void(0)" onclick="location.href='manager_list.php'"><img src="images/flat_icons/open131.png" class="imageButtonFlat" title="Manage Manager Records" /></a>
									</td>
								</tr>
							</table>
							<table class="tableItems">
								<tr>
									<td width="175">    
										<ul>
											<li class="listItem">Station Sorters</li>
										</ul>
									</td>
									<td align="right">
										<a class="lnkButton" href="javascript:void(0)" onclick="location.href='add_sorter.php'"><img src="images/flat_icons/text70.png" class="imageButtonFlat" title="Add Sorter Record" /></a>
										<a class="lnkButton" href="javascript:void(0)" onclick="location.href='sorter_list.php'"><img src="images/flat_icons/open131.png" class="imageButtonFlat" title="Manage Sorter Records" /></a>
									</td>
								</tr>
							</table>
							<table class="tableItems">
								<tr>
									<td width="175">    
										<ul>
											<li class="listItem">Delivery Personnel</li>
										</ul>
									</td>
									<td align="right">
										<a class="lnkButton" href="javascript:void(0)" onclick="location.href='add_delivery_personnel.php'"><img src="images/flat_icons/text70.png" class="imageButtonFlat" title="Add Delivery Personnel Record" /></a>
										<a class="lnkButton" href="javascript:void(0)" onclick="location.href='delivery_personnels_list.php'"><img src="images/flat_icons/open131.png" class="imageButtonFlat" title="Manage Delivery Personnel Records" /></a>
									</td>
								</tr>
							</table>
							<table class="tableItems">
								<tr>
									<td width="175">    
										<ul>
											<li class="listItem">Excess Baggage</li>
										</ul>
									</td>
									<td align="right">
										<a class="lnkButton" href="javascript:void(0)" onclick="location.href='add_excess_baggage.php'"><img src="images/flat_icons/text70.png" class="imageButtonFlat" title="Add Excess Baggage Record" /></a>
										<a class="lnkButton" href="javascript:void(0)" onclick="location.href='excess_baggage_list.php'"><img src="images/flat_icons/open131.png" class="imageButtonFlat" title="Manage Excess Baggage Records" /></a>
									</td>
								</tr>
							</table>
							<table class="tableItems">
								<tr>
									<td width="175">    
										<ul>
											<li class="listItem">Satellite Office Agents</li>
										</ul>
									</td>
									<td align="right">
										<a class="lnkButton" href="javascript:void(0)" onclick="location.href='add_so_agent.php'"><img src="images/flat_icons/text70.png" class="imageButtonFlat" title="Add SO Agent Record" /></a>
										<a class="lnkButton" href="javascript:void(0)" onclick="location.href='so_agent_list.php'"><img src="images/flat_icons/open131.png" class="imageButtonFlat" title="Manage Satellite Office Agent Records" /></a>
									</td>
								</tr>
							</table>
							<?php } ?>

						</td>
					</tr>
				</table>
			</div>
		<?php
			}
		
			if( $type_code == ADMIN || $type_code == STATION_ADMIN ) {
		?>
			<div>
				<table id="tblReports" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
						<td align="center" valign="middle" class="utilities">
							<img src="images/verification5.png" class="flatIcon" />
							<span class="utilitiesLabel">Reports</span>
						</td>
					</tr>
					<tr>
						<td class="boxLineNoPadding">
							<ul>
								<li><a href="javascript:void(0)" onclick="location.href='report.php'" class="listLink">Booking Reports</a></li>
								<li><a href="javascript:void(0)" onclick="location.href='report_daily.php'" class="listLink">Daily Sales Report</a></li>
							</ul>
						</td>
					</tr>
				</table>
			</div>
		<?php
			} 
		?>
      </div>
      <div class="clear"></div>
    </div>

    <!-- Footer -->
    <div class="container clear footerContainer">
      <?php include('footer_flat.php') ?>
    </div>
  </center>
</body>
</html>