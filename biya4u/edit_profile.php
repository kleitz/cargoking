<?php 
  include('protect.php');
  include ('dbconnect.php');

  session_start();

  $userId = -1;
  if( isset($_SESSION['login_id']) ) $userId = $_SESSION['login_id'];

  $action = "";
  $success = "";
  $errorNo = "";
  $errorMsg = "";
  $isDebug = "";
  $updateSQL = "";
  if( isset($_REQUEST['action']) ) $action = $_REQUEST['action'];
  if( isset($_REQUEST['success']) ) $success = $_REQUEST['success'];
  if( isset($_REQUEST['errorNo']) ) $errorNo = $_REQUEST['errorNo'];
  if( isset($_REQUEST['errorMsg']) ) $errorMsg = $_REQUEST['errorMsg'];
  if( isset($_REQUEST['isDebug']) ) $isDebug = $_REQUEST['isDebug'];
  if( isset($_REQUEST['updateSQL']) ) $updateSQL = $_REQUEST['updateSQL'];

  $sqlUserProfile = " SELECT * FROM vw_loginusers WHERE id = " . $userId . " LIMIT 1";

  $results = mysqli_query( $conn, $sqlUserProfile );
  $recordCount = mysqli_num_rows($results);

  $id = -1;
  $fullName = "";
  $firstName = "";
  $lastName = "";
  $middleName = "";
  $address = "";
  $contactNumber = "";
  $emailAddress = "";
  $username = "";
  $password = "";

  if( $results ) {
    while ($row = mysqli_fetch_assoc($results)) {
      $id            = $row['id'];
      $fullName      = $row['name'];
      $firstName     = $row['firstname'];
      $lastName      = $row['lastname'];
      $middleName    = $row['middlename'];
      $address       = $row['address'];
      $contactNumber = $row['contact_number'];
      $emailAddress  = $row['email'];
      $username      = $row['username'];
      $password      = $row['password'];
    }
  }

  /* Get Session ID:
      echo "[SESSION-ID]: " . session_id()  . "<br/>";
  */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Admin</title>
    <link href="css/style.css" type="text/css" rel="stylesheet"/>
    <link href="css/styleMenu.css" rel="stylesheet" media="screen">
    <link href="css/blitzer/jquery-ui-1.10.4.custom.css" rel="stylesheet">

    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/jquery.bpopup.min.js"></script>
    <script src="js/menu.js"></script>

    <script type="text/javascript">
      var SCROLL_TOP_LIMIT = 124;

      var action = "<?php echo $action; ?>";
      var success = "<?php echo $success; ?>";
      var errorNo = "<?php echo $errorNo; ?>";
      var errorMsg = "<?php echo $errorMsg; ?>";
      var isDebug = "<?php echo $isDebug; ?>";
      var updateSQL = "<?php echo $updateSQL; ?>";

    	$(document).ready(function(){

        $("#menuContainerDiv").wrap("<div class=\"menuPlaceholder\"></div>");
        $(".menuPlaceholder").height($("#menuContainerDiv").outerHeight());

        $("#div_status").hide();

        $(document).scroll( function(evt) {
          showFloatingMenu(SCROLL_TOP_LIMIT);
        });

        if( action == "update" && success == "true"){
          var strErroSuccessItem;
          strErroSuccessItem  = "<li>\n";
          strErroSuccessItem += " <label class='success' style='display: inline;'>";
          strErroSuccessItem += " Profile successfully updated.";
          strErroSuccessItem += " </label>";
          strErroSuccessItem += "</li>\n";
          $("#div_status ul").append(strErroSuccessItem);
          $("#div_status").addClass("success").show();
        }
        else if( action == "update" && success == "false"){
          var strErrorItem;
          strErrorItem  = "<li>\n";
          strErrorItem += " <label class='error' style='display: inline;'>";
          strErrorItem += " Unable to update profile.";
          strErrorItem += " </label>";
          strErrorItem += "</li>\n";
          $("#div_status ul").append(strErrorItem);
          strErrorItem  = "<li>\n";
          strErrorItem += " <label class='error' style='display: inline;'>";
          strErrorItem += " Error (" + errorNo + "): <br/><br/>" + errorMsg;
          strErrorItem += " <br/></label>";
          strErrorItem += "</li>\n";
          $("#div_status ul").append(strErrorItem);

          $("#div_status").addClass("error").show();
        }

        $("#formEditProfile").validate({
          rules: {
            profileFirstName: { required:true },
            profileLastName: { required:true },
            profileMiddleName: { required:true },
            profileAddress: { required:true },
            profileContactNo: { required:true },
            //profileUsername: { required:true },
            profilePassword: { required:true },
            retypedProfilePassword: {
              required:true,
              equalTo: "#txtProfilePassword",
              maxlength:25,
              minlength:4
            }
          },

          messages: {
            profileFirstName: { required: "Please enter first name." },
            profileLastName: { required: "Please enter last name." },
            profileMiddleName: { required: "Please enter middle name." },
            profileAddress: { required: "Please enter address." },
            profileContactNo: { required: "Please enter contact number." },
            //profileUsername: { required: "Please enter username." },
            profilePassword: { required: "Please enter password." },
            retypedProfilePassword:
            {
              required: "Please Re-enter password.",
              equalTo:  "Please Re-Enter the Correct Password"
            }
          },

          errorContainer: $('#div_status'),
          errorLabelContainer: $('#div_status ul'),
          wrapper: 'li'
        });
    	});


    </script>
    <script type="text/JavaScript">
    <!--
    function MM_openBrWindow(theURL,winName,features) { //v2.0
      window.open(theURL,winName,features);
    }

    function deleteModeOfPayment(modeOfPaymentId) {
      var confirmDelete = false;
      if( confirmDelete = confirm("Are you sure you want to mode of payment?") ){
        location.href = "mode_rep.php?del_id=" + modeOfPaymentId;
      }
      return confirmDelete;
    }
    //-->
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
        <div align="center" class="title">Edit Profile</div>

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
                <div class="profileContainer">
                  <!--
                  <p>
                    <span class="profileLabel">Full Name:</span>
                    <input type="text" id="txtProfileFullName" name="profileFullName" value="<?php echo $fullName; ?>" class="profileField displayOnly" readonly="readonly" />
                  </p>
                  -->
                  <p>
                    <span class="profileLabel">First Name:</span>
                    <input type="text" id="txtProfileFirstName" name="profileFirstName" value="<?php echo $firstName; ?>" class="profileField" />
                  </p>
                  <p>
                    <span class="profileLabel">Last Name:</span>
                    <input type="text" id="txtProfileLastName" name="profileLastName" value="<?php echo $lastName; ?>" class="profileField" />
                  </p>
                  <p>
                    <span class="profileLabel">Middle Name:</span>
                    <input type="text" id="txtProfileMiddleName" name="profileMiddleName" value="<?php echo $middleName; ?>" class="profileField" />
                  </p>
                  <p>
                    <span class="profileLabel">Address:</span>
                    <textarea id="txtProfileAddress" name="profileAddress" cols="100" rows="3" class="profileAddress" resizable="false"><?php echo $address; ?></textarea>
                  </p>
                  <p>
                    <span class="profileLabel">Contact Number:</span>
                    <input type="text" id="txtContactNumber" name="contactNumber" value="<?php echo $contactNumber; ?>" class="profileField" />
                  </p>
                  <p>
                    <span class="profileLabel">Email Address:</span>
                    <input type="text" id="txtProfileEmail" name="profileEmail" value="<?php echo $emailAddress; ?>" class="profileField" />
                  </p>
                </div>

                <div class="userAccessContainer">
                  <p align="left">
                    <span class="userAccessLabel">Username:</span>
                    <input type="text" id="txtProfileUsername" name="profileUsername" value="<?php echo $username; ?>" class="profileField displayOnly" readonly="readonly" />
                  </p>
                  <p align="left">
                    <span class="userAccessLabel">Password:</span>
                    <input type="password" id="txtProfilePassword" name="profilePassword" value="<?php echo $password; ?>" class="passwordField" />
                  </p>
                  <p align="left">
                    <span class="userAccessLabel">Confirm Password:</span>
                    <input type="password" id="txtRetypedProfilePassword" name="retypedProfilePassword" value="<?php echo $password; ?>" class="passwordField" />
                  </p>
                </div>
            <!-- END: My Profile: User Access form fields -->

                <p align="right" style="margin-right: 10px;">
                  <input type="submit" id="btnUpdateProfile" name="submit" value="Update Profile" class="button" />
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