<?php
	include('constants.php');
	//echo "<span style='padding-left: 15px;'>Success - Login!</span><br />";  
	//echo "<span style='padding-left: 15px;'>Member: " . $_SESSION['type_code'] . "</span><br />";

	session_start();

	$login_name = "";
	$type_code = "";
	$stationId = "";
	if( isset($_SESSION['name']) )      $login_name = $_SESSION['name'];
	if( isset($_SESSION['type_code']) ) $type_code  = $_SESSION['type_code'];
	if( isset($_SESSION['stationId']) ) $stationId  = $_SESSION['stationId'];
?>
<table width="960" height="45" border="0" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" >
	<tr>
		<td height="0">
			<table width="960" border="0" cellpadding="0" cellspacing="0"> 
				<tr><!--background="images/adminheader.jpg"-->
					<td height="68" valign="top"  style="background-repeat:no-repeat;">
						<table width="961" border="0" align="right">
							<tr>
								<td class="subheadertxtblack">
									<table width="104%" height="25" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td width="4">&nbsp;</td>
											<td width="220" rowspan="2">
												<a href="javascript:void(0)" onclick="location.href='index.php'">
													<img src="images/logo.png" style="padding: 2px; margin-top: 10px; margin-left: 10px;" />
												</a>
											</td>
											<td align="right" valign="bottom" class="mediumwhiteboldlink" style="height: 70px;">
												<div style="margin-right: 50px;">
													<div style="display: inline-block; padding-left: 5px;">
														Your IP Address is 
														<?php echo "<span>" . $_SERVER['REMOTE_ADDR'] . "</span>";  ?>
													</div>
													<div style="display: inline-block; margin-left: 20px; padding-right: 5px;">
														Welcome <?php echo "<span>" . $login_name . "</span>"; ?>
													</div>
												</div>
											</td> 
										</tr>
										<tr>
											<td width="4">&nbsp;</td>
											<td valign="bottom">
												<div id="divNavigation">
													<ul id="menuCKNavigation" class="sf-menu" style="height: 23px;">
														<li class="current">
															<a href="javascript:void(0)" onclick="location.href='index.php'">Home</a>
														</li>
														<?php
															if( $type_code == ADMIN ) {
														?>
														<li>
															<a>Users</a>
															<ul>
																<li>
																	<a>Station Administators</a>
																	<ul>
																		<li><a href="javascript:void(0)" onclick="location.href='station.php'">New Station Admininstrator</a></li>
																		<li><a href="javascript:void(0)" onclick="location.href='station_rep.php'">Display Station Admininstrators</a></li>
																	</ul>
																</li>
																<li>
																	<a>Station Managers</a>
																	<ul>
																		<li><a href="javascript:void(0)" onclick="location.href='manager.php'">New Station Manager</a></li>
																		<li><a href="javascript:void(0)" onclick="location.href='manager_rep.php'">Display Station Managers</a></li>
																	</ul>
																</li>
																<li>
																	<a>Sorters</a>
																	<ul>
																		<li><a href="javascript:void(0)" onclick="location.href='sorters.php'">New Station Sorter</a></li>
																		<li><a href="javascript:void(0)" onclick="location.href='sorters_rep.php'">Display Station Sorters</a></li>
																	</ul>
																</li>
																<li>
																	<a>Excess Baggage</a>
																	<ul>
																		<li><a href="javascript:void(0)" onclick="location.href='excess_baggage.php'">New Station Excess Baggage</a></li>
																		<li><a href="javascript:void(0)" onclick="location.href='excess_baggage_rep.php'">Display Station Excess Baggages</a></li>
																	</ul>
																</li>
																<li>
																	<a>Satellite Office Agent</a>
																	<ul>
																		<li><a href="javascript:void(0)" onclick="location.href='so_agent.php'">New Satellite Office Agent</a></li>
																		<li><a href="javascript:void(0)" onclick="location.href='so_agent_rep.php'">Display Satellite Office Agents</a></li>
																	</ul>
																</li>
															</ul>
														</li>
														<li>
															<a>Locations</a>
															<ul>
																<li>
																	<a>Stations</a>
																	<ul>
																		<li><a href="javascript:void(0)" onclick="location.href='bookpl.php'">New Station</a></li>
																		<li><a href="javascript:void(0)" onclick="location.href='bookpl_rep.php'">Manage Stations</a></li>
																	</ul>
																</li>
																<li>
																	<a>Satellite Offices</a>
																	<ul>
																		<li><a href="javascript:void(0)" onclick="location.href='delivery_area.php'">New Satellite Office</a></li>
																		<li><a href="javascript:void(0)" onclick="location.href='deliveryarea_rep.php'">Manage Satellite Offices</a></li>
																	</ul>
																</li>
															</ul>
														</li>
														<li>
															<a>HAWB Settings</a>
															<ul>
																<li>
																	<a>Shipment Types</a>
																	<ul>
																		<li><a href="javascript:void(0)" onclick="location.href='cat1.php'">New shipment type</a></li>
																		<li><a href="javascript:void(0)" onclick="location.href='cat_rep1.php'">Manage shipment types</a></li>
																	</ul>
																</li>
																<li>
																	<a>Weight Breaks</a>
																	<ul>
																		<li><a href="javascript:void(0)" onclick="location.href='weight.php'">New weight break</a></li>
																		<li><a href="javascript:void(0)" onclick="location.href='weight_rep.php'">Manage weight breaks</a></li>
																	</ul>
																</li>
																<li>
																	<a>Movement Types</a>
																	<ul>
																		<li><a href="javascript:void(0)" onclick="location.href='move.php'">New movement type</a></li>
																		<li><a href="javascript:void(0)" onclick="location.href='move_rep.php'">Manage movement types</a></li>
																	</ul>
																</li>
																<li>
																	<a>Payment Modes</a>
																	<ul>
																		<li><a href="javascript:void(0)" onclick="location.href='mode.php'">New payment mode</a></li>
																		<li><a href="javascript:void(0)" onclick="location.href='mode_rep.php'">Manage paymet modes</a></li>
																	</ul>
																</li>
																<li>
																	<a>Service Modes</a>
																	<ul>
																		<li><a href="javascript:void(0)" onclick="location.href='sermode.php'">New service mode</a></li>
																		<li><a href="javascript:void(0)" onclick="location.href='sermode_rep.php'">Manage service modes</a></li>
																	</ul>
																</li>
															</ul>
														</li>														

														<?php 
															} else if( $type_code == STATION_ADMIN ) {
														?>
														<li>
															<a>Manage Users</a>
															<ul>
																<li>
																	<a>Manager</a>
																	<ul>
																		<li><a href="javascript:void(0)" onclick="location.href='manager.php'">New manager</a></li>
																		<li><a href="javascript:void(0)" onclick="location.href='manager_rep.php'">Manage managers</a></li>
																	</ul>
																</li>
																<li>
																	<a>Sorter</a>
																	<ul>
																		<li><a href="javascript:void(0)" onclick="location.href='sorters.php'">New station sorter</a></li>
																		<li><a href="javascript:void(0)" onclick="location.href='sorters_rep.php'">Manage stations sorters</a></li>
																	</ul>
																</li>
																<li>
																	<a>Excess Baggage</a>
																	<ul>
																		<li><a href="javascript:void(0)" onclick="location.href='excess_baggage.php'">New station excess Baggage staff</a></li>
																		<li><a href="javascript:void(0)" onclick="location.href='excess_baggage_rep.php'">Manage station excess baggage staffs</a></li>
																	</ul>
																</li>
																<li>
																	<a>Satellite Offices Agents</a>
																	<ul>
																		<li><a href="javascript:void(0)" onclick="location.href='so_agent.php'">New satellite offices agent</a></li>
																		<li><a href="javascript:void(0)" onclick="location.href='so_agent_rep.php'">Manage satellite offices agents</a></li>
																	</ul>
																</li>
															</ul>
														</li>
														<li>
															<a>Satellite Offices</a>
															<ul>
																<li><a href="javascript:void(0)" onclick="location.href='delivery_area.php'">New satellite office</a></li>
																<li><a href="javascript:void(0)" onclick="location.href='deliveryarea_rep.php'">Manage satellite offices</a></li>
															</ul>
														</li>
														<?php 
															} else if( $type_code == MANAGER ) {
														?>
															<li>
																<a>HAWB</a>
																<ul>
																	<!-- li><a href="javascript:void(0)" onclick="location.href='newbook.php'">New</a></li -->
																	<li><a href="javascript:void(0)" onclick="location.href='pend.php'">Pending transactions</a></li>
																	<li><a href="javascript:void(0)" onclick="location.href='man_booking.php'">View all transactions</a></li>
																</ul>
															</li>
															<li>
																<a>Customers</a>
																<ul>
																	<li><a href="javascript:void(0)" onclick="location.href='customer.php'">Add customer</a></li>
																	<li><a href="javascript:void(0)" onclick="location.href='customer_rep.php'">Manage station customers</a></li>
																</ul>
															</li>
															<li>
																<a>Agents</a>
																<ul>
																	<li><a href="javascript:void(0)" onclick="location.href='so_agent_rep.php'">Display satellite office agents</a></li>
																</ul>
															</li>
														<?php 
															} else if( $type_code == SO_AGENT ) {
														?>
															<li>
																<a>HAWB</a>
																<ul>
																	<li><a href="javascript:void(0)" onclick="location.href='newbook.php'">New</a></li>
																	<li><a href="javascript:void(0)" onclick="location.href='pend.php'">Pending</a></li>
																	<li><a href="javascript:void(0)" onclick="location.href='man_booking.php'">All</a></li>
																</ul>
															</li>
															<li>
																<a>Customers</a>
																<ul>
																	<li><a href="javascript:void(0)" onclick="location.href='customer_rep.php?station_only=true'">Station Customers</a></li>
																	<li><a href="javascript:void(0)" onclick="location.href='customer_rep.php'">Satellite Office Customers</a></li>
																</ul>
															</li>
														<?php
															}

															if( $type_code != STATION_ADMIN ) {
														?>
														<li>
															<a>Reports</a>
															<ul>
																<li>
																	<a>Branch (SO) Incoming/Outgoing</a>
																	<ul>
																		<li><a href="javascript:void(0)" onclick="location.href='report_outgoing.php'">Outgoing Cargos</a></li>
																		<li><a href="javascript:void(0)" onclick="location.href='report_incoming.php'">Incoming Cargos</a></li>
																	</ul>
																</li>
																<?php
																	if( $type_code == SO_AGENT || $type_code == MANAGER ) {
																?>
																<li>
																	<a>Agent Sales Report</a>
																	<ul>
																		<li><a href="javascript:void(0)" onclick="location.href='report_agent_daily.php'">Daily</a></li>
																		<li><a href="javascript:void(0)" onclick="location.href='report_agent_weekly.php'">Weekly</a></li>
																		<li><a href="javascript:void(0)" onclick="location.href='report_agent_monthly.php'">Monthly</a></li>
																	</ul>
																</li>
																<li>
																	<a>Branch (SO) Sales Report</a>
																	<ul>
																		<li><a href="javascript:void(0)" onclick="location.href='report_branch_daily.php'">Daily</a></li>
																		<li><a href="javascript:void(0)" onclick="location.href='report_branch_weekly.php'">Weekly</a></li>
																		<li><a href="javascript:void(0)" onclick="location.href='report_branch_monthly.php'">Monthly</a></li>
																	</ul>
																</li>
																<?php
																	}

																	if( $type_code == MANAGER ) {
																?>
																<li>
																	<a>Station (City) Sales Report</a>
																	<ul>
																		<li><a href="javascript:void(0)" onclick="location.href='report_station_daily.php'">Daily</a></li>
																		<li><a href="javascript:void(0)" onclick="location.href='report_station_weekly.php'">Weekly</a></li>
																		<li><a href="javascript:void(0)" onclick="location.href='report_station_monthly.php'">Monthly</a></li>
																	</ul>
																</li>
																<li>
																	<a>Monthly Comparator Reports</a>
																	<ul>
																		<li><a href="javascript:void(0)" onclick="location.href='report_station_branches_monthly_chart.php'">Branches Sales</a></li>
																		<li><a href="javascript:void(0)" onclick="location.href='report_branch_agents_monthly_sales_chart.php'">Agents Sales</a></li>
																		<li><a href="javascript:void(0)" onclick="location.href='report_branch_agents_monthly_txcounts_chart.php'">Agents Transaction Volume</a></li>
																	</ul>
																</li>
																<?php
																	}
																?>
																<li><a href="javascript:void(0)" onclick="location.href='allprintview.php'">Reports Preview</a></li>
															</ul>
														</li>
														<?php
															}
														?>
														<li><a href="javascript:void(0)" onclick="location.href='logout.php'">Logout</a></li>
													</ul>
												</div>
											</td>
										</tr>
									</table>
								</td>
								<td width="10">&nbsp;</td>
								<td width="12">&nbsp;</td>
							</tr>
						</table>
					<td width="934">&nbsp;</td>
					<td width="10">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<br />
