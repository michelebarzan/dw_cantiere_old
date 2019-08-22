<?php
	include "Session.php";
	include "connessione.php";
	
	$pageName="Presenze ditte";
	$appName="Cantiere";
?>
<html>
	<head>
		<title><?php echo $appName."&nbsp&#8594&nbsp".$pageName; ?></title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.png" />
		<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
		<script src="struttura.js"></script>
		<script src="presenzeDitte.min.js"></script>
		<link rel="stylesheet" href="css/styleV15.css" />
		<link rel="stylesheet" href="fontawesomepro/css/fontawesomepro.css" />
		<script src="tableToExcel.js"></script>
	</head>
	<body onload="aggiungiNotifica('Stai lavorando sulla commessa <?php echo $_SESSION['commessa']; ?>');getElencoRegistrazioni();">
		<?php include('struttura.php'); ?>
		<div id="hiddenContainerReport"></div>
		<iframe name="print_frame" id="print_frame" width="0" height="0" frameborder="0" src="about:blank"></iframe>
		<!-- Modal duplica -->
		<div id="modalDuplica" class="modal">
			<!-- Modal content -->
			<div class="modal-content">
				<div class="modal-header">
					<button id="closeModalDuplica" class="closeModal" onclick='chiudiPopupDuplica()'></button>
					<h2>Inserisci una nuova data</h2>
				</div>
				<div class="modal-body">
					<input type='date' id='dataDuplicaRegistrazione' class='inputTesto' value='' />
				</div>
				<div class="modal-footer">
					<input type='button' id='btnConfermaModalDuplica' class='btnModal' onclick='duplicaRegistrazione(document.getElementById("dataDuplicaRegistrazione").value);chiudiPopupDuplica()' value='Conferma' />
					<input type='button' id='btnAnnullaModalDuplica' class='btnModal' onclick='chiudiPopupDuplica()' value='Annulla' />
				</div>
			</div>
		</div>
		<!-- Modal nuova -->
		<div id="modalNuova" class="modal">
			<!-- Modal content -->
			<div class="modal-content">
				<div class="modal-header">
					<button id="closeModalNuova" class="closeModal" onclick='chiudiPopupNuova()'></button>
					<h2>Inserisci una data per la nuova registrazione</h2>
				</div>
				<div class="modal-body">
					<input type='date' id='dataNuovaRegistrazione' class='inputTesto' value='' />
				</div>
				<div class="modal-footer">
					<input type='button' id='btnConfermaModalNuova' class='btnModal' onclick='nuovaRegistrazione(document.getElementById("dataNuovaRegistrazione").value);chiudiPopupNuova()' value='Conferma' />
					<input type='button' id='btnAnnullaModalNuova' class='btnModal' onclick='chiudiPopupNuova()' value='Annulla' />
				</div>
			</div>
		</div>
		<!-- Modal aggiungi ditta -->
		<div id="modalAggiungiDitta" class="modal">
			<!-- Modal content -->
			<div class="modal-content">
				<div class="modal-header">
					<button id="closeModalAggiungiDitta" class="closeModal" onclick='chiudiPopupAggiungiDitta()'></button>
					<h2>Scegli la ditta da aggiungere</h2>
				</div>
				<div class="modal-body">
					<select id='selectDitte' class='inputTesto' >
						<option value='' disabled selected>Scegli ditta</option>
						<?php getListaDitte($conn); ?>
					</select>
				</div>
				<div class="modal-footer">
					<input type='button' id='btnConfermaModalAggiungiDitta' class='btnModal' onclick='aggiungiDitta(document.getElementById("selectDitte").value);chiudiPopupAggiungiDitta()' value='Conferma' />
					<input type='button' id='btnAnnullaModalAggiungiDitta' class='btnModal' onclick='chiudiPopupAggiungiDitta()' value='Annulla' />
				</div>
			</div>
		</div>
		<!-- Modal aggiungi ponte -->
		<div id="modalAggiungiPonte" class="modal">
			<!-- Modal content -->
			<div class="modal-content">
				<div class="modal-header">
					<button id="closeModalAggiungiPonte" class="closeModal" onclick='chiudiPopupAggiungiPonte()'></button>
					<h2>Scegli il ponte da aggiungere</h2>
				</div>
				<div class="modal-body">
					<select id='selectPonte' class='inputTesto' >
						<option value='' disabled selected>Scegli ponte</option>
						<option value='gen' >gen</option>
						<option value='pref' >pref</option>
						<?php getListaPonti($conn); ?>
					</select>
				</div>
				<div class="modal-footer">
					<input type='button' id='btnConfermaModalAggiungiPonte' class='btnModal' onclick='aggiungiPonte(document.getElementById("selectPonte").value);chiudiPopupAggiungiPonte()' value='Conferma' />
					<input type='button' id='btnAnnullaModalAggiungiPonte' class='btnModal' onclick='chiudiPopupAggiungiPonte()' value='Annulla' />
				</div>
			</div>
		</div>
		<!-- Modal aggiungi operatore -->
		<div id="modalAggiungiOperatore" class="modal">
			<!-- Modal content -->
			<div class="modal-content">
				<div class="modal-header">
					<button id="closeModalAggiungiOperatore" class="closeModal" onclick='chiudiPopupAggiungiOperatore()'></button>
					<h2>Scegli l' operatore da aggiungere</h2>
				</div>
				<div class="modal-body" id="selectOperatoreContainer"></div>
				<div class="modal-footer">
					<input type='button' id='btnConfermaModalAggiungiOperatore' class='btnModal' onclick='aggiungiOperatore(document.getElementById("selectOperatore").value);chiudiPopupAggiungiOperatore()' value='Conferma' />
					<input type='button' id='btnAnnullaModalAggiungiOperatore' class='btnModal' onclick='chiudiPopupAggiungiOperatore()' value='Annulla' />
				</div>
			</div>
		</div>
		<!-- Modal modifica note registrazione -->
		<div id="modalModificaNoteRegistrazione" class="modal">
			<!-- Modal content -->
			<div class="modal-content">
				<div class="modal-header">
					<button id="closeModalModificaNoteRegistrazione" class="closeModal" onclick='chiudiPopupModificaNoteRegistrazione()'></button>
					<h2>Modifica il testo delle note</h2>
				</div>
				<div class="modal-body">
					<textarea id="textAreaNoteRegistrazione"></textarea>
				</div>
				<div class="modal-footer">
					<input type='button' id='btnConfermaModalModificaNoteRegistrazione' class='btnModal' onclick='modificaNoteRegistrazione(registrazioneVisualizzata,document.getElementById("textAreaNoteRegistrazione").value);chiudiPopupModificaNoteRegistrazione()' value='Conferma' />
					<input type='button' id='btnAnnullaModalModificaNoteRegistrazione' class='btnModal' onclick='chiudiPopupModificaNoteRegistrazione()' value='Annulla' />
				</div>
			</div>
		</div>
		<div id="popupAttivitaGruppo" onmouseout='document.getElementById("popupAttivitaGruppo").style.display="none";'></div>
		<div id="container">
			<div id="content">
				<div id="immagineLogo" class="immagineLogo" ></div>
				<div id="containerPresenzeDitte">
					<div id="elencoRegistrazioni"></div>
					<div id="datiRegistrazione">
						<div id="box1">
							<span id='intestazioneDatiRegistrazione'>Dati registrazione:</span>
							<div id='funzioniRegistrazione'>
								<span>Report: </span>
								<i class="btnFunzioniRegistrazioni far fa-file-excel" title="Report Excel" onclick="reportExcel()"></i>
								<i class="btnFunzioniRegistrazioni far fa-print" title="Stampa report" onclick="stampaReport()"></i>
							</div>
							<div class="titoliElenchi" style="margin-top:17px">
								<div style="width:150px;height:30px;line-height:30px;display:inline-block;float:left;text-align:left;">Ditte coinvolte</div>
								<div style="width:150px;height:30px;display:inline-block;float:right;text-align:right;"><i style="cursor:pointer" title="Aggiungi ditta" onclick="apriPopupAggiungiDitta()" class="fal fa-plus-circle fa-2x"></i></div>
							</div>
							<input type='date' id='dataRegistrazione' class='inputTesto' onfocusout="cambiaDataRegistrazione()" value='' />
							<div id='elencoDitte'></div>
						</div>
						<div class="titoliElenchi" style="margin-top:170px;margin-left:-320px;display:inline-block;float:left;">
							<div style="width:150px;height:30px;line-height:30px;display:inline-block;float:left;text-align:left;">Ponti coinvolti</div>
							<div style="width:150px;height:30px;display:inline-block;float:right;text-align:right;"><i style="cursor:pointer" title="Aggiungi ponte" onclick="apriPopupAggiungiPonte()" class="fal fa-plus-circle fa-2x"></i></div>
						</div>
						<div id='elencoPonti'></div>
						<div class="titoliElenchi" style="margin-left:20px;margin-top:12px">
							<div style="width:150px;height:30px;line-height:30px;display:inline-block;float:left;text-align:left;">Operatori coinvolti</div>
							<div style="width:150px;height:30px;display:inline-block;float:right;text-align:right;"><i style="cursor:pointer" title="Aggiungi operatore" onclick="apriPopupAggiungiOperatore()" class="fal fa-plus-circle fa-2x"></i></div>
						</div>
						<div id='elencoOperatori'></div>
						<div id='divBottoniRegistrazioni'>
							<input type='button' id='btnDuplica' class='btnRegistrazioni' onclick='apriPopupDuplica()' value='Duplica registrazione' />
							<input type='button' id='btnElimina' class='btnRegistrazioni' onclick='eliminaRegistrazione()' value='Elimina registrazione' />
							<input type='button' id='btnNuova' class='btnRegistrazioni' onclick='apriPopupNuova()' value='Nuova registrazione' />
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="push"></div>
		<div id="footer">
			<b>De&nbspWave&nbspS.r.l.</b>&nbsp&nbsp|&nbsp&nbspVia&nbspDe&nbspMarini&nbsp116149&nbspGenova&nbspItaly&nbsp&nbsp|&nbsp&nbspPhone:&nbsp(+39)&nbsp010&nbsp640201
		</div>
	</body>
