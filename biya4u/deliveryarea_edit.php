<?php 
	include('protect.php');
	include 'dbconnect.php';
	include('utilities.php');
	include('constants.php');

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

	//echo "[ID]: " . $md_edit . "<br>";

	$satelliteOfficesInfo = getAssociativeArrayFromSQL($conn, "select * from deliveryarea where id = '$md_edit' ");

	$errorNo  = "";
	$errorMsg = "";

	if( isset($_POST['submit']) ) {	
		$satelliteOffice = "";
		$soHawbPrefixCode = "";
		$sOStation = "";
		$location  = "";
		$deliveryArea  = "";

		if( isset($_POST['satelliteOffice']) )  $satelliteOffice  = $_POST['satelliteOffice'];
		if( isset($_POST['soHawbPrefixCode']) ) $soHawbPrefixCode = $_POST['soHawbPrefixCode'];
		if( isset($_POST['location']) )         $location         = $_POST['location'];
		if( isset($_POST['deliveryArea']) )     $deliveryArea     = $_POST['deliveryArea'];

		$SQLUpdate  = " UPDATE deliveryarea SET ";
		$SQLUpdate .= "   city = '$satelliteOffice', ";
		$SQLUpdate .= "   station = '$location', ";
		$SQLUpdate .= "   delarea = '$deliveryArea', ";
		$SQLUpdate .= "   station_hawb_prefix = '$soHawbPrefixCode', ";
		$SQLUpdate .= "   created_by = '$login_id', ";
		$SQLUpdate .= "   last_modified_date = now() ";
		$SQLUpdate .= " WHERE id = " . $md_edit;

		//echo "[SQL Update]: " . $SQLUpdate . "<br>";

		$successUpdate = mysqli_query($conn, $SQLUpdate); 
		if( $successUpdate ) {
			echo "<script type=\"text/javascript\">";
			echo "	 window.opener.location.href='deliveryarea_rep.php?action=update&success=true';";
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
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link href="css/style.css" type="text/css"  rel="stylesheet"/>
		<link href="css/superfish.css" rel="stylesheet" media="screen">
		<link href="css/blitzer/jquery-ui-1.10.4.custom.css" rel="stylesheet">
		<title>Update Satellite Office Details</title>
		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/jquery-ui-1.10.4.custom.min.js"></script>
		<script src="js/jquery.validate.min.js"></script>
		<script src="js/hoverIntent.js"></script>
		<script src="js/superfish.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#btnUpdateSatelliteOffice").button();
				var sf = $('#menuCKNavigation').superfish();
				$("#formUpdateSatelliteOffice").validate({
					rules: {
						satelliteOffice: {
							required:true,
							maxlength: 50,
							minlength: 2
							/*
							remote: {
								url: "checkSatelliteOfficeNameUpdate.php",
								type: "post",
								data: {
									satelliteOfficeName: function() {
										return $("#txtSatelliteOffice").val();
									},
									soId: '<?php echo $md_edit; ?>'
								}
							}
							*/
						},
						soHawbPrefixCode: {
							maxlength: 20,
							minlength: 2
							/*
							remote: {
								url: "checkSatelliteOfficeHawbPrefixUpdate.php",
								type: "post",
								data: {
									soHawbPrefixCode: function() {
										return $("#txtSOHawbPrefixCode").val();
									},
									soId: '<?php echo $md_edit; ?>'
								}
							}
							*/
						},
						location: {
							required: true
						},
						deliveryArea: {
							required: true
						}
						
					},

					messages: {
						satelliteOffice: {
							required: "Please enter satellite office name.",
							minlength: "Please enter satellite office name with atleast 2 characters.",
							maxlength: "Please enter satellite office name with no more than 50 characters."
							/* remote: "Satellite office name already exists. Please try another one." */
						},
						soHawbPrefixCode: {
							minlength: "Please enter satellite office HAWB prefix code with atleast 2 characters.",
							maxlength: "Please enter satellite office HAWB prefix code with no more than 20 characters."
							/* remote: "satellite office HAWB prefix code already exists. Please try another one." */
						},
						location: {
							required: "Please select a station."
						},
						deliveryArea: {
							required: "Please select a delivery area."
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
			<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
				<tr>
					<td>
						<table width="700" border="0" cellspacing="3" cellpadding="3" class="sub_cont" bgcolor="#FFFFFF" style="border-radius:15px;">
							<tr>
								<td align="center">
									<form id="formUpdateSatelliteOffice" name="formUpdateSatelliteOffice" method="post" action="">
										<table width="600" border="0">
											<tr>
												<td colspan="3"><img src="images/logo.png" style="margin-top: 10px;" /></td>
											</tr>
											<tr>
												<td colspan="3"><p align="center" class="textShadow" style="font-size: 14px; font-weight: bold;">Update Satellite Office Details</p></td>
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
												<td colspan="3" height="30" valign="top">
													<i><b>Note:</b>&nbsp;&nbsp;&nbsp;
													"</i><span class="required">*</span><i>" - required field.</i>
												</td>
											</tr>
											<tr>
												<td width="15" class="required">*</td>
												<td width="215"><label for="txtSatelliteOffice">Satellite Office</label></td>
												<td width="300"><input type="text"id="txtSatelliteOffice" name="satelliteOffice" class="form-field" value="<?php echo $satelliteOfficesInfo['city']; ?>" style="width: 255px;" /></td>
											</tr>
											<tr>
												<td width="15">&nbsp;</td>
												<td width="215"><label for="txtSOHawbPrefixCode">HAWB Prefix Code</label></td>
												<td width="300"><input type="text"id="txtSOHawbPrefixCode" name="soHawbPrefixCode" class="form-field" value="<?php echo $satelliteOfficesInfo['station_hawb_prefix']; ?>" style="width: 255px;" /></td>
											</tr>
											<?php 	if( $type_code == ADMIN ) { ?> 
											<tr>
												<td width="15" class="required">*</td>
												<td width="215"><label for="sel_location">Station</label></td>
												<td width="300"><?php generateSelectObject($conn,  "bplace", "id", "category", "", "location", "form-field" ); ?></td>
											</tr>
											<?php 
													}
													
													if( $type_code == STATION_ADMIN ) {
														//Get Station Info from user station id.
														$city = getAssociativeArrayFromSQL($conn, "select * from bplace where id ='" . $stationId . "'");
											 ?>
											<tr>
												<td width="15" class="required">*</td>
												<td width="215"><label for="txtSOStation">Station</label></td>
												<td width="300">
													<input type="hidden" id="hdSOStation" name="location" value="<?php echo $city['id']; ?>" />
													<input type="text" id="txtSOStation" name="sOStation" value="<?php echo $city['category']; ?>" class="form-field" style="width:255px;" readonly="readonly" />
												</td>
											</tr>
											 <?php } ?>
											<tr>
												<td width="15" class="required">*</td>
												<td width="215">Delivery Area</td>
												<td width="300">
													<select id="sel_delivery_area" name="deliveryArea" class="form-field">
														<option value="1">Within City</option>
														<option value="2">Outside City</option>
														<option value="3">Excess Baggage Port-Port</option>
														<option value="4">Excess Baggage Door-Door</option>
													</select>
												</td>
											</tr>      
											<tr>
												<td width="15">&nbsp;</td>
												<td width="215"></td>
												<td width="300"><input type="submit" id="btnUpdateSatelliteOffice" name="submit" value="Submit" /></td>
											</tr>
										</table>
									</form>
								</td>
							</tr>
							<tr><td>&nbsp;</td></tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>
