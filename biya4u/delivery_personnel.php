<?php 
	include('protect.php');
	include 'dbconnect.php'; 
	//include('paging.class.php');
	include('utilities.php');
	include('constants.php');

	session_start();
	$type_code = "";
	$stationId = "";
	if( isset($_SESSION['type_code']) ) $type_code = $_SESSION['type_code'];
	if( isset($_SESSION['stationId']) ) $stationId = $_SESSION['stationId'];

	if($_POST['submit']) {
		$deliveryPersonnelName                = mysqli_real_escape_string($conn, $_REQUEST['deliveryPersonnelName']);
		$city                  	              = mysqli_real_escape_string($conn, $_REQUEST['city']);
		$deliverPersonnelPhoneNo              = mysqli_real_escape_string($conn, $_REQUEST['deliverPersonnelPhoneNo']);
		$deliveryPersonnelEmailAddress        = mysqli_real_escape_string($conn, $_REQUEST['deliveryPersonnelEmailAddress']);
		$deliveryPersonnelCode                = mysqli_real_escape_string($conn, $_REQUEST['deliveryPersonnelCode']);
		$deliveryPersonnelUsername            = mysqli_real_escape_string($conn, $_REQUEST['deliveryPersonnelUsername']);
		$deliveryPersonnelPassword            = mysqli_real_escape_string($conn, $_REQUEST['deliveryPersonnelPassword']);

		$deliveryPersonnelIdentificationType  = mysqli_real_escape_string($conn, $_REQUEST['deliveryPersonnelIdentificationType']);
		$deliveryPersonnelIdentificationNo    = mysqli_real_escape_string($conn, $_REQUEST['deliveryPersonnelIdentificationNo']);

		$SQLInsert  = " insert into users (user_type_id, code, identification_type, identification_no, name, station_id, phone, email, username, password, creation_date, last_modified_date) ";
		$SQLInsert .= " values (" . DELIVERY_PERSONNEL_ID . ", '" . $deliveryPersonnelCode . "', " . $deliveryPersonnelIdentificationType . ", '" . $deliveryPersonnelIdentificationNo . "', '" . $deliveryPersonnelName . "', " . $city . ", '" . $deliverPersonnelPhoneNo . "', '" . $deliveryPersonnelEmailAddress . "', '" . $deliveryPersonnelUsername . "', '" . $deliveryPersonnelPassword . "', now(), now())";
		
		$successInsertion = mysqli_query($conn,  $SQLInsert );
		
		if( $successInsertion ) {
			header('Location: delivery_personnels_list.php.php?action=add&success=true');
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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
			$.validator.addMethod('customphone', function (value, element) {
				return this.optional(element) || /^\(*\d{1,4}\)*\s*\d{3}\s*-*\s*\d{4}$/.test(value);
			}, "Please enter a valid phone number");

			$(document).ready(function(){
				var sf = $('#menuCKNavigation').superfish();
				$("#btnAddDeliveryPersonnels").button();
				$("#user").validate({
					rules: {
						deliveryPersonnelName: {
							required:true,
							remote: {
								url: "checkUniqueUserDetail.php",
								type: "post",
								data: {
									searchKey: "name",
									searchValue: function() {
										return $("#txtDeliveryPersonnelName").val();
									}
								}
							}
						},
						city: {
							required:true
						},
						deliverPersonnelPhoneNo: 'customphone',
						deliveryPersonnelEmailAddress: {
							required:true,
							email:true
						},
						deliveryPersonnelUsername: {
							required : true,
							maxlength: 25,
							minlength: 4,
							remote: {
								url: "uname.php",
								type: "post",
								data: {
									uname: function() {
										return $("#txtDeliveryPersonnelUsername").val();
									}
								}
							}
						},
						deliveryPersonnelPassword: {
							required:true,
							maxlength:25,
							minlength:4
						},
						deliveryPersonnelConfirmPassword: {
							required:true,
							equalTo: "#txtDeliveryPersonnelPassword",
							maxlength:25,
							minlength:4
						}
					},

					messages: {
						deliveryPersonnelName: {
							remote: "Name Already Exists. Please try another one."
						},
						city: {
							required: "Sorter Station should not be blank.",
						},
						deliveryPersonnelEmailAddress: {
							required: "Please enter Email Address.",
							email: "Please enter valid Email Address."
						},
						deliveryPersonnelUsername: {
							required: "Please enter station administrator username.",
							remote: "Username Already Exists. Please try another one."
						},
						deliveryPersonnelPassword: {
							required: "Please enter password."
						},
						deliveryPersonnelConfirmPassword: {
							equalTo: "Please Re-Enter the Correct Password"
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
								<td>
									<div id="errorContainer">
										<ul />
									</div>
								</td>
							</tr>
							<tr>
							<td>
								<p align="center" class="textShadow" style="font-size: 14px; font-weight: bold;">Add Delivery Personnel Details</p>
								<table width="883" align="center">
									<tr>
										<td height="30" valign="top">
											<i><b>Note:</b>&nbsp;&nbsp;&nbsp;
											"</i><span class="required">*</span><i>" - required field.</i>
										</td>
									</tr>
									<tr>
										<td width="600">
											<form action="" method="post" name="user" id="user">
												<table width="600">
													<tr>
														<td width="17" class="required">*</td>
														<td width="153"><label for="txtDeliveryPersonnelName">Name</label></td>
														<td width="435"><input type="text" id='txtDeliveryPersonnelName' name="deliveryPersonnelName" value="<?php echo $_REQUEST['deliveryPersonnelName']; ?>" class="form-field" style="width:255px;"/></td>
													</tr>
													<?php if( $type_code == ADMIN ) { ?> 
													<tr>
														<td width="17" class="required">*</td>
														<td width="153"><label for="sel_city">Station</label></td>
														<td width="435"><?php generateDropdownObject($conn, "bplace","city", "form-field"); ?></td>
													</tr>
													<?php }
														if( $type_code == STATION_ADMIN ) { 
															$station = getAssociativeArrayFromSQL($conn, "select * from bplace where id='" . $stationId . "'");
													?>
													<tr>
														<td width="17" class="required">*</td>
														<td width="153"><label for="txtDeliveryPersonnelStationName">Station</label></td>
														<td width="435">
															<input type="text" id="txtDeliveryPersonnelStationName" name="deliveryPersonnelStationName" value="<?php echo $station['category']; ?>" class="form-field" style="width:255px;" readonly="readonly" />
															<input type="hidden" id="txtDeliveryPersonnelStationId" name="city" value="<?php echo $station['id']; ?>" />
														</td>
													</tr>
													<?php } ?>
													<tr>
														<td width="17">&nbsp;</td>
														<td width="153"><label for="txtDeliveryPersonnelPhoneNo">Phone</label></td>
														<td width="435"><input type="text" id="txtDeliveryPersonnelPhoneNo" name="deliverPersonnelPhoneNo" value="<?php echo $_REQUEST['deliverPersonnelPhoneNo']; ?>" class="form-field" style="width:255px;" title="Optional, but needs to follow the format for mobile no. [(0912) 345-6789, (0912) 345 6789, (0912) 3456789, (0912)3456789], telephone no. [(082) 123-4567, (2) 1234567, (82) 123 4567, (6382)1234567]." /></td>
													</tr>
													<tr>
														<td width="17" class="required">*</td>
														<td width="153"><label for="txtDeliveryPersonnelEmailAddress">Email</label></td>
														<td><input type="text" id="txtDeliveryPersonnelEmailAddress" name="deliveryPersonnelEmailAddress" class="form-field" style="width:255px;" title="Required: Email Address following the format accountname@domain.com. Used for Activation and password reset." /></td>
													</tr>
													<tr>
														<td width="17">&nbsp;</td>
														<td width="153"><label for="txtDeliveryPersonnelCode">Sorter Code</label></td>
														<td width="435"><input type="text" id='txtDeliveryPersonnelCode' name="deliveryPersonnelCode" class="form-field" value="<?php echo $_REQUEST['stationAdminCode']; ?>" class="form-field" style="width:255px;" /></td>
													</tr>
													<tr>
														<td width="17">&nbsp;</td>
														<td width="153"><label for="selDeliveryPersonnelIdentificationType">Identification Type</label></td>
														<td width="435">
															<select id="selDeliveryPersonnelIdentificationType" name="deliveryPersonnelIdentificationType" class="form-field" title="Optional field, provided identification card for verifying identity">
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
														<td width="153"><label for="txtDeliveryPersonnelIdentificationNo">Identification No.</label></td>
														<td width="435"><input type="text" id='txtDeliveryPersonnelIdentificationNo' name="deliveryPersonnelIdentificationNo" class="form-field" value="<?php echo $_REQUEST['managerIdentificationNo']; ?>" style="width:255px;" title="Optional field, Identification number of the provided document for identity verification." /></td>
													</tr>
													<tr>
														<td width="17" class="required">*</td>
														<td><label for="txtDeliveryPersonnelUsername">Username</label></td>
														<td width="153"><input type="text" id="txtDeliveryPersonnelUsername" name="deliveryPersonnelUsername" class="form-field" style="width:255px;" /></td>
													</tr>
													<tr>
														<td width="17" class="required">*</td>
														<td><label for="txtDeliveryPersonnelPassword">Password</label></td>
														<td width="153"><input type="password" id="txtDeliveryPersonnelPassword" name="deliveryPersonnelPassword" class="form-field" style="width:255px;" /></td>
													</tr>
													<tr>
														<td width="17" class="required">*</td>
														<td width="153"><label for="txtDeliveryPersonnelConfirmPassword">Confirm Passsword</label></td>
														<td width="435"><input type="password" id="txtDeliveryPersonnelConfirmPassword" name="deliveryPersonnelConfirmPassword" class="form-field" style="width:255px;" /></td>
													</tr>           
													<tr>
														<td width="17">&nbsp;</td>
														<td width="153">&nbsp;</td>
														<td width="435"><input type="submit" id="btnAddDeliveryPersonnels" name="submit" value="Submit" /></td>
													</tr>
												</table>
												</form>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td style="height: 30px;">&nbsp;</td>
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