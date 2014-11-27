<?php
	session_start();
	session_unset();
	session_destroy();
	$_SESSION = array(); // Clears the $_SESSION variable
	
	//echo "<p class=data> <center>Successfully,Logged out<br><br><a href='test.php'> Log OUT </a><br><br><a href=welcome.php>Click here if your browser is not redirecting automatically or you don't want to wait.</a><br></center>";
     print "<script>";
     print " self.location='../index.php';"; // Comment this line if you don't want to redirect
     print "</script>";
?>