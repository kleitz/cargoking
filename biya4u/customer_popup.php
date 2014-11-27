<?php 
	include('protect.php');
	include('dbconnect.php'); 
	include('utilities.php');
	include('constants.php');

	session_start();

	$action = "";
	$success = "";
	if( isset($_REQUEST['action']) ) $action = $_REQUEST['action'];
	if( isset($_REQUEST['success']) ) $success = $_REQUEST['success'];

	$stationId = "";	
	$satelliteOfficeId = "";	
	if( isset($_SESSION['stationId']) )           $stationId         = $_SESSION['stationId'];
	if( isset($_SESSION['satellite_office_id']) ) $satelliteOfficeId = $_SESSION['satellite_office_id'];

	//echo "[STATION-ID]: " . $stationId . "<br>";
	//echo "[SATELLITE-OFFICE-ID]: " . $satelliteOfficeId . "<br>";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link href="css/style.css" type="text/css"  rel="stylesheet"/>
		<link href="css/superfish.css" rel="stylesheet" media="screen">
		<link href="css/flat/red.css" rel="stylesheet" media="screen">
		<link href="css/blitzer/jquery-ui-1.10.4.custom.css" rel="stylesheet">
		<title>Admin</title>
		<style type="text/css">
			.style1 {font-size: large;}
		</style>
		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/jquery-ui-1.10.4.custom.min.js"></script>
		<script src="js/jquery.validate.min.js"></script>
		<script src="js/jquery.bpopup.min.js"></script>
		<script src="js/hoverIntent.js"></script>
		<script src="js/superfish.js"></script>
		<script src="js/icheck.min.js"></script>
		<script type="text/javascript">

			var action = "<?php echo $action; ?>";
			var success = "<?php echo $success; ?>";

			$.validator.addMethod('customphone', function (value, element) {
				return this.optional(element) || /^\(*\d{1,4}\)*\s*\d{3}\s*-*\s*\d{4}$/.test(value);
			}, "Please enter a valid phone number");

			var showHidePercentageField = function(isDiscounted){
				if( isDiscounted ){
					$("#trCustomerPercentage").show();
					$("#txtCustomerPercentageDiscount").focus();
				}
				else {
					$("#trCustomerPercentage").hide();
				}
			};

			var setDiscountedCheckboxWhenPercentageIsSet = function(){
				var percentage = $("#txtCustomerPercentageDiscount").val();
				if( Number(percentage) > 0){
					$("#chkDiscountedCustomer").iCheck("check");
					$("#trCustomerPercentage").show();
				}
				else {
					$("#chkDiscountedCustomer").iCheck("uncheck");
					$("#trCustomerPercentage").hide();
				}
			};

			var setAddCustomerStatus = function(action, success){
				if( action == "add" && success == "true"){
					$("#trStatusDisplay").show();
					$("#divStatusMessage").html("Successfully added a customer.").show();
				}
				else if( action == "delete" && success == "true"){
					$("#trStatusDisplay").show();
					$("#divStatusMessage").html("Successfully deleted a customer.").show();
				}
				else if( action == "delete" && success == "false"){
					$("#trStatusDisplay").show();
					$("#divStatusMessage").html("Cannot delete customer.").show();
				}
				/*
				else {
					$("#divStatusMessage").hide();
					$("#trStatusDisplay").hide();
				}
				*/
			};

			var reloadUpdateCustomerWindow = function(){
				console.log("reloadUpdateCustomerWindow()");
				window.opener.location.href="customer_rep.php?action=update&success=true";
				window.close();
			};
			
			$(document).ready(function(){
				/* Initialize components/objects */
				var sf = $('#menuCKNavigation').superfish();
				$("#chkDiscountedCustomer").iCheck({ checkboxClass: 'icheckbox_flat-red' });
				$("#btnAddCustomer").button();
				$("#sel_customerStation").val("<?php echo $stationId; ?>");
				$("#sel_satelliteOffice").val("<?php echo $satelliteOfficeId; ?>");

				/* Call functions */
				setAddCustomerStatus(action, success);
				setDiscountedCheckboxWhenPercentageIsSet();

				/* Bind events to components/objects */

				//Get list of satellite offices based on the selected station.
				$("#sel_customerStation").bind("change", function(){
					console.log("Station: " + $(this).val());
					$.ajax({
						type: "GET",
						url: "ajaxSatelliteOffices.php",
						data: "station_id=" + $(this).val(),
						success: function(returnHtml) {
							$("#sel_satelliteOffice").html(returnHtml);
						}
					});
				});
				
				//Hide percentage field when discounted checkbox is not checked.
				$("#chkDiscountedCustomer").on("ifChanged", function(){
					showHidePercentageField( $(this).is(":checked") )
				});

				/*
				$("#btnClearCustomer").bind("click", function(){
					$("#chkDiscountedCustomer").iCheck("uncheck");
					$("#sel_satelliteOffice").html("<option value=\"\">--[Select]--</option>");
					$("#divStatusMessage").html("").hide();
					$("#errorContainer").hide();
					$("#trStatusDisplay").hide();
					$("#formCustomer").trigger("reset");
				});
				*/

				/* Form validations */
				$("#formCustomer").validate({
					rules: {
						customerFirstName: {
							required:true,
							maxlength: 50,
							minlength: 2,
							remote: {
								url: "checkCustomerName.php",
								type: "post",
								data: {
									customerName: function() {
										return $("#txtCustomerFirstName").val() + " " + $("#txtCustomerLastName").val();
									}
								}
							}
						},
						customerLastName: { 
							required:true,
							maxlength: 50,
							minlength: 2,
							remote: {
								url: "checkCustomerName.php",
								type: "post",
								data: {
									customerName: function() {
										return $("#txtCustomerFirstName").val() + " " + $("#txtCustomerLastName").val();
									}
								}
							}
						},
						customerStation: { required:true },
						satelliteOffice: { required:true },
						customerPhone: 'customphone',
						customerEmail: { email:true },
						customerPercentageDiscount: { number: true }
					},

					messages: {
						customerFirstName: {
							required: "Please enter customer first name.",
							minlength: "Please enter customer first name with atleast 2 characters.",
							maxlength: "Please enter customer first name with no more than 50 characters.",
							remote: "Customer first name already exists. Please try another one."
						},
						customerLastName: {
							required: "Please enter customer last name.",
							minlength: "Please enter customer last name with atleast 2 characters.",
							maxlength: "Please enter customer last name with no more than 50 characters.",
							remote: "Customer last name already exists. Please try another one."
						},
						customerStation: {
							required: "Please select station or city."
						},
						satelliteOffice: {
							required: "Please select satellite office."
						},
						customerEmail: {
							email: "Please enter valid Email Address."
						},
						customerPercentageDiscount: { number: "Please enter valid percentage value." }
					},

					errorContainer: $('#errorContainer'),
					errorLabelContainer: $('#errorContainer ul'),
					wrapper: 'li'
				});
				/* END */
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
								<td>
								<div>
									<img src="images/logo.png" style="margin-top: 10px; margin-left: 10px;" />
									<div class="style1" style="display: inline-block; margin-left: 50px; margin-bottom: 10px;">Add Customer</div>
									<img id="imgClose" src="images/close.png" style="position: relative; top: -75px; left: 355px;" title="Click this button to close the current window." onclick="parent.closeBPopup();" />
								</div>
								</td>
							</tr>
							<tr>
								<td>
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
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td>
									
									<table width="775" align="center">
										<tr>
											<td height="30" valign="top" style="padding-left: 40px;">
												<i><b>Note:</b>&nbsp;&nbsp;&nbsp;
												"</i><span class="required">*</span><i>" - required field.</i>
											</td>
										</tr>
										<tr id="trStatusDisplay" style="display: none;">
											<td style="padding: 0px 12px;">
												<div id="divStatusMessage"><?php echo $statusMsg; ?></div>
											</td>
										</tr>
										<tr>
											<td width="100%">
												<form id="formCustomer" name="formCustomer" action="addCustomerPopup.php" method="post">
													<input type="hidden" name="customer_id" value="<?php echo $md_edit; ?>" />
													<table>
														<tr>
															<td style="padding-left: 30px; border-right: 1px solid #CCCCCC;">
																<table border="0" width="450">
																	<tr>
																		<td width="15" class="required">*</td>
																		<td width="235"><label for="txtCustomerFirstName">First Name</label></td>
																		<td width="300"><input type="text" id='txtCustomerFirstName' name="customerFirstName" value="<?php echo $customerFirstName; ?>" class="form-field" style="width:255px;" /></td>
																	</tr>
																	<tr>
																		<td width="15" class="required">*</td>
																		<td width="235"><label for="txtCustomerLastName">Last Name</label></td>
																		<td width="300"><input type="text" id='txtCustomerLastName' name="customerLastName" value="<?php echo $customerLastName; ?>" class="form-field" style="width:255px;" /></td>
																	</tr>
																	<tr>
																		<td width="15">&nbsp;</td>
																		<td width="235"><label for="txtCustomerMiddleName">Middle Name</label></td>
																		<td width="300"><input type="text" id='txtCustomerMiddleName' name="customerMiddleName" value="<?php echo $customerMiddleName; ?>" class="form-field" style="width:255px;" /></td>
																	</tr>
																	<tr>
																		<td width="15">&nbsp;</td>
																		<td width="235" height="98" valign="top"><label for="txtCustomerAddress">Address</label></td>
																		<td width="300"><textarea id='txtCustomerAddress' name="customerAddress" class="form-field" cols="30" rows="3" style="width:255px;"><?php echo $customerAddress; ?></textarea></td>
																	</tr>
																<?php
																	if( $stationId ) {
																		$city = getAssociativeArrayFromSQL($conn,  "select * from bplace where id ='" . $stationId . "'" );
																?>
																	<tr>
																		<td width="15" class="required">*</td>
																		<td width="235"><label for="txtCustomerStation">Station</label></td>
																		<td width="300">
																			<input type="hidden" id="hdCustomerStation" name="customerStation" value="<?php echo $city['id']; ?>" />
																			<input type="text" id="txtCustomerStation" name="customerStationName" value="<?php echo $city['category']; ?>" class="form-field" style="width:255px;" readonly="readonly" />
																		</td>
																	</tr>
																<?php	
																	}
																	else {
																?>
																	<tr>
																		<td width="15" class="required">*</td>
																		<td width="235"><label for="sel_customerStation">Station</label></td>
																		<td width="300"><?php generateDropdownObject($conn, "bplace", "customerStation", "form-field"); ?></td>
																	</tr>
																<?php
																	}
																?>
																	<tr>
																		<td width="15" class="required">*</td>
																		<td width="235"><label for="sel_city">Satellite Office</label></td>
																		<td width="300">
																			<?php
																				if( $stationId ) {
																					if( $satelliteOfficeId ){
																						$satelliteOffice = getAssociativeArrayFromSQL($conn,  "select * from deliveryarea where id ='" . $satelliteOfficeId . "'" );
																						echo "<input type=\"hidden\" id=\"hdSatelliteOffice\" name=\"satelliteOffice\" value=\"" . $satelliteOffice['id'] . "\" />";
																						echo "<input type=\"text\" id=\"txtSatelliteOffice\" name=\"satelliteOfficeName\" value=\"" . $satelliteOffice['city'] . "\" class=\"form-field\" style=\"width:255px;\" readonly=\"readonly\" />";
																					}
																					else {
																						generateSelectObject($conn,  "deliveryarea", "id", "city", "station=$stationId", "satelliteOffice", "form-field" );
																					}
																				} else {
																					echo "<select id=\"sel_satelliteOffice\" name=\"satelliteOffice\" class=\"form-field\">";
																					echo "	<option value=\"\">--[Select]--</option>";
																					echo "</select>";
																				}
																			?>
																		</td>
																	</tr>
																	<tr>
																		<td width="15">&nbsp;</td>
																		<td width="235"><label for="txtCustomerPhone">Phone</label></td>
																		<td width="300"><input type="text" id="txtCustomerPhone" name="customerPhone" value="<?php echo $customerPhone; ?>" class="form-field" style="width:255px;"/></td>
																	</tr>
																	<tr>
																		<td width="15">&nbsp;</td>
																		<td width="235"><label for="txtCustomerEmail">Email Address</label></td>
																		<td width="300"><input type="text" id="txtCustomerEmail" name="customerEmail" value="<?php echo $customerEmail; ?>" class="form-field" style="width:255px;"/></td>
																	</tr>
																	<tr>
																		<td width="15">&nbsp;</td>
																		<td width="215"><label for="selCustomerIdentificationType">Identification Type</label></td>
																		<td width="300">
																			<select id="selCustomerIdentificationType" name="customerIdentificationType" class="form-field">
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
																		<td width="15">&nbsp;</td>
																		<td width="235"><label for="txtCustomerIdentificationNo">Identification No.</label></td>
																		<td width="300"><input type="text" id='txtCustomerIdentificationNo' name="customerIdentificationNo" class="form-field" value="<?php echo $customerIdentificationNo; ?>" style="width:255px;" title="Optional field, Identification number of the provided document for identity verification." /></td>
																	</tr>
																</table>
															</td>
															<td valign="top">
																<div style="margin-left: 20px; padding: 5px 10px; border: 0px solid #CCCCCC;">
																	<table width="250">
																		<tr>
																			<td>
																				<input type="checkbox" id="chkDiscountedCustomer" name="discountedCustomer" value="" class="form-field" style="display: inline;" />
																				<label for="chkDiscountedCustomer" style="margin-left: 10px;">Discounted Customer</label>
																			</td>
																		</tr>
																		<tr id="trCustomerPercentage">
																			<td>
																				<label for="txtCustomerPercentageDiscount">Percentage Discount (%)</label>
																				<input type="text" id="txtCustomerPercentageDiscount" name="customerPercentageDiscount" value="<?php echo $customerPercentageDiscount; ?>" class="form-field" style="width: 30px; margin-left: 10px; display: inline;" />
																			</td>
																		</tr>
																	</table>
																</div>
															</td>
														</tr>														
														<tr>
															<td colspan="2" align="center" style="border-top: 0px solid #cccccc;">
																<input type="submit" id="btnAddCustomer" name="submit" value="Add Customer" style="margin-top: 10px; margin-right: 10px;" />
															</td>
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
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>
