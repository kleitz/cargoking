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
		<title>Home</title>
		<link href="css/style.css" type="text/css"  rel="stylesheet"/>
		<link href="css/superfish.css" rel="stylesheet" media="screen">
		<link href="css/blitzer/jquery-ui-1.10.4.custom.css" rel="stylesheet">
		<style type="text/css">
			<!--
			.style6 {font-family: Arial, Helvetica, sans-serif; font-size: 16px; font-weight: bold; color: #000000; text-decoration:none; line-height:30px;}
			.style6 a {font-family: Arial, Helvetica, sans-serif; font-size: 16px; font-weight: bold; color: #000000; text-decoration:none; }
			.style3
			{
			color:#FF0000;
			}
			.searchToggleButton {
				display: inline-block;
				font-weight: bold;
				border: 2px solid rgb(178, 0, 0);
				padding: 2px 10px;
				color: rgb(178, 0, 0);
				margin-left: 70px;
				margin-top: 20px;
				box-shadow: 3px 3px 3px #888888;
				cursor: pointer;
			}
			.searchToggleButton:hover {
				border: 2px solid #D11919;
				color: #D11919;
			}
			-->
		</style>
		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/hoverIntent.js"></script>
		<script src="js/superfish.js"></script>
		<script src="js/jquery-ui-1.10.4.custom.min.js"></script>
		<script type="text/javascript">

			$(document).ready(function(){
				var sf = $('#menuCKNavigation').superfish();
				$( "#btnSearchHAWB, .actionButtons, a.lnkButton" ).button();
				//$(".searchHawbContainer").hide();

				$("#spanSearchToggleButton").bind("click", function(){
					$(".searchHawbContainer").toggle();
				});
				
			});

			function MM_openBrWindow(theURL, winName, features) { //v2.0
			  window.open(theURL, winName, features);
			}
		</script>
	</head>

	<body>
		<div align="center">
			<table width="100%" border="0" cellspacing="0" cellpadding="0"  align="center">
				<tr>
					<td>
						<table width="950" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
							<tr>
								<td>
									<?php 
										include('adminheader.php'); 
									?>
								</td>
							</tr>
							<tr>
								<td width="187"><?php if($_REQUEST['succ'] == 'yes'){ echo "<span class='style3'>Succesfully</span>" ; } ?></td>   
							</tr>
							<tr>
								<td>
									<br />
									<br />
									<table width="950" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="481" height="99" valign="top">
												<table width="340" border="0" align="center" cellpadding="0"  cellspacing="0">
													<tr>
														<td align="center" valign="middle" style="background-image:url(images/bgbox.jpg); background-repeat:repeat-x; height:25px; font-family: Verdana, Arial, Helvetica,  sans-serif; font-size:13px; font-weight:bold; color:#044d65;">
															<img src="images/members.gif" width="16" height="16" />
															&nbsp;&nbsp;&nbsp;
															<strong>Control Panel</strong>
														</td>
													</tr>
													<tr>
														<td style="background-image:url(images/boxline.jpg); background-repeat:repeat-y; padding: 10px 0px;">
															<?php if( $type_code == SO_AGENT || $type_code == MANAGER ){ ?>
															<table width="95%" style="border-spacing:0px; margin: 10px 0px;">
																<tr>
																	<td width="150"><ul style=""><li>Customer</li></ul></td>
																	<td align="right">
																		<a class="lnkButton" href="javascript:void(0)" onclick="location.href='customer.php'">Add</a>
																		<?php if( $type_code == MANAGER ){ ?>
																			<a class="lnkButton" href="javascript:void(0)" onclick="location.href='customer_rep.php'">Manage</a>
																		<?php } ?>
																	</td>
																</tr>
															</table>
															<?php } ?>

															<?php if( $type_code == ADMIN ) { ?>
															<table width="95%" style="border-spacing:0px;">
																<tr>
																	<td width="173">    
																		<ul> 
																			<li>Type of Shipment</li>
																		</ul>
																	</td>
																	<td align="right">
																		<a class="lnkButton" href="javascript:void(0)" onclick="location.href='cat1.php'">Add</a>
																		<a class="lnkButton" href="javascript:void(0)" onclick="location.href='cat_rep1.php'">Manage</a>
																	</td>
																</tr>
															</table>
															<?php } ?>
															<?php if( $type_code == ADMIN ) { ?>
															<table width="95%" style="border-spacing:0px;">
																<tr>
																	<td width="173">    
																		<ul>
																			<li>Mode Of Payment</li>
																		</ul>
																	</td>
																	<td align="right">
																		<a class="lnkButton" href="javascript:void(0)" onclick="location.href='mode.php'">Add</a>
																		<a class="lnkButton" href="javascript:void(0)" onclick="location.href='mode_rep.php'">Manage</a>
																	</td>
																</tr>
															</table>
															<table width="95%" style="border-spacing:0px;">
																<tr>
																	<td width="173">    
																		<ul>
																			<li>Type of Movement</li>
																		</ul>
																	</td>
																	<td align="right">
																		<a class="lnkButton" href="javascript:void(0)" onclick="location.href='move.php'">Add</a>
																		<a class="lnkButton" href="javascript:void(0)" onclick="location.href='move_rep.php'">Manage</a>
																	</td>
																</tr>
															</table>
															<table width="95%" style="border-spacing:0px;">
																<tr>
																	<td width="173">    
																		<ul> 
																			<li>Service Mode</li>
																		</ul>
																	</td>
																	<td align="right">
																		<a class="lnkButton" href="javascript:void(0)" onclick="location.href='sermode.php'"> Add</a>
																		<a class="lnkButton" href="javascript:void(0)" onclick="location.href='sermode_rep.php'">Manage</a>
																	</td>
																</tr>
															</table>
															<table width="95%" style="border-spacing:0px;">
																<tr>
																	<td width="173">    
																		<ul> 
																			<li>Weight Breaks</li>
																		</ul>
																	</td>
																	<td align="right">
																		<a class="lnkButton" href="javascript:void(0)" onclick="location.href='weight.php'">Add</a>
																		<a class="lnkButton" href="javascript:void(0)" onclick="location.href='weight_rep.php'">Manage</a>
																	</td>
																</tr>
															</table>
															<table width="95%" style="border-spacing:0px;">
																<tr>
																	<td width="171">    
																		<ul> 
																			<li>Status</li>
																		</ul>
																	</td>
																	<td align="right">
																		<a class="lnkButton" href="javascript:void(0)" onclick="location.href='status.php'">Add</a>
																		<a class="lnkButton" href="javascript:void(0)" onclick="location.href='status_rep.php'">Manage</a>
																	</td>
																</tr>
															</table>
															<table width="95%" style="border-spacing:0px;">
																<tr>
																	<td width="173">    
																		<ul>
																			<li>Stations</li>
																		</ul>
																	</td>
																	<td align="right">
																		<a class="lnkButton" href="javascript:void(0)" onclick="location.href='bookpl.php'">Add</a>
																		<a class="lnkButton" href="javascript:void(0)" onclick="location.href='bookpl_rep.php'">Manage</a>
																	</td>
																</tr>
															</table>
															<?php } ?>

															<?php if( $type_code == ADMIN || $type_code == STATION_ADMIN ) { ?>
															<table width="95%" style="border-spacing:0px;">
																<tr>
																	<td width="173">    
																		<ul>
																			<li>Satellite Offices</li>
																		</ul>
																	</td>
																	<td align="right">
																		<a class="lnkButton" href="javascript:void(0)" onclick="location.href='delivery_area.php'">Add</a>
																		<a class="lnkButton" href="javascript:void(0)" onclick="location.href='deliveryarea_rep.php'">Manage</a>
																	</td>
																</tr>
															</table>
															<?php } ?>

															<?php if( $type_code == ADMIN ) { ?>
															<table width="95%" style="border-spacing:0px;">
																<tr>
																	<td width="173">    
																		<ul>
																			<li>Station Admins</li>
																		</ul>
																	</td>
																	<td align="right">
																		<a class="lnkButton" href="javascript:void(0)" onclick="location.href='station.php'">Add</a>
																		<a class="lnkButton" href="javascript:void(0)" onclick="location.href='station_rep.php'">Manage</a>
																	</td>
																</tr>
															</table>
															<?php } ?>

															<?php if( $type_code == ADMIN || $type_code == STATION_ADMIN ) { ?>
															<table width="95%" style="border-spacing:0px;">
																<tr>
																	<td width="173">    
																		<ul>
																			<li>Managers</li>
																		</ul>
																	</td>
																	<td align="right">
																		<a class="lnkButton" href="javascript:void(0)" onclick="location.href='manager.php'">Add</a>
																		<a class="lnkButton" href="javascript:void(0)" onclick="location.href='manager_rep.php'">Manage</a>
																	</td>
																</tr>
															</table>
															<table width="95%" style="border-spacing:0px;">
																<tr>
																	<td width="173">    
																		<ul>
																			<li>Sorters</li>
																		</ul>
																	</td>
																	<td align="right">
																		<a class="lnkButton" href="javascript:void(0)" onclick="location.href='sorters.php'">Add</a>
																		<a class="lnkButton" href="javascript:void(0)" onclick="location.href='sorters_rep.php'">Manage</a>
																	</td>
																</tr>
															</table>
															<table width="95%" style="border-spacing:0px;">
																<tr>
																	<td width="173">    
																		<ul>
																			<li>Excess Baggage</li>
																		</ul>
																	</td>
																	<td align="right">
																		<a class="lnkButton" href="javascript:void(0)" onclick="location.href='excess_baggage.php'">Add</a>
																		<a class="lnkButton" href="javascript:void(0)" onclick="location.href='excess_baggage_rep.php'">Manage</a>
																	</td>
																</tr>
															</table>
															<table width="95%" style="border-spacing:0px;">
																<tr>
																	<td width="173">    
																		<ul>
																			<li>SO Agents</li>
																		</ul>
																	</td>
																	<td align="right">
																		<a class="lnkButton" href="javascript:void(0)" onclick="location.href='so_agent.php'">Add</a>
																		<a class="lnkButton" href="javascript:void(0)" onclick="location.href='so_agent_rep.php'">Manage</a>
																	</td>
																</tr>
															</table>
															<?php } ?>
															<?php if( $type_code == ADMIN || $type_code == STATION_ADMIN ) { ?>
															<table width="95%" style="border-spacing:0px;">
																<tr>
																	<td width="173">    
																		<ul> 
																			<li>Vehicle No</li>
																		</ul>
																	</td>
																	<td align="right">
																		<a class="lnkButton" href="javascript:void(0)" onclick="location.href='vec.php'">Add</a>
																		<a class="lnkButton" href="javascript:void(0)" onclick="location.href='vec_rep1.php'">Manage</a>
																	</td>
																</tr>
															</table>
															<?php } ?>
														</td>
													</tr>
													<tr>
														<td><img src="images/boxbottom.jpg" width="340" height="13" /></td>
													</tr>
												</table>
											</td>
											<td width="469" valign="top">
												<?php 	if( $type_code == MANAGER || $type_code == SO_AGENT ) { ?>
												<table width="340" border="0" align="center" cellpadding="0" cellspacing="0">
													<tr>
														<td align="center" valign="middle" style="background-image:url(images/bgbox.jpg); background-repeat:repeat-x; height:25px; font-family: Verdana, Arial, Helvetica, sans-serif; font-size:13px; font-weight:bold; color:#044d65;">
															<img src="images/amexcardc.gif" height="16" width="16" />&nbsp;&nbsp;&nbsp;HAWB
														</td>
													</tr>
													<tr>
														<td style="background-image:url(images/boxline.jpg); background-repeat:repeat-y;">
															<ul>
																<?php if( $type_code == SO_AGENT ) { ?>
																<li><a href="javascript:void(0)" onclick="location.href='newbook.php'" class="Lightblue">New HAWB</a></li>
																<?php } ?>
																<li class="Lightblue"><a href="javascript:void(0)" onclick="location.href='report_outgoing.php'" class="Lightblue">Outgoing Cargos</a></li>
																<li class="Lightblue"><a href="javascript:void(0)" onclick="location.href='report_incoming.php'" class="Lightblue">Incoming Cargos</a></li>
																<li class="Lightblue"><a href="javascript:void(0)" onclick="location.href='man_booking.php'" class="Lightblue">List of All HAWB</a></li>
																<li class="Lightblue"><a href="javascript:void(0)" onclick="location.href='report_agent_daily.php'" class="Lightblue">Agent Daily Sales Report</a></li>
																<li class="Lightblue"><a href="javascript:void(0)" onclick="location.href='report_agent_weekly.php'" class="Lightblue">Agent Weekly Sales Report</a></li>
																<li class="Lightblue"><a href="javascript:void(0)" onclick="location.href='report_agent_monthly.php'" class="Lightblue">Agent Monthly Sales Report</a></li>
																<?php if( $type_code == MANAGER ) { ?>
																	<li class="Lightblue"><a href="javascript:void(0)" onclick="location.href='report_branch_weekly.php'" class="Lightblue">Branch Daily Sales Report</a></li>
																	<li class="Lightblue"><a href="javascript:void(0)" onclick="location.href='report_branch_weekly.php'" class="Lightblue">Branch Weekly Sales Report</a></li>
																	<li class="Lightblue"><a href="javascript:void(0)" onclick="location.href='report_branch_monthly.php'" class="Lightblue">Branch Monthly Sales Report</a></li>
																	<li class="Lightblue"><a href="javascript:void(0)" onclick="location.href='pend.php'" class="Lightblue">Update HAWB</a></li>
																	<li class="Lightblue"><a href="javascript:void(0)" onclick="location.href='deliveredhawb.php'" class="Lightblue">List of delivered</a></li>
																	<li class="Lightblue"><a href="javascript:void(0)" onclick="location.href='search_booking.php'" class="Lightblue">Search &amp; Edit</a></li></li>
																<?php } ?>
															</ul>
														</td>
													</tr>
													<tr>
														<td><img src="images/boxbottom.jpg" width="340" height="13" /></td>
													</tr>
												</table>
												<?php } ?>
												<?php 	if( $type_code == ADMIN ) { ?>
												<table width="340" border="0" align="center" cellpadding="0" cellspacing="0">
													<tr>
														<td align="center" valign="middle" style="background-image:url(images/bgbox.jpg); background-repeat:repeat-x; height:25px; font-family: Verdana, Arial, Helvetica, sans-serif; font-size:13px; font-weight:bold; color:#044d65;">
															<img src="images/amexcardc.gif" height="16" width="16" style="margin-right: 10px;" />Administrator Settings
														</td>
													</tr>
													<tr>
														<td style="background-image:url(images/boxline.jpg); background-repeat:repeat-y;">
															<ul>
																<li><a href="javascript:void(0)" onclick="location.href='securepass.php'" class="Lightblue">Change Administrator Password</a></li>
															</ul>
														</td>
													</tr>
													<tr>
														<td><img src="images/boxbottom.jpg" width="340" height="13" /></td>
													</tr>
												</table>
												<?php 	} 

														if( $type_code == ADMIN || $type_code == STATION_ADMIN ) {
												?>
												<table width="340" border="0" align="center" cellpadding="0" cellspacing="0">
													<tr>
														<td align="center" valign="middle" style="background-image:url(images/bgbox.jpg); background-repeat:repeat-x; height:25px; font-family: Verdana, Arial, Helvetica, sans-serif; font-size:13px; font-weight:bold; color:#044d65;">
														<img src="images/amexcardc.gif" height="16" width="16" style="margin-right: 10px;" />Manage Users</td>
													</tr>
													<tr>
														<td style="background-image:url(images/boxline.jpg); background-repeat:repeat-y;">
															<ul>
																<li><a href="javascript:void(0)" onclick="location.href='station_rep.php'" class="Lightblue">Station Administrators</a></li>
																<li><a href="javascript:void(0)" onclick="location.href='manager_rep.php'" class="Lightblue">Station Managers</a></li>
																<li><a href="javascript:void(0)" onclick="location.href='sorters_rep.php'" class="Lightblue">Station Sorters</a></li>
																<li><a href="javascript:void(0)" onclick="location.href='excess_baggage_rep.php'" class="Lightblue">Excess Baggage</a></li>
																<li><a href="javascript:void(0)" onclick="location.href='so_agent_rep.php'" class="Lightblue">Satellite Office Agents</a></li>
															</ul>
														</td>
													</tr>
													<tr>
														<td><img src="images/boxbottom.jpg" width="340" height="13" /></td>
													</tr>
												</table>
												<?php
													}
												
													if( $type_code == ADMIN || $type_code == STATION_ADMIN ) {
												?>
												<table width="340" border="0" align="center" cellpadding="0" cellspacing="0">
													<tr>
														<td align="center" valign="middle" style="background-image:url(images/bgbox.jpg); background-repeat:repeat-x; height:25px; font-family: Verdana, Arial, Helvetica, sans-serif; font-size:13px; font-weight:bold; color:#044d65;">
														<img src="images/amexcardc.gif" height="16" width="16" style="margin-right: 10px;" />Reports</td>
													</tr>
													<tr>
														<td style="background-image:url(images/boxline.jpg); background-repeat:repeat-y;">
															<ul>
																<li><a href="javascript:void(0)" onclick="location.href='report.php'" class="Lightblue">Booking Reports</a></li>
																<li><a href="javascript:void(0)" onclick="location.href='report_daily.php'" class="Lightblue">Daily Sales Report</a></li>
															</ul>
														</td>
													</tr>
													<tr>
														<td><img src="images/boxbottom.jpg" width="340" height="13" /></td>
													</tr>
												</table>
												<?php
													} 
												?>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<?php if( $type_code == SO_AGENT ) { ?>
							
							<tr>
								<td>
									<span id="spanSearchToggleButton" class="searchToggleButton textShadow">Search HAWB</span><br>
									<div class="searchHawbContainer">
										<form id="formSearchHAWB" name="formSearchHAWB" action="" method="get">
											<table width="70%" align="center" cellpadding="4" cellspacing="0" border="0">
												<tr>
													<td colspan="2" valign="top" class="TrackTitle">
														<div align="center" class="style2" style="margin-bottom: 10px;"><strong>HAWB Search</strong></div>
													</td>
												</tr>
												<tr bgcolor="EFEFEF">
													<td colspan="2" valign="top" bgcolor="#FFFFFF">
														<span style="font-size: 10px; font-style: italic;">Key in the HAWB Number to MODIFY the data. This is helpful if you have made spelling errors while adding the HAWB.</span>
													</td>
												</tr>
												<tr>
													<td colspan="3" bgcolor="#EFEFEF">
														<div style="padding: 10px 30px;">
															<label for="txtManagerPhone" style="font-weight: bold; display: inline-block;">Enter HAWB number:</label>
															<input type="text" id="txtSearchHAWB" name="search" value="<?php echo $hawbCode; ?>" class="form-field" maxlength="50" style="display: inline-block; width: 200px;" />
															<input type="submit" id="btnSearchHAWB" name="submit" value="Seach HAWB" />
														</div>
													</td>
												</tr>
											</table>
										</form>
									</div>
								</td>
							</tr>
							<?php
									if($_GET['search']) {
							?>
							<tr>
								<td>
									<div class="searchHawbContainer">
										<table width="98%" border="0" align="center" cellpadding="3" cellspacing="3">
											<tr>
												<td width="54%"><span class="Closed"><strong><?php echo $totalCount; ?> </strong></span><strong>Results Found</strong>.</td>
												<td width="46%"><div align="right"><?php echo $links = $pager->get_links(); ?></div></td>
											</tr>
										</table>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="searchHawbContainer">
										<table width="98%" border="0"  cellspacing="0" cellpadding="5" align="center" id="tab_bg" style="border:1px solid #F0F0F0;">
											<tr id="head_bg" bgcolor="#F4F4F4">
												<td class="wht_txt" width="11%" height="25"><div style="padding-left: 10px;"><strong>Date</strong></div></td>
												<td class="wht_txt" width="15%"><div align="left"><strong>Origin</strong></div></td>
												<td class="wht_txt" width="21%"><div align="left"><strong>Receiver</strong></div></td>
												<td class="wht_txt" width="15%"><div align="left"><strong>Destination</strong></div></td>
												<td class="wht_txt" width="10%"><div align="left"><strong>Total</strong></div></td>
												<td class="wht_txt" width="28%"><div align="left"><strong>Action </strong></div></td>
											</tr>
											<?php
												if( $totalCount > 0 ){
													while($fet_2 = mysqli_fetch_array($result)) {
											?>
											<tr>
												<td width="11%" style="padding-left: 15px;"><?php echo $fet_2['formatted_date']; ?></td>
												<td width="15%"><?php echo $fet_2['origin']; ?></td>
												<td width="21%"><?php echo $fet_2['receiver_name']; ?></td>
												<td width="15%"><?php echo $fet_2['destination'];  ?></td>
												<td width="10%"><?php echo "<b>" . $fet_2['total_price'] . "</b>"; ?></td>
												<td width="28%">
													<a href="javascript:void(0);" class="actionButtons" onclick="location.href='booking_edit.php?ed=<?php echo  $fet_2['id']; ?>'" target="_blank">Edit </a>
													<a href="javascript:void(0);" class="actionButtons" onClick="MM_openBrWindow('view.php?ed=<?php echo  $fet_2['id']; ?> ','','scrollbars=yes,left=300,top=150,width=700,height=700')">View </a>
													<a href="javascript:void(0);" class="actionButtons" onClick="MM_openBrWindow('print_view.php?ed=<?php echo  $fet_2['id']; ?> ','','scrollbars=yes,left=300,top=150,width=700,height=700')">Print </a>
												</td>
											</tr> 
											<tr><td colspan="12" style="border-bottom:1px dashed #D7D7D7;"></td></tr>
											<?php
													}
												}
											?>
										</table>
									</div>
								</td>
							</tr>
							<?php
									}
							?>
							<?php
								}
							?>
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
