<?php 
	include('protect.php');
	include 'dbconnect.php';
	include 'utilities.php';
	include('paging.class.php');
	include('constants.php');

	session_start();
	$type_code = "";
	$stationId = "";
	if( isset($_SESSION['type_code']) ) $type_code = $_SESSION['type_code'];
	if( isset($_SESSION['stationId']) ) $stationId = $_SESSION['stationId'];

	$action = "";
	$success = "";
	if( isset($_REQUEST['action']) ) $action = $_REQUEST['action'];
	if( isset($_REQUEST['success']) ) $success = $_REQUEST['success'];

	$station = "N/A";
	if( $stationId != "" ) {
		$stationInfo = getAssociativeArrayFromSQL($conn,  "select * from bplace where id ='" . $stationId . "'" );
		$station = $stationInfo['category'];
	}

	if(isset($_REQUEST['del_id'])) {
		$del_id_net = $_REQUEST['del_id' ];
		$del=mysqli_query($conn, "DELETE FROM deliveryarea WHERE id='$del_id_net' ") or die (mysqli_error());
		
		echo "<script type=\"text/javascript\">";
		echo "self.location='deliveryarea_rep.php?action=delete&success=true';";
		echo "</script>";
	}

	//echo "[STATION-ID]: [" . $stationId . "]<br>";
	
	$stationFilter = $stationId == "" ? "" : " WHERE station = " . $stationId;
	$total_results = (mysqli_query($conn, "SELECT COUNT(*) as Num FROM deliveryarea ". $stationFilter)); 
	$row = mysqli_fetch_assoc($total_results);
	$totalCount = $row['Num'];

	/*
	if($totalCount ==0)	{
		print "<script>";
			print "self.location='noresults.php';"; // Comment this line if you don't want to redirect
		print "</script>";
	}
	*/
	
	$pager = new pager($_GET['p'], 15, $totalCount, 4);
	$offset = $pager->get_start_offset();
	$limit = 15;

	// Perform MySQL query on only the current page number's results 
	$SQLQuery = "SELECT * FROM deliveryarea " . $stationFilter . " ORDER BY city asc LIMIT " . $offset . ", $limit ";
	
	//echo "[SQL]: " . $SQLQuery . "<br>";
	
	$result = mysqli_query($conn,  $SQLQuery );
	$recordCount = mysqli_num_rows($result);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link href="css/style.css" type="text/css"  rel="stylesheet"/>
		<link href="css/superfish.css" rel="stylesheet" media="screen">
		<link href="css/blitzer/jquery-ui-1.10.4.custom.css" rel="stylesheet">
		<title>Satellite Offices</title>
		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/jquery-ui-1.10.4.custom.min.js"></script>
		<script src="js/hoverIntent.js"></script>
		<script src="js/superfish.js"></script>
		<script type="text/javascript">

			var action = "<?php echo $action; ?>";
			var success = "<?php echo $success; ?>";

			$(document).ready(function(){
				$(".actionButtons, #lnkAddStationAdmin").button();
				var sf = $('#menuCKNavigation').superfish();
				$("#tblDeliveryAreasList tr:even").css("background-color", "#FFE6E6");

				if( action == "add" && success == "true"){
					$("#trStatusDisplay").show();
					$("#divStatusMessage").html("Successfully added a satellite office.").show();
				}
				else if( action == "update" && success == "true"){
					$("#trStatusDisplay").show();
					$("#divStatusMessage").html("Successfully updated a satellite office.").show();
				}
				else if( action == "delete" && success == "true"){
					$("#trStatusDisplay").show();
					$("#divStatusMessage").html("Successfully deleted a satellite office.").show();
				}
				else if( action == "delete" && success == "false"){
					$("#trStatusDisplay").show();
					$("#divStatusMessage").html("Cannot deleted active satellite office.").show();
				}
				else {
					$("#divStatusMessage").hide();
					$("#trStatusDisplay").hide();
				}

			});

			function MM_openBrWindow(theURL,winName,features) { //v2.0
			  window.open(theURL,winName,features);
			}

			function deleteSatelliteOffice(deleteSatelliteOfficeId) {
				var confirmDelete = false;
				if( confirmDelete = confirm("Are you sure you want to delete satellite office?") ){
					location.href = "deliveryarea_rep.php?del_id=" + deleteSAdminId;
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
								<td><?php include('adminheader.php') ?></td>
							</tr>
							<tr>
								<td>
									<p>&nbsp;</p>
									<div align="center" class="textShadow" style="font-size: 14px; font-weight: bold;">Satellite Offices</div>
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
									<?php
										if( $station != "N/A") {
									?>
									<div style="display: inline-block; margin-left: 15px;"><b>Station:</b> <?php echo $station; ?></div>
									<?php
										}
									?>
								</td>
							</tr>
							<tr><td>&nbsp;</td></tr>
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
									<table id="tblDeliveryAreasList" width="98%" border="0"  cellspacing="0" cellpadding="5" align="center" style="border:1px solid #181818; box-shadow: 3px 3px 3px #888888;">
										<tr id="head_bg" style="border-bottom: 1px solid black;">
											<!-- th class="displayAllTableHeader" width="9%" height="39"><div align="left"><strong>Id</strong></div></th -->
											<th class="displayAllTableHeader" style="width: 20%; padding-left: 20px;"><div align="left"><strong>City</strong></div></th>
											<th class="displayAllTableHeader" style="width: 20%;"><div align="left"><strong>HAWB Prefix</strong></div></th>
											<th class="displayAllTableHeader" style="width: 20%;"><div align="left"><strong>Station</strong></div></th>
											<th class="displayAllTableHeader" style="width: 20%;"><div align="left"><strong>Delivery Area</strong></div></th>	
											<th class="displayAllTableHeader" style="width: 20%;"><div align="left"><strong>Action</strong></div></th>	
										</tr>
									<?php 
										if( $recordCount > 0 ){
											while( $fet_2 = mysqli_fetch_array($result) ) {
									?>	
										<tr>
											<!-- td width="9%">< ?php  echo $fet_2['id']; ?></td -->
											<td style="width: 20%; padding-left: 20px;"><?php  echo stripslashes($fet_2['city']); ?></td>
											<td style="width: 20%; padding-left: 20px;"><?php  echo $fet_2['station_hawb_prefix']; ?></td>
											<td style="width: 20%;">
												<?php  
													$bpid = $fet_2['station'];
													$rs = getAssociativeArrayFromSQL($conn, "select * from bplace where id=".$bpid."");
													echo $rs['category']; 
												?>
											</td>
											<td style="width: 20%;">
												<?php 
													if($fet_2['delarea']=="1")
														echo ("Within City");
													else
														echo ("Outside City");
												?>
											</td>
											<td style="width: 20%;">
												<a class="actionButtons" href="javascript:void(0);" onClick="MM_openBrWindow('deliveryarea_edit.php?ed=<?php echo  $fet_2['id']; ?> ','','scrollbars=yes,left=275,top=100,width=725,height=550')">Edit</a>
												<a class="actionButtons" href="javascript:void(0);" onclick="deleteSatelliteOffice(<?php echo  $fet_2['id']; ?>)">Delete</a>
											</td>
										</tr>
										<?php
												}
											}
											else {
										?>
											<tr><td colspan="5" align="center"><span class="dataNotFound">Data not found.</span></td></tr>
										<?php
											}
										?>
									</table>
								</td>
							</tr>
							<!--
							<tr>
								<td>
									<table width="98%" border="0" align="center" cellpadding="3" cellspacing="3">
										<tr>
											<td width="54%"><span class="Closed"><strong>< ?php echo $totalCount; ?> </strong></span><strong>Results Found</strong>.</td>
											<td width="46%"><div align="right">< ?php echo $links = $pager->get_links(); ?></div></td>
										</tr>
									</table>
								</td>
							</tr>
							-->
							<tr>
								<td align="right" style="height: 40px; vertical-align: bottom;">
									<a id="lnkAddStationAdmin" href="javascript:void(0)" onclick="location.href='delivery_area.php'" class="linkGoldButton" style="margin-right: 10px;">Add Satellite Office</a>
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