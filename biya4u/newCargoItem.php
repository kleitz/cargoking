<?php 
  include('protect.php');
  include('dbconnect.php');
  include('utilities.php');

  session_start();

  $branchId = $_SESSION['satellite_office_id'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Cargo King: New HAWB</title>
    <link href="css/style.css" type="text/css" rel="stylesheet"/>
    <link href="css/styleMenu.css" rel="stylesheet" media="screen">
    <link href="css/blitzer/jquery-ui-1.10.4.custom.css" rel="stylesheet">

    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/jquery.bpopup.min.js"></script>
    <script src="js/menu.js"></script>

    <script type="text/javascript">
      $(document).ready(function(){
        $("#div_status").hide();
      });
    </script>
</head>

<body>
  <center>

    <!-- Header -->
    <div class="headerContainers" align="left">
      <?php include('header_flat.php'); ?>
    </div>

    <!-- Menu -->
    <div id="menuContainerDiv" class="containers menu" align="left" style="border-bottom: 5px solid #FF5151;">
      <?php include('menu_flat.php'); ?>
    </div>

    <!-- Contents -->
    <div class="containers contents">
      <div class="contentContainer">

        <!-- Title -->      
        <div align="center" class="title">New House Airway Bill (HAWB)</div>

        <!-- Status Messages -->      
        <div id="div_status" align="left">
          <ul />
        </div>

        <!-- Table Data Container -->
        <div align="center">
          <div>

            <!-- START: My Profile: User Access form fields -->
            <form id="formEditProfile" name="formEditProfile" action="update_profile_action.php" method="post">
                <input type="hidden" id="hndUserProfileId" name="userProfileId" value="<?php echo $userId; ?>" />            
                <div class="formContainer">
                  <p>
                    <span class="required">*</span>
                    <label for="txtWeightCategory" class="fieldLabel">Date:</label>
                    <input type="text" id="txtWeightCategory" name="weightCategory" value="" class="smallTextField" placeholder="MM-DD-YYYY" />
                  </p>
                  <p>
                    <span class="required">*</span>
                    <label for="txtWeightCategory" class="fieldLabel">Shipper Name:</label>
                    <input type="text" id="txtWeightCategory" name="weightCategory" value="" class="profileField" placeholder="Type shipper name to search" />
                  </p>
                  <p>
                    <span class="required">*</span>
                    <label for="txtWeightCategory" class="fieldLabel">Sender Name:</label>
                    <input type="text" id="txtWeightCategory" name="weightCategory" value="" class="profileField" placeholder="Sender name" />
                  </p>
                  <p>
                    <span class="required">*</span>
                    <label for="txtWeightCategory" class="fieldLabel">Address:</label>
                    <textarea id="txtProfileAddress" name="profileAddress" cols="100" rows="3" class="profileAddress" resizable="false"></textarea>
                  </p>
                  <p>
                    <span class="not-required">&nbsp;</span>
                    <label for="txtWeightCategory" class="fieldLabel">Contact Number:</label>
                    <input type="text" id="txtWeightCategory" name="weightCategory" value="" class="profileField" placeholder="Sender name" />
                  </p>
                  <p>
                    <span class="not-required">&nbsp;</span>
                    <label for="txtWeightCategory" class="fieldLabel">City:</label>
                    <input type="text" id="txtWeightCategory" name="weightCategory" value="" class="profileField" placeholder="Sender name" />
                  </p>
                  <p>
                    <span class="not-required">&nbsp;</span>
                    <label for="txtWeightCategory" class="fieldLabel">Identification No.:</label>
                    <input type="text" id="txtWeightCategory" name="weightCategory" value="" class="profileField" placeholder="Sender name" />
                  </p>

                  <p>
                    <span class="required">*</span>
                    <label for="selOrigin" class="fieldLabel">City of Origin:</label>
                    <select id="selOrigin" name="cityOfOrigin" class="dropboxField" style="width: 325px;" disabled="true">
                      <option value="-1">-- Select Origin --</option>
                      <option value="CEB" selected>Cebu</option>
                      <option value="DVO">Davao</option>
                      <option value="MNL">Manila</option>
                      <option value="ZAM">Zamboanga</option>
                    </select>
                  </p>
                  <p>
                    <span class="required">*</span>
                    <label for="txtWeightCategory" class="fieldLabel">Branch:</label>
                    <input type="text" id="txtWeightCategory" name="weightCategory" value="<?php echo getBranchNameById( $conn, $branchId ); ?>" class="profileField" placeholder="Sender name" />
                  </p>
                </div>
                  <p align="right" style="margin-right: 10px;">
                    <input type="submit" id="btnUpdateProfile" name="submit" value="Save Transaction" class="button" />
                  </p>
            </form>
          </div>

        </div>

      </div>
    </div>

    <!-- Footer -->
    <div class="container clear footerContainer">
      <?php include('footer_flat.php') ?>
    </div>
  </center>
</body>
</html>