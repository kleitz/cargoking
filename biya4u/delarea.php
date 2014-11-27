<?php 
	include('protect.php');
	include 'dbconnect.php'; 

	$selected_destination = trim($_REQUEST['selected_destination']);
	$selected_city  = trim($_REQUEST['selected_city']);

	$row  = getAssociativeArrayFromSQL($conn, "select * from deliveryarea where station = '$selected_destination' and city = '$selected_city'");

	if($row['delarea'] == "1") 
		$del = "Within City"; 
	if($row['delarea'] == "2") 
		$del = "Outside City";
	if($row['delarea'] == "3") 
		$del = "Excess Baggage Port-Port";
	if($row['delarea'] == "4") 
		$del = "Excess Baggage Door-Door";
 ?>

<input type="text" id="hdDeliveryArea" name="delarea" value="<?php echo $row['delarea']; ?>" />