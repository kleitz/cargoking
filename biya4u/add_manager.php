<?php 
  include('protect.php');
  include('dbconnect.php'); 
  include('utilities.php');
  include('constants.php');

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
    $area_name = mysqli_real_escape_string($conn, $_REQUEST['area_name']);
    $firstName = mysqli_real_escape_string($conn, $_REQUEST['firstName']);
    $lastName = mysqli_real_escape_string($conn, $_REQUEST['lastName']);
    $middleName = mysqli_real_escape_string($conn, $_REQUEST['middleName']);
    $code = mysqli_real_escape_string($conn, $_REQUEST['code']);
    $phoneNumber = mysqli_real_escape_string($conn, $_REQUEST['phoneNumber']);
    $emailAddress = mysqli_real_escape_string($conn, $_REQUEST['emailAddress']);
    $username = mysqli_real_escape_string($conn, $_REQUEST['username']);
    $password = mysqli_real_escape_string($conn, $_REQUEST['password']);
    $identificationType  = mysqli_real_escape_string($conn, $_REQUEST['identificationType']);
    $identificationNumber    = mysqli_real_escape_string($conn, $_REQUEST['identificationNumber']);

    $SQLInsert  = " insert into users (user_type_id, code, identification_type, identification_no, firstname, lastname, middlename, station_id, phone, email, username, password, created_by, creation_date, last_modified_by, last_modified_date) ";
    $SQLInsert .= " values (" . MANAGER_ID . ", '" . $code . "', '" . $identificationType . "', '" . $identificationNumber . "', '" . $firstName . "', '" . $lastName . "', '" . $middleName . "', '" . $area_name . "', '" . $phoneNumber . "', '" . $emailAddress . "', '" . $username . "', '" . $password . "', '" . $login_id . "', now(), '" . $login_id . "', now())";
    $successInsertion = mysqli_query($conn,  $SQLInsert );

    if( $successInsertion ) {
      echo "<script type=\"text/javascript\">";
      echo "  self.location='manager_list.php?action=add&success=true';";
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
    <title>Cargo King: Add Station Manager</title>
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
      #sel_area_name, #selIdentificationType {
        height: 32px;
        width: 323px;
      }
    </style>

    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/icheck.min.js"></script>
    <script src="js/menu.js"></script>

    <script type="text/javascript">
      $.validator.addMethod('customphone', function (value, element) {
        return this.optional(element) || /^\(*\d{1,4}\)*\s*\d{3}\s*-*\s*\d{4}$/.test(value);
      }, "Please enter a valid phone number");

      $(document).ready(function(){
        $("#div_status").hide();

        $("#chkHasIdentification").iCheck({ checkboxClass: 'icheckbox_flat-red' });

        $("#frmStationAdmin").validate({
          rules: {
            area_name: {
              required:true
            },
            firstName: {
              required:true,
              remote: {
                url: "check_Fullname.php",
                type: "post",
                data: {
                  first_name: function() {
                    return $("#txtFirstName").val();
                  },
                  last_name: function() {
                    return $("#txtLastName").val();
                  },
                }
              }
            },
            lastName: {
              required:true,
              remote: {
                url: "check_Fullname.php",
                type: "post",
                data: {
                  first_name: function() {
                    return $("#txtFirstName").val();
                  },
                  last_name: function() {
                    return $("#txtLastName").val();
                  },
                }
              }
            },
            phoneNumber: 'customphone',
            emailAddress: {
              required: true,
              email:true
            },
            username: {
              required: true,
              remote: {
                url: "check_Username.php",
                type: "post",
                data: {
                  username: function() {
                    return $("#txtUsername").val();
                  }
                }
              }
            },
            password: {
              required: true,
              maxlength:25,
              minlength:4
            },
            confirmPassword: {
              required: true,
              equalTo: "#txtPassword",
              maxlength:25,
              minlength:4
            }
          },

          messages: {
            area_name: {
              required: "Please select a station."
            },
            firstName: {
              required: "Please enter first name.",
              remote: "Firstname already exists. Please try another one."
            },
            lastName: {
              required: "Please enter last name.",
              remote: "Lastname already exists. Please try another one."
            },
            emailAddress: {
              required: "Please enter email address",
              email: "Please enter a valid email address"
            },
            username: {
              required: "Please enter username.",
              remote: "Username already exists. Please try another one."
            },
            password: {
              required:  "Please enter password.",
              maxlength: "Please enter a password of no more than 25 characters.",
              minlength: "Please enter a password of atleast 4 characters."
            },
            confirmPassword: {
              required:  "Please retype the password.",
              equalTo:   "Password and confirmed passwords are not the same, please try again.",
              maxlength: "Please confirm the password with no more than 25 characters.",
              minlength: "Please confirm the password with atleast 4 characters."
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

        $("#selIdentificationType, #txtIdentificationNumber").bind("change", showHideIdentifactionInfo());
        $("#chkHasIdentification").on("ifChanged", function(){
          hasIdentificationDocument($(this).is(":checked"));
        });
      });

      var showHideIdentifactionInfo = function(){
        var idType = $("#selIdentificationType").val();
        var idNo = $("#txtIdentificationNumber").val();

        if( "-1" == $.trim(idType) && "" == $.trim(idNo) ){
          $("#chkHasIdentification").iCheck("uncheck");
          $("#parIdType, #parIdNo").hide();
        }
        else {
          $("#chkHasIdentification").iCheck("check");
          $("#parIdType, #parIdNo").show();
        }
      };

      var hasIdentificationDocument = function(hasDocument){
          if(hasDocument){
            $("#parIdType, #parIdNo").show();
          }
          else {
            $("#parIdType, #parIdNo").hide();
          }
      };
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
        <div align="center" class="title">Add Station Manager</div>

        <!-- Status Messages -->      
        <div id="div_status" align="left">
          <ul />
        </div>

        <!-- Table Data Container -->
        <div align="center">
          <div>
            <!-- START: form fields -->
            <form id="frmStationAdmin" name="frmStationAdmin" action="" method="post">           
                <div class="profileContainer">
                  <p>
                    <span class="required">*</span>
                    <label for="sel_area_name" class="fieldLabel">Station:</label>
                    <?php generateDropdownObject($conn, "area_location", "area_name", "profileField"); ?>
                  </p>
                  <p>
                    <span class="required">*</span>
                    <label for="txtFirstName" class="fieldLabel">Firstname:</label>
                    <input type="text" id="txtFirstName" name="firstName" value="" class="profileField" />
                  </p>
                  <p>
                    <span class="required">*</span>
                    <label for="txtLastName" class="fieldLabel">Lastname:</label>
                    <input type="text" id="txtLastName" name="lastName" value="" class="profileField" />
                  </p>
                  <p>
                    <span class="not-required">&nbsp;</span>
                    <label for="txtMiddleName" class="fieldLabel">Middlename:</label>
                    <input type="text" id="txtMiddleName" name="middleName" value="" class="profileField" />
                  </p>
                  <p>
                    <span class="not-required">&nbsp;</span>
                    <label for="txtCode" class="fieldLabel">Code:</label>
                    <input type="text" id="txtCode" name="code" value="" class="profileField" />
                  </p>
                  <p>
                    <span class="not-required">&nbsp;</span>
                    <label for="txtPhoneNumber" class="fieldLabel">Contact Number:</label>
                    <input type="text" id="txtPhoneNumber" name="phoneNumber" value="" class="profileField" />
                  </p>
                  <p>
                    <span class="required">*</span>
                    <label for="txtEmailAddress" class="fieldLabel">Email Address:</label>
                    <input type="text" id="txtEmailAddress" name="emailAddress" value="" class="profileField" />
                  </p>
                </div>

                <div class="userAccessContainer">
                  <p>
                    <span class="required">*</span>
                    <label for="txtUsername" class="fieldLabel">Username:</label>
                    <input type="text" id="txtUsername" name="username" value="" class="profileField" />
                  </p>
                  <p>
                    <span class="required">*</span>
                    <label for="txtPassword" class="fieldLabel">Password:</label>
                    <input type="password" id="txtPassword" name="password" value="" class="profileField" />
                  </p>
                  <p>
                    <span class="required">*</span>
                    <label for="txtConfirmPassword" class="fieldLabel">Confirm Password:</label>
                    <input type="password" id="txtConfirmPassword" name="confirmPassword" value="" class="profileField" />
                  </p>
                </div>

                <div class="userAccessContainer">
                  <p align="left" style="margin-left: 40px; margin-top: 5px; margin-bottom: 5px;">
                    <input type="checkbox" id="chkHasIdentification" name="hasIdentification" value="withID" />
                    <label for="chkHasIdentification" class="fieldLabel" style="width: 250px; margin-left: 15px;">Identification Document</label>
                  </p>
                  <p id="parIdType" style="margin-top: 20px;">
                    <span class="not-required">&nbsp;</span>
                    <label for="selIdentificationType" class="fieldLabel">Identification Type:</label>
                    <select id="selIdentificationType" name="identificationType" class="profileField" title="Optional field, provided identification card for verifying identity">
                      <option value="-1">--[Select]--</option>
                      <option value="1">Company ID</option>
                      <option value="2">PHILHEALTH ID</option>
                      <option value="3">Drivers License ID</option>
                      <option value="4">SSS ID</option>
                      <option value="5">GSIS ID</option>
                      <option value="6">Passport</option>
                      <option value="7">Others</option>
                    </select>
                  </p>
                  <p id="parIdNo">
                    <span class="not-required">&nbsp;</span>
                    <label for="txtIdentificationNumber" class="fieldLabel">Identification No.:</label>
                    <input type="text" id="txtIdentificationNumber" name="identificationNumber" value="" class="profileField" />
                  </p>
                </div>

                <p align="right" style="margin-right: 10px;">
                  <input type="submit" id="btnAddUser" name="submit" value="Add Station Manager" class="button" />
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