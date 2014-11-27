<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="UTF-8">
	<title>Locate Cargo King Branches</title>
	<link rel="stylesheet" href="css/styleMenu.css">
	<link rel="stylesheet" href="css/bodyAndHeader.css">
	<link rel="stylesheet" href="css/aboutCargoKing.css">
	<link rel="stylesheet" href="css/branches.css">
	<link rel="stylesheet" href="css/contactUs.css">
	<link rel="stylesheet" href="css/footer.css">
    <style>
      h1 {
      	font-family: "OpenSanRegular";

      }
      #map_canvas {
        width: 600px;
        height: 400px;
        background-color: #ddd;
        border: 5px solid #1A1F24;
        border-radius: 10px;
        display: inline-block;
      }
      .mainContainer {
      	width: 1200px;
      }
      .branchContainers {
      	border: 5px solid #1A1F24;
      	width: 200px;
      	height: 400px;
      	overflow-y: auto;
      	display: inline-block;
      	margin-right: 10px;
      	background-color: #ddd;
      }
      span.branch {
      	font-family: "OpenSanRegular";
      	font-size: 12px;
      	font-weight: bold;
      	color: #003366;
      	padding: 10px;
      	display: block;
      }
      span.branch:hover {
      	color: #1A1F24;
      	background-color: #8099B2;
      }
      div > span.branch:not(:last-child) {
      	border-bottom: 1px dashed #999;
      }
    </style>
	<script src="biya4u/js/jquery-1.11.1.min.js"></script>
	<script src="biya4u/js/jquery.bxslider.min.js"></script>
	<script src="biya4u/js/jquery.bpopup.min.js"></script>
	<script src="js/menu.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js"></script>
	<script>
		var	SCROLL_TOP_LIMIT=126;
		var map;

		$(document).ready(function() {
			var par = $('#loginForm');
			$('#loginForm').hide();
			$('#loginMenu').click (function() {
				$('#loginForm').toggle();
				$(this).parent().css({'z-index' : '999'});
			});

			$("#menuContainerDiv").wrap("<div class=\"menuPlaceholder\"></div>");
			$(".menuPlaceholder").height($("#menuContainerDiv").outerHeight());

			getLocation();
		});

		$(document).scroll(function(evt){
		  	showFloatingMenu(SCROLL_TOP_LIMIT);
     	});

		var initializeMap = function(lat, lng) {
			var dlat = 7.102010;
			var dlng = 125.614683;
			var zoom = 12;

			if(lat) dlat = lat;
			if(lng) dlng = lng;
			if(lat && lng) zoom = 15;

			var mapCanvas = document.getElementById('map_canvas');
			var mapOptions = {
				center: new google.maps.LatLng(dlat, dlng),
				zoom: zoom,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			}
			map = new google.maps.Map(mapCanvas, mapOptions);

			if(lat && lng) {
				var mrkCurrent = new google.maps.Marker({
					position: new google.maps.LatLng(dlat, dlng),
					map: map,
					icon: 'https://maps.google.com/mapfiles/kml/shapes/info-i_maps.png',
					title: 'Your current location.'
				});
			}

			/* START: Setup Markers */
			var mrkDsti = new google.maps.Marker({
				position: new google.maps.LatLng(7.102010, 125.614683),
				map: map,
				title: 'John Gold Group of Companies, DSTI Building, Watusi St., Buhangin'
			});
			var mrkAbreeza = new google.maps.Marker({
				position: new google.maps.LatLng(7.091087, 125.611312),
				map: map,
				title: 'Cargo King Abreeza Branch'
			});
			var mrkGGrandIlustre = new google.maps.Marker({
				position: new google.maps.LatLng(7.069388,125.606227),
				map: map,
				title: 'Cargo King Gaisano Grand Ilustre Davao Branch'
			});
			var mrkGmallBajada = new google.maps.Marker({
				position: new google.maps.LatLng(7.077896, 125.614086),
				map: map,
				title: 'Cargo King Gaisano Mall Davao Branch'
			});
			var mrkNcccMall = new google.maps.Marker({
				position: new google.maps.LatLng(7.062734,125.593696),
				map: map,
				title: 'Cargo King NCCC Mall Davao Branch'
			});
			var mrkSMPremier = new google.maps.Marker({
				position: new google.maps.LatLng(7.098886, 125.630866),
				map: map,
				title: 'Cargo King SM Premier Davao Branch'
			});
			var mrkSMDavao = new google.maps.Marker({
				position: new google.maps.LatLng(7.049616, 125.587975),
				map: map,
				title: 'Cargo King SM Davao Branch'
			});
			var mrkVPDavao = new google.maps.Marker({
				position: new google.maps.LatLng(7.086365, 125.611645),
				map: map,
				title: 'Cargo King Victoria Plaza Davao Branch'
			});
			/* END */
		};

		var loadBranchLocation = function(branchId){
			//TODO: Change this to DB Drive solution
			//send JSON request that will query the latitude and longitude of selected branch by sending branch id as parameter
			//Once you get the LAT & LONG, center the map using these values, also zoom the map to focus the branch location.
			var location;
			var zoom = 15;
			if(branchId == 0){
				//All CK
				location = new google.maps.LatLng(7.102010, 125.614683);
				zoom = 12;
			}
			else if(branchId == 1){
				//Abreeza
				location = new google.maps.LatLng(7.102010, 125.614683);
			}
			else if(branchId == 2){
				//Abreeza
				location = new google.maps.LatLng(7.091087, 125.611312);
			}
			else if(branchId == 3){
				//Gaisano Grand Ilustre
				location = new google.maps.LatLng(7.069388,125.606227);
			}
			else if(branchId == 4){
				//GMALL
				location = new google.maps.LatLng(7.077896, 125.614086);
			} 
			else if(branchId == 5){
				//NCCC Mall
				location = new google.maps.LatLng(7.062734,125.593696);
			} 
			else if(branchId == 6){
				//SM Premier
				location = new google.maps.LatLng(7.098886, 125.630866);
			} 
			else if(branchId == 7){
				//SM Davao
				location = new google.maps.LatLng(7.049616, 125.587975);
			} 
			else if(branchId == 8){
				//Victoria Plaza
				location = new google.maps.LatLng(7.086365, 125.611645);
			}

			if(map && location){
				//set map center and zoom
				map.setCenter(location);
				map.setZoom(zoom);
			}
		};

		function getLocation(){
			if (navigator.geolocation){
				var options = {
					enableHighAccuracy: true,
					timeout: 5000,
					maximumAge: 0
				};
				navigator.geolocation.getCurrentPosition( success, error, options);
			}
			else {
				x.innerHTML= "Geolocation is not supported by this browser.";
			}
		}
		function error(e) {
			console.log("error code:" + e.code + 'message: ' + e.message );
			initializeMap();
		}
		function success(position) {
			var  lat  = position.coords.latitude;
			var  lng =  position.coords.longitude;
			initializeMap(lat, lng);
		}
	</script>
