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
    $area_name     = mysqli_real_escape_string($conn, $_REQUEST['area_name']);
    $modelYear    = mysqli_real_escape_string($conn, $_REQUEST['modelYear']);
    $plateNo      = mysqli_real_escape_string($conn, $_REQUEST['plateNo']);
    $cargoVehicleInfos = mysqli_real_escape_string($conn, $_REQUEST['cargoVehicleInfos']);

    $SQLInsert  = " insert into vec (station_id, model_year, plate_no, vehicle_infos, created_by, creation_date, last_modified_by, last_modified_date) ";
    $SQLInsert .= " values ('" . $area_name . "', '" . $modelYear . "', '" . $plateNo . "', '" . $cargoVehicleInfos . "', '" . $login_id . "', now(), '" . $login_id . "', now())";
    $successInsertion = mysqli_query($conn,  $SQLInsert );

    if( $successInsertion ) {
      echo "<script type=\"text/javascript\">";
      echo "  self.location='cargo_vehicles_list.php?action=add&success=true';";
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
    <title>Cargo King: Add Cargo Vehicle</title>
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
      #sel_area_name {
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
            modelYear: {
              required:true,
              remote: {
                url: "check_Vehicle.php",
                type: "post",
                data: {
                  plate_no: function() {
                    return $("#txtPlateNumber").val();
                  }
                }
              }
            },
            plateNo: {
              required:true
            }
          },

          messages: {
            area_name: {
              required: "Please select a Station."
            },
            modelYear: {
              required: "Please enter vehicle model and year.",
              remote: "Plate number already Exists. Please try another one."
            },
            plateNo: {
              required: "Please fill vehicle plate number"
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
        <div align="center" class="title">Add Cargo Vehicle</div>

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
                    <label for="sel_area_name" class="fieldLabel">Assigned Station:</label>
                    <?php generateDropdownObject($conn, "area_location", "area_name", "profileField"); ?>
                  </p>
                  <p>
                    <span class="required">*</span>
                    <label for="txtModelYear" class="fieldLabel">Model &amp; Year:</label>
                    <input type="text" id="txtModelYear" name="modelYear" value="" class="profileField" />
                  </p>
                  <p>
                    <span class="required">*</span>
                    <label for="txtPlateNumber" class="fieldLabel">Plate No.:</label>
                    <input type="text" id="txtPlateNumber" name="plateNo" value="" class="profileField" />
                  </p>
                  <p>
                    <span class="not-required">&nbsp;</span>
                    <label for="txtCargoVehicleInfos" class="fieldLabel remarksLabel">Vehicle Infos:</label>
                    <textarea id="txtCargoVehicleInfos" name="cargoVehicleInfos" cols="100" rows="3" class="profileAddress" resizable="false"></textarea>
                  </p>
                </div>

                <p align="right" style="margin-right: -10px;">
                  <input type="submit" id="btnAddCargoVehicle" name="submit" value="Add Cargo Vehicle" class="button" />
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