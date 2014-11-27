<?php 
  include('protect.php');
  include('dbconnect.php'); 

  session_start();
  $login_id  = "";
  $login     = "";
  $type_code = "";
  $stationId = "";
  if( isset($_SESSION['login_id']) )  $login_id  = $_SESSION['login_id'];
  if( isset($_SESSION['username']) )  $login     = $_SESSION['username'];
  if( isset($_SESSION['type_code']) ) $type_code = $_SESSION['type_code'];
  if( isset($_SESSION['stationId']) ) $stationId = $_SESSION['stationId'];

  if($_POST['submit']) {
    $serviceMode                  = mysqli_real_escape_string($conn, $_REQUEST['serviceMode']);
    $serviceModeRemarks           = mysqli_real_escape_string($conn, $_REQUEST['serviceModeRemarks']);

    $SQLInsert                      = " insert into service_mode (service_mode, remarks, created_by, creation_date, last_modified_by, last_modified_date) ";
    $SQLInsert                     .= " values ('" . $serviceMode . "', '" . $serviceModeRemarks . "', '" . $login_id . "', now(), '" . $login_id . "', now())";
    $successInsertion = mysqli_query($conn,  $SQLInsert );

    if( $successInsertion ) {
      echo "<script type=\"text/javascript\">";
      echo "  self.location='service_modes_list.php?action=add&success=true';";
      echo "</script>";
    }
    else {
      $errorNo  = mysqli_errno();
      $errorMsg = mysqli_error();
      header("HTTP/1.1 500 Internal Server Error");
      echo "<div class='errorContainer'>";
      echo "<span class='errorMessage'>Error Number: " . $errorNo . "</span><br />";
      echo "<span class='errorMessage'>Error: " . $errorMsg . "</span><br />";
      echo "</div>";
    }
   }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Cargo King: Add Service Mode </title>
    <link href="css/style.css" type="text/css" rel="stylesheet"/>
    <link href="css/styleMenu.css" rel="stylesheet" media="screen">
    <link href="css/blitzer/jquery-ui-1.10.4.custom.css" rel="stylesheet">
    <link href="css/flat/red.css" rel="stylesheet" media="screen">

    <style>
      .remarksLabel {
        vertical-align: top;
        display: inline-block;
        text-align: left;
        margin-top: 10px;
      }
    </style>

    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/menu.js"></script>

    <script type="text/javascript">

      $(document).ready(function(){

        $("#div_status").hide();

        $("#formMovementType").validate({
          rules: {
            serviceMode: {
              required:true,
              maxlength: 25,
              minlength: 3,
              remote: {
                url: "check_ServiceMode.php",
                type: "post",
                data: {
                  serviceMode: function() {
                    return $("#txtServiceMode").val();
                  }
                }
              }
            }
          },

          messages: {
            serviceMode: {
              required: "Please fill the required field.",
              maxlength: "The maximum length of service mode not exceed 15 characters.",
              minlength: "The minimum length of service mode should be 3 characters.",
              remote: "This kind of service mode already Exists. Please try another one."
            }
          },

          errorContainer: $('#div_status'),
          errorLabelContainer: $('#div_status ul'),
          wrapper: 'li'
        });

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
        <div align="center" class="title">Add Service Mode</div>

        <!-- Status Messages -->      
        <div id="div_status" align="left">
          <ul />
        </div>

        <!-- Table Data Container -->
        <div align="center">
          <div>
            <!-- START: My Profile: User Access form fields -->
            <form id="formMovementType" name="formMovementType" action="" method="post">           
                <div class="formContainer">
                  <p>
                    <span class="required">*</span>
                    <label for="txtServiceMode" class="fieldLabel">Service Mode:</label>
                    <input type="text" id="txtServiceMode" name="serviceMode" value="" class="profileField" />
                  </p>
                  <p>
                    <span class="not-required">&nbsp;</span>
                    <label for="txtServiceModeRemarks" class="fieldLabel remarksLabel">Remarks:</label>
                    <textarea id="txtServiceModeRemarks" name="serviceModeRemarks" cols="100" rows="3" class="profileAddress" resizable="false"></textarea>
                  </p>
                </div>

                <p align="right" style="margin-right: -10px;">
                  <input type="submit" id="btnServiceMode" name="submit" value="Add Service Mode" category" class="button" />
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