<?php 
  include('protect.php');
  include 'dbconnect.php'; 
  include('paging.class.php');

  $action = "";
  $success = "";
  if( isset($_REQUEST['action']) ) $action = $_REQUEST['action'];
  if( isset($_REQUEST['success']) ) $success = $_REQUEST['success'];

  if(isset($_REQUEST['del_id'])) {
    $del_id_net = $_REQUEST['del_id' ];
    $modpay_query = mysqli_query($conn, "select * from booking where status='$del_id_net'");
    $modpay_num = mysqli_num_rows($modpay_query);
  
    if($modpay_num>0) {
      echo "<script type=\"text/javascript\">";
      echo "  alert(\"Cannot remove used status type.\");";
      echo "  self.location='status_types_list.php?action=delete&success=false';";
      echo "</script>";  
    }
    else {
      $del = mysqli_query($conn, "DELETE FROM status WHERE id='$del_id_net' ") or die (mysqli_error());
      echo "<script type=\"text/javascript\">";
      echo "  alert('Successfully removed status type.');";
      echo "  self.location='status_types_list.php?action=delete&success=true';";
      echo "</script>";
    }
  }

  $total_results = (mysqli_query($conn, "SELECT COUNT(*) as Num FROM status ")); 
  $row = mysqli_fetch_assoc($total_results);
  $totalCount = $row['Num'];

  $pager = new pager($_GET['p'], 15, $totalCount, 4);
  $offset = $pager->get_start_offset();
  $limit = 15;

  $result = mysqli_query($conn, "SELECT * FROM status ORDER BY id ASC LIMIT " . $offset . ", $limit ");
  $recordCount = mysqli_num_rows($result);
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
</script>
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
      <div align="center" class="style2"><strong> Status</strong></div>
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
    <tr id="head_bg"  bgcolor="#F4F4F4">
      <td class="wht_txt" width="19%"><div align="left"><strong>Id</strong></div></td>
      <td class="wht_txt" width="19%"><div align="left"><strong>Status</strong></div></td>	
      <td class="wht_txt" width="12%"><div align="left"><strong>Action </strong></div></td>
    </tr>


  <?php 
while($fet_2 = mysqli_fetch_array($result)) {
	if($fet_2['category']=="DELIVERED")
		continue;
	?>	
  <tr>
     <td   width="13%"><?php  echo $fet_2['id']; ?></td>
    <td   width="13%"><?php  echo stripslashes($fet_2['category']); ?></td>
	<td   width="19%"><a href="#" onClick="MM_openBrWindow('status_edit.php?ed=<?php echo  $fet_2['id']; ?> ','','scrollbars=yes,left=300,top=150,width=600,height=500')"   >Edit </a></td>
	
  </tr>
  <?php
    }
  ?> 
   <?php 
   	$result=mysqli_query($conn, "select * from status where category='DELIVERED'");
while($fet_2=mysqli_fetch_array($result))
{
?>
  <tr>
  	<td><?php  echo $fet_2['id']; ?></td>
     <td   width="13%"><?php  echo stripslashes($fet_2['category']); ?></td>
     <td>&nbsp;</td>
  </tr>
  <?php } ?>
<tr><td colspan="8" style="border-bottom:1px dashed #D7D7D7;"></td></tr>   
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
