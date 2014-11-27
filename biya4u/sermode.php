<?php 
include('protect.php');
include 'dbconnect.php'; 
 include('paging.class.php');
  //status 
/* $status=$_REQUEST['status'];
$row_id = mysqli_query($conn, "update testimonial set status = 'InActive' where id = '$status'  ") or die (mysqli_error());
*/

class regis
{

function valid($a)
{
$all=array($a);

$err=array('Please Fill The Service Mode');
echo "<ul style='line-height:20px; color:red;'>";for($i=0;$i<count($all);$i++)
{

if($all[$i]=='')
{
echo "<li>".$err[$i]."</li>";
$ok=1;
}
if($all[$i]!=='')
{

$cat=mysqli_real_escape_string($conn, $_POST['cat']);

$query=mysqli_query($conn, "select * from servicemode where category='$cat'");


$num=mysqli_num_rows($query);

if($num>0)
{
echo "<li>Service Mode already Exists</li>";

$ok=1;


}


}

}
echo "</ul>";
if($ok!=1)
 {
 
$insert= mysqli_query($conn, "insert into servicemode values('','$cat')");
 if($insert)
 {
 
 ?><script type="text/javascript">alert('Service Mode Added Successfully'); self.location='sermode.php';</script><?php
 
 
 }
 }
}
}

$obj=new regis;


 
  




//$select_link=mysqli_query($conn, "select * from testimonial");
  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
<script type="text/javascript">
	$(document).ready(function(){
		var example = $('#menuCKNavigation').superfish();
	});
</script



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
    <td ><p align="center" class="style1"> Add Service Mode</p>
        <span class="">
        <?php if($_POST['submit'])
{

 echo $_POST['des'];
 $obj->valid($_POST['cat']);
 
 
 
 }   ?>
        </span>
        <table align="center">
          <form action="" method="post">
            <tr>
              <td width="132">Service Mode</td>
              <td width="144"><input type="text" name="cat" value="<?php echo $_REQUEST['cat']; ?>"  onkeyup="showHint(this.value)" id='cat'/></td>
            </tr>
            <tr>
              <td width="132"></td>
              <td width="144" id='txtHint'></td>
            </tr>

            <tr>
              <td width="132"></td>
              <td width="144"><input type="submit" name="submit" value="Submit" /></td>
            </tr>
          </form>
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
