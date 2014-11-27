<?php
  include('constants.php');
  //echo "<span style='padding-left: 15px;'>Success - Login!</span><br />";  
  //echo "<span style='padding-left: 15px;'>Member: " . $_SESSION['type_code'] . "</span><br />";

  session_start();

  $login_name = "";
  $type_code = "";
  $stationId = "";
  if( isset($_SESSION['name']) )      $login_name = $_SESSION['name'];
  if( isset($_SESSION['type_code']) ) $type_code  = $_SESSION['type_code'];
  if( isset($_SESSION['stationId']) ) $stationId  = $_SESSION['stationId'];
?>

<style>
  .warningImage {
    width: 32px;
    height: 32px;
    margin-right: 15px;
  }
</style>

<!-- START: Search Result Pop-up -->
<div id="divDialog" class="dialogStyle">
  <img id="imgClose" src="images/flat_icons/close_32.png" class="closeImage" onclick="closeDialog();" title="Close search result pop-up." />
  <hr class="popupLineTop">
  <div class="searchInfo">
    <p>
      <span class="searchLabel">Sender Name:</span>
      <span class="searchValue" id="spnSenderName">Juan Dela Cruz</span>  
    </p>
    <p>
      <span class="searchLabel">Recipient Name:</span>
      <span class="searchValue" id="spnReceiverName">Rosana Bin Laden</span>  
    </p>
    <p>
      <span class="searchLabel">Delivery Address:</span>
      <span class="searchValue" id="spnReceiverAddress">#123 Dimakita Street, Nawawala Subdivision, Dimahanap City 12345</span>  
    </p>
    <p>
      <span class="searchLabel">Recipient Contact Number:</span>
      <span class="searchValue" id="spnReceiverContactNo">(082) 305-2123</span>  
    </p>
    <p>
      <span class="searchLabel">Cargo Item Status:</span>
      <span class="searchValue" id="spnCargoStatus">For Delivery</span>  
    </p>
    <p>
      <span class="searchLabel">Cargo Last Location:</span>
      <span class="searchValue" id="spnCargoLocation">Dimahanap City Cargo</span>  
    </p>
  </div>
  <hr class="popupLineBottom">
</div>
<!-- END: Search Result Pop-up -->

