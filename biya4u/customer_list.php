<?php 
  include('protect.php');
  include ('dbconnect.php');
  include ('utilities.php');
  include('paging.class.php');
  include('constants.php');

  session_start();

  $type_code = "";
  $stationId = "";
  $satelliteOfficeId = "";
  $stationOnly = "";
  if( isset($_SESSION['type_code']) )           $type_code         = $_SESSION['type_code'];
  if( isset($_SESSION['stationId']) )           $stationId         = $_SESSION['stationId'];
  if( isset($_SESSION['satellite_office_id']) ) $satelliteOfficeId = $_SESSION['satellite_office_id'];
  if( isset($_GET['station_only']) )            $stationOnly       = $_GET['station_only'];

  if( $stationOnly ){
    $satelliteOfficeId = "";
  }
  
  $station = "N/A";
  $satelliteOffice = "N/A";

  if( $stationId ) {
    $stationInfo = getAssociativeArrayFromSQL($conn,  "select * from bplace where id ='" . $stationId . "'" );
    $station = $stationInfo['category'];
  }
  
  if( $satelliteOfficeId ) {
    $satelliteOfficeInfo = getAssociativeArrayFromSQL($conn,  "select * from deliveryarea where id ='" . $satelliteOfficeId . "'" );
    $satelliteOffice = $satelliteOfficeInfo['city'];
  }

  $action = "";
  $success = "";
  if( isset($_REQUEST['action']) ) $action = $_REQUEST['action'];
  if( isset($_REQUEST['success']) ) $success = $_REQUEST['success'];

  if(isset($_REQUEST['del_id'])) {
    $del_id_net = $_REQUEST['del_id' ];

    //Insert code for checking if there are records from other tables that are accessing the record to be deleted.
    //Return an error message if the manager to be deleted has been accessed by other entities.

    $del = mysqli_query($conn, "DELETE FROM customer WHERE id='$del_id_net' ") or die (mysqli_error());
    echo "<script type=\"text/javascript\">";
    echo "  self.location='customer_list.php?action=delete&success=true';";
    echo "</script>";
  }

  $stationFilter   = ($stationId == "") ? "" : " WHERE station_id = " . $stationId;
  $satOfficeFilter = ($satelliteOfficeId == "") ? "" : " AND satellite_office_id=" . $satelliteOfficeId;
  
  $total_results = (mysqli_query($conn, " select count(id) as row_count from vw_customers " . $stationFilter . $satOfficeFilter . " limit 1 ")); 
  $row = mysqli_fetch_assoc($total_results);
  $totalCount = $row['row_count'];

  $pager = new pager($_GET['p'], 15, $totalCount, 4);
  $offset = $pager->get_start_offset();
  $limit = 15;
  $strOffsetLimit = " LIMIT " . $offset . ", $limit";

  $SQLCustomers = "SELECT * FROM vw_customers ";
  $strSQLOrder = " ORDER BY cust_name ASC ";
  
  $SQLResult = $SQLCustomers . $stationFilter . $satOfficeFilter;

  $recordCount = mysqli_num_rows(mysqli_query($conn, $SQLResult));
  $result = mysqli_query($conn, $SQLResult . $strSQLOrder . $strOffsetLimit);

  //echo "[SQL]: " . $SQLResult . "<br>";

  if(isset($_GET['submit'])) {
    $searchKey = "";
    $strBookingFullTextSearchFilter = "";
    $hasSearchKeyFilter = false;

    if ( isset($_GET['searchKey']) ) {
      $searchKey = $_GET['searchKey'];
      $strBookingFullTextSearchFilter = " concat(id, lower(cust_id), identification_number, lower(cust_name), lower(address), lower(station_name), phone, lower(satellite_office_name), lower(email_address)) like '%" . strtolower($searchKey) . "%'";   
      $hasSearchKeyFilter = true;
    }

    $strFilters = " AND ";
    if( $hasSearchKeyFilter ) {
      $strFilters .= $strBookingFullTextSearchFilter;
    }

    $SQLCount = $SQLResult . $strFilters;
    $SQLCustomersResult = $SQLCount . $strSQLOrder . $strOffsetLimit;
    
    //echo "[SQL]: " . $SQLCustomersResult . "<br>";
    
    $totalCount       = mysqli_num_rows( mysqli_query($conn, $SQLCount) );
    $result           = mysqli_query($conn, $SQLCustomersResult);
  }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
     <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Customers</title>
    <link href="css/style.css" type="text/css" rel="stylesheet"/>
    <link href="css/styleMenu.css" rel="stylesheet" media="screen">
    <link href="css/blitzer/jquery-ui-1.10.4.custom.css" rel="stylesheet">
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.bpopup.min.js"></script>
    <script src="js/menu.js"></script>

    <script type="text/javascript">
      var action = "<?php echo $action; ?>";
      var success = "<?php echo $success; ?>";

      $(document).ready(function(){

        $("#tblCustomerList tr:odd").addClass("oddRow");
        $("#tblCustomerList tr:even").addClass("evenRow");

        if( action == "add" && success == "true"){
          $("#trStatusDisplay").show();
          $("#divStatusMessage").html("Successfully added a customer.").show();
        }
        else if( action == "update" && success == "true"){
          $("#trStatusDisplay").show();
          $("#divStatusMessage").html("Successfully updated a customer.").show();
        }
        else if( action == "delete" && success == "true"){
          $("#trStatusDisplay").show();
          $("#divStatusMessage").html("Successfully removed a customer.").show();
        }
        else if( action == "delete" && success == "false"){
          $("#trStatusDisplay").show();
          $("#divStatusMessage").html("Cannot deleted active customer.").show();
        }
        else {
          $("#divStatusMessage").hide();
          $("#trStatusDisplay").hide();
        }
      });
            var SCROLL_TOP_LIMIT = 172;
        function MM_openBrWindow(theURL,winName,features) { //v2.0
          window.open(theURL,winName,features);
        }

        function deleteCustomer(deleteCustomerId) {
            var confirmDelete = false;
            if( confirmDelete = confirm("Are you sure you want to remove customer?") ){
              location.href = "customer_list.php?del_id=" + deleteCustomerId;
            }
            return confirmDelete;
        }
            $("#menuContainerDiv").wrap("<div class=\"menuPlaceholder\"></div>");
            $(".menuPlaceholder").height($("#menuContainerDiv").outerHeight());

            $(document).scroll( function(evt) {
              showFloatingMenu(SCROLL_TOP_LIMIT);  
    }); 
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
    </script>
    <style>
    .customerSearchButton {
      border-width: 0px;
      background-image: url("images/flat_icons/search.png");
      height: 27.1px;
      width: 27px;
      background-color: #ff5151;
      margin-left: -4px;
      background-repeat: no-repeat;
      background-position: center;
      padding: 0px;
      border-radius: 0 5px 5px 0;
      display: inline-block;
      position: relative;
      bottom: -1px;
      cursor: pointer;
    }
    .customerSearchButton:hover {
      background-color: #d81e28;
    }
    .customerSearchBox {
      width: 400px;
      height: 27px;
      color: #ffffff;
      border-radius: 5px 0px 0px 5px;
      background-color: #4c5262;
      font-size: 14px;
      padding: 0 5px 0 15;
      display: inline-block;
      border: 0px;
      margin-left: 15px;
      display: inline-block;
      position: relative;
    }
    </style> 
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
      <div style="width: 900px; padding: 10px;">

        <!-- Status Messages -->      
        <div id="divStatus" align="center" class="title">
          <div id="divStatusMessage"></div>
        </div>

        <!-- Title -->      
        <div style="margin-top: -30px;" align="center" class="title">Customers</div>

        <!-- Paging -->
        <div>
          <div>
            <td align="right">
              <form id="formCustomerSearch" name="formCustomerSearch" method="get">
                <div align="right" style="width: 100%; display: inline-block;">
                  <label for="txtSearchKey">Search by Key:</label>
                  <input type="text" id="txtSearchKey" name="searchKey" value="<?php echo $_GET['searchKey']; ?>" placeholder="Keyword (ie. Sender, Receiver, Origin, Destination, etc.)" class="form-field customerSearchBox"  />
                  <input type="submit" id="btnSubmitSearchByKey" name="submit" value="" class="customerSearchButton"  />
                </div>
              </form>
            </td>
          </div>
          <div class="contents" style="float: left;"><?php echo $totalCount; ?>&nbsp;Results Found</div>
          <div class ="contents" style="float: right;"><?php echo $links = $pager->get_links(); ?></div>
        </div>

        <!-- Table Data Container -->
        <div class="clear" align="center">
          <div>
            <tr>
                <td>
                  <table id="tblCustomerList" width="100%" border="0"  cellspacing="0" cellpadding="5" align="center" style="border:5px solid #bbbbbb; margin-bottom: 10px;">
                    <tr>
                      <th class="tableHeader" style="width: 10%; padding-left: 20px;"><div align="left"><strong>ID</strong></div></th>
                      <th class="tableHeader" style="width: 10%;"><div align="left"><strong>Name</strong></div></th>
                      <th class="tableHeader" style="width: 10%;"><div align="left"><strong>Address</strong></div></th>
                      <th class="tableHeader" style="width: 10%;"><div align="left"><strong>Contact No.</strong></div></th>
                      <th class="tableHeader" style="width: 10%;"><div align="left"><strong>Email Address</strong></div></th>
                      <th class="tableHeader" style="width: 10%;"><div align="left"><strong>Identification No.</strong></div></th>
                      <th class="tableHeader" style="width: 7%;"><div align="left"><strong>Action</strong></div></th>
                    </tr>
                    <?php
                      if( $recordCount > 0 ){
                        while( $fet_2 = mysqli_fetch_array($result) ) {
                        //include('results.php');
                    ?>  
                    <tr>
                      <td class="data" width="1%" style="padding-left: 10px; padding-right: 0px;"><?php  echo $fet_2['cust_id']; ?></td>
                      <td class="data" width="18%" style="padding-left: 0px;"><?php  echo $fet_2['cust_name']; ?></td>
                      <td class="data" width="20%" style="padding-left: 0px;"><?php  echo $fet_2['address']; ?></td>
                      <td class="data" width="13%" style="padding-left: 0px;"><?php  echo $fet_2['phone']; ?></td>
                      <td class="data" width="17%" style="padding-left: 0px; padding-right: 10px;"><?php  echo $fet_2['email_address']; ?></td>
                      <td class="data" width="10%" style="padding-left: 0px;"><?php  echo $fet_2['identification_number']; ?></td>
                      <td class="data" width="8%" style="padding-left: 0px; padding-right: 0px;">
                        <?php 
                          if( $fet_2['satellite_office_id'] == $_SESSION['satellite_office_id'] || $type_code == ADMIN || $type_code == STATION_ADMIN ) {
                        ?>
                        <a href="javascript:void(0);" class="actionButtons" onClick="MM_openBrWindow('customer_edit.php?ed=<?php echo  $fet_2['id']; ?> ','','scrollbars=yes,left=150,top=10,width=900,height=900')"><img src="images/flat_icons/pencil43.png" class="imageButtonFlat" alt="X" /></a>
                        <a href="javascript:void(0);" class="actionButtons" onclick="deleteCustomer(<?php echo  $fet_2['id']; ?>)"><img src="images/flat_icons/delete30.png" class="imageButtonFlat" alt="X" /></a>
                        <?php
                          }
                          else
                            echo "&nbsp;";
                        ?>
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
            <a id="lnkButton" href="javascript:void(0)" onclick="location.href='customer.php'" class="flatButton">Add Customer</a>
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
