<?php 
	session_start();

	include('dbconnect.php');
	include('public_utilities.php');
	//include("securimage.php"); 

	$myusername = "";
	$mypassword = "";
	$verifyCode = "";
	if( isset( $myusername ) ) $myusername = $_POST['loginUserName'];
	if( isset( $mypassword ) ) $mypassword = $_POST['loginPassword'];
	//if( isset( $verifyCode ) ) $verifyCode = $_POST['loginVerificationCode'];

	$good_pass = mysqli_real_escape_string($conn, $mypassword);

	$loginUserInfo = loginUser( $conn, $myusername, $good_pass );
	$hasUserInfos = count( $loginUserInfo ) > 0;

	//$img = new Securimage();
	//$isValid = $img->check($_POST['loginVerificationCode']);
	$hasErrors = false;

	if($hasUserInfos) {

		$_SESSION['login_id']  = $loginUserInfo['login_id'];
		$_SESSION['username']  = $loginUserInfo['username'];
		$_SESSION['password']  = $loginUserInfo['password'];
		$_SESSION['type_code'] = $loginUserInfo['type_code'];
		$_SESSION['type_name'] = $loginUserInfo['type_name'];
		$_SESSION['name']      = $loginUserInfo['full_name'];
		$_SESSION['stationId'] = $loginUserInfo['station_id'];
		$_SESSION['satellite_office_id'] = $loginUserInfo['satellite_office_id'];
		$_SESSION['hawb_booking_prefix'] = $loginUserInfo['hawb_prefix_code'];
		$_SESSION['ACTION']    = "success";

		/*
		if($isValid){
			$_SESSION['login_id']  = $loginUserInfo['login_id'];
			$_SESSION['username']  = $loginUserInfo['username'];
			$_SESSION['password']  = $loginUserInfo['password'];
			$_SESSION['type_code'] = $loginUserInfo['type_code'];
			$_SESSION['type_name'] = $loginUserInfo['type_name'];
			$_SESSION['name']      = $loginUserInfo['full_name'];
			$_SESSION['stationId'] = $loginUserInfo['station_id'];
			$_SESSION['satellite_office_id'] = $loginUserInfo['satellite_office_id'];
			$_SESSION['hawb_booking_prefix'] = $loginUserInfo['hawb_prefix_code'];
			$_SESSION['ACTION']    = "success";
		}
		else {
			$_SESSION['ACTION'] = "noVerify";
			$_SESSION['LOGIN_USERNAME']  = $_POST['loginUserName'];
			$_SESSION['LOGIN_PASSWORD']  = $_POST['loginPassword'];
			$_SESSION['LOGIN_VERIFY_CODE']  = $_POST['loginVerificationCode'];
			$hasErrors = true;
		}
		*/
	}
	else {
		$_SESSION['ACTION'] = "noAccess";
		$_SESSION['LOGIN_USERNAME']  = $_POST['loginUserName'];
		$_SESSION['LOGIN_PASSWORD']  = $_POST['loginPassword'];
		$_SESSION['LOGIN_VERIFY_CODE']  = $_POST['loginVerificationCode'];
		$hasErrors = true;
	}

	session_write_close();

	if( !$hasErrors ){
		header("location:index.php");
		exit();
	}
	else {
		header('location:../index.php'); 
		exit();
	}



?>