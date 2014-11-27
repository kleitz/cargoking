<?php 
include('protect.php');
include 'dbconnect.php'; 
 include('paging.class.php');
  //status 
/* $status=$_REQUEST['status'];
$row_id = mysqli_query($conn, "update testimonial set status = 'InActive' where id = '$status'  ") or die (mysqli_error());
*/

if($_GET['search'])
{

$sug=html_entity_decode($_GET['search']);

$mug=" and (booking.bookno like '%$sug%' || booking.radd like '%$sug%' ||  booking.customer1 like '%$sug%' ||   booking.rphone like '%$sug%') ";


}


    if(isset($_REQUEST['del_id']))
  {
  $del_id_net = $_REQUEST['del_id' ];
  
  
        

  $del=mysqli_query($conn, "DELETE FROM booking WHERE id='$del_id_net' ") or die (mysqli_error());
  
  
 
 ?><script type="text/javascript">alert('One Record Deleted Successfully'); self.location='pend.php';</script><?php
  
  

  }
  


$quy=mysqli_query($conn, "SELECT * FROM booking  where status='DELIVERED'".$mug);


$totalCount = mysqli_num_rows($quy);

if($totalCount ==0)
	{

	print "<script>";
    print "self.location='noresults.php';"; // Comment this line if you don't want to redirect
     print "</script>";
	}
	


$pager = new pager($_GET['p'], 15, $totalCount, 4);
$offset = $pager->get_start_offset();
$limit = 15;


// Perform MySQL query on only the current page number's results 


$result = mysqli_query($conn, "SELECT * FROM booking  where status='DELIVERED'".$mug."  ORDER BY booking.id desc LIMIT " . $offset . ", $limit ");



//$select_link=mysqli_query($conn, "select * from testimonial");
  
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
           
           
           <td colspan="2">
 





              <table width="928" align="center"><tr>
                <td width="332"><strong>Pending  Booking Details </strong></td><td width="584">
                
                <form action="" method="get" id="sub"><strong>Search By HAWB No,Customer Id,Phone </strong>                <input type="text" name="search" value="" id="search" style="width:200px; height:20px;"/>
                <input type="submit" name="submit" id="" value="Go"/>
<input type="reset" name="rest" onClick="self.location='pend.php';"/>

</form>


</td></tr>



</table>

                
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

  <tr><td id="min1">
  <table width="98%" border="0"  cellspacing="0" cellpadding="5" align="center" id="tab_bg" style="border:1px solid #F0F0F0;">
  <tr  id="head_bg"  bgcolor="#F4F4F4">
   
      
	    <td width="6%" height="25" class="wht_txt"><div align="left"><strong>Date</strong></div></td>
			 	
             
         		 <td class="wht_txt" width="7%"><div align="left"><strong>HAWB No</strong></div></td><td class="wht_txt" width="9%"><div align="left"><strong>Origin</strong></div></td><td class="wht_txt" width="9%"><div align="left"><strong>Receiver</strong></div></td>
         		 <td class="wht_txt" width="10%"><div align="left"><strong>Destination</strong></div></td>
         		 <td class="wht_txt" width="7%"><div align="left"><strong>Quantity</strong></div></td>
         		 <td class="wht_txt" width="9%"><div align="left"><strong>Mode of Payment</strong></div></td>
         		 <td class="wht_txt" width="7%"><div align="left"><strong>Total Amount</strong></div></td>
         		 
         		 	
                    
                    
                  <td class="wht_txt" width="7%"><div align="left"><strong>Posted By</strong></div></td>
                    
                    
                    
			 <td class="wht_txt" width="29%"><div align="center"><strong>Action </strong></div></td>
    </tr>
<?php 
  
  function salt($table,$id)
  {
	  
	 
	  $query=mysqli_query($conn, "select * from  ".$table." where id='$id'");
	 
	  while($row=mysqli_fetch_assoc($query))
	  {
		 
       echo $row['category'];
		  
	  }
	  
	  ?> 
	  
	  <?php
  }
  ?>

  <?php 
while($fet_2=mysqli_fetch_array($result))
{
//	include('results.php');
	?>	
  <tr>
     <td   width="6%"><?php  $dat=explode("-" ,$fet_2['date']); 
	 
	 
	 echo $dat[2]."-".$dat[1]."-".$dat[0];
	 
	 
	 ?></td>
    <td   width="7%"><?php  echo $fet_2['bookno']; ?></td>
    <td   width="9%"><?php  
	
	salt("bplace",$fet_2['origin'])
	
	?></td>
    <td   width="9%"><?php  echo $fet_2['receiver']; ?></td>
    <td   width="10%"><?php  salt("bplace",$fet_2['destination'])
	
	?></td>
    <td   width="7%">
	
	<?php $bido= $fet_2['bookno']; 
	
	$bi_query=mysqli_query($conn, "select sum(tot) as tot,sum(qun) as qun from arr where bookid ='$bido'");
	$bi_row=mysqli_fetch_assoc($bi_query);
	?>
	
	
	<?=$bi_row['qun']?></td>
    <td   width="9%"><?=salt("mop",$fet_2['modpay'])?></td>
    <td   width="7%">
    <?php
    
    
	echo "<b>".$bi_row['tot']."</b>";
	
	?>    </td>
    <td>
    
    
    <?php echo $fet_2['postby'];
	
	$postbe=$fet_2['postby'];
	
	
	if($postbe!=="admin")
	{
		$post_query=mysqli_query($conn, "select * from branch where branch_id='$postbe'");
		
		$post_row=mysqli_fetch_assoc($post_query);
		
		echo "-".$post_row['branch_username'];
		
	}
	
	
	 ?>
    
    </td>
    
	<td   width="29%"><!--<a href="booking_edit.php?ed=<?php echo  $fet_2['id']; ?>" target="_blank">Edit </a>--> &nbsp;&nbsp; 
    
    
    <a href="#" onClick="MM_openBrWindow('view.php?ed=<?php echo  $fet_2['id']; ?> ','','scrollbars=yes,left=300,top=150,width=900,height=900')"   >View </a> &nbsp;&nbsp; 
    
    <?php
		if($fet_2['status']!='DELIVERED')
		{
    ?><a href="update_status.php?ed=<?php echo  $fet_2['id']; ?>"   >UpdateStatus </a> &nbsp;&nbsp; <?php } ?>
    
     <a href="#"  onClick="MM_openBrWindow('print_view.php?ed=<?php echo  $fet_2['id']; ?> ','','scrollbars=yes,left=150,top=150,width=870,height=620')"  >Print </a> &nbsp;&nbsp; 

    <a href=""  onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
	
  </tr> 
<tr><td colspan="14" style="border-bottom:1px dashed #D7D7D7;"></td></tr>
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
