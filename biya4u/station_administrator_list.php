<?php 
  include('protect.php');
  include('dbconnect.php');
  include('utilities.php');
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

  if(isset($_REQUEST['del_id'])) {
    $del_id_net = $_REQUEST['del_id' ];

    //Insert code for checking if there are records from other tables that are accessing the record to be deleted.
    //Return an error message if the station admin to be deleted has been accessed by other entities.

    $del=mysqli_query($conn, "DELETE FROM users WHERE id='$del_id_net' ") or die (mysqli_error());
    echo "<script type=\"text/javascript\">";
    echo "  self.location='station_administrator_list.php?action=delete&success=true';";
    echo "</script>";
  }

  $stationFilter = ($stationId == "") ? "" : " AND station_id = " . $stationId;
  $total_results = (mysqli_query($conn, " select count(id) as row_count from vw_loginusers where user_type_id = " . STATION_ADMIN_ID . $stationFilter . " limit 1 ")); 
    
  $row = mysqli_fetch_assoc($total_results);
  $totalCount = $row['row_count'];



  $pager = new pager($_GET['p'], 15, $totalCount, 4);
  $offset = $pager->get_start_offset();
  $limit = 15;

  // Perform MySQL query on only the current page number's results 
  $SQLStationAdmins = "SELECT * FROM vw_loginusers where user_type_id = " . STATION_ADMIN_ID . $stationFilter . " ORDER BY full_name desc LIMIT " . $offset . ", $limit ";
  $result = mysqli_query($conn, $SQLStationAdmins);
  $recordCount = mysqli_num_rows($result)
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Cargo King: Station Administrators</title>
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



        $("#tblStationList tr:odd").addClass("oddRow");
        $("#tblStationList tr:even").addClass("evenRow");

        if( action == "add" && success == "true"){
          $("#divStatus").show();
          $("#divStatusMessage").html("Successfully added station administrator.").addClass("success");
        }
        else if( action == "add" && success == "false"){
          $("#divStatus").show();
          $("#divStatusMessage").html("Unable to add station administrator.").addClass("error");
        }
        else if( action == "update" && success == "true"){
          $("#divStatus").show();
          $("#divStatusMessage").html("Successfully updated station administrator.").addClass("success");
        }
        else if( action == "delete" && success == "true"){
          $("#divStatus").show();
          $("#divStatusMessage").html("Successfully removed station administrator.").addClass("success");
        }
        else if( action == "delete" && success == "false"){
          $("#divStatus").show();
          $("#divStatusMessage").html("Cannot deleted active station administrator.").addClass("error");
        }
        else {
          $("#divStatusMessage").removeClass("success").removeClass("error");
          $("#divStatus").hide();
        }
      });

        function deleteStationAdministrator(deleteSAdminId) {
          var confirmDelete = false;
          if( confirmDelete = confirm("Are you sure you want to remove station administrator?") ){
            location.href = "station_administrator_list.php?del_id=" + deleteSAdminId;
          }
          return confirmDelete;
        }
        $(document).ready(function(){
          $("#menuContainerDiv").wrap("<div class=\"menuPlaceholder\"></div>");
          $(".menuPlaceholder").height($("#menuContainerDiv").outerHeight());
       });

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
        <div align="center" class="title">Station Administrators</div>

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
            <td>
              <table id="tblStationList" width="100%" border="0"  cellspacing="0" cellpadding="5" align="center" style="border:5px solid #bbbbbb; margin-bottom: 10px;">
                  <tr>
                    <th class="tableHeader" style="width: 5%; padding-left: 10px;" width="15%" height="39"><div align="left"><strong>ID</strong></div></th>
                    <th class="tableHeader" style="width: 35%;"><div align="left"><strong>Name</strong></div></th>
                    <th class="tableHeader" style="width: 10%;"><div align="left"><strong>Station</strong></div></th>
                    <th class="tableHeader" style="width: 17%;"><div align="left"><strong>Phone</strong></div></th>
                    <th class="tableHeader" style="width: 20%; padding-left: 15px;"><div align="left"><strong>Email</strong></div></th> 
                    <th class="tableHeader" style="width: 13%; padding-left: 25px; padding-right: 0;"><div align="left"><strong>Action</strong></div></th>
                  </tr>
                  <?php 
                    if( $recordCount > 0 ){
                      while($fet_2=mysqli_fetch_array($result)) {
                  ?>
                  <tr>
                    <td class="data" width="5%" style="padding-left: 10px;"><?php echo $fet_2['id']; ?></td>
                    <td class="data" width="35%"><?php echo stripslashes($fet_2['full_name']); ?></td>
                    <td class="data" width="10%" style="padding-left: 10px;">
                      <?php  
                        $bpid = $fet_2['station_id'];
                        $rs = getAssociativeArrayFromSQL($conn, "select * from area_location where id=".$bpid."");
                        echo $rs['area_name'];
                      ?>
                    </td>
                    <td width="17%"><?php  echo stripslashes($fet_2['contact_number']); ?></td>
                    <td width="20%" style="padding-left: 15px;"><?php  echo stripslashes($fet_2['email']); ?></td>
                    <td width="13%" style="padding-left: 15px;">
                      <a class="actionButtons" href="javascript:void(0);" onClick="MM_openBrWindow('station_edit.php?ed=<?php echo  $fet_2['id']; ?> ','','scrollbars=yes,left=150,top=10,width=900,height=900')"><img src="images/flat_icons/pencil43.png" class="imageButtonFlat" alt="X" /></a>
                      <a class="actionButtons" href="javascript:void(0);" onclick="deleteStationAdministrator(<?php echo  $fet_2['id']; ?>)"><img src="images/flat_icons/delete30.png" class="imageButtonFlat" alt="X" /></a>
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
          </div>

          <br />
          <!-- START: Add Button -->
          <p align="right">
            <a id="lnkButton" href="javascript:void(0)" onclick="location.href='add_station_administrator.php'" class="flatButton">Add Station Administrator</a>
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
