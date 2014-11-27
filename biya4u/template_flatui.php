<?php 
  include('protect.php');
  include 'dbconnect.php'; 
  include('paging.class.php');
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
    <script src="js/jquery.bpopup.min.js"></script>
    <script src="js/menu.js"></script>

    <script type="text/javascript">

      var SCROLL_TOP_LIMIT = 124;

    	$(document).ready(function(){

        $("#menuContainerDiv").wrap("<div class=\"menuPlaceholder\"></div>");
        $(".menuPlaceholder").height($("#menuContainerDiv").outerHeight());

        $("#tblModeOfPaymentList tr:odd").css("background-color", "#FFFFFF");  /* #EBEBE0 */
        $("#tblModeOfPaymentList tr:even").css("background-color", "#FFE6E6");
    	});

      $(document).scroll( function(evt) {
        showFloatingMenu(SCROLL_TOP_LIMIT);
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
    <div class="containers menu" align="left" style="border-bottom: 5px solid #FF5151;">
      <?php include('menu_flat.php'); ?>
    </div>

    <!-- Contents -->
    <div class="containers contents">
      <div style="width: 550px; padding: 10px;">

        <!-- Status Messages -->      
        <div id="divStatus" align="center" class="title">
          <div id="divStatusMessage"></div>
        </div>

        <!-- Title -->      
        <div align="center" class="title">TITLE HERE</div>

        <!-- Paging -->
        <div>
          <div class="contents" style="float: left;">
            1&nbsp;Results Found
          </div>
          <div class="contents" style="float: right;">
            1
          </div>
        </div>

        <!-- Table Data Container -->
        <div class="clear" align="center">
          <div>

            <!-- START: Data Table -->
            YOUR DATA TABLE HERE
            <!-- END: Data Table -->

          </div>

          <br />
          <!-- START: Add Button -->
          <p align="right">
            <a id="lnkButton" href="javascript:void(0)" onclick="location.href='index.php'" class="flatButton">BUTTON NAME</a>
          </p>
          <!-- END: Add Button -->
          <br />

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
