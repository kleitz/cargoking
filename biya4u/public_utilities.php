<?php

	function loginUser( $conn, $userName, $password ) {
		$sqlLogin = "select * from vw_loginusers where username = '$userName' and password = '$password' ";
		$loginUserInfo = array();
		$results = mysqli_query($conn, $sqlLogin);
		if( $results ) {
			while( $row = mysqli_fetch_assoc( $results ) ) {
				$loginUserInfo['login_id']            = $row['id'];
				$loginUserInfo['username']            = $row['username'];
				$loginUserInfo['password']            = $row['password'];
				$loginUserInfo['type_code']           = $row['type_code'];
				$loginUserInfo['type_name']           = $row['type_name'];
				$loginUserInfo['full_name']           = $row['name'];
				$loginUserInfo['station_id']          = $row['station_id'];
				$loginUserInfo['satellite_office_id'] = $row['satellite_office_id'];
				$loginUserInfo['hawb_prefix_code']    = $row['hawb_booking_prefix'];
			}
		}
		return $loginUserInfo;
	}

?>