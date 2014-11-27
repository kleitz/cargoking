<?php 
	include('protect.php');
	include 'dbconnect.php'; 
	include('paging.class.php');

	$id = $_GET['ed'];

	$result = mysqli_query($conn, "SELECT * FROM vw_booking_details where id = '$id'"); 
  
	function salt($table, $id) {
		$query = mysqli_query($conn, "select * from  ".$table." where id='$id'");
		while($row=mysqli_fetch_assoc($query)) {
			echo $row['category'];
		}
	}

  
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<title>Admin</title>
		<link href="css/style.css" rel="stylesheet" type="text/css">
		<link href="css/blitzer/jquery-ui-1.10.4.custom.css" rel="stylesheet">
		<style type="text/css">
			.style1 {color: #FF0000}
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
			.totalLabelHeader { border-top:1px solid #A0A0A4; border-bottom:1px solid #A0A0A4; font-weight: bold; padding-left: 25px; }
			.fieldLabel { font-weight: bold; }
			<!--
			body {
				margin-left: 0px;
				margin-top: 0px;
				margin-right: 0px;
				margin-bottom: 0px;
			}
			-->
		</style>
		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/jquery-ui-1.10.4.custom.min.js"></script>
		<script src="js/updateStatusJSScripts.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#btnUpdateHawb").button();
			});
		</script>
	</head>
	<body>
		<?php
			while( $fet_2 = mysqli_fetch_array($result) ) {
		?>
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
			<?php
				if( !isset($_GET['popup']) ) {
			?>
			<tr>
				<td width="780"><?php include('adminheader.php'); ?></td>
			</tr>
			<?php
				}
			?>
			<tr>
				<td bgcolor="#FFFFFF">
					<table class="ds_box" cellpadding="0" cellspacing="0" id="ds_conclass" style="display: none;"> 
						<tr> 
							<td id="ds_calclass">&nbsp;</td> 
						</tr> 
					</table> 
					<table width="98%"  border="0" align="center">
						<tr>
							<td align="center"><p align="center" class="textShadow" style="font-size: 14px; font-weight: bold;">Update HAWB</p></td>
						</tr>
					</table>
					<table bgcolor="#FFFFFF" border="0" width="" style="border:1px #A4A4A4 dotted;" align="center">
						<tr>
							<td height="35" bgcolor="#EBEBEB">
								<div>
									<span style="width:300px; font-size:18px; font-weight: bold; padding-left: 10px;"><?php echo $fet_2['booking_code']; ?></span>
									<span style="margin:0 0 0 380px; font-weight: bold;"><?php echo $fet_2['formatted_date']; ?></span>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<table border="0" width="100%">
								<tbody>
									<tr>
										<td>
											<div align="left" style="text-align:justify; line-height:30px;">
												<table width="550" cellspacing="0">
													<tr>
														<td width="107">Origin</td>
														<td width="16" align="center"><strong>:</strong></td>
														<td width="409"><?php echo $fet_2['origin']; ?></td>
													</tr>
													<tr>
														<td width="107">Destination</td>
														<td width="16" align="center"><strong>:</strong></td>
														<td width="409"><?php echo $fet_2['destination']; ?></td>
													</tr>
													<tr>
														<td width="107">Receiver Name</td>
														<td width="16" align="center"><strong>:</strong></td>
														<td width="409"><?php echo $fet_2['receiver_name']; ?></td>
													</tr>
													<tr>
														<td width="107">Address</td>
														<td width="16" align="center" valign="middle"><strong>:</strong></td>
														<td width="409"><?php echo $fet_2['receiver_address']; ?></td>
													</tr>
													<tr>
														<td width="107">Phone</td>
														<td width="16" align="center"><strong>:</strong></td>
														<td width="409"><?php echo $fet_2['receiver_phone']; ?></td>
													</tr>
													<tr>
														<td width="107">Sender Name</td>
														<td width="16" align="center"><strong>:</strong></td>
														<td width="409"><?php echo $fet_2['sender_name']; ?></td>
													</tr>
													<tr>
														<td width="107">Address</td>
														<td width="16" align="center"><strong>:</strong></td>
														<td width="409"><?php echo $fet_2['sender_address']; ?></td>
													</tr>
													<tr>
														<td width="107">Phone</td>
														<td width="16" align="center"><strong>:</strong></td>
														<td width="409"><?php echo $fet_2['sender_phone']; ?></td>
													</tr>
													<tr>
														<td width="107">Payment Mode</td>
														<td width="16" align="center"><strong>:</strong></td>
														<td width="409"><?php echo $fet_2['payment_mode']; ?></td>
													</tr>
													<tr>
														<td width="107">Movement</td>
														<td width="16" align="center"><strong>:</strong></td>
														<td width="409"><?php echo $fet_2['movement_type']; ?></td>
													</tr>
													<tr>
														<td width="107">Service Mode</td>
														<td width="16" align="center"><strong>:</strong></td>
														<td width="409"><?php echo $fet_2['service_mode']; ?></td>
													</tr>
												</table>
												<table cellspacing="0" cellpadding="0" style="width: 100%; border: 1px solid #A0A0A4;">
													<tr>
														<td width="123" align="center" class="cargoHeaderBorderBottom"><strong>Cargo Description</strong></td>
														<td width="87" align="center" class="cargoHeaderBorderBottom"><strong>Quantity</strong></td>
														<td width="116" align="center" class="cargoHeaderBorderBottom"><strong>Measurement</strong></td>
														<td width="129" align="center" class="cargoHeaderBorderBottom"><strong>Weight</strong></td>
														<td width="129" align="center" class="cargoHeaderBorderBottom"><strong>Declared Value</strong></td>
													</tr>
													<?php
														$rsHawbItems = mysqli_query($conn, "select * from  vw_hawb_items where booking_id = " . $fet_2['id']);
														$recordCount = mysqli_num_rows($rsHawbItems);

														if( 0 < $recordCount ){
															while( $row = mysqli_fetch_assoc($rsHawbItems) ) {
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
														else {
															echo "<tr><td colspan=\"5\" align=\"center\"><span class=\"dataNotFound\">Data not found.</span></td></tr>";
														}
													?>
													<tr>
														<td colspan="2" class="totalLabelHeader"><span style="margin-right: 20px;">Total Weight:</span><?php echo number_format((float) $fet_2['total_weight'], 2, '.', ','); ?></td>
														<td colspan="3" class="totalLabelHeader"><span style="margin-right: 20px;">Total Charges:</span><?php echo number_format((float) $fet_2['discounted_price'], 2, '.', ','); ?></td>
													</tr>
												</table>
											</div>
										</td>
									</tr>
									<tr>
										<td>
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
										<td align="right" bgcolor="#FFFFFF"><div align="center"><span class="Partext1"><?php echo $row["status_date"];?></span></div></td>
										<td align="right" bgcolor="#FFFFFF"><div align="center"><span class="Partext1"><?php echo $row["status_time"];?></span></div></td>
										<td bgcolor="#FFFFFF"><div align="center"><span class="Partext1"><?php echo $row["location_id"];?></span></div></td>
										<td bgcolor="#FFFFFF"><div align="center"><span class="Partext1"><?php echo $row["status_id"];?></span></div></td>
										<td bgcolor="#FFFFFF"><div align="center"><span class="Partext1"><?php echo $row["comments"];?></span></div></td>
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
						</tr>
						<tr><td>&nbsp;</td></tr>
						<tr>
							<td>
								<form id="frmShipment" name="frmShipment" action="update_confirm.php?popup=true" method="post"> 
								<table width="550" align="center" cellpadding="2" cellspacing="2" bgcolor="#EEEEEE">
									<tr>
										<td colspan="3" align="center" style="background-color: #B20000; color: #fff; font-weight: bold; border-bottom:1px solid #A0A0A4; padding: 7px 15px;">UPDATE STATUS</td>
									</tr>
									<tr>
										<td colspan="3" align="right" bgcolor="#FFFFFF"></td>
									</tr>
									<tr>
										<td width="150" align="right" bgcolor="#FFFFFF" class="Partext1"><b>New Location:</b></td>
										<td width="400" colspan="2" bgcolor="#FFFFFF" class="Partext1">
											<input name="Loc" type="text" id="Loc" size="60" maxlength="50" value="<?php echo $_POST['Loc']; ?>">
										</td>
									</tr>
									<tr>
										<td width="150" align="right" bgcolor="#FFFFFF" class="Partext1"><b>New Status:</b></td>
										<td width="150" width="26%" bgcolor="#FFFFFF" class="Partext1">
											<select name="status">
											<?php
												$sta = mysqli_query($conn, "select * from status");
													while($rs=mysqli_fetch_array($sta))
														echo ("<option value='".$rs['category']."'>".$rs['category']."</option>");
											?>
											</select>
										</td>
										<td width="250" bgcolor="#FFFFFF" class="Partext1">
											<div align="center">
												<a href="markdelivered.php?id=<?php echo $strid;?>">Marked this HAWB as to be <span class="style1"><b>DELIVERED</b></span></a>
												<span class="style1"></span>
											</div>
										</td>
									</tr>
									<tr>
										<td width="150" align="right" bgcolor="#FFFFFF"><span class="Partext1"><b>Comments:</b></span></td>
										<td width="400" colspan="2" bgcolor="#FFFFFF" class="Partext1"><textarea name="comments" cols="40" rows="3" id="comments"><?php echo $_POST['comments']; ?></textarea></td>
									</tr> 
									<tr>
										<td width="150" align="right" bgcolor="#FFFFFF">&nbsp;</td>
										<td width="400" colspan="2" bgcolor="#FFFFFF" class="Partext1">
											<input type="submit" id="btnUpdateHawb" name="submit" value="Update HAWB Status" style="margin-top: 20px; margin-right: 10px;" />
											<input name="mode" type="hidden" id="mode" value="edit">
											<input name="txthwid" type="hidden" id="txthwid" value="<?php echo $strid;?>">
										</td>
									</tr>
									<tr>
										<td colspan="3" align="right" bgcolor="#FFFFFF">
											<div align="center"></div>
										</td>
									</tr>
								</table>
								</form>
							</td>
						</tr>
						<tr><td>&nbsp;</td></tr>
					</tbody>
					</table> 
				</td>
			</tr>
			<tr>
				<td><?php include('adminfooter.php'); ?></td>
			</tr>
		</table>
		<?php
			}
		?>
	</body>
</html>