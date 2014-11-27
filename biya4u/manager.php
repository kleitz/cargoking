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
		$managerName                = mysqli_real_escape_string($conn, $_REQUEST['managerName']);
		$city                       = mysqli_real_escape_string($conn, $_REQUEST['city']);
		$managerPhone               = mysqli_real_escape_string($conn, $_REQUEST['managerPhone']);
		$managerEmailAddress        = mysqli_real_escape_string($conn, $_REQUEST['managerEmailAddress']);
		$managerCode                = mysqli_real_escape_string($conn, $_REQUEST['managerCode']);
		
		$managerIdentificationType  = mysqli_real_escape_string($conn, $_REQUEST['managerIdentificationType']);
		$managerIdentificationNo    = mysqli_real_escape_string($conn, $_REQUEST['managerPassword']);
		
		$managerUsername            = mysqli_real_escape_string($conn, $_REQUEST['managerUsername']);
		$managerPassword            = mysqli_real_escape_string($conn, $_REQUEST['managerPassword']);

		$SQLInsert  = " insert into users (user_type_id, code, identification_type, identification_no, name, station_id, phone, email, username, password, creation_date, last_modified_date) ";
		$SQLInsert .= " values (" . MANAGER_ID . ", '" . $managerCode . "', " . $managerIdentificationType . ", '" . $managerIdentificationNo . "', '" . $managerName . "', " . $city . ", '" . $managerPhone . "', '" . $managerEmailAddress . "', '" . $managerUsername . "', '" . $managerPassword . "', now(), now())";
		$successInsertion = mysqli_query($conn,  $SQLInsert );

		if( $successInsertion ) {
			header('Location: manager_rep.php?action=add&success=true');
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
		$("#btnAddManager").button();
		$("#user").validate({
			rules: {
				managerName: { 
					required:true,
					remote: {
						url: "checkUniqueUserDetail.php",
						type: "post",
						data: {
							searchKey: "name",
							searchValue: function() {
								return $("#txtManagerName").val();
							}
						}
					}
				},
				city: { required:true },
				managerPhone: 'customphone',
				managerEmailAddress: {
					required:true,
					email:true
				},
				/*
				managerCode: {
					required: true
				},
				*/
				managerUsername: {
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
				managerPassword: {
					required:true,
					maxlength:25,
					minlength:4
				},
				managerRetypedPassword: {
					required:true,
					equalTo: "#txtManagerPassword",
					maxlength:25,
					minlength:4
				}
			},

			messages: {
				managerName: {
					required: "Please enter manager name.",
					remote: "Name Already Exists. Please try another one."
				},
				city: {
					required: "Please select city."
				},
				/*
				managerPhone: {
					required: "Please enter contact number."
				},
				*/
				managerEmailAddress: {
					required: "Please enter Email Address.",
					email: "Please enter valid Email Address."
				},
				/*
				managerCode: {
					required: "Please enter manager code."
				},
				*/
				managerUsername: {
					required: "Please enter manager username.",
					remote: "Username Already Exists. Please try another one."
				},
				managerPassword: {
					required: "Please enter password."
				},
				managerRetypedPassword:
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
								<ul />
							</div>
						</td>
					</tr>
					<tr>
						<td align="center">
							<div class="textShadow" style="font-size: 14px; font-weight: bold; margin-top: 20px; margin-bottom: 20px;">Add Station Manager Details</div>
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
												<td width="103"><label for="txtManagerName">Name</label></td>
												<td width="435"><input type="text" id='txtManagerName' name="managerName" class="form-field" value="" style="width:255px;" /></td>
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
												<td width="103"><label for="txtManagerPhone">Phone</label></td>
												<td width="435"><input type="text" id="txtManagerPhone" name="managerPhone" class="form-field" value="<?php echo $_REQUEST['managerPhone']; ?>" style="width:255px;" title="Optional, but needs to follow the format for mobile no. [(0912) 345-6789, (0912) 345 6789, (0912) 3456789, (0912)3456789], telephone no. [(082) 123-4567, (2) 1234567, (82) 123 4567, (6382)1234567]." /></td>
											</tr>
											<tr>
												<td width="17" class="required">*</td>
												<td><label for="txtManagerEmailAddress">Email</label></td>
												<td><input type="text" id="txtManagerEmailAddress" name="managerEmailAddress" class="form-field" value="<?php echo $_REQUEST['managerEmailAddress']; ?>" style="width:255px;" title="Required: Email Address following the format accountname@domain.com. Used for Activation and password reset." /></td>
											</tr>
											<tr>
												<td width="17">&nbsp;</td>
												<td width="103"><label for="txtManagerCode">Manager Code</label></td>
												<td width="435"><input type="text" id='txtManagerCode' name="managerCode" class="form-field" value="<?php echo $_REQUEST['managerCode']; ?>" style="width:255px;" /></td>
											</tr>
											<tr>
												<td width="17">&nbsp;</td>
												<td width="103"><label for="selManagerIdentificationType">Identification Type</label></td>
												<td width="435">
													<select id="selManagerIdentificationType" name="managerIdentificationType" class="form-field" title="Optional field, provided identification card for verifying identity">
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
												<td width="103"><label for="txtManagerIdentificationNo">Identification No.</label></td>
												<td width="435"><input type="text" id='txtManagerIdentificationNo' name="managerIdentificationNo" class="form-field" value="<?php echo $_REQUEST['managerIdentificationNo']; ?>" style="width:255px;" title="Optional field, Identification number of the provided document for identity verification." /></td>
											</tr>
											<tr>
												<td width="17" class="required">*</td>
												<td><label for="txtUsername">Username</label></td>
												<td><input type="text" id="txtUsername" name="managerUsername" value="" class="form-field" autocomplete=off style="width:255px;" /></td>
											</tr>
											<tr>
												<td width="17" class="required">*</td>
												<td><label for="txtManagerPassword">Password</label></td>
												<td><input type="password" id="txtManagerPassword" name="managerPassword" value="" class="form-field" autocomplete=off style="width:255px;" /></td>
												<td width="17">&nbsp;</td>
											</tr>
											<tr>
												<td width="17" class="required">*</td>
												<td><label for="txtManagerRetypedPassword">Confirm Passsword</label></td>
												<td><input type="password" id="txtManagerRetypedPassword" name="managerRetypedPassword" value="" class="form-field" autocomplete=off style="width:255px;" /></td>
											</tr>           
											<tr>
												<td width="17">&nbsp;</td>
												<td width="103"></td>
												<td width="435"><input type="submit" id="btnAddManager" name="submit" value="Submit" /></td>
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
