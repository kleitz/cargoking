<?php
	include("securimage.php"); 

	$searchKey = trim($_POST['verificationAnswer']);

	$img = new Securimage();
	$valid = $img->check($searchKey);

	if($valid) {
		echo "true";
	}
	else {
		echo "false";
	}
?>

