<?php
	include('constants.php');
	//echo "<span style='padding-left: 15px;'>Success - Login!</span><br />";  
	//echo "<span style='padding-left: 15px;'>Member: " . $_SESSION['type_code'] . "</span><br />";

	session_start();

	$login_name = "";
	$type_code = "";
	$stationId = "";
	if( isset($_SESSION['name']) )      $login_name = $_SESSION['name'];
	if( isset($_SESSION['type_code']) ) $type_code  = $_SESSION['type_code'];
	if( isset($_SESSION['stationId']) ) $stationId  = $_SESSION['stationId'];
?>
<img src="images/logo.png" style="padding: 2px; margin-top: 10px; margin-left: 10px;" />
