<?php
	include('protect.php');
	include 'dbconnect.php'; 

	$login_id          = "";
	$type_code         = "";
	$stationId         = "";
	$satelliteOfficeId = "";
	$hawbBookingPrefix = "";

	if( isset($_SESSION['login_id']) )            $login_id          = $_SESSION['login_id'];
	if( isset($_SESSION['type_code']) )           $type_code         = $_SESSION['type_code'];
	if( isset($_SESSION['stationId']) )           $stationId         = $_SESSION['stationId'];
	if( isset($_SESSION['satellite_office_id']) ) $satelliteOfficeId = $_SESSION['satellite_office_id'];
	if( isset($_SESSION['hawb_booking_prefix']) ) $hawbBookingPrefix = $_SESSION['hawb_booking_prefix'];
	
	if($_POST['submit']) {
		$IN_TRANSIT_STATUS_ID = 1;
 
		$date             = null;
		$customerCode     = "";
		$shipperName      = "";
		$shipperAddress   = "";
		$shipperPhone     = "";
		$shipperCity      = "";
		$shipperIdNo      = "";
		$origin           = "";
		$destination      = "";
		$rcity            = "";
		$croute           = "";
		$consigneeName    = "";
		$consigneeAddress = "";
		$consigneePhone   = "";
		$modpay           = "";
		$move             = "";
		$sermode          = "";
		$totalWeight      = "";
		$totalCharges     = "";
		$discountedAmount = "";
		$cargoItemsCount  = "";
		$weightRefId      = "";
		$remarks          = "";
		
		$typeOfShipment   = null;
		$quantity         = null;
		$length           = null;
		$width            = null;
		$height           = null;
		$dimtot           = null;
		$dimensionWeight  = null;
		$actualWeight     = null;
		$preferredWeight  = null;
		$declaredValue    = null;
		
		/* START: Codes for HAWB details */
		if( isset($_POST['date']) )             $date             = $_POST['date'];
		if( isset($_POST['customer']) )         $customerCode     = $_POST['customer'];
		if( isset($_POST['shipperName']) )      $shipperName      = mysqli_real_escape_string($conn, $_POST['shipperName']);
		if( isset($_POST['shipperAddress']) )   $shipperAddress   = mysqli_real_escape_string($conn, $_POST['shipperAddress']);
		if( isset($_POST['shipperPhone']) )     $shipperPhone     = $_POST['shipperPhone'];
		if( isset($_POST['shipperCity']) )      $shipperCity      = $_POST['shipperCity'];
		if( isset($_POST['shipperIdNo']) )      $shipperIdNo      = $_POST['shipperIdNo'];
		if( isset($_POST['origin']) )           $origin           = $_POST['origin'];
		if( isset($_POST['destination']) )      $destination      = $_POST['destination'];
		if( isset($_POST['rcity']) )            $rcity            = $_POST['rcity'];
		if( isset($_POST['croute']) )           $croute           = $_POST['croute'];
		if( isset($_POST['consigneeName']) )    $consigneeName    = mysqli_real_escape_string($conn, $_POST['consigneeName']);
		if( isset($_POST['consigneeAddress']) ) $consigneeAddress = mysqli_real_escape_string($conn, $_POST['consigneeAddress']);
		if( isset($_POST['consigneePhone']) )   $consigneePhone   = $_POST['consigneePhone'];
		if( isset($_POST['modpay']) )           $modpay           = $_POST['modpay'];
		if( isset($_POST['move']) )             $move             = $_POST['move'];
		if( isset($_POST['sermode']) )          $sermode          = $_POST['sermode'];
		if( isset($_POST['totalWeight']) )      $totalWeight      = $_POST['totalWeight'];
		if( isset($_POST['totalCharges']) )     $totalCharges     = $_POST['totalCharges'];
		if( isset($_POST['discountedAmount']) ) $discountedAmount = $_POST['discountedAmount'];
		if( isset($_POST['cargoItemsCount']) )  $cargoItemsCount  = $_POST['cargoItemsCount'];
		if( isset($_POST['weightReferrenceId']))  $weightRefId    = $_POST['weightReferrenceId'];
		if( isset($_POST['remarks']) )          $remarks          = mysqli_real_escape_string($conn, $_POST['remarks']);

		/* START: Codes for adding cargo items */
		if( isset($_POST['typeOfShipment']) )   $typeOfShipment   = $_POST['typeOfShipment'];
		if( isset($_POST['quantity']) )         $quantity         = $_POST['quantity'];
		if( isset($_POST['length']) )           $length           = $_POST['length'];
		if( isset($_POST['width']) )            $width            = $_POST['width'];
		if( isset($_POST['height']) )           $height           = $_POST['height'];
		if( isset($_POST['dimensionTotal']) )   $dimensionTotal   = $_POST['dimensionTotal'];
		if( isset($_POST['dimensionWeight']) )  $dimensionWeight  = $_POST['dimensionWeight'];
		if( isset($_POST['actualWeight']) )     $actualWeight     = $_POST['actualWeight'];
		if( isset($_POST['preferredWeight']) )  $preferredWeight  = $_POST['preferredWeight'];
		if( isset($_POST['declaredValue']) )    $declaredValue     = $_POST['declaredValue'];

		//Get HAWB Booking prefix for the agent
		$SQLInsert  = " insert into booking ( ";
		$SQLInsert .= " prefix,";
		$SQLInsert .= " customer_code,";
		$SQLInsert .= " sender_name,";
		$SQLInsert .= " sender_address,";
		$SQLInsert .= " sender_city,";
		$SQLInsert .= " sender_phone,";
		$SQLInsert .= " identification_number,";
		$SQLInsert .= " satellite_office_id,";
		$SQLInsert .= " origin,";
		$SQLInsert .= " destination,";
		$SQLInsert .= " receiver_name,";
		$SQLInsert .= " receiver_address,";
		$SQLInsert .= " receiver_phone,";
		$SQLInsert .= " payment_mode_id,";
		$SQLInsert .= " movement_type_id,";
		$SQLInsert .= " service_mode_id,";
		$SQLInsert .= " hawb_date,";
		$SQLInsert .= " hawb_status,";
		$SQLInsert .= " remarks,";
		$SQLInsert .= " no_of_items,";
		$SQLInsert .= " weight_ref_id,";
		$SQLInsert .= " total_weight,";
		$SQLInsert .= " total_price,";
		$SQLInsert .= " discounted_price,";
		$SQLInsert .= " created_by,";
		$SQLInsert .= " create_date,";
		$SQLInsert .= " last_modified_by,";
		$SQLInsert .= " last_modified_date";
		$SQLInsert .= " ) values ( ";
		$SQLInsert .= " '$hawbBookingPrefix', ";
		$SQLInsert .= " '$customerCode', ";
		$SQLInsert .= " '$shipperName', ";
		$SQLInsert .= " '$shipperAddress', ";
		$SQLInsert .= " '$shipperCity', ";
		$SQLInsert .= " '$shipperPhone', ";
		$SQLInsert .= " '$shipperIdNo', ";
		$SQLInsert .= " '$satelliteOfficeId', ";
		$SQLInsert .= " '$origin', ";
		$SQLInsert .= " '$destination', ";
		$SQLInsert .= " '$consigneeName', ";
		$SQLInsert .= " '$consigneeAddress', ";
		$SQLInsert .= " '$consigneePhone', ";
		$SQLInsert .= " '$modpay', ";
		$SQLInsert .= " '$move', ";
		$SQLInsert .= " '$sermode', ";
		$SQLInsert .= " str_to_date('$date', '%d-%m-%Y'), ";
		$SQLInsert .= " '$IN_TRANSIT_STATUS_ID', ";
		$SQLInsert .= " '$remarks', ";
		$SQLInsert .= " '$cargoItemsCount', ";
		$SQLInsert .= " '$weightRefId', ";
		$SQLInsert .= " '$totalWeight', ";
		$SQLInsert .= " '$totalCharges', ";
		$SQLInsert .= " '$discountedAmount', ";
		$SQLInsert .= " '$login_id', ";
		$SQLInsert .= " now(), ";
		$SQLInsert .= " '$login_id', ";
		$SQLInsert .= " now() ";
		$SQLInsert .= " ) ";

		//echo "[SQL Insert Booking]:<br><br>" . $SQLInsert . "<br>";
		mysqli_query($conn,  "BEGIN" );

		$successInsertion = mysqli_query($conn,  $SQLInsert );
		$hawbBookingId = mysqli_insert_id($conn);

		if( 0 == mysqli_errno() ){
			for( $i=0; $i < $cargoItemsCount; $i++ ){
				$hawBookingCode = $hawbBookingPrefix . "-" . $hawbBookingId;
				$shipmentType = ($typeOfShipment[$i] == "") ? -1 : $typeOfShipment[$i]; 
				$qty = ($quantity[$i] == "") ? 1 : $quantity[$i]; 
				$valL = ($length[$i] == "") ? 0 : $length[$i]; 
				$valW = ($width[$i] == "") ? 0 : $width[$i]; 
				$valH = ($height[$i] == "") ? 0 : $height[$i]; 
				$totalSize = ($dimensionTotal[$i] == "") ? 0 : $dimensionTotal[$i]; 
				$totalWeight = ($dimensionWeight[$i] == "") ? 0 : $dimensionWeight[$i]; 
				$actualW = ($actualWeight[$i] == "") ? 0 : $actualWeight[$i];
				$preferredW = ($preferredWeight[$i] == "") ? 0 : $preferredWeight[$i];
				$declaredVal = ($declaredValue[$i] == "") ? 0 : $declaredValue[$i]; 

				$SQLHawbAmountInsert  = " insert into booking_item_details (booking_id, booking_code, shipment_type_id, quantity, container_length, container_width, container_height, dimension_total, dimension_weight, actual_weight, preferred_weight, declared_value, created_by, create_date, last_modified_by, last_modified_date ) values ( ";
				$SQLHawbAmountInsert .= " '$hawbBookingId',";
				$SQLHawbAmountInsert .= " '$hawBookingCode',";
				$SQLHawbAmountInsert .= " '$shipmentType',";
				$SQLHawbAmountInsert .= " '$qty',";
				$SQLHawbAmountInsert .= " '$valL',";
				$SQLHawbAmountInsert .= " '$valW',";
				$SQLHawbAmountInsert .= " '$valH',";
				$SQLHawbAmountInsert .= " '$totalSize',";
				$SQLHawbAmountInsert .= " '$totalWeight',";
				$SQLHawbAmountInsert .= " '$actualW',";
				$SQLHawbAmountInsert .= " '$preferredW',";
				$SQLHawbAmountInsert .= " '$declaredVal',";
				$SQLHawbAmountInsert .= " '$login_id',";
				$SQLHawbAmountInsert .= " now(),";
				$SQLHawbAmountInsert .= " '$login_id',";
				$SQLHawbAmountInsert .= " now()";
				$SQLHawbAmountInsert .= " ) ";

				//echo "[SQL]: " . $SQLHawbAmountInsert . "<br><br>";
				mysqli_query($conn,  $SQLHawbAmountInsert );
				if( 0 != mysqli_errno($conn) ){
					mysqli_query($conn,  "ROLLBACK" );
					header("Status: 400 Internal Server Error");
					echo "<div class='errorContainer'>";
					echo "<span class='errorMessage'>Error Number: " . mysqli_errno($conn) . "</span><br />";
					echo "<span class='errorMessage'>Error: " . mysqli_error($conn) . "</span><br />";
					echo "<span class='errorMessage'>SQL:<br>" . $SQLHawbAmountInsert . "</span><br />";
					echo "</div>";
					exit;
				}
				else {

					//insert boking status
					//check if has errors
					//if there are any errors, rollback
					//Otherwise proceed with commit
					//redirect to newbook.php with success status

					$SQLHawbBookingStatus  = " insert into booking_status( hawb_id, hawb_code, status_date, status_time, location_id, satellite_office_id, status_id, comments, created_by, create_date, last_modified_by, last_modified_date ) values ( ";
					$SQLHawbBookingStatus .= " '$hawbBookingId', ";
					$SQLHawbBookingStatus .= " '$hawBookingCode', ";
					$SQLHawbBookingStatus .= " curdate(), ";
					$SQLHawbBookingStatus .= " curtime(), ";
					$SQLHawbBookingStatus .= " '$origin', ";
					$SQLHawbBookingStatus .= " '$satelliteOfficeId', ";
					$SQLHawbBookingStatus .= " '10', "; //SAT_OFC_TO_ORIGIN_PORT: Satellite Office to Port (Origin)
					$SQLHawbBookingStatus .= " 'Satellite Office (Branch) to Port (Origin)', ";
					$SQLHawbBookingStatus .= " '$login_id', ";
					$SQLHawbBookingStatus .= " now(), ";
					$SQLHawbBookingStatus .= " '$login_id', ";
					$SQLHawbBookingStatus .= " now() ";
					$SQLHawbBookingStatus .= " ) ";


					//echo "[SQL]: " . $SQLHawbBookingStatus . "<br><br>";
					mysqli_query($conn,  $SQLHawbBookingStatus );
					if( 0 != mysqli_errno($conn) ){
						mysqli_query($conn,  "ROLLBACK" );
						header("Status: 400 Internal Server Error");
						echo "<div class='errorContainer'>";
						echo "<span class='errorMessage'>Error Number: " . mysqli_errno($conn) . "</span><br />";
						echo "<span class='errorMessage'>Error: " . mysqli_error($conn) . "</span><br />";
						echo "<span class='errorMessage'>SQL:<br>" . $SQLHawbBookingStatus . "</span><br />";
						echo "</div>";
						exit;
					}

				}
			}
			mysqli_query($conn,  "COMMIT" );
			header('Location: newbook.php?action=add&success=true');
		}
		else {
			mysqli_query($conn,  "ROLLBACK" );
			header("Status: 400 Internal Server Error");
			echo "<div class='errorContainer'>";
			echo "<span class='errorMessage'>Error Number: " . mysqli_errno($conn) . "</span><br />";
			echo "<span class='errorMessage'>Error: " . mysqli_error($conn) . "</span><br />";
			echo "<span class='errorMessage'>SQL: " . $SQLInsert . "</span><br />";
			echo "</div>";
			exit;
		}
	}
?>