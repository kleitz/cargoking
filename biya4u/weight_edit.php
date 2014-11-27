<?php 
	include('protect.php');
	include 'dbconnect.php';
	include('utilities.php');

	session_start();
	$login_id  = "";
	$login     = "";
	$type_code = "";
	$stationId = "";
	if( isset($_SESSION['login_id']) )  $login_id  = $_SESSION['login_id'];
	if( isset($_SESSION['username']) )  $login     = $_SESSION['username'];

	$md_edit = "";
	if( isset($_REQUEST['ed']) ) $md_edit = $_REQUEST['ed'];

	$weightCategoryInfo = getAssociativeArrayFromSQL($conn, "SELECT * FROM weight WHERE id = " . $md_edit);

	$search  = array('"', "'");
	$replace = array('&quot;', '&#39;');

	$errorNo  = "";
	$errorMsg = "";

	if(isset($_REQUEST['submit'])) {

		$weightValue     = mysqli_real_escape_string($conn, $_POST['cat']);
		$deliveryArea    = mysqli_real_escape_string($conn, $_POST['area']);
		$amountTotal     = mysqli_real_escape_string($conn, $_POST['rate']);
		$hasVat          = mysqli_real_escape_string($conn, $_POST['wvat']);
		$freightCharge   = mysqli_real_escape_string($conn, $_POST['fcharge']);
		$vat             = mysqli_real_escape_string($conn, $_POST['vat']);
		$commission      = mysqli_real_escape_string($conn, $_POST['comm']);
		$amountDueToCK   = mysqli_real_escape_string($conn, $_POST['duecar']);

		$weightValue = $weightValue == "" ? 0 : floatval(str_replace(",", "", $weightValue));
		$freightCharge = $freightCharge == "" ? 0 : floatval(str_replace(",", "", $freightCharge));
		$vat = $vat == "" ? 0 : floatval(str_replace(",", "", $vat));
		$amountTotal = $amountTotal == "" ? 0 : floatval(str_replace(",", "", $amountTotal));
		$commission = $commission == "" ? 0 : floatval(str_replace(",", "", $commission));
		$amountDueToCK = $amountDueToCK == "" ? 0 : floatval(str_replace(",", "", $amountDueToCK));

		$id = $_GET['ed'];

		$successUpdate = mysqli_query($conn, "UPDATE weight SET weightvalue ='$weightValue',delarea='$deliveryArea',fcharge='$freightCharge',vat='$vat',commission='$commission',duecar='$amountDueToCK',rate='$amountTotal' WHERE id ='$id' ")or die (mysqli_error());
		if( $successUpdate ) {
			echo "<script type=\"text/javascript\">";
			echo "	 window.opener.location.href='weight_rep.php?action=update&success=true';";
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
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
			$(document).ready(function() {
				var sf = $('#menuCKNavigation').superfish();
				$("#btnUpdateWeightCategory").button();

				<?php
					if($weightCategoryInfo["id"] < 132 && $weightCategoryInfo["id"] > 127 ) {
				?>
						$("#objDeliveryArea").val("<?php echo getWeightDeliveryArea($weightCategoryInfo["delarea"]); ?>");
				<?php
					}
					else {
				?>
						$("#objDeliveryArea").val("<?php echo $weightCategoryInfo['delarea']; ?>");
				<?php
					}
				?>

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

			function MM_openBrWindow(theURL,winName,features) { //v2.0
				window.open(theURL,winName,features);
			}
		</script>
	</head>

	<body>
		<div align="center">
			<table width="580" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF" style="border-radius:15px;">
				<tr>
					<td style="padding: 10px;"><img src="images/logo.png" /></td>
				</tr>
				<tr>
					<td>
						<p align="center" class="textShadow" style="font-size: 14px; font-weight: bold;">Update Weight Category</p>
					</td>
				</tr>
				<tr>
					<td>
						<table width="100%" border="0" cellspacing="3" cellpadding="3" class="sub_cont">
							<tr>
								<td>
									<form id="form1" name="form1" method="post" action="">
									<table width="98%" border="0">
										<tr>
											<td width="15" class="required">*</td>
											<td width="125"><label for="objWeight">Weight Value</label></td>
											<td width="400">
												<?php
													if($weightCategoryInfo['id'] < 132 && $weightCategoryInfo['id'] > 127 ) {
														echo "<input type=\"text\" id=\"objWeight\" name=\"cat\" value=\"" . stripslashes(str_replace($search, $replace, $weightCategoryInfo['weightvalue'])) . "\" class=\"form-field\" readonly=\"readonly\" style=\"width:220px;\" />";
													}
													else {
														echo "<select id=\"objWeight\" name=\"cat\" class=\"form-field\" style=\"width:243px;\">";
														echo "	<option value=" . stripslashes(str_replace($search, $replace,$weightCategoryInfo['weightvalue'])) . ">" . stripslashes(str_replace($search, $replace,$weightCategoryInfo['weightvalue'])) . "</option>";
														echo "	<option value=\"0.5\">0.5</option>";

														for( $i = 1; $i < 50; $i++ )
															echo ("<option value='$i'>$i</option>");

														echo "</select>";
													}
												?>
											</td>
										</tr>
										<tr>
											<td width="15">&nbsp;</td>
											<td width="125"><label for="objDeliveryArea">Delivery Area</label></td>
											<td width="400">
												<?php
													if($weightCategoryInfo['id'] < 132 && $weightCategoryInfo['id'] > 127 ) {
												?> 
												<input type="text" id="objDeliveryArea" name="varea" value="<?php echo getWeightDeliveryArea($weightCategoryInfo['delarea']); ?>" class="form-field" readonly="readonly" style="width:220px;"/>
												<input type="hidden" id="hdDeliveryArea" name="area" value="<?php echo $weightCategoryInfo['delarea']; ?>" />
												<?php
													}
													else {
												?>
												<select id="objDeliveryArea" name="area" class="form-field" style="width:243px;">
													<option value="1">Within City</option>
													<option value="2">Outside City</option>
													<option value="3">Excess Baggage Port-Port</option>
													<option value="4">Excess Baggage Door-Door</option>
												</select>
												<?php
													}
												?>
											</td>
										</tr>
										<tr>
											<td width="15" class="required">*</td>
											<td width="125"><label for="txtRate">Grand Total</label></td>
											<td width="400">
											<input type="text" id="txtRate" name="rate" value="<?php  echo stripslashes(str_replace($search, $replace,$weightCategoryInfo['rate']));?>" class="form-field" style="width:220px;" /></td>
										</tr>
										<tr>
											<td width="15" class="required">*</td>
											<td width="125"><label for="txtFreightCharge">Freight Charge</label></td>
											<td width="400">
											<input type="text" id="txtFreightCharge" name="fcharge" value="<?php  echo stripslashes(str_replace($search, $replace,$weightCategoryInfo['fcharge']));?>" class="form-field" style="width:220px;" /></td>
										</tr>
										<?php 
											if($weightCategoryInfo['vat'] != 0) {
										?>
										<tr>
											<td width="15" class="required">*</td>
											<td width="125"><label for="txtVAT">VAT 12%</label></td>
											<td width="400">
												<input type="text" id="txtVAT" name="vat" value="<?php  echo stripslashes(str_replace($search, $replace,$weightCategoryInfo['vat']));?>" class="form-field" style="width:220px;" />
											</td>
										</tr>
										<?php
											}
										?>
										<tr>
											<td width="15" class="required">*</td>
											<td width="125"><label for="txtCommission">Commission</label></td>
											<td width="400">
											<input type="text" id="txtCommission" name="comm" value="<?php  echo stripslashes(str_replace($search, $replace,$weightCategoryInfo['commission']));?>" class="form-field" style="width:220px;" /></td>
										</tr>
										<tr>
											<td width="15" class="required">*</td>
											<td width="125"><label for="txtDueToCK">Due to Cargo King</label></td>
											<td width="400">
											<input type="text" id="txtDueToCK" name="duecar" value="<?php  echo stripslashes(str_replace($search, $replace,$weightCategoryInfo['duecar']));?>" class="form-field" style="width:220px;" /></td>
										</tr>
										<tr>
											<td colspan="2">&nbsp;</td>
											<td>
												<input type="submit" id="btnUpdateWeightCategory" name="submit" value="Update Weight Category" style="margin-top: 20px; margin-right: 10px;" />
											</td>
										</tr>
									</table>
									</form>
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>
