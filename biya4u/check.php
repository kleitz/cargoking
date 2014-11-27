<?php 
include('protect.php');
include 'dbconnect.php'; 
 
 
 $sug=trim($_REQUEST['bookno']);
 
$query=mysqli_query($conn, "select * from booking where bookno='$sug'");

 
 if(mysqli_num_rows($query)>0)
 {
	 $valid="false";
 }
 else
 {
	 $valid="true";
 }
 echo $valid;
 
 ?>