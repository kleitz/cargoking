<?php 
	include('protect.php');
	include 'dbconnect.php'; 

	session_start();
	$login_id  = "";
	$login     = "";
	$type_code = "";
	$stationId = "";
	if( isset($_SESSION['login_id']) )  $login_id  = $_SESSION['login_id'];
	if( isset($_SESSION['username']) )  $login     = $_SESSION['username'];
	if( isset($_SESSION['type_code']) ) $type_code = $_SESSION['type_code'];
	if( isset($_SESSION['stationId']) ) $stationId = $_SESSION['stationId'];
	
	$md_edit = "";
	if( isset($_REQUEST['ed']) ) $md_edit = $_REQUEST['ed'];

	$shipmentTypeInfo = getAssociativeArrayFromSQL($conn, "SELECT * FROM ty_ship WHERE id = '$md_edit' ");

	$errorNo  = "";
	$errorMsg = "";

	if($_POST['submit']) {
		$typeOfShipment                  = mysqli_real_escape_string($conn, $_REQUEST['typeOfShipment']);
		$typeOfShipmentCode              = mysqli_real_escape_string($conn, $_REQUEST['typeOfShipmentCode']);
		$typeOfShipmentRemarks           = mysqli_real_escape_string($conn, $_REQUEST['typeOfShipmentRemarks']);

		$SQLUpdate  = " UPDATE ty_ship SET ";
		$SQLUpdate .= "   category = '$typeOfShipment', ";
		$SQLUpdate .= "   code = '$typeOfShipmentCode', ";
		$SQLUpdate .= "   remarks = '$typeOfShipmentRemarks', ";
		$SQLUpdate .= "   created_by = '$login_id', ";
		$SQLUpdate .= "   last_modified_date = now() ";
		$SQLUpdate .= " WHERE id = " . $md_edit;

		//echo "[SQL]: " . $SQLUpdate . "<br>";
		
		$successUpdate = mysqli_query($conn,  $SQLUpdate );

		if( $successUpdate ) {
			echo "<script type=\"text/javascript\">";
			echo "	 window.opener.location.href='cat_rep1.php?action=add&success=true';";
			echo "   window.close();";
			echo "</script>";
		}
		else {
			$errorNo  = mysqli_errno($conn);
			$errorMsg = mysqli_error($conn);
		}
	 }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link href="css/style.css" type="text/css"  rel="stylesheet"/>
		<link href="css/superfish.css" rel="stylesheet" media="screen">
		<link href="css/blitzer/jquery-ui-1.10.4.custom.css" rel="stylesheet">
		<title>Admin</title>
		<style type="text/css">
		<!--
		.style1 {font-size: large;}
		-->
		</style>
		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/jquery-ui-1.10.4.custom.min.js"></script>
		<script src="js/jquery.validate.min.js"></script>
		<script src="js/hoverIntent.js"></script>
		<script src="js/superfish.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				var sf = $('#menuCKNavigation').superfish();
				$("#btnUpdateShipmentType").button();
				$("#formTypeOfShipment").validate({
					rules: {
						typeOfShipment: {
							required:true,
							maxlength: 25,
							minlength: 4
							/*
							remote: {
								url: "checkTypeOfShipment.php",
								type: "post",
								data: {
									typeOfShipment: function() {
										return $("#txtTypeOfShipment").val();
									}
								}
							}
							*/
						}
					},

					messages: {
						typeOfShipment: {
							required: "Please Fill The Type of Shipment.",
							maxlength: "The maximum length of type of shipment should not exceed 25 characters.",
							minlength: "The minimum length of type of shipment should be 4 characters."
							/* remote: "Type of Shipment Already Exists. Please try another one." */
						}
					},

					errorContainer: $('#errorContainer'),
					errorLabelContainer: $('#errorContainer ul'),
					wrapper: 'li'
				});
			});
		</script>
	</head>
	<body>
		<div align="center">
			<table width="100%" border="0" cellspacing="0" cellpadding="0"  align="center">
				<tr>
					<td>
						<table width="650" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF" style="border-radius:15px;">
							<tr>
								<td align="center">
									<form id="formTypeOfShipment" name="formTypeOfShipment" action="" method="post">
										<table width="600">
											<tr>
												<td colspan="3"><img src="images/logo.png" style="margin-top: 10px;" /></td>
											</tr>
											<tr>
												<td colspan="3"><p align="center" class="header">Update Shipment Type</p></td>
											</tr>
											<tr>
												<td colspan="3">
													<div id="errorContainer">
														<ul />
													</div>
													<?php
														if( $errorNo != "" && $errorMsg != "" ) {
															header("HTTP/1.1 500 Internal Server Error");
															echo "<div class='errorContainer'>";
															echo "<span class='errorMessage'>Error Number: " . $errorNo . "</span><br />";
															echo "<span class='errorMessage'>Error: " . $errorMsg . "</span><br />";
															echo "</div>";
														}
													?>
												</td>
											</tr>
											<tr><td colspan="3">&nbsp;</td></tr> 
											<tr>
												<td height="30" colspan="3" valign="top">
													<i><b>Note:</b>&nbsp;&nbsp;&nbsp;
													"</i><span class="required">*</span><i>" - required field.</i>
												</td>
											</tr>
											<tr>
												<td width="17" class="required">*</td>
												<td width="153" valign="top"><label for="txtTypeOfShipment">Type of Shipment</label></td>
												<td width="435">
													<input type="text" id='txtTypeOfShipment' name="typeOfShipment" value="<?php echo $shipmentTypeInfo['category']; ?>" class="form-field" style="width:250px;" title="Type of Shipment (eg. General Cargo, Perishable Goods, Valuable Item)." />
												</td>
											</tr>
											<tr>
												<td width="17">&nbsp;</td>
												<td width="153" valign="top"><label for="txtTypeOfShipmentCode">Shipment Code</label></td>
												<td width="435">
													<input type="text" id='txtTypeOfShipmentCode' name="typeOfShipmentCode" value="<?php echo $shipmentTypeInfo['code']; ?>" class="form-field" style="width:250px;" title="Type of Shipment code(Not required)." />
												</td>
											</tr>
											<tr>
												<td width="17">&nbsp;</td>
												<td width="153" valign="top"><label for="txtTypeOfShipmentRemarks">Remarks</label></td>
												<td width="435">
													<textarea id='txtTypeOfShipmentRemarks' name="typeOfShipmentRemarks" style="width:250px;" class="form-field" title="Type of Shipment remarks(Not required)."><?php echo $shipmentTypeInfo['remarks']; ?></textarea>
												</td>
											</tr>
											<tr>
												<td width="17">&nbsp;</td>
												<td width="153">&nbsp;</td>
												<td width="435"><input type="submit"id="btnUpdateShipmentType" name="submit" value="Update Shipment Type" style="margin-top: 15px;" /></td>
											</tr>
											<tr>
												<td colspan="3"><?php include('adminfooter.php') ?></td>
											</tr>
										</table>
									</form>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>
