<?php 
	include('protect.php');
	include('dbconnect.php'); 
	include('utilities.php');
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
		$del=mysqli_query($conn, "DELETE FROM users WHERE id='$del_id_net' ") or die (mysqli_error());
		echo "<script type=\"text/javascript\">";
		echo "	self.location='manager_rep.php?action=delete&success=true';";
		echo "</script>";
	}

	$stationFilter = ($stationId == "") ? "" : " AND station_id = " . $stationId;
	$total_results = (mysqli_query($conn, " select count(id) as row_count from users where user_type_id = " . MANAGER_ID . $stationFilter . " limit 1 ")); 

	$row = mysqli_fetch_assoc($total_results);
	$totalCount = $row['row_count'];

	$pager = new pager($_GET['p'], 15, $totalCount, 4);
	$offset = $pager->get_start_offset();
	$limit = 15;
	
	$SQLManagers = "SELECT * FROM users WHERE user_type_id = " . MANAGER_ID . $stationFilter . " ORDER BY name desc LIMIT " . $offset . ", $limit ";
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

				$(".actionButtons, #lnkAddManager").button();

				$("#tblManagerList tr:even").css("background-color", "#FFE6E6");  /* #EBEBE0 */

				if( action == "add" && success == "true"){
					$("#trStatusDisplay").show();
					$("#divStatusMessage").html("Successfully added a station manager.").show();
				}
				else if( action == "update" && success == "true"){
					$("#trStatusDisplay").show();
					$("#divStatusMessage").html("Successfully updated a station manager.").show();
				}
				else if( action == "delete" && success == "true"){
					$("#trStatusDisplay").show();
					$("#divStatusMessage").html("Successfully deleted a station manager.").show();
				}
				else if( action == "delete" && success == "false"){
					$("#trStatusDisplay").show();
					$("#divStatusMessage").html("Cannot deleted active station manager account.").show();
				}
				else {
					$("#divStatusMessage").hide();
					$("#trStatusDisplay").hide();
				}
			});

			function MM_openBrWindow(theURL,winName,features) { //v2.0
			  window.open(theURL,winName,features);
			}

			function deleteStationManager(deleteManagerId) {
				var confirmDelete = false;
				if( confirmDelete = confirm("Are you sure you want to delete manager?") ){
					location.href = "manager_rep.php?del_id=" + deleteManagerId;
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
									<div align="center" class="textShadow" style="font-size: 14px; font-weight: bold;">Station Managers</div>
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
											<td width="54%"><span class="Closed" style="padding-right: 10px;"><strong><?php echo $totalCount; ?> </strong></span><strong>Results Found</strong>.</td>
											<td width="46%"><div align="right"><?php echo $links = $pager->get_links(); ?></div></td>
										</tr>              
									</table>
								</td>
							</tr>
							<tr>
								<td id="min1">
									<table id="tblManagerList" width="98%" border="0"  cellspacing="0" cellpadding="5" align="center" style="border:1px solid #181818; box-shadow: 3px 3px 3px #888888; margin-bottom: 10px;">
										<tr id="head_bg" style="border-bottom: 1px solid black;">
											<th width="15%" class="displayAllTableHeader">
												<div align="left"><strong>Code</strong></div>
											</th>
											<th class="displayAllTableHeader" width="20%"><div align="left"><strong>Name</strong></div></th>
											<th class="displayAllTableHeader" width="10%"><div align="left"><strong>Username</strong></div></th>
											<th class="displayAllTableHeader" width="10%"><div align="left"><strong>Station</strong></div></th>
											<th class="displayAllTableHeader" width="13%"><div align="left"><strong>Phone</strong></div></th>
											<th class="displayAllTableHeader" width="17%"><div align="left"><strong>Email Address</strong></div></th>	
											<th class="displayAllTableHeader" width="15%"><div align="left"><strong>Action</strong></div></th>
										</tr>
										<?php
											if( $recordCount > 0 ){
												while( $fet_2 = mysqli_fetch_array($result) ) {
												//include('results.php');
										?>	
										<tr>
											<td width="15%"><?php  echo $fet_2['code']; ?></td>
											<td width="20%"><?php  echo stripslashes($fet_2['name']); ?></td>
											<td width="10%"><?php  echo stripslashes($fet_2['username']); ?></td>
											<td width="10%">
												<?php  	
													$bpid = $fet_2['station_id'];
													$rs=getAssociativeArrayFromSQL($conn, "select * from bplace where id=".$bpid."");
													echo $rs['category'];
												?>
											</td>
											<td width="13%"><?php  echo stripslashes($fet_2['phone']); ?></td>
											<td width="17%"><?php  echo stripslashes($fet_2['email']); ?></td>
											<td width="15%">
												<a href="javascript:void(0);" class="actionButtons" onClick="MM_openBrWindow('manager_edit.php?ed=<?php echo  $fet_2['id']; ?> ','','scrollbars=yes,left=150,top=10,width=900,height=900')"><img src="images/flat_icons/pencil43.png" alt="X" /></a>
												<a href="javascript:void(0);" class="actionButtons" onclick="deleteStationManager(<?php echo  $fet_2['id']; ?>)"><img src="images/flat_icons/delete30.png" alt="X" /></a>
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
									<a id="lnkAddManager" href="javascript:void(0)" onclick="location.href='manager.php'" class="linkGoldButton" style="margin-right: 10px;">Add Manager</a>
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