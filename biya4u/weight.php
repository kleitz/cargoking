<?php 
	include('protect.php');
	include 'dbconnect.php';

	session_start();
	$login_id = 1; //default to admin id
	if( isset($_SESSION['login_id']) ) $login_id = $_SESSION['login_id'];
	
	//add codes for adding new weight category
	if($_POST['submit']) {
		$weightValue     = mysqli_real_escape_string($conn, $_REQUEST['cat']);
		$deliveryArea    = mysqli_real_escape_string($conn, $_REQUEST['area']);
		$amountTotal     = mysqli_real_escape_string($conn, $_REQUEST['rate']);
		$hasVat          = mysqli_real_escape_string($conn, $_REQUEST['wvat']);
		$freightCharge   = mysqli_real_escape_string($conn, $_REQUEST['fcharge1']);
		$vat             = mysqli_real_escape_string($conn, $_REQUEST['vat1']);
		$commission      = mysqli_real_escape_string($conn, $_REQUEST['comm']);
		$amountDueToCK   = mysqli_real_escape_string($conn, $_REQUEST['cargodue']);

		$weightValue = $weightValue == "" ? 0 : floatval(str_replace(",", "", $weightValue));
		$freightCharge = $freightCharge == "" ? 0 : floatval(str_replace(",", "", $freightCharge));
		$vat = $vat == "" ? 0 : floatval(str_replace(",", "", $vat));
		$amountTotal = $amountTotal == "" ? 0 : floatval(str_replace(",", "", $amountTotal));
		$commission = $commission == "" ? 0 : floatval(str_replace(",", "", $commission));
		$amountDueToCK = $amountDueToCK == "" ? 0 : floatval(str_replace(",", "", $amountDueToCK));

		$sqlInsert  = " insert into weight(weightvalue, delarea, fcharge, vat, rate, commission, duecar, created_by, create_date, last_modified_by, last_modified_date) values ('$weightValue', '$deliveryArea', '$freightCharge', '$vat', '$amountTotal', '$commission', '$amountDueToCK', '$login_id', now(), '$login_id', now())";
		//echo "[SQL]: " . $sqlInsert . "<br>";

		$successInsertion = mysqli_query($conn,  $sqlInsert );

		if( $successInsertion ) {
			header('Location: weight_rep.php?action=add&success=true');
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
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
		<script src="js/hoverIntent.js"></script>
		<script src="js/superfish.js"></script>
		<script src="js/icheck.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				var sf = $('#menuCKNavigation').superfish();

				$("input[type=radio]").iCheck({ radioClass: 'iradio_flat-red' });
				$("input[type=radio]").on("ifChecked", function(e){
					generateVAT();
					//showHidePercentageField( $(this).is(":checked") )
				});
				
				//Set without VAT as default.
				$("#optVatNo").iCheck("check");

				$("#selDeliveryArea").val("<?php echo $_REQUEST['area']; ?>");

				$("#formAddWeight").validate({
					rules: {
						cat: {
							required:true,
							minlength:1,
							maxlength:4,
							number:true
						},
						rate: {
							required:true,
							number:true
						},
						comm: {
							required:true,
							number:true
						}				
					},
					messages: {
						cat: {
							required: "Please enter weight value.",
							minlength: "Please enter atleast one digit value.",
							maxlength: "Please enter a value with 4 digits atmost.",
							number: "Please enter a valid weight value."
						},
						rate: {
							required:"Please enter a rate.",
							number: "Please enter a valid rate."
						},
						comm: {
							required: "Please enter a commission.",
							number: "Please enter a valid commission."
						}
					},
					errorContainer: $('#errorContainer'),
					errorLabelContainer: $('#errorContainer ul'),
					wrapper: 'li'
				});
			});

			var calculateDueToCK = function() {
				var freight = $("#txtFreightCharge").val();
				var vat = $("#txtVAT").val();
				var commission = $("#txtCommission").val();
				var rate = $("#txtRate").val();
				
				freight    = !isNaN(freight)    ? Number(freight)    : 0;
				vat        = !isNaN(vat)        ? Number(vat)        : 0;
				commission = !isNaN(commission) ? Number(commission) : 0;
				rate       = !isNaN(rate)       ? Number(rate)       : 0;

				if("" != $("#txtCommission").val()){
					var dueToCK = rate - commission
					$("#txtDueToCK").val(dueToCK);
				}
			};

			var generateVAT = function() {
				var rate = $("#txtRate").val();
				var has_vat = $("input[name=wvat]:checked").val();
				$.post("calculateVat.php",{ rate: rate, has_vat: has_vat}, function(result){
					$("#vatext").html(result);
				});
			};
		</script>
	</head>
	<body>
		<div align="center">
			<table width="100%" border="0" cellspacing="0" cellpadding="0"  align="center">
				<tr>
					<td>
						<table width="900" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
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
									<p align="center" class="style1">Add Weight Value</p>
									<form id="formAddWeight" name="suc" action="" method="post">
										<table align="center">
											<tr>
												<td width="15" class="required">*</td>
												<td width="125"><label for="txtWeight">Weight Value</label></td>
												<td width="400"><input type="text" id='txtWeight' name="cat" value="<?php echo $_REQUEST['cat']; ?>" class="form-field" style="width:110px; display: inline-block;"/><strong> KG</strong></td>
											</tr>
											<tr>
												<td width="15">&nbsp;</td>
												<td width="125"><label for="selDeliveryArea">Delivery Area</label></td>
												<td width="400">
													<select id="selDeliveryArea" name="area" class="form-field">
														<option value="1">Within City</option>
														<option value="2">Outside City</option>
														<option value="3">Excess Baggage Port-Port</option>
														<option value="4">Excess Baggage Door-Door</option>
													</select>
												</td>
											</tr>
											<tr>
												<td width="15" class="required">*</td>
												<td width="125"><label for="txtRate">Grand Total</label></td>
												<td width="400">
													<input type="text" id="txtRate" name="rate" size="5" value="<?php echo $_REQUEST['rate']; ?>" class="form-field" style="width:110px; margin-right: 15px; display:inline-block;" onchange="generateVAT();" />
													<div id="divTax" style="display:inline-block; height: 30px; padding-top: 10px; padding-bottom: 0px;">
														<input type="radio" id="optVatYes" name="wvat" value="withvat" />
														<label for="optVatYes">With VAT</label>
														<input type="radio" id="optVatNo" name="wvat" value="withoutvat" />
														<label for="optVatNo">Without VAT</label>
													</div>
												</td>
											</tr>
											<tr>
												<td colspan="3" id="vatext">
													<table width="100%" cellpadding="0" cellspacing="0" align="center">
														<tr>
															<td width="15">&nbsp;</td>
															<td width="135"><label for="txtFreightCharge">Freight Charge</label></td>
															<td width="400"><input type="text" id="txtFreightCharge" name="fcharge1" class="form-field" style="width:110px;" readonly="readonly" /></td>
														</tr>
														<tr>
															<td width="15">&nbsp;</td>
															<td width="135"><label for="txtVAT">VAT 12%</label></td>
															<td width="400">
																<input type="text" id="txtVAT" name="vat1" class="form-field" style="width: 110px; padding-top: 4px; margin-top: 6px; margin-bottom: 2px;" readonly="readonly" />
															</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td width="15" class="required">*</td>
												<td width="125"><label for="txtCommission">Commission</label></td>
												<td width="400"><input type="text" id="txtCommission" name="comm" size="5" value="<?php echo $_REQUEST['comm']; ?>" class="form-field" style="width:110px;" onBlur="calculateDueToCK();" /></td>
											</tr>
											<tr>
												<td width="15">&nbsp;</td>
												<td width="125"><label for="txtDueToCK">Due To Cargo King</label></td>
												<td width="400"><input type="text" id="txtDueToCK" name="cargodue" size="5" value="<?php echo $_REQUEST['cargodue']; ?>" class="form-field" style="width:110px;" readonly="readonly" /></td>
											</tr>
											<tr>
												<td width="15">&nbsp;</td>
												<td width="125">&nbsp;</td>
												<td width="400"><input type="submit" name="submit" value="Submit" /></td>
											</tr>
										
										</table>
									</form>
								</td>
							</tr>
							<tr><td>&nbsp;</td>
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
