<?php include('protect.php');
include 'dbconnect.php'; 
 include('paging.class.php');

$total_results = (mysqli_query($conn, "SELECT COUNT(*) as Num FROM customer ")); 
	
$row = mysqli_fetch_assoc($total_results);
$totalCount = $row['Num'];

if($totalCount ==0)
	{

	print "<script>";
    print "self.location='noresults.php';"; // Comment this line if you don't want to redirect
     print "</script>";
	}
	
$sug=html_entity_decode($_POST['suggest']);

$mug=" where cusid like '%$sug%' ||  name like '%$sug%' ||   phone like '%$sug%' ";

$pager = new pager($_GET['p'], 15, $totalCount, 4);
$offset = $pager->get_start_offset();
$limit = 15;


// Perform MySQL query on only the current page number's results 


$result = mysqli_query($conn, "SELECT * FROM customer ".$mug." ORDER BY id desc LIMIT " . $offset . ", $limit ");



//$select_link=mysqli_query($conn, "select * from testimonial");
  
?>

<table width="98%" border="0"  cellspacing="0" cellpadding="5" align="center" id="tab_bg" style="border:1px solid #F0F0F0;">
  <tr  id="head_bg"  bgcolor="#F4F4F4">
   
      
	    <td class="wht_txt" width="9%"><div align="left"><strong>Id</strong></div></td>
			 	
             
         		 <td class="wht_txt" width="17%"><div align="left"><strong>Name</strong></div></td><td class="wht_txt" width="24%"><div align="left"><strong>Address</strong></div></td>
         		 <td class="wht_txt" width="20%"><div align="left"><strong>City</strong></div></td>
         		 <td class="wht_txt" width="17%"><div align="left"><strong>Phone</strong></div></td>	
			 <td class="wht_txt" width="13%"><div align="left"><strong>Action </strong></div></td>
    </tr>


  <?php 
while($fet_2=mysqli_fetch_array($result))
{
//	include('results.php');
	?>	
  <tr>
     <td   width="9%"><?php  echo $fet_2['cusid']; ?></td>
    <td   width="17%"><?php  echo $fet_2['name']; ?></td><td   width="24%"><?php  echo $fet_2['address']; ?></td>
    <td   width="20%"><?php  echo $fet_2['city']; ?></td>
    <td   width="17%"><?php  echo $fet_2['phone']; ?></td>
	<td   width="13%"><a href="#" onclick="MM_openBrWindow('customer_edit.php?ed=<?php echo  $fet_2['id']; ?> ','','scrollbars=yes,left=300,top=150,width=600,height=500')"   >Edit </a> &nbsp;&nbsp; <a href="?del_id=<?php echo  $fet_2['id']; ?>
	
 "  onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
	
  </tr> 
<tr><td colspan="9" style="border-bottom:1px dashed #D7D7D7;"></td></tr>
   <?php }?>
</table>