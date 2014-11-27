var MAX_CARGO_ITEMS_ALLOWED = 25;
var DEFAULT_WEIGHT_DIVISOR = 3500;

var addCargoDetailsRow = function() {
	var rowCount = $("#tblHawbItems tr").length;
	if( LAST_COLUMN_ITEM_INDEX < MAX_CARGO_ITEMS_ALLOWED){
		appendCargoItemByIndex(++LAST_COLUMN_ITEM_INDEX);
	}
};

var appendCargoItemByIndex = function(str) {
	var sud = parseInt(str) + 0;	

	//Copy options from Type of Shipment Dropdown
	var selectString = "";
	selectString +=  "<option value='-1'>--[Select]--</option>\n";
	for( var i=0; i < jShipmentTypesObj.length; i++ ){
		var objTypeOfShipment = jShipmentTypesObj[i];
		selectString +=  "<option value='" + objTypeOfShipment.value + "'>" + objTypeOfShipment.label + "</option>\n";
	}	

	var strHtml = "";
	strHtml += "    <tr id=\"" + sud + "\">\n";
	strHtml += "		<td>\n";
	strHtml += "			<select id=\"selTypeOfShipment" + sud + "\" name=\"typeOfShipment[]\" style=\"width:200px;\">\n";
	strHtml += "				" + selectString + "\n";
	strHtml += "			</select>\n";
	strHtml += "		</td>\n";
	strHtml += "		<td align=\"center\"><input type=\"text\" id=\"txtQuantity_" + sud + "\" name=\"quantity[]\" size=\"3\" style=\"text-align: center;\" /></td>\n";
	strHtml += "		<td>\n";
	strHtml += "			<input type=\"text\" id=\"txtLength_" + sud + "\" name=\"length[]\" size=\"2\" style=\"text-align:center;\" placeholder=\"L\" onBlur=\"computeDimensionTotal(this);\" />\n";
	strHtml += "			<input type=\"text\" id=\"txtWidth_" + sud + "\" name=\"width[]\" size=\"2\" style=\"text-align:center;\" placeholder=\"W\" onBlur=\"computeDimensionTotal(this);\" />\n";
	strHtml += "			<input type=\"text\" id=\"txtHeight_" + sud + "\" name=\"height[]\" size=\"2\" style=\"text-align:center;\" placeholder=\"H\" onBlur=\"computeDimensionTotal(this);\" />\n"; 
	strHtml += "			<input type=\"text\" id=\"txtDimensionTotal_" + sud + "\" name=\"dimensionTotal[]\" size=\"2\" readonly=\"readonly\" style=\"margin-left: 10px; width: 75px;\" onFocus=\"calculateWeight(this);\" />\n";
	strHtml += "		</td>\n";
	strHtml += "		<td>\n";
	strHtml += "			<input type=\"text\" id=\"txtDimensionWeight_" + sud + "\" name=\"dimensionWeight[]\" class=\"tot\" value=\"\" style=\"width:50px;text-align: center;\" placeholder=\"Volume\" onchange=\"whichEverWeightIsHigher(this);\" readonly=\"readonly\" />\n";
	strHtml += "			<input type=\"text\" id=\"txtActualWeight_" + sud + "\" name=\"actualWeight[]\" class=\"tot\" value=\"\" style=\"margin-left: 10px; width:50px;text-align: center;\" placeholder=\"Actual\" onchange=\"whichEverWeightIsHigher(this);\" />\n";
	strHtml += "			<input type=\"text\" id=\"txtPreferredWeight_" + sud + "\" name=\"preferredWeight[]\" class=\"tot\" value=\"\" style=\"margin-left: 10px; width:35px;text-align: center;  background-color: #eeeeee;\" placeholder=\"KGS\" readonly=\"readonly\" />\n";

	strHtml += "		</td>\n";
	strHtml += "		<td>\n";
	strHtml += "			<input type=\"text\" id=\"txtDeclaredValue_" + sud + "\" name=\"declaredValue[]\" class=\"dc\" value=\"\" style=\"width:80px; text-align: center;\">\n";
	//strHtml += "			<span id=\"btnAddItem" + sud + "\" class=\"addHawbItemButton\" onClick=\"mine('" + sud + "'); hideElement('btnAddItem" + sud + "');\">+</span>\n";
	strHtml += "			<span id=\"btnRemoveItem" + sud + "\" class=\"removeHawbItemButton\" onClick=\"removeCargoItem(this);\">Remove</span>\n";
	strHtml += "		</td>\n";
	strHtml += "	</tr>\n";

	$("#tblHawbItems tbody").append(strHtml);
	$("#hdLastCargoItemIndex").val(LAST_COLUMN_ITEM_INDEX);
};