</head>
	<body id="aboutUsPage">
		<center>
			<div class="headerContainer" align="left">
				<?php include('headerFlat.php'); ?>
			</div> <!-- end of hearderContainter -->
			<div id="menuContainerDiv" class="menuContainer"> 
				<?php include('menuFlat.php'); ?>
			</div>
			<div class="paragraphContainer">

				<div class="aboutCargoking">
					<div align="center" class="title">Locate Cargo King Branches (Satellite Offices)</div>
					<div class="branchContainers" align="left">
						<span class="branch" onclick="loadBranchLocation(0);">All Cargo King Davao</span>
						<span class="branch" onclick="loadBranchLocation(2);">ABREEZA Davao</span>
						<span class="branch">Boulevard Davao</span>
						<span class="branch">Buhangin Davao</span>
						<span class="branch">Claveria Davao</span>
						<span class="branch">DIA Lanang Davao</span>
						<span class="branch" onclick="loadBranchLocation(1);">John Gold HQ Davao</span>
						<span class="branch">Ecoland Matina Davao</span>
						<span class="branch" onclick="loadBranchLocation(3);">Gaisano Grand Davao</span>
						<span class="branch" onclick="loadBranchLocation(4);">GMALL Davao</span>
						<span class="branch">Mintal Davao</span>
						<span class="branch" onclick="loadBranchLocation(5);">NCCC Mall Davao</span>
						<span class="branch" onclick="loadBranchLocation(7);">SM Davao</span>
						<span class="branch" onclick="loadBranchLocation(6);">SM Premier Lanang Davao</span>
						<span class="branch">Toril Davao</span>
						<span class="branch" onclick="loadBranchLocation(8);">Victoria Plaza Davao</span>
						<span class="branch">Uyanguren Davao</span>
						<span class="branch">Apokon Tagum</span>
						<span class="branch">Gaisano Grand Tagum</span>
						<span class="branch">GMALL Tagum</span>
						<span class="branch">NCCC Mall Tagum</span>
					</div>
					<div id="map_canvas"></div>
				</div>
			</div>
			<div class="footer">
				<?php include('footerFlat.php'); ?>
			</div>
		</center>
	</body>
</html>