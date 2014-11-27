<?php 
include('protect.php');
include 'dbconnect.php'; 
 include('paging.class.php');
  //status 
/* $status=$_REQUEST['status'];
$row_id = mysqli_query($conn, "update testimonial set status = 'InActive' where id = '$status'  ") or die (mysqli_error());
*/
$sug=html_entity_decode($_GET['search']);

if($_GET['search'])
{
if($_SESSION['member']=="admin")
	$mug=" where cusid like '%$sug%' ||  name like '%$sug%' ||   phone like '%$sug%'  ||   address like '%$sug%' ";
else
	$mug="and cusid like '%$sug%' ||  name like '%$sug%' ||   phone like '%$sug%'  ||   address like '%$sug%' ";

}
    if(isset($_REQUEST['del_id']))
  {
  $del_id_net = $_REQUEST['del_id' ];
  
      
	$cus_query=mysqli_query($conn, "select * from booking where customer='$del_id_net'");
  
  $cus_num=mysqli_num_rows($cus_query);
  
  if($cus_num>0)
  {
  ?><script type="text/javascript">alert("List Available, So Can't Delete");

self.location='man_customer.php';


</script><?php
  
  }
  else
  {    

  $del=mysqli_query($conn, "DELETE FROM customer WHERE cusid='$del_id_net' ") or die (mysqli_error());
  
  
 
 ?><script type="text/javascript">alert('One Record Deleted Successfully'); self.location='man_customer.php';</script><?php
  
  

  }
  
  
  }
  


if($_SESSION['member']=="admin")
	$total_results = (mysqli_query($conn, "SELECT COUNT(*) as Num FROM customer".$mug)); 
else
	{
		$login=$_SESSION['adminusername'];
		$city=getAssociativeArrayFromSQL($conn, "select * from station where username='$login'");
		$total_results = (mysqli_query($conn, "SELECT COUNT(*) as Num FROM customer where city=".$city['city']."".$mug));
	}
	
$row = mysqli_fetch_assoc($total_results);
$totalCount = $row['Num'];

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

if($_SESSION['member']=="admin")
	$result = mysqli_query($conn, "SELECT * FROM customer".$mug."  ORDER BY id desc LIMIT " . $offset . ", $limit ");
else
	{
		$login=$_SESSION['adminusername'];
		$city=getAssociativeArrayFromSQL($conn, "select * from station where username='$login'");
		$result = mysqli_query($conn, "SELECT * FROM customer where city=".$city['city']."".$mug."  ORDER BY id desc LIMIT " . $offset . ", $limit ");
	}




//$select_link=mysqli_query($conn, "select * from testimonial");
  
?>
<?php 
  
  function salt1($table,$id)
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



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/style.css" type="text/css"  rel="stylesheet"/>

<title>Admin</title>
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

              <table width="952" align="center"><tr>
              
              <td width="336"><strong>Manage Customer Details</strong></td>
              
              
              <td width="604">
              
              <form action="" method="get">
              
              <strong>Search By Customer Id,Name,phone,Address  </strong>                
              <input type="text" name="search" value="" id="search" style="width:200px; height:20px;"/>
                <input type="submit" name="submit" id="sub" value="Go"/>
<input type="reset" name="rest" onClick="self.location='man_customer.php';"/></form></td></tr>




              </table>

                
                </td>
  </tr>

  <tr><td><table width="98%" border="0" align="center" cellpadding="3" cellspacing="3">
    <tr>
      <td width="54%"><span class="Closed"><strong><?php echo $totalCount; ?> </strong></span><strong>Results Found</strong>.</td>
      <td width="46%"><div align="right"><?php echo $links = $pager->get_links(); ?></div></td>
      </tr>
    
    
    </table>    <br />
    
</td></tr>
  
  
  
    <tr>
      <td width="187" height="35" align="right"><?php if($_REQUEST['succ']=='yes'){echo "<span class='style3'>Succesfully</span>" ;} ?> <a href="customer.php">Add New</a>&nbsp;&nbsp;&nbsp;</td>   
  </tr>

  <tr><td id="min1">
  <table width="98%" border="0"  cellspacing="0" cellpadding="5" align="center" id="tab_bg" style="border:1px solid #F0F0F0;">
  <tr  id="head_bg"  bgcolor="#F4F4F4">
   
      
	    <td width="3%" height="39" class="wht_txt"><div align="left"><strong>Id</strong></div></td>
			 	
             
         		 <td class="wht_txt" width="12%"><div align="left"><strong>Name</strong></div></td><td class="wht_txt" width="15%"><div align="left"><strong>Address</strong></div></td>
         		 <td class="wht_txt" width="11%"><div align="left"><strong>City</strong></div></td>
         		 <td class="wht_txt" width="20%"><div align="left"><strong>Phone</strong></div></td>
         		 <td class="wht_txt" width="18%"><div align="left"><strong>Tin</strong></div></td>	
			 <td class="wht_txt" width="21%"><div align="left"><strong>Action</strong></div></td>
    </tr>


  <?php 
while($fet_2=mysqli_fetch_array($result))
{
//	include('results.php');
	?>	
  <tr>
     <td   width="3%"><?php  echo $fet_2['cusid']; ?></td>
    <td   width="12%"><?php  echo stripslashes($fet_2['name']); ?></td><td   width="15%"><?php  echo stripslashes($fet_2['address']); ?></td>
    <td   width="11%"><?php  $bpid=$fet_2['city'];
	$rs=getAssociativeArrayFromSQL($conn, "select * from bplace where id=".$bpid."");
	echo $rs['category']; ?></td>
    <td   width="20%"><?php  echo stripslashes($fet_2['phone']); ?></td>
    <td   width="18%"><?php  echo stripslashes($fet_2['tin']); ?></td>
	<td   width="21%"><a href="#" onClick="MM_openBrWindow('customer_edit.php?ed=<?php echo  $fet_2['id']; ?> ','','scrollbars=yes,left=150,top=10,width=900,height=900')">Edit</a>  &nbsp;&nbsp;&nbsp;<a href="?del_id=<?php echo  $fet_2['cusid']; ?>
	
 "  onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
	
  </tr> 
<tr><td colspan="10" style="border-bottom:1px dashed #D7D7D7;"></td></tr>
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
