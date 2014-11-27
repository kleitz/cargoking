<?php 
  include('protect.php');
  include('dbconnect.php');
  include('utilities.php');
  include('paging.class.php');
  include('constants.php');

  $action = "";
  $success = "";
  if( isset($_REQUEST['action']) ) $action = $_REQUEST['action'];
  if( isset($_REQUEST['success']) ) $success = $_REQUEST['success'];

  if(isset($_REQUEST['del_id'])) {
    $del_id_net = $_REQUEST['del_id' ];
    $modpay_query = mysqli_query($conn, "select * from booking where payment_mode_id='$del_id_net'");
    $modpay_num = mysqli_num_rows($modpay_query);

    if($modpay_num>0) {
      echo "<script type=\"text/javascript\">";
      echo "  self.location='payment_modes_list.php?action=delete&success=false';";
      echo "</script>";
    }
    else {
      $del = mysqli_query($conn, "DELETE FROM payment_mode WHERE id='$del_id_net' ") or die (mysqli_error());
      echo "<script type=\"text/javascript\">self.location='payment_modes_list.php?action=delete&success=true';</script>";
    }
  }

  $total_results = (mysqli_query($conn, "SELECT COUNT(*) as Num FROM payment_mode ")); 
  	
  $row = mysqli_fetch_assoc($total_results);
  $totalCount = $row['Num'];

  if($totalCount == 0) {
    print "<script>";
    print "self.location='noresults.php';"; // Comment this line if you don't want to redirect
    print "</script>";
  }
  	
  $pager = new pager($_GET['p'], 15, $totalCount, 4);
  $offset = $pager->get_start_offset();
  $limit = 15;

  // Perform MySQL query on only the current page number's results 
  $result = mysqli_query($conn, "SELECT * FROM payment_mode  ORDER BY id asc LIMIT " . $offset . ", $limit ");
  $recordCount = mysqli_num_rows($result);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Cargo King: Payment Modes</title>
    <link href="css/style.css" type="text/css"  rel="stylesheet"/>
    <link href="css/styleMenu.css" rel="stylesheet" media="screen">
    <link href="css/blitzer/jquery-ui-1.10.4.custom.css" rel="stylesheet">

    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery-ui-1.10.4.custom.min.js"></script>
    <script src="js/menu.js"></script>
    <script type="text/javascript">
      var SCROLL_TOP_LIMIT = 124;
      function MM_openBrWindow(theURL,winName,features) { //v2.0
        window.open(theURL,winName,features);
      }
      var action = "<?php echo $action; ?>";
      var success = "<?php echo $success; ?>";
    	$(document).ready(function(){

        $("#tblModeOfPaymentList tr:odd").addClass("oddRow");
        $("#tblModeOfPaymentList tr:even").addClass("evenRow");

        if( action == "add" && success == "true"){
          $("#divStatus").show();
          $("#divStatusMessage").html("Successfully added payment mode.").addClass("success");
        }
         else if( action == "add" && success == "false"){
          $("#divStatus").show();
          $("#divStatusMessage").html("Unable to add payment mode.").addClass("error");
        }

        else if( action == "update" && success == "true"){
          $("#divStatus").show();
          $("#divStatusMessage").html("Successfully updated payment mode.").addClass("success");
        }
        else if( action == "delete" && success == "true"){
          $("#divStatus").show();
          $("#divStatusMessage").html("Successfully removed payment mode.").addClass("success");
        }
        else if( action == "delete" && success == "false"){
          $("#divStatus").show();
          $("#divStatusMessage").html("Cannot remove active payment mode.").addClass("error");
        }
        else {
          $("#divStatusMessage").removeClass("success").removeClass("error");
          $("#divStatus").hide();
        }        
    	});

      function deleteModeOfPayment(modeOfPaymentId) {
        var confirmDelete = false;
        if( confirmDelete = confirm("Are you sure you want to remove payment mode?") ){
          location.href = "payment_modes_list.php?del_id=" + modeOfPaymentId;
        }
        return confirmDelete;
      }
         $("#menuContainerDiv").wrap("<div class=\"menuPlaceholder\"></div>");
         $(".menuPlaceholder").height($("#menuContainerDiv").outerHeight());

         $(document).scroll( function(evt) {
            showFloatingMenu(SCROLL_TOP_LIMIT);  
        }); 
   </script>
</head>

<body>
  <center>
    
    <!-- Test php echoes
    <div class="containers">
      
    </div>
    -->

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
      <div style="width: 800px; padding: 10px;">

        <!-- Title -->
        <div align="center" class="title">Payment Modes</div>

         <!-- Status Messages -->      
        <div id="divStatus" align="center" class="title">
          <div id="divStatusMessage"></div>
        </div>

        <!-- Paging -->
        <div>
          <div class="contents" style="float: left;">
            <?php echo $totalCount; ?>&nbsp;Results Found
          </div>
          <div class="contents" style="float: right;">
            <?php echo $links = $pager->get_links(); ?>
          </div>
        </div>

        <!-- Table Data -->
        <div class="clear" align="center">
          <div>
            <table id="tblModeOfPaymentList" width="100%" border="0"  cellspacing="0" cellpadding="5" align="center" style="border:5px solid #bbbbbb; margin-bottom: 10px;">
              <tr>
                <th class="tableHeader" width="10%"><strong>ID</strong></th>
                <th class="tableHeader" width="30%"><div align="left"><strong>Mode of Payment</strong></div></th>
                <th class="tableHeader" width="50%"><div align="left"><strong>Remarks</strong></div></th>
                <th class="tableHeader" width="10%"><div align="left"><strong>Action</strong></div></th>
              </tr>
              <?php 
                if( $recordCount > 0 ){
                  while($fet_2=mysqli_fetch_array($result)) { 
              ?>  
              <tr>
                <td width="10%" class="data" align="center"><?php echo $fet_2['id']; ?></td>
                <td width="30%" class="data"><?php echo stripslashes($fet_2['payment_mode']); ?></td>
                <td width="50%" class="data"><?php echo stripslashes($fet_2['remarks']); ?></td>
                <td width="10%">
                  <a href="javascript:void(0);" class="actionButtons" onClick="MM_openBrWindow('mode_edit.php?ed=<?php echo  $fet_2['id']; ?> ','','scrollbars=yes,left=300,top=150,width=600,height=500')"><img src="images/flat_icons/pencil43.png" class="imageButtonFlat" alt="X" /></a>
                  <a href="javascript:void(0);" class="actionButtons" onclick="deleteModeOfPayment(<?php echo  $fet_2['id']; ?>)"><img src="images/flat_icons/delete30.png" class="imageButtonFlat" alt="X" /></a>
                </td>
              </tr>
                <?php
                    }
                  }
                  else {
                ?>
                  <tr><td colspan="4" align="center"><span class="dataNotFound">Data not found.</span></td></tr>
                <?php
                  }
                ?>
            </table>
          </div>

          <br/>
          <!-- START: Add Button -->
          <p align="right">
            <a id="lnkAddModeOfPayment" href="javascript:void(0)" onclick="location.href='add_mode_payment.php'" class="flatButton">Add Payment Mode</a>
          </p>
          <!-- END: Add Button -->
          <br/>

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
