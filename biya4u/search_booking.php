<?php 
	include('protect.php');
	include 'dbconnect.php'; 
	include('paging.class.php');

	$hawbCode = html_entity_decode($_GET['search']);
	$mug = " where bookno='$hawbCode'";

	if(isset($_REQUEST['del_id'])) {
		$del_id_net = $_REQUEST['del_id' ];
		$del = mysqli_query($conn, "DELETE FROM booking WHERE id='$del_id_net' ") or die (mysqli_error());
		echo "<script type=\"text/javascript\">";
		echo "	self.location='deliveryarea_rep.php?action=delete&success=true';";
		echo "</script>";
	}

	$total_results = (mysqli_query($conn,  "SELECT COUNT(*) as Num FROM booking" . $mug )); 		
	$row = mysqli_fetch_assoc($total_results);
	$totalCount = $row['Num'];	

	$pager = new pager($_GET['p'], 15, $totalCount, 4);
	$offset = $pager->get_start_offset();
	$limit = 15;

	// Perform MySQL query on only the current page number's results 
	$SQLQuery = "SELECT * FROM vw_booking_totals" . $mug . "  ORDER BY id desc LIMIT " . $offset . ", $limit ";
	
	//echo "[SQL]: " . $SQLQuery . "<br>";
	
	$result = mysqli_query($conn, $SQLQuery);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link href="css/style.css" type="text/css"  rel="stylesheet"/>
		<link href="css/superfish.css" rel="stylesheet" media="screen">
		<link href="css/blitzer/jquery-ui-1.10.4.custom.css" rel="stylesheet">
		<title>Admin</title>
		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/jquery-ui-1.10.4.custom.min.js"></script>
		<script src="js/hoverIntent.js"></script>
		<script src="js/superfish.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				var sf = $('#menuCKNavigation').superfish();
				$("#btnSearchHAWB, .actionButtons").button();
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
								<td colspan="2">
									<form action="" method="get" name="form1" id="form1" onsubmit="return validate()">
										<table width="70%" align="center" cellpadding="4" cellspacing="0" border="0">
											<tr><td colspan="2">&nbsp;</td></tr>
											<tr>
												<td colspan="2" valign="top" class="TrackTitle">
													<div align="center" class="style2"><strong>HAWB Search</strong></div>
												</td>
											</tr>
											<tr><td colspan="2">&nbsp;</td></tr>
											<tr bgcolor="EFEFEF">
												<td colspan="2" valign="top" bgcolor="#FFFFFF">
													<span style="font-size: 10px; font-style: italic;">Key in the HAWB Number to MODIFY the data. This is helpful if you have made spelling errors while adding the HAWB.</span>
												</td>
											</tr>
											<tr>
												<td colspan="3" bgcolor="EFEFEF">
													<div style="padding: 10px 30px;">
														<label for="txtManagerPhone" style="font-weight: bold; display: inline-block;">Enter HAWB number:</label>
														<input type="text" id="txtSearchHAWB" name="search" value="<?php echo $hawbCode; ?>" class="form-field" maxlength="50" style="display: inline-block;" />
														<input type="submit" id="btnSearchHAWB" name="submit" value="Seach HAWB" />
													</div>
												</td>
											</tr>
										</table>
									</form>
								</td>
							</tr>
							<tr><td height="30">&nbsp;</td></tr>
							<tr>
								<td>
								<?php
									if($_GET['search']) {
								?>
									<table width="98%" border="0" align="center" cellpadding="3" cellspacing="3">
										<tr>
											<td width="54%"><span class="Closed"><strong><?php echo $totalCount; ?> </strong></span><strong>Results Found</strong>.</td>
											<td width="46%"><div align="right"><?php echo $links = $pager->get_links(); ?></div></td>
										</tr>
									</table>
								<?php
									}
								?>
								</td>
							</tr>
							<tr>
								<td id="min1">
								<?php
									if($_GET['search']) {
								?>
									<table width="98%" border="0"  cellspacing="0" cellpadding="5" align="center" id="tab_bg" style="border:1px solid #F0F0F0;">
										<tr id="head_bg" bgcolor="#F4F4F4">
											<td class="wht_txt" width="11%" height="25"><div style="padding-left: 10px;"><strong>Date</strong></div></td>
											<td class="wht_txt" width="11%"><div align="left"><strong>HAWB No</strong></div></td>
											<td class="wht_txt" width="15%"><div align="left"><strong>Origin</strong></div></td>
											<td class="wht_txt" width="15%"><div align="left"><strong>Receiver</strong></div></td>
											<td class="wht_txt" width="15%"><div align="left"><strong>Destination</strong></div></td>
											<td class="wht_txt" width="10%"><div align="left"><strong>Total</strong></div></td>
											<td class="wht_txt" width="23%"><div align="left"><strong>Action </strong></div></td>
										</tr>
										<?php 
											while($fet_2=mysqli_fetch_array($result)) {
												$jump = $fet_2['bookno'];
												$jump_query = mysqli_query($conn,  "select * from  invoice_arr where bookid='" . $fet_2['bookno'] . "'" );

												if( mysqli_num_rows($jump_query) < 1) {
										?>
										<tr>
											<td width="11%" style="padding-left: 15px;">
											<?php 
												$dat = explode("-" ,$fet_2['date']); 
												echo $dat[2] . "-" . $dat[1] . "-" . $dat[0];
											?>
											</td>
											<td width="11%"><?php echo $fet_2['bookno']; ?></td>
											<td width="15%"><?php echo $fet_2['origin']; ?></td>
											<td width="15%"><?php echo $fet_2['receiver']; ?></td>
											<td width="15%"><?php echo $fet_2['destination'];  ?></td>
											<td width="10%"><?php echo "<b>" . $fet_2['total_amount'] . "</b>"; ?></td>
											<td width="23%">
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
								<?php
									}
								?>
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
