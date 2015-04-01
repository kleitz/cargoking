<?php 
  include('protect.php');
  include ('dbconnect.php');
  include ('utilities.php');
  include('paging.class.php');
  include('constants.php');

  session_start();
  $type_code = "";
  $stationId = "";
  if( isset($_SESSION['type_code']) ) $type_code = $_SESSION['type_code'];
  if( isset($_SESSION['stationId']) ) $stationId = $_SESSION['stationId'];

  $action = "";
  $success = "";
  if( isset($_REQUEST['action']) ) $action = $_REQUEST['action'];
  if( isset($_REQUEST['success']) ) $success = $_REQUEST['success'];

  $station = "N/A";
  if( $stationId != "" ) {
    $stationInfo = getAssociativeArrayFromSQL($conn,  "select * from area_location where id ='" . $stationId . "'" );
    $station = $stationInfo['area_name'];
  }

  if(isset($_REQUEST['del_id'])) {
    $del_id_net = $_REQUEST['del_id' ];
    $del=mysqli_query($conn, "DELETE FROM delivery_area WHERE id='$del_id_net' ") or die (mysqli_error());
    
    echo "<script type=\"text/javascript\">";
    echo "self.location='delivery_area_list.php?action=delete&success=true';";
    echo "</script>";
  }

  //echo "[STATION-ID]: [" . $stationId . "]<br>";
  
  $stationFilter = $stationId == "" ? "" : " WHERE station = " . $stationId;
  $total_results = (mysqli_query($conn, "SELECT COUNT(*) as Num FROM delivery_area ". $stationFilter)); 
  $row = mysqli_fetch_assoc($total_results);
  $totalCount = $row['Num'];

  /*
  if($totalCount ==0) {
    print "<script>";
      print "self.location='noresults.php';"; // Comment this line if you don't want to redirect
    print "</script>";
  }
  */
  
  $pager = new pager($_GET['p'], 15, $totalCount, 4);
  $offset = $pager->get_start_offset();
  $limit = 15;

  // Perform MySQL query on only the current page number's results 
  $SQLQuery = "SELECT * FROM delivery_area " . $stationFilter . " ORDER BY city asc LIMIT " . $offset . ", $limit ";
  
  //echo "[SQL]: " . $SQLQuery . "<br>";
  
  $result = mysqli_query($conn,  $SQLQuery );
  $recordCount = mysqli_num_rows($result);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Cargo King: Satellite Offices</title>
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

        $("#tblDeliveryAreasList tr:odd").addClass("oddRow");
        $("#tblDeliveryAreasList tr:even").addClass("evenRow");

        if( action == "add" && success == "true"){
          $("#divStatus").show();
          $("#divStatusMessage").html("Successfully added a satellite office.").addClass("success");
        }
        else if( action == "add" && success == "false"){
          $("#divStatus").show();
          $("#divStatusMessage").html("Unable to add weight category.").addClass("error");
        }
        else if( action == "update" && success == "true"){
          $("#divStatus").show();
          $("#divStatusMessage").html("Successfully updated a satellite office.").addClass("success");
        }
        else if( action == "delete" && success == "true"){
          $("#divStatus").show();
          $("#divStatusMessage").html("Successfully removed a satellite office.").addClass("success");
        }
        else if( action == "delete" && success == "false"){
          $("#divStatus").show();
          $("#divStatusMessage").html("Cannot deleted active satellite office.").addClass("error");
        }
        else {
          $("#divStatusMessage").removeClass("success").removeClass("error");
          $("#divStatus").hide();
        }

      });
      
      function deleteArea(areaId) {
        var confirmDelete = false;
          if( confirmDelete = confirm("Are you sure you want to remove area?") ){
            location.href = "delivery_area_list.php?del_id=" + areaId;
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
        <div align="center" class="title">Satellite Offices</div>

        <!-- Status Messages -->      
        <div id="divStatus" align="center" class="title">
          <div id="divStatusMessage"></div>
        </div>

        <!-- Paging -->
        <div>
          <div class="contents" style="float: left;"><?php echo $totalCount; ?>&nbsp;Results Found</div>
          <div class="contents" style="float: right;"><?php echo $links = $pager->get_links(); ?></div>
        </div>

        <!-- Table Data Container -->
        <div class="clear" align="center">
          <div>
            <tr>
                <td id="min1">
                  <table id="tblDeliveryAreasList" width="100%" border="0"  cellspacing="0" cellpadding="5" align="center" style="border:5px solid #bbbbbb; margin-bottom: 10px;">
                    <tr>
                      <th class="tableHeader" style="width: 5%; padding-left: 20px;"><div align="left"><strong>Id</strong></div></th>
                      <th class="tableHeader" style="width: 20%; padding-left: 20px;"><div align="left"><strong>City</strong></div></th>
                      <th class="tableHeader" style="width: 20%;"><div align="left"><strong>HAWB Prefix</strong></div></th>
                      <th class="tableHeader" style="width: 20%; padding-left: 10px;"><div align="left"><strong>Station</strong></div></th>
                      <th class="tableHeader" style="width: 15%; padding-left: 25px;"><div align="left"><strong>Delivery Area</strong></div></th> 
                      <th class="tableHeader" style="width: 20%;"><div style="padding-left: 47px;" align="left"><strong>Action</strong></div></th>  
                    </tr>
                  <?php 
                    if( $recordCount > 0 ){
                      while( $fet_2 = mysqli_fetch_array($result) ) {
                  ?>  
                    <tr>
                      <td class="data" style="width: 5%; padding-left: 20px;"><?php  echo $fet_2['id']; ?></td>
                      <td class="data" style="width: 20%; padding-left: 20px;"><?php  echo stripslashes($fet_2['area']); ?></td>
                      <td class="data" style="width: 20%; padding-left: 10;"><?php  echo $fet_2['station_hawb_prefix']; ?></td>
                      <td class="data" style="width: 20%; padding-left: 10px;">
                        <?php  
                          $bpid = $fet_2['station'];
                          $rs = getAssociativeArrayFromSQL($conn, "select * from area_location where id=".$bpid."");
                          echo $rs['area_name']; 
                        ?>
                      </td>
                      <td class="data" style="width: 20%; padding-left: 25px;">
                        <?php 
                          if($fet_2['delarea']=="1")
                            echo ("Within City");
                          else
                            echo ("Outside City");
                        ?>
                      </td>
                      <td style="padding-left: 45px;" width="15%">
                        <a href="javascript:void(0);" class="actionButtons" onClick="MM_openBrWindow('deliveryarea_edit.php?ed=<?php echo  $fet_2['id']; ?> ','','scrollbars=yes,left=300,top=150,width=600,height=500')"><img src="images/flat_icons/pencil43.png" class="imageButtonFlat" alt="X" /></a>
                        <a href="javascript:void(0);" class="actionButtons" onclick="deleteArea(<?php echo  $fet_2['id']; ?>)"><img src="images/flat_icons/delete30.png" class="imageButtonFlat" alt="X" /></a>
                      </td>
                    </tr>
                    <?php
                        }
                      }
                      else {
                    ?>
                      <tr><td colspan="6" align="center"><span class="dataNotFound">Data not found.</span></td></tr>
                    <?php
                      }
                    ?>
                  </table>
                </td>
              </tr>
          </div>

          <br />
          <!-- START: Add Button -->
          <p align="right">
            <a id="lnkButton" href="javascript:void(0)" onclick="location.href='delivery_area.php'" class="flatButton">Add Satellite Office</a>
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
