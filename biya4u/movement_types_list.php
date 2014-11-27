<?php 
  include('protect.php');
  include 'dbconnect.php'; 
  include('paging.class.php');

  $action = "";
  $success = "";
  if( isset($_REQUEST['action']) ) $action = $_REQUEST['action'];
  if( isset($_REQUEST['success']) ) $success = $_REQUEST['success'];

  if(isset($_REQUEST['del_id'])) {

    $del_id_net = $_REQUEST['del_id' ];
    $movement_type_query = mysqli_query($conn, "select * from booking where movement_type_id = '$del_id_net'");
    $movement_type_num = mysqli_num_rows($movement_type_query);
    
    if($movement_type_num > 0) {
      echo "<script type=\"text/javascript\">";
      echo "  self.location='movement_types_list.php?action=delete&success=false';";
      echo "</script>";  
    }
    else {
      $del = mysqli_query($conn, "DELETE FROM movement_type WHERE id='$del_id_net' ") or die (mysqli_error());
      echo "<script type=\"text/javascript\">";
      echo "  self.location='movement_types_list.php?action=delete&success=true';";
      echo "</script>";
    }  
  }

  $total_results = (mysqli_query($conn, "SELECT COUNT(*) as Num FROM movement_type ")); 
  $row = mysqli_fetch_assoc($total_results);
  $totalCount = $row['Num'];

  if($totalCount ==0) {
    print "<script>";
    print " self.location='noresults.php';"; // Comment this line if you don't want to redirect
    print "</script>";
  }

  $pager = new pager($_GET['p'], 15, $totalCount, 4);
  $offset = $pager->get_start_offset();
  $limit = 15;

  // Perform MySQL query on only the current page number's results 
  $result = mysqli_query($conn, "SELECT * FROM movement_type  ORDER BY id asc LIMIT " . $offset . ", $limit ");
  $recordCount = mysqli_num_rows($result);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Cargo King: Movement Types</title>
    <link href="css/style.css" type="text/css" rel="stylesheet"/>
    <link href="css/styleMenu.css" rel="stylesheet" media="screen">

    <link href="css/blitzer/jquery-ui-1.10.4.custom.css" rel="stylesheet">
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/menu.js"></script>
    <script type="text/javascript">
      var SCROLL_TOP_LIMIT = 124;
      function MM_openBrWindow(theURL,winName,features) { //v2.0
         window.open(theURL,winName,features);
      }  

      var action = "<?php echo $action; ?>";
      var success = "<?php echo $success; ?>";
    	$(document).ready(function(){

        $("#tblMovementTypes tr:odd").addClass("oddRow");
        $("#tblMovementTypes tr:even").addClass("evenRow");

        if( action == "add" && success == "true"){
          $("#divStatus").show();
          $("#divStatusMessage").html("Successfully added movement type.").addClass("success");
        }
        else if( action == "add" && success == "false"){
          $("#divStatus").show();
          $("#divStatusMessage").html("Unable to add weight category.").addClass("error");
        }
        else if( action == "update" && success == "true"){
          $("#divStatus").show();
          $("#divStatusMessage").html("Successfully updated movement type.").addClass("success");
        }
        else if( action == "delete" && success == "true"){
          $("#divStatus").show();
          $("#divStatusMessage").html("Successfully removed movement type.").addClass("success");
        }
        else if( action == "delete" && success == "false"){
          $("#divStatus").show();
          $("#divStatusMessage").html("Cannot remove active movement type.").addClass("error");
        }
        else {
          $("#divStatusMessage").removeClass("success").removeClass("error");
          $("#divStatus").hide();
        }
    	});

      function deleteMovementType(movementTypeId) {
        var confirmDelete = false;
        if( confirmDelete = confirm("Are you sure you want to remove movement type?") ){
          location.href = "movement_types_list.php?del_id=" + movementTypeId;
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
        <div align="center" class="title">Movement Types</div>

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

        <!-- Table Data Container -->
        <div class="clear" align="center">
          <div>

            <!-- START: Data Table -->
            <table id="tblMovementTypes" width="100%" border="0"  cellspacing="0" cellpadding="5" align="center" style="border:5px solid #bbbbbb; margin-bottom: 10px;">
              <tr>
                <td class="tableHeader" style="width: 10%;" align="center"><strong>ID</strong></td>
                <td class="tableHeader" style="width: 30%;"><div align="left"><strong>Type of Movement</strong></div></td> 
                <td class="tableHeader" style="width: 50%;"><div align="left"><strong>Remarks</strong></div></td> 
                <td class="tableHeader" style="width: 10%;"><div align="left"><strong>Action </strong></div></td>
              </tr>

              <?php 
                if( $recordCount > 0 ){
                  while($fet_2=mysqli_fetch_array($result)) {
              ?>  
              <tr>
                <td class="data" style="width: 10%;" align="center"><?php echo $fet_2['id']; ?></td>
                <td class="data" style="width: 30%;"><?php echo stripslashes($fet_2['movement_type']); ?></td>
                <td class="data" style="width: 50%;"><?php echo stripslashes($fet_2['remarks']); ?></td>
                <td class="data" style="width: 10%;">
                  <a class="actionButtons" href="javascript:void(0);" onClick="MM_openBrWindow('move_edit.php?ed=<?php echo $fet_2['id']; ?> ','','scrollbars=yes,left=325,top=50,width=700,height=575')"><img src="images/flat_icons/pencil43.png" class="imageButtonFlat" alt="X" /> </a>
                  <a class="actionButtons" href="javascript:void(0);" onclick="deleteMovementType(<?php echo  $fet_2['id']; ?>)"><img src="images/flat_icons/delete30.png" class="imageButtonFlat" alt="X" /></a>
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
            <!-- END: Data Table -->

          </div>

          <br/>
          <!-- START: Add Button -->
          <p align="right">
            <a id="lnkAddMovementTYpeButton" href="javascript:void(0)" onclick="location.href='add_movement_type.php'" class="flatButton">Add Movement Type</a>
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
