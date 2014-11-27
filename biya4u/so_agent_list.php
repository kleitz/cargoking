<?php 
  include('protect.php');
  include('dbconnect.php');
  include('utilities.php');
  include('paging.class.php');
  include('constants.php');

  session_start();

  $type_code = "";
  $stationId = "";
  $satelliteOfficeId = "";
  if( isset($_SESSION['type_code']) )           $type_code         = $_SESSION['type_code'];
  if( isset($_SESSION['stationId']) )           $stationId         = $_SESSION['stationId'];
  if( isset($_SESSION['satellite_office_id']) ) $satelliteOfficeId = $_SESSION['satellite_office_id'];

  $station = "N/A";
  $satelliteOffice = "N/A";

  if( $stationId ) {
    $stationInfo = getAssociativeArrayFromSQL($conn,  "select * from area_location where id ='" . $stationId . "'" );
    $station = $stationInfo['area_name'];
  }

  if( $satelliteOfficeId ) {
    $satelliteOfficeInfo = getAssociativeArrayFromSQL($conn,  "select * from delivery_area where id ='" . $satelliteOfficeId . "'" );
    $satelliteOffice = $satelliteOfficeInfo['area'];
  }

  $action = "";
  $success = "";
  if( isset($_REQUEST['action']) ) $action = $_REQUEST['action'];
  if( isset($_REQUEST['success']) ) $success = $_REQUEST['success'];

  if(isset($_REQUEST['del_id'])) {
    $del_id_net = $_REQUEST['del_id' ];

    //Insert code for checking if there are records from other tables that are accessing the record to be deleted.
    //Return an error message if the manager to be deleted has been accessed by other entities.

    $del = mysqli_query($conn, "DELETE FROM users WHERE id='$del_id_net' ") or die (mysqli_error());
    echo "<script type=\"text/javascript\">";
    echo "  self.location='so_agent_list.php?action=delete&success=true';";
    echo "</script>";
  }

  $stationFilter   = ($stationId == "") ? "" : " AND station_id = " . $stationId;
  $satOfficeFilter = ($satelliteOfficeId == "") ? "" : " AND satellite_office_id=" . $satelliteOfficeId;
  
  $total_results = (mysqli_query($conn, " select count(id) as row_count from vw_satellite_office_agents WHERE 1=1" . $stationFilter . $satOfficeFilter . " limit 1 ")); 

  $row = mysqli_fetch_assoc($total_results);
  $totalCount = $row['row_count'];

  $pager = new pager($_GET['p'], 15, $totalCount, 4);
  $offset = $pager->get_start_offset();
  $limit = 15;
  $strOffsetLimit = " LIMIT " . $offset . ", $limit";
  
  $SQLSOAgents = "SELECT * FROM vw_satellite_office_agents WHERE 1=1";
  $strSQLOrder = " ORDER BY agent_name ASC ";
  
  $SQLResult = $SQLSOAgents . $stationFilter . $satOfficeFilter;
  
  $recordCount = mysqli_num_rows(mysqli_query($conn, $SQLResult));
  $result = mysqli_query($conn, $SQLResult . $strSQLOrder . $strOffsetLimit);

  if(isset($_GET['submit'])) {
    $searchKey = "";
    $strBookingFullTextSearchFilter = "";
    $hasSearchKeyFilter = false;

    if ( isset($_GET['searchKey']) ) {
      $searchKey = $_GET['searchKey'];
      $strBookingFullTextSearchFilter = " AND concat(id, lower(code), identification_no, lower(agent_name), lower(username), lower(email), phone, lower(satellite_office)) like '%" . strtolower($searchKey) . "%'";    
      $hasSearchKeyFilter = true;
    }

    $strFilters = "";
    if( $hasSearchKeyFilter ) {
      $strFilters .= $strBookingFullTextSearchFilter;
    }

    $SQLCount = $SQLResult . $strFilters;
    $SQLBookingResult = $SQLCount . $strSQLOrder . $strOffsetLimit;

    $totalCount  = mysqli_num_rows( mysqli_query($conn, $SQLCount) );
    $recordCount = mysqli_num_rows(mysqli_query($conn, $SQLBookingResult));
    $result      = mysqli_query($conn, $SQLBookingResult);
  }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Admin: S.O Agent List</title>
    <link href="css/style.css" type="text/css" rel="stylesheet"/>
    <link href="css/styleMenu.css" rel="stylesheet" media="screen">
    <link href="css/blitzer/jquery-ui-1.10.4.custom.css" rel="stylesheet">

    <style>
      #btnSubmitSearchByKey {
        padding: 2px 5px;
        border: 0px;
        font-weight: bold;
        font-size: 18px;
        cursor: pointer;
        color: white; 
      }
    </style>

    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.bpopup.min.js"></script>
    <script src="js/menu.js"></script>
    <script type="text/javascript">
      var action = "<?php echo $action; ?>";
      var success = "<?php echo $success; ?>";
      var SCROLL_TOP_LIMIT = 124;

      $(document).ready(function(){

        $("#tblSoAgentList tr:odd").addClass("oddRow");
        $("#tblSoAgentList tr:even").addClass("evenRow");

        $("#menuContainerDiv").wrap("<div class=\"menuPlaceholder\"></div>");
        $(".menuPlaceholder").height($("#menuContainerDiv").outerHeight());

        if( action == "add" && success == "true"){
          $("#divStatus").show();
          $("#divStatusMessage").html("Successfully added a satellite office agent.").addClass("success");
        }
        else if( action == "add" && success == "false"){
          $("#divStatus").show();
          $("#divStatusMessage").html("Unable to add weight category.").addClass("error");
        }
        else if( action == "update" && success == "true"){
          $("#divStatus").show();
          $("#divStatusMessage").html("Successfully updated a satellite office agent.").addClass("success");
        }
        else if( action == "delete" && success == "true"){
          $("#divStatus").show();
          $("#divStatusMessage").html("Successfully removed a satellite office agent.").addClass("success");
        }
        else if( action == "delete" && success == "false"){
          $("#divStatus").show();
          $("#divStatusMessage").html("Cannot deleted active satellite office agent.").addClass("error");
        }
        else {
          $("#divStatusMessage").removeClass("success").removeClass("error");
          $("#divStatus").hide();
        }

      });

      $(document).scroll( function(evt) {
        showFloatingMenu(SCROLL_TOP_LIMIT);  
      });  

      function MM_openBrWindow(theURL,winName,features) { //v2.0
        window.open(theURL,winName,features);
      }

      function deleteSatelliteOfficeAgent(deleteSatelliteOfficeAgentId) {
          var confirmDelete = false;
          if( confirmDelete = confirm("Are you sure you want to remove S.O agent?") ){
            location.href = "so_agent_list.php?del_id=" + deleteSatelliteOfficeAgentId;
          }
          return confirmDelete;
      }
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
      <div style="width: 800px; padding: 10px; height: auto;">

        <!-- Title -->      
        <div align="center" class="title">Satellite Office Agents</div>

         <!-- Status Messages -->      
        <div id="divStatus" align="center" class="title">
          <div id="divStatusMessage"></div>
        </div>

        <!-- Paging -->
        <div>
          <div style="margin-bottom: 10px;">
            <td align="right">
              <form id="formSOAgentSearch" name="formSOAgentSearch" method="get">
                <div align="right" style="width: 100%; display: inline-block;">
                  <label for="txtSearchKey">Search by Key:</label>
                  <input type="text" id="txtSearchKey" name="searchKey" value="<?php echo $_GET['searchKey']; ?>" placeholder="Keyword (ie. Name, Code, Username, Station, Branch, etc.)" class="profileField" style="width: 400px; font-size: 14px; padding: 5px 10px; display: inline-block;" />
                  <input type="submit" id="btnSubmitSearchByKey" name="submit" value="&#128269;" class="flatButton" style="padding: 2px 5px; border: 0px; color: white; font-weight: bold; font-size: 18px;" />
                </div>
              </form>
             </td>
          </div>
          <div class="contents" style="float: left;"><?php echo $totalCount; ?>&nbsp;Results Found</div>
          <div class="contents" style="float: right;"><?php echo $links = $pager->get_links(); ?></div>
        </div>

        <!-- Table Data Container -->
        <div class="clear" align="center">
          <div>
            <tr>
                <td>
                  <table id="tblSoAgentList" width="100%" border="0"  cellspacing="0" cellpadding="5" align="center" style="border:5px solid #bbbbbb; margin-bottom: 10px;">
                    <tr>
                      <th class="tableHeader" style="width: 5%; padding-left: 10px;"><div align="left"><strong>ID</strong></div></th>
                      <th class="tableHeader" style="width: 30%;"><div align="left"><strong>Name</strong></div></th>
                      <th class="tableHeader" style="width: 10%;"><div align="left"><strong>Station</strong></div></th>
                      <th class="tableHeader" style="width: 11%; padding-left: 10px;"><div align="left"><strong>Branch</strong></div></th>
                      <th class="tableHeader" style="width: 13%;"><div align="left"><strong>Phone</strong></div></th>
                      <th class="tableHeader" style="width: 20%;"><div align="left"><strong>Email</strong></div></th>
                      <th class="tableHeader" style="width: 11%; padding-left: 5px;"><div align="left"><strong>Action</strong></div></th>
                    </tr>
                    <?php
                      if( $recordCount > 0 ){
                        while( $fet_2 = mysqli_fetch_array($result) ) {
                        //include('results.php');
                    ?>  
                    <tr>
                      <td style="padding-left: 10px;" width="5%"><?php  echo $fet_2['id']; ?></td>
                      <td class="dataRegular" width="30%"><?php  echo stripslashes($fet_2['agent_name']); ?></td>
                      <td class="dataSmall" width="10%" style="padding-left: 10px;">
                        <?php   
                          $bpid = $fet_2['station_id'];
                          $rs=getAssociativeArrayFromSQL($conn, "select * from area_location where id=".$bpid."");
                          echo $rs['area_name'];
                        ?>
                      </td>
                      <td class="dataSmall" width="11%" style="padding-left: 10px;"><?php  echo $fet_2['satellite_office']; ?></td>
                      <td class="dataSmall" width="13%"><?php  echo stripslashes($fet_2['phone']); ?></td>
                      <td class="dataSmall" width="20%"><?php  echo stripslashes($fet_2['email']); ?></td>
                      <td class="data" width="11%" style="padding-left: 5px;">
                        <a class="actionButtons" href="javascript:void(0);" onClick="MM_openBrWindow('so_agent_edit.php?ed=<?php echo  $fet_2['id']; ?> ','','scrollbars=yes,left=150,top=10,width=900,height=900')"><img src="images/flat_icons/pencil43.png" class="imageButtonFlat" alt="X" /></a>
                        <a class="actionButtons" href="javascript:void(0);" onclick="deleteSatelliteOfficeAgent(<?php echo  $fet_2['id']; ?>)"><img src="images/flat_icons/delete30.png" class="imageButtonFlat" alt="X" /></a>
                      </td>
                    </tr> 
                    <?php
                        }
                      }
                      else {
                    ?>
                      <tr><td colspan="7" align="center"><span class="dataNotFound">Data not found.</span></td></tr>
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
            <a id="lnkButton" href="javascript:void(0)" onclick="location.href='add_so_agent.php'" class="flatButton">Add Satellite Office Agent</a>
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
