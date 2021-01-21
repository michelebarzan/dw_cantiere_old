<?php
	include "Session.php";
	include "connessione.php";
	
	echo "<input type='hidden' id='filtroDeck1' value='".$_POST['filtroDeck1']."' />";
	echo "<input type='hidden' id='filtroFZ1' value='".$_POST['filtroFZ1']."' />";
	echo "<input type='hidden' id='filtroGruppo1' value='".$_POST['filtroGruppo1']."' />";

	//cancellaGrigliaWeb_1($conn);
	//creaGrigliaWeb_1($conn);
	
	function cancellaGrigliaWeb_1($conn)
	{
		$queryColonne="DROP VIEW grigliaWeb_1";
		$resultColonne=sqlsrv_query($conn,$queryColonne);
		/*if($resultColonne==FALSE)
		{
			echo "<br><br>Errore esecuzione query<br>Query: ".$queryColonne."<br>Errore: ";
			die(print_r(sqlsrv_errors(),TRUE));
		}*/
	}
	function creaGrigliaWeb_1($conn)
	{
		$queryColonne="CREATE VIEW grigliaWeb_1 AS SELECT dbo.[tip cab].Deck, dbo.[tip cab].FZ, dbo.view_tblInternaCabineAttivita.* FROM dbo.view_tblInternaCabineAttivita INNER JOIN dbo.[tip cab] ON dbo.view_tblInternaCabineAttivita.NCabina = dbo.[tip cab].[Nr# Cabina  Santarossa] ";
		$resultColonne=sqlsrv_query($conn,$queryColonne);
		if($resultColonne==FALSE)
		{
			echo "<br><br>Errore esecuzione query<br>Query: ".$queryColonne."<br>Errore: ";
			die(print_r(sqlsrv_errors(),TRUE));
		}
	}
	
?>
<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="js/prg.js"></script>
		<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.33.1/dist/sweetalert2.min.js"></script>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@7.33.1/dist/sweetalert2.min.css">
		<link rel="stylesheet" href="fontawesomepro/css/fontawesomepro.css" />
		<title>Prg cantiere</title>
		<link rel="stylesheet" href="css/stylePrgV8.css" />
		<script>
			
		</script>
	</head>
	<body onload="checkCookies();">
		<div id="popupAttivitaGruppo" onmouseout='document.getElementById("popupAttivitaGruppo").style.display="none";'></div>
		<div id="containerProgressBar">
			<div id="middle">
				<div id="inner">
					<div id="spinnerContainerProgressBar"></div>
					<div id="messagesProgressBar">
						<div id="message1">L' operazione puo durare 4 minuti.<div id="timer"><label id="minutes">00</label>:<label id="seconds">00</label></div></div>
						<div id="message2" onclick="gotopath('gestionePrg.php')">Problemi? ricarica la pagina</div>
					</div>
					<!--<div id="statusProgressBar">
						<div id="progressPC"></div>%
						<div id="nCelle"></div>
					</div>
					<div id="progressBar">
						<div id="bar" style="width:0%"></div>
					</div>
					<div id="messagesProgressBar">
						<div id="message1">L' operazione puo durare 4 minuti.<div id="timer"><label id="minutes">00</label>:<label id="seconds">00</label></div></div>
						<div id="message2" onclick="gotopath('gestionePrg.php')">Problemi? ricarica la pagina</div>
					</div>-->
				</div>
			</div>
		</div>
		<div id="container">
			<div id="tabella"></div>
		</div>
	</body>
</html>