var calculateCargoItemCharge = function() {
	var MINIMUM_DECLARED_VALUE = 500;
	var FOR_EVERY_AMOUNT = 100;

	var weight_divisor = $("#selDivisor").val() ? Number($("#selDivisor").val()) : DEFAULT_WEIGHT_DIVISOR;
	var totalDeclaredValue = 0;
	var total_weight_value = 0;

	getCargoItemsCount();

	$("#tblHawbItems tr").each(function(){
		var idx = $(this).attr('id');

		var lengthVal = Number($("#txtLength_" + idx).val());
		var widthVal = Number($("#txtWidth_" + idx).val());
		var heightVal = Number($("#txtHeight_" + idx).val());
	
		if( $("#txtLength_" + idx).val() || $("#txtWidth_" + idx).val() || $("#txtHeight_" + idx).val() ) {
			var volumeLWH = lengthVal * widthVal * heightVal;
			$("#txtDimensionTotal_" + idx).val(volumeLWH);
			$("#txtDimensionWeight_" + idx).val( Math.round(volumeLWH/weight_divisor) );
		}
		
		if( Number($("#txtDeclaredValue_" + idx).val()) > 0) {
			var dcVal = Number($("#txtDeclaredValue_" + idx).val());
			var dcCharge = 0;
			if(dcVal > MINIMUM_DECLARED_VALUE){
				dcVal -= MINIMUM_DECLARED_VALUE; //Subtract 500 from the declared value when its value is greater than 500
				dcCharge = parseInt( dcVal / FOR_EVERY_AMOUNT ); //For each 100 pesos in excess of 500 declared value, you add a Php 1 charge.
			}
			totalDeclaredValue += dcCharge;
		}

		var dimensionWeight = Number($("#txtDimensionWeight_" + idx).val());
		var actualWeight    = Number($("#txtActualWeight_"    + idx).val());

		dimensionWeight = isNaN(dimensionWeight) ? 0 : dimensionWeight;
		actualWeight    = isNaN(actualWeight) ? 0    : actualWeight;

		var weight_total = 0;
		if( dimensionWeight > actualWeight )
			weight_total += dimensionWeight;
		else
			weight_total += actualWeight;

		total_weight_value += weight_total;
		$("#txtPreferredWeight_" + idx).val(weight_total);

	});

	total_weight_value = isNaN(total_weight_value) ? 0 : total_weight_value;
	$("#txtTotalWeight").val(total_weight_value);

	//Compute for Total Charges
	var satellite_office = $("#hdDeliveryArea").val();
	var isConnectingRoute  = $('input[name=croute]:checked', '#formNewHawb').val();

	//Re-calculate totals (call total_calc.php)
	$.get("total_calc.php",{ totalWeight: total_weight_value, satellite_office: satellite_office, isConnectingRoute: isConnectingRoute, totalDeclaredValue: totalDeclaredValue}, function(result){
		var jsonObj = JSON && JSON.parse(result) || $.parseJSON(result);
		/*
		console.log("[total_wo_declared_value]: " + jsonObj.total_wo_declared_value);
		console.log("[commission]: " + jsonObj.commission);
		console.log("[amount_due_to_cargoking]: " + jsonObj.amount_due_to_cargoking);
		console.log("[weight_referrence_id]: " + jsonObj.weight_referrence_id);
		*/
		$("#hdWeightReferrenceId").val(jsonObj.weight_referrence_id);
		$("#txtTotalCharges").val(jsonObj.total_price);
		computeDiscountedPrice();
	});
};

