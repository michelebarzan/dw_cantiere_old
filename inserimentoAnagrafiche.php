<?php
	include "Session.php";
	include "connessione.php";
	
	$pageName="Inserimento anagrafiche";
	$appName="Cantiere";
?>
<html>
	<head>
		<title><?php echo $appName."&nbsp&#8594&nbsp".$pageName; ?></title>
		<link rel="stylesheet" href="css/styleV15.css" />
		<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.png" />
		<script src="struttura.js"></script>
		<script src="js/inserimentoAnagrafiche.js"></script>
		<script src="https://kit.fontawesome.com/4462bc49a0.js" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
		<link rel="stylesheet" href="css/inserimentoAnagrafiche.css" />
		<link rel="stylesheet" href="libs/js/spinners/spinner.css" />
		<script src="libs/js/spinners/spinner.js"></script>
		<script src="editableTable/editableTable.js"></script>
		<link rel="stylesheet" href="editableTable/editableTable.css" />
		<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
	</head>
	<body onload="aggiungiNotifica('Stai lavorando sulla commessa <?php echo $_SESSION['commessa']; ?>')">
		<?php include('struttura.php'); ?>
		<div id="immagineLogo" class="immagineLogo" ></div>
		<div class="full-width-action-bar">
			<div class="full-width-action-bar-buttons-container">
				<button class="full-width-action-bar-button" onclick="assegnazioneOperatori()">
					<span>Assegnazione operatori ditte</span>
					<i class="fad fa-hospital-user"></i>
				</button>
				<button class="full-width-action-bar-button" onclick="anagraficaDitte()">
					<span>Anagrafica ditte</span>
					<i class="fad fa-building"></i>
				</button>
				<button class="full-width-action-bar-button" onclick="anagraficaOperatori()">
					<span>Anagrafica operatori</span>
					<i class="fad fa-user-plus"></i>
				</button>
			</div>
        </div>
		<div class="reusable-control-bar" id="actionBarInserimentoAnagrafiche"></div>
		<div id="containerAnagrafiche"></div>
		<div id="footer">
			<b>De&nbspWave&nbspS.r.l.</b>&nbsp&nbsp|&nbsp&nbspVia&nbspDe&nbspMarini&nbsp116149&nbspGenova&nbspItaly&nbsp&nbsp|&nbsp&nbspPhone:&nbsp(+39)&nbsp010&nbsp640201
		</div>
	</body>
	<script src="libs/js/jquery-ui.js"></script>
	<script src="libs/js/multiple-select/multiple-select.min.js"></script>
	<script src="libs/js/multiple-select/multiple-select-it-IT.js"></script>
	<link rel="stylesheet" href="libs/js/multiple-select/multiple-select.min.css">
</html>





