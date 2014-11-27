<?php 
  include('protect.php');
  include('dbconnect.php'); 
  include('utilities.php');

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
    $area_name           = mysqli_real_escape_string($conn, $_REQUEST['area_name']);
    $deliveryArea        = mysqli_real_escape_string($conn, $_REQUEST['deliveryArea']);
    $satelliteOfficeName = mysqli_real_escape_string($conn, $_REQUEST['satelliteOfficeName']);
    $satelliteOfficeCode = mysqli_real_escape_string($conn, $_REQUEST['satelliteOfficeCode']);

    $SQLInsert  = " insert into delivery_area (area, station, delarea, station_hawb_prefix, created_by, creation_date, last_modified_by, last_modified_date) ";
    $SQLInsert .= " values ('" . $satelliteOfficeName . "', '" . $area_name . "', '" . $deliveryArea . "', '" . $satelliteOfficeCode . "', '" . $login_id . "', now(), '" . $login_id . "', now())";
    $successInsertion = mysqli_query($conn,  $SQLInsert );

    if( $successInsertion ) {
      echo "<script type=\"text/javascript\">";
      echo "  self.location='delivery_area_list.php?action=add&success=true';";
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
    <title>Cargo King: Add Satellite Office</title>
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
      #sel_area_name, #selDeliveryArea {
        height: 32px;
        width: 323px;
      }
    </style>

    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/menu.js"></script>

    <script type="text/javascript">

      $(document).ready(function(){

        $("#div_status").hide();

        $("#formStatusTypes").validate({
          rules: {
            area_name: {
              required:true
            },
            deliveryArea: {
              required: true
            },
            satelliteOfficeName: {
              required:true,
              remote: {
                url: "check_SatelliteOffice.php",
                type: "post",
                data: {
                  so_name: function() {
                    return $("#txtSatelliteOfficeName").val();
                  }
                }
              }
            }
          },

          messages: {
            area_name: {
              required: "Please select a station."
            },
            deliveryArea: {
              required: "Please select delivery area."
            },
            satelliteOfficeName: {
              required: "Please enter satellite office name.",
              remote: "Satellite office name already exists. Please try another one."
            }
          },

          errorContainer: $('#div_status'),
          errorLabelContainer: $('#div_status ul'),
          wrapper: 'li'
        });

        //START: Disabled station dropdown if non-administrator since they have StationId values, then use their station id as the base station
        <?php 
          if($type_code != ADMIN){
        ?>
          $("#sel_area_name").val("<?php echo $stationId; ?>");
          $("#sel_area_name").attr("disabled", "disabled");
        <?php
          }
        ?>
        //END
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
        <div align="center" class="title">Add Satellite Office</div>

        <!-- Status Messages -->      
        <div id="div_status" align="left">
          <ul />
        </div>

        <!-- Table Data Container -->
        <div align="center">
          <div>
            <!-- START: form fields -->
            <form id="formStatusTypes" name="formStatusTypes" action="" method="post">           
                <div class="formContainer">
                  <p>
                    <span class="required">*</span>
                    <label for="sel_area_name" class="fieldLabel">Station:</label>
                    <?php generateDropdownObject($conn, "area_location", "area_name", "profileField"); ?>
                  </p>
                  <p>
                    <span class="required">*</span>
                    <label for="selDeliveryArea" class="fieldLabel">Delivery Area:</label>
                    <select id="selDeliveryArea" name="deliveryArea" class="profileField">
                      <option value="1">Within City</option>
                      <option value="2">Outside City</option>
                      <option value="3">Excess Baggage Port-Port</option>
                      <option value="4">Excess Baggage Door-Door</option>
                    </select>
                  </p>
                  <p>
                    <span class="required">*</span>
                    <label for="txtSatelliteOfficeName" class="fieldLabel">Satellite Office Name:</label>
                    <input type="text" id="txtSatelliteOfficeName" name="satelliteOfficeName" value="" class="profileField" />
                  </p>
                  <p>
                    <span class="not-required">&nbsp;</span>
                    <label for="txtSatelliteOfficeCode" class="fieldLabel">Code:</label>
                    <input type="text" id="txtSatelliteOfficeCode" name="satelliteOfficeCode" value="" class="profileField" />
                  </p>
                </div>

                <p align="right" style="margin-right: -10px;">
                  <input type="submit" id="btnAddSatelliteOffice" name="submit" value="Add Satellite Office" class="button" />
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