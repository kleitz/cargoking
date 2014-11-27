<?php 
	include('protect.php');
	include 'dbconnect.php'; 
	include('paging.class.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link href="css/style.css" type="text/css"  rel="stylesheet"/>
		<link href="css/superfish.css" rel="stylesheet" media="screen">
		<title>Admin</title>
		<style type="text/css">
		<!--
		.style1 {font-size: large;}
		-->
		</style>
		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/jquery.validate.min.js"></script>
		<script src="js/hoverIntent.js"></script>
		<script src="js/superfish.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				var sf = $('#menuCKNavigation').superfish();
				$("#formTypeOfShipment").validate({
					rules: {
						typeOfShipment: {
							required:true,
							maxlength: 25,
							minlength: 4,
							remote: {
								url: "checkTypeOfShipment.php",
								type: "post",
								data: {
									typeOfShipment: function() {
										return $("#txtTypeOfShipment").val();
									}
								}
							}
						}
					},

					messages: {
						typeOfShipment: {
							required: "Please Fill The Type of Shipment.",
							maxlength: "The maximum length of type of shipment should not exceed 25 characters.",
							minlength: "The minimum length of type of shipment should be 4 characters.",
							remote: "Type of Shipment Already Exists. Please try another one."
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
								<td width="187"><?php include('adminheader.php') ?></td>
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
								<td>
									<p align="center" class="style1">Type of Shipment</p>
									<?php 

									if($_POST['submit']) {
										$typeOfShipment                  = mysqli_real_escape_string($conn, $_REQUEST['typeOfShipment']);
										$typeOfShipmentCode              = mysqli_real_escape_string($conn, $_REQUEST['typeOfShipmentCode']);
										$typeOfShipmentRemarks           = mysqli_real_escape_string($conn, $_REQUEST['typeOfShipmentRemarks']);

										$SQLInsert  = " insert into ty_ship (category, code, remarks, creation_date, last_modified_date) ";
										$SQLInsert .= " values ('" . $typeOfShipment . "', '" . $typeOfShipmentCode . "', '" . $typeOfShipmentRemarks . "', now(), now())";
										$successInsertion = mysqli_query($conn,  $SQLInsert );

										if( $successInsertion ) {
									?> 
										<script type="text/javascript">
											alert("Successfully added a manager!");
											self.location='cat_rep1.php';
										</script>
									<?php
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
									<br>
									<form id="formTypeOfShipment" name="formTypeOfShipment" action="" method="post">
										<table align="center">
											<tr>
												<td width="132" valign="top"><label for="txtTypeOfShipment">Vehicle Plate Number</label></td>
												<td width="144">
													<input type="text" id='txtTypeOfShipment' name="typeOfShipment" value="<?php echo $_REQUEST['typeOfShipment']; ?>" class="form-field" style="width:250px;" title="Type of Shipment (eg. General Cargo, Perishable Goods, Valuable Item)." />
												</td>
											</tr>
											<tr>
												<td width="132" valign="top">Shipment Code</td>
												<td width="144">
													<input type="text" id='txtTypeOfShipmentCode' name="typeOfShipmentCode" value="<?php echo $_REQUEST['typeOfShipmentCode']; ?>" class="form-field" style="width:250px;" title="Type of Shipment code(Not required)." />
												</td>
											</tr>
											<tr>
												<td width="132" valign="top">Remarks</td>
												<td width="144">
													<textarea id='txtTypeOfShipmentRemarks' name="typeOfShipmentRemarks" style="width:250px;" class="form-field" title="Type of Shipment remarks(Not required)."><?php echo $_REQUEST['typeOfShipmentRemarks']; ?></textarea>
												</td>
											</tr>
											<tr>
												<td width="132">&nbsp;</td>
												<td width="144"><input type="submit" name="submit" value="Submit" style="margin-top: 15px;" /></td>
											</tr>
										</table>
									</form>
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