</html>

<?php

	function getListaDitte($conn)
	{
		$queryPonte="SELECT * FROM cantiere_ditte ORDER BY nome";
		$resultPonte=sqlsrv_query($conn,$queryPonte);
		if($resultPonte==FALSE)
		{
			echo "<br><br>Errore esecuzione query<br>Query: ".$queryPonte."<br>Errore: ";
			die(print_r(sqlsrv_errors(),TRUE));
		}
		else
		{
			while($rowPonte=sqlsrv_fetch_array($resultPonte))
			{
				echo "<option value='".$rowPonte['id_ditta']."' >".$rowPonte['nome']."</option>";
			}
		}
	}
	
	function getListaPonti($conn)
	{
		$queryPonte="SELECT * FROM cantiere_ponti WHERE commessa=".$_SESSION['id_commessa']." ORDER BY ponte";
		$resultPonte=sqlsrv_query($conn,$queryPonte);
		if($resultPonte==FALSE)
		{
			echo "<br><br>Errore esecuzione query<br>Query: ".$queryPonte."<br>Errore: ";
			die(print_r(sqlsrv_errors(),TRUE));
		}
		else
		{
			while($rowPonte=sqlsrv_fetch_array($resultPonte))
			{
				echo "<option value='".$rowPonte['ponte']."' >".$rowPonte['ponte']."</option>";
			}
		}
	}

?>
