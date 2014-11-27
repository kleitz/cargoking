<?php
	//Note: It is assumed that you already included db_connect.php in the calling(parent) PHP file.

	/** Method: generateDropdownObject($conn)
	 *  Description: Generate a simple dropdown field based on the given TABLE name, the dropdown object ID/Name will be the NAME value
	 *  Params:
	 *    $table         - String, Table name that will be used in the SQL Query
	 *    $name          - String, Will be used in assigning the dropdown object ID and Name
	 *    $useFieldClass - Boolean, true if form-field class will be used.
	*/
	function generateDropdownObject( $conn, $table, $name, $fieldClass ) {
		$strClass = "";

		if( Isset($fieldClass) ) {
			$strClass = " class= '" . $fieldClass . "'";
		}

		echo "<select id='sel_" . $name . "' name='" . $name . "'" . $strClass . ">";
		echo "<option value=''>--[Select]--</option>";

		$result = mysqli_query($conn,  "SELECT * FROM  ".$table." ORDER BY " . $name . " ASC" );

		if ($result) {
			while( $row = mysqli_fetch_assoc( $result ) ) {
				echo "<option value='" . $row['id'] ."'>" . $row[$name] . "</option>";
			}
		}

		echo "</select>";
	}

	/** Method: generateSelectObject($conn)
	 *  Description: Generate a simple dropdown field based on the given TABLE name, the dropdown object ID/Name will be the NAME value
	 *  Params:
	 *    $tableName         - String, Table name that will be used in the SQL Query
	 *    $columnId          - String, Column that will be used for the option value
	 *    $columnName        - String, Column that will be used for the option label or text
	 *    $columnName        - String, Other filter that will be applied in the SQL Query
	 *    $dropdownName      - String, Will be used in assigning the dropdown object ID and Name
	 *    $useFieldClass - Boolean, true if form-field class will be used.
	*/
	function generateSelectObject( $conn, $tableName, $columnId, $columnName, $otherFilter, $dropdownName, $fieldClass ) {
		$strClass = "";

		if( Isset($fieldClass) ) {
			$strClass = " class= '" . $fieldClass . "'";
		}

		echo "<select id='sel_" . $dropdownName . "' name='" . $dropdownName . "'" . $strClass . ">";
		echo "<option value=''>--[Select]--</option>";

		$SQLSelect = "SELECT $columnId as value, $columnName as label FROM  ".$tableName;

		if( isset($otherFilter) && $otherFilter != "" ) {
			$SQLSelect .= " WHERE ";
			$SQLSelect .= $otherFilter;
		}

		$SQLSelect .= " ORDER BY $columnName ASC";
		
		$result = mysqli_query($conn,  $SQLSelect );
		if ($result) {
			while( $row = mysqli_fetch_assoc( $result ) ) {
				echo "<option value='" . $row['value'] ."'>" . $row['label'] . "</option>";
			}
		}
	
		echo "</select>";
	}

	/** Method: getUserTypeCode()
	 *  Description: Get User Type Code given only the User Type ID
	 *  Params:
	 *    $userTypeId         - Integer, User Type ID
	*/
	function getUserTypeCode( $conn, $userTypeId ){
		$type_code = null;
		$SQLUserType = "select type_code from user_types where id = " . $userTypeId . " limit 1";
		$result = mysqli_query($conn,  $SQLUserType );
		if ($result) {
			$row = mysqli_fetch_assoc( $result );	
		}
		else {
			$type_code = $row['type_code'];
		}
		return $type_code;
	}

	/** Method: getUserType()
	 *  Description: Get User Type given only the User Type ID
	 *  Params:
	 *    $userTypeId         - Integer, User Type ID
	*/
	function getUserType( $conn, $userTypeId ){
		$row = null;
		$SQLUserType = "select type_code from user_types where id = " . $userTypeId . " limit 1";
		$result = mysqli_query($conn,  $SQLUserType );
		if ($result) {
			$row = mysqli_fetch_assoc( $result );
		}
		return $row;
	}

	/** Method: getJSONStations($conn)
	 *  Description: Get List of stations as json object
	*/
	function getJSONStations($conn){
		$SQLStations = "SELECT * FROM area_location";
		$result = mysqli_query($conn,  $SQLStations );
		$strJsonData = "[]";

		if ($result) {
			if( mysqli_num_rows($result) ){
				$strJsonData = "{stationData:[";
			
				$first = true;
				//$rows = mysqli_fetch_assoc( $result );
				while($row = mysqli_fetch_assoc($result)){
					if($first) {
						$first = false;
					} else {
						$strJsonData .= ",";
					}
					$strJsonData .= json_encode($row);
				}
				$strJsonData .= "]}";
			}
		}

		return $strJsonData;
	}

	/** Method: getModeOfPayments($conn)
	 *  Description: Get List of Mode of payments
	*/
	function getModeOfPayments($conn){
		$SQLMOPList = "SELECT * FROM payment_mode";
		$result = mysqli_query($conn,  $SQLMOPList );
		$mopList = array();
		if ($result) {
			while ($row = mysqli_fetch_assoc( $result )){
				$mopList[] = $row;
			}
		}
		return $mopList;
	}

	/** Method: getTypeOfMovement()
	 *  Description: Get List of Type of movements
	*/
	function getTypeOfMovement($conn){
		$SQLMovementList = "SELECT * FROM movement_type";
		$result = mysqli_query($conn,  $SQLMovementList );
		$movementList = array();
		if ($result) {
			while ($row = mysqli_fetch_assoc( $result )){
				$movementList[] = $row;
			}
		}
		return $movementList;
	}

	/** Method: getStations($conn)
	 *  Description: Get List of stations
	*/
	function getStations($conn) {
		$result = mysqli_query($conn,  "SELECT * FROM area_location" );
		$stationList = array();
		if ($result) {
			while ($row = mysqli_fetch_assoc( $result )){
				$stationList[] = $row;
			}
		}
		return $stationList;
	}

	/** Method: getElementByIdFromList()
	 *  Description: Get specific array element from an array using the element's ID as search key.
	 *  Params:
	 *    $list         - Array, array or list to search
	 *    $elementId    - Integer, Element ID to search
	*/
	function getElementByIdFromList( $list, $elementId){
		$element = null;
		foreach($list as $e){
			if( $e["id"] == $elementId ){
				$element = $e;
				break;
			}
		}
		return $element;
	}

	/** Method: getWeightDeliveryArea()
	 *  Description: Get weight delivery are label/text based on the delivery area id.
	 *  Params:
	 *    $delareaId         - String(from request parameter), delivery area ID
	*/
	function getWeightDeliveryArea($delareaId) {
		$deliveryArea = "N/A";
		if($delareaId == "1"){
			$deliveryArea = "Within City";
		}
		else if($delareaId == "2"){
			$deliveryArea = "Outside City";
		}
		else if($delareaId == "3"){
			$deliveryArea = "Excess Baggage Port-Port";
		}
		else if($delareaId == "4"){
			$deliveryArea = "Excess Baggage Door-Door";
		}
		return $deliveryArea;
	}

	/** Method: getStationNameById($conn)
	 *  Description: Get Station or City name, given the station id.
	 *  Params:
	 *    $stationId         - String(from request parameter), Station ID
	*/
	function getStationNameById( $conn, $stationId ){
		$station_name = null;
		$SQLStation = "select id, area_name as station_name from area_location where id = " . $stationId;
		$result = mysqli_query($conn, $SQLStation);
		if ($result) {
			$station = mysqli_fetch_assoc($result);
			$station_name = $station["station_name"];
		}
		return $station_name;
	}

	/** Method: getBranchNameById($conn)
	 *  Description: Get branch or satellite office name, given the branch or satellite office id.
	 *  Params:
	 *    $branchId         - String(from request parameter), Branch or satellite office ID
	*/
	function getBranchNameById( $conn, $branchId ){
		$branch_name = null;
		$SQLBranch = "select id, area as branch_name from delivery_area where id = " . $branchId;
		$result = mysqli_query($conn, $SQLBranch);
		if ($result) {
			$branch = mysqli_fetch_assoc( $result );	
			$branch_name = $branch["branch_name"];
		}
		return $branch_name;
	}

	/** Method: getAgentNameById($conn)
	 *  Description: Get branch or satellite office name, given the branch agent id.
	 *  Params:
	 *    $agentId         - String(from request parameter), Branch Agent ID
	*/
	function getAgentNameById( $conn, $agentId ){
		$agent_name = null;
		$SQLAgent = "select id, agent_name from vw_satellite_office_agents where id = " . $agentId;
		$result = mysqli_query($conn, $SQLAgent);
		if($result) {
			$agents = mysqli_fetch_assoc($result);
			$agent_name = $agents["agent_name"];
		}
		return $agent_name;
	}

	/** Method: getAssociativeArrayFromSQL($conn, $sql)
	 *  Description: Get associative array from SQL
	 *  Params:
	 *    $conn - Database connection
	 *    $sql  - SQL Statement
	*/
	function getAssociativeArrayFromSQL($conn, $sql){
		$arrayResult = null;
		$rsArray = mysqli_query($conn, $sql);
		if($rsArray) {
			$arrayResult = mysqli_fetch_array($rsArray);	
		}
		return $arrayResult;
	}

	function string_boolean($string){
		return ( mb_strtoupper( trim( $string)) === mb_strtoupper ("true")) ? TRUE : FALSE;
	}
?>