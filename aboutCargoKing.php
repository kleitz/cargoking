<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="UTF-8">
	<title>About Cargo King</title>
	<link rel="stylesheet" href="css/styleMenu.css">
	<link rel="stylesheet" href="css/bodyAndHeader.css">
	<link rel="stylesheet" href="css/aboutCargoKing.css">
	<link rel="stylesheet" href="css/branches.css">
	<link rel="stylesheet" href="css/contactUs.css">
	<link rel="stylesheet" href="css/footer.css">
	<script src="biya4u/js/jquery-1.11.1.min.js"></script>
	<script src="biya4u/js/jquery.bxslider.min.js"></script>
	<script src="biya4u/js/jquery.bpopup.min.js"></script>
	<script src="js/menu.js"></script>
	<script>
		var	SCROLL_TOP_LIMIT=126;

		$(document).ready(function() {
			var par = $('#loginForm');
			$('#loginForm').hide();
			$('#loginMenu').click (function() {
				$('#loginForm').toggle();
				$(this).parent().css({'z-index' : '999'});
			});

			$("#menuContainerDiv").wrap("<div class=\"menuPlaceholder\"></div>");
			$(".menuPlaceholder").height($("#menuContainerDiv").outerHeight());
		});

		$(document).scroll(function(evt){
		  	showFloatingMenu(SCROLL_TOP_LIMIT);
     	});
	</script>
</head>
	<body id="aboutUsPage">
		<center>
			<div class="headerContainer" align="left">
				<?php include('headerFlat.php'); ?>
			</div> <!-- end of hearderContainter -->
			<div id="menuContainerDiv" class="menuContainer"> 
				<?php include('menuFlat.php'); ?>
			</div>
			<div class="paragraphContainer">
				<div class="aboutCargoking">
					<div>
					    <h2>What is Cargo King?</h2>
							<p class="paragraph"> &nbsp;&nbsp; Is a logistics service provider which is committed to deliver a total logistics solutions to clients, in a most efficient, cost effective and timely manner promising a more dependable courier at half the price every “JUAN” is paying.</p>
							<p class="cargokingAdvantage"><span class="checkSymbol">&#10004;</span>Fast and efficient, always on-time. <br />
							<span class="checkSymbol">&#10004;</span>Assured drop in your air cargo expenses.<br />
							<span class="checkSymbol">&#10004;</span>Safe and secured while in transit.<br />
							<span class="checkSymbol">&#10004;</span>Accurate dissemination and tracking of information rendered by our highly trained and <br /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; customer oriented personnel.</p>
						<h2>Cargo King Origin</h2>
							<p class="paragraph">&nbsp;&nbsp; Being in the cargo industry handling airport to airport services for more than decade and counting, we are looking forward to expand our services by creating and launching new products that are efficient and cost effective. Our more than 50 years of combined experience, inspired us to create a new product called “Cargo King”.</p>
							<p class="paragraph">&nbsp;&nbsp; Cargo King will be the first service provider in the country with offices located at the airports, making cargo handling safe and secured, fast, and cost efficient.</p>
					</div>
				</div>
			</div>
			<div class="footer">
				<?php include('footerFlat.php'); ?>
			</div>
		</center>
	</body>
</html>