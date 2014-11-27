<?php 
	include('protect.php');
	include 'dbconnect.php'; 
	//include('paging.class.php');
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

	$soAgentInfo = getAssociativeArrayFromSQL($conn, "SELECT * FROM users WHERE user_type_id = " . SO_AGENT_ID . " AND id = '$md_edit' ");

	$errorNo  = "";
	$errorMsg = "";

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

		$SQLUpdate  = " UPDATE users SET ";
		$SQLUpdate .= "   name = '$soAgentName', ";
		$SQLUpdate .= "   station_id = $city, ";
		$SQLUpdate .= "   satellite_office_id = '$satelliteOffice', ";
		$SQLUpdate .= "   phone = '$soAgentPhone', ";
		$SQLUpdate .= "   email = '$soAgentEmailAddress', ";
		$SQLUpdate .= "   code = '$soAgentCode', ";
		$SQLUpdate .= "   username = '$soAgentUsername', ";
		$SQLUpdate .= "   password = '$soAgentPassword', ";
		$SQLUpdate .= "   identification_type = '$soAgentIdentificationType', ";
		$SQLUpdate .= "   identification_no = '$soAgentIdentificationNo', ";
		$SQLUpdate .= "   created_by = '$login_id', ";
		$SQLUpdate .= "   last_modified_date = now() ";
		$SQLUpdate .= " WHERE id = " . $md_edit;

		//echo "[SQL Udate]: " . $SQLUpdate . "<br>";
		$successUpdate = mysqli_query($conn,  $SQLUpdate );
		
		if( $successUpdate ) {
			echo "<script type=\"text/javascript\">";
			echo "	 window.opener.location.href='so_agent_rep.php?action=update&success=true';";
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

			$("#sel_city").val("<?php echo $soAgentInfo['station_id']; ?>");
			$("#sel_satelliteOffice").val("<?php echo $soAgentInfo['satellite_office_id']; ?>");
			$("#selSOAgentIdentificationType").val("<?php echo $soAgentInfo['identification_type']; ?>");

			$("#user").validate({
				rules: {
					soAgentName: { 
						required:true
						/*
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
						*/
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
						minlength: 4
						/*
						remote: {
							url: "uname.php",
							type: "post",
							data: {
								uname: function() {
									return $("#txtUsername").val();
								}
							}
						}
						*/
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
						required: "Please enter Satellite Office Agent name."
						/* remote: "Name Already Exists. Please try another one." */
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
						required: "Please enter Satellite Office Agent username."
						/* remote: "Username Already Exists. Please try another one." */
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
						<table width="700" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF" style="border-radius:15px;">
							<tr>
								<td align="center">
									<form id="user" name="user" action="" method="post">
										<table width="600">
											<tr>
												<td colspan="3"><img src="images/logo.png" style="margin-top: 10px;" /></td>
											</tr>
											<tr>
												<td colspan="3"><p align="center" class="textShadow" style="font-size: 14px; font-weight: bold;">Update Satellite Office Agent Details</p></td>
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
												<td width="17" class="required">*</td>
												<td width="103"><label for="txtSOAgentName">Name</label></td>
												<td width="435"><input type="text" id='txtSOAgentName' name="soAgentName" class="form-field" value="<?php echo $soAgentInfo['name']; ?>" style="width:255px;" /></td>
											</tr>
										   <?php 	if( $type_code == ADMIN ) { ?> 
											<tr>
												<td width="17" class="required">*</td>
												<td width="103"><label for="sel_city">Station</label></td>
												<td width="435"><?php generateDropdownObject($conn, "bplace", "city", "form-field"); ?></td>
											</tr>
											<?php 
													}
													
													if( $type_code == STATION_ADMIN ) {
														//Get Station Info from user station id.
														$city = getAssociativeArrayFromSQL($conn, "select * from bplace where id ='" . $stationId . "'");
											 ?>
											<tr>
												<td width="17" class="required">*</td>
												<td width="103"><label for="txtSOAgentVCity">Station</label></td>
												<td width="435">
													<input type="hidden" id="hdSOAgentCity" name="city" value="<?php echo $city['id']; ?>" />
													<input type="text" id="txtSOAgentVCity" name="vcity" value="<?php echo $city['category']; ?>" class="form-field" style="width:255px;" readonly="readonly" />
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
														generateSelectObject($conn,  "deliveryarea", "id", "city", $stationFilter, "satelliteOffice", "form-field" );
													?>
												</td>
											</tr>
											<tr>
												<td width="17">&nbsp;</td>
												<td width="103"><label for="txtSOAgentPhone">Phone</label></td>
												<td width="435"><input type="text" id="txtSOAgentPhone" name="soAgentPhone" class="form-field" value="<?php echo $soAgentInfo['phone']; ?>" style="width:255px;" title="Optional, but needs to follow the format for mobile no. [(0912) 345-6789, (0912) 345 6789, (0912) 3456789, (0912)3456789], telephone no. [(082) 123-4567, (2) 1234567, (82) 123 4567, (6382)1234567]." /></td>
											</tr>
											<tr>
												<td width="17" class="required">*</td>
												<td><label for="txtSOAgentEmailAddress">Email</label></td>
												<td><input type="text" id="txtSOAgentEmailAddress" name="soAgentEmailAddress" class="form-field" value="<?php echo $soAgentInfo['email']; ?>" style="width:255px;" title="Required: Email Address following the format accountname@domain.com. Used for Activation and password reset." /></td>
											</tr>
											<tr>
												<td width="17">&nbsp;</td>
												<td width="103"><label for="txtSOAgentCode">Agent Code</label></td>
												<td width="435"><input type="text" id='txtSOAgentCode' name="soAgentCode" class="form-field" value="<?php echo $soAgentInfo['code']; ?>" style="width:255px;" /></td>
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
												<td width="435"><input type="text" id='txtSOAgentIdentificationNo' name="soAgentIdentificationNo" class="form-field" value="<?php echo $soAgentInfo['identification_no']; ?>" style="width:255px;" title="Optional field, Identification number of the provided document for identity verification." /></td>
											</tr>
											<tr>
												<td width="17" class="required">*</td>
												<td><label for="txtUsername">Username</label></td>
												<td><input type="text" id="txtUsername" name="soAgentUsername" value="<?php echo $soAgentInfo['username']; ?>" class="form-field" autocomplete=off style="width:255px;" /></td>
											</tr>
											<tr>
												<td width="17" class="required">*</td>
												<td><label for="txtSOAgentPassword">Password</label></td>
												<td><input type="password" id="txtSOAgentPassword" name="soAgentPassword" value="<?php echo $soAgentInfo['password']; ?>" class="form-field" autocomplete=off style="width:255px;" /></td>
												<td width="17">&nbsp;</td>
											</tr>
											<tr>
												<td width="17" class="required">*</td>
												<td><label for="txtSOAgentRetypedPassword">Confirm Passsword</label></td>
												<td><input type="password" id="txtSOAgentRetypedPassword" name="soAgentRetypedPassword" value="<?php echo $soAgentInfo['password']; ?>" class="form-field" autocomplete=off style="width:255px;" /></td>
											</tr>           
											<tr>
												<td width="17">&nbsp;</td>
												<td width="103"></td>
												<td width="435"><input type="submit" id="btnAddSOAgent" name="submit" value="Update Satellite Office Agent" /></td>
											</tr>
										</table>
									</form>
								</td>
							</tr>
						</table>
					</td>        
				</tr>
				<tr>
					<td><?php include('adminfooter.php') ?></td>
				</tr>
			</table>
		</div>
	</body>
</html>
