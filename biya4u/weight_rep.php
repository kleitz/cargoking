<?php 
	include('protect.php');
	include 'dbconnect.php'; 
	include('paging.class.php');
	include('utilities.php');

	$action = "";
	$success = "";
	if( isset($_REQUEST['action']) ) $action = $_REQUEST['action'];
	if( isset($_REQUEST['success']) ) $success = $_REQUEST['success'];

    if(isset($_REQUEST['del_id'])) {
		$del_id_net = $_REQUEST['del_id' ];
		$modpay_query = mysqli_query($conn, "select * from booking where weight_ref_id = '$del_id_net'");
		$modpay_num = mysqli_num_rows($modpay_query);
  
		if($modpay_num > 0) {
			echo "<script type=\"text/javascript\">";
			echo "	self.location='weight_rep.php?action=delete&success=false';";
			echo "</script>";
		}
		else {
			$del = mysqli_query($conn, "DELETE FROM weight WHERE id='$del_id_net'") or die (mysqli_error());
			echo "<script type=\"text/javascript\">";
			echo "	self.location='weight_rep.php?action=delete&success=true';";
			echo "</script>";
		}
	}

	$total_results = (mysqli_query($conn, "SELECT COUNT(*) as Num FROM weight ")); 
		
	$row = mysqli_fetch_assoc($total_results);
	$totalCount = $row['Num'];

	$pager = new pager($_GET['p'], 15, $totalCount, 4);
	$offset = $pager->get_start_offset();
	$limit = 15;

	$result = mysqli_query($conn, "SELECT * FROM weight ORDER BY delarea, weightvalue, id ASC LIMIT " . $offset . ", $limit ");
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

				$(".actionButtons, #lnkAddWeightCategory").button();

				$("#tblWeightCategoryList tr:even").css("background-color", "#FFE6E6");  /* #EBEBE0 */

				if( action == "add" && success == "true"){
					$("#trStatusDisplay").show();
					$("#divStatusMessage").html("Successfully added a weight category.").show();
				}
				else if( action == "update" && success == "true"){
					$("#trStatusDisplay").show();
					$("#divStatusMessage").html("Successfully updated a weight category.").show();
				}
				else if( action == "delete" && success == "true"){
					$("#trStatusDisplay").show();
					$("#divStatusMessage").html("Successfully deleted a weight category.").show();
				}
				else if( action == "delete" && success == "false"){
					$("#trStatusDisplay").show();
					$("#divStatusMessage").html("Cannot deleted active weight category.").show();
				}
				else {
					$("#divStatusMessage").hide();
					$("#trStatusDisplay").hide();
				}
			});

			function MM_openBrWindow(theURL,winName,features) { //v2.0
			  window.open(theURL,winName,features);
			}

			function deleteWeightCategory(weightCategoryId) {
				var confirmDelete = false;
				if( confirmDelete = confirm("Are you sure you want to delete weight?") ){
					location.href = "weight_rep.php?del_id=" + weightCategoryId;
				}
				return confirmDelete;
			}
		</script>
	</head>

	<body>
		<div align="center">
			<table width="100%" border="0" cellspacing="0" cellpadding="0"  align="center" >
				<tr>
					<td>
						<table width="970" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
							<tr>
								<td><?php include('adminheader.php') ?></td>
							</tr>
							<tr>
								<td>
									<table width="600" border="0" align="center" cellpadding="3" cellspacing="3">
										<tr>
											<td colspan="2">
												<p>&nbsp;</p>
												<div align="center" class="textShadow" style="font-size: 14px; font-weight: bold;">Weight Categories</div>
											</td>
										</tr>
										<tr><td colspan="2">&nbsp;</td></tr>
										<tr id="trStatusDisplay">
											<td colspan="2" style="padding: 0px 12px;">
												<div id="divStatusMessage"></div>
											</td>
										</tr>
										<tr><td colspan="2">&nbsp;</td></tr>
										<tr>
											<td width="54%"><span class="Closed"><strong><?php echo $totalCount; ?> </strong></span><strong>Results Found</strong>.</td>
											<td width="46%"><div align="right"><?php echo $links = $pager->get_links(); ?></div></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td>
									<table id="tblWeightCategoryList" width="600" border="0"  cellspacing="0" cellpadding="5" align="center" style="border:1px solid #181818; box-shadow: 3px 3px 3px #888888;">
										<tr id="head_bg" style="border-bottom: 1px solid black;">
											<td class="displayAllTableHeader" width="14%" style="padding-left: 15px;"><div align="left"><strong>ID</strong></div></td>
											<td class="displayAllTableHeader" width="20%"><div align="left"><strong>Weight Value</strong></div></td>	
											<td class="displayAllTableHeader" width="15%"><div align="left"><strong>Rate</strong></div></td>	
											<td class="displayAllTableHeader" width="25%"><div align="left"><strong>Delivery Area </strong></div></td>
											<td class="displayAllTableHeader" width="26%"><div align="left"><strong>Action </strong></div></td>
										</tr>
										<?php
											if( $recordCount > 0 ){
												while($fet_2 = mysqli_fetch_array($result)) {
										?>	
										<tr>
											<td width="14%" style="padding-left: 15px;"><?php  echo $fet_2['id']; ?></td>
											<td width="20%"><?php  echo stripslashes($fet_2['weightvalue']); ?> Kg</td>
											<td width="15%"><?php  echo stripslashes($fet_2['rate']); ?></td>
											<td width="25%"><?php  echo getWeightDeliveryArea($fet_2['delarea']); ?></td>
											<td width="26%">
												<a href="javascript:void(0);" class="actionButtons" onClick="MM_openBrWindow('weight_edit.php?ed=<?php echo  $fet_2['id']; ?> ','','scrollbars=yes,left=300,top=150,width=600,height=500')">Edit</a>
												<?php
													if( 127 > $fet_2['id'] || 132 < $fet_2['id']) {
														echo "<a href=\"javascript:void(0);\" class=\"actionButtons\" onclick=\"deleteWeightCategory(" . $fet_2['id'] . ");\">Delete</a>";
													}
												?>
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
							<tr>
								<td align="right" style="height: 40px; vertical-align: bottom;">
									<a id="lnkAddWeightCategory" href="javascript:void(0)" onclick="location.href='weight.php'" class="linkGoldButton" style="margin-right: 185px;">Add Weight Category</a>
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
