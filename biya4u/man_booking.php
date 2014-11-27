<?php 
	include('protect.php');
	include 'dbconnect.php'; 
	include('paging.class.php');
	include('constants.php');

	session_start();
	$login_id = "";
	$login = "";
	$type_code = "";
	$stationId = "";

	if( isset($_SESSION['login_id']) ) $login_id = $_SESSION['login_id'];
	if( isset($_SESSION['username']) ) $login = $_SESSION['username'];
	if( isset($_SESSION['type_code']) ) $type_code = $_SESSION['type_code'];
	if( isset($_SESSION['stationId']) ) $stationId = $_SESSION['stationId'];

	$sug = html_entity_decode($_GET['search']);

	if($type_code == ADMIN)
		$mug = " where concat(id, lower(booking_code), lower(origin), lower(destination), lower(receiver_name), receiver_phone, lower(receiver_address), lower(customer_code), lower(sender_name), sender_phone, lower(sender_city)) like '%" . strtolower($searchKey) . "%'";
	else
		$mug = " and concat(id, lower(booking_code), lower(origin), lower(destination), lower(receiver_name), receiver_phone, lower(receiver_address), lower(customer_code), lower(sender_name), sender_phone, lower(sender_city)) like '%" . strtolower($searchKey) . "%'";


	if(isset($_REQUEST['del_id'])) {
		$del_id_net = $_REQUEST['del_id' ];
		$del = mysqli_query($conn, "DELETE FROM booking WHERE id='$del_id_net' ") or die (mysqli_error());
		echo "<script type=\"text/javascript\">";
		echo "	alert('One Record Deleted Successfully');";
		echo "	self.location='man_booking.php';";
		echo "</script>";
	}

	if($type_code == ADMIN)
		$total_results = (mysqli_query($conn, "SELECT * FROM vw_booking_details " . $mug));
	else if( $type_code == STATION_ADMIN) {
		$total_results = mysqli_query($conn, "SELECT * FROM vw_booking_details where origin_id=" . $stationId . " " . $mug);
	}
	else
		$total_results = (mysqli_query($conn, "SELECT * FROM vw_booking_details where agent_id = '$login_id' " . $mug));
	
	$totalCount = mysqli_num_rows($total_results);


	$pager = new pager($_GET['p'], 15, $totalCount, 4);
	$offset = $pager->get_start_offset();
	$limit = 15;

	// Perform MySQL query on only the current page number's results 
	if($type_code == ADMIN)
		$result = mysqli_query($conn, "SELECT * FROM vw_booking_details " . $mug . "  ORDER BY hawb_date desc LIMIT " . $offset . ", $limit ");
	else if( $type_code == STATION_ADMIN) {
		$result = mysqli_query($conn, "SELECT * FROM vw_booking_details where origin_id = " . $stationId . " " . $mug);
	}
	else
		$result = mysqli_query($conn, "SELECT * FROM vw_booking_details where agent_id = '$login_id' ".$mug." ORDER BY hawb_date desc LIMIT " . $offset . ", $limit ");
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
		<script type="text/JavaScript">
			$(document).ready(function(){
				$(".actionButtons, #lnkAddStationAdmin").button();
				var sf = $('#menuCKNavigation').superfish();
				$("#tblBookingList tr:even").css("background-color", "#FFE6E6");
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
						<td><?php include('adminheader.php'); ?></td>
					</tr>
					<tr>
						<td colspan="2">
							<table width="928" align="center">
								<tr>
									<td width="332"><strong>Manage Booking Details </strong></td>
									<td width="584">
										<form action="" method="get" id="sub">
											<strong>Search By HAWB No,Customer Id,Phone </strong>
											<input type="text" name="search" value="" id="search" style="width:200px; height:20px;"/>
											<input type="submit" name="submit" id="" value="Go"/>
											<input type="reset" name="rest" onClick="self.location='man_booking.php';"/>
										</form>
									</td>
								</tr>
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
							<br />
						</td>
					</tr>
					<tr>
						<td width="187" align="right">
							<?php if($_REQUEST['succ']=='yes'){echo "<span class='style3'>Succesfully</span>" ;} ?>
							<a href="newbook.php">Add New</a>
							&nbsp;&nbsp;&nbsp;
						</td>   
					</tr>
					<tr>
						<td id="min1">
							<table id="tblBookingList" width="98%" border="0"  cellspacing="0" cellpadding="5" align="center" style="border:1px solid #181818; box-shadow: 3px 3px 3px #888888;">
								<tr id="head_bg"  bgcolor="#F4F4F4">
									<td width="10%" height="25" class="displayAllTableHeader"><div align="left"><strong>Date</strong></div></td>
									<td class="displayAllTableHeader" width="7%"><div align="left"><strong>HAWB No</strong></div></td>
									<td class="displayAllTableHeader" width="6%"><div align="left"><strong>Origin</strong></div></td>
									<td class="displayAllTableHeader" width="8%"><div align="left"><strong>Receiver</strong></div></td>
									<td class="displayAllTableHeader" width="10%"><div align="left"><strong>Destination</strong></div></td>
									<td class="displayAllTableHeader" width="7%"><div align="left"><strong>Quantity</strong></div></td>
									<td class="displayAllTableHeader" width="9%"><div align="left"><strong>Mode of Payment</strong></div></td>
									<td class="displayAllTableHeader" width="7%"><div align="left"><strong>Total Amount</strong></div></td>
									<td class="displayAllTableHeader" width="8%"><div align="left"><strong>Posted By</strong></div></td>
									<td class="displayAllTableHeader" width="28%"><div align="center"><strong>Action </strong></div></td>
								</tr>
								<?php
									while($fet_2 = mysqli_fetch_array($result)) {
										//	include('results.php');
								?>
								<tr>
									<td width="10%"><?php echo $fet_2['formatted_date']; ?></td>
									<td width="7%"><?php echo $fet_2['booking_code']; ?></td>
									<td width="6%"><?php echo $fet_2['origin']; ?></td>
									<td width="8%"><?php echo $fet_2['receiver_name']; ?></td>
									<td width="10%"><?php echo $fet_2['destination']; ?></td>
									<td width="7%"><?php echo $fet_2['no_of_items']; ?></td>
									<td width="9%"><?php echo $fet_2['payment_mode']; ?></td>
									<td width="7%"><?php echo $fet_2['total_price']; ?></td>
									<td><?php echo $fet_2['agent_name']; ?></td>
									<td width="28%">
										<!--<a href="booking_edit.php?ed=< ?php echo  $fet_2['id']; ?>" target="_blank">Edit </a>--> &nbsp;&nbsp; 
										<a href="javascript:void(0);" class="actionButtons" onClick="MM_openBrWindow('view.php?ed=<?php echo  $fet_2['id']; ?> ','','scrollbars=yes,left=300,top=150,width=900,height=900')"   >View </a> &nbsp;&nbsp; 
    
									<?php
										if($type_code == ADMIN) {
											if($fet_2['hawb_status_id'] != 3) { //Status is not equal to DELIVERED
												echo "<a href=\"update_status.php?ed=".$fet_2['id'] . ">Update</a> &nbsp;&nbsp; ";
											}
									?>
										 <a href="#" onClick="MM_openBrWindow('print_view.php?ed=<?php echo  $fet_2['id']; ?> ','','scrollbars=yes,left=150,top=150,width=870,height=620')"  >Print </a> &nbsp;&nbsp; 
										 <a href="?del_id=<?php echo  $fet_2['id']; ?>" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
									<?php
										}
									?>
									</td>	
								</tr>
								<?php
									}
								?>
									</table>
									<br />
									<br />
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
