<?php 
	include('protect.php');
	include('dbconnect.php');
	include('constants.php');

	$adminNewPassword = "";
	if( isset($_POST['adminNewPassword']) ) $adminNewPassword = $_POST['adminNewPassword'];
	
	$SQLUpdate = "UPDATE users SET password ='$adminNewPassword' WHERE id=" . ADMIN_ID;
	$updateAdminPassword = mysqli_query($conn, $SQLUpdate);

	session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link href="css/style.css" rel="stylesheet" type="text/css">
		<link href="css/superfish.css" rel="stylesheet" media="screen">
		<title>Set Admin Password</title>
	</head>
	<body>
		<table width="960" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="white" id="Outer">
			<tr>
				<td>
					<table width="100%" border="0" cellpadding="0" cellspacing="0" id="inner">
						<tr>
							<td colspan="2"><?php include("adminheader.php"); ?></td>
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
										<td width="97%" class="headertext">SET ADMIN PASSWORD </td>
									</tr>
								</table>
								<br />
								<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
									<tr>
										<td>
											<div align="center" class="smalltextgrey">
												<div align="left" class="smalltextred"></div>
											</div>
										</td>
									</tr>
								</table>
								<p>&nbsp;</p>
								<table width="90%" border="0" align="center" cellpadding="3" cellspacing="3" class="blackbox">
									<tr>
										<td width="40%">&nbsp;</td>
										<td width="60%">&nbsp;</td>
									</tr>
									<tr>
										<td colspan="2"><div align="center">Admin Password has been changed Success. </div></td>
									</tr>
									<tr>
										<td colspan="2">&nbsp;</td>
									</tr>
								</table>
								<p>&nbsp;</p>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<?php include("adminfooter.php");?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>