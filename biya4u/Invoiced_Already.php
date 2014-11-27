<?php 
include('protect.php');
include 'dbconnect.php'; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/style.css" type="text/css"  rel="stylesheet"/>
<title>Admin</title>

<style type="text/css">
<!--
.style6 {font-family: Arial, Helvetica, sans-serif; font-size: 16px; font-weight: bold; color: #000000; text-decoration:none; line-height:30px;}
.style6 a {font-family: Arial, Helvetica, sans-serif; font-size: 16px; font-weight: bold; color: #000000; text-decoration:none; }
-->
</style>
</head>

<body>
<div align="center">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  align="center">
  <tr>
    <td>
<table width="950" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include('adminheader.php') ?>

	</td>
  </tr>
  
  <tr><td align="center" valign="middle">

 

<br />
<br />

 <span class="content"><strong>Your HAWB No:<?=$_REQUEST['bo']?>
  Already Invoiced You Cannot Delete.</strong></span> <a href="index.php" class="Alert">Continue </a> <br />
<br />
<br />
<br />
<br />

  </td></tr>
  
  <tr>
    <td>  
<br />

</td>
  </tr>
<tr>
    <td><?php include('adminfooter.php') ?></td>
  </tr>
</table>
</td>
  </tr>
</table></div>
</body>
</html>
