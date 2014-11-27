<?php

	include('protect.php');
	include 'dbconnect.php'; 
	include('paging.class.php');

	$booking_id = "";
	$STATUS_DELIVERED = 3;
	
	if( isset($_GET['ed']) ) $booking_id = $_GET['ed'];

	$result = mysqli_query($conn, "SELECT * FROM vw_booking_details where id = '$booking_id'"); 
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link href="css/style.css" type="text/css" rel="stylesheet"/>
		<link href="css/blitzer/jquery-ui-1.10.4.custom.css" rel="stylesheet">
		<style>
			.linkButton {
				text-decoration: none; font: menu;
				display: inline-block; padding: 5px 15px;
				/*
				background: ButtonFace; color: ButtonText;
				border-style: solid; border-width: 2px;
				border-color: ButtonHighlight ButtonShadow ButtonShadow ButtonHighlight;
				*/
				border: 2px solid #3D3D29;
				color: black;
			}
			.linkButton:active, .linkButton:visited, .linkButton:hover, .linkButton:link {
				display: inline-block; padding: 5px 15px;
				/* 
				border-color: ButtonShadow ButtonHighlight ButtonHighlight ButtonShadow;
				border-style: solid; border-width: 2px;
				*/
				border: 2px solid #3D3D29;
				color: black;
			}
			.fieldLabel { font-weight: bold; }
			.totalLabelHeader { border-top:1px solid #A0A0A4; font-weight: bold; padding-left: 25px; }
		</style>
		<title>View Booking Details</title>
		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/jquery-ui-1.10.4.custom.min.js"></script>
		<script type="text/JavaScript">
			$(document).ready(function(){
				$("#linkUpdateStatus").button();
				$("#tblManagerList tr:even").css("background-color", "#FFE6E6");  /* #EBEBE0 */
			});

			function MM_openBrWindow(theURL, winName, features) {
				window.open(theURL, winName, features);
			}
		</script>
	</head>
	<body style="background:#FFF;">
		<div align="center" style="background:#FFF;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0"  align="">
				<tr>
					<td>
						<table border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF" >
							<tr>
								<td>
									<table width="100%" border="0" cellspacing="3" cellpadding="3" class="sub_cont">
										<tr>
											<td align="center">
											<?php 
												while($fet_2 = mysqli_fetch_array($result)) {
											?>
												<!--<b style="color: #FF8040;"> &#2953;&nbsp;</b>
												<h2 style="color:#008040;"><strong>&#2980;&#2969;&#3021;&#2965;&#2965;&#2985;&#3007; &#2975;&#3021;&#2992;&#3006;&#2985;&#3021;&#3000;&#3021; &#2986;&#3019;&#2992;&#3021;&#2975;&#3021;</strong>&nbsp; </h2>
												<h3 style="color: #9F3400;">9-10,No.21,கீழவெளி வீதி ,நெல்பேட்டை ,மதுரை -1</h3>-->
												<p>&nbsp;</p>
												<table bgcolor="#FFFFFF" border="0" width="" style="border:1px #A4A4A4 dotted;">
													<tbody>
														<tr>
															<td height="35" bgcolor="#EBEBEB">
																<div>
																	<b style="width: 300px; font-size: 18px; font-weight: bold; padding-left: 10px;">
																		&nbsp;&nbsp;<?php echo $fet_2['booking_code']; ?>
																	</b>
																	<b style="margin:0 0 0 380px;"><?php echo $fet_2['formatted_date']; ?></b>
																</div>
															</td>
														</tr>
														<tr>
															<td>
																<table border="0" style="width: 100%;">
																<tbody>
																	<tr>
																		<td width="">
																			<div align="left" style="text-align:justify; line-height:30px;">
																				<table width="550" cellspacing="0">
																					<tr>
																						<td width="107" class="fieldLabel" valign="top">Origin</td>
																						<td width="16" class="fieldLabel" align="center" valign="top"><strong>:</strong></td>
																						<td width="409" valign="top" style="padding-left: 20px;"><?php echo $fet_2['origin']; ?></td>
																					</tr>
																					<tr>
																						<td width="107" class="fieldLabel" valign="top">Destination</td>
																						<td width="16" class="fieldLabel" align="center" valign="top"><strong>:</strong></td>
																						<td width="409" valign="top" style="padding-left: 20px;"><?php echo $fet_2['destination']; ?></td>
																					</tr>
																					<tr>
																						<td class="fieldLabel" valign="top">Receiver Name</td>
																						<td class="fieldLabel" align="center" valign="top"><strong>:</strong></td>
																						<td valign="top" style="padding-left: 20px;"><?php  echo $fet_2['receiver_name']; ?></td>
																					</tr>
																					<tr>
																						<td class="fieldLabel" valign="top">Address</td>
																						<td class="fieldLabel" align="center" valign="top"><strong>:</strong></td>
																						<td valign="top" style="padding-left: 20px;"><?php  echo $fet_2['receiver_address']; ?></td>
																					</tr>
																					<tr>
																						<td class="fieldLabel" valign="top">Phone</td>
																						<td class="fieldLabel" align="center" valign="top"><strong>:</strong></td>
																						<td valign="top" style="padding-left: 20px;"><?php  echo $fet_2['receiver_phone']; ?></td>
																					</tr>
																					<tr>
																						<td class="fieldLabel" valign="top">Sender Name</td>
																						<td class="fieldLabel" align="center" valign="top"><strong>:</strong></td>
																						<td valign="top" style="padding-left: 20px;"><?php  echo $fet_2['sender_name']; ?></td>
																					</tr>
																					<tr>
																						<td class="fieldLabel" valign="top">Address</td>
																						<td class="fieldLabel" align="center" valign="top"><strong>:</strong></td>
																						<td valign="top" style="padding-left: 20px;"><?php  echo $fet_2['sender_address']; ?></td>
																					</tr>
																					<tr>
																						<td class="fieldLabel" valign="top">Phone</td>
																						<td class="fieldLabel" align="center" valign="top"><strong>:</strong></td>
																						<td valign="top" style="padding-left: 20px;"><?php  echo $fet_2['sender_phone']; ?></td>
																					</tr>
																					<tr>
																						<td class="fieldLabel" valign="top">Payment Mode</td>
																						<td class="fieldLabel" align="center" valign="top"><strong>:</strong></td>
																						<td valign="top" style="padding-left: 20px;"><?php echo $fet_2['payment_mode']; ?></td>
																					</tr>
																					<tr>
																						<td class="fieldLabel" valign="top">Movement Type</td>
																						<td class="fieldLabel" align="center" valign="top"><strong>:</strong></td>
																						<td valign="top" style="padding-left: 20px;"><?php echo $fet_2['movement_type']; ?></td>
																					</tr>
																					<tr>
																						<td class="fieldLabel" valign="top">Service Mode</td>
																						<td class="fieldLabel" align="center" valign="top"><strong>:</strong></td>
																						<td valign="top" style="padding-left: 20px;"><?php echo $fet_2['service_mode']; ?></td>
																					</tr>
																					<tr><td colspan="3">&nbsp;</td></tr>
																				</table>
																				<table cellspacing="0" cellpadding="0" style="width: 100%; border: 1px solid #A0A0A4;">
																					<tr>
																						<td width="150" align="center" class="cargoHeaderBorderBottom">Cargo Description</td>
																						<td width="90" align="center" class="cargoHeaderBorderBottom">Quantity</td>
																						<td width="130" align="center" class="cargoHeaderBorderBottom">Measurement</td>
																						<td width="130" align="center" class="cargoHeaderBorderBottom">Weight</td>
																						<td width="130" align="center" class="cargoHeaderBorderBottom">Declared Value</td>
																					</tr>
																					<?php
																						$rsHawbItems = mysqli_query($conn, "select * from vw_hawb_items where booking_id = '" . $fet_2['id'] . "'");
																						$recordCount = mysqli_num_rows($rsHawbItems);
																						
																						if( 0 < $recordCount ){
																							while( $row = mysqli_fetch_assoc($rsHawbItems) ) { 
																								if($row['preferred_weight'] != "0") {
																					?>
																					<tr>
																						<td width="123" align="center" bgcolor="#EBEBEB"><?php echo $row['shipment_type']; ?></td>
																						<td width="87" align="center" bgcolor="#EBEBEB"><?php echo number_format($row['quantity'], 0, '.', ','); ?></td>
																						<td width="116" align="center" bgcolor="#EBEBEB"><?php echo number_format((float) $row['dimension_total'], 2, '.', ','); ?></td>
																						<td width="129" align="center" bgcolor="#EBEBEB"><?php echo number_format((float) $row['preferred_weight'], 2, '.', ','); ?></td>
																						<td width="129" align="center" bgcolor="#EBEBEB"><?php echo number_format((float) $row['declared_value'], 2, '.', ','); ?>&nbsp;</td>
																					</tr>
																					<?php
																								}
																							}
																						}
																						else {
																							echo "<tr><td colspan=\"5\" align=\"center\"><span class=\"dataNotFound\">Data not found.</span></td></tr>";
																						} 
																					?>
																					<tr>
																						<td colspan="2" class="totalLabelHeader"><span style="margin-right: 20px;">Total Weight:</span><?php echo number_format((float) $fet_2['total_weight'], 2, '.', ','); ?></td>
																						<td colspan="3" class="totalLabelHeader"><span style="margin-right: 20px;">Total Charges:</span><?php echo number_format((float) $fet_2['discounted_price'], 2, '.', ','); ?></td>
																					</tr>
																				</table>
																				<table width="552">
																					<tr>
																						<td width="107" class="fieldLabel">Remarks</td>
																						<td width="16" class="fieldLabel" align="center"><strong>:</strong></td>
																						<td width="409" style="padding-left: 20px;"><i><?php echo $fet_2['remarks']; ?></i></td>
																					</tr>
																					<tr>
																						<td colspan="3">&nbsp;</td>
																					</tr>
																				</table>
																			</div>
																		</td>
																	</tr>
																</tbody>
																</table>
															</td>
														</tr>
														<tr>
															<td>
																<table align="center" cellpadding="0" cellspacing="0" style="width: 100%; border: 1px solid #A0A0A4;">
																	<tr>
																		<td width="13%" align="right" style="background-color: #B20000; color: #fff; font-weight: bold; border-bottom:1px solid #A0A0A4; padding: 7px 15px;">Date</td>
																		<td width="14%" align="right" style="background-color: #B20000; color: #fff; font-weight: bold; border-bottom:1px solid #A0A0A4; padding: 7px 15px;">Time</td>
																		<td width="22%" style="background-color: #B20000; color: #fff; font-weight: bold; border-bottom:1px solid #A0A0A4; padding: 7px 15px;">Location</td>
																		<td width="17%" style="background-color: #B20000; color: #fff; font-weight: bold; border-bottom:1px solid #A0A0A4; padding: 7px 15px;">Status</td>
																		<td width="24%" style="background-color: #B20000; color: #fff; font-weight: bold; border-bottom:1px solid #A0A0A4; padding: 7px 15px;">Comments</td>
																	</tr>
																	<?php
																		$strid = $fet_2['booking_code'];
																		$result1 = mysqli_query($conn, "SELECT * FROM booking_status WHERE hawb_code = '$strid'");
																		$rCount = mysqli_num_rows($result1);
																		if( 0 < $rCount ) {
																			while($row = mysqli_fetch_array($result1)) { 
																	?>
																	<tr>
																		<td align="right" bgcolor="#FFFFFF"><div align="center"><span class="Partext1"><? echo $row["status_date"];?></span></div></td>
																		<td align="right" bgcolor="#FFFFFF"><div align="center"><span class="Partext1"><? echo $row["status_time"];?></span></div></td>
																		<td bgcolor="#FFFFFF"><div align="center"><span class="Partext1"><? echo $row["location_id"];?></span></div></td>
																		<td bgcolor="#FFFFFF"><div align="center"><span class="Partext1"><? echo $row["status_id"];?></span></div></td>
																		<td bgcolor="#FFFFFF"><div align="center"><span class="Partext1"><? echo $row["comments"];?></span></div></td>
																	</tr>
																	<?php
																			}
																		}
																		else {
																			echo "<tr><td colspan=\"5\" align=\"center\" style=\"padding: 7px 15px;\"><span class=\"dataNotFound\">Data not found.</span></td></tr>";
																		}
																	?>
																</table>
															</td>
															<tr><td>&nbsp;</td></tr>
														</tr>
														<tr>
															<td align="right">
															<?php 	if( $fet_2['hawb_status'] == $STATUS_DELIVERED ) { ?>
																	<button id="btnPrintPreview" onclick="MM_openBrWindow('print_view.php?ed=<?php echo $booking_id; ?>','','scrollbars=yes, left=150, top=150, width=870, height=930')" style="margin-right: 16px;">Print HAWB</button>
															<?php 
																	} else {
															?>
																	<div style="inline-block; padding-right: 16px;">
																		<a id="linkUpdateStatus" href="javascript:void(0)" onclick="location.href='update_status.php?ed=<?php echo  $booking_id; ?>&popup=true'">Update HAWB</a>
																	</div>
															<?php
																	}
															?>
															</td>
														</tr>
														<tr><td>&nbsp;</td></tr>
													</tbody>
												</table>
												<br />
											<?php } ?>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>