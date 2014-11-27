<?php 
include('protect.php');
include 'dbconnect.php'; 
 include('paging.class.php');
				  
	 $ed=$_REQUEST['ed'];
  			
		
				
$in_arr=mysqli_query($conn, "select * from  invoice_arr where bookid='B".$ed."'");		
				
				
if(mysqli_num_rows($in_arr)>0)
{
	
	
	header("location:Invoiced_Already.php?bo=B".$ed);
}
				
				
				
				
				
				
				  $search  = array('"', "'");
$replace = array('&quot;', '&#39;');
				  
				  
				 
				  
				  
 
  $ed_quer=mysqli_query($conn, "select * from booking where id='$ed'");
  
  $ed_row=mysqli_fetch_assoc($ed_quer);
  
    function salt1($table,$id)
  {
	  
	 
	  $query=mysqli_query($conn, "select * from  ".$table." where id='$id'");
	 
	  while($row=mysqli_fetch_assoc($query))
	  {
		 
       echo stripslashes(str_replace($search, $replace,$row['category']));
		  
	  }
	  
	 
  }
 
  function salt($table,$name,$val)
  {
	  
$query=mysqli_query($conn, "select * from  ".$table." order by category Asc ");
	  ?>
      <select name="<?=$name?>" style="width:250px;">
	  
	  <option value="<?=$val?>"><?php salt1($table,$val);  ?></option>
	  
	  
	  <?php
	  while($row=mysqli_fetch_assoc($query))
	  {
		  ?>
          <option value="<?=$row['id']?>"><?php echo stripslashes(str_replace($search, $replace,$row['category']));?></option>
          <?php
		  
	  }
	  
	  ?> </select><?php
	  
	  
  }
  
 
  
  
 
 if($_POST['submit'])
 {
	 $bookno=mysqli_real_escape_string($conn, $_POST['bookno']);
	 
 	$manju=explode('-',$_POST['date']);
 	
	$customer=mysqli_real_escape_string($conn, $_POST['customer']);
	
	$sendername=mysqli_real_escape_string($conn, $_POST['sendername']);
	
	$senderaddress=mysqli_real_escape_string($conn, $_POST['senderaddress']);
	
	$senderphone=mysqli_real_escape_string($conn, $_POST['senderphone']);
 
 	$sendercity=mysqli_real_escape_string($conn, $_POST['sendercity']);
	
	$sendertin=mysqli_real_escape_string($conn, $_POST['sendertin']);
	
	$origin=mysqli_real_escape_string($conn, $_POST['origin']);
	
	$destination=mysqli_real_escape_string($conn, $_POST['destination']);
	
	$receiver=mysqli_real_escape_string($conn, $_POST['receiver']);
	
	$radd=mysqli_real_escape_string($conn, $_POST['radd']);
	 
	 $rcity=$_POST['rcity'];
	
	$rphone=mysqli_real_escape_string($conn, $_POST['rphone']);
	
	$modpay=mysqli_real_escape_string($conn, $_POST['modpay']);
	
	$move=mysqli_real_escape_string($conn, $_POST['move']);
	
	$sermode=mysqli_real_escape_string($conn, $_POST['sermode']);
	
	$des=mysqli_real_escape_string($conn, $_POST['des']);
	
	$delarea=$_POST['delarea'];
		
 	 $tyship=$_POST['tyship'];
	 
	 $qun=$_POST['qun'];
	 
	 $length=$_POST['length'];
	 
	 $width=$_POST['width'];
	 
	 $height=$_POST['height'];
	 
	 $weight=$_POST['weight'];
	 
	 $total=$_POST['total'];
	 
	 $totalweight=$_POST['total_wei'];
	 
	 $dc=$_POST['dc'];
		
	$idfo=$_REQUEST['idfo'];
	
	
		$query=mysqli_query($conn, "update booking set receiver='$receiver',radd='$radd',rcity='$rcity',rphone='$rphone',customer='$customer',sendername='$sendername',senderaddress='$senderaddress',sendercity='$sendercity',senderphone='$senderphone',sendertin='$sendertin',origin='$origin'destination='$destination',modpay='$modpay',movement='$move',servicemode='$sermode',des='$des',date='$date' where bookno='$bookno'") ; 
		
		
		 
	if($query)
	{
	
	for($j=0;$j<count($idfo);$j++)
	{
	
		
	$query1=mysqli_query($conn, "update arr set tyship='$tyship[$j]',qun='$qun[$j]',price='$price[$j]',tot='$tot[$j]',at='$at[$j]' where id='$idfo[$j]'") or die("error");
	echo "update arr set tyship='$tyship[$j]',qun='$qun[$j]',price='$price[$j]',tot='$tot[$j]',at='$at[$j]' where id='$idfo[$j]'";
	}
	
	$delma=$_REQUEST['delma'];
	for($m=0;$m<count($delma);$m++)
	{
	$muery=mysqli_query($conn, "delete from arr where id='$delma[$m]'");
	
	}
	$boko=$_REQUEST['boko'];
	
	$tyship1=$_REQUEST['tyship1'];
	
	$qun1=$_REQUEST['qun1'];
	$price1=$_REQUEST['price1'];
	
	
	$tot1=$_REQUEST['tot1'];
	
	$at1=$_REQUEST['at1'];
	for($n=0;$n<count($tyship1);$n++)
	{
	if($tyship1[$n]!=='')
	{
		$insert=mysqli_query($conn, "insert into arr(bookid,tyship,qun,price,tot,at) value('$boko','$tyship1[$n]','$qun1[$n]','$price1[$n]','$tot1[$n]','$at[$n]')");
	
	
	}
	}
	
	
		?>
		<script type="text/javascript">
        
		/*alert("Your Booking Details Added Successfully");*/
		
		/*self.location="edit_success.php?bo=<?php echo $ed_row['bookno'];?>";*/
		
        
        </script>
		<?php
		
	}
	
		 
	
	 
	 
 }
 
 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/style.css" type="text/css"  rel="stylesheet"/>

