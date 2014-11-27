<?php 
	include('protect.php');
	include('dbconnect.php');

	$area_name = "";
	if( isset($_REQUEST['area_name']) ) $area_name = trim($_REQUEST['area_name']);

	$SQLBranches = "SELECT id as value, area as label FROM delivery_area where station = '$area_name' order by area ASC";
	$result = mysqli_query($conn, $SQLBranches);
	$recordCount = mysqli_num_rows($result);

	$options = array();
	if( $recordCount > 0 ) {
		$idx = 0;
		while($row = mysqli_fetch_array($result)) {
			$mapOption = array("label" => $row["label"], "value" => $row["value"]);			
			$options[$idx++] = $mapOption;
		}
	}
	echo json_encode($options);
?>