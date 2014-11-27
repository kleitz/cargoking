<?php 
  include('protect.php');
  include('dbconnect.php');
  include('utilities.php');
  include('paging.class.php');
  include('constants.php');

  //status 
  /* $status=$_REQUEST['status'];
  $row_id = mysqli_query($conn, "update testimonial set status = 'InActive' where id = '$status'  ") or die (mysqli_error());
  */

  if(isset($_REQUEST['del_id'])) {
    $del_id_net = $_REQUEST['del_id' ];
    $modpay_query=mysqli_query($conn, "select * from booking where modpay='$del_id_net'");
    $modpay_num=mysqli_num_rows($modpay_query);

    if($modpay_num>0) {
?>
<script type="text/javascript">alert("List Available, So Can't Delete");
  self.location='mode_rep.php';
</script>
<?php
    }
    else {
      $del = mysqli_query($conn, "DELETE FROM mop WHERE id='$del_id_net' ") or die (mysqli_error());
?>
<script type="text/javascript">alert('One Record Deleted Successfully'); self.location='mode_rep.php';</script>
<?php
    }
  }

$total_results = (mysqli_query($conn, "SELECT COUNT(*) as Num FROM mop ")); 
	
$row = mysqli_fetch_assoc($total_results);
$totalCount = $row['Num'];

if($totalCount == 0) {
  print "<script>";
  print "self.location='noresults.php';"; // Comment this line if you don't want to redirect
  print "</script>";
}
	
$pager = new pager($_GET['p'], 15, $totalCount, 4);
$offset = $pager->get_start_offset();
$limit = 15;

// Perform MySQL query on only the current page number's results 
$result = mysqli_query($conn, "SELECT * FROM mop  ORDER BY id desc LIMIT " . $offset . ", $limit ");
//$select_link=mysqli_query($conn, "select * from testimonial");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Admin</title>
    <link href="css/style.css" type="text/css"  rel="stylesheet"/>
    <link href="css/superfish.css" rel="stylesheet" media="screen">
    <link href="css/blitzer/jquery-ui-1.10.4.custom.css" rel="stylesheet">
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery-ui-1.10.4.custom.min.js"></script>
    <script src="js/hoverIntent.js"></script>
    <script src="js/superfish.js"></script>
    <script type="text/javascript">
    	$(document).ready(function(){
    		var sf = $('#menuCKNavigation').superfish();
        $(".actionButtons, #lnkAddModeOfPayment").button();
        $("#tblModeOfPaymentList tr:even").css("background-color", "#FFE6E6");  /* #EBEBE0 */
    	});
    </script>
    <script type="text/JavaScript">
    <!--
    function MM_openBrWindow(theURL,winName,features) { //v2.0
      window.open(theURL,winName,features);
    }

    function deleteModeOfPayment(modeOfPaymentId) {
      var confirmDelete = false;
      if( confirmDelete = confirm("Are you sure you want to mode of payment?") ){
        location.href = "mode_rep.php?del_id=" + modeOfPaymentId;
      }
      return confirmDelete;
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
    <td>
      <p>&nbsp;</p>
      <div align="center" class="textShadow" style="font-size: 14px; font-weight: bold;">Mode of Payment</div>
    </td>
  </tr>
  <tr><td>&nbsp;</td></tr>
  
  <!--
  <tr>
    <td width="187"><?php if($_REQUEST['succ']=='yes'){echo "<span class='style3'>Succesfully</span>" ;} ?></td>   
  </tr>
  -->

  <tr>
    <td>
      <table width="55%" border="0" align="center" cellpadding="3" cellspacing="3">
        <tr>
          <td width="54%"><span class="Closed" style="padding-right: 10px;"><strong><?php echo $totalCount; ?> </strong></span><strong>Results Found</strong>.</td>
          <td width="46%"><div align="right"><?php echo $links = $pager->get_links(); ?></div></td>
        </tr>              
      </table>
    </td>
  </tr>

  <tr>
    <td>
      <table id="tblModeOfPaymentList" width="55%" border="0"  cellspacing="0" cellpadding="5" align="center" style="border:1px solid #181818; box-shadow: 3px 3px 3px #888888; margin-bottom: 10px;">
        <tr id="head_bg" style="border-bottom: 1px solid black;">
          <th width="10%" class="displayAllTableHeader">
            <strong>Id</strong>
          </th>
          <th class="displayAllTableHeader" width="60%"><div align="left"><strong>Mode of Payment</strong></div></th>
          <th class="displayAllTableHeader" width="30%"><div align="left"><strong>Action</strong></div></th>
        </tr>

<?php 
  while($fet_2=mysqli_fetch_array($result)) { 
?>	
  <tr>
    <td width="10%" align="center"><?php echo $fet_2['id']; ?></td>
    <td width="60%"><?php echo stripslashes($fet_2['category']); ?></td>
    <td width="30%">
      <a href="javascript:void(0);" class="actionButtons" onClick="MM_openBrWindow('mode_edit.php?ed=<?php echo  $fet_2['id']; ?> ','','scrollbars=yes,left=300,top=150,width=600,height=500')"><img src="images/flat_icons/pen29.png" alt="X" /></a>
      <a href="javascript:void(0);" class="actionButtons" onclick="deleteModeOfPayment(<?php echo  $fet_2['id']; ?>)"><img src="images/flat_icons/delete30.png" alt="X" /></a>
    </td>
  </tr>
<?php }?>
</table>
    </td>
  </tr>
  <tr>
    <td align="right" style="height: 40px; padding-right: 205px; vertical-align: bottom;">
      <a id="lnkAddModeOfPayment" href="javascript:void(0)" onclick="location.href='mode.php'" class="linkGoldButton" style="margin-right: 10px;">Add Mode of Payment</a>
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
