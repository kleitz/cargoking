<?php 
	include("securimage.php"); 
	include('dbconnect.php');

	session_start();

	// username and password sent from signup form 
	$myusername = $_POST['txtusername']; 
	$mypassword = $_POST['txtpassword'];

	$good_pass = mysqli_real_escape_string($conn, $mypassword);

	//$sql="SELECT * FROM adminlogin WHERE adminusername='$myusername' and adminpassword='$good_pass' ";
	$sql="select * from vw_loginusers where username = '$myusername' and password = '$good_pass' ";

	echo "[SQL]: " . $sql . "<br>";

	$result=mysqli_query($conn, $sql);
	while( $row = mysqli_fetch_array($result) ) {
		$login_id            = $row['id'];
		$strusername         = $row['username'];
		//$password          = $row['password'];
		$type_code           = $row['type_code'];
		$type_name           = $row['type_name'];
		$name                = $row['name'];
		$email               = $row['email'];
		$stationId           = $row['station_id'];
		$satelliteOfficeId   = $row['satellite_office_id'];
		$hawbBookingPrefix   = $row['hawb_booking_prefix'];
	}

	// Mysql_num_row is counting table row
	$count = @mysqli_num_rows($result);
	// If result matched $myusername and $mypassword, table row must be 1 row

	$img = new Securimage();
	$valid = $img->check($_POST['code']);

	if($count > 0) { //If username and password is valid (there is atleast one return/result)
		//$img = new Securimage();	
		//$valid = $img->check($_POST['code']);
		if( !$_POST['code'] ) {
			header('location:login.php?Action=captchap');
		}
		else if( $valid )  {
			//$update1 = mysqli_query($conn, "SELECT * FROM adminlogin WHERE adminusername='$myusername' and adminpassword='$mypassword'"); 

			// Register $myusername, $mypassword and redirect to file "login_success.php"
			$_SESSION['login_id']  = $login_id;
			$_SESSION['username']  = $strusername;
			$_SESSION['type_code'] = $type_code;
			$_SESSION['type_name'] = $type_name;
			$_SESSION['name'] = $name;
			$_SESSION['email'] = $email;
			$_SESSION['stationId'] = $stationId;
			$_SESSION['satellite_office_id'] = $satelliteOfficeId;
			$_SESSION['hawb_booking_prefix'] = $hawbBookingPrefix;

			//$_SESSION['ConfirmEmail'] = $row['ConfirmEmail']; 
			header('location:index.php?Action=Success');
			//header($_SERVER['HTTP_REFERER']);
		} 
		else {
			header('location:login.php?Action=captcha');
		} 
	}
	else { //Username and password not found (Can be because of a wrong username, password or both).
		//$img = new Securimage();
		//$valid = $img->check($_POST['code']);
		if( !$_POST['code'] ) {
			header('location:login.php?Action=wrongall');
		}
		else {
			echo "[Login-Id]: " . $login_id . "<br />"; 
			//header('location:login.php?Action=wrong');
		} 
		exit();
	}
?>
