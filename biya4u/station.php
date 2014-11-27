<?php 
	include('protect.php');
	include 'dbconnect.php'; 
	//include('paging.class.php');
	include('utilities.php');
	include('constants.php');

	session_start();
	$type_code = $_SESSION['type_code'];
	$stationId = $_SESSION['stationId'];
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
				$("#btnAddStation").button();
				$("#frmStationAdmin").validate({
					rules: {
						stationAdminName: {
							required:true,
							remote: {
								url: "checkUniqueUserDetail.php",
								type: "post",
								data: {
									searchKey: "name",
									searchValue: function() {
										return $("#txtStationAdminName").val();
									}
								}
							}
						},
						city: {
							required:true
						},
						stationAdminPhone: 'customphone',
						stationAdminEmailAddress: {
							required:true,
							email:true
						},
						/*
						stationAdminCode: {
							required: true
						},
						*/
						stationAdminUsername: {
							required : true,
							maxlength: 25,
							minlength: 4,
							remote: {
								url: "uname.php",
								type: "post",
								data: {
									uname: function() {
										return $("#txtStationAdminUsername").val();
									}
								}
							}
						},
						stationAdminPassword: {
							required:true,
							maxlength:25,
							minlength:4
						},
						stationAdminRetypedPassword: {
							required:true,
							equalTo: "#txtStationAdminPassword",
							maxlength:25,
							minlength:4
						}
					},

					messages: {
						stationAdminName: {
							required: "Please enter station admininstrator name.",
							remote: "Name Already Exists. Please try another one."
						},
						city: {
							required: "Please select station or city."
						},
						/*
						stationAdminPhone: {
							required: "Please enter contact number."
						},
						*/
						stationAdminEmailAddress: {
							required: "Please enter Email Address.",
							email: "Please enter valid Email Address."
						},
						/*
						stationAdminCode: {
							required: "Please enter station administrator code."
						},
						*/
						stationAdminUsername: {
							required: "Please enter station administrator username.",
							remote: "Username Already Exists. Please try another one."
						},
						stationAdminPassword: {
							required: "Please enter password."
						},
						stationAdminRetypedPassword:
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
								<td width="187"><?php include('adminheader.php') ?>	</td>
							</tr>
							<tr>
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
									<div class="textShadow" style="font-size: 14px; font-weight: bold; margin-top: 20px; margin-bottom: 20px;">Add Station Administrator Details</div>
									<span class="">
									<?php 
										if($_POST['submit']) {
											$stationAdminName                = mysqli_real_escape_string($conn, $_REQUEST['stationAdminName']);
											$city                  		     = mysqli_real_escape_string($conn, $_REQUEST['city']);
											$stationAdminPhone               = mysqli_real_escape_string($conn, $_REQUEST['stationAdminPhone']);
											$stationAdminEmailAddress        = mysqli_real_escape_string($conn, $_REQUEST['stationAdminEmailAddress']);
											$stationAdminCode                = mysqli_real_escape_string($conn, $_REQUEST['stationAdminCode']);
											$stationAdminUsername            = mysqli_real_escape_string($conn, $_REQUEST['stationAdminUsername']);
											$stationAdminPassword            = mysqli_real_escape_string($conn, $_REQUEST['stationAdminPassword']);

											$stationAdminIdentificationType  = mysqli_real_escape_string($conn, $_REQUEST['stationAdminIdentificationType']);
											$stationAdminIdentificationNo    = mysqli_real_escape_string($conn, $_REQUEST['stationAdminIdentificationNo']);

											$SQLInsert  = " insert into users (user_type_id, code, identification_type, identification_no, name, station_id, phone, email, username, password, creation_date, last_modified_date) ";
											$SQLInsert .= " values (" . STATION_ADMIN_ID . ", '" . $stationAdminCode . "', " . $stationAdminIdentificationType . ", '" . $stationAdminIdentificationNo . "', '" . $stationAdminName . "', " . $city . ", '" . $stationAdminPhone . "', '" . $stationAdminEmailAddress . "', '" . $stationAdminUsername . "', '" . $stationAdminPassword . "', now(), now())";
											$successInsertion = mysqli_query($conn,  $SQLInsert );

											if( $successInsertion ) {
												echo "<script type=\"text/javascript\">";
												echo "	self.location='station_rep.php?action=add&success=true';";
												echo "</script>";
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
									</span>
									<table width="883" align="center">									
										<tr>
											<td height="30" valign="top">
												<i><b>Note:</b>&nbsp;&nbsp;&nbsp;
												"</i><span class="required">*</span><i>" - required field.</i>
											</td>
										</tr>
										<tr>
											<td width="600">
												<form action="" method="post" name="user" id="frmStationAdmin">
												<table width="600">
													<tr>
														<td width="17" class="required">*</td>
														<td width="153"><label for="txtStationAdminName">Name</label></td>
														<td width="435"><input type="text" id='txtStationAdminName' name="stationAdminName" value="<?php echo $_REQUEST['nam']; ?>" class="form-field"  onkeyup="showHint(this.value)" style="width:255px;"/></td>
													</tr>
													<?php 	if( $type_code == ADMIN ) { ?> 
													<tr>
														<td width="17" class="required">*</td>
														<td width="153"><label for="sel_city">Station</label></td>
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
														<td width="103"><label for="txtManagerVCity">City</label></td>
														<td width="435">
															<input type="hidden" id="hdManagerCity" name="city" value="<?php echo $city['id']; ?>" />
															<input type="text" id="txtManagerVCity" name="vcity" value="<?php echo $city['category']; ?>" class="form-field" style="width:255px;" readonly="readonly" />
														</td>
													</tr>
												   <?php } ?>
													<tr>
														<td width="17">&nbsp;</td>
														<td width="153"><label for="txtStationAdminPhone">Phone</label></td>
														<td width="435"><input type="text" id="txtStationAdminPhone" name="stationAdminPhone" value="<?php echo $_REQUEST['phone']; ?>" class="form-field" style="width:255px;" title="Optional, but needs to follow the format for mobile no. [(0912) 345-6789, (0912) 345 6789, (0912) 3456789, (0912)3456789], telephone no. [(082) 123-4567, (2) 1234567, (82) 123 4567, (6382)1234567]."/></td>
													</tr>
													<tr>
														<td width="17" class="required">*</td>
														<td width="153"><label for="txtStationAdminEmailAddress">Email</label></td>
														<td width="435"><input type="text" id="txtStationAdminEmailAddress" name="stationAdminEmailAddress" class="form-field" style="width:255px;" title="Required: Email Address following the format accountname@domain.com. Used for Activation and password reset." /></td>
													</tr>
													<tr>
														<td width="17">&nbsp;</td>
														<td width="153"><label for="txtStationAdminCode">Station Admin Code</label></td>
														<td width="435"><input type="text" id='txtStationAdminCode' name="stationAdminCode" class="form-field" value="<?php echo $_REQUEST['stationAdminCode']; ?>" class="form-field" style="width:255px;" /></td>
													</tr>
													<tr>
														<td width="17">&nbsp;</td>
														<td width="153"><label for="selStationAdminIdentificationType">Identification Type</label></td>
														<td width="435">
															<select id="selStationAdminIdentificationType" name="stationAdminIdentificationType" class="form-field" title="Optional field, provided identification card for verifying identity">
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
														<td width="153"><label for="txtStationAdminIdentificationNo">Identification No.</label></td>
														<td width="435"><input type="text" id='txtStationAdminIdentificationNo' name="stationAdminIdentificationNo" class="form-field" value="<?php echo $_REQUEST['managerIdentificationNo']; ?>" style="width:255px;" title="Optional field, Identification number of the provided document for identity verification." /></td>
													</tr>
													<tr>
														<td width="17" class="required">*</td>
														<td width="153"><label for="txtStationAdminUsername">Username</label></td>
														<td width="153"><input type="text" id="txtStationAdminUsername" name="stationAdminUsername" class="form-field" autocomplete=off style="width:255px;" /></td>
													</tr>
													<tr>
														<td width="17" class="required">*</td>
														<td width="153"><label for="txtStationAdminPassword">Password</label></td>
														<td width="435"><input type="password" id="txtStationAdminPassword" name="stationAdminPassword" class="form-field" autocomplete=off style="width:255px;" /></td>
													</tr>
													<tr>
														<td width="17" class="required">*</td>
														<td width="153"><label for="txtStationAdminRetypedPassword">Confirm Passsword</label></td>
														<td width="435"><input type="password" id="txtStationAdminRetypedPassword" name="stationAdminRetypedPassword" class="form-field" autocomplete=off style="width:255px;" /></td>
													</tr>           
													<tr>
														<td width="17">&nbsp;</td>
														<td width="153">&nbsp;</td>
														<td width="435"><input type="submit" id="btnAddStation" name="submit" value="Submit" /></td>
													</tr>
												</table>
												</form>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr><td >&nbsp;</td></tr>
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