<!-- START: Menu -->
<div>
  <div style="float: left;">
    <div id="divMenu">
      <ul>
        <li>
          <a href="javascript:void(0)" onclick="location.href='index.php'"><span>Home</span></a>
        </li>
        <?php
          if( $type_code == ADMIN ) {
        ?>
        <li>
          <a><span>Users</span></a>
          <ul>
            <li class='has-sub'>
              <a><span>Station Administators</span></a>
              <ul>
                <li><a href="javascript:void(0)" onclick="location.href='add_station_administrator.php'"><span>New Station Admininstrator</span></a></li>
                <li><a href="javascript:void(0)" onclick="location.href='station_administrator_list.php'"><span>Display Station Admininstrators</span></a></li>
              </ul>
            </li>
            <li class='has-sub'>
              <a><span>Station Managers</span></a>
              <ul>
                <li><a href="javascript:void(0)" onclick="location.href='add_manager.php'"><span>New Station Manager</span></a></li>
                <li><a href="javascript:void(0)" onclick="location.href='manager_list.php'"><span>Display Station Managers</span></a></li>
              </ul>
            </li>
            <li class='has-sub'>
              <a><span>Sorters</a>
              <ul>
                <li><a href="javascript:void(0)" onclick="location.href='add_sorter.php'"><span>New Station Sorter</span></a></li>
                <li><a href="javascript:void(0)" onclick="location.href='sorter_list.php'"><span>Display Station Sorters</span></a></li>
              </ul>
            </li>
            <li class='has-sub'>
              <a><span>Delivery Personnel</span></a>
              <ul>
                <li><a href="javascript:void(0)" onclick="location.href='add_delivery_personnel.php'"><span>New delivery personnel</span></a></li>
                <li><a href="javascript:void(0)" onclick="location.href='delivery_personnels_list.php'"><span>Manage delivery personnels</span></a></li>
              </ul>
            </li>
            <li class='has-sub'>
              <a><span>Excess Baggage</span></a>
              <ul>
                <li><a href="javascript:void(0)" onclick="location.href='add_excess_baggage.php'"><span>New Station Excess Baggage</span></a></li>
                <li><a href="javascript:void(0)" onclick="location.href='excess_baggage_list.php'"><span>Display Station Excess Baggages</span></a></li>
              </ul>
            </li>
            <li class='has-sub'>
              <a><span>Satellite Office Agent</span></a>
              <ul>
                <li><a href="javascript:void(0)" onclick="location.href='add_so_agent.php'"><span>New Satellite Office Agent</span></a></li>
                <li><a href="javascript:void(0)" onclick="location.href='so_agent_list.php'"><span>Display Satellite Office Agents</span></a></li>
              </ul>
            </li>
          </ul>
        </li>
        <li>
          <a><span>Locations</span></a>
          <ul>
            <li class='has-sub'>
              <a><span>Stations</span></a>
              <ul>
                <li><a href="javascript:void(0)" onclick="location.href='add_station.php'"><span>New Station</span></a></li>
                <li><a href="javascript:void(0)" onclick="location.href='stations_list.php'"><span>Manage Stations</span></a></li>
              </ul>
            </li>
            <li class='has-sub'>
              <a><span>Satellite Offices</span></a>
              <ul>
                <li><a href="javascript:void(0)" onclick="location.href='add_delivery_area.php'"><span>New Satellite Office</span></a></li>
                <li><a href="javascript:void(0)" onclick="location.href='delivery_area_list.php'"><span>Manage Satellite Offices</span></a></li>
              </ul>
            </li>
          </ul>
        </li>
        <li>
          <a><span>HAWB Settings</span></a>
          <ul>
            <li class='has-sub'>
              <a>Shipment Types</span></a>
              <ul>
                <li><a href="javascript:void(0)" onclick="location.href='add_shipment_type.php'"><span>New shipment type</span></a></li>
                <li><a href="javascript:void(0)" onclick="location.href='shipment_types_list.php'"><span>Manage shipment types</span></a></li>
              </ul>
            </li>
            <li class='has-sub'>
              <a><span>Weight Breaks</span></a>
              <ul>
                <li><a href="javascript:void(0)" onclick="location.href='add_weight_category.php'"><span>New weight break</span></a></li>
                <li><a href="javascript:void(0)" onclick="location.href='weight_breaks_list.php'"><span>Manage weight breaks</span></a></li>
              </ul>
            </li>
            <li class='has-sub'>
              <a><span>Status Types</span></a>
              <ul>
                <li><a href="javascript:void(0)" onclick="location.href='add_status_type.php'"><span>New status type</span></a></li>
                <li><a href="javascript:void(0)" onclick="location.href='status_types_list.php'"><span>Manage status types</span></a></li>
              </ul>
            </li>
            <li class='has-sub'>
              <a><span>Movement Types</span></a>
              <ul>
                <li><a href="javascript:void(0)" onclick="location.href='add_movement_type.php'"><span>New movement type</span></a></li>
                <li><a href="javascript:void(0)" onclick="location.href='movement_types_list.php'"><span>Manage movement types</span></a></li>
              </ul>
            </li>
            <li class='has-sub'>
              <a><span>Payment Modes</span></a>
              <ul>
                <li><a href="javascript:void(0)" onclick="location.href='add_mode_payment.php'"><span>New payment mode</span></a></li>
                <li><a href="javascript:void(0)" onclick="location.href='payment_modes_list.php'"><span>Manage paymet modes</span></a></li>
              </ul>
            </li>
            <li class='has-sub'>
              <a><span>Service Modes</span></a>
              <ul>
                <li><a href="javascript:void(0)" onclick="location.href='add_service_mode.php'"><span>New service mode</span></a></li>
                <li><a href="javascript:void(0)" onclick="location.href='service_modes_list.php'"><span>Manage service modes</span></a></li>
              </ul>
            </li>
            <li class='has-sub'>
              <a><span>Cargo Vehicles</span></a>
              <ul>
                <li><a href="javascript:void(0)" onclick="location.href='add_cargo_vehicle.php'"><span>New cargo vehicle</span></a></li>
                <li><a href="javascript:void(0)" onclick="location.href='cargo_vehicles_list.php'"><span>Manage cargo vehicles</span></a></li>
              </ul>
            </li>
          </ul>
        </li>                           

        <?php 
          } else if( $type_code == STATION_ADMIN ) {
        ?>
        <li>
          <a><span>Manage Users</span></a>
          <ul>
            <li class='has-sub'>
              <a><span>Manager</span></a>
              <ul>
                <li><a href="javascript:void(0)" onclick="location.href='manager.php'"><span>New manager</span></a></li>
                <li><a href="javascript:void(0)" onclick="location.href='manager_list.php'"><span>Manage managers</span></a></li>
              </ul>
            </li>
            <li class='has-sub'>
              <a><span>Sorter</span></a>
              <ul>
                <li><a href="javascript:void(0)" onclick="location.href='sorters.php'"><span>New station sorter</span></a></li>
                <li><a href="javascript:void(0)" onclick="location.href='sorter_list.php'"><span>Manage stations sorters</span></a></li>
              </ul>
            </li>
            <li class='has-sub'>
              <a><span>Delivery Personnel</span></a>
              <ul>
                <li><a href="javascript:void(0)" onclick="location.href='add_delivery_personnel.php'"><span>New delivery personnel</span></a></li>
                <li><a href="javascript:void(0)" onclick="location.href='delivery_personnels_list.php'"><span>Manage delivery personnels</span></a></li>
              </ul>
            </li>
            <li class='has-sub'>
              <a><span>Excess Baggage</span></a>
              <ul>
                <li><a href="javascript:void(0)" onclick="location.href='excess_baggage.php'"><span>New station excess Baggage staff</span></a></li>
                <li><a href="javascript:void(0)" onclick="location.href='excess_baggage_list.php'"><span>Manage station excess baggage staffs</span></a></li>
              </ul>
            </li>
            <li class='has-sub'>
              <a><span>Satellite Offices Agents</span></a>
              <ul>
                <li><a href="javascript:void(0)" onclick="location.href='so_agent.php'"><span>New satellite offices agent</span></a></li>
                <li><a href="javascript:void(0)" onclick="location.href='so_agent_list.php'"><span>Manage satellite offices agents</span></a></li>
              </ul>
            </li>
          </ul>
        </li>
        <li>
          <a><span>Satellite Offices</span></a>
          <ul>
            <li><a href="javascript:void(0)" onclick="location.href='delivery_area.php'"><span>New satellite office</span></a></li>
            <li><a href="javascript:void(0)" onclick="location.href='delivery_area_list.php'"><span>Manage satellite offices</span></a></li>
          </ul>
        </li>
        <?php 
          } else if( $type_code == MANAGER ) {
        ?>
          <li>
            <a><span>HAWB</span></a>
            <ul>
              <!-- li><a href="javascript:void(0)" onclick="location.href='newbook.php'">New</a></li -->
              <li><a href="javascript:void(0)" onclick="location.href='pend.php'"><span>Pending transactions</span></a></li>
              <li><a href="javascript:void(0)" onclick="location.href='man_booking.php'"><span>View all transactions</span></a></li>
            </ul>
          </li>
          <li>
            <a><span>Customers</span></a>
            <ul>
              <li><a href="javascript:void(0)" onclick="location.href='customer.php'"><span>Add customer</span></a></li>
              <li><a href="javascript:void(0)" onclick="location.href='customer_rep.php'"><span>Manage station customers</span></a></li>
            </ul>
          </li>
          <li>
            <a><span>Agents</span></a>
            <ul>
              <li><a href="javascript:void(0)" onclick="location.href='so_agent_list.php'"><span>Display satellite office agents</span></a></li>
            </ul>
          </li>
        <?php 
          } else if( $type_code == SO_AGENT ) {
        ?>
          <li>
            <a><span>HAWB</span></a>
            <ul>
              <li><a href="javascript:void(0)" onclick="location.href='newbook.php'"><span>New</span></a></li>
              <li><a href="javascript:void(0)" onclick="location.href='pend.php'"><span>Pending</span></a></li>
              <li><a href="javascript:void(0)" onclick="location.href='man_booking.php'"><span>All</span></a></li>
            </ul>
          </li>
          <li>
            <a><span>Customers</span></a>
            <ul>
              <li><a href="javascript:void(0)" onclick="location.href='customer_rep.php?station_only=true'"><span>Station Customers</span></a></li>
              <li><a href="javascript:void(0)" onclick="location.href='customer_rep.php'"><span>Satellite Office Customers</span></a></li>
            </ul>
          </li>
        <?php
          }

          if( $type_code != STATION_ADMIN ) {
        ?>
        <li>
          <a><span>Reports</span></a>
          <ul>
            <li class='has-sub'>
              <a>Branch (SO) Incoming/Outgoing</span></a>
              <ul>
                <li><a href="javascript:void(0)" onclick="location.href='report_outgoing.php'"><span>Outgoing Cargos</span></a></li>
                <li><a href="javascript:void(0)" onclick="location.href='report_incoming.php'"><span>Incoming Cargos</span></a></li>
              </ul>
            </li>
            <?php
              if( $type_code == SO_AGENT || $type_code == MANAGER ) {
            ?>
            <li class='has-sub'>
              <a><span>Agent Sales Report</span></a>
              <ul>
                <li><a href="javascript:void(0)" onclick="location.href='report_agent_daily.php'"><span>Daily</span></a></li>
                <li><a href="javascript:void(0)" onclick="location.href='report_agent_weekly.php'"><span>Weekly</span></a></li>
                <li><a href="javascript:void(0)" onclick="location.href='report_agent_monthly.php'"><span>Monthly</span></a></li>
              </ul>
            </li>
            <li class='has-sub'>
              <a><span>Branch (SO) Sales Report</span></a>
              <ul>
                <li><a href="javascript:void(0)" onclick="location.href='report_branch_daily.php'"><span>Daily</span></a></li>
                <li><a href="javascript:void(0)" onclick="location.href='report_branch_weekly.php'"><span>Weekly</span></a></li>
                <li><a href="javascript:void(0)" onclick="location.href='report_branch_monthly.php'"><span>Monthly</span></a></li>
              </ul>
            </li>
            <?php
              }

              if( $type_code == MANAGER ) {
            ?>
            <li class='has-sub'>
              <a><span>Station (City) Sales Report</span></a>
              <ul>
                <li><a href="javascript:void(0)" onclick="location.href='report_station_daily.php'"><span>Daily</span></a></li>
                <li><a href="javascript:void(0)" onclick="location.href='report_station_weekly.php'"><span>Weekly</span></a></li>
                <li><a href="javascript:void(0)" onclick="location.href='report_station_monthly.php'"><span>Monthly</span></a></li>
              </ul>
            </li>
            <li class='has-sub'>
              <a><span>Monthly Comparator Reports</span></a>
              <ul>
                <li><a href="javascript:void(0)" onclick="location.href='report_station_branches_monthly_chart.php'"><span>Branches Sales</span></a></li>
                <li><a href="javascript:void(0)" onclick="location.href='report_branch_agents_monthly_sales_chart.php'"><span>Agents Sales</span></a></li>
                <li><a href="javascript:void(0)" onclick="location.href='report_branch_agents_monthly_txcounts_chart.php'"><span>Agents Transaction Volume</span></a></li>
              </ul>
            </li>
            <?php
              }
            ?>
            <li><a href="javascript:void(0)" onclick="location.href='allprintview.php'"><span>Reports Preview</span></a></li>
          </ul>
        </li>
        <?php
          }
        ?>
      </ul>
    </div>
  </div>
  <div class="welcome">
    <div class="searchCargoContainer">
      <input type="text" id="txtSearchCargo" maxlength="25" class="trackCargo" placeholder="Search Cargo" title="Enter HAWB ID to search" onkeydown="searchCargoItemByEnterKey(this.value, event);" />
      <a href="javascript:void(0)" onclick="searchCargoItem($('#txtSearchCargo').val());"><img src="images/flat_icons/search.png" class="searchButton" /></a>
    </div>
    <div class="loggedUser"><a href="javascript:void(0)" class="logoutLink" onclick="location.href='edit_profile.php'">[ My Profile ]</a></div>
    <div class="logout"><a href="javascript:void(0)" class="logoutLink" onclick="location.href='../index.php'">LOGOUT</a></div>
  </div>
  <div class="clear"></div>
</div>
<!-- END: Menu -->

<!-- END: Search Result Pop-up -->
<div id="divErrorLogin" class="errorDialog" onclick="closeErrorDialog();" style="display:none;">
  <div style="padding: 10px; text-align: left">
    <div style="float:left;">
      <img src="images/flat_icons/warning_32x32.png" class="warningImage" alt="Warning">
    </div>
    <div id="spanErrorMsg" valign="middle"></div>
  </div>
</div>