var computeDiscountedPrice = function(){
	var discountedPrice = 0;
	var total_charges = !isNaN($("#txtTotalCharges").val()) ? Number($("#txtTotalCharges").val()) : 0;
	var percentage_discount = !isNaN($("#hdCustomerPercentDiscount").val()) ? Number($("#hdCustomerPercentDiscount").val()) : 0;
	var new_amount_due_percentage = 1 - (percentage_discount/100);
	$("#txtDiscountedAmount").val(total_charges * new_amount_due_percentage);
};

var calculateWeight = function(obj) {
	var idx            = $(obj).closest("tr").attr('id');
	var weight_divisor = $("#selDivisor").val() ? Number($("#selDivisor").val()) : DEFAULT_WEIGHT_DIVISOR;
	var lengthVal      = Number($("#txtLength_" + idx).val());
	var widthVal       = Number($("#txtWidth_" + idx).val());
	var heightVal      = Number($("#txtHeight_" + idx).val());

	if( $("#txtLength_" + idx).val() || $("#txtWidth_" + idx).val() || $("#txtHeight_" + idx).val() ) {
		var volumeLWH = lengthVal * widthVal * heightVal;
		var calculatedWeight = Math.round( volumeLWH / weight_divisor );
		$("#txtDimensionTotal_" + idx).val(volumeLWH);
		$("#txtDimensionWeight_" + idx).val(calculatedWeight);
		//$("#txtPreferredWeight_" + idx).val(calculatedWeight);
	}

	whichEverWeightIsHigher(obj);

	//Recompute total weight:
	calculateCargoItemCharge();
};

var removeCargoItem = function(obj){
	var idx = $(obj).closest("tr").attr('id');

	//re-compute total weight (Total Weight - Actual Weight)
	var total_weight_value = Number($("#total_wei").val());
	var actual_weight_value = Number($("#txtActualWeight_" + idx).val());
	var satellite_office = $("#sel_rcity").val();
	var isConnectingRoute  = $("#croute").val();

	total_weight_value -= actual_weight_value;

	//Re-calculate totals (call total_calc.php)
	$.get("total_calc.php",{ totalWeight: total_weight_value, satellite_office: satellite_office, isConnectingRoute: isConnectingRoute}, function(result){
		$("#trTotalCharges").html(result);
	});  

	$(obj).closest('tr').remove();
	getCargoItemsCount();
};

var removeAllCargoItems = function() {
	removeAllTableItems("tblHawbItems");
};

var removeAllTableItems = function(tableObjId) {
	$("#" + tableObjId).find("tr:gt(0)").remove();
};

var computeDimensionTotal = function(obj) {
	var idx = $(obj).closest("tr").attr('id');
	var objLength = $("#txtLength_" + idx);
	var objWidth  = $("#txtWidth_"  + idx);
	var objHeight = $("#txtHeight_" + idx);

	if( objLength.val() && objWidth.val() && objHeight.val() ){
		calculateWeight(obj);
	}
	else if( !objLength.val() && !objWidth.val() && !objHeight.val() ){
		$("#txtDimensionTotal_"  + idx).val('');
		$("#txtDimensionWeight_" + idx).val('');
		$("#txtDeclaredValue_"   + idx).val('');
	}

	whichEverWeightIsHigher(obj);
};

var getCargoItemsCount = function() {
	var noOfItems = $("#tblHawbItems tr").length;
	$("#hdCargoItemsCount").val((noOfItems-1));
};

var whichEverWeightIsHigher = function(obj){
	var idx = $(obj).closest("tr").attr('id');
	var preferredWeight = 0;
	
	var dimensionWeight = Number($("#txtDimensionWeight_" + idx).val());
	var actualWeight = Number($("#txtActualWeight_" + idx).val());

	if( dimensionWeight > actualWeight)
		preferredWeight = dimensionWeight;
	else
		preferredWeight = actualWeight;

	$("#txtPreferredWeight_" + idx).val(preferredWeight);
	getCargoItemsCount();
};

var setDeliveryArea = function() {
	var selected_destination = $("#sel_destination").val();
	var selected_city = $("#sel_rcity").val();
	$.post("delarea.php", {selected_destination: selected_destination, selected_city: selected_city}, function(result){
		$("#divDeliveryArea").html(result); 
	});
};