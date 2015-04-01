<style>
	.warningImage {
		width: 32px;
		height: 32px;
		margin-right: 15px;
	}
</style>

<div class="cssmenu menuAlignToSearchBox">
	<ul>
		<li><a href='index.php'><span>Home</span></a></li>
		<li><a href='aboutCargoKing.php'><span>About Cargo King</span></a></li>
		<li><a href='branches.php'><span>Satellite Outlets</span></a></li>
		<li><a href='contactUs.php'><span>Contact Us</span></a></li>
	</ul>
</div>
<div class="searchCargoContainer">
	<input type="text" id="txtSearchCargo" maxlength="25" class="searchCargoBox" placeholder="Search Cargo" title="Enter HAWB ID to search (example: CK-ABC-DFEHIJ-1234)" onkeydown="searchCargoItemByEnterKey(this.value, event);" />
	<a href="javascript:void(0);" onclick="searchCargoItem($('#txtSearchCargo').val());" class="search-button"><img src="images/search-icon.png" /></a>
</div>
<div class="loginContainer">
	<div id="loginMenu">
		<span>LOGIN</span>
	</div>
	<div id="loginForm" class="loginFormContainer">
		<!--
		<span class="errorMessage">Invalid Username/Password!</span>
		-->
		<form action="biya4u/submit_login.php" method="post" name="login-form-data">
			<div>
				<div class="usernameIcon"></div>
				<input type="text" id="txtUsername" name="loginUserName" placeholder="Username" required class="logintextField" />
			</div>
			<div>
				<div class="passwordIcon"></div>
				<input type="password" id="txtLoginPassword" name="loginPassword" placeholder="Password" class="logintextField" />
			</div>
			<div>
				<!--
				<div class="checkIcon"></div>
				<input type="text" id="txtLoginVerificationCode" name="loginVerificationCode" placeholder="Verification Code" required class="logintextField" />
				-->
				<div class="forgotPassword"><a href="#">Forgot your password?</a></div>
			</div>

			<?php
			/*
			<div class="capchaContainer">
				<img src="biya4u/securimage_show.php?sid=<?php echo md5(uniqid(time())); ?>" />
			</div>
			*/
			?>

				<input type="submit" value="Login" class="buttonLogin" />
			<!--	
			<div>
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
			</div>
			-->
		</form>
	</div>
</div>
<!-- START: Search Result Pop-up -->
<div id="divDialog" class="dialogStyle">
  <img id="imgClose" src="biya4u/images/flat_icons/close_32.png" class="closeImage" onclick="closeDialog();" title="Close search result pop-up." />
  <hr class="popupLineTop">
  <div class="searchInfo">
    <p>
      <span class="searchLabel">Sender Name:</span>
      <span class="searchValue" id="spnSenderName">Juan Dela Cruz</span>  
    </p>
    <p>
      <span class="searchLabel">Recipient Name:</span>
      <span class="searchValue" id="spnReceiverName">Rosana Bin Laden</span>  
    </p>
    <p>
      <span class="searchLabel">Delivery Address:</span>
      <span class="searchValue" id="spnReceiverAddress">#123 Dimakita Street, Nawawala Subdivision, Dimahanap City 12345</span>  
    </p>
    <p>
      <span class="searchLabel">Recipient Contact Number:</span>
      <span class="searchValue" id="spnReceiverContactNo">(082) 305-2123</span>  
    </p>
    <p>
      <span class="searchLabel">Cargo Item Status:</span>
      <span class="searchValue" id="spnCargoStatus">For Delivery</span>  
    </p>
    <p>
      <span class="searchLabel">Cargo Last Location:</span>
      <span class="searchValue" id="spnCargoLocation">Dimahanap City Cargo</span>  
    </p>
    <p>
      <span class="searchLabel">Last Update By:</span>
      <span class="searchValue" id="spnCargoUser">Borgy Manotoy</span>  
    </p>
  </div>
  <hr class="popupLineBottom">
</div>

<!-- END: Search Result Pop-up -->
<div id="divErrorLogin" class="errorDialog" onclick="closeErrorDialog();">
	<div style="padding: 10px; text-align: left">
		<div style="float:left;">
			<img src="biya4u/images/flat_icons/warning_32x32.png" class="warningImage" alt="Warning">
		</div>
		<div id="spanErrorMsg" valign="middle"></div>
	</div>
</div>