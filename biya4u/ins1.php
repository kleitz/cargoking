<?php 
include('protect.php');
include 'dbconnect.php'; 
 $sug=trim($_REQUEST['suggest']);
 
$query=mysqli_query($conn, "select * from customer where cusid='$sug'");
$row=mysqli_fetch_assoc($query);
 
 $search  = array('"', "'");
$replace = array('&quot;', '&#39;');
				  
				  
 
 
 
 
 
 ?>
 
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
 
  
         <tr><td  width="234">Receiver Name/பெறுநர் பெயர்</td><td width="508">
            
            <input type="text" value="<?php echo stripslashes(str_replace($search, $replace,$row['name']));?>" name="receiver" style="width:255px;" readonly/>
            
            
            </td> <td width="68" class="Alert">&nbsp;</td></tr>
            
            <tr><td>Address/விலாசம்</td><td>
            
            <textarea name="radd" style="width:255px;" readonly><?php 
			
			echo stripslashes(str_replace($search, $replace,$row['address']));?></textarea>
              </td> <td width="68" class="Alert">&nbsp;</td></tr>
              
              
              
              
              
               <tr>
                 <td>City/ஊர்</td>
                 <td>
            
            <input type="text" value="<?php echo stripslashes(str_replace($search, $replace,$row['city']));?>" name="rcity" style="width:255px;" readonly/>
            
            
            </td> <td width="68" class="Alert">&nbsp;</td></tr>
            
              
             
              
               <tr>
                 <td>Phone/போன்</td>
                 <td>
            
            <input type="text" value="<?php echo stripslashes(str_replace($search, $replace,$row['phone']));?>" name="rphone" style="width:255px;" readonly/>
            
            
            </td> <td width="68" class="Alert">&nbsp;</td></tr>
            
            
            
            
            
            
            
             <tr>
                 <td>Destinations</td>
                 <td>
            
           <select name="desarea" style="width:250px;">
           
           <option value="<?=$row['desarea']?>"><?php salt("destinations",$row['desarea'])?></option>
           
           
           
           </select>
            
            
            </td> <td width="68" class="Alert">&nbsp;</td></tr>
            
            
            
            
            
            
            