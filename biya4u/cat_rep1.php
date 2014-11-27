<?php 
	include('protect.php');
	include 'dbconnect.php'; 
	include('paging.class.php');
	include('constants.php');

	$action = "";
	$success = "";
	if( isset($_REQUEST['action']) ) $action = $_REQUEST['action'];
	if( isset($_REQUEST['success']) ) $success = $_REQUEST['success'];

	if( isset($_REQUEST['del_id']) ) {
		$del_id_net = $_REQUEST['del_id']; 
		$tyship_query = mysqli_query($conn,  "select * from arr where tyship = '$del_id_net'" );
		$tyship_num = mysqli_num_rows($tyship_query);

		if( $tyship_num > 0 ) {
			echo "<script type=\"text/javascript\">";
			echo "	self.location='cat_rep1.php?action=delete&success=false';";
			echo "</script>";
		} else {
			$del = mysqli_query($conn, "DELETE FROM ty_ship WHERE id='$del_id_net' ") or die (mysqli_error());
			echo "<script type=\"text/javascript\">";
			echo "	self.location='cat_rep1.php?action=delete&success=true';";
			echo "</script>";
		}
	}

	$total_results = ( mysqli_query($conn,  "SELECT COUNT(*) as Num FROM ty_ship " ) );
	$row = mysqli_fetch_assoc($total_results);
	$totalCount = $row['Num'];

	$pager = new pager($_GET['p'], 15, $totalCount, 4);
	$offset = $pager->get_start_offset();
	$limit = 15;

	$result = mysqli_query($conn, "SELECT * FROM ty_ship  ORDER BY category asc LIMIT " . $offset . ", $limit ");
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
				$(".actionButtons").button();
				var sf = $('#menuCKNavigation').superfish();
				$("#tblTypeOfShipmets tr:even").css("background-color", "#EBEBE0");
				if( action == "add" && success == "true"){
					$("#trStatusDisplay").show();
					$("#divStatusMessage").html("Successfully added shipment type.").show();
				}
				else if( action == "update" && success == "true"){
					$("#trStatusDisplay").show();
					$("#divStatusMessage").html("Successfully updated shipment type.").show();
				}
				else if( action == "delete" && success == "true"){
					$("#trStatusDisplay").show();
					$("#divStatusMessage").html("Successfully deleted shipment type.").show();
				}
				else if( action == "delete" && success == "false"){
					$("#trStatusDisplay").show();
					$("#divStatusMessage").html("Cannot deleted active shipment type.").show();
				}
				else {
					$("#divStatusMessage").hide();
					$("#trStatusDisplay").hide();
				}
			});

			function MM_openBrWindow(theURL,winName,features) { //v2.0
			  window.open(theURL,winName,features);
			}

			function deleteTypeOfShipment(deletTypeOfShipmentId) {
				var confirmDelete = false;
				if( confirmDelete = confirm("Are you sure you want to delete shipment type?") ){
					location.href = "cat_rep1.php?del_id=" + deletTypeOfShipmentId;
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
									<table width="55%" border="0" align="center" cellpadding="3" cellspacing="3">
										<tr><td colspan="2"><p align="center" class="header">Type of Shipments</p></td></tr>
										<tr id="trStatusDisplay">
											<td colspan="2">
												<div id="divStatusMessage"></div>
											</td>
										</tr>
										<tr><td colspan="2">&nbsp;</td></tr>
										<tr>
											<td width="54%"><span class="Closed" style="padding-right: 10px;"><strong><?php echo $totalCount; ?></strong></span><strong>Results Found</strong>.</td>
											<td width="46%"><div align="right"><?php echo $links = $pager->get_links(); ?></div></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td>
									<table id="tblTypeOfShipmets" width="55%" border="0"  cellspacing="0" cellpadding="5" align="center" id="tab_bg" style="border:1px solid #181818; box-shadow: 3px 3px 3px #888888;">
										<tr id="head_bg"  style="border-bottom: 1px solid black;">
											<td class="displayAllTableHeader" style="width: 10%; padding-left: 20px;"><div align="left"><strong>Id</strong></div></td>
											<td class="displayAllTableHeader" style="width: 60%; padding-left: 20px;"><div align="left"><strong>Type of Shipments</strong></div></td>	
											<td class="displayAllTableHeader" style="width: 30%; padding-left: 20px;"><div align="left"><strong>Action </strong></div></td>
										</tr>
										<?php 
											while($fet_2=mysqli_fetch_array($result)) {
										?>	
										<tr>
											<td style="width: 10%; padding-left: 20px;"><?php echo $fet_2['id']; ?></td>
											<td style="width: 60%; padding-left: 20px;"><?php echo stripslashes($fet_2['category']); ?></td>
											<td style="width: 30%; padding-left: 20px;">
												<a class="actionButtons" href="javascript:void(0);" onClick="MM_openBrWindow('cat_edit1.php?ed=<?php echo $fet_2['id']; ?> ','','scrollbars=yes,left=325,top=50,width=700,height=575')"   >Edit </a>
												<a class="actionButtons" href="javascript:void(0);" onclick="deleteTypeOfShipment(<?php echo  $fet_2['id']; ?>)">Delete</a>
											</td>
										</tr>
										<?php
											}
										?>
									</table>
								</td>
							</tr>
							<tr>
								<td align="right" style="height: 40px; vertical-align: bottom;">
									<a id="lnkAddManager" href="cat1.php" class="linkGoldButton" style="margin-right: 220px;">Add Type of Shipments</a>
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
