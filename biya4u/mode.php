<?php 
	include('protect.php');
	include 'dbconnect.php'; 
	include('paging.class.php');
		 
	session_start();

	$login_id     = "";
	$type_code = "";
	$stationId = "";
	if( isset($_SESSION['login_id']) )  $login_id  = $_SESSION['login_id'];
	if( isset($_SESSION['type_code']) ) $type_code = $_SESSION['type_code'];
	if( isset($_SESSION['stationId']) ) $stationId = $_SESSION['stationId'];

	$action = "";
	$success = "";
	if( isset($_REQUEST['action']) ) $action = $_REQUEST['action'];
	if( isset($_REQUEST['success']) ) $success = $_REQUEST['success'];	
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
	<script src="js/jquery.validate.min.js"></script>
	<script src="js/jquery-ui-1.10.4.custom.min.js"></script>
	<script src="js/hoverIntent.js"></script>
	<script src="js/superfish.js"></script>
	<script type="text/javascript">
	
		var action = "<?php echo $action; ?>";
		var success = "<?php echo $success; ?>";
		
		$(document).ready(function(){
		$("#btnAddModeofPayment").button();
			var sf = $('#menuCKNavigation').superfish();
			$("#formmodeOfPayment").validate({
				rules:{
					modeOfPayment: {
						required:true,
						maxlength: 15,
						minlength: 4,
						remote: {
							url: "check_ModeofPayment.php",
							type: "post",
							data: {
								mop: function() {
									console.log ($("#txtmodeOfPayment").val());
									return $("#txtmodeOfPayment").val();
								}
							}
						}
					}
				},

				messages: {
					modeOfPayment: {									
						required: "Please fill the required field.",
						maxlength: "The maximum length of of payment mode not exceed 15 characters.",
						minlength: "The minimum length of payment mode should be 4 characters.",
						remote: "This kind mode of payment is already Exists. Please try another one."
					}
				},

				errorContainer: $('#errorContainer'),
				errorLabelContainer: $('#errorContainer ul'),
				wrapper: 'li'
			});
			if( action == "add" && success == "true"){
				$("#trStatusDisplay").show();
				$("#divStatusMessage").html("Successfully added mode of payment.").show();
			}
			else if( action == "delete" && success == "true"){
				$("#trStatusDisplay").show();
				$("#divStatusMessage").html("Successfully deleted mode of payment.").show();
			}
			else if( action == "delete" && success == "false"){
				$("#trStatusDisplay").show();
				$("#divStatusMessage").html("Cannot deleted active mode of payment.").show();
			}
			else {
				$("#divStatusMessage").hide();
				$("#trStatusDisplay").hide();
			}
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
									<td ><p align="center" class="style1"> Add Mode of Payment</p>
											<span class="">
										<?php 
											if($_POST['submit']) {
											
																															
												$modeOfPayment    = mysqli_real_escape_string($conn, $_REQUEST['modeOfPayment']);
												$SQLInsert  = " insert into mop (category) ";
												$SQLInsert .= " values ('" . $modeOfPayment . "')";
												$successInsertion = mysqli_query($conn,  $SQLInsert );
											if( $successInsertion ) {	
												echo "<script type=\"text/javascript\">";
												//alert("Successfully added a vehicle!");
												echo "	self.location='payment_modes_list.php?action=add&success=true';";
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
										<form id="formmodeOfPayment" name="formmodeOfPayment" action="" method="post">
											<table align="center">
												<tr>
												  <td width="132">Mode of Payment</td>
												  <td width="144"><input type="text" name="modeOfPayment" value="<?php echo $_REQUEST['modeOfPayment']?>" class="form-field"" id='txtmodeOfPayment'/></td>
												  <td width="132"></td>
												  <td width="144" id='txtHint'></td>
												</tr>
												<tr>
												  <td width="132"></td>
												  <td width="144"><input type="submit" id="btnAddModeofPayment" name="submit" value="Submit" /></td>
												</tr>
											</table>
										</form>
									</td>
								</tr>
									<tr><td >&nbsp;</td></tr>
									<tr><td><?php include('adminfooter.php') ?></td></tr>
						</table>
					</td>
			  </tr>
			</table>
		</div>
	</body>
</html>
