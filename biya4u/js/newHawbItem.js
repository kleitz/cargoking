function initializePage(){

	var rowCount = $("#tblHawbItems tr").length;
	if( rowCount <= 1){
		addCargoDetailsRow();
	}

	$( "#txtHAWBDate" ).datepicker({ dateFormat: 'dd-mm-yy' });
	$("#btnCalculateHawb, #btnSubmitHawb, #btnResetHawb, #lnkAddCargoItem").button();
	$("input[type=radio]").iCheck({ radioClass: 'iradio_flat-red' });
	
	$("#lnkAddCustomer").bind("click", function(e){
		e.preventDefault();
		$('#divAddCustomer').bPopup({
			content: 'iframe',
			contentContainer: "#divAddCustomer",
			iframeAttr: "scrolling='no', frameborder='0', width='820', height='825'",
			loadUrl: "customer_popup.php"
		});
	});

	$("#txtCustomer").keyup( function(e){
		var KEY_ESCAPE = 27; //Escape key
		var code = e.keyCode || e.which;
		if( code != KEY_ESCAPE ){
			var txt = $(this).val();
			$("#min1").show();
			$("#divCustomerList").show();			
			$.post("cus1.php", {suggest: txt}, function(result) {
				$("#min1").html(result);
				if($("#min1 li").length == 0) $("#min1").hide();
			});		
		}
		else {
			$("#min1").empty();
			$("#min1").hide();
			$("#divCustomerList").hide();
		}
	});

	$("#sel_destination").change(function(){
		var txt = $(this).val();
		$.post("city.php", {suggest: txt}, function(result){
			$("#sel_rcity").html(result);
		});
	});

	$("#selDivisor").val("3500");

	$("#lnkTest").bind("click", function(e){
		e.preventDefault();
		$("#divDialog").bPopup();
	});

/*
	$("#divDialog").dialog({
		autoOpen: false,
		modal: false,
		buttons: {
			Ok: function () {
				$(this).dialog("close");
			}
		}
	});
*/
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

/* Load customer details into text fields */
var loadSelectedCustomerInfos = function(customerId){
	$("#txtCustomer").val(customerId);
	$.get("load_customer.php", {customerId: customerId}, function(result){
		var jsonObj = JSON && JSON.parse(result) || $.parseJSON(result);
		$("#txtCustomer").val(jsonObj.cust_id);
		$("#txtSenderName").val(jsonObj.cust_name);
		$("#txtSenderAddress").val(jsonObj.address);
		$("#txtSenderContactNo").val(jsonObj.phone);
		$("#txtSenderCity").val(jsonObj.station_name);
		$("#txtSenderIDNo").val(jsonObj.identification_number);
		$("#hdCustomerPercentDiscount").val(jsonObj.percentage_discount);
		$("#min1").hide();
	});
}

var showDialog = function( containerId, msgContainerId, msg ){
	$("#" + msgContainerId).html(msg);
	//$("#" + containerId).dialog('open');
	$("#" + containerId).bPopup();
	/*
	$("#" + containerId).bPopup({
		modalClose: true,
		opacity: 0.6,
		positionStyle: 'fixed' //'fixed' or 'absolute'
	});
	*/
};

function lam(a) {
	document.getElementById("rcustomer").value=a;
	document.getElementById("min").style.display="none";
}

function lam1(a) {
	document.getElementById("customer").value = a;
	document.getElementById("min1").style.display = "none";
}

function hideElement(str) {
	document.getElementById(str).style.display = "none";
}

function fun() {
	document.getElementById('cus').style.display="block";
	document.getElementById('hide').style.display="block";
}
function fun1() {
	document.getElementById('cus').style.display="none";
	document.getElementById('hide').style.display="none";
}

