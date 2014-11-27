<?php 
	include('protect.php');
	include 'dbconnect.php'; 
	$searchKey = trim($_REQUEST['suggest']);

	$query = mysqli_query($conn, "select * from vw_customers where cust_id ='$searchKey'");
	$row = mysqli_fetch_assoc($query);
	//$search  = array('"', "'");
	//$replace = array('&quot;', '&#39;');
?>
	<tr>
		<td width="237">Sender Name</td>
		<td width="505">
			<input type="text" value="<?php echo stripslashes(str_replace($search, $replace,$row['cust_name']));?>" name="sendername" style="width:255px;" readonly/>
		</td>
		<td width="68" class="Alert">&nbsp;</td>
	</tr>
	<tr>
		<td>Address</td>
		<td>
			<textarea name="senderaddress" style="width:255px;" readonly><?php echo stripslashes(str_replace($search, $replace,$row['address'])); ?></textarea>
		</td>
		<td width="68" class="Alert">&nbsp;</td>
	</tr>
	<tr>
		<td>Phone</td>
		<td>
			<input type="text" value="<?php echo stripslashes(str_replace($search, $replace,$row['phone']));?>" name="senderphone" style="width:255px;" readonly/>
		</td>
		<td width="68" class="Alert">&nbsp;</td>
	</tr>
	<tr>
		<td>City</td>
		<td>
			<input type="text" value="<?php echo $row['station_name']; ?>" name="sendercity" style="width:255px;" readonly/>
		</td>
		<td width="68" class="Alert">&nbsp;</td>
	</tr>
	<tr>
		<td>Tin</td>
		<td>
			<input type="text" value="<?php echo stripslashes(str_replace($search, $replace,$row['identification_number']));?>" name="sendertin" style="width:255px;" readonly/>
		</td>
		<td width="68" class="Alert">&nbsp;</td>
	</tr>