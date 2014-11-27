<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="UTF-8">
	<title>Cargo King Branches</title>
	<link rel="stylesheet" href="css/styleMenu.css">
	<link rel="stylesheet" href="css/bodyAndHeader.css">
	<link rel="stylesheet" href="css/aboutCargoKing.css">
	<link rel="stylesheet" href="css/branches.css">
	<link rel="stylesheet" href="css/contactUs.css">
	<link rel="stylesheet" href="css/footer.css">

	<script src="biya4u/js/jquery-1.11.1.min.js"></script>
	<script src="biya4u/js/jquery.bxslider.min.js"></script>
	<script src="biya4u/js/jquery.bpopup.min.js"></script>
	<script src="js/menu.js"></script>

	<script>
		var	SCROLL_TOP_LIMIT=126;
		$(function() {
			var par = $('#loginForm');
			$('#loginForm').hide();
			$('#loginMenu').click (function() {
				$('#loginForm').toggle();
				$(this).parent().css({'z-index' : '999'});
			});

			$("#menuContainerDiv").wrap("<div class=\"menuPlaceholder\"></div>");
			$(".menuPlaceholder").height($("#menuContainerDiv").outerHeight());
		});

		$(document).scroll(function(evt){
    		showFloatingMenu(SCROLL_TOP_LIMIT);
     	});
	</script>
