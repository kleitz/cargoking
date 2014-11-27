<?php 
	include('protect.php');
	include 'dbconnect.php';
	include('utilities.php');
	include "qrlib/qrlib.php";

	$id=$_GET['ed'];
	$root=$_SERVER['HTTP_HOST'];

	$result = getAssociativeArrayFromSQL($conn, "SELECT * FROM vw_booking_details where id='$id'"); 

	$rsServiceMode = mysqli_query($conn, "select * from servicemode");
	$rsMovement = mysqli_query($conn, "select * from movement");
	$rsMop = mysqli_query($conn, "select * from mop");

	$sqlCargoItems = "select * from vw_hawb_items where booking_id = '" . $result['id'] . "'";
	$rsCargoDetails = mysqli_query($conn, $sqlCargoItems);

	$idx = 0;
	$arHawbItems = array();
	while( $row = mysqli_fetch_array($rsCargoDetails) ) {
		$arHawbItems[$idx] = $row;
		$idx++;
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/style.css" type="text/css"  rel="stylesheet" media="print"/>
<head><title>Print HAWB</title>
<script src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		window.print();
	});
	function PrintElem(elem) {
		Popup($(elem).html());
	}
</script>
<style type="text/css">
	body{
		background:#FFF;
		font-size:11px;
		font-family:Arial, Helvetica, sans-serif;
	}
	.small
	{
		font-family:"Times New Roman", Times, serif;
		font-size:9px;
	}
	.cargoInfo { font-weight: bold; font-size: 14px; padding:5px; vertical-align: top; }
	.cargoCharge { font-weight: bold; font-size: 12px; padding:5px; vertical-align: top; }
	.cargoInfoTable { border: 2px solid black; }
	.cargoInfoHeader { border-bottom: 2px solid black; padding: 2px; }
	.cargoInfoDetails { border-bottom: 1px solid black; font-weight: bold; font-size: 14px; padding:10px 5px; vertical-align: top; text-align: center; }
	.cargoInfoFirstHeader { border-bottom: 2px solid black; padding: 2px 10px; text-align: left; }
	.cargoInfoFirstDetail { border-bottom: 1px solid black; font-weight: bold; font-size: 14px; padding:10px 10px; vertical-align: top; text-align: left; }
	.cargoInfoFirstCharges { border-bottom: 1px solid #D6D6C2; font-weight: bold; font-size: 11px; padding:5px 10px; vertical-align: top; }
	.cargoInfoCharges { border-bottom: 1px solid #D6D6C2; font-weight: bold; font-size: 12px; padding:5px; vertical-align: top; }
	.cargoInfoBlankSpaces { border-bottom: 1px solid #F5F9F9; font-weight: bold; font-size: 12px; padding:5px; vertical-align: top; }
	.cargoInfoRemarks { border-top: 2px solid black; font-weight: bold; font-size: 14px; padding:10px 5px; vertical-align: top; }
	.reportInfoTable { border-top: 2px solid black; border-bottom: 2px solid black; border-left: 2px solid black; }
	.rightBorder { border-right: 1px solid black; }
	.bottomBorder { border-bottom: 1px solid black; }
	.bottomRightBorder { border-bottom: 1px solid black; border-right: 1px solid black; }
	.reportData { padding-left: 5px; }
</style>
</head>

<body>
	<?php include('print_view_template.php'); ?>
	<br />
	<br />
	<br />
	<br />
	<?php include('print_view_template.php'); ?>
</body>
</html>