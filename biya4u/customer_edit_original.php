<?php 
include('protect.php');
include 'dbconnect.php';

$md_edit = $_REQUEST['ed'];

 ?>

<?php
if(isset($_REQUEST['submit']))
{
	$nam=$_REQUEST['nam'];
	
    $address=$_REQUEST['address'];
	
	$city=$_REQUEST['city'];
	
	
	$phone=$_REQUEST['phone'];$tin=$_REQUEST['tin'];
    
	
$upd_query = mysqli_query($conn, "update customer set name='$nam',address='$address',city='$city',phone='$phone',tin='$tin' where id ='$md_edit' ")or die (mysqli_error());

print "<script>";
print "self.location='edit_confirm7.php'";
print "</script>";

}

function salt($table,$name,$it)
  {
	  
	  $query=mysqli_query($conn, "select * from  ".$table." order by category Asc ");
	  ?>
      <select name="<?=$name?>" style="width:250px;">
	  
	  <option value="">--select--</option>
	  
	  
	  <?php
	  while($row=mysqli_fetch_assoc($query))
	  {
		  ?>
          <option value="<?=$row['id']?>" <?php if($it==$row['id']) { ?> selected="selected"<?php } ?>><?=$row['category']?></option>
          <?php
		  
	  }
	  
	  ?> </select><?php
	  
	  
  }
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/style.css" type="text/css"  rel="stylesheet"/>

<title>Admin</title>
	<script src="../js/jquery.js" type="text/javascript"></script>
<script src="../js/jquery.validate.js" type="text/javascript"></script>
 

<script type="text/javascript"> 


jQuery(document).ready(function() {
 
	jQuery("#form1").validate({
		rules: {
		
	fname: { required: true },
	
	/*email: { required: true, minlength: 5,email:true,remote: "emails.php"  },*/
	phone: { required: true },
					
		errorElement: "label",
		messages: {
		
			/*email: {
				required: " Please enter your email address",
				email: " Please enter a valid email address",
				minlength: " Email : at least 5 characters long",
				remote: jQuery.format(" {0} is aCKeady in use")
			},*/
			
		
			
			},
		
		}
	});
	
});
 
</script>



<script type="text/JavaScript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
window.open(theURL,winName,features);
}
</script>
</head>

<body style="background:#FFF;">
<div align="center" style="background:#FFF;">

<table width="580" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF" >

  <tr>
    <td><p>&nbsp;</p>
      <div align="center" class="style2"><strong> Edit Customer Details</strong></div>
     </td>
  </tr>


  
  
  
   

  <tr><td ><br />
  <?php 
  $row = getAssociativeArrayFromSQL($conn, "select * from customer where id = '$md_edit' ");
   ?>
      <table width="100%" border="0" cellspacing="3" cellpadding="3" class="sub_cont">
        <tr>
          <td ><form id="form1" name="form1" method="post" action="">
              <table width="98%" border="0">
                <tr>
                  <td width="28%">Name</td>
                  <td width="72%">
                  
                    <?php
				  
				  $search  = array('"', "'");
$replace = array('&quot;', '&#39;');
				  
				  
				 
				  
				  
				  ?>
                  
                  
                  
                  
                  
                  <input type="text" name="nam" value="<?php echo stripslashes(str_replace($search, $replace,$row['name']));?>"  onkeyup="showHint(this.value)" id='cat' style="width:255px;"/>                    <input type="hidden" name="regid" id="regid" value="<?php htmlspecialchars(stripslashes($md_edit)); ?>"  /></td>
                </tr>
                <tr>
                  <td>Address</td>
                  <td><textarea name="address" cols="30" rows="5"><?php echo stripslashes(str_replace($search, $replace,$row['address']));?></textarea></td>
                </tr>
                <tr>
                  <td height="24">City</td>
                  <td><?php salt("bplace","city",$row['city']); ?></td>
                </tr>
                <tr>
                  <td>Phone</td>
                  <td><input type="text" name="phone" value="<?php echo stripslashes(str_replace($search, $replace,$row['phone']));?>" style="width:255px;"/></td>
                </tr>
                <tr>
                  <td>Tin</td>
                  <td><input type="text" name="tin" value="<?php echo stripslashes(str_replace($search, $replace,$row['tin']));?>" style="width:255px;"/></td>
                </tr>

                <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" name="submit" id="submit" value="Submit" /></td>
                </tr>
                <tr>
                  
                  <td colspan="2"></td>
                </tr>
              </table>
          </form></td>
        </tr>
        <tr>
          <td></td>
        </tr>
      </table>
      <br /></td></tr>
  

</table>
</div>
</body>
</html>