</head>
	<body id="branchesPage">
		<center>
			<div class="headerContainer" align="left">
				<?php include('headerFlat.php'); ?>
			</div> <!-- end of hearderContainter -->
			<div id="menuContainerDiv" class="menuContainer"> 
				<?php include('menuFlat.php'); ?>
			</div>
			<div class="stationContainer">
				<div id="manila" class="manilaStationContainer">
					<h5>Manila Stations</h5>
					<div>
					<span onclick="alert('Ulalam!')">Paranaque</span>
					<span onclick="alert('Ulalam!')">Pasay</span>
					<span onclick="alert('Ulalam!')">Las Piñas</span>
					<span onclick="alert('Ulalam!')">Alabang</span>
					<span onclick="alert('Ulalam!')">Manila</span>
					<span onclick="alert('Ulalam!')">Paco</span>
					<span onclick="alert('Ulalam!')">Sta. Ana</span>
					<span onclick="alert('Ulalam!')">Boni</span>
					<span onclick="alert('Ulalam!')">Mandaluyong</span>
					<span onclick="alert('Ulalam!')">Ortigas</span>
					<span onclick="alert('Ulalam!')">Pasig</span>
					<span onclick="alert('Ulalam!')">Cubao</span>
					<span onclick="alert('Ulalam!')">Cordova</span>
					<span onclick="alert('Ulalam!')">Caloocan</span>
					<span onclick="alert('Ulalam!')">Malabon</span>
					<span onclick="alert('Ulalam!')">Novaliches</span>
					<span onclick="alert('Ulalam!')">Marikina</span>
					<span onclick="alert('Ulalam!')">San Juan</span>
					<span onclick="alert('Ulalam!')">Makati</span>
					<span onclick="alert('Ulalam!')">Fairview</span>
					<span onclick="alert('Ulalam!')">San Mateo</span>
					<span onclick="alert('Ulalam!')">Valenzuela</span>
					<span onclick="alert('Ulalam!')">Laguna</span>
					<span onclick="alert('Ulalam!')">Cavite / Silang</span>
					<span onclick="alert('Ulalam!')">Bulacan</span>
					<span onclick="alert('Ulalam!')">Antipolo Cainta</span>
					<span onclick="alert('Ulalam!')">Cogeo</span>
					<span onclick="alert('Ulalam!')">Taytay</span>
					<span onclick="alert('Ulalam!')">Batangas</span>
					<span onclick="alert('Ulalam!')">Rizal</span>
					<span onclick="alert('Ulalam!')">Angono</span>
					<span onclick="alert('Ulalam!')">Montalban</span>
					<span onclick="alert('Ulalam!')">GMA</span></div></div>
				<div class="zamboangaStationContainer">
					<h5>Zamboanga Stations</h5>
					<div>
					<span onclick="alert('Ulalam!')">Baliwasan</span>
					<span onclick="alert('Ulalam!')">San Jose</span>
					<span onclick="alert('Ulalam!')">Calarian</span>
					<span onclick="alert('Ulalam!')">South Village</span>
					<span onclick="alert('Ulalam!')">Sununuc</span>
					<span onclick="alert('Ulalam!')">Suterville</span>
					<span onclick="alert('Ulalam!')">Canelar Moret</span>
					<span onclick="alert('Ulalam!')">Buena Vista</span>
					<span onclick="alert('Ulalam!')">Sucabon</span>
					<span onclick="alert('Ulalam!')">Mayor Jaldon</span>
					<span onclick="alert('Ulalam!')">Pilar Street</span>
					<span onclick="alert('Ulalam!')">Tugbungan</span>
					<span onclick="alert('Ulalam!')">Tetuan</span>
					<span onclick="alert('Ulalam!')">Guiwan</span>
					<span onclick="alert('Ulalam!')">Putik</span>
					<span onclick="alert('Ulalam!')">Divisoria</span>
					<span onclick="alert('Ulalam!')">Boalan</span>
					<span onclick="alert('Ulalam!')">Zambowood</span>
					<span onclick="alert('Ulalam!')">Luyahan</span>
					<span onclick="alert('Ulalam!')">Tumaga</span>
					<span onclick="alert('Ulalam!')">Pasonanca</span>
					<span onclick="alert('Ulalam!')">Sta. Maria</span>
					<span onclick="alert('Ulalam!')">San Roque</span>
					<span onclick="alert('Ulalam!')">Ayala</span>
					<span onclick="alert('Ulalam!')">Labuan</span>
					<span onclick="alert('Ulalam!')">Culianan</span>
					<span onclick="alert('Ulalam!')">Mercedez</span>
					<span onclick="alert('Ulalam!')">Cabaluay</span>
					<span onclick="alert('Ulalam!')">Victoria</span>
					<span onclick="alert('Ulalam!')">Bolong</span>
					<span onclick="alert('Ulalam!')">Manicahan</span>
					<span onclick="alert('Ulalam!')">Sanggali</span>
					</div>
				</div>
				<div class="cagayanStationContainer">
					<h5>Cagayan de Oro Stations</h5>
					<div>
					<span onclick="alert('Ulalam!')">Aluba</span>
					<span onclick="alert('Ulalam!')">Agora</span>
					<span onclick="alert('Ulalam!')">Bonbon</span>
					<span onclick="alert('Ulalam!')">Bugo</span>
					<span onclick="alert('Ulalam!')">Balua</span>
					<span onclick="alert('Ulalam!')">Canitoan</span>
					<span onclick="alert('Ulalam!')">Carmen</span>
					<span onclick="alert('Ulalam!')">Cogon</span>
					<span onclick="alert('Ulalam!')">Cugman</span>
					<span onclick="alert('Ulalam!')">Divisoria</span>
					<span onclick="alert('Ulalam!')">Kauswagan</span>
					<span onclick="alert('Ulalam!')">Lapasan</span>
					<span onclick="alert('Ulalam!')">Landfill</span>
					<span onclick="alert('Ulalam!')">Patag</span>
					<span onclick="alert('Ulalam!')">Taguano</span>
					<span onclick="alert('Ulalam!')">Lumbia</span>
					<span onclick="alert('Ulalam!')">Baloy</span>
					<span onclick="alert('Ulalam!')">Velez</span>
					<span onclick="alert('Ulalam!')">Puerto</span>
					<span onclick="alert('Ulalam!')">Xavier Heights</span>
					<span onclick="alert('Ulalam!')">Zayas</span>
					<span onclick="alert('Ulalam!')">San Simon</span>
					<span onclick="alert('Ulalam!')">San Agustin</span>
					<span onclick="alert('Ulalam!')">Nazareth</span>
					<span onclick="alert('Ulalam!')">Balongis</span>
					<span onclick="alert('Ulalam!')">Maasin</span>
					<span onclick="alert('Ulalam!')">PN Roa</span>
					<span onclick="alert('Ulalam!')">Indahag</span></div></div>
				<div class="butuanStationContainer">
					<h5> Butuan Stations</h5>
					<div>
					<span onclick="alert('Ulalam!')">Amparo</span>
					<span onclick="alert('Ulalam!')">Anticala</span>
					<span onclick="alert('Ulalam!')">Antongalon</span>
					<span onclick="alert('Ulalam!')">Aupagan</span>
					<span onclick="alert('Ulalam!')">Baobaoan</span>
					<span onclick="alert('Ulalam!')">Basag</span>
					<span onclick="alert('Ulalam!')">Bilay</span>
					<span onclick="alert('Ulalam!')">Bitan-agan</span>
					<span onclick="alert('Ulalam!')">Bonbon</span>
					<span onclick="alert('Ulalam!')">Bugsukan</span>
					<span onclick="alert('Ulalam!')">Camayahan</span>
					<span onclick="alert('Ulalam!')">Dankias</span>
					<span onclick="alert('Ulalam!')">DE ORO De Oro</span>
					<span onclick="alert('Ulalam!')">Don Francisco</span>
					<span onclick="alert('Ulalam!')">Dulag</span>
					<span onclick="alert('Ulalam!')">Florida</span>
					<span onclick="alert('Ulalam!')">Los Angeles</span>
					<span onclick="alert('Ulalam!')">M.J. Santos</span>
					<span onclick="alert('Ulalam!')">Maguinda</span>
					<span onclick="alert('Ulalam!')">Maibu</span>
					<span onclick="alert('Ulalam!')">Mandamo</span>
					<span onclick="alert('Ulalam!')">Manila de Bugabus</span>
					<span onclick="alert('Ulalam!')">Nongnong</span>
					<span onclick="alert('Ulalam!')">Pianing</span>
					<span onclick="alert('Ulalam!')">Salvacion</span>
					<span onclick="alert('Ulalam!')">San Mateo</span>
					<span onclick="alert('Ulalam!')">Sikatuna</span>
					<span onclick="alert('Ulalam!')">Sumile</span>
					<span onclick="alert('Ulalam!')">Sumilihon</span>
					<span onclick="alert('Ulalam!')">Taguibo</span>
					<span onclick="alert('Ulalam!')">Taligaman</span>
					<span onclick="alert('Ulalam!')">Tungao</span></div>
				</div>
				<div class="cebuStationContainer">
					<h5>Cebu Stations</h5>
					<div>
					<span onclick="alert('Ulalam!')">Mabolo</span>
					<span onclick="alert('Ulalam!')">Reclamation Area</span>
					<span onclick="alert('Ulalam!')">Reclamacion Area</span>
					<span onclick="alert('Ulalam!')">Mandaue</span>
					<span onclick="alert('Ulalam!')">Cebu City Proper</span>
					<span onclick="alert('Ulalam!')">Lapu-lapu City</span>
					<span onclick="alert('Ulalam!')">Banilad</span>
					<span onclick="alert('Ulalam!')">Talamban</span>
					<span onclick="alert('Ulalam!')">Lahug</span>
					<span onclick="alert('Ulalam!')">Pardo</span>
					<span onclick="alert('Ulalam!')">Marigondon</span>
					<span onclick="alert('Ulalam!')">Maribago</span>
					<span onclick="alert('Ulalam!')">Mactan</span>
					<span onclick="alert('Ulalam!')">Cordova</span>
					<span onclick="alert('Ulalam!')">Colon</span>
					<span onclick="alert('Ulalam!')">Mabolo</span>
					<span onclick="alert('Ulalam!')">Consolacion</span>
					<span onclick="alert('Ulalam!')">Liloan</span>
					<span onclick="alert('Ulalam!')">Talisay City</span>
					<span onclick="alert('Ulalam!')">Naga</span>
					<span onclick="alert('Ulalam!')">Minglanilla</span>
					<span onclick="alert('Ulalam!')">Danao City</span></div></div>
				<div class="tagbilaranStationContainer">
					<h5>Tagbilaran Stations</h5>
					<div>
					<span onclick="alert('Ulalam!')">Albuquerque</span>
					<span onclick="alert('Ulalam!')">Antequera</span>
					<span onclick="alert('Ulalam!')">Baclayon</span>
					<span onclick="alert('Ulalam!')">Corella</span>
					<span onclick="alert('Ulalam!')">Cortes</span>
					<span onclick="alert('Ulalam!')">Dauis</span>
					<span onclick="alert('Ulalam!')">Tagbilaran City</span>
					<span onclick="alert('Ulalam!')">Balilihan</span>
					<span onclick="alert('Ulalam!')">Catigbian</span>
					<span onclick="alert('Ulalam!')">Dimiao</span>
					<span onclick="alert('Ulalam!')">Lila</span>
					<span onclick="alert('Ulalam!')">Luay</span>
					<span onclick="alert('Ulalam!')">Loboc</span>
					<span onclick="alert('Ulalam!')">Loon</span>
					<span onclick="alert('Ulalam!')">Maribojoc</span>
					<span onclick="alert('Ulalam!')">Panglao</span>
					<span onclick="alert('Ulalam!')">Sikatuna</span></div></div>
				<div class="davaoStationContainer">
					<h5>Davao Stations</h5>
					<div>
					<span onclick="alert('Ulalam!')">Obrero</span>
					<span onclick="alert('Ulalam!')">Garcia Heights</span>
					<span onclick="alert('Ulalam!')">Quirino</span>
					<span onclick="alert('Ulalam!')">Guzman Street</span>
					<span onclick="alert('Ulalam!')">Sta. Ana Avenue</span>
					<span onclick="alert('Ulalam!')">Claveria</span>
					<span onclick="alert('Ulalam!')">Uyanguren</span>
					<span onclick="alert('Ulalam!')">Agdao</span>
					<span onclick="alert('Ulalam!')">San Pedro</span>
					<span onclick="alert('Ulalam!')">Rizal</span>
					<span onclick="alert('Ulalam!')">Damosa</span>
					<span onclick="alert('Ulalam!')">Lanang</span>
					<span onclick="alert('Ulalam!')">Buhangin</span>
					<span onclick="alert('Ulalam!')">Cabantian</span>
					<span onclick="alert('Ulalam!')">Milan</span>
					<span onclick="alert('Ulalam!')">R. Castillo</span>
					<span onclick="alert('Ulalam!')">Sasa</span>
					<span onclick="alert('Ulalam!')">Magallanes</span>
					<span onclick="alert('Ulalam!')">Bakerohan</span>
					<span onclick="alert('Ulalam!')">Matina</span>
					<span onclick="alert('Ulalam!')">Bangkal</span>
					<span onclick="alert('Ulalam!')">Boulevard</span>
					<span onclick="alert('Ulalam!')">Mt. Apo</span>
					<span onclick="alert('Ulalam!')">Malvar</span>
					<span onclick="alert('Ulalam!')">Toril</span>
					<span onclick="alert('Ulalam!')">Bunawan</span>
					<span onclick="alert('Ulalam!')">Tibungco</span>
					<span onclick="alert('Ulalam!')">Panacan</span>
					<span onclick="alert('Ulalam!')">Ilang</span>
					<span onclick="alert('Ulalam!')">Ulas</span>
					<span onclick="alert('Ulalam!')">Mintal</span>
					<span onclick="alert('Ulalam!')">Calinan</span>
					<span onclick="alert('Ulalam!')">Catalunan</span>
					<span onclick="alert('Ulalam!')">Iwa</span>
					<span onclick="alert('Ulalam!')">Mulig</span>
					<span onclick="alert('Ulalam!')">Baguio District</span>
					<span onclick="alert('Ulalam!')">Eden</span>
					<span onclick="alert('Ulalam!')">Crossing Bayabas</span>
					<span onclick="alert('Ulalam!')">Lubogan</span>
					<span onclick="alert('Ulalam!')">Daliao</span>
					<span onclick="alert('Ulalam!')">Camansi</span>
					<span onclick="alert('Ulalam!')">Tigatto</span>
					<span onclick="alert('Ulalam!')">Malagos</span>
					<span onclick="alert('Ulalam!')">Marapangi</span>
					<span onclick="alert('Ulalam!')">Talomo</span>
					<span onclick="alert('Ulalam!')">Tugbok</span></div>
					</div>
			</div>
			<div class="footer">
				<?php include('footerFlat.php'); ?>
			</div>
		</center>
	</body>
</html>