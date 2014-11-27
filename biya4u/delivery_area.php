<?php 
	include('protect.php');
	include 'dbconnect.php'; 
	include('utilities.php');
	//include('constants.php');

	session_start();

	$login_id  = "";
	$login     = "";
	$type_code = "";
	$stationId = "";
	if( isset($_SESSION['login_id']) )  $login_id  = $_SESSION['login_id'];
	if( isset($_SESSION['username']) )  $login     = $_SESSION['username'];
	if( isset($_SESSION['type_code']) ) $type_code = $_SESSION['type_code'];
	if( isset($_SESSION['stationId']) ) $stationId = $_SESSION['stationId'];

	if(isset($_POST['submit'])) {
		$satelliteOffice = "";
		$soHawbPrefixCode = "";
		$sOStation = "";
		$location  = "";
		$deliveryArea  = "";

		if( isset($_POST['satelliteOffice']) )  $satelliteOffice  = $_POST['satelliteOffice'];
		if( isset($_POST['soHawbPrefixCode']) ) $soHawbPrefixCode = $_POST['soHawbPrefixCode'];
		if( isset($_POST['location']) )         $location         = $_POST['location'];
		if( isset($_POST['deliveryArea']) )     $deliveryArea     = $_POST['deliveryArea'];

		$SQLInsert = "insert into deliveryarea (city, station, delarea, station_hawb_prefix, created_by, creation_date, last_modified_date) values ('$satelliteOffice', '$location', '$deliveryArea', '$soHawbPrefixCode', $login_id, now(), now())";

		$successInsertion = mysqli_query($conn, $SQLInsert); 
		if( $successInsertion ) {
			//Delivery Area Details Submitted Successfully
			header('Location: deliveryarea_rep.php?action=add&success=true');
		}
		else {
			$errorNo  = mysqli_errno($conn);
			$errorMsg = mysqli_error($conn);
			header("HTTP/1.1 500 Internal Server Error");
			echo "<div class='errorContainer'>";
			echo "<span class='errorMessage'>Error Number: " . $errorNo . "</span><br />";
			echo "<span class='errorMessage'>Error: " . $errorMsg . "</span><br />";
			echo "</div>";
		}
	}
	
	//echo "[Type Code]: " + $type_code + "<br>";
	//echo "[Station ID]: " + $stationId + "<br>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link href="css/style.css" type="text/css"  rel="stylesheet"/>
		<link href="css/superfish.css" rel="stylesheet" media="screen">
		<link href="css/blitzer/jquery-ui-1.10.4.custom.css" rel="stylesheet">
		<title>Add Satellite Office Details</title>
		<style type="text/css">
			.style1 {font-size: large;}
		</style>
		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/jquery-ui-1.10.4.custom.min.js"></script>
		<script src="js/jquery.validate.min.js"></script>
		<script src="js/hoverIntent.js"></script>
		<script src="js/superfish.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#btnAddSatelliteOffice").button();
				var example = $('#menuCKNavigation').superfish();
				$("#formAddSatelliteOffice").validate({
					rules: {
						satelliteOffice: {
							required:true,
							maxlength: 50,
							minlength: 2,
							remote: {
								url: "checkSatelliteOfficeName.php",
								type: "post",
								data: {
									satelliteOfficeName: function() {
										return $("#txtSatelliteOffice").val();
									}
								}
							}
						},
						soHawbPrefixCode: {
							maxlength: 20,
							minlength: 2,
							remote: {
								url: "checkSatelliteOfficeHawbPrefix.php",
								type: "post",
								data: {
									soHawbPrefixCode: function() {
										return $("#txtSOHawbPrefixCode").val();
									}
								}
							}
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
							maxlength: "Please enter satellite office name with no more than 50 characters.",
							remote: "Satellite office name already exists. Please try another one."
						},
						soHawbPrefixCode: {
							minlength: "Please enter satellite office HAWB prefix code with atleast 2 characters.",
							maxlength: "Please enter satellite office HAWB prefix code with no more than 20 characters.",
							remote: "satellite office HAWB prefix code already exists. Please try another one."
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
		</script>
	</head>

	<body>
		<div align="center">
			<table width="100%" border="0" cellspacing="0" cellpadding="0"  align="center">
				<tr>
					<td>
						<table width="900" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF" >
							<tr>
								<td width="187"><?php include('adminheader.php') ?></td>
							</tr>
							<tr>
								<td>
									<table width="550" align="center">
										<tr>
											<td width="187"><p align="center" class="textShadow" style="font-size: 14px; font-weight: bold;">Add Satellite Office Details</p></td>
										</tr>
										<tr>
											<td>
												<div id="errorContainer">
													<ul />
												</div>
											</td>
										</tr>
										<tr><td>&nbsp;</td></tr>
										<tr><td>&nbsp;</td></tr>
										<tr>
											<td height="30" valign="top">
												<i><b>Note:</b>&nbsp;&nbsp;&nbsp;
												"</i><span class="required">*</span><i>" - required field.</i>
											</td>
										</tr>

										<tr>
											<td width="550">
												<form id="formAddSatelliteOffice" action="" method="post" name="user" id="user">
												<table width="100%">
													<tr>
														<td width="15" class="required">*</td>
														<td width="215"><label for="txtSatelliteOffice">Satellite Office</label></td>
														<td width="300"><input type="text"id="txtSatelliteOffice" name="satelliteOffice" class="form-field" style="width: 255px;" /></td>
													</tr>
													<tr>
														<td width="15">&nbsp;</td>
														<td width="215"><label for="txtSOHawbPrefixCode">HAWB Prefix Code</label></td>
														<td width="300"><input type="text"id="txtSOHawbPrefixCode" name="soHawbPrefixCode" class="form-field" style="width: 255px;" /></td>
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
														<td width="300"><input type="submit" id="btnAddSatelliteOffice" name="submit" value="Submit" /></td>
													</tr>
												</table>
												</form>
											</td>
										</tr>
										<tr><td width="301">&nbsp;</td></tr>
									</table>
								</td>
							</tr>
							<tr><td>&nbsp;</td></tr>
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
