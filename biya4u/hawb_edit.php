<?php 
	include('protect.php');
	include 'dbconnect.php'; 
	//include('paging.class.php');
	include('utilities.php');
	include('constants.php');

	session_start();
	$login = $_SESSION['username'];
	$type_code = $_SESSION['type_code'];
	$hawbBookingPrefix = $stationId = $_SESSION['hawb_booking_prefix'];
	$weight = '';
 
	$action = "";
	$success = "";
	if( isset($_REQUEST['action']) ) $action = $_REQUEST['action'];
	if( isset($_REQUEST['success']) ) $success = $_REQUEST['success'];

	/* START: Load shipment types into JS Array */
	$ty_query = mysqli_query($conn, "select id as value, category as label from ty_ship order by category"); 
	$shipmentTypes = array();
	while( $ty_row = mysqli_fetch_assoc($ty_query) ) {
		$type = array();
		$type["label"] = $ty_row["label"];
		$type["value"] = $ty_row["value"];
		$shipmentTypes[] = $type;
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Admin</title>
		<link href="css/style.css" type="text/css"  rel="stylesheet"/>
		<link href="css/superfish.css" rel="stylesheet" media="screen">
		<link href="css/flat/red.css" rel="stylesheet" media="screen">
		<link href="css/blitzer/jquery-ui-1.10.4.custom.css" rel="stylesheet">
		<style type="text/css">
			.style1 {font-size: large; }
			.dialogStyle {
				font-size: 11px;
				background-color: #FFFFFF;
				padding: 10px;
				width: 200px;
				height: 100px;
				border-radius:15px; 
			}
			#divAddCustomer, #divDialog { display:none; }
		</style>
		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/jquery-ui-1.10.4.custom.min.js"></script>
		<script src="js/jquery.validate.min.js"></script>
		<script src="js/jquery.ui.datepicker.validation.min.js"></script>
		<script src="js/superfish.js"></script>
		<script src="js/hoverIntent.js"></script>
		<script src="js/jquery.bpopup.min.js.txt"></script>
		<script src="js/newHawbItem.js"></script>
		<script src="js/hawbCargoItems.js"></script>
		<script src="js/icheck.min.js"></script>
		<script type="text/javascript">
		var LAST_COLUMN_ITEM_INDEX = 0;
		var jShipmentTypes = <?php echo json_encode($shipmentTypes); ?>;
		var jShipmentTypesObj = eval(jShipmentTypes);

		var action = "<?php echo $action; ?>";
		var success = "<?php echo $success; ?>";

		$.validator.addMethod('customphone', function (value, element) {
			return this.optional(element) || /^\(*\d{1,4}\)*\s*\d{3}\s*-*\s*\d{4}$/.test(value);
		}, "Please enter a valid phone number")

		$.validator.addMethod('computedField', function (value, element) {
			return this.optional(element) || (Number(value) > 0);
		}, "Please add a cargo item and calculate total weight and charges before submitting the form.")

		$(document).ready(function(){
			initializePage();
			$("#formNewHawb").validate({
				rules: {
					date:             { required: true },
					customer:         { required: true },
					shipperName:      { required: true },
					/* shipperAddress:   { required: true }, */
					/* shipperPhone:     { required: true }, */
					/* shipperCity:      { required: true }, */
					/* shipperIdNo:      { required: true }, */
					origin:           { required: true },
					destination:      { required: true },
					rcity:            { required: true },
					croute:           { required: true },
					consigneeName:    { required: true },
					consigneeAddress: { required: true },
					consigneePhone:   { required: true, 'customphone': true },
					modpay:           { required: true },
					move:             { required: true },
					sermode:          { required: true },
					totalWeight: 	  'computedField',
					totalCharges: 	  'computedField'
				},
						
				messages: {
					date:             { required: "Please select shipment date." },
					customer:         { required: "Please select a customer." },
					shipperName:      { required: "Please enter shipper name." },
					/* shipperAddress:   { required: "Please enter shipper address." }, */
					/* shipperPhone:     { required: "Please enter shipper contact number." }, */
					/* shipperCity:      { required: "Please enter shipper city." }, */
					/* shipperIdNo:      { required: "Please enter shipper identification number." }, */
					origin:           { required: "Please select shipment origin." },
					destination:      { required: "Please select shipment destination." },
					rcity:            { required: "Please enter consignee city." },
					croute:           { required: "Please choose if the shipment will be a connecting route." },
					consigneeName:    { required: "Please enter consignee name." },
					consigneeAddress: { required: "Please enter consignee address." },
					consigneePhone:   { required: "Please enter consignee contact number." },
					modpay:           { required: "Please select mode of payment." },
					move:             { required: "Please select type of movement." },
					sermode:          { required: "Please select service mode." },
				},

				errorContainer: $('#errorContainer'),
				errorLabelContainer: $('#errorContainer ul'),
				wrapper: 'li'
			});

			if( action == "add" && success == "true"){
				showDialog("divDialog", "spanDialogMsg", "Successfully saved new HAWB.");
			}

		});

		var closeBPopup = function() {
			$("#divAddCustomer").bPopup().close()
		};

		var closeDialog = function() {
			$("#divDialog").bPopup().close()
		};
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
							<tr><td><p align="center" class="header">New HAWB</p></td></tr>
							<tr>
								<td>
									<div id="errorContainer">
										<ul />
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<form id="formNewHawb" name="formNewHawb" action="addHawbRecord.php" method="post">
										<table align="left" style="margin-left: 70px; position: relative; width: 800px; height: 70px;">            
											<tr>
												<td width="15" class="required">*</td>
												<td width="245"><label for="txtSenderName">Date</label></td>
												<td width="560">
													<input type="text" id='txtHAWBDate' name="date" class="form-field" value="<?php echo date("d-m-Y"); ?>" readonly="readonly" />
												</td>
											</tr>
											<tr>
												<td width="15" class="required">*</td>
												<td width="245"><label for="txtCustomer"><strong>Choose Shipper</strong></label></td>
												<td>           
													<div id="divCustomerList" style="width: 255px; position:absolute; top: 65px; left: 262px; display: none;">
														<ul id="min1" style="width:255px; background: #800000; border:1px solid #959595; padding:5px; line-height:25px; list-style:none; margin-top: 0px;" align="center"></ul>
													</div>
													<div style="padding: 0px;">
														<input type="text" id="txtCustomer" name="customer" class="form-field" style="width:255px; display: inline-block;" autocomplete="off"/>
														<a id="lnkAddCustomer" href="javascript:void(0);" class="linkRedButton">Add New Customer</a>
													</div>
												</td>
											</tr>
										</table>

										<input type="hidden" id="hdCustomerPercentDiscount" name="customerPercentDiscount" val="" />
										<table id="tblCustomerInfos" width="800" align="left" style="margin-left: 70px;">
											<tr>
												<td width="15" class="required">*</td>
												<td width="245"><label for="txtSenderName"><b>Sender Name</b></label></td>
												<td width="560">
													<input type="text" id="txtSenderName" name="shipperName" value="" class="form-field" style="width:255px;" readonly/>
												</td>
											</tr>
											<tr>
												<td width="15">&nbsp;</td>
												<td width="245"><label for="txtSenderAddress"><b>Address</b></label></td>
												<td width="560">
													<textarea id="txtSenderAddress" name="shipperAddress" rows="3" class="form-field" style="width:255px; resize: none;" readonly></textarea>
												</td>
											</tr>
											<tr>
												<td width="15">&nbsp;</td>
												<td width="245"><label for="txtSenderContactNo">Contact Number</label></td>
												<td width="560">
													<input type="text" id="txtSenderContactNo" name="shipperPhone" class="form-field" value="" style="width: 255px;" readonly/>
												</td>
											</tr>
											<tr>
												<td width="15">&nbsp;</td>
												<td width="245"><label for="txtSenderCity">City</label></td>
												<td width="560">
													<input type="text" id="txtSenderCity" name="shipperCity" class="form-field" value="" style="width:255px;" readonly/>
												</td>
											</tr>
											<tr>
												<td width="15">&nbsp;</td>
												<td width="245"><label for="txtSenderIDNo">Identification Number</label></td>
												<td width="560">
													<input type="text" id="txtSenderIDNo" name="shipperIdNo" class="form-field" value="" style="width:255px;" readonly/>
												</td>
											</tr>
										</table>
										<table width="800" align="left" style="margin-left: 70px;">
											<tr>
												<td width="15" class="required">*</td>
												<td width="245"><label for="<?php echo ($type_code == ADMIN ? "sel_origin" : "txtOrigin"); ?>">Origin</label></td>
												<?php 
													if( $type_code == ADMIN ) {
												?>
													<td width="560"><?php generateDropdownObject($conn, "bplace", "origin", "form-field"); ?></td>
												<?php
													}
													else { 
															$origin = getAssociativeArrayFromSQL($conn, "select * from bplace where id =" . $stationId);
												?>
												<td width="560">
													<input type="text" id="txtOrigin" name="originvalue" value="<?php echo $origin['category']; ?>" class="form-field" style="width:255px;" readonly="readonly" />
													<input type="hidden" id="origin" name="origin" value="<?php echo $stationId; ?>" />
												</td> 
												<?php
													}
												?>
											</tr>
											<tr>
												<td width="15" class="required">*</td>
												<td width="245"><label for="sel_destination">Destination</label></td>
												<td width="560"><?php generateDropdownObject($conn, "bplace", "destination", "form-field"); ?></td>
											</tr>
										</table>
										<table width="800" align="left" style="margin-left: 70px;">
											<tr>
												<td width="15" class="required">*</td>
												<td width="245"><label for="sel_rcity">City / Delivery Area</label></td>
												<td width="560">
													<select id="sel_rcity" name="rcity" class="form-field" style="width:280px" onChange="setDeliveryArea();">
														<option value="">--Select--</option>
													</select>
												</td>
											</tr>
											<tr>
												<td width="15" class="required">*</td>
												<td width="245">Connecting Route</td>
												<td width="560">
													<div id="city" style="height: 30px; padding-top: 10px; padding-bottom: 0px;">
														<input type="radio" id="optCrouteYes" name="croute" value="yes" />
														<label for="optCrouteYes">Yes</label>
														<input type="radio" id="optCrouteNo" name="croute" value="no" checked="checked" />
														<label for="optCrouteNo">No</label>
													</div>
												</td>
											</tr>
											<tr>
												<td width="15" class="required">*</td>
												<td width="245"><label for="txtReceiver"><strong>Consignee's Name</strong></label></td>
												<td width="560">
													<input type="text" id="txtReceiver" name="consigneeName" value="" class="form-field" style="width:255px;" />
												</td>
											</tr>
											<tr>
												<td width="15" class="required">*</td>
												<td width="245"><label for="txtReceiverAddress"><strong>Address</strong></label></td>
												<td width="560">
													<textarea id="txtReceiverAddress" name="consigneeAddress" class="form-field" rows="3" style="width:255px; resize: none;"></textarea>
												</td>
											</tr>
												<td width="15" class="required">*</td>
												<td width="245"><label for="txtReceiverContactNo">Phone</label></td>
												<td width="560">
													<input type="text" id="txtReceiverContactNo" name="consigneePhone" value="" class="form-field" style="width:255px;" />
												</td>
											</tr>
										</table>

										<div id="divDeliveryArea" style="margin-left: 90px; display: none;"><input type="hidden" id="hdDeliveryArea" name="deliveryArea" value="" /></div>
										<table width="800" align="left" style="margin-left: 70px;">
											<tr>
												<td width="15" class="required">*</td>
												<td width="245"><label for="sel_modpay">Mode of Payment</label></td>
												<td width="560"><?php generateDropdownObject($conn, "mop", "modpay", "form-field"); ?></td>
											</tr>
											<tr>
												<td width="15" class="required">*</td>
												<td width="245"><label for="sel_move">Type of Movement</label></td>
												<td width="560"><?php generateDropdownObject($conn, "movement", "move", "form-field"); ?></td>
											</tr>
											<tr>
												<td width="15" class="required">*</td>
												<td width="245"><label for="sel_sermode">Service Mode</label></td>
												<td width="560"><?php generateDropdownObject($conn, "servicemode", "sermode", "form-field"); ?></td>
											</tr>
										</table>

										<table id="tblHawbItems" width="873" align="left" style="margin-top: 30px; border:1px solid #181818; box-shadow: 3px 3px 3px #888888;">
											<tr id="trHawbHeaders">
												<td width="201" height="27" align="center" valign="middle" class="hawbHeader">Cargo Description</td>
												<td width="50"  align="center" valign="middle" class="hawbHeader">QTY</td>
												<td width="259" align="center" valign="middle" class="hawbHeader">Dimension</td> 
												<td width="189" align="center" valign="middle" class="hawbHeader">Weight(Kilo)</td>
												<td width="150" align="center" valign="middle" class="hawbHeader">Declared Value</td>
											</tr>
										</table>

										<table width="873" align="left" style="margin-top: 15px;">
											<tr>
												<td colspan=3">
													<div style="display: none;">
														<label for="hdLastCargoItemIndex" style="font-weight: bold; margin-right: 25px;">Last cargo item index:</label>
														<input type="text" id="hdLastCargoItemIndex" name="lastCargoItemIndex" value="0" />
													</div>
												</td>
												<td align="right">
													<a id="lnkAddCargoItem" href="javascript:void(0);" onclick="addCargoDetailsRow();" class="linkGoldButton" title="Add cargo item button.">Add Cargo Item</a>
												</td>
											</tr>
											<tr>
												<td class="dashedTop" style="height: 30px;">
													<label for="selDivisor" style="font-weight: bold;">Divisor:</label>
													<select id="selDivisor" name="divisor" onchange="calculateCargoItemCharge();" style="margin-left: 10px; width: 100px; padding-left: 7px; padding-top: 2px; padding-bottom: 2px;">
														<option value="3500">3500</option>
														<option value="4500">4500</option>
														<option value="6000">6000</option>
													</select>
												</d>
												<td class="dashedTop" style="height: 30px; padding-left:20px;">
													<label for="txtTotalWeight" style="font-weight: bold;">Total Weight:</label>
													<input type="text" id="txtTotalWeight" name="totalWeight" border="0" style="text-align:right; width:75px; font-weight:bold; padding: 2px 7px;" readonly="readonly" value="0"/>
												</td>
												<td id="tdTotalCharges" class="dashedTop" style="padding-left: 20px;">
													<label for="txtTotalCharges" style="font-weight: bold;">Total Charges:</label>
													<input type="text" id="txtTotalCharges" name="totalCharges" style="text-align: right; width: 75px; font-weight: bold; margin-left: 20px; padding: 2px 7px;" value="0" readonly="readonly" />
												</td>
												<td rowspan="2" align="right" class="dashedTop dashedBottom">
													<a href="javascript:void(0);" onclick="calculateCargoItemCharge();">
													<img src="images/calculator_red.png" alt="Calculate" title="Click button to calculate total weight and charges." />
													</a>
												</td>
											</tr>
											<tr>
												<td>
													<div style="display: none;">
														<label for="hdWeightReferrenceId" style="font-weight: bold; margin-right: 25px;">Weight Ref. Id</label>
														<input type="hidden" id="hdWeightReferrenceId" name="weightReferrenceId" value="0" />
													</div>
												</td>
												<td class="dashedBottom" style="height: 40px; margin-left: 0px; padding-left: 20px;">
													<label for="hdCargoItemsCount" style="font-weight: bold;">No. of Items:</label>
													<input type="text" id="hdCargoItemsCount" name="cargoItemsCount" value="0" style="text-align:right; width:75px; font-weight:bold; padding: 2px 7px; margin-left: 2px;" readonly="readonly" />
												</td>
												<td class="dashedBottom" style="padding-left: 20px; height: 40px;">
													<label for="txtDiscountedAmount" style="font-weight: bold;">Discounted Price:</label>
													<input type="text" id="txtDiscountedAmount" name="discountedAmount" value="0" onClick="$(this).select();" style="text-align:right; width:75px; font-weight:bold; padding: 2px 7px;" title="Displays discounted price based on the customer's given discount. This field can be overriden to give specific discount per transaction." />
												</td>
											</tr>
										</table>

										<table id="new" align="left" style="width: 550px; margin-top: 10px;">
											<tr>
												<td width="200"><label for="txtHawbRemarks" style="font-weight: bold;">Remarks / Notations:</label></td>
												<td width="350"><textarea id="txtHawbRemarks" name="remarks" cols="40" rows="5" style="resize: none;"></textarea></td>
											</tr>
											<tr>
												<td width="200">&nbsp;</td>
												<td width="350" align="center">
													<input type="submit" id="btnSubmitHawb" name="submit" value="Submit" />
													<input type="reset" id="btnResetHawb" name="reset" value="Reset" />
												</td>
											</tr>
										</table>
									</form>
								</td>
							</tr>
							<tr>
								<td>
									<div id="divAddCustomer"></div>
									<div id="divDialog" class="dialogStyle glow" title="Click [X] button to close the dialog.">
										<div>
											<img id="imgClose" src="images/close.png" style="float: right; margin-right: -19px; margin-top: -18px;" onclick="closeDialog();" />
										</div>
										<div style="text-align: center; margin-top: 40px; ">
											<span id="spanDialogMsg" class="textShadow"></span>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td><?php include('adminfooter.php') ?></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;
						<!--
						<div id="divCustomerList" style="position:relative;  top: -952px; left: 205px; display:none;">
							<ul id="min1" style="width:255px; max-height:500px; background: #008040; margin:-5px 0 0 310px; border:1px solid #959595; padding:5px; line-height:25px; list-style:none;" align="center"></ul>
						</div>
						-->
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>
