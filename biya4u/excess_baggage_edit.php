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

	$stationExcessBaggageInfo = getAssociativeArrayFromSQL($conn, "SELECT * FROM users WHERE user_type_id = " . EXCESS_BAGGAGE_ID . " AND id = '$md_edit' ");

	$errorNo  = "";
	$errorMsg = "";

	if($_POST['submit']) {
		$excessBaggageName                = mysqli_real_escape_string($conn, $_REQUEST['excessBaggageName']);
		$city                  	          = mysqli_real_escape_string($conn, $_REQUEST['city']);
		$excessBaggagePhoneNo             = mysqli_real_escape_string($conn, $_REQUEST['excessBaggagePhoneNo']);
		$excessBaggageEmailAddress        = mysqli_real_escape_string($conn, $_REQUEST['excessBaggageEmailAddress']);
		$excessBaggageCode                = mysqli_real_escape_string($conn, $_REQUEST['excessBaggageCode']);
		$excessBaggageUsername            = mysqli_real_escape_string($conn, $_REQUEST['excessBaggageUsername']);
		$excessBaggagePassword            = mysqli_real_escape_string($conn, $_REQUEST['excessBaggagePassword']);

		$excessBaggageIdentificationType  = mysqli_real_escape_string($conn, $_REQUEST['excessBaggageIdentificationType']);
		$excessBaggageIdentificationNo    = mysqli_real_escape_string($conn, $_REQUEST['excessBaggageIdentificationNo']);

		$SQLUpdate  = " UPDATE users SET ";
		$SQLUpdate .= "   name = '$excessBaggageName', ";
		$SQLUpdate .= "   station_id = $city, ";
		$SQLUpdate .= "   phone = '$excessBaggagePhoneNo', ";
		$SQLUpdate .= "   email = '$excessBaggageEmailAddress', ";
		$SQLUpdate .= "   code = '$excessBaggageCode', ";
		$SQLUpdate .= "   username = '$excessBaggageUsername', ";
		$SQLUpdate .= "   password = '$excessBaggagePassword', ";
		$SQLUpdate .= "   identification_type = '$excessBaggageIdentificationType', ";
		$SQLUpdate .= "   identification_no = '$excessBaggageIdentificationNo', ";
		$SQLUpdate .= "   created_by = '$login_id', ";
		$SQLUpdate .= "   last_modified_date = now() ";
		$SQLUpdate .= " WHERE id = " . $md_edit;

		//$SQLInsert  = " insert into users (user_type_id, code, identification_type, identification_no, name, station_id, phone, email, username, password, creation_date, last_modified_date) ";
		//$SQLInsert .= " values (" . EXCESS_BAGGAGE_ID . ", '" . $excessBaggageCode . "', " . $excessBaggageIdentificationType . ", '" . $excessBaggageIdentificationNo . "', '" . $excessBaggageName . "', " . $city . ", '" . $excessBaggagePhoneNo . "', '" . $excessBaggageEmailAddress . "', '" . $excessBaggageUsername . "', '" . $excessBaggagePassword . "', now(), now())";
		
		echo "SQL: " . $SQLInsert . "<br>";
		
		$successInsertion = mysqli_query($conn,  $SQLUpdate );
		
		if( $successInsertion ) {
			echo "<script type=\"text/javascript\">";
			echo "	 window.opener.location.href='excess_baggage_rep.php?action=update&success=true';";
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
				$("#btnAddExcessBaggage").button();

				$("#sel_city").val("<?php echo $stationExcessBaggageInfo['station_id']; ?>");
				$("#selexcessBaggageIdentificationType").val("<?php echo $stationExcessBaggageInfo['identification_type']; ?>");

				$("#user").validate({
					rules: {
						excessBaggageName: {
							required:true
							/*
							remote: {
								url: "checkUniqueUserDetail.php",
								type: "post",
								data: {
									searchKey: "name",
									searchValue: function() {
										return $("#txtExcessBaggageName").val();
									}
								}
							}
							*/
						},
						city: {
							required:true
						},
						excessBaggagePhoneNo: 'customphone',
						excessBaggageEmailAddress: {
							required:true,
							email:true
						},
						excessBaggageUsername: {
							required : true,
							maxlength: 25,
							minlength: 4
							/*
							remote: {
								url: "uname.php",
								type: "post",
								data: {
									uname: function() {
										return $("#txtExcessBaggageUsername").val();
									}
								}
							}
							*/
						},
						excessBaggagePassword: {
							required:true,
							maxlength:25,
							minlength:4
						},
						excessBaggageConfirmPassword: {
							required:true,
							equalTo: "#txtExcessBaggagePassword",
							maxlength:25,
							minlength:4
						}
					},

					messages: {
						excessBaggageName: {
							required: "Please enter station excess baggage staff name."
							/* remote: "Name Already Exists. Please try another one." */
						},
						city: {
							required: "Excess Baggage Station should not be blank.",
						},
						excessBaggageEmailAddress: {
							required: "Please enter Email Address.",
							email: "Please enter valid Email Address."
						},
						excessBaggageUsername: {
							required: "Please enter station administrator username."
							/* remote: "Username Already Exists. Please try another one." */
						},
						excessBaggagePassword: {
							required: "Please enter password."
						},
						excessBaggageConfirmPassword: {
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
									<form action="" method="post" name="user" id="user">
										<table width="600">
											<tr>
												<td colspan="3"><img src="images/logo.png" style="margin-top: 10px;" /></td>
											</tr>
											<tr>
												<td colspan="3"><p align="center" class="textShadow" style="font-size: 14px; font-weight: bold;">Update Station Excess Baggage Details</p></td>
											</tr>
											<tr>
												<td colspan="3" height="30" valign="top">
													<i><b>Note:</b>&nbsp;&nbsp;&nbsp;
													"</i><span class="required">*</span><i>" - required field.</i>
												</td>
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
												<td width="17" class="required">*</td>
												<td width="153"><label for="txtExcessBaggageName">Name</label></td>
												<td width="435"><input type="text" id='txtExcessBaggageName' name="excessBaggageName" value="<?php echo $stationExcessBaggageInfo['name']; ?>" class="form-field" style="width:255px;"/></td>
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
												<td width="153"><label for="txtExcessBaggageStationName">Station</label></td>
												<td width="435">
													<input type="text" id="txtExcessBaggageStationName" name="excessBaggageStationName" value="<?php echo $station['category']; ?>" class="form-field" style="width:255px;" readonly="readonly" />
													<input type="hidden" id="txtExcessBaggageStationId" name="city" value="<?php echo $station['id']; ?>" />
												</td>
											</tr>
											<?php } ?>
											<tr>
												<td width="17">&nbsp;</td>
												<td width="153"><label for="txtExcessBaggagePhoneNo">Phone</label></td>
												<td width="435"><input type="text" id="txtExcessBaggagePhoneNo" name="excessBaggagePhoneNo" value="<?php echo $stationExcessBaggageInfo['phone']; ?>" class="form-field" style="width:255px;" title="Optional, but needs to follow the format for mobile no. [(0912) 345-6789, (0912) 345 6789, (0912) 3456789, (0912)3456789], telephone no. [(082) 123-4567, (2) 1234567, (82) 123 4567, (6382)1234567]." /></td>
											</tr>
											<tr>
												<td width="17" class="required">*</td>
												<td width="153"><label for="txtExcessBaggageEmailAddress">Email</label></td>
												<td><input type="text" id="txtExcessBaggageEmailAddress" name="excessBaggageEmailAddress" value="<?php echo $stationExcessBaggageInfo['email']; ?>" class="form-field" style="width:255px;" title="Required: Email Address following the format accountname@domain.com. Used for Activation and password reset." /></td>
											</tr>
											<tr>
												<td width="17">&nbsp;</td>
												<td width="153"><label for="txtExcessBaggageCode">Excess Baggage Code</label></td>
												<td width="435"><input type="text" id='txtExcessBaggageCode' name="excessBaggageCode" class="form-field" value="<?php echo $stationExcessBaggageInfo['code']; ?>" class="form-field" style="width:255px;" /></td>
											</tr>
											<tr>
												<td width="17">&nbsp;</td>
												<td width="153"><label for="selexcessBaggageIdentificationType">Identification Type</label></td>
												<td width="435">
													<select id="selexcessBaggageIdentificationType" name="excessBaggageIdentificationType" class="form-field" title="Optional field, provided identification card for verifying identity">
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
												<td width="153"><label for="txtExcessBaggageIdentificationNo">Identification No.</label></td>
												<td width="435"><input type="text" id='txtExcessBaggageIdentificationNo' name="excessBaggageIdentificationNo" class="form-field" value="<?php echo $stationExcessBaggageInfo['identification_no']; ?>" style="width:255px;" title="Optional field, Identification number of the provided document for identity verification." /></td>
											</tr>
											<tr>
												<td width="17" class="required">*</td>
												<td><label for="txtExcessBaggageUsername">Username</label></td>
												<td width="153"><input type="text" id="txtExcessBaggageUsername" name="excessBaggageUsername" value="<?php echo $stationExcessBaggageInfo['username']; ?>" class="form-field" style="width:255px;" /></td>
											</tr>
											<tr>
												<td width="17" class="required">*</td>
												<td><label for="txtExcessBaggagePassword">Password</label></td>
												<td width="153"><input type="password" id="txtExcessBaggagePassword" name="excessBaggagePassword" value="<?php echo $stationExcessBaggageInfo['password']; ?>" class="form-field" style="width:255px;" /></td>
											</tr>
											<tr>
												<td width="17" class="required">*</td>
												<td width="153"><label for="txtExcessBaggageConfirmPassword">Confirm Passsword</label></td>
												<td width="435"><input type="password" id="txtExcessBaggageConfirmPassword" name="excessBaggageConfirmPassword" value="<?php echo $stationExcessBaggageInfo['password']; ?>" class="form-field" style="width:255px;" /></td>
											</tr>           
											<tr>
												<td width="17">&nbsp;</td>
												<td width="153">&nbsp;</td>
												<td width="435"><input type="submit" id="btnAddExcessBaggage" name="submit" value="Update Station Excess Baggage Staff" style="margin-top: 20px; margin-right: 10px;" /></td>
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