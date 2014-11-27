<?php
	include('protect.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link href="css/style.css" type="text/css"  rel="stylesheet"/>
		<title>Admin</title>
		<script language=JavaScript>
			function win(){
				window.opener.location.href="man_users.php";
				self.close();
			}
		</script>
	</head>
	<body>
		<div align="center">
			<table width="580" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF" >
				<tr>
					<td>
						<p>&nbsp;</p>
						<div align="center" class="big_text"><strong>Update Confirmation</strong></div>
					</td>
				</tr>
				<tr>
					<td>
						<table width="100%" height="200" border="0" cellspacing="3" cellpadding="3" class="sub_cont">
							<tr><em></em>
								<td align="center">
									<strong>Updated Successfully.</strong>
									<br />
									<br />
									<br />
									<div align="center">
										<input name="button" type="button" class="green-button" onclick="win();" value="Close window" />
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>
