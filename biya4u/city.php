<?php 
	include('protect.php');
	include 'dbconnect.php';

	$sug = trim($_REQUEST['suggest']);
	$row = mysqli_query($conn, "select * from deliveryarea where station='$sug' order by city asc");

	$selectHTML  = "";
	$selectHTML .= "<select id=\"sel_rcity\" name=\"rcity\" class=\"form-field\" style=\"width:280px;\" onchange=\"setDeliveryArea()\">";
	$selectHTML .= "	<option value=\"\">--[Select]--</option>";

					while( $rs = mysqli_fetch_array($row) )
						$selectHTML .= "<option value='" . $rs['city'] . "'>" . $rs['city'] . "</option>";

	$selectHTML .= "</select>";

	echo($selectHTML);
?>