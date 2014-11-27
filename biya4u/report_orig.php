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
	if( isset($stationId) ) $strStationFilter = "origin = $stationId";

	$SQLBooking = "SELECT * FROM booking";
	$strOrderBy = " ORDER BY id desc ";

	$SQLBookingResult = "";

	/* Get Results count */
	$SQLCount         = $SQLBooking . ( $stationId > 0 ? " WHERE " . $strStationFilter : "");
	$totalCount       = mysqli_num_rows( mysqli_query($conn, $SQLCount) );	

	/* Get Booking Results */
	$SQLBookingResult = $SQLCount . $strOrderBy . $strOffsetLimit;
	$result           = mysqli_query($conn,  $SQLBookingResult);

	if(isset($_GET['submit'])) {
		if( isset($_GET['from']) ) $f=$_GET['from'];
		if( isset($_GET['to']) ) $t=$_GET['to'];

		$dFrom = new DateTime($f);
		$from  = $dFrom->format('Y-m-d');

		$dTo   = new DateTime($t);
		$to    = $dTo->format('Y-m-d');

		$strDateRangeFilter = " date between '" . $from . "' AND '" . $to . "'";

		/* Get Results count */
		$SQLCount         = $SQLBooking . " WHERE " . $strDateRangeFilter . ( $stationId > 0 ? " AND " . $strStationFilter : "");
		$totalCount       = mysqli_num_rows( mysqli_query($conn, $SQLCount) );	

		/* Get Booking Results */
		$SQLBookingResult = $SQLCount . $strOrderBy . $strOffsetLimit;
		$result           = mysqli_query($conn, $SQLBookingResult);		
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link href="css/style.css" type="text/css"  rel="stylesheet"/>
		<link href="css/superfish.css" rel="stylesheet" media="screen">
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
		<script type="text/javascript" src="js/jquery.validate.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				var example = $('#menuCKNavigation').superfish();
				$("#f1").validate({
					rules: {
						from: {
							required:true
						},
						to: {
							required:true
						}
					},
					messages: {
						from: {
							required:"Required"
						},
						to: {
							required:"Required"
						}
					}
				});
			});

			function MM_openBrWindow(theURL,winName,features) { //v2.0
			  window.open(theURL,winName,features);
			}
		</script>
	</head>

	<body>
		<div align="center">
		<?php 
			if($_SESSION['member']!="Manager") {
				include("adminheader.php");
			}
			else {
		?>
			<table cellpadding="0" cellspacing="0" border="0" width="960" bgcolor="#FFFFFF">
				<tr>
					<td style="padding:5px;" width="50%" rowspan="2"><img src="images/logo.png" border="0" /></td>
					<td class="mediumwhiteboldlink" valign="top" style="padding:5px;">
						Your IP Address is <?php echo $_SERVER['REMOTE_ADDR'];  ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Welcome <?php echo $_SESSION['adminusername']; ?>
					</td>
				</tr>
				<tr>
					<td align="right" style="padding-right:15px;"><img src="images/arrow.png" width="5" height="8" /><strong><a href="logout.php" class="subheadertxtblack">&nbsp;Logout</a></strong></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
			</table>
		<?php 
			}
		?>
			<table cellpadding="0" cellspacing="0" border="0" width="960" bgcolor="#FFFFFF">
				<tr>
					<td colspan="2" align="center">
						<strong>Report for 
						<?php
							$query = getAssociativeArrayFromSQL($conn, "select * from bplace where id='$city'");
							echo $query['category'];
						?>
						</strong>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<form name="f1" id="f1" method="get">
							<label for="from">From</label>
							<input type="text" id="from" name="from" onClick="ds_sh(this);"/>
							<label for="to">to</label>
							<input type="text" id="to" name="to" onClick="ds_sh(this);"/>
							<input type="submit" name="submit" id="submit" value="Submit" />
						</form>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
					<?php 
						if($totalCount==0)
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
				<?php 
					if($login == "admin") {
				?>
				<tr>
					<td colspan="2">
						<table width="98%" border="0" align="center" cellpadding="3" cellspacing="3">
							<tr>
								<td width="54%" align="right"><span class="Closed"><strong><a href="xl.php?from=<?php echo $from; ?>&to=<?php echo $to; ?>">Export in Excel</a></strong></span></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
            <?php 
					}
					else {
			?>
				<tr>
					<td colspan="2">
						<table width="98%" border="0" align="center" cellpadding="3" cellspacing="3">
							<tr>
								<td width="54%" align="right"><span class="Closed"><strong><a href="xl.php?from=<?php echo $from; ?>&to=<?php echo $to; ?>&city=<?php echo $city;?>">Export in Excel</a></strong></span></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
            <?php } ?>
				<tr>
					<td colspan="2">
						<table width="98%" border="0"  cellspacing="0" cellpadding="5" align="center" id="tab_bg" style="border:1px solid #F0F0F0;">
							<tr  id="head_bg"  bgcolor="#F4F4F4">
								<td width="11%" height="25" class="wht_txt"><div align="left"><strong>Date</strong></div></td>
								<td class="wht_txt" width="8%"><div align="left"><strong>HAWB No</strong></div></td>
								<td class="wht_txt" width="12%"><div align="left"><strong>Shipper Name</strong></div></td>
								<td class="wht_txt" width="6%"><div align="left"><strong>Origin</strong></div></td>
								<td class="wht_txt" width="9%"><div align="left"><strong>Destination</strong></div></td>
								<td class="wht_txt" width="8%"><div align="left"><strong>Weight</strong></div></td>
								<td class="wht_txt" width="7%"><div align="left"><strong>Quantity</strong></div></td>
								<td class="wht_txt" width="12%"><div align="left"><strong>Mode of Payment</strong></div></td>
								<td class="wht_txt" width="8%"><div align="left"><strong>Grand Total</strong></div></td>
								<td class="wht_txt" width="9%"><div align="left"><strong>Commission</strong></div></td>
								<td class="wht_txt" width="10%"><div align="left"><strong>Due To Cargo King</strong></div></td>
							</tr>
							<?php 
								while($fet_2=mysqli_fetch_array($result)) {
								//	include('results.php');
							?>
							<tr>
								<td width="11%">
								<?php
									$dat=explode("-" ,$fet_2['date']); 
									echo $dat[2]."-".$dat[1]."-".$dat[0];
								?>
								</td>
								<td width="8%"><?php echo $fet_2['bookno']; ?></td>
								<td width="12%"><?php echo $fet_2['sendername']; ?></td>
								<td width="6%"><?php generateDropdownObject($conn, "bplace", $fet_2['origin']); ?></td>
								<td width="9%"><?php generateDropdownObject($conn, "bplace", $fet_2['destination']); ?></td>
								<td width="8%">
								<?php
									$bido = $fet_2['bookno']; 
									$bi_query = mysqli_query($conn, "select * from arr where bookid ='$bido' and weight='0'");
									$bi_row = mysqli_fetch_assoc($bi_query);
									$tot_wei = $bi_row['total_weight'];

									echo $bi_row['total_weight'];
								?>
								</td>
								<td width="7%">
								<?php 
									$quantity = 0;
									$qun = mysqli_query($conn, "select qun from arr where bookid ='$bido'");
									while( $rs = mysqli_fetch_array($qun) )
										$quantity = $quantity + $rs['qun'];
									echo $quantity;
								?>
								</td>
								<td width="12%"><?php generateDropdownObject($conn, "mop", $fet_2['modpay']); ?></td>
								<td width="8%">
								<?php
									if($tot_wei<50) {
										$cargo  = getAssociativeArrayFromSQL($conn, "select * from weight where weightvalue='$tot_wei' and delarea='".$fet_2['deliveryarea']."'");
										$rate   = $cargo['rate'];
										$comm   = $cargo['commission'];
										$duecar = $cargo['duecar'];
									}
									else {
										if($tot_wei>49 && $tot_wei<1001) {
												$query  = mysqli_query($conn, "select * from weight where weightvalue='50-1000' and delarea='".$fet_2['deliveryarea']."'");
												$cargo  = mysqli_fetch_array($query);
												$rate   = $cargo['rate'] * $tot_wei;
												$comm   = $rate * 0.25;
												$duecar = $rate - $comm;
										}
										else {
												$query  = mysqli_query($conn, "select * from weight where weightvalue='1001--' and delarea='".$fet_2['deliveryarea']."'");
												$cargo  = mysqli_fetch_array($query);
												$rate   = $cargo['rate'] * $tot_wei;
												$comm   = $rate * 0.25;
												$duecar = $rate - $comm;
										}
									}

									echo $rate;
								?>
								</td>
								<td width="9%"><?php echo $comm; ?></td>
								<td width="10%"><?php echo $duecar; ?></td>
							</tr> 
							<tr><td colspan="14" style="border-bottom:1px dashed #D7D7D7;"></td></tr>
							<?php 
								}
							?>
						</table>
					</td>
				</tr>
            <?php } ?>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2"><?php include('adminfooter.php'); ?></td>
				</tr>
			</table>
		</div>
	</body>
</html>
