<?php 
	include 'dbconnect.php';

	$searchKey = $_POST['suggest'];
	
	$SQLQuery  = " SELECT * FROM vw_customers ";
	$SQLQuery .= " WHERE lower(concat(cust_id, cust_name, address, station_name, satellite_office_name)) like '%" . $searchKey . "%' ";
	$SQLQuery .= " ORDER BY cust_name ASC ";
	$SQLQuery .= " LIMIT 0, 10 ";

	$cus_query = mysqli_query($conn,  $SQLQuery ) or die(mysqli_error()); 
	while( $cus_row = mysqli_fetch_assoc($cus_query) ) {
		$elementHtml  = "<li style=\"border-bottom:#D2D2D2 1px dotted; cursor:pointer;\">";
		$elementHtml .= "	<a onclick=\"loadSelectedCustomerInfos('" . $cus_row['cust_id'] . "');\" style=\"color: #FFFFFF;\">";
		$elementHtml .= 		$cus_row['cust_id'] . ": " . $cus_row['cust_name'] . " (" . $cus_row['station_name'] . ")";
		$elementHtml .= "	</a>";
		$elementHtml .= "</li>";
		echo  $elementHtml . "\n" ;
	}
?>