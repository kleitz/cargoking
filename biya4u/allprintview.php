<?php 
	include('protect.php');
	include 'dbconnect.php'; 
	include('paging.class.php');
	include('constants.php');

	//status 
	/* $status=$_REQUEST['status'];
	$row_id = mysqli_query($conn, "update testimonial set status = 'InActive' where id = '$status'  ") or die (mysqli_error());
	*/

	session_start();

	$login_id  = "";	
	$type_code = "";
	$stationId = "";
	if( isset($_SESSION['login_id']) )  $login_id  = $_SESSION['login_id'];
	if( isset($_SESSION['type_code']) ) $type_code  = $_SESSION['type_code'];
	if( isset($_SESSION['stationId']) ) $stationId  = $_SESSION['stationId'];
	
	/*
	echo "[login_id]: " . $login_id  . "<br>";
	echo "[type_code]: " . $type_code . "<br>";
	echo "[stationId]: " . $stationId . "<br>";
	*/

	$SQLResult = "";
	$strFilters = "";
	$SQLBookingResult = "";
	$strBookingFullTextSearchFilter = "";
	$SQLBooking = " SELECT * FROM vw_booking_details WHERE hawb_status_id <> 3 ";
	$strOrderBy = " ORDER BY hawb_date desc ";

	$sqlTotalCount = " select count(id) as row_count from vw_booking_details WHERE hawb_status_id <> 3";
	if($type_code == ADMIN) {
		$SQLResult = $SQLBooking;
	}	
	else if($type_code == STATION_ADMIN || $type_code == MANAGER) {
		$SQLResult = $SQLBooking . " and  origin_id = " . $stationId ;
		$sqlTotalCount .= " and  origin_id = " . $stationId;
	}
	else if($type_code == SO_AGENT) {
		$SQLResult = $SQLBooking . " and  agent_id = " . $login_id;
		$sqlTotalCount .= " and  agent_id = " . $login_id;
	}

	if(isset($_GET['submit'])) {
		if ( isset($_GET['searchKey']) ) {
			$strBookingFullTextSearchFilter = " and concat(id, lower(booking_code), lower(origin), lower(destination), lower(receiver_name), receiver_phone, lower(receiver_address), lower(customer_code), lower(sender_name), sender_phone, lower(sender_city)) like '%" . strtolower($_GET['searchKey']) . "%'";		
			$sqlTotalCount .= $strBookingFullTextSearchFilter;
		}
	}
	$sqlTotalCount .= " limit 1";
	//echo "[SQL]: " . $sqlTotalCount . "<br>";

	$total_results = (mysqli_query($conn,  $sqlTotalCount )); 
	$row = mysqli_fetch_assoc($total_results);
	$totalCount = $row['row_count'];

	$pager = new pager($_GET['p'], 15, $totalCount, 4);
	$offset = $pager->get_start_offset();
	$limit = 15;
	$strOffsetLimit = " LIMIT " . $offset . ", $limit";

	//echo "[SQL]: " . $SQLResult . $strBookingFullTextSearchFilter . "<br>";

	$totalCount = mysqli_num_rows(mysqli_query($conn, $SQLResult. $strBookingFullTextSearchFilter));
	$result = mysqli_query($conn, $SQLResult . $strBookingFullTextSearchFilter . $strOrderBy . $strOffsetLimit);

	/*
	if(isset($_GET['submit'])) {
		$searchKey = "";
		$strBookingFullTextSearchFilter = "";
		$hasSearchKeyFilter = false;

		if ( isset($_GET['searchKey']) ) {
			$searchKey = $_GET['searchKey'];
			$strBookingFullTextSearchFilter = " concat(id, lower(booking_code), lower(origin), lower(destination), lower(receiver_name), receiver_phone, lower(receiver_address), lower(customer_code), lower(sender_name), sender_phone, lower(sender_city)) like '%" . strtolower($searchKey) . "%'";		
			$hasSearchKeyFilter = true;
		}

		$strFilters = " AND ";
		if( $hasSearchKeyFilter ) {
			$strFilters .= $strBookingFullTextSearchFilter;
		}

		$SQLCount = $SQLResult . $strFilters;
		$SQLBookingResult = $SQLCount . $strOrderBy . $strOffsetLimit;
		
		//echo "[SQL]: " . $SQLBookingResult . "<br>";
		
		$totalCount       = mysqli_num_rows( mysqli_query($conn, $SQLCount) );
		$result           = mysqli_query($conn, $SQLBookingResult);
	}
	*/

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link href="css/style.css" type="text/css"  rel="stylesheet"/>
		<link href="css/superfish.css" rel="stylesheet" media="screen">
		<link href="css/blitzer/jquery-ui-1.10.4.custom.css" rel="stylesheet">
		<title>HAWB List Print View</title>
		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/hoverIntent.js"></script>
		<script src="js/superfish.js"></script>
		<script src="js/jquery-ui-1.10.4.custom.min.js"></script>
		<script src="js/jquery.validate.min.js"></script>
		<script src="js/jquery.ui.datepicker.validation.min.js"></script>
		<script type="text/JavaScript">
			$(document).ready(function(){
				var sf = $('#menuCKNavigation').superfish();
				$("#tblHawbList tr:even").css("background-color", "#FFE6E6");  /* #EBEBE0 */
				$(".actionButtons, #btnSubmitSearchByKey").button();

				$("#formReportPreviewSearch").validate({
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
								<td>
									<?php include('adminheader.php') ?>
								</td>
							</tr>
							<tr>
								<td>
									<div id="errorContainer">
										<ul />
									</div>
								</td>
							</tr>
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td>
									<table width="928" align="center">
										<tr>
											<td colspan="2" align="right">
												<div align="center" class="textShadow" style="font-size: 14px; font-weight: bold;">Bookings Report Preview</div>
											</td>
										</tr>
										<tr><td colspan="2">&nbsp;</td></tr>
										<tr><td>&nbsp;</td></tr>
										<tr>
											<td colspan="2" align="right">
												<form id="formReportPreviewSearch" name="formReportPreviewSearch" method="get">
													<div align="right" style="width: 100%; display: inline-block;">
														<label for="txtSearchKey" style="font-weight: bold;">Search by Key:</label>
														<input type="text" id="txtSearchKey" name="searchKey" value="<?php echo $_GET['searchKey']; ?>" placeholder="Keyword (ie. Sender, Receiver, Origin, Destination, etc.)" clas="form-field" style="width: 400px; font-size: 14px; padding: 5px 10px; display: inline-block;" />
														<input type="submit" id="btnSubmitSearchByKey" name="submit" value="Search" />
													</div>
												</form>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td>
									<table width="98%" border="0" align="center" cellpadding="3" cellspacing="3">
										<tr>
											<td width="54%">
												<span class="Closed">
													<strong><?php echo $totalCount; ?> </strong>
												</span>
												<strong>Results Found</strong>.
											</td>
											<td width="46%">
												<div align="right">
													<?php echo $links = $pager->get_links(); ?>
												</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td id="min1">
									<table id="tblHawbList" width="98%" border="0"  cellspacing="0" cellpadding="5" align="center" style="border:1px solid #181818; margin-bottom: 5px; box-shadow: 3px 3px 3px #888888;">
										<tr  id="head_bg"  bgcolor="#F4F4F4">
											<td width="11%" height="25" class="displayAllTableHeader"><div align="left"><strong>Date</strong></div></td>
											<td class="displayAllTableHeader" width="9%"><div align="left"><strong>HAWB No</strong></div></td>
											<td class="displayAllTableHeader" width="9%"><div align="left"><strong>Origin</strong></div></td>
											<td class="displayAllTableHeader" width="10%"><div align="left"><strong>Receiver</strong></div></td>
											<td class="displayAllTableHeader" width="10%"><div align="left"><strong>Destination</strong></div></td>
											<td class="displayAllTableHeader" width="8%"><div align="left"><strong>Quantity</strong></div></td>
											<td class="displayAllTableHeader" width="14%"><div align="left"><strong>Mode of Payment</strong></div></td>
											<td class="displayAllTableHeader" width="11%"><div align="left"><strong>Total Amount</strong></div></td>
											<td class="displayAllTableHeader" width="9%"><div align="left"><strong>Posted By</strong></div></td>
											<td class="displayAllTableHeader" width="9%"><div align="center"><strong>Action </strong></div></td>
										</tr>
										<?php
											if( $totalCount > 0) {
												while($fet_2=mysqli_fetch_array($result)) {
												//	include('results.php');
										?>
										<tr>
											<td width="11%"><?php echo $fet_2['formatted_date']; ?></td>
											<td width="9%"><?php  echo $fet_2['booking_code']; ?></td>
											<td width="9%"><?php echo $fet_2['origin']; ?></td>
											<td width="10%"><?php echo $fet_2['receiver_name']; ?></td>
											<td width="10%"><?php echo $fet_2['destination']; ?></td>
											<td width="8%"><?php echo $fet_2['no_of_items']; ?></td>
											<td width="14%"><?php echo $fet_2['payment_mode']; ?></td>
											<td width="11%"><?php echo "<b>" . number_format((float) $fet_2['total_price'], 2, '.', ',') . "</b>"; ?></td>
											<td><?php echo $fet_2['agent_name']; ?></td>
											<td width="9%">
												<a href="javascript:void(0);" class="actionButtons" onClick="MM_openBrWindow('print_view.php?ed=<?php echo  $fet_2['id']; ?> ','','scrollbars=yes,left=150,top=150,width=870,height=930')">Print</a>
												&nbsp;&nbsp;
											</td>
										</tr>
										<?php 
												}
											}
											else {
										?>
											<tr><td colspan="10" align="center"><span class="dataNotFound">Data not found.</span></td></tr>
										<?php
											}
										?>
									</table>
									<br />
									<br />
								</td>
							</tr>
							<tr><td>&nbsp;</td></tr>							
							<tr>
								<td><?php include('adminfooter.php'); ?></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>
