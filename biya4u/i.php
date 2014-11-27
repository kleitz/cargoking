<?php 
	include('protect.php');
	include 'dbconnect.php'; 
	include('paging.class.php');
	include('constants.php');

	session_start();

	$type_code = "";
	$stationId = "";
	$satelliteOfficeId = "";
	if( isset($_SESSION['type_code']) )           $type_code         = $_SESSION['type_code'];
	if( isset($_SESSION['stationId']) )           $stationId         = $_SESSION['stationId'];
	if( isset($_SESSION['satellite_office_id']) ) $satelliteOfficeId = $_SESSION['satellite_office_id'];
	
	$station = "N/A";
	$satelliteOffice = "N/A";

	if( $stationId ) {
		$stationInfo = getAssociativeArrayFromSQL($conn,  "select * from bplace where id ='" . $stationId . "'" );
		$station = $stationInfo['category'];
	}
	
	if( $satelliteOfficeId ) {
		$satelliteOfficeInfo = getAssociativeArrayFromSQL($conn,  "select * from deliveryarea where id ='" . $satelliteOfficeId . "'" );
		$satelliteOffice = $satelliteOfficeInfo['city'];
	}

	$action = "";
	$success = "";
	if( isset($_REQUEST['action']) ) $action = $_REQUEST['action'];
	if( isset($_REQUEST['success']) ) $success = $_REQUEST['success'];

	if(isset($_REQUEST['del_id'])) {
		$del_id_net = $_REQUEST['del_id' ];

		//Insert code for checking if there are records from other tables that are accessing the record to be deleted.
		//Return an error message if the manager to be deleted has been accessed by other entities.

		$del=mysqli_query($conn, "DELETE FROM users WHERE id='$del_id_net' ") or die (mysqli_error());
		echo "<script type=\"text/javascript\">";
		echo "	self.location='manager_rep.php?action=delete&success=true';";
		echo "</script>";
	}

	$stationFilter   = ($stationId == "") ? "" : " WHERE station_id = " . $stationId;
	$satOfficeFilter = ($satelliteOfficeId == "") ? "" : " AND satellite_office_id=" . $satelliteOfficeId;
	
	$total_results = (mysqli_query($conn, " select count(id) as row_count from vw_customers " . $stationFilter . $satOfficeFilter . " limit 1 ")); 

	$row = mysqli_fetch_assoc($total_results);
	$totalCount = $row['row_count'];

	$pager = new pager($_GET['p'], 15, $totalCount, 4);
	$offset = $pager->get_start_offset();
	$limit = 15;
	
	$SQLManagers = "SELECT * FROM vw_customers " . $stationFilter . $satOfficeFilter . " ORDER BY cust_name asc LIMIT " . $offset . ", $limit ";
	
	//echo "[SQL]: " . $SQLManagers . "<br>";
	
	$result = mysqli_query($conn, $SQLManagers);
	$recordCount = mysqli_num_rows($result);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link href="css/style.css" type="text/css"  rel="stylesheet"/>
		<link href="css/superfish.css" rel="stylesheet" media="screen">
		<link href="css/blitzer/jquery-ui-1.10.4.custom.css" rel="stylesheet">
		<title>Admin</title>
		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/jquery-ui-1.10.4.custom.min.js"></script>
		<script src="js/hoverIntent.js"></script>
		<script src="js/superfish.js"></script>
		<script type="text/javascript">
			var action = "<?php echo $action; ?>";
			var success = "<?php echo $success; ?>";
			$(document).ready(function(){
				var sf = $('#menuCKNavigation').superfish();

				$(".actionButtons").button();

				$("#tblManagerList tr:even").css("background-color", "#EBEBE0");

				if( action == "add" && success == "true"){
					$("#trStatusDisplay").show();
					$("#divStatusMessage").html("Successfully added a customer.").show();
				}
				else if( action == "update" && success == "true"){
					$("#trStatusDisplay").show();
					$("#divStatusMessage").html("Successfully updated a customer.").show();
				}
				else if( action == "delete" && success == "true"){
					$("#trStatusDisplay").show();
					$("#divStatusMessage").html("Successfully deleted a customer.").show();
				}
				else if( action == "delete" && success == "false"){
					$("#trStatusDisplay").show();
					$("#divStatusMessage").html("Cannot deleted active customer.").show();
				}
				else {
					$("#divStatusMessage").hide();
					$("#trStatusDisplay").hide();
				}
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
								<td><?php include('adminheader.php') ?>
							</td>
							</tr>
							<tr>
								<td>
									<p>&nbsp;</p>
									<div align="center" class="style2"><strong>Customers</strong></div>
								</td>
							</tr>
							<tr><td>&nbsp;</td></tr>
							<tr id="trStatusDisplay">
								<td style="padding: 0px 12px;">
									<div id="divStatusMessage"></div>
								</td>
							</tr>
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td>
									<div style="display: inline-block; margin-left: 10px;"><b>Station:</b> <?php echo $station; ?></div>
									<?php if( $satelliteOffice != "N/A") { ?>
									<div style="display: inline-block; margin-left: 15px;"><b>Satellite Office:</b> <?php echo $satelliteOffice; ?></div>
									<?php } ?>
								</td>
							</tr>
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td>
									<table width="98%" border="0" align="center" cellpadding="3" cellspacing="3">
										<tr>
											<td width="54%"><span class="Closed" style="padding-right: 10px;"><strong><?php echo $totalCount; ?> </strong></span><strong>Results Found</strong>.</td>
											<td width="46%"><div align="right"><?php echo $links = $pager->get_links(); ?></div></td>
										</tr>              
									</table>
								</td>
							</tr>
							<tr>
								<td id="min1">
									<table id="tblManagerList" width="98%" border="0"  cellspacing="0" cellpadding="5" align="center" id="tab_bg" style="border:1px solid #181818; box-shadow: 3px 3px 3px #888888;">
										<tr id="head_bg"  style="border-bottom: 1px solid black;">
											<th width="4%" height="39" class="displayAllTableHeader">
												<div align="left"><strong>ID</strong></div>
											</th>
											<th class="displayAllTableHeader" width="10%"><div align="left"><strong>Name</strong></div></th>
											<th class="displayAllTableHeader" width="20%"><div align="left"><strong>Address</strong></div></th>
											<th class="displayAllTableHeader" width="12%"><div align="left"><strong>Contact No.</strong></div></th>
											<th class="displayAllTableHeader" width="17%"><div align="left"><strong>Email Address</strong></div></th>
											<th class="displayAllTableHeader" width="12%"><div align="left"><strong>Identification No.</strong></div></th>
											<th class="displayAllTableHeader" width="23%"><div align="left"><strong>Action</strong></div></th>
										</tr>
										<?php
											if( $recordCount > 0 ){
												while( $fet_2 = mysqli_fetch_array($result) ) {
												//include('results.php');
										?>	
										<tr>
											<td width="4%"><?php  echo $fet_2['cust_id']; ?></td>
											<td width="20%"><?php  echo $fet_2['cust_name']; ?></td>
											<td width="10%"><?php  echo $fet_2['address']; ?></td>
											<td width="12%"><?php  echo $fet_2['phone']; ?></td>
											<td width="17%"><?php  echo $fet_2['email_address']; ?></td>
											<td width="12%"><?php  echo $fet_2['identification_number']; ?></td>
											<td width="23%">
												<a href="#" class="actionButtons" onClick="MM_openBrWindow('customer_edit.php?ed=<?php echo  $fet_2['id']; ?> ','','scrollbars=yes,left=150,top=10,width=900,height=900')">Edit</a>
												<a href="?del_id=<?php echo  $fet_2['id']; ?>" class="actionButtons" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
											</td>
										</tr> 
										<?php
												}
											}
											else {
										?>
											<tr><td colspan="7" align="center"><span class="dataNotFound">Data not found.</span></td></tr>
										<?php
											}
										?>
									</table>
								</td>
							</tr>
							<tr>
								<td align="right" style="height: 40px; vertical-align: bottom;">
									<a id="lnkAddCustomer" href="customer.php" class="linkGoldButton" style="margin-right: 10px;">Add Customer</a>
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