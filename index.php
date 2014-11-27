<?php 
  	session_start();
	include('biya4u/dbconnect.php');
	include('biya4u/constants.php');
	include('biya4u/utilities.php');

	$action = "";
	$loginUsername = "";
	$loginPassword = "";
	//$verifyCode = "";
	if( isset($_SESSION['ACTION']) )             $action = $_SESSION['ACTION'];
	if( isset($_SESSION['LOGIN_USERNAME']) )     $loginUsername = $_SESSION['LOGIN_USERNAME'];
	if( isset($_SESSION['LOGIN_PASSWORD']) )     $loginPassword = $_SESSION['LOGIN_PASSWORD'];
	//if( isset($_SESSION['LOGIN_VERIFY_CODE']) )  $verifyCode = $_SESSION['LOGIN_VERIFY_CODE'];

	$errorMsg = "";
	if($action == ACTION_NO_ACCESS){
		$errorMsg = "Invalid username/password";
	}
	else if($action == ACTION_VERIFICATION_FAILED){
		$errorMsg = "Verification failed";
	}

	unset($_SESSION['ACTION']);
	unset($_SESSION['LOGIN_USERNAME']);
	unset($_SESSION['LOGIN_PASSWORD']);
	unset($_SESSION['LOGIN_VERIFY_CODE']);
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
	<link rel="stylesheet" href="css/jquery.bxslider.css"/>
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="biya4u/js/jquery.bxslider.min.js"></script>
	<script src="biya4u/js/jquery.bpopup.min.js"></script>
	<script src="js/menu.js"></script>

	<script type="text/javascript">
		var	SCROLL_TOP_LIMIT=130;

		var action        = "<?php echo $action; ?>";
		var errorMsg      = "<?php echo $errorMsg; ?>";
		var loginUsername = "<?php echo $loginUsername; ?>";
		var loginPassword = "<?php echo $loginPassword; ?>";
		//var verifyCode    = "<?php echo $verifyCode; ?>";

		$(document).ready(function(){
			$('.bxslider').bxSlider({
				auto: true,
				autoControls: true,
				mode: 'fade'
			});
			var par = $('#loginForm');
			$('#loginForm').hide();
			$('#loginMenu').click (function() {
				$('#loginForm').toggle();
				$(this).parent().css({'z-index' : '999'});
			});
			$("#menuContainerDiv").wrap("<div class=\"menuPlaceholder\"></div>");
    		$(".menuPlaceholder").height($("#menuContainerDiv").outerHeight());

			if(loginUsername != "" && loginPassword != ""){
				$("#txtUsername").val(loginUsername);
				$("#txtLoginPassword").val(loginPassword);
			}

    		if(action == "noAccess"){
    			$('#loginForm').toggle().parent().css({'z-index' : '999'});
    			showDialog("divErrorLogin", "spanErrorMsg", errorMsg);
    		}
    		else if(action == "noVerify"){
    			$('#loginForm').toggle().parent().css({'z-index' : '999'});
    			showDialog("divErrorLogin", "spanErrorMsg", errorMsg);
    		}
    		
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
			</div>
			<!-- end of hearderContainter -->
			<div id="menuContainerDiv" class="menuContainer"> 
				<?php include('menuFlat.php'); ?>
			</div>
			<!-- end of menuSection --> 
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
					<div>
						<div class="banner">
			        		<div>
				        		<ul class="ch-grid">
									<li>
										<div class="ch-item ch-img-1">
											<div class="ch-info">
												<h4>Get a Quote</h4>
												<p><a href="#">Click Here</a></p>
											</div>
										</div>
									</li>
								</ul>
							</div>
			        		<h3>Get a Quote</h3>
			        		<p>100% convertable to HTML/CSS layout.</p>
			        		<a class="bannerButton" href="#">Get Info</a>
			        	</div>
			            <div class="banner">
			                <div>
				        		<ul class="ch-grid">
									<li>
										<div class="ch-item ch-img-2">
											<div class="ch-info">
												<h4>Schedule a Pickup</h4>
												<p><a href="#">Click Here</a></p>
											</div>
										</div>
									</li>
								</ul>
							</div>
			                <h3>Schedule a Pickup</h3>
			                <p>100% convertable to HTML/CSS layout.</p>
			                <a class="bannerButton" href="#">Get Info</a>
			            </div>
			            <div class="banner">
			                 <div>
				        		<ul class="ch-grid">
									<li>
										<div class="ch-item ch-img-3">
											<div class="ch-info">
												<h4>Locate a Branch</h4>
												<p><a href="javascript:void(0);" onclick="location.href='locateBranches.php'">Click Here</a></p>
											</div>
										</div>
									</li>
								</ul>
							</div>
			                <h3>Locate a Branch</h3>
			                <p>Locate a specific branch in a map.</p>
			                <a class="bannerButton" href="javascript:void(0);" onclick="location.href='locateBranches.php'">Locate</a>
			            </div>
					</div>
				</div> <!-- end of slideshowSection -->
			</div>
			<!-- end of slideshowContainer -->
			<div class="footer">
				<?php include('footerFlat.php'); ?>
			</div>
			<!-- end of footerContainer -->
		</center>
	</body>
</html>