<?php 
include('protect.php');
include 'dbconnect.php'; 
 include('paging.class.php');
  //status 
/* $status=$_REQUEST['status'];
$row_id = mysqli_query($conn, "update testimonial set status = 'InActive' where id = '$status'  ") or die (mysqli_error());
*/
$sug=html_entity_decode($_GET['search']);

$mug=" where postby='$sug'";

    if(isset($_REQUEST['del_id']))
  {
  $del_id_net = $_REQUEST['del_id' ];
  
  
        

  $del=mysqli_query($conn, "DELETE FROM booking WHERE id='$del_id_net' ") or die (mysqli_error());
  
  
 
 ?><script type="text/javascript">alert('One Record Deleted Successfully'); self.location='man_booking.php';</script><?php
  
  

  }
  



$total_results = (mysqli_query($conn, "SELECT COUNT(*) as Num FROM booking".$mug)); 
	
$row = mysqli_fetch_assoc($total_results);
$totalCount = $row['Num'];

if($totalCount ==0)
	{

	/*print "<script>";
    print "self.location='noresults.php';"; // Comment this line if you don't want to redirect
     print "</script>";*/
	}
	


$pager = new pager($_GET['p'], 15, $totalCount, 4);
$offset = $pager->get_start_offset();
$limit = 15;


// Perform MySQL query on only the current page number's results 


$result = mysqli_query($conn, "SELECT * FROM booking".$mug."  ORDER BY id desc LIMIT " . $offset . ", $limit ");



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
                
                <!--<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.2.min.js"></script>
                
                
              <script type="text/javascript">
$(document).ready(function(){
                
            $("#sub").submit(function(){
	   
	    $("#min1").html("<img src='images/loading7.gif' align='center'>");
	   
    txt=$("#search").val();
	
	
  
	
    $.post("man_book1.php",{suggest:txt},function(result){
      $("#min1").html(result);
	  
	  
    });
  });  
         });
</script>-->






              <table width="928" align="center"><tr>
                <td width="332"><strong>Search &amp; Edit   Booking Details </strong></td><td width="584">
                
                <form action="" method="get" id="sub">
                  <strong>Search ByBranch Id : </strong>                
                  <input type="text" name="search" value="" id="search" style="width:200px; height:20px;"/>
                <input type="submit" name="submit" id="" value="Go"/>
                </form>


</td></tr>



</table>

                
            </td>
           
           </tr>

  <tr><td><?php if($_GET['search'])
  
  { ?><table width="98%" border="0" align="center" cellpadding="3" cellspacing="3">
    
    
    
    
    
    <tr>
      <td width="54%"><span class="Closed"><strong><?php echo $totalCount; ?> </strong></span><strong>Results Found</strong>.</td>
      <td width="46%"><div align="right"><?php echo $links = $pager->get_links(); ?></div></td>
      </tr>
    
    
    
    
    
    
    </table> <?php } ?> <br />
    
</td></tr>
  
  
  
    <tr><td width="187"><?php if($_REQUEST['succ']=='yes'){echo "<span class='style3'>Succesfully</span>" ;} ?> </td>   
  </tr>

  <tr><td id="min1">
  
 <?php if($_GET['search'])
  
  {
  
  ?>
  
  <table width="98%" border="0"  cellspacing="0" cellpadding="5" align="center" id="tab_bg" style="border:1px solid #F0F0F0;">
  <tr  id="head_bg"  bgcolor="#F4F4F4">
   
      
	    <td width="11%" height="25" class="wht_txt"><div align="left"><strong>Date</strong></div></td>
			 	
             
         		 <td class="wht_txt" width="11%"><div align="left"><strong>HAWB No</strong></div></td><td class="wht_txt" width="15%"><div align="left"><strong>Booking Place</strong></div></td><td class="wht_txt" width="15%"><div align="left"><strong>Receiver</strong></div></td>
         		 <td class="wht_txt" width="15%"><div align="left"><strong>Destination Area</strong></div></td>
         		 <td class="wht_txt" width="13%"><div align="left"><strong>Total Amount</strong></div></td>
         		 
         		 	
			 <td class="wht_txt" width="20%"><div align="left"><strong>Action </strong></div></td>
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

$jump=$fet_2['bookno'];


$jump_query=mysqli_query($conn, "select * from  invoice_arr where bookid='$jump'");

if(mysqli_num_rows($jump_query)<1)
{

	?>
  <tr>
     <td   width="11%"><?php 
	 
	 $dat=explode("-" ,$fet_2['date']); 
	 
	 
	 echo $dat[2]."-".$dat[1]."-".$dat[0];
	 
	  
	  
	  ?></td>
    <td   width="11%"><?php  echo $fet_2['bookno']; ?></td><td   width="15%"><?php  
	
	salt("bplace",$fet_2['bookingpl'])
	
	?></td><td   width="15%"><?php  /*echo $fet_2['customer']; */
	
	$cus= $fet_2['customer1']; 
	
	$cus_query=mysqli_query($conn, "select * from customer where cusid='$cus'");
	$cus_row=mysqli_fetch_assoc($cus_query);
	
	echo $cus_row['name']."-".$cus_row['cusid'];
	
	
	?></td>
    <td   width="15%"><?php  $des= $fet_2['desarea']; 
	
	$des_query=mysqli_query($conn, "select * from destinations where id='$des'");
	$des_row=mysqli_fetch_assoc($des_query);
	
	echo $des_row['category'];
	
	?></td>
    <td   width="13%">
    <?php
    
    $bido= $fet_2['bookno']; 
	
	$bi_query=mysqli_query($conn, "select sum(tot) as tot from arr where bookid ='$bido'");
	$bi_row=mysqli_fetch_assoc($bi_query);
	
	echo "<b>".$bi_row['tot']."</b>";
	
	?>
    
    </td>
    
    
	<td   width="20%"><a href="booking_edit.php?ed=<?php echo  $fet_2['id']; ?>" target="_blank">Edit </a> &nbsp;&nbsp; 
    
    
    <a href="#" onclick="MM_openBrWindow('view.php?ed=<?php echo  $fet_2['id']; ?> ','','scrollbars=yes,left=300,top=150,width=700,height=700')"   >View </a> &nbsp;&nbsp; 
    
    
     <a href="#" onclick="MM_openBrWindow('print_view.php?ed=<?php echo  $fet_2['id']; ?> ','','scrollbars=yes,left=300,top=150,width=700,height=700')"   >Print </a> &nbsp;&nbsp; 
    
    
   <!-- <a href="?del_id=<?php echo  $fet_2['id']; ?>
	
 "  onclick="return confirm('Are you sure you want to delete?')">Delete</a>--></td>
	
  </tr> 
  <tr><td colspan="12" style="border-bottom:1px dashed #D7D7D7;"></td></tr>
  <?php } ?>

   <?php } ?>
</table>
<?php  }?>
  
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
