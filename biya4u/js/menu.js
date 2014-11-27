var searchCargoItem = function(hawbCode) {
  if(hawbCode) {

    //console.log("[HAWB-CODE]: " + hawbCode);

    //CK-DVO-BUHANGIN-1039
    $.getJSON("trackCargoItem.php", { hawb_code: hawbCode}, function(data){
        console.log("[DATA]: " + data);
        if(data){
          $("#spnSenderName").html(data.sender_name);
          $("#spnReceiverName").html(data.receiver_name);
          $("#spnReceiverAddress").html(data.receiver_address);
          $("#spnReceiverContactNo").html(data.receiver_phone);
          $("#spnCargoStatus").html(data.status_description);
          $("#spnCargoLocation").html(data.location);
          $("#spnCargoUser").html(data.full_name);
          showDialog("divDialog");
        }
        else {
          showDialog("divErrorLogin", "spanErrorMsg", "Unable to locate cargo with Tracking <br>No.: '" + hawbCode + "'.");
        }
    });
  }
};



var searchCargoItemByEnterKey = function(hawbCode, event) {
  var key = event.which;
  if(key == 13) {
    searchCargoItem(hawbCode);
  }
};

var showDialog = function( containerId, msgContainerId, msg ){
  $("#" + msgContainerId).html(msg);
  $("#" + containerId).bPopup();
};

var closeDialog = function() {
  $("#divDialog").bPopup().close()
};

var closeErrorDialog = function() {
  $("#divErrorLogin").bPopup().close()
};

var showFloatingMenu = function(scrollTopLimit, isDebug) {
  var scrollTopValue = $(window).scrollTop();

  //For Testing Purposes only
  if(isDebug) {
    $("#txtSearchCargo").val(scrollTopValue);
  }

  if(scrollTopValue >= scrollTopLimit) {
    $("#menuContainerDiv").addClass("floatingMenuContainer");
  }
  else {
    $("#menuContainerDiv").removeClass("floatingMenuContainer");
  }
};