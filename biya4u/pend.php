<?php 
	include('protect.php');
	include 'dbconnect.php'; 
	include('paging.class.php');
	include('constants.php');
	//include('utilities.php');

	session_start();
		
	$login = $_SESSION['adminusername'];

	$login_id = "";
	$type_code = "";
	$stationId = "";
	$STATUS_DELIVERED = 3;
	$strBookingFullTextSearchFilter = "";

	if( isset($_SESSION['login_id']) ) $login_id = $_SESSION['login_id'];
	if( isset($_SESSION['type_code']) ) $type_code = $_SESSION['type_code'];
	if( isset($_SESSION['stationId']) ) $stationId = $_SESSION['stationId'];

	if($_GET['searchKey']) {
		$searchKey = html_entity_decode($_GET['searchKey']);
		$strBookingFullTextSearchFilter = " and concat(id, lower(booking_code), lower(origin), lower(destination), lower(receiver_name), receiver_phone, lower(receiver_address), lower(customer_code), lower(sender_name), sender_phone, lower(sender_city)) like '%" . strtolower($searchKey) . "%'";		
	}

	if(isset($_REQUEST['del_id'])) {
		$del_id_net = $_REQUEST['del_id' ];
		$del = mysqli_query($conn, "DELETE FROM booking WHERE id = '$del_id_net' ") or die (mysqli_error());
		echo "<script type=\"text/javascript\">";
		echo "	alert('One Record Deleted Successfully');";
		echo "	self.location='pend.php';";
		echo "</script>";
	}

	$SQLPending = " SELECT * FROM vw_booking_details  where hawb_status <> " . $STATUS_DELIVERED; //STATUS:3 = DELIVERED
	$SQLQty = $SQLPending;

	if($type_code == ADMIN) {
		$SQLQty .= $strBookingFullTextSearchFilter;
	}
	else if($type_code == STATION_ADMIN || $type_code == MANAGER) {
		$SQLQty .= " and origin_id = " . $stationId . $strBookingFullTextSearchFilter;
	}
	else {
		$SQLQty .= " and agent_id = '$login_id' ".$strBookingFullTextSearchFilter;
	}

	$resultQty = mysqli_query($conn, $SQLQty);
	$totalCount = mysqli_num_rows($resultQty);
	
	$pager = new pager($_GET['p'], 15, $totalCount, 4);
	$offset = $pager->get_start_offset();
	$limit = 15;

	// Perform MySQL query on only the current page number's results 
	if($type_code == ADMIN) {
		$SQLPending .= $strBookingFullTextSearchFilter . " ORDER BY id desc LIMIT " . $offset . ", $limit ";
	}
	else if($type_code == STATION_ADMIN || $type_code == MANAGER) {
		$SQLPending .= " and origin_id = " . $stationId . $strBookingFullTextSearchFilter . " ORDER BY id desc LIMIT " . $offset . ", $limit ";
	}
	else{
		$SQLPending .= " and agent_id = '$login_id' " . $strBookingFullTextSearchFilter . " ORDER BY id desc LIMIT " . $offset . ", $limit ";
	}

	$result = mysqli_query($conn, $SQLPending);

	//echo "[SQL]: " . $SQLPending . "<br>";
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
		<script src="js/hoverIntent.js"></script>
		<script src="js/superfish.js"></script>
		<script src="js/jquery-ui-1.10.4.custom.min.js"></script>
		<script src="js/jquery.validate.min.js"></script>
		<script src="js/jquery.ui.datepicker.validation.min.js"></script>
		<script type="text/JavaScript">
			$(document).ready(function(){
				var sf = $('#menuCKNavigation').superfish();
				$("#tblHawbList tr:even").css("background-color", "#FFE6E6");  /* #EBEBE0 */
				$(".actionButtons, #btnSearchKeyword, #btnResetSearch").button();
			});

			function MM_openBrWindow(theURL,winName,features) { //v2.0
			  window.open(theURL,winName,features);
			}

			function deleteBooking(bookingId) {
				var confirmDelete = false;
				if( confirmDelete = confirm("Are you sure you want to delete pending booking?") ){
					location.href = "pend.php?del_id=" + bookingId;
				}
				return confirmDelete;
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
								<td colspan="2"><?php include('adminheader.php') ?></td>
							</tr>
							<tr>
								<td colspan="2">
									<table width="928" align="center">
										<tr><td colspan="2">&nbsp;</td></tr>
										<tr>
											<td colspan="2" align="right">
												<div align="center" class="textShadow" style="font-size: 14px; font-weight: bold;">Pending  Booking Details</div>
											</td>
										</tr>
										<tr><td colspan="2">&nbsp;</td></tr>
										<tr><td colspan="2">&nbsp;</td></tr>
										<tr>
											<td colspan="2" align="right">
												<form action="" method="get" id="sub">
													<label for="txtSearchKey" style="font-weight: bold;">Search by Key:</label>
													<input type="text" id="txtSearchKey" name="searchKey" value="<?php echo $_GET['searchKey']; ?>" placeholder="Keyword (ie. Sender, Receiver, Origin, Destination, etc.)" clas="form-field" style="width: 400px; font-size: 14px; padding: 5px 10px; display: inline-block;" />
													<input id="btnSearchKeyword" type="submit" name="submit" value="Go"/>
													<input id="btnResetSearch" type="reset" name="rest" onClick="self.location='pend.php';"/>
												</form>
											</td>
										</tr>
										<tr><td colspan="2">&nbsp;</td></tr>
									</table>
								</td>
							</tr>
							<tr>
								<td>
									<table width="98%" border="0" align="center" cellpadding="3" cellspacing="3">
										<tr>
											<td width="54%"><span class="Closed"><strong><?php echo $totalCount; ?> </strong></span><strong>Results Found</strong>.</td>
											<td width="46%"><div align="right"><?php echo $links = $pager->get_links(); ?></div></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="187"><?php if($_REQUEST['succ']=='yes'){echo "<span class='style3'>Succesfully</span>" ;} ?></td>
							</tr>
							<tr>
								<td id="min1">
									<table id="tblHawbList" width="98%" border="0"  cellspacing="0" cellpadding="5" align="center" style="border:1px solid #181818; margin-bottom: 5px; box-shadow: 3px 3px 3px #888888;">
										<tr id="head_bg" bgcolor="#F4F4F4">
											<td width="10%" height="25" class="displayAllTableHeader"><div align="left"><strong>Date</strong></div></td>
											<td class="displayAllTableHeader" width="7%"><div align="left"><strong>HAWB No</strong></div></td>
											<td class="displayAllTableHeader" width="6%"><div align="left"><strong>Origin</strong></div></td>
											<td class="displayAllTableHeader" width="8%"><div align="left"><strong>Receiver</strong></div></td>
											<td class="displayAllTableHeader" width="10%"><div align="left"><strong>Destination</strong></div></td>
											<td class="displayAllTableHeader" width="7%"><div align="left"><strong>Quantity</strong></div></td>
											<td class="displayAllTableHeader" width="9%"><div align="left"><strong>Mode of Payment</strong></div></td>
											<td class="displayAllTableHeader" width="8%"><div align="left"><strong>Total Amount</strong></div></td>
											<td class="displayAllTableHeader" width="7%"><div align="left"><strong>Posted By</strong></div></td>
											<td class="displayAllTableHeader" width="28%"><div align="center"><strong>Action </strong></div></td>
										</tr>
										<?php
											if( $totalCount > 0) {
												while($fet_2=mysqli_fetch_array($result)) {
										?>	
										<tr>
											<td width="10%"><?php echo $fet_2["formatted_date"]; ?></td>
											<td width="7%"><?php  echo $fet_2['booking_code']; ?></td>
											<td width="6%"><?php  echo $fet_2['origin']; ?></td>
											<td width="8%"><?php echo $fet_2['receiver_name']; ?></td>
											<td width="10%"><?php  echo $fet_2['destination']; ?></td>
											<td width="7%"><?php  echo $fet_2['no_of_items']; ?></td>
											<td width="9%"><?php  echo $fet_2['payment_mode']; ?></td>
											<td width="8%"><?php echo "<b>" . $fet_2['discounted_price'] . "</b>"; ?></td>
											<td><?php echo $fet_2['agent_name']; ?></td>
											<td width="28%">
												&nbsp;&nbsp;
												<a href="javascript:void(0);" class="actionButtons" onClick="MM_openBrWindow('view.php?ed=<?php echo  $fet_2['id']; ?> ','','scrollbars=yes,left=300,top=150,width=900,height=900')">View</a>
												&nbsp;&nbsp; 
												<?php
													if($fet_2['hawb_status'] != $STATUS_DELIVERED) {
												?>
												<a href="javascript:void(0)" class="actionButtons" onclick="location.href='update_status.php?ed=<?php echo  $fet_2['id']; ?>'">Update</a>
												&nbsp;&nbsp;
												<?php
													}
												?>
												<a href="javascript:void(0);" class="actionButtons" onClick="MM_openBrWindow('print_view.php?ed=<?php echo  $fet_2['id']; ?> ','','scrollbars=yes,left=150,top=150,width=870,height=620')">Print</a> &nbsp;&nbsp; 
												<a href="javascript:void(0);" class="actionButtons" onclick="deleteBooking(<?php echo  $fet_2['id']; ?>)">Delete</a>
											</td>
										</tr>
									<?php 
											}
										}
										else {
									?>
										<tr><td colspan="14" align="center"><span class="dataNotFound">Data not found.</span></td></tr>
									<?php
										}
									?>
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
