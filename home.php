<?php 
  	session_start();
	include('biya4u/dbconnect.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="UTF-8">
	<title>Cargo King</title>
	<link rel="stylesheet" href="css/styleMenu.css">
	<link rel="stylesheet" href="css/bodyAndHeader.css">
	<link rel="stylesheet" href="css/aboutCargoKing.css">
	<link rel="stylesheet" href="css/branches.css">
	<link rel="stylesheet" href="css/contactUs.css">
	<link rel="stylesheet" href="css/footer.css">
	<link rel="stylesheet" type="text/css" href="css/jquery.bxslider.css"/>
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/jquery.bxslider.min.js"></script>
	<script src="js/menu.js"></script>

	<script type="text/javascript">
		var	SCROLL_TOP_LIMIT=124;
		$(document).ready(function(){
			$('.bxslider').bxSlider({
				auto: true,
				autoControls: true,
				mode: 'fade'
			});
			var par = $('#loginForm');
			$('#loginForm').hide();
			$('#loginBtn').click (function() {
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
	<body id="homePage">
		<center>
			<div class="headerContainer" align="left">
				<?php include('headerFlat.php'); ?>
			</div> <!-- end of hearderContainter -->
					<div id="menuContainerDiv" class="menuContainer"> 
					<?php include('menuFlat.php'); ?>
					<div class="searchCargoContainer">
							<input class="searchCargoBox" type="text" id="txtSearchCargo" title="Enter HAWB ID to search" placeholder="Search Cargo" maxlength="18" />
							<a href="javascript:void();" onclick="alert('Call cargo tracker AJAX/JSON');" class="search-button"><img src="images/search-icon.png" /></a>
					</div>
					<div class="loginContainer">
						<div id="loginBtn" class="txtLogin">
							<span>Login</span>
						</div>
						<div id="loginForm" class="loginFormContainer">
							<form action="biya4u/submit_login.php" method="post" enctype="login-form-data" name="login-form-data">
								<div>
									<div class="usernameIcon"></div>
									<input type="text" id="txtUsername" name="loginUserName" placeholder="Username" required class="logintextField" />
								</div>
								<div>
									<div class="passwordIcon"></div>
									<input type="password" id="txtLoginPassword" name="loginPassword" placeholder="Password" class="logintextField" />
								</div>
								<div>
									<div class="checkIcon"></div>
									<input type="text" id="txtLoginVerificationCode" name="loginVerificationCode" placeholder="Verification Code" required class="logintextField" />
									<div class="forgotPassword"><a href="#">Forgot your password?</a></div>
								</div>
								<div class="capchaContainer">
									<img src="biya4u/securimage_show.php?sid=<?php echo md5(uniqid(time())); ?>" />
								</div>
									<input type="submit" value="Login" class="loginBtn" />
							<!--	<div>
									<p class="checkBox"><input type="checkbox" name="checkbox" />Login to other branch</p>
									<p><select required class="branchSelector">
										<option value="">Please Select Branch</option>
										<option value="Manila">Manila</option>
										<option value="Davao">Davao</option>
										<option value="Zamboanga">Zamboanga</option>
										<option value="cagayanDeOro">Cagayan de Oro</option>
										<option value=" Butuan">Butuan</option>
										<option value=" Tagbilaran">Tagbilaran</option>
										<option value=" Cebu">Cebu</option>
									</select></p>	
								</div> -->
							</form>
						</div>
					</div>
				</div>  <!-- end of menuSection --> 
					<div class="slideshowContainer">
						<div class="slideshowsection">
							<div class="middle_partWrap" align="center"> 
								<div id="divImageSliderContainer" class="clearfix colelem" style="width: 945px; height: 345px">
									<ul class="bxslider">
										<li><img src="images/4.jpg" height="340" width="100%"  style="margin-left: -79px; margin-top: -25px" /></li>
										<li><img src="images/21.jpg" height="340" width="100%" style="margin-left: -79px; margin-top: -25px" /></li>
										<li><img src="images/5.jpg" height="340" width="100%" style="margin-left: -79px; margin-top: -25px" /></li>
									</ul>
								</div>
								<div class="clear"></div>
								<div class="marque_wrp_txt">
									<marquee id="marq6" scrollamount="3">
										<a onmouseover="document.getElementById('marq6').stop();" onmouseout="document.getElementById('marq6').start();" style="text-decoration:none"></a>
									</marquee>
								</div>  
							</div>
						</div> <!-- end of slideshowSection -->
					   <!-- <div class="divCargoTracker">Cargo Tracker Here</div> -->
					</div> <!-- end of slideshowContainer -->
					<div class="footer">
						<?php include('footerFlat.php'); ?>
					</div> <!-- end of footerContainer -->
		</center>
	</body>
</html>