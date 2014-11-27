<?php 
	include('protect.php');
	include 'dbconnect.php'; 

	session_start();

	$login_id     = "";
	$type_code = "";
	$stationId = "";
	if( isset($_SESSION['login_id']) )  $login_id  = $_SESSION['login_id'];
	if( isset($_SESSION['type_code']) ) $type_code = $_SESSION['type_code'];
	if( isset($_SESSION['stationId']) ) $stationId = $_SESSION['stationId'];

	$action = "";
	$success = "";
	if( isset($_REQUEST['action']) ) $action = $_REQUEST['action'];
	if( isset($_REQUEST['success']) ) $success = $_REQUEST['success'];
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
		<script src="js/jquery.validate.min.js"></script>
		<script src="js/jquery-ui-1.10.4.custom.min.js"></script>
		<script src="js/hoverIntent.js"></script>
		<script src="js/superfish.js"></script>
		<script type="text/javascript">

			var action = "<?php echo $action; ?>";
			var success = "<?php echo $success; ?>";

			$(document).ready(function(){
			$("#btnSubmitPlateNumber").button();
				var sf = $('#menuCKNavigation').superfish();
				$("#formPlateNumber").validate({
					rules: {
						plateNumber: {
							required:true,
							maxlength: 10,
							minlength: 4,
							remote: {
								url: "checkVehiclePlateNo.php",
								type: "post",
								data: {
									vehiclePlateNo: function() {
										return $("#txtPlateNumber").val();
									}
								}
							}
						}
						
					},

					messages: {
						plateNumber: {
							required: "Please fill the vehicle plate number.",
							maxlength: "The maximum length of vehicle number should not exceed 10 characters.",
							minlength: "The minimum length of vehicle numbert should be 4 characters.",
							remote: "Vehicle number Already Exists. Please try another one."
						},
						
					},

					errorContainer: $('#errorContainer'),
					errorLabelContainer: $('#errorContainer ul'),
					wrapper: 'li'
				});

				if( action == "add" && success == "true"){
					$("#trStatusDisplay").show();
					$("#divStatusMessage").html("Successfully added a vehicle.").show();
				}
				else if( action == "delete" && success == "true"){
					$("#trStatusDisplay").show();
					$("#divStatusMessage").html("Successfully deleted a vehicle.").show();
				}
				else if( action == "delete" && success == "false"){
					$("#trStatusDisplay").show();
					$("#divStatusMessage").html("Cannot deleted active vehicle.").show();
				}
				else {
					$("#divStatusMessage").hide();
					$("#trStatusDisplay").hide();
				}

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
									<div id="errorContainer">
										<ul />
									</div>
								</td>
							</tr>
							<tr><td><p align="center" class="style1">Vehicle Details</p></td></tr>
							<tr id="trStatusDisplay">
								<td style="padding: 0px 12px;">
									<div id="divStatusMessage"></div>
								</td>
							</tr>
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td>
									<?php 

									if($_POST['submit']) {
									
									echo "hello<br>";
									
										$plateNumber = mysqli_real_escape_string($conn, $_REQUEST['plateNumber']);
										$modelYear = mysqli_real_escape_string($conn, $_REQUEST['modelYear']);
										$vehicleRemarks = mysqli_real_escape_string($conn, $_REQUEST['vehicleRemarks']);

										$SQLInsert  = " insert into vec (plate_no, model_year, remarks, creation_date, last_modified_date) ";
										$SQLInsert .= " values ('" . $plateNumber . "', '" . $modelYear . "', '" . $vehicleRemarks . "', now(), now())";
										$successInsertion = mysqli_query($conn,  $SQLInsert );

										if( $successInsertion ) {
									?> 
										<script type="text/javascript">
											alert("Successfully added a vehicle!");
											self.location='vec_rep1.php?action=add&succes=true';
										</script>
									<?php
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
									?>
									<form id="formPlateNumber" name="formPlateNumber" action="" method="post">
										<table align="center">
											<tr>
												<td width="132" valign="top"><label for="txtPlateNumber">Vehicle Plate Number</label></td>
												<td width="144">
													<input type="text" id='txtPlateNumber' name="plateNumber" value="<?php echo $_REQUEST['PlateNumber']; ?>" class="form-field" style="width:250px;" title="Vehicle Plate Number (eg. MEH698)." />
												</td>
											</tr>
											<tr>
												<td width="132" valign="top">Model and Year</td>
												<td width="144">
													<input type="text" id='txtModelYear' name="modelYear" value="<?php echo $_REQUEST['typeOfShipmentCode']; ?>" class="form-field" style="width:250px;" title="Type of Shipment code(Not required)." />
												</td>
											</tr>
											<tr>
												<td width="132" valign="top">Remarks</td>
												<td width="144">
													<textarea id='txtVehicleRemarks' name="vehicleRemarks" style="width:250px;" class="form-field" title="Type of Shipment remarks(Not required)."><?php echo $_REQUEST['typeOfShipmentRemarks']; ?></textarea>
												</td>
											</tr>
											<tr>
												<td width="132">&nbsp;</td>
												<td width="144"><input type="submit" name="submit" value="Submit" id="btnSubmitPlateNumber" style="margin-top: 15px;" /></td>
											</tr>
										</table>
									</form>
								</td>
							</tr>
							<tr>
								<td >&nbsp;</td>
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
