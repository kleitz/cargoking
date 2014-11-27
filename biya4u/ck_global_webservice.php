<?php
	session_start();
	include('dbconnect.php');
	include('public_utilities.php');

	$myusername = "";
	$mypassword = "";
	if( isset( $myusername ) ) $myusername = $_POST['loginUserName'];
	if( isset( $mypassword ) ) $mypassword = $_POST['loginPassword'];

	/* Steps/Procedures:
	 * Login
	 * Search Cargo/HAWB Item Status
	 * Update HAWB Item Status
	*/

?>