<?php 
include('protect.php');
include 'dbconnect.php'; ?>

<?php
if(isset($_REQUEST['submit']))
{

$fname = $_POST['fname'];
$add = $_POST['add'];

$id=$_GET['ed'];
// update registration details


$upd_query = mysqli_query($conn, "update bplace set category ='$fname',address='$add' where id ='$id' ")or die (mysqli_error());
print "<script>";
print "self.location='bookpl_confirm.php'";
print "</script>";

}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/style.css" type="text/css"  rel="stylesheet"/>
<link href="css/superfish.css" rel="stylesheet" media="screen">
<title>Admin</title>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.validate.js" type="text/javascript"></script>
<script src="js/hoverIntent.js"></script>
<script src="js/superfish.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var example = $('#menuCKNavigation').superfish();
	});
</script>

<script type="text/javascript"> 


jQuery(document).ready(function() {
 
	jQuery("#form1").validate({
		rules: {
		
	fname: { required: true },
	
	/*email: { required: true, minlength: 5,email:true,remote: "emails.php"  },*/
	phone: { required: true },
					
		errorElement: "label",
		messages: {
			
		
			
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

<body>
<div align="center">

<table width="580" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF" >

  <tr>
    <td><p>&nbsp;</p>
      <div align="center" class="style2"><strong> Edit Category </strong></div>
     </td>
  </tr>


  
  
  
   

  <tr><td ><br />
  <?php $md_edit = $_REQUEST['ed'];
  $row = getAssociativeArrayFromSQL($conn, "select * from bplace where id = '$md_edit' ");
   ?>
   
    
                  <?php
				  
				  $search  = array('"', "'");
$replace = array('&quot;', '&#39;');
				  
				  
				 
				  
				  
				  ?>
   
   
   
      <table width="100%" border="0" cellspacing="3" cellpadding="3" class="sub_cont">
        <tr>
          <td ><form id="form1" name="form1" method="post" action="">
              <table width="98%" border="0">
                <tr>
                  <td width="28%">Location*</td>
                  <td width="72%">
                  <input type="text" name="fname" id="fname" value="<?php echo stripslashes(str_replace($search, $replace,$row['category']));?>" style="width:220px;" />
                  <input type="hidden" name="regid" id="regid" value="<?=$md_edit; ?>"  /></td>
                </tr>
				<tr>
                  <td width="28%" valign="top">Location Address</td>
                  <td width="72%">
                  <textarea name="add" id="add" style="width:220px;" rows="4"><?php echo stripslashes(str_replace($search, $replace,$row['address']));?></textarea></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" name="submit" id="submit" value="Submit" /></td>
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
