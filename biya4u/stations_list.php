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
    $station_query=mysqli_query($conn, "select * from booking where origin='$del_id_net'");
    $station_num=mysqli_num_rows($station_query);
  
    if($station_num>0) {
      echo "<script type=\"text/javascript\">";
      echo "  self.location='stations_list.php?action=delete&success=false';";
      echo "</script>";  
    }
    else {
      $del = mysqli_query($conn, "DELETE FROM area_location WHERE id='$del_id_net' ") or die (mysqli_error());
      echo "<script type=\"text/javascript\">";
      echo "  self.location='stations_list.php?action=delete&success=true';";
      echo "</script>";
    }
  }

  $total_results = (mysqli_query($conn, "SELECT COUNT(*) as Num FROM area_location ")); 
  $row = mysqli_fetch_assoc($total_results);
  $totalCount = $row['Num'];

  $pager = new pager($_GET['p'], 15, $totalCount, 4);
  $offset = $pager->get_start_offset();
  $limit = 15;

  $result = mysqli_query($conn, "SELECT * FROM area_location ORDER BY id ASC LIMIT " . $offset . ", $limit ");
  $recordCount = mysqli_num_rows($result);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Cargo King: Stations</title>
    <link href="css/style.css" type="text/css" rel="stylesheet"/>
    <link href="css/styleMenu.css" rel="stylesheet" media="screen">

    <link href="css/blitzer/jquery-ui-1.10.4.custom.css" rel="stylesheet">
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.bpopup.min.js"></script>
    <script src="js/menu.js"></script>

    <script type="text/javascript">
      var SCROLL_TOP_LIMIT = 124;
      function MM_openBrWindow(theURL,winName,features) { //v2.0
        window.open(theURL,winName,features);
      }

      var action = "<?php echo $action; ?>";
      var success = "<?php echo $success; ?>";

      $(document).ready(function(){
        $("#tblStationsList tr:odd").addClass("oddRow");
        $("#tblStationsList tr:even").addClass("evenRow");

        if( action == "add" && success == "true"){
          $("#divStatus").show();
          $("#divStatusMessage").html("Successfully added station.").addClass("success");
        }
        else if( action == "add" && success == "false"){
          $("#divStatus").show();
          $("#divStatusMessage").html("Unable to add weight category.").addClass("error");
        }
        else if( action == "update" && success == "true"){
          $("#divStatus").show();
          $("#divStatusMessage").html("Successfully updated station.").addClass("success");
        }
        else if( action == "delete" && success == "true"){
          $("#divStatus").show();
          $("#divStatusMessage").html("Successfully removed station.").addClass("success");
        }
        else if( action == "delete" && success == "false"){
          $("#divStatus").show();
          $("#divStatusMessage").html("Cannot delete active station.").addClass("error");
        }
        else {
          $("#divStatusMessage").removeClass("success").removeClass("error");
          $("#divStatus").hide();
        }
    	});

        function deleteStation(stationId) {
          var confirmDelete = false;
          if( confirmDelete = confirm("Are you sure you want to remove station?") ){
            location.href = "stations_list.php?del_id=" + stationId;
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
        <div align="center" class="title">Stations</div>

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
            <table id="tblStationsList" width="100%" border="0"  cellspacing="0" cellpadding="5" align="center" style="border:5px solid #bbbbbb; margin-bottom: 10px;">
              <tr>
                <th class="tableHeader" width="10%"><strong>ID</strong></th>
                <th class="tableHeader" width="20%"><div align="left"><strong>Location</strong></div></td>  
                <th class="tableHeader" width="10%"><div align="left"><strong>Code</strong></div></td>
                <th class="tableHeader" width="50%"><div align="left"><strong>Address</strong></div></td>
                <th class="tableHeader" width="10%"><div align="left"><strong>Action </strong></div></td>
              </tr>
              <?php 
                if( $recordCount > 0 ){
                  while($fet_2 = mysqli_fetch_array($result)) {
              ?>  
              <tr>
                <td width="10%" class="data" align="center"><?php  echo $fet_2['id']; ?></td>
                <td width="20%" class="data"><?php  echo stripslashes($fet_2['area_name']); ?></td>
                <td width="10%" class="data"><?php  echo stripslashes($fet_2['area_code']); ?></td>
                <td width="50%" class="data"><?php  echo stripslashes($fet_2['address']); ?></td>
                <td width="10%">
                  <a href="javascript:void(0);" class="actionButtons" onClick="MM_openBrWindow('bookpl_edit.php?ed=<?php echo  $fet_2['id']; ?> ','','scrollbars=yes,left=300,top=150,width=600,height=500')"><img src="images/flat_icons/pencil43.png" class="imageButtonFlat" alt="X" /></a>
                  <a href="javascript:void(0);" class="actionButtons" onclick="deleteStation(<?php echo  $fet_2['id']; ?>)"><img src="images/flat_icons/delete30.png" class="imageButtonFlat" alt="X" /></a>
                </td>
              </tr> 
              <?php
                  }
                }
                else {
              ?>
                <tr><td colspan="5" align="center"><span class="dataNotFound">Data not found.</span></td></tr>
              <?php
                }
              ?>
            </table>
            <!-- END: Data Table -->

          </div>

          <br />
          <!-- START: Add Button -->
          <p align="right">
            <a id="lnkButton" href="javascript:void(0)" onclick="location.href='add_station.php'" class="flatButton">Add Station</a>
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
