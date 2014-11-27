<?php
	include('protect.php');
	include 'dbconnect.php'; 

	session_start();

	$login_id     = "";
	$type_code = "";
	$stationId = "";
	if( isset($_SESSION['login_id']) )  $login_id  = $_SESSION['login_id'];
	if( isset($_SESSION['type_code']) ) $type_code = $_SESSION['type_code'];
	if( isset($_SESSION['stationId']) ) $stationId = $_SESSION['stationId'];

	/*
	echo "User Type: "  . $type_code . "<br>";
	echo "Station ID: " . $stationId . "<br>";
	echo "Login ID: "   . $login_id . "<br>";
	*/

	if($_POST['submit']) {

		$customerFirstName             = mysqli_real_escape_string($conn, $_REQUEST['customerFirstName']);
		$customerLastName              = mysqli_real_escape_string($conn, $_REQUEST['customerLastName']);
		$customerMiddleName            = mysqli_real_escape_string($conn, $_REQUEST['customerMiddleName']);
		$customerAddress               = mysqli_real_escape_string($conn, $_REQUEST['customerAddress']);
		$customerStation               = mysqli_real_escape_string($conn, $_REQUEST['customerStation']);
		$satelliteOffice               = mysqli_real_escape_string($conn, $_REQUEST['satelliteOffice']);
		$customerPhone                 = mysqli_real_escape_string($conn, $_REQUEST['customerPhone']);
		$customerEmail                 = mysqli_real_escape_string($conn, $_REQUEST['customerEmail']);
		$customerIdentificationType    = mysqli_real_escape_string($conn, $_REQUEST['customerIdentificationType']);
		$customerIdentificationNo      = mysqli_real_escape_string($conn, $_REQUEST['customerIdentificationNo']);
		$customerPercentageDiscount    = mysqli_real_escape_string($conn, $_REQUEST['customerPercentageDiscount']);

		if( trim($customerIdentificationType) == '-1' ) {
			$customerIdentificationNo = '';
		}
		
		if( strlen(trim($customerPercentageDiscount)) == 0 ) {
			$customerPercentageDiscount = 0.0;
		}

		/*
		echo "<div style='border: 1px solid green; padding: 10px; display: block;'>";
		echo "[Name]: " . $customerFirstName . " " . $customerLastName . "<br>";
		echo "[Middle name]: " . $customerMiddleName . "<br>";
		echo "[Address]: " . $customerAddress . "<br>";
		echo "[Station]: " . $customerStation . "<br>";
		echo "[Satellite]: " . $satelliteOffice . "<br>";
		echo "[Phone]: " . $customerPhone . "<br>";
		echo "[Email]: " . $customerEmail . "<br>";
		echo "[ID Type]: [" . $customerIdentificationType . "]<br>";
		echo "[ID No]: [" . $customerIdentificationNo . "]<br>";
		echo "</div>";
		*/

		$SQLInsert  = " insert into customer (first_name, last_name, middle_name, address, station_id, satellite_office_id, phone, email_address, identification_type, identification_number, percentage_discount, created_by, creation_date, last_modified_date) ";
		$SQLInsert .= " values ('$customerFirstName', '$customerLastName', '$customerMiddleName', '$customerAddress', $customerStation, $satelliteOffice, '$customerPhone', '$customerEmail', '$customerIdentificationType', '$customerIdentificationNo', $customerPercentageDiscount, $login_id, now(), now())";
		$successInsertion = mysqli_query($conn,  $SQLInsert );

		//echo "[SQL]: " . $SQLInsert . "<br>";
		
		if( $successInsertion ) {
			header('Location: customer.php?action=add&success=true');
		}
		else {
			$errorNo  = mysqli_errno($conn);
			$errorMsg = mysqli_error($conn);
			header("HTTP/1.1 500 Internal Server Error");
			echo "<div class='errorContainer'>";
			echo "<span class='errorMessage'>Error Number: " . $errorNo . "</span><br />";
			echo "<span class='errorMessage'>Error: " . $errorMsg . "</span><br />";
			echo "</div>";
		}
	}   
?>