<title>Admin</title>
<style type="text/css">
<!--
.style1 {font-size: large;}
-->
</style>

<!--<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
    -->
    
  <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="js/jquery.validate.min.js"></script>
    
    
<script type="text/javascript">
$(document).ready(function(){
 
  /*$("#rcustomer").keyup(function(){
	  
    txt=$("#rcustomer").val();
	
	$("#min").show();
	
    $.post("cus.php",{suggest:txt},function(result){
      $("#min").html(result);
	  
	  
    });
  });*/
  
   /*$(".dem").hide();
   $("#clo").hide();
   $("#edo").click(function(){
  $(".dem").show();
  $(".raga").hide();
 $("#clo").show();
 $("#edo").hide();
});

 $("#clo").click(function(){
	 
	 $(".dem").hide();
  $(".raga").show();
  $("#clo").hide();
 $("#edo").show();
	 
 });
*/


  $("#customer").keyup(function(){
	   
    txt=$("#customer").val();
	
    $("#min1").show();
	
    $.post("cus1.php",{suggest:txt},function(result){
      $("#min1").html(result);
	  
	  
    });
  });
  
 
 
 
	  
  /*  txt=$("#rcustomer").val();
	
	$("#min").hide();
	
    $.post("cus.php",{suggest:txt},function(result){
      $("#min").html(result);
	  
	  
    });*/
 
  
  
 
	   
    txt=$("#customer").val();
	
    $("#min1").hide();
	
    $.post("cus1.php",{suggest:txt},function(result){
      $("#min1").html(result);
	  
	  
    });
  
  
  
  $("new1").html("<li><img src='images/loading7.gif' border='0'></li>");
	
	  
   /* txt=$("#rcustomer").val();
	
    $.get("ins1.php",{suggest:txt},function(result){
      $("#new1").html(result);
    });*/
	
	
	$("new").html("<li><img src='images/loading7.gif' border='0'></li>");
	
	  
    txt=$("#customer").val();
	
    $.get("ins.php",{suggest:txt},function(result){
      $("#new").html(result);
    });
  
  
  
  
  
  
  
  $("#suc").validate({
			
			rules: {
				bookno: {
					required:true,
					remote: "check.php"
				},
				rcustomer:
				{
					required:true
				},
				receiver:
				{
					required:true
				},
				/*rcity:
				{
					required:true
				},
				radd:
				{
					required:true	
				},*/
				rphone:
				{
					required:true,
					number:true
				},
				bookingpl:
				{
					required:true
				},
				customer:
				{
					required:true
				},
				desarea:
				{
					required:true
				},
				modpay:
				{
				required:true
				},
				tyship:
				{
				required:true
				}
				 /*,
				 des:
				 {
					required:true 
				 }*/
				
			},
			
			messages: {
				bookno: {
					required:"Please Enter the HAWB No",
					remote: "HAWB No ACKeady Exist"
					
				},
				rcustomer:
				{
					required:"Please Enter the Customer Id"
				},
				receiver:
				{
					required:"Please Enter the Receiver Name"
				},
				/*rcity:
				{
					required:"Please Enter the Receiver City"
				},
				radd:
				{
					required:"Please Enter the Receiver Address"	
				},*/
				bookingpl:
				{
					required:"Please Select the Booking Place"
				},
				customer:
				{
					required:"Please Select the Customer"
				},
				desarea:
				{
					required:"Please Select the Destination Area"
				},
				modpay:
				{
				required:"Please Select the Mode of Payment"
				},
				tyship:
				{
				required:"Please Select the Type of Shipment"
				},
				des:
				{
					required:"Please Enter the Description"
				}
			}
		});
  
  
  
});
</script>

<script type="text/javascript">

function lam(a)
{
	
	
	document.getElementById("rcustomer").value=a;
	document.getElementById("min").style.display="none";
	
	
}


function lam1(a)
{
	
	
	document.getElementById("customer").value=a;
	document.getElementById("min1").style.display="none";
	
	
}

</script>

</head>

<body>

<style type="text/css">

.ds_box {
	background-color: #FFF;
	border: 1px solid #000;
	position: absolute;
	z-index: 32767;
}

.ds_tbl {
	background-color: #FFF;
}

.ds_head {
	background-color: #333;
	color: #FFF;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
	font-weight: bold;
	text-align: center;
	letter-spacing: 2px;
}

.ds_subhead {
	background-color: #CCC;
	color: #000;
	font-size: 12px;
	font-weight: bold;
	text-align: center;
	font-family: Arial, Helvetica, sans-serif;
	width: 32px;
}

.ds_cell {
	background-color: #EEE;
	color: #000;
	font-size: 13px;
	text-align: center;
	font-family: Arial, Helvetica, sans-serif;
	padding: 5px;
	cursor: pointer;
}

.ds_cell:hover {
	background-color: #F3F3F3;
} /* This hover code won't work for IE */

</style>
 
<table class="ds_box" cellpadding="0" cellspacing="0" id="ds_conclass" style="display: none;"> 
  <tr> 
    <td id="ds_calclass"> </td> 
  </tr> 
</table> 
<script type="text/javascript">
// <!-- <![CDATA[

// Project: Dynamic Date Selector (DtTvB) - 2006-03-16
// Script featured on JavaScript Kit- http://www.javascriptkit.com
// Code begin...
// Set the initial date.
var ds_i_date = new Date();
ds_c_month = ds_i_date.getMonth() + 1;
ds_c_year = ds_i_date.getFullYear();

// Get Element By Id
function ds_getel(id) {
	return document.getElementById(id);
}

// Get the left and the top of the element.
function ds_getleft(el) {
	var tmp = el.offsetLeft;
	el = el.offsetParent
	while(el) {
		tmp += el.offsetLeft;
		el = el.offsetParent;
	}
	return tmp;
}
function ds_gettop(el) {
	var tmp = el.offsetTop;
	el = el.offsetParent
	while(el) {
		tmp += el.offsetTop;
		el = el.offsetParent;
	}
	return tmp;
}

// Output Element
var ds_oe = ds_getel('ds_calclass');
// Container
var ds_ce = ds_getel('ds_conclass');

// Output Buffering
var ds_ob = ''; 
function ds_ob_clean() {
	ds_ob = '';
}
function ds_ob_flush() {
	ds_oe.innerHTML = ds_ob;
	ds_ob_clean();
}
function ds_echo(t) {
	ds_ob += t;
}

var ds_element; // Text Element...

var ds_monthnames = [
'January', 'February', 'March', 'April', 'May', 'June',
'July', 'August', 'September', 'October', 'November', 'December'
]; // You can translate it for your language.

var ds_daynames = [
'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'
]; // You can translate it for your language.

// Calendar template
function ds_template_main_above(t) {
	return '<table cellpadding="3" cellspacing="1" class="ds_tbl">'
	     + '<tr>'
		 + '<td class="ds_head" style="cursor: pointer" onclick="ds_py();">&lt;&lt;</td>'
		 + '<td class="ds_head" style="cursor: pointer" onclick="ds_pm();">&lt;</td>'
		 + '<td class="ds_head" style="cursor: pointer" onclick="ds_hi();" colspan="3">[Close]</td>'
		 + '<td class="ds_head" style="cursor: pointer" onclick="ds_nm();">&gt;</td>'
		 + '<td class="ds_head" style="cursor: pointer" onclick="ds_ny();">&gt;&gt;</td>'
		 + '</tr>'
	     + '<tr>'
		 + '<td colspan="7" class="ds_head">' + t + '</td>'
		 + '</tr>'
		 + '<tr>';
}

function ds_template_day_row(t) {
	return '<td class="ds_subhead">' + t + '</td>';
	// Define width in CSS, XHTML 1.0 Strict doesn't have width property for it.
}

function ds_template_new_week() {
	return '</tr><tr>';
}

function ds_template_blank_cell(colspan) {
	return '<td colspan="' + colspan + '"></td>'
}

function ds_template_day(d, m, y) {
	return '<td class="ds_cell" onclick="ds_onclick(' + d + ',' + m + ',' + y + ')">' + d + '</td>';
	// Define width the day row.
}

function ds_template_main_below() {
	return '</tr>'
	     + '</table>';
}

// This one draws calendar...
function ds_draw_calendar(m, y) {
	// First clean the output buffer.
	ds_ob_clean();
	// Here we go, do the header
	ds_echo (ds_template_main_above(ds_monthnames[m - 1] + ' ' + y));
	for (i = 0; i < 7; i ++) {
		ds_echo (ds_template_day_row(ds_daynames[i]));
	}
	// Make a date object.
	var ds_dc_date = new Date();
	ds_dc_date.setMonth(m - 1);
	ds_dc_date.setFullYear(y);
	ds_dc_date.setDate(1);
	if (m == 1 || m == 3 || m == 5 || m == 7 || m == 8 || m == 10 || m == 12) {
		days = 31;
	} else if (m == 4 || m == 6 || m == 9 || m == 11) {
		days = 30;
	} else {
		days = (y % 4 == 0) ? 29 : 28;
	}
	var first_day = ds_dc_date.getDay();
	var first_loop = 1;
	// Start the first week
	ds_echo (ds_template_new_week());
	// If sunday is not the first day of the month, make a blank cell...
	if (first_day != 0) {
		ds_echo (ds_template_blank_cell(first_day));
	}
	var j = first_day;
	for (i = 0; i < days; i ++) {
		// Today is sunday, make a new week.
		// If this sunday is the first day of the month,
		// we've made a new row for you aCKeady.
		if (j == 0 && !first_loop) {
			// New week!!
			ds_echo (ds_template_new_week());
		}
		// Make a row of that day!
		ds_echo (ds_template_day(i + 1, m, y));
		// This is not first loop anymore...
		first_loop = 0;
		// What is the next day?
		j ++;
		j %= 7;

	}
	// Do the footer
	ds_echo (ds_template_main_below());
	// And let's display..
	ds_ob_flush();
	// Scroll it into view.
	ds_ce.scrollIntoView();
}

// A function to show the calendar.
// When user click on the date, it will set the content of t.
function ds_sh(t) {
	// Set the element to set...
	ds_element = t;
	// Make a new date, and set the current month and year.
	var ds_sh_date = new Date();
	ds_c_month = ds_sh_date.getMonth() + 1;
	ds_c_year = ds_sh_date.getFullYear();
	// Draw the calendar
	ds_draw_calendar(ds_c_month, ds_c_year);
	// To change the position properly, we must show it first.
	ds_ce.style.display = '';
	// Move the calendar container!
	the_left = ds_getleft(t);
	the_top = ds_gettop(t) + t.offsetHeight;
	ds_ce.style.left = the_left + 'px';
	ds_ce.style.top = the_top + 'px';
	// Scroll it into view.
	ds_ce.scrollIntoView();
}

// Hide the calendar.
function ds_hi() {
	ds_ce.style.display = 'none';
}

// Moves to the next month...
function ds_nm() {
	// Increase the current month.
	ds_c_month ++;
	// We have passed December, let's go to the next year.
	// Increase the current year, and set the current month to January.
	if (ds_c_month > 12) {
		ds_c_month = 1; 
		ds_c_year++;
	}
	// Redraw the calendar.
	ds_draw_calendar(ds_c_month, ds_c_year);
}

// Moves to the previous month...
function ds_pm() {
	ds_c_month = ds_c_month - 1; // Can't use dash-dash here, it will make the page invalid.
	// We have passed January, let's go back to the previous year.
	// Decrease the current year, and set the current month to December.
	if (ds_c_month < 1) {
		ds_c_month = 12; 
		ds_c_year = ds_c_year - 1; // Can't use dash-dash here, it will make the page invalid.
	}
	// Redraw the calendar.
	ds_draw_calendar(ds_c_month, ds_c_year);
}

// Moves to the next year...
function ds_ny() {
	// Increase the current year.
	ds_c_year++;
	// Redraw the calendar.
	ds_draw_calendar(ds_c_month, ds_c_year);
}

// Moves to the previous year...
function ds_py() {
	// Decrease the current year.
	ds_c_year = ds_c_year - 1; // Can't use dash-dash here, it will make the page invalid.
	// Redraw the calendar.
	ds_draw_calendar(ds_c_month, ds_c_year);
}

// Format the date to output.
function ds_format_date(d, m, y) {
	// 2 digits month.
	m2 = '00' + m;
	m2 = m2.substr(m2.length - 2);
	// 2 digits day.
	d2 = '00' + d;
	d2 = d2.substr(d2.length - 2);
	// YYYY-MM-DD
	return y + '-' + m2 + '-'+ d2;
}

// When the user clicks the day.
function ds_onclick(d, m, y) {
	// Hide the calendar.
	ds_hi();
	// Set the value of it, if we can.
	if (typeof(ds_element.value) != 'undefined') {
		ds_element.value = ds_format_date(d, m, y);
	// Maybe we want to set the HTML in it.
	} else if (typeof(ds_element.innerHTML) != 'undefined') {
		ds_element.innerHTML = ds_format_date(d, m, y);
	// I don't know how should we display it, just alert it to user.
	} else {
		alert (ds_format_date(d, m, y));
	}
}

function getSelected(opt)
 {
 
 	var opt=document.frmExport.opt;
            for (var intLoop = 0; intLoop < opt.length; intLoop++)
			 {
			  if (!(opt.options[intLoop].selected))
			   {
			   		alert("Select any one field!");
					return false;
               }
		    }
			return true;           
  }

// And here is the end.

// ]]> -->
</script> 
<div align="center">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  align="center">
  
  <tr>
    
	<td>
	<table width="900" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF" >
  <tr>
    <td width="187"><?php include('adminheader.php') ?>	</td>
  </tr>
  <tr>
    <td ><p align="center" class="style1"> Edit Booking Details</p>
        <span class="">
       
        </span>
        
        
        
         
                  
        
        
       <form action="" method="post" name="suc" id="suc" onSubmit="return suy();">  <table width="826" align="center">
         
            <!--<tr>
              <td>HAWB No</td>
              <td><input type="text" name="bookno" id='cat2' style="width:255px;" value="<?=$_POST['bookno']?>"/>
                <span class="Alert">
                <?=$bookno1?>
                </span></td>
             
              
            </tr>-->
            
            
            
            <tr>
              <td>Date</td>
              <td>
              <input type="text" name="date" id='date' style="width:255px;" value="<?php 
			  echo $ed_row['date'];?>" readonly="readonly" onClick="ds_sh(this);"/>
                <span class="Alert">
                <?=$bookno1?>
                <input type="hidden" name="boko" value="<?=$ed_row['bookno']?>" />

                <span class="Alert">
                <?=$bookno1?>
                </span></td>
             
              
            </tr>
            
            
            <tr>
              <td width="238"><strong>Choose Shipper</strong></td>
              <td width="562">
              
         
              
              <!--<select name="rcustomer" style="width:255px;" id="rcustomer">
                <option value="">--Select--</option>
                
                <?php
				while($cus_row=mysqli_fetch_assoc($cus_query))
				{
					?>
					
					<option value="<?=$cus_row['cusid']?>"><?=$cus_row['name']?>-<?=$cus_row['cusid']?></option>
					
					<?php
					
				}
				?>
                
              </select>-->      
              <input type="text" name="customer" id="customer" style="width:250px;"  value="<?php 
			  echo stripslashes(str_replace($search, $replace,$ed_row['customer']));?>" autocomplete="off"/>
              <script type="text/javascript">
			  function fun()
			  {
				  document.getElementById('cus').style.display="block";
				  
				  document.getElementById('hide').style.display="block";
				  
			  }
			  function fun1()
			  {
				  document.getElementById('cus').style.display="none";
				  
				   document.getElementById('hide').style.display="none";
				  
			  }
			  </script>
              
               </td>
              <td width="10" class="Alert">&nbsp;</td>
              
            </tr>
            </table> <ul id="min1" style=" position:absolute;  display:none; width:250px; max-height:500px;background: #008040; margin:-5px 0 0 310px; border:1px solid #959595; padding:5px; line-height:25px; list-style:none;"align="center"></ul>
            <table width="826" align="center" id="new" >
            
            
            
            <tr>
              <td  width="237">Shipper's Name</td><td width="560">
            
            <input type="text" value="" name="sendername" style="width:255px;" readonly/>
            
            
            </td> <td width="13" class="Alert">&nbsp;</td>
            </tr>
            
            <tr>
              <td>Address</td><td>
            
            <textarea name="Shipperaddress" style="width:255px;" readonly></textarea>
              </td> <td width="13" class="Alert">&nbsp;</td>
            </tr>
              
              
               <tr>
                 <td>Phone</td>
                 <td>
            
            <input type="text" value="" name="senderphone" style="width:255px;" readonly/>
            
            
            </td> <td width="13" class="Alert">&nbsp;</td>
               </tr>
            
            
            
            
            
            
             <tr>
                 <td>City</td>
                 <td>
            
            <input type="text" value="" name="sendercity" style="width:255px;" readonly/>
            
            
            </td> <td width="13" class="Alert">&nbsp;</td>
             </tr>
            
            <tr>
                 <td>TIN</td>
                 <td>
            
            <input type="text" value="" name="sendertin" style="width:255px;" readonly/>
            
            
            </td> <td width="13" class="Alert">&nbsp;</td>
            </tr>
            
            
            
            
            </table>
            
             
            
           
            
            
            <table width="826" align="center">
            
            <tr>
              <td width="233">Origin</td>
              <td width="566">
              
              <?php salt("bplace","origin",$ed_row['origin']); ?>
              
                <span class="Alert">
                <?=$bookingpl1?>
                </span></td>
              <td width="11" class="Alert">&nbsp;</td>
              
            </tr>
            <tr>
              <td width="233">Destination</td>
              <td width="566">
              
               <?php salt("bplace","destination",$ed_row['destination']); ?>
                <span class="Alert">
                <?=$bookingpl1?>
                </span></td>
              <td width="11" class="Alert">&nbsp;</td>
              
            </tr>
           
            <!--<tr>
              <td width="233"><strong>Choose Consignee</strong></td>
              <td width="566">
              
              <?php $cus_query=mysqli_query($conn, "select name,cusid from customer order by id desc"); ?>
              <!--<select name="customer" style="width:255px;" id="customer">
                <option value="">--Select--</option>
                
                <?php
				while($cus_row=mysqli_fetch_assoc($cus_query))
				{
					?>
					
					<option value="<?=$cus_row['cusid']?>"><?=$cus_row['name']?>-<?=$cus_row['cusid']?></option>
					
					<?php
					
				}
				?>
                
              </select>--
              <input type="text" name="rcustomer" id="rcustomer" style="width:250px;" autocomplete="off"/><span class="Alert">
              <?=$customer1?>
              </span></td>
              <td width="11" class="Alert">&nbsp;</td>
              
            </tr>-->
            </table>
            
            
            <table width="826" align="center" id="new1" >
            
            
            
            <tr>
              <td  width="234">Consignee's Name<strong> </strong> </td>
              <td width="508">
            
            <input type="text" name="receiver" style="width:255px;" value="<?=$ed_row['receiver']?>" />
            
            
            </td> <td width="68" class="Alert">&nbsp;</td></tr>
            
            <tr>
              <td>Address</td><td>
            
            <textarea name="radd" style="width:255px;" ><?=$ed_row['radd']?></textarea>
              </td> <td width="68" class="Alert">&nbsp;</td></tr>
             
             <tr>
                 <td>City</td>
                 <td>
            
            <input type="text" name="rcity" style="width:255px;" value="<?=$ed_row['rcity']?>" />
            
            
            </td> <td width="68" class="Alert">&nbsp;</td></tr>
            
            <tr>
                 <td>Phone</td>
                 <td>
            
            <input type="text" name="rphone" style="width:255px;" value="<?=$ed_row['rphone']?>" />
            
            
            </td> <td width="68" class="Alert">&nbsp;</td></tr>
             </table >
              
           <table align="center">
           <tr>
              <td width="235">Delivery Area</td>
              <td width="507">                
                	<select name="delarea" id="delarea" style="width:250px;" >
                    	<?php
							if($ed_row['deliveryarea'] == '1')
								echo ("<option value='1'>Within City</option>");
							else
								echo ("<option value='2'>Outside City</option>");
						 ?>
                    	<option value="1">Within City</option>
                        <option value="2">Outside City</option>
                    </select>                
                </td>
              <td width="68" class="Alert">&nbsp;</td>
              
            </tr>
            <tr>
              <td width="235">Mode of Payment</td>
              <td width="507">     
                <?php salt("mop","modpay",$ed_row['modpay']); ?>
                
                <span class="Alert">
                  <?=$modpay1?>
                  </span></td>
              <td width="68" class="Alert">&nbsp;</td>
              
            </tr>
            <tr>
              <td width="235">Type of Movement</td>
              <td width="507">
                <?php salt("movement","move",$ed_row['movement']); ?>
                <span class="Alert">
                  <?=$modpay1?>
                  </span></td>
              <td width="68" class="Alert">&nbsp;</td>
              
            </tr>
            <tr>
              <td width="235">Service Mode</td>
              <td width="507">
                <?php salt("servicemode","sermode",$ed_row['servicemode']); ?>
                <span class="Alert">
                  <?=$modpay1?>
                  </span></td>
              <td width="68" class="Alert">&nbsp;</td>
              
            </tr>
            <tr>
              <td width="235">Status</td>
              <td width="507">                
                <select name="status" id="status" style="width:250px;">
                	<option value="<?=$ed_row['status']?>"><?=$ed_row['status']?></option>
                    <?php
						$sta=mysqli_query($conn, "select * from status");
							while($rs=mysqli_fetch_array($sta))
								echo ("<option value='".$rs['category']."'>".$rs['category']."</option>");
					?>
                </select>
                </td>
              <td width="68" class="Alert">&nbsp;</td>
              
            </tr>
            </table>
            
            <table width="830" align="center" id="new2">
             <tr>
             <td width="259" height="27" align="center" valign="middle" bgcolor="#e72020" style=""><strong>Cargo Description</strong></td>
             <td width="64" align="center" valign="middle" bgcolor="#e72020"><strong>No. of Pieces</strong></td>
             <td width="233" align="center" valign="middle" bgcolor="#e72020"><strong>Measurement</strong></td> 
             <td width="105" align="center" valign="middle" bgcolor="#e72020"><strong>Weight(Kilo)</strong></td>
             <td width="100" align="center" valign="middle" bgcolor="#e72020"><strong>Declared Value</strong></td>
           </tr>
             <script type="text/javascript">
			  function zoho(val,q,to)
			  {
				  
				   
				   
				 document.getElementById(to).value=document.getElementById(val).value*document.getElementById(q).value
				  
			  }
			   
			   
			   function removeed(ido)
			   {
				   var numo=ido-1;
				   
				   var aja=numo+"btn";
				  
				   document.getElementById(aja).style.display="inline";
				  
				   var t="weight"+ido;
				  
				  document.getElementById('total_wei').value=document.getElementById('total_wei').value - document.getElementById(t).value;	
				  wei=document.getElementById('total_wei').value;
				  weii=document.getElementById('delarea').value;
				  $.get("total_calc.php",{suggest:wei,area:weii},function(result){
      				$("#total").html(result);
    				});  
				  
				  
				  var el = document.getElementById(ido);
				  
				  
				
var remElement = (el.parentNode).removeChild(el);
				  
			   }
			   function neo(str)
			   {
				  
				   
				   
			document.getElementById(str).style.display="none";
				   
			   }
			   
			  </script>
              
              
              
             <?php $new_query=mysqli_query($conn, "select * from arr where bookid='".$ed_row['bookno']."'"); 
			 
			 
			 
			 
			 
			 
			 while($new_row=mysqli_fetch_assoc($new_query))
			 
			 {
			 	if($new_row['weight']!="0")
				{
			 ?>
             
             <tr class="dem">
             <td>
             
             
             <?php salt("ty_ship","tyship[]",$new_row['tyship']);  ?>             </td>
             
             
             <td align="center"><input type="text" size="3" name="qun[]" id="qun[]"  value="<?=$new_row['qun']?>" style="text-align:center;"/>             </td>
             
             
             
             <td><!--<input type="text" name="price[]" id='price'   value="<?=$new_row['price']?>" style="text-align: center;" />-->
             <input type="text" name="length[]" id="length" size="2" style="text-align:center;"  value="<?=$new_row['length']?>" /> 
              <input type="text" name="width[]" id="width" size="2" style="text-align:center;"   value="<?=$new_row['width']?>" /> 
               <input type="text" name="height[]" id="height" size="2" style="text-align:center;"   value="<?=$new_row['height']?>" /> 
               <?php $dimtot=$new_row['length'] * $new_row['width'] * $new_row['height'];
			    ?>
               <input type="text" name="dimtot" id="dimtot" size="2" readonly="readonly" value="<?=$dimtot?>" /></td>
             
             
             
             
             <td width="105">
                 <input type="text" name="tot[]" id='tot' class="tot" style="width:100px; text-align: center;" value="<?=$new_row['weight']?>"/>
                 
                 
                 <input type="hidden" name="idfo[]" value="<?=$new_row['id']?>" />                </td> 
             <td width="100"><input type="text" style="width:100px;" name="at[]" id="at" value="<?=$new_row['at']?>" />    </td>
                
                <td width="41"><input type="checkbox" value="<?=$new_row['id']?>" name="delma[]" /><a>Delete</a></td></tr>
             
             
              <?php  }
			  } ?>
           </table>
            
            
            
            
            <table id="myList" width="833" align="center"></table>
            <?php
				$totquery=getAssociativeArrayFromSQL($conn, "select * from arr where bookid='".$ed_row['bookno']."' and weight='0'");
			?>
			<table width="833" align="center">
            <tr>
            <td colspan="2" style="padding-right:50px;">Total Weight:<input type="text" name="total_wei" id="total_wei" border="0" style="border:none; text-align:right; width:75px; font-weight:bold;" readonly="readonly" value="<?=$totquery['total_weight']?>"/></td>
              <td width="421" colspan="3" align="right" id="total" style="padding-right:50px;">Total Charges:
                <input type="text" name="total" id="total" border="0" style="border:none; text-align:right; width:75px; font-weight:bold;" readonly="readonly" value="<?=$totquery['tot']?>"/></td>
              </tr></table>
<script>
	function weical(str)
	{
		if(document.getElementById('length').value == "" || document.getElementById('length').value== "Length") {
			document.getElementById("length").readOnly = true;
			document.getElementById("width").readOnly = true;
			document.getElementById("height").readOnly = true;
	 	}
		else
		{
			var cal = document.getElementById('length').value * document.getElementById('width').value * document.getElementById('height').value;
			document.getElementById('dimtot').value = document.getElementById('length').value * document.getElementById('width').value * document.getElementById('height').value;
			dvar x=(cal/3500);
			document.getElementById('weight').value=x.toFixed(2);
			document.getElementById("weight").readOnly = true;
		}
		
		wei=document.getElementById('weight').value;
		
		var sud=str+1;
		for(i=1;i<sud;i++)
		{
			t="weight"+i;
			l="length"+i;
			w="width"+i;
			h="height"+i;
			dt="dimtot"+i;
			if(document.getElementById('length').value == "" || document.getElementById('length').value== "Length") {
				document.getElementById(l).readOnly = true;
				document.getElementById(w).readOnly = true;
				document.getElementById(h).readOnly = true;
	 		}
			else
			{
			cal=document.getElementById(l).value * document.getElementById(w).value * document.getElementById(h).value;
			document.getElementById(dt).value = document.getElementById(l).value * document.getElementById(w).value * document.getElementById(h).value;
		
			var y=(cal/3500);
			document.getElementById(t).value=y.toFixed(2);
			document.getElementById(t).readOnly = true;
			}
			temp=document.getElementById(t).value;
			wei = parseFloat(wei) + parseFloat(temp);
		}
		
			document.getElementById('total_wei').value=wei;
			  weii=document.getElementById('dearea').value;
				  $.get("total_calc.php",{suggest:wei,area:weii},function(result){
      			$("#total").html(result);
    		});
	}
	
	function mine(str)
	{
	
	var sud=str+1;	
	
	var nam="<?php echo $success; ?>";
	
	var qun='qun'+sud;
	
	var tot="tot"+sud;
	
	var pri='price'+sud;
	
	var btn=sud+'btn'
	
	$("#myList").append('<tr id="'+sud+'"><td width="206"><select name="tyship[]" style="width:250px;"><option value="">--Select--</option>'+nam+'</select></td><td width="90" align="center"><input type="text" name="qun[]" id="qun" size="3" /></td><td width="260"><input type="text" name="length[]" id="length'+sud+'" size="2" onClick="this.value=\'\';" onBlur="this.value=!this.value?\'Length\':this.value;" value="Length" style="text-align: center;"><input type="text" size="2" name="width[]" id="width'+sud+'" onClick="this.value=\'\';" onBlur="this.value=!this.value?\'Width\':this.value;" value="Width" style="text-align: center;"><input type="text" size="2" name="height[]" id="height'+sud+'" onClick="this.value=\'\';" onBlur="this.value=!this.value?\'Height\':this.value;" value="Height" style="text-align: center;"><input type="text" size="2" name="dimtot" id="dimtot'+sud+'" onfocus="weical('+sud+')"  /></td><td width="137"><input type="text" name="weight[]" id="weight'+sud+'" class="tot" value="" style=" width:100px;text-align: center;"/></td><td width="171"><input type="text" name="dc[]" id="'+sud+'dc" class="dc" value="" style=" width:100px; text-align: center;"><span id="'+sud+'btn" style="cursor:pointer;" onclick=mine('+sud+');neo("'+btn+'");>+</span>&nbsp;&nbsp;&nbsp;<span style="cursor:pointer;" onClick="removeed('+sud+')">-</span></td></tr>');
	

	
	}
 
</script>

            <table width="826" align="center" id="new">
             <tr>
              <td width="202">Remarks / Notations</td>
              <td width="592"><textarea cols="40" rows="5" name="des"></textarea></td>
              <td width="10">&nbsp;</td><td width="10">&nbsp;</td>
            </tr>
            <tr>
              <td width="202"></td>
              <td width="592"><input type="submit" name="submit" value="Submit" /></td>
              <td width="10">&nbsp;</td><td width="10">&nbsp;</td>
            </tr>
          
        </table></form></td>
  </tr>

  
  <tr><td >&nbsp;</td>
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
