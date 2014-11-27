<?php 
	include('protect.php');
	include 'dbconnect.php'; 

	$totalWeight = 0;
	$satellite_office   = "";
	$isConnectingRoute = "false";
	$totalDeclaredValue = 0;
	
	if( isset($_REQUEST['totalWeight']) )        $totalWeight        = $_REQUEST['totalWeight'];
	if( isset($_REQUEST['satellite_office']) )   $satellite_office   = $_REQUEST['satellite_office'];
	if( isset($_REQUEST['isConnectingRoute']) )  $isConnectingRoute  = $_REQUEST['isConnectingRoute'];
	if( isset($_REQUEST['totalDeclaredValue']) ) $totalDeclaredValue = $_REQUEST['totalDeclaredValue'];

	$rate = 0;
	if($totalWeight > 49) {
		if($totalWeight > 49 && $totalWeight < 1001) {
			$query = mysqli_query($conn, "select * from weight where weightvalue='50-1000' and delarea='$satellite_office'");
			$row   = mysqli_fetch_array($query);
			$rate  = $row['rate'] * $totalWeight;
		}
		else {
			$query = mysqli_query($conn, "select * from weight where weightvalue='1001--' and delarea='$satellite_office'");
			$row   = mysqli_fetch_array($query);
			$rate  = $row['rate'] * $totalWeight;
		}	
	}
	else {
		$query = mysqli_query($conn, "select * from weight where weightvalue='$totalWeight' and delarea='$satellite_office'");
		$row   = mysqli_fetch_array($query);	
		$rate  = $row['rate'];
	}

	if($isConnectingRoute == "yes") {
		$rate = $rate * 2 ;
	}

	$rate += $totalDeclaredValue;

	$computedValues = array();
	$computedValues["weight_referrence_id"] = $row['id'];
	$computedValues["total_price"] = $rate;
	$computedValues["total_wo_declared_value"] = $row['rate'];
	$computedValues["commission"] = $row['commission'];
	$computedValues["amount_due_to_cargoking"] = $row['duecar'];
	
	echo json_encode($computedValues);
?>