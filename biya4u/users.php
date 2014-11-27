<?php 
session_start();
include('protect.php');
include 'dbconnect.php'; 
 include('paging.class.php');
 function salt($table,$name)
  {
	  
	  $query=mysqli_query($conn, "select * from  ".$table." order by category Asc ");
	  ?>
      <select name="<?=$name?>" style="width:250px;">
	  
	  <option value="">--select--</option>
	 	  
	  <?php
	  while($row=mysqli_fetch_assoc($query))
	  {
		  ?>
          <option value="<?=$row['id']?>"><?=$row['category']?></option>
          <?php } ?></select><?php } ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/style.css" type="text/css"  rel="stylesheet"/>
<link href="css/superfish.css" rel="stylesheet" media="screen">
<title>Admin</title>
<style type="text/css">
<!--
.style1 {font-size: large;}
-->
</style>

<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/hoverIntent.js"></script>
<script src="js/superfish.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	var example = $('#menuCKNavigation').superfish();
	$("#user").validate({
			rules: {
				nam: {
					required:true
				},
				city:
				{
					required:true
				},
				phone:
				{
					required:true
				},
				tin:
				{
					required:true,
					email:true
				},
				uname:
				{
					required:true,
					remote: "uname.php",
					maxlength:8,
					minlength:4
				},
				pwd:
				{
					required:true,
					maxlength:8,
					minlength:4
				},
				pwd1:
				{
					required:true,
					equalTo: "#pwd",
					maxlength:8,
					minlength:4
				}
				
			},
			
			messages: {
				uname: {
					remote: "Username Already Exists. Please try another one."
					
				},
				pwd1:
				{
					equalTo: "Please Re-Enter the Correct Password"
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
	<table width="900" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF" >
  <tr>
    <td width="187"><?php include('adminheader.php') ?>	</td>
  </tr>
  <tr>
    <td ><p align="center" class="style1"> Add User Details</p>
        <span class="">
        <?php if($_POST['submit'])
{

$nam=mysqli_real_escape_string($conn, $_REQUEST['nam']);

$phone=mysqli_real_escape_string($conn, $_REQUEST['phone']);


$city=mysqli_real_escape_string($conn, $_REQUEST['city']);

$tin=mysqli_real_escape_string($conn, $_REQUEST['tin']);

$uname=$_REQUEST['uname'];

$pwd=$_REQUEST['pwd'];
 
 if($nam=='')
 {
	 $nam1="Please Enter Your Name";
	
	$ok=1; 
 }

 if($city=='')
 {
	 $city1="Please Enter Your City";
	
	$ok=1; 
 }

 if($ok!==1)
 {
	 $rand=rand();
	 
	 $rquery=mysqli_query($conn, "select * from user where rando='$rand'");
	 
	 if(mysqli_num_rows($rquery)>0)
	 {
		 $ram=rand();
	 }
	 else
	 {
		 $ram=$rand;
	 }
	 
	$query=mysqli_query($conn, "insert into user (name,city,phone,rando,email,username) values ('$nam','$city','$phone','$ram','$tin','$uname')"); 
	 $rquery1=mysqli_query($conn, "select * from user where rando='$ram'");
	 
	$row=mysqli_fetch_assoc($rquery1);
	
	$id=$row['id'];
	$pre=$row['pref'];
	$tot=$pre.$id;
	$update=mysqli_query($conn, "update user set cusid='$tot' where id='$id'");
	
	$usequery=mysqli_query($conn, "insert into adminlogin (adminusername,adminpassword,member) values('$uname','$pwd','User')");
	
	if($query && $usequery)
	{
		?><script type="text/javascript">alert("User Details Submitted Successfully");
        self.location='man_users.php';
        </script><?php
	}
	
 }
 
 
 }   ?>
        </span>
        <table width="883" align="center">
        <tr><td width="570">  <table width="721"><form action="" method="post" name="user" id="user">
            <tr>
              <td width="103">Name</td>
              <td width="435"><input type="text" name="nam" value="<?php echo $_REQUEST['nam']; ?>"  onkeyup="showHint(this.value)" id='cat' style="width:255px;"/></td>
              <td width="17" style="color:red;"><?php echo $nam1; ?></td>
            </tr>
            <?php if($_SESSION['member']=="admin") { ?> 
            <tr>
              <td width="103">City</td>
              <td width="435"><?php salt("bplace","city"); ?></td>
              <td  style="color:red;"><?php echo $city1; ?></td>
            </tr>
            <?php }
			 if($_SESSION['member']=="Stationadmin") { 
			 	$stat=getAssociativeArrayFromSQL($conn, "select * from station where username='".$_SESSION['adminusername']."'");
				$city=getAssociativeArrayFromSQL($conn, "select * from bplace where id='".$stat['city']."'");
			 ?>
           	<tr>
              <td width="103">City</td>
              <td width="435"><input type="text" name="vcity" id="vcity" value="<?php echo $city['category']; ?>" style="width:255px;" readonly="readonly" /></td><input type="hidden" name="city" id="city" value="<?=$city['id']?>" />
              <td  style="color:red;"><?php echo $city1; ?></td>
            </tr>
           <?php } ?>
            <tr>
              <td width="103">Phone</td>
              <td width="435"><input type="text" name="phone" value="<?php echo $_REQUEST['phone']; ?>" style="width:255px;"/></td>
              <td  style="color:red;"><?php echo $phone1; ?></td>
            </tr>
           <tr>
              <td>Email</td>
              <td><input type="text" name="tin" id="tin" style="width:255px;" />              </td>
              <td  style="color:red;">&nbsp;</td>
            </tr>
            <tr>
              <td>Username</td>
              <td><input type="text" name="uname" id="uname" style="width:255px;" />              </td>
              <td  style="color:red;">&nbsp;</td>
            </tr>
             <tr>
              <td>Password</td>
              <td><input type="password" name="pwd" id="pwd" style="width:255px;" />              </td>
              <td  style="color:red;">&nbsp;</td>
            </tr>
            <tr>
              <td>Re-Enter Passsword</td>
              <td><input type="password" name="pwd1" id="pwd1" style="width:255px;" />              </td>
              <td  style="color:red;">&nbsp;</td>
            </tr>
            <!--<tr>
    			<td width="187" colspan="2"><p class="style1">HAWB Allotment</p></td>
  			</tr>
              <tr>
              <td colspan="3">HAWB Series <input type="text" name="pre" id="pre" size="10" /> <strong>Series</strong> From <input type="text" name="from" id="from" size="10" /> To <input type="text" name="to" id="to" size="10" /></td>
            </tr>-->         
            <tr>
              <td width="103"></td>
              <td width="435"><input type="submit" name="submit" value="Submit" /></td>
            </tr>
          </form></table>
          
          </td></tr><tr><td width="301">
          
          
          
          
          </td></tr>
        </table></td>
        
  </tr>

  
  <tr><td >&nbsp;</td>
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
