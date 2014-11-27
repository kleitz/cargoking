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
				$("#btnAddLocation").button();
					var sf = $('#menuCKNavigation').superfish();
					$("#formLocation").validate({
						rules:{
							location: {
								required:true,
								maxlength: 15,
								minlength: 4,
								remote: {
									url: "check_location.php",
									type: "post",
									data: {
										location: function() {
											return $("#txtLocation").val();
										}
									}
								}
							}
						},
								messages: {
									location: {									
										required: "Please fill the location.",
										maxlength: "The maximum length of of location not exceed 15 characters.",
										minlength: "The minimum length of location should be 4 characters.",
										remote: "Location address is already Exists. Please try another one."
									}
								
								},
								errorContainer: $('#errorContainer'),
								errorLabelContainer: $('#errorContainer ul'),
								wrapper: 'li'
					});
					if( action == "add" && success == "true"){
						$("#trStatusDisplay").show();
						$("#divStatusMessage").html("Successfully added a location.").show();
					}
					else if( action == "delete" && success == "true"){
						$("#trStatusDisplay").show();
						$("#divStatusMessage").html("Successfully deleted a location.").show();
					}
					else if( action == "delete" && success == "false"){
						$("#trStatusDisplay").show();
						$("#divStatusMessage").html("Cannot deleted active location.").show();
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
														<td width="187"><?php include('adminheader.php') ?></td>
													  </tr>
													  <tr>
														<td>
															<div id="errorContainer">
																<ul />
															</div>
														</td>
													</tr>
													<tr>
												  <tr>
														<td ><p align="center" class="style1"> Add Location</p>
																
																		<?php 
																			if($_POST['submit']) {
																			
																				echo "hello<br>";
																				
																				$location = mysqli_real_escape_string($conn, $_REQUEST['location']);
																				$address  = mysqli_real_escape_string($conn, $_REQUEST['address']);
																				
																				$SQLInsert  = " insert into bplace (category, address) ";
																				$SQLInsert .= " values ('" . $location . "', '" . $address . "')";
																				$successInsertion = mysqli_query($conn,  $SQLInsert );
																				
																				echo "[SQL]: " . $SQLInsert . "<br>";

																			if( $successInsertion ) {	
																				//echo $_POST['des'];  $obj->valid($_POST['cat']);
																		  
																		?>
																				<script type="text/javascript">
																				//alert("Successfully added a vehicle!");
																				self.location='bookpl_rep1.php?action=add&succes=true';
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
																		
																
																<form id="formLocation" name="formLocation" action="" method="post">
																<table align="center">
																	<tr>
																		  <td width="166">Location</td>
																		  <td width="161"><input type="text" id='txtlocation' name="location" value="<?php echo $_REQUEST['location']; ?>" class="form-field" /></td>
																	</tr>
																	<tr>
																		  <td width="166" valign="top">Location Office Address</td>
																		  <td width="161"><textarea id="txtlocationaddress" name="address" rows="4" class="form-field"></textarea></td>
																	</tr>
																	<tr>
																		  <td width="166"></td>
																		  <td width="161"><input type="submit" id="btnAddLocation" name="submit" value="Submit" /></td>
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
