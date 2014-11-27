<?php 
  include('protect.php');
  include('dbconnect.php');

  session_start();
  $login_id = 1; //default to admin id
  if( isset($_SESSION['login_id']) ) $login_id = $_SESSION['login_id'];
  
  //add codes for adding new weight category
  if($_POST['submit']) {
    $weightValue     = mysqli_real_escape_string($conn, $_REQUEST['weightCategory']);
    $deliveryArea    = mysqli_real_escape_string($conn, $_REQUEST['deliveryArea']);
    $amountTotal     = mysqli_real_escape_string($conn, $_REQUEST['grandTotal']);
    $hasVat          = mysqli_real_escape_string($conn, $_REQUEST['hasVAT']);
    $freightCharge   = mysqli_real_escape_string($conn, $_REQUEST['freightCharge']);
    $vat             = mysqli_real_escape_string($conn, $_REQUEST['vat']);
    $commission      = mysqli_real_escape_string($conn, $_REQUEST['commission']);
    $amountDueToCK   = mysqli_real_escape_string($conn, $_REQUEST['dueToCargoking']);

    $weightValue = $weightValue == "" ? 0 : floatval(str_replace(",", "", $weightValue));
    $freightCharge = $freightCharge == "" ? 0 : floatval(str_replace(",", "", $freightCharge));
    $vat = $vat == "" ? 0 : floatval(str_replace(",", "", $vat));
    $amountTotal = $amountTotal == "" ? 0 : floatval(str_replace(",", "", $amountTotal));
    $commission = $commission == "" ? 0 : floatval(str_replace(",", "", $commission));
    $amountDueToCK = $amountDueToCK == "" ? 0 : floatval(str_replace(",", "", $amountDueToCK));

    $sqlInsert  = " insert into weight_category(weightvalue, delarea, fcharge, vat, rate, commission, duecar, created_by, creation_date, last_modified_by, last_modified_date) values ('$weightValue', '$deliveryArea', '$freightCharge', '$vat', '$amountTotal', '$commission', '$amountDueToCK', '$login_id', now(), '$login_id', now())";
    
    //echo "[SQL]: " . $sqlInsert . "<br>";

    $successInsertion = mysqli_query($conn,  $sqlInsert );

    if( $successInsertion ) {
      header('Location: weight_breaks_list.php?action=add&success=true');
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
    <title>Cargo King: Add Weight Category</title>
    <link href="css/style.css" type="text/css" rel="stylesheet"/>
    <link href="css/styleMenu.css" rel="stylesheet" media="screen">
    <link href="css/blitzer/jquery-ui-1.10.4.custom.css" rel="stylesheet">
    <link href="css/flat/red.css" rel="stylesheet" media="screen">

    <style>
      span#spanTax {
        display:inline-block;
        height: 30px;
        padding-top: 10px;
        padding-bottom: 0px;
        margin-left: 25px;
      }
      span#spanTax > label {
        font-family: 'OpenSanRegular';
        font-size: 12px;
      }
    </style>

    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/jquery.bpopup.min.js"></script>
    <script src="js/menu.js"></script>
    <script src="js/icheck.min.js"></script>

    <script type="text/javascript">

    var WITH_VAT = "withVAT";
    var WITHOUT_VAT = "withoutVAT";

      $(document).ready(function(){

        $("#div_status").hide();

        $("input[type=radio]").iCheck({ radioClass: 'iradio_flat-red' });
        $("input[type=radio]").on("ifChecked", function(e){
          generateVAT();
          //showHidePercentageField( $(this).is(":checked") )
        });
        
        //Set without VAT as default.
        $("#optVatNo").iCheck("check");

        $("#formAddWeightCategory").validate({
          rules: {
            weightCategory: {
              required:true,
              minlength:1,
              maxlength:4,
              number:true
            },
            grandTotal: {
              required:true,
              number:true
            },
            commission: {
              required:true,
              number:true
            }       
          },
          messages: {
            weightCategory: {
              required: "Please enter weight value.",
              minlength: "Please enter atleast one digit value.",
              maxlength: "Please enter a value with 4 digits atmost.",
              number: "Please enter a valid weight value."
            },
            grandTotal: {
              required:"Please enter a rate.",
              number: "Please enter a valid rate."
            },
            commission: {
              required: "Please enter a commission.",
              number: "Please enter a valid commission."
            }
          },
          errorContainer: $('#div_status'),
          errorLabelContainer: $('#div_status ul'),
          wrapper: 'li'
        });

      });

      var calculateDueToCK = function() {
        var freight = $("#txtFreightCharge").val();
        var vat = $("#txtVAT").val();
        var commission = $("#txtCommission").val();
        var rate = $("#txtGrandTotal").val();
        
        freight    = !isNaN(freight)    ? Number(freight)    : 0;
        vat        = !isNaN(vat)        ? Number(vat)        : 0;
        commission = !isNaN(commission) ? Number(commission) : 0;
        rate       = !isNaN(rate)       ? Number(rate)       : 0;

        if("" != $("#txtCommission").val()){
          var dueToCK = rate - commission
          $("#txtDueToCK").val(dueToCK);
        }
      };

      var generateVAT = function() {
        var rate = $("#txtGrandTotal").val();
        var has_vat = $("input[name=hasVAT]:checked").val();
        if(has_vat == WITH_VAT){
          if(rate.trim() != ""){

            console.log("[rate]: " + rate);
            console.log("[has_vat]: " + has_vat);

            getFreightChargeAndVAT(rate, has_vat);
          }
        }
        else {

          $(".withTaxField").hide();
          $("#txtFreightCharge").val("");
          $("#txtVAT").val("");
        }

      };

      var getFreightChargeAndVAT = function(rate, has_vat) {
        //var rate = $("#txtGrandTotal").val();
        //var has_vat = $("input[name=hasVAT]:checked").val();
        $.getJSON("computeVAT.php",{ rate: rate, has_vat: has_vat}, function(data){
          $.each(data, function(key, val){
            if(key == "freightCharge") $("#txtFreightCharge").val(val);
            if(key == "vat") $("#txtVAT").val(val);
            //console.log("[" + key + "]: " + val);
          });
          //TODO: Parse JSON result and display to Freight Charge and VAT fields
          $(".withTaxField").show();
        });
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
        <div align="center" class="title">Add Weight Category</div>

        <!-- Status Messages -->      
        <div id="div_status" align="left">
          <ul />
        </div>

        <!-- Table Data Container -->
        <div align="center">
          <div>


            <!-- START: My Profile: User Access form fields -->
            <form id="formAddWeightCategory" name="formAddWeightCategory" action="" method="post">           
                <div class="formContainer">
                  <p>
                    <span class="required">*</span>
                    <label for="txtWeightCategory" class="fieldLabel">Weight Value:</label>
                    <input type="text" id="txtWeightCategory" name="weightCategory" value="" class="smallTextField" placeholder="kilograms" />
                    <span class="postLabel">KG</span>
                  </p>
                  <p>
                    <span class="required">*</span>
                    <label for="selDeliveryArea" class="fieldLabel">Delivery Area:</label>
                    <select id="selDeliveryArea" name="deliveryArea" class="dropboxField">
                      <option value="-1">-- Select delivery area --</option>
                      <option value="1">Within City</option>
                      <option value="2">Outside City</option>
                      <option value="3">Excess Baggage Port-Port</option>
                      <option value="4">Excess Baggage Door-Door</option>
                    </select>

                    <!--
                    <input type="text" id="txtProfileLastName" name="profileLastName" value="" class="smallTextField" />
                    -->
                  </p>
                  <p>
                    <span class="required">*</span>
                    <label for="txtGrandTotal" class="fieldLabel">Grand Total:</label>
                    <input type="text" id="txtGrandTotal" name="grandTotal" value="" class="smallTextField" placeholder="[Php]" onblur="generateVAT();" />
                    <span id="spanTax">
                      <input type="radio" id="optVatYes" name="hasVAT" value="withVAT" />
                      <label for="optVatYes">With VAT</label>
                      <input type="radio" id="optVatNo" name="hasVAT" value="withoutVAT" />
                      <label for="optVatNo">Without VAT</label>
                    </span>
                  </p>
                  <p class="withTaxField">
                    <span class="not-required">&nbsp;</span>
                    <label for="txtFreightCharge" class="fieldLabel">Freight Charge:</label>
                    <input type="text" id="txtFreightCharge" name="freightCharge" value="" class="smallTextField" />
                  </p>
                  <p class="withTaxField">
                    <span class="not-required">&nbsp;</span>
                    <label for="txtVAT" class="fieldLabel">VAT 12%:</label>
                    <input type="text" id="txtVAT" name="vat" value="" class="smallTextField" />
                  </p>
                  <p>
                    <span class="required">*</span>
                    <label for="txtCommission" class="fieldLabel">Commission:</label>
                    <input type="text" id="txtCommission" name="commission" value="" class="smallTextField" />
                  </p>
                  <p>
                    <span class="required">*</span>
                    <label for="txtDueToCargoking" class="fieldLabel">Due to Cargo King:</label>
                    <input type="text" id="txtDueToCargoking" name="dueToCargoking" value="" class="smallTextField" />
                  </p>
                </div>

                <p align="right" style="margin-right: -10px;">
                  <input type="submit" id="btnAddWeightCategory" name="submit" value="Add weight category" class="button" />
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