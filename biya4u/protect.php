<?php

	session_start();

	/*
	echo "[Username]: " . $_SESSION['username'] . "<br />";
	echo "[Session ID]: " . session_id() . "<br />";
	*/

	if( !isset( $_SESSION['username'] ) ) {
		header('location:../index.php');
	}
?>