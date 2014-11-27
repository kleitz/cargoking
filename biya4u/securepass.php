<?php 
	include('protect.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link href="css/style.css" rel="stylesheet" type="text/css">
		<link href="css/superfish.css" rel="stylesheet" media="screen">
		<script src="js/jquery-1.11.1.min.js" type="text/javascript"></script>
		<script src="js/jquery.validate.min.js" type="text/javascript"></script>
		<script src="js/hoverIntent.js" type="text/javascript"></script>
		<script src="js/superfish.js" type="text/javascript"></script>
		<script type="text/javascript" type="text/javascript">
			$.validator.addMethod('custompassword', function (value, element) {
				return this.optional(element) || /^[a-zA-Z0-9_]+$/.test(value);
			}, "Please enter a valid password [Letters and Numbers only].");

			$(document).ready(function(){
				var example = $('#menuCKNavigation').superfish();
				$("#signupForm").validate({
					rules: {
						adminOldPassword: {
							required: true,
							minlength: 4,
							maxlength: 25,
							custompassword: true
						},
						adminNewPassword: {
							required: true,
							minlength: 4,
							maxlength: 25,
							custompassword: true
						},
						adminConfirmPassword: {
							required: true,
							minlength: 4,
							maxlength: 25,
							custompassword: true,
							equalTo: "#txtAdminConfirmPassword"
						}
					},
					
					messages: {
						adminOldPassword: {
							required:  "Please enter current password.",
							minlength: "Password should be atleast 4 characters.",
							maxlength: "Password should be no more than 25 characters."
						},
						adminNewPassword: {
							required:  "Please enter new password.",
							minlength: "Password should be atleast 4 characters.",
							maxlength: "Password should be no more than 25 characters."
						},
						adminConfirmPassword: {
							required:  "Please confirm new password.",
							minlength: "Password should be atleast 4 characters.",
							maxlength: "Password should be no more than 25 characters.",
							equalTo:   "The new password and the confirmation password are not equal."
						}
					},

					errorContainer: $('#errorContainer'),
					errorLabelContainer: $('#errorContainer ul'),
					wrapper: 'li'
				});
			});
		</script>
		<title>Set Admin Password</title>
	</head>

	<body>
		<table width="960" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="white" id="Outer">
			<tr>
				<td>
					<table width="100%" border="0" cellpadding="0" cellspacing="0" id="inner">
						<tr>
							<td colspan="2"><?php include("adminheader.php");?></td>
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
							<td width="80%" valign="top">
								<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
									<tr>
										<td>&nbsp;</td>
										<td class="headertext">&nbsp;</td>
									</tr>
									<tr>
										<td width="3%">&nbsp;</td>
										<td width="97%" class="headertext">SET ADMIN PASSWORD</td>
									</tr>
								</table>
								<br />
								<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
									<tr>
										<td>
											<div align="center" class="smalltextgrey">
												<div align="left" class="smalltextgrey" style="margin-left: 30px;">Below is the list of Administrator Password. You can   change/edit admin's password</div>
											</div>
										</td>
									</tr>
								</table>
								<br />
								<form id="signupForm" name="signupForm" method="post" action="securepass_submit.php"> 
									<table border="0" align="center" cellpadding="3" cellspacing="3" class="blackbox" style="width: 50%; padding: 10px;">
										<tr>
											<td style="width: 40%; padding-left: 15px;"><label for="txtAdminOldPassword">Current Password  :</label></td>
											<td style="width: 60%;"><input id="txtAdminOldPassword" name="adminOldPassword" type="password" class="form-field" size="25" /></td>
										</tr>
										<tr>
											<td style="width: 40%; padding-left: 15px;"><label for="txtAdminNewPassword">New Password  :</label></td>
											<td style="width: 60%;"><input id="txtAdminNewPassword" name="adminNewPassword" type="password" class="form-field" size="25" /></td>
										</tr>
										<tr>
											<td style="width: 40%; padding-left: 15px;"><label for="txtAdminConfirmPassword">Confirm Password :</label></td>
											<td style="width: 60%;"><input id="txtAdminConfirmPassword" name="adminConfirmPassword" type="password" class="form-field" size="25" /></td>
										</tr>
										<tr>
											<td style="width: 40%; padding-left: 15px;">&nbsp;</td>
											<td style="width: 60%;"><input type="submit" name="Submit" value="Submit" /></td>
										</tr>
									</table>
								</form>
								<p>&nbsp;</p>
							</td>
						</tr>
						<tr>
							<td colspan="2"><?php include("adminfooter.php");?></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>
