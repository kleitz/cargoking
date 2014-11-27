<?php 
session_start();
include('protect.php');
include 'dbconnect.php'; 

 $id=$_REQUEST['id'];
 $rs=getAssociativeArrayFromSQL($conn, "select * from user where id='$id'");
  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/style.css" type="text/css"  rel="stylesheet"/>

<title>Admin</title>
<style type="text/css">
<!--
.style1 {font-size: large;}
-->
</style>

<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $("#user").validate({
			
			rules: {
				pre:
				{
					required:true
				},
				from:
				{
					required:true,
					number:true,
					maxlength:6
				},
				to:
				{
					required:true,
					number:true,
					maxlength:6
				}
				
			}
		});
  
  
});
</script>
<SCRIPT language=JavaScript>
<!-- 
function win(){
window.opener.location.href="man_users.php";
self.close();
//-->
}
</SCRIPT>

</head>

<body>
<div align="center">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  align="center">
  
  <tr>
    
	<td>
	<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF" >
  <tr>
    <td width="187">&nbsp;</td>
  </tr>
  <tr>
    <td ><p align="center" class="style1">HAWB Allotment for <?=$rs['name']?></p>
        
        <table width="883" align="center">
        <tr><td width="570">  <table width="70%" align="center">
        	<tr>
            	<td align="center">HAWB Number starting from <strong><?=$rs['hawbprefix']?><?=$rs['hawbfrom']?></strong> to <strong><?=$rs['hawbprefix']?><?=$rs['hawbto']?></strong></td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
            </tr>
            <tr>
            	<td><div align="center">
            <input name="button" type="button" class="green-button" onclick="win();" value="Close window" />
          </div></td>
            </tr>
        </table>
          
          </td></tr><tr><td width="301">
          
          
          
          
          </td></tr>
        </table></td>
        
  </tr>

  
  <tr><td >&nbsp;</td>
  </tr>
  
<tr>
    <td>&nbsp;</td>
  </tr>
</table>
</td>
  </tr>
</table></div>
</body>
</html>
