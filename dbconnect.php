<?php
	ob_start();
	if( !is_resource($conn) ) {
		$conn = mysqli_connect("127.0.0.1:3306","root","root", "ehi8so1c_cargoking") or die ('Error Connectiong to mysql: '.mysqli_error());
		if (mysqli_connect_errno()) {
		    throw new Exception(mysqli_connect_error(), mysqli_connect_errno());
		}
	}
?>

