<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="UTF-8">
	<title>Contact Us</title>
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

		$(function() {
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
	<body id="contactUsPage">
		<center>
			<div class="headerContainer" align="left">
				<?php include('headerFlat.php'); ?>
			</div> <!-- end of hearderContainter -->
			<div id="menuContainerDiv" class="menuContainer"> 
				<?php include('menuFlat.php'); ?>
			</div>
			<div class="contaUsContainer">
				<div class="contactForm">
					<form action="" method="post" enctype="contact-form-data" name="contact-form-data">
					<div class="getintouchContainer"><p class="getinTouch">Get in touch with us</p></div>
						<div>
							<div class="nameIcon"></div>
							<input type="text" name="name" placeholder="Name" required class="formfield" />
						</div>
						<div>
							<div class="addressIcon"></div>
							<input type="text" name="name" placeholder="Address" class="formfield" />
						</div>
						<div>
							<div class="emailIcon"></div>
							<input type="email" name="email-add" placeholder="Email Address" required class="formfield" />
						</div>
						<div>
							<div class="phoneIcon"></div>
							<input type="tel" name="tel" placeholder="Phone Number" maxlength="11" required class="formfield" />
						</div>
						<div>
							<div class="msgIcon"></div>
							<textarea rows="3" cols="30" placeholder="Your message..." required class="msgeArea"></textarea>
						</div>
						<input type="submit" value="Submit" class="submitButton" />
					</form>
				</div>
			</div>
			<div class="footer">
				<?php include('footerFlat.php'); ?>
			</div>
		</center>
	</body>
</html>