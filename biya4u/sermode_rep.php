<?php 
  include('protect.php');
  include 'dbconnect.php'; 
  include('paging.class.php');


  if(isset($_REQUEST['del_id'])) {
    $del_id_net = $_REQUEST['del_id' ];
    $modpay_query=mysqli_query($conn, "select * from booking where servicemode='$del_id_net'");
    $modpay_num=mysqli_num_rows($modpay_query);
  
    if($modpay_num>0) {
      echo "<script type=\"text/javascript\">";
      echo "  alert(\"Cannot remove used service mode.\");";
      echo "  self.location='service_modes_list.php?action=delete&success=false';";
      echo "</script>";  
    }
    else {
      $del = mysqli_query($conn, "DELETE FROM servicemode WHERE id='$del_id_net' ") or die (mysqli_error());
      echo "<script type=\"text/javascript\">";
      echo "  alert('Successfully removed service mode.');";
      echo "  self.location='service_modes_list.php?action=delete&success=true';";
      echo "</script>";
    }
  }

  $total_results = (mysqli_query($conn, "SELECT COUNT(*) as Num FROM servicemode "));
  $row = mysqli_fetch_assoc($total_results);
  $totalCount = $row['Num'];

  if($totalCount ==0) {
    print "<script>";
    print "self.location='noresults.php';"; // Comment this line if you don't want to redirect
    print "</script>";
  }

  $pager = new pager($_GET['p'], 15, $totalCount, 4);
  $offset = $pager->get_start_offset();
  $limit = 15;

  // Perform MySQL query on only the current page number's results 
  $result = mysqli_query($conn, "SELECT * FROM servicemode  ORDER BY id desc LIMIT " . $offset . ", $limit ");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/style.css" type="text/css"  rel="stylesheet"/>
<link href="css/superfish.css" rel="stylesheet" media="screen">
<title>Admin</title>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/hoverIntent.js"></script>
<script src="js/superfish.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var example = $('#menuCKNavigation').superfish();
	});
</script
<script type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>

<body>
<div align="center">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  align="center">
  <tr>
    <td>
<table width="900" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF" >
  <tr>
    <td><?php include('adminheader.php') ?>
	</td>
  </tr>
  <tr>
    <td><p>&nbsp;</p>
      <div align="center" class="style2"><strong> Service Mode</strong></div>
     </td>
  </tr>

  <tr><td><table width="98%" border="0" align="center" cellpadding="3" cellspacing="3">
              <tr>
                <td width="54%"><span class="Closed"><strong><?php echo $totalCount; ?> </strong></span><strong>Results Found</strong>.</td>
                <td width="46%"><div align="right"><?php echo $links = $pager->get_links(); ?></div></td>
              </tr>
              
            </table>  <br />

</td></tr>
  
  
  
    <tr><td width="187"><?php if($_REQUEST['succ']=='yes'){echo "<span class='style3'>Succesfully</span>" ;} ?> </td>   
  </tr>

  <tr><td >
  <table width="55%" border="0"  cellspacing="0" cellpadding="5" align="center" id="tab_bg" style="border:1px solid #F0F0F0;">
  <tr  id="head_bg"  bgcolor="#F4F4F4">
   
      
	    <td class="wht_txt" width="19%"><div align="left"><strong>Id</strong></div></td>
			 	
             
         		 <td class="wht_txt" width="19%"><div align="left"><strong>Service Mode</strong></div></td>	
			 <td class="wht_txt" width="12%"><div align="left"><strong>Action </strong></div></td>
    </tr>


  <?php 
while($fet_2=mysqli_fetch_array($result))
{
//	include('results.php');
	?>	
  <tr>
     <td   width="13%"><?php  echo $fet_2['id']; ?></td>
    <td   width="13%"><?php  echo stripslashes($fet_2['category']); ?></td>
	<td   width="19%"><a href="#" onClick="MM_openBrWindow('sermode_edit.php?ed=<?php echo  $fet_2['id']; ?> ','','scrollbars=yes,left=300,top=150,width=600,height=500')"   >Edit </a> &nbsp;&nbsp; <a href="?del_id=<?php echo  $fet_2['id']; ?>"  onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
	
  </tr> 
<tr><td colspan="8" style="border-bottom:1px dashed #D7D7D7;"></td></tr>
   <?php }?>
</table>

  
  <br />
  <br /></td></tr>
  
<tr>
    <td><?php include('adminfooter.php') ?></td>
  </tr>
</table>
</td>
  </tr>
</table></div>
</body>
</html>
