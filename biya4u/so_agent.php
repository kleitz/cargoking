<?php 
	include('protect.php');
	include 'dbconnect.php'; 
	include('paging.class.php');
	include('utilities.php');
	include('constants.php');

	session_start();
	$type_code = "";
	$stationId = "";
	if( isset($_SESSION['type_code']) ) $type_code = $_SESSION['type_code'];
	if( isset($_SESSION['stationId']) ) $stationId = $_SESSION['stationId'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href="css/style.css" type="text/css"  rel="stylesheet"/>
	<link href="css/superfish.css" rel="stylesheet" media="screen">
	<link href="css/blitzer/jquery-ui-1.10.4.custom.css" rel="stylesheet">
	<title>Admin</title>
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/jquery-ui-1.10.4.custom.min.js"></script>
	<script src="js/jquery.validate.min.js"></script>
	<script src="js/hoverIntent.js"></script>
	<script src="js/superfish.js"></script>
	<script type="text/javascript">
	$.validator.addMethod('customphone', function (value, element) {
		return this.optional(element) || /^\(*\d{1,4}\)*\s*\d{3}\s*-*\s*\d{4}$/.test(value);
	}, "Please enter a valid phone number");

	$(document).ready(function(){
		var sf = $('#menuCKNavigation').superfish();
		$("#btnAddSOAgent").button();
		$("#user").validate({
			rules: {
				soAgentName: { 
					required:true,
					remote: {
						url: "checkUniqueUserDetail.php",
						type: "post",
						data: {
							searchKey: "name",
							searchValue: function() {
								return $("#txtSOAgentName").val();
							}
						}
					}
				},
				city: { required:true },
				soAgentPhone: 'customphone',
				soAgentEmailAddress: {
					required:true,
					email:true
				},
				/*
				soAgentCode: {
					required: true
				},
				*/
				soAgentUsername: {
					required : true,
					maxlength: 25,
					minlength: 4,
					remote: {
						url: "uname.php",
						type: "post",
						data: {
							uname: function() {
								return $("#txtUsername").val();
							}
						}
					}
				},
				soAgentPassword: {
					required:true,
					maxlength:25,
					minlength:4
				},
				soAgentRetypedPassword: {
					required:true,
					equalTo: "#txtSOAgentPassword",
					maxlength:25,
					minlength:4
				}
			},

			messages: {
				soAgentName: {
					required: "Please enter Satellite Office Agent name.",
					remote: "Name Already Exists. Please try another one."
				},
				city: {
					required: "Please select city."
				},
				/*
				soAgentPhone: {
					required: "Please enter contact number."
				},
				*/
				soAgentEmailAddress: {
					required: "Please enter Email Address.",
					email: "Please enter valid Email Address."
				},
				/*
				soAgentCode: {
					required: "Please enter Satellite Office Agent code."
				},
				*/
				soAgentUsername: {
					required: "Please enter Satellite Office Agent username.",
					remote: "Username Already Exists. Please try another one."
				},
				soAgentPassword: {
					required: "Please enter password."
				},
				soAgentRetypedPassword:
				{
					required: "Please Re-enter password.",
					equalTo:  "Please Re-Enter the Correct Password"
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
						<td width="187"><?php include('adminheader.php'); ?>	</td>
					</tr>
					<tr>
						<td>
							<div id="errorContainer">
								<p>Please fill-up all the required fields and try again:</p>
								<ul />
							</div>
						</td>
					</tr>
					<tr>
						<td align="center">
							<div class="textShadow" style="font-size: 14px; font-weight: bold; margin-top: 20px; margin-bottom: 20px;">Add Satellite Office Agent Details</div>
							<?php 
							if($_POST['submit']) {
								$soAgentName                = mysqli_real_escape_string($conn, $_REQUEST['soAgentName']);
								$city                       = mysqli_real_escape_string($conn, $_REQUEST['city']);
								$satelliteOffice            = mysqli_real_escape_string($conn, $_REQUEST['satelliteOffice']);
								$soAgentPhone               = mysqli_real_escape_string($conn, $_REQUEST['soAgentPhone']);
								$soAgentEmailAddress        = mysqli_real_escape_string($conn, $_REQUEST['soAgentEmailAddress']);
								$soAgentCode                = mysqli_real_escape_string($conn, $_REQUEST['soAgentCode']);
								
								$soAgentIdentificationType  = mysqli_real_escape_string($conn, $_REQUEST['soAgentIdentificationType']);
								$soAgentIdentificationNo    = mysqli_real_escape_string($conn, $_REQUEST['soAgentIdentificationNo']);
								
								$soAgentUsername            = mysqli_real_escape_string($conn, $_REQUEST['soAgentUsername']);
								$soAgentPassword            = mysqli_real_escape_string($conn, $_REQUEST['soAgentPassword']);

								if( "" == $city && "" != $stationId ){
									$city = $stationId;
								}
								
								$SQLInsert  = " insert into users (user_type_id, code, identification_type, identification_no, firstname, station_id, satellite_office_id, phone, email, username, password, creation_date, last_modified_date) ";
								$SQLInsert .= " values (" . SO_AGENT_ID . ", '" . $soAgentCode . "', " . $soAgentIdentificationType . ", '" . $soAgentIdentificationNo . "', '" . $soAgentName . "', " . $city . ", '" . $satelliteOffice . "', '" . $soAgentPhone . "', '" . $soAgentEmailAddress . "', '" . $soAgentUsername . "', '" . $soAgentPassword . "', now(), now())";
								$successInsertion = mysqli_query($conn,  $SQLInsert );

								echo "[SQL INSERT]: " . $SQLInsert . "<br>";
								
								if( $successInsertion ) {
									header('Location: so_agent_rep.php?action=add&success=true');
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
							<table width="883" align="center">
								<tr>
									<td height="30" valign="top">
										<i><b>Note:</b>&nbsp;&nbsp;&nbsp;
										"</i><span class="required">*</span><i>" - required field.</i>
									</td>
								</tr>
								<tr>
									<td width="570">
										<form id="user" name="user" action="" method="post">
										<table width="721">
											<tr>
												<td width="17" class="required">*</td>
												<td width="103"><label for="txtSOAgentName">Name</label></td>
												<td width="435"><input type="text" id='txtSOAgentName' name="soAgentName" class="form-field" value="" style="width:255px;" /></td>
											</tr>
										   <?php 	if( $type_code == ADMIN ) { ?> 
											<tr>
												<td width="17" class="required">*</td>
												<td width="103"><label for="sel_city">Station</label></td>
												<td width="435"><?php generateDropdownObject($conn, "area_location", "area_name", "form-field"); ?></td>
											</tr>
											<?php 
													}
													
													if( $type_code == STATION_ADMIN ) {
														//Get Station Info from user station id.
														$city = getAssociativeArrayFromSQL($conn, "select * from area_location where id ='" . $stationId . "'");
											 ?>
											<tr>
												<td width="17" class="required">*</td>
												<td width="103"><label for="txtSOAgentVCity">Station</label></td>
												<td width="435">
													<input type="hidden" id="hdSOAgentCity" name="city" value="<?php echo $city['id']; ?>" />
													<input type="text" id="txtSOAgentVCity" name="vcity" value="<?php echo $city['area_name']; ?>" class="form-field" style="width:255px;" readonly="readonly" />
												</td>
											</tr>
										   <?php } ?>
											<tr>
												<td width="17" class="required">*</td>
												<td width="103"><label for="txtSOAgentVCity">Satellite Office</label></td>
												<td width="435">
													<?php 
														$stationFilter = "";
														if( $stationId > 0 )  $stationFilter = "station = " . $stationId;
														generateSelectObject($conn,  "delivery_area", "id", "area", $stationFilter, "satelliteOffice", "form-field" );
													?>
												</td>
											</tr>
											<tr>
												<td width="17">&nbsp;</td>
												<td width="103"><label for="txtSOAgentPhone">Phone</label></td>
												<td width="435"><input type="text" id="txtSOAgentPhone" name="soAgentPhone" class="form-field" value="<?php echo $_REQUEST['soAgentPhone']; ?>" style="width:255px;" title="Optional, but needs to follow the format for mobile no. [(0912) 345-6789, (0912) 345 6789, (0912) 3456789, (0912)3456789], telephone no. [(082) 123-4567, (2) 1234567, (82) 123 4567, (6382)1234567]." /></td>
											</tr>
											<tr>
												<td width="17" class="required">*</td>
												<td><label for="txtSOAgentEmailAddress">Email</label></td>
												<td><input type="text" id="txtSOAgentEmailAddress" name="soAgentEmailAddress" class="form-field" value="<?php echo $_REQUEST['soAgentEmailAddress']; ?>" style="width:255px;" title="Required: Email Address following the format accountname@domain.com. Used for Activation and password reset." /></td>
											</tr>
											<tr>
												<td width="17">&nbsp;</td>
												<td width="103"><label for="txtSOAgentCode">Agent Code</label></td>
												<td width="435"><input type="text" id='txtSOAgentCode' name="soAgentCode" class="form-field" value="<?php echo $_REQUEST['soAgentCode']; ?>" style="width:255px;" /></td>
											</tr>
											<tr>
												<td width="17">&nbsp;</td>
												<td width="103"><label for="selSOAgentIdentificationType">Identification Type</label></td>
												<td width="435">
													<select id="selSOAgentIdentificationType" name="soAgentIdentificationType" class="form-field" title="Optional field, provided identification card for verifying identity">
														<option value="-1">--[Select]--</option>
														<option value="1">Company ID</option>
														<option value="2">PHILHEALTH ID</option>
														<option value="3">Drivers License ID</option>
														<option value="4">SSS ID</option>
														<option value="5">GSIS ID</option>
														<option value="6">Passport</option>
														<option value="7">Others</option>
													</select>
												</td>
											</tr>
											<tr>
												<td width="17">&nbsp;</td>
												<td width="103"><label for="txtSOAgentIdentificationNo">Identification No.</label></td>
												<td width="435"><input type="text" id='txtSOAgentIdentificationNo' name="soAgentIdentificationNo" class="form-field" value="<?php echo $_REQUEST['soAgentIdentificationNo']; ?>" style="width:255px;" title="Optional field, Identification number of the provided document for identity verification." /></td>
											</tr>
											<tr>
												<td width="17" class="required">*</td>
												<td><label for="txtUsername">Username</label></td>
												<td><input type="text" id="txtUsername" name="soAgentUsername" value="" class="form-field" autocomplete=off style="width:255px;" /></td>
											</tr>
											<tr>
												<td width="17" class="required">*</td>
												<td><label for="txtSOAgentPassword">Password</label></td>
												<td><input type="password" id="txtSOAgentPassword" name="soAgentPassword" value="" class="form-field" autocomplete=off style="width:255px;" /></td>
												<td width="17">&nbsp;</td>
											</tr>
											<tr>
												<td width="17" class="required">*</td>
												<td><label for="txtSOAgentRetypedPassword">Confirm Passsword</label></td>
												<td><input type="password" id="txtSOAgentRetypedPassword" name="soAgentRetypedPassword" value="" class="form-field" autocomplete=off style="width:255px;" /></td>
											</tr>  
											<tr>
												<td width="17">&nbsp;</td>
												<td width="103"></td>
												<td width="435"><input type="submit" id="btnAddSOAgent" name="submit" value="Submit" /></td>
											</tr>
										</table>
										</form>
									</td>
								</tr>
								<tr>
									<td width="301">&nbsp;</td>
								</tr>
							</table>
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
