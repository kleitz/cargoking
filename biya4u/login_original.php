<?php 
	session_start();
	include("securimage.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Login</title>
		<style>
			body {
				background-color: #FFFFFF;
				background-image: url(images/backgrounds/squared_metal_2X.png);
				background-repeat: repeat; /* repeat-x */
				background-position: left top;

				font-family: 'OpenSanRegular';

				/*
				background-color: #2b1313;
				background-image: url("../images/webtreats/background_img.jpg");
				*/
			}

			.tb10 {
				/*
				background-image:url(images/form_bg.jpg);
				background-repeat:repeat-x;
				*/
				border:1px solid #d1c7ac;
				width: 150px;
				color:#333333;
				padding:3px;
				margin-right:4px;
				margin-bottom:8px;
				font-family:tahoma, arial, sans-serif;
			}

			.lired {
				font-family:  Verdana;
				font-size: 11px;
				line-height: 1.5em;
				font-weight: bold;
				color:#0069D2;
				text-decoration: none;
			}

			.MdHeading {
				FONT: bold 13px Arial, Helvetica, sans-serif
			}
			.red {
				font-family:  Arial;
				font-size: 12px;
				line-height: 1.5em;
				font-weight: normal;
				color:#FF0000;
				text-decoration: none;
			}
			.formcommentstxt {
				FONT-WEIGHT: normal; FONT-SIZE: 11px; TEXT-TRANSFORM: none; COLOR: #595959; FONT-STYLE: normal; FONT-FAMILY: arial, verdana
			}
			.staff
			{ font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; color:#0066FF;

			}
		</style>
		<script language="javascript">
			<!--
			function memloginvalidate() {
			   if(document.form1.txtusername.value == "")
				 {
					alert("Please enter admin Username.");
					document.form1.txtusername.focus();
					return false;
				 }
			   if(document.form1.txtpassword.value == "")
				 {
					alert("Please enter admin Password.");
					document.form1.txtpassword.focus();
					return false;
				 }
				   if(document.form1.code.value == "")
				 {
					alert("Please enter Code.");
					document.form1.code.focus();
					return false;
				 }
			}
			//-->
		</script>
	</head>
	<body bgcolor="#e6e2e3" onLoad="document.form1.txtusername.focus();" >
		<p align="center"><br />
		  <br />
		  <br />
		  <br />
		  <br />
		</p>
		<table width="361" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center"><img src="images/adminheader.jpg" /></td>
			</tr>
			<tr>
				<td style="background-image:url(images/center.jpg); background-repeat:repeat-y;">
					<br />
					<form id="form1" name="form1" method="post" action="login_submit.php" onsubmit="return memloginvalidate()">
						<table width="281" border="0" align="center">
							<tr>
								<td colspan="3" class="red">
									<?php 
										$StrAction = "";
										if( isset($_GET['Action']) ) $StrAction = $_GET['Action'];
										if ($StrAction == "wrong") {
											echo "<table width=97% border=0 cellpadding=0 cellspacing=0 >";
											echo "<tr>";
											echo "<td class=Alert><strong>Please Correct the Following errors.</strong> </td>";
											echo "</tr>";
											echo "<tr>";
											echo "<td><ul class=Alert>";
											echo "<li>Invalid Admin Username or Incorrect Password.</li>";
											echo "<li>Make sure that the Caps Lock or A light is switched off on your keyboard   before trying again. </li>";
											echo "<li>Please Specify Password. </li>";
											echo "</ul></td>";
											echo "</tr>";
											echo "</table>";
										}
										else if ($StrAction == "wrongall") {
											echo "<table width=97% border=0 cellpadding=0 cellspacing=0 >";
											echo "<tr>";
											echo "<td class=Alert><strong>Please Correct the Following errors.</strong> </td>";
											echo "</tr>";
											echo "<tr>";
											echo "<td><ul class=Alert>";
											echo "<li>Invalid Admin Username or Incorrect Password.</li>";
											echo "<li>Make sure that the Caps Lock or A light is switched off on your keyboard   before trying again. </li>";
											echo "<li>Please Specify Password. </li>";
											echo "</ul></td>";
											echo "</tr>";
											echo "<tr>";
											echo "<td><ul class=Alert>";
											echo "<li>Please enter Code.</li>";
											echo "</ul></td>";
											echo "</tr>";
											echo "</table>";
										}
										else if ($StrAction == "captchap") {
											echo "<table width=97% border=0 cellpadding=0 cellspacing=0 >";
											echo "<tr>";
											echo "<td><ul class=Alert>";
											echo "<li>Please enter Code.</li>";
											echo "</ul></td>";
											echo "</tr>";
											echo "</table>";
										}
										else if($StrAction == "captcha") {
											echo "<table width=97% border=0 cellpadding=0 cellspacing=0 >";
											echo "<tr>";
											echo "<td><ul class=Alert>";
											echo "<li>Sorry, the code you entered was invalid.</li>";
											echo "</ul></td>";
											echo "</tr>";
											echo "</table>";
										}
									?>
								</td>
							</tr>
							<tr>
								<td width="94" height="40" class="formcommentstxt" style="padding-right: 5px;">Username</td>
								<td width="5">:</td>
								<td width="168"><input name="txtusername" type="text" class="tb10"  id="txtusername" maxlength="20" /></td>
							</tr>
							<tr>
								<td height="40" class="formcommentstxt">Password</td>
								<td>:</td>
								<td><input name="txtpassword" type="password" class="tb10" id="txtpassword" maxlength="20" /></td>
							</tr>
							<tr>
								<td height="40" class="formcommentstxt">Verification Code</td>
								<td>:</td>
								<td><input type="text" name="code" id="code" Class="tb10" maxlength="50" /></td>
							</tr>
							<tr>
								<td height="40" class="MdHeading"></td>
								<td></td>
								<td><div align="left"><img src="securimage_show.php?sid=<?php echo md5(uniqid(time())); ?>" border="1" /></div></td>
							</tr>
							<tr>
								<td height="27"></td>
								<td></td>
								<td><input name="Submit" type="Image" src="images/sub.jpeg" value="Login" /></td>
							</tr>
							<tr>
								<td height="27" colspan="3" style="font-size: 8pt; color: #555; text-align: center;"><div align="center" class="formcommentstxt">  Your IP Address is <?php echo $_SERVER['REMOTE_ADDR'];  ?></div></td>
							</tr>
							<tr>
								<td height="27" colspan="3" align="center" class="staff" >&nbsp;</td>
							</tr>
						</table>
					</form>  
				</td>
			</tr>
			<tr>
				<td ><img src="images/footer.jpg" width="361" height="23" /></td>
			</tr>
		</table>
		<div align="center"><span style="font-family: Tahoma, Verdana, sans-serif; font-size: 9px; color: rgb(0, 0, 0)">&nbsp;</span></div>
	</body>
</html>
