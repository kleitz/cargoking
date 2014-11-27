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

  if($_POST['submit']) {
    $stationName     = mysqli_real_escape_string($conn, $_REQUEST['stationName']);
    $stationCode     = mysqli_real_escape_string($conn, $_REQUEST['stationCode']);
    $stationAddress  = mysqli_real_escape_string($conn, $_REQUEST['stationAddress']);
    $stationRemarks  = mysqli_real_escape_string($conn, $_REQUEST['stationRemarks']);

    $SQLInsert  = " insert into area_location (area_name, area_code, address, remarks, created_by, creation_date, last_modified_by, last_modified_date) ";
    $SQLInsert .= " values ('" . $stationName . "', '" . $stationCode . "', '" . $stationAddress . "', '" . $stationRemarks . "','" . $login_id . "', now(), '" . $login_id . "', now())";
    $successInsertion = mysqli_query($conn,  $SQLInsert );

    if( $successInsertion ) {
      echo "<script type=\"text/javascript\">";
      echo "  self.location='stations_list.php?action=add&success=true';";
      echo "</script>";
    }
    else {
      $errorNo  = mysqli_errno($conn);
      $errorMsg = mysqli_error($conn);
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
    <title>Cargo King: Add Station</title>
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

        $("#formStation").validate({
          rules: {
            stationName: {
              required:true,
              remote: {
                url: "checkStationName.php",
                type: "post",
                data: {
                  station_name: function() {
                    return $("#txtStationName").val();
                  }
                }
              }
            },
            stationCode: {
              required: true
            }
          },

          messages: {
            stationName: {
              required: "Please fill station name.",
              remote: "Station name already exists. Please try another one."
            },
            stationCode: {
              required: "Please enter station code."
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
        <div align="center" class="title">Add Station</div>

        <!-- Status Messages -->      
        <div id="div_status" align="left">
          <ul />
        </div>

        <!-- Table Data Container -->
        <div align="center">
          <div>
            <!-- START: My Profile: User Access form fields -->
            <form id="formStation" name="formStation" action="" method="post">           
                <div class="formContainer">
                  <p>
                    <span class="required">*</span>
                    <label for="txtStationName" class="fieldLabel">Station Name:</label>
                    <input type="text" id="txtStationName" name="stationName" value="" class="profileField" />
                  </p>
                  <p>
                    <span class="required">*</span>
                    <label for="txtStationCode" class="fieldLabel">Code:</label>
                    <input type="text" id="txtStationCode" name="stationCode" value="" class="profileField" />
                  </p>
                  <p>
                    <span class="not-required">&nbsp;</span>
                    <label for="txtStationAddress" class="fieldLabel remarksLabel">Address:</label>
                    <textarea id="txtStationAddress" name="stationAddress" cols="100" rows="3" class="profileAddress" resizable="false"></textarea>
                  </p>
                  <p>
                    <span class="not-required">&nbsp;</span>
                    <label for="txtStationRemarks" class="fieldLabel remarksLabel">Remarks:</label>
                    <textarea id="txtStationRemarks" name="stationRemarks" cols="100" rows="3" class="profileAddress" resizable="false"></textarea>
                  </p>
                </div>

                <p align="right" style="margin-right: -10px;">
                  <input type="submit" id="btnAddStation" name="submit" value="Add Station" class="button" />
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