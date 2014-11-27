<?php 
	include('protect.php');
	include 'dbconnect.php'; 
	include('paging.class.php');
	include('constants.php');

	session_start();

	$type_code = "";
	$stationId = "";
	$satelliteOfficeId = "";
	$stationOnly = "";
	if( isset($_SESSION['type_code']) )           $type_code         = $_SESSION['type_code'];
	if( isset($_SESSION['stationId']) )           $stationId         = $_SESSION['stationId'];
	if( isset($_SESSION['satellite_office_id']) ) $satelliteOfficeId = $_SESSION['satellite_office_id'];
	if( isset($_GET['station_only']) )            $stationOnly       = $_GET['station_only'];

	if( $stationOnly ){
		$satelliteOfficeId = "";
	}
	
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

		$del = mysqli_query($conn, "DELETE FROM customer WHERE id='$del_id_net' ") or die (mysqli_error());
		echo "<script type=\"text/javascript\">";
		echo "	self.location='customer_rep.php?action=delete&success=true';";
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
	$strOffsetLimit = " LIMIT " . $offset . ", $limit";

	$SQLCustomers = "SELECT * FROM vw_customers ";
	$strSQLOrder = " ORDER BY cust_name ASC ";
	
	$SQLResult = $SQLCustomers . $stationFilter . $satOfficeFilter;

	$recordCount = mysqli_num_rows(mysqli_query($conn, $SQLResult));
	$result = mysqli_query($conn, $SQLResult . $strSQLOrder . $strOffsetLimit);

	//echo "[SQL]: " . $SQLResult . "<br>";

	if(isset($_GET['submit'])) {
		$searchKey = "";
		$strBookingFullTextSearchFilter = "";
		$hasSearchKeyFilter = false;

		if ( isset($_GET['searchKey']) ) {
			$searchKey = $_GET['searchKey'];
			$strBookingFullTextSearchFilter = " concat(id, lower(cust_id), identification_number, lower(cust_name), lower(address), lower(station_name), phone, lower(satellite_office_name), lower(email_address)) like '%" . strtolower($searchKey) . "%'";		
			$hasSearchKeyFilter = true;
		}

		$strFilters = " AND ";
		if( $hasSearchKeyFilter ) {
			$strFilters .= $strBookingFullTextSearchFilter;
		}

		$SQLCount = $SQLResult . $strFilters;
		$SQLCustomersResult = $SQLCount . $strSQLOrder . $strOffsetLimit;
		
		//echo "[SQL]: " . $SQLCustomersResult . "<br>";
		
		$totalCount       = mysqli_num_rows( mysqli_query($conn, $SQLCount) );
		$result           = mysqli_query($conn, $SQLCustomersResult);
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link href="css/style.css" type="text/css"  rel="stylesheet"/>
		<link href="css/superfish.css" rel="stylesheet" media="screen">
		<link href="css/blitzer/jquery-ui-1.10.4.custom.css" rel="stylesheet">
		<link href="/images/favicon.ico" type="image/x-icon" rel="shortcut icon" />
		<title>Admin</title>
		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/jquery-ui-1.10.4.custom.min.js"></script>
		<script src="js/jquery.validate.min.js"></script>
		<script src="js/hoverIntent.js"></script>
		<script src="js/superfish.js"></script>
		<script type="text/javascript">
			var action = "<?php echo $action; ?>";
			var success = "<?php echo $success; ?>";
			$(document).ready(function(){
				var sf = $('#menuCKNavigation').superfish();
				$(".actionButtons, #lnkAddCustomer, #btnSubmitSearchByKey").button();
				$("#tblManagerList tr:even").css("background-color", "#FFE6E6");

				$("#formCustomerSearch").validate({
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

			function deleteCustomer(deleteCustomerId) {
				var confirmDelete = false;
				if( confirmDelete = confirm("Are you sure you want to delete customer?") ){
					location.href = "customer_rep.php?del_id=" + deleteCustomerId;
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
								<td><?php include('adminheader.php') ?>
							</td>
							</tr>
							<tr>
								<td>
									<p>&nbsp;</p>
									<div align="center" class="textShadow"><strong>Customers</strong></div>
								</td>
							</tr>
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td>
									<div id="errorContainer">
										<ul />
									</div>
								</td>
							</tr>
							<tr id="trStatusDisplay">
								<td style="padding: 0px 12px;">
									<div id="divStatusMessage"></div>
								</td>
							</tr>
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td>
									<table width="99%" align="center">
										<tr>
											<td>
												<?php
													if( $station != "N/A") {
												?>
												<div style="display: inline-block; margin-left: 10px;"><b>Station:</b> <?php echo $station; ?></div>
												<?php
													}

													if( $satelliteOffice != "N/A") {
												?>
												<div style="display: inline-block; margin-left: 10px;"><b>Satellite Office:</b> <?php echo $satelliteOffice; ?></div>
												<?php
													}
												?>
											</td>
											<td align="right">
												<form id="formCustomerSearch" name="formCustomerSearch" method="get">
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
											<th class="displayAllTableHeader" width="11%"><div align="left"><strong>Contact No.</strong></div></th>
											<th class="displayAllTableHeader" width="17%"><div align="left"><strong>Email Address</strong></div></th>
											<th class="displayAllTableHeader" width="13%"><div align="left"><strong>Identification No.</strong></div></th>
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
											<td width="11%"><?php  echo $fet_2['phone']; ?></td>
											<td width="17%"><?php  echo $fet_2['email_address']; ?></td>
											<td width="13%"><?php  echo $fet_2['identification_number']; ?></td>
											<td width="23%">
												<?php 
													if( $fet_2['satellite_office_id'] == $_SESSION['satellite_office_id'] || $type_code == ADMIN || $type_code == STATION_ADMIN ) {
												?>
												<a href="javascript:void(0);" class="actionButtons" onClick="MM_openBrWindow('customer_edit.php?ed=<?php echo  $fet_2['id']; ?> ','','scrollbars=yes,left=150,top=10,width=900,height=900')">Edit</a>
												<a href="javascript:void(0);" class="actionButtons" onclick="deleteCustomer(<?php echo  $fet_2['id']; ?>)">Delete</a>
												<?php
													}
													else
														echo "&nbsp;";
												?>
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
									<a id="lnkAddCustomer" href="javascript:void(0)" onclick="location.href='customer.php'" class="linkGoldButton" style="margin-right: 10px;">Add Customer</a>
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