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

	//$md_edit = "";
	//if( isset($_REQUEST['ed']) ) $md_edit = $_REQUEST['ed'];

	if($_POST['submit']) {

		$customerID                    = mysqli_real_escape_string($conn, $_REQUEST['customer_id']);
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

		$SQLUpdate   = " UPDATE customer SET ";
		$SQLUpdate  .= "    first_name = '$customerFirstName', ";
		$SQLUpdate  .= "    last_name = '$customerLastName', ";
		$SQLUpdate  .= "    middle_name = '$customerMiddleName', ";
		$SQLUpdate  .= "    address = '$customerAddress', ";
		$SQLUpdate  .= "    station_id = $customerStation, ";
		$SQLUpdate  .= "    satellite_office_id = $satelliteOffice, ";
		$SQLUpdate  .= "    phone = '$customerPhone', ";
		$SQLUpdate  .= "    email_address = '$customerEmail', ";
		$SQLUpdate  .= "    identification_type = '$customerIdentificationType', ";
		$SQLUpdate  .= "    identification_number = '$customerIdentificationNo', ";
		$SQLUpdate  .= "    percentage_discount = $customerPercentageDiscount, ";
		$SQLUpdate  .= "    created_by = '$login_id', ";
		$SQLUpdate  .= "    last_modified_date = now() ";
		$SQLUpdate  .= " WHERE id = " . $customerID;

		//echo "[SQL]: " . $SQLUpdate . "<br>";

		$successInsertion = mysqli_query($conn,  $SQLUpdate );

		if( $successInsertion ) {
			echo "<script>";
			echo "   window.opener.location.href='customer_rep.php?action=update&success=true';";
			echo "   window.close();";
			echo "</script>";

			//header('Location: customer_rep.php?action=update&success=true');
		}
		else {
			$errorNo  = mysqli_errno($conn);
			$errorMsg = mysqli_error($conn);
		}
	}   
?>