<?php 
session_start();
include('protect.php');
include 'dbconnect.php'; 
 include('paging.class.php');
 
 if(isset($_POST['submit']))
 {
 	$id=$_POST['userid'];
	$pre=$_POST['pre'];
	$from=$_POST['from'];
	$to=$_POST['to'];
	
	if($from >= $to)
	{
		echo ("<script>alert('There is error in series.. Ending Series Number must be greater than Starting Series Number. Please check again..'); window.location='user_hawb.php?id=".$id."&pre=".$pre."&from=".$from."&to=".$to."';</script>");
	}
	else
	{
	$query=mysqli_query($conn, "update user set hawbprefix='$pre' , hawbfrom='$from', hawbto='$to' where id='$id'");
	if($query)
		echo ("<script>alert('HAWB Alloted for this User'); window.location='user_confirm.php';</script>");
	else
		echo mysqli_error($conn);
	}
 }
  
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
    <td ><p align="center" class="style1">HAWB Allotment</p>
        
        <table width="883" align="center">
        <tr><td width="570">  <table width="721"><form action="" method="post" name="user" id="user">
			 <tr>
             	<td>User's Name</td>
                <td><input type="text" name="name" id="name" value="<?=$rs['name']?>" readonly="readonly" /><input type="hidden" name="userid" id="userid" value="<?=$id?>" /></td>
             </tr>
             <tr>
             	<td>User's HAWB Series - Prefix</td>
                <td><input type="text" name="pre" id="pre" value="<?=$_REQUEST['pre']?>" /></td>
             </tr>
             <tr>
             	<td>User's HAWB Series - From</td>
                <td><input type="text" name="from" id="from" value="<?=$_REQUEST['from']?>" /></td>
             </tr>
             <tr>
             	<td>User's HAWB Series - To</td>
                <td><input type="text" name="to" id="to" value="<?=$_REQUEST['to']?>" /></td>
             </tr>
            <tr>
              <td width="216"></td>
              <td width="493"><input type="submit" name="submit" value="Submit" /></td>
            </tr>
          </form></table>
          
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
