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
		<link rel="stylesheet" href="fontawesomepro/css/fontawesomepro.css" />
		<script>
			function anagraficaDitte()
			{
				document.getElementById('containerAnagrafiche').innerHTML='';
				document.getElementById("btnFunctionListAnagraficaOperatori").classList.remove("btnFunctionListActive");
				document.getElementById("btnFunctionListAnagraficaOperatori").className="btnFunctionList";
				document.getElementById("btnFunctionListAnagraficaDitte").classList.remove("btnFunctionList");
				document.getElementById("btnFunctionListAnagraficaDitte").className="btnFunctionListActive";
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						if(this.responseText.indexOf("Error")!=-1 || this.responseText.indexOf("Notice")!=-1)
						{
							window.alert("Errore di sistema. Se il problema persiste contattare l' amministratore");
							console.log(this.responseText);
						}
						else
						{
							document.getElementById('containerAnagrafiche').innerHTML=this.responseText;
						}
					}
				};
				xmlhttp.open("POST", "getAnagraficaDitte.php?", true);
				xmlhttp.send();
			}
			function salvaModificheDitta(id_ditta)
			{
				document.getElementById('risultato'+id_ditta).innerHTML="";
				var nome=document.getElementById("nomeAnagrafica"+id_ditta).innerHTML;
				var indirizzo=document.getElementById("indirizzoAnagrafica"+id_ditta).innerHTML;
				var localita=document.getElementById("localitaAnagrafica"+id_ditta).innerHTML;
				var provincia=document.getElementById("provinciaAnagrafica"+id_ditta).innerHTML;
				var cap=document.getElementById("capAnagrafica"+id_ditta).innerHTML;
				var riferimento=document.getElementById("riferimentoAnagrafica"+id_ditta).innerHTML;
				var telefono=document.getElementById("telefonoAnagrafica"+id_ditta).innerHTML;
				var cellulare=document.getElementById("cellulareAnagrafica"+id_ditta).innerHTML;
				if(nome=='')
					document.getElementById('risultato'+id_ditta).innerHTML='<i title="Il campo nome è obbligatorio" class="fas fa-exclamation-triangle"></i>';
				else
				{				
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() 
					{
						if (this.readyState == 4 && this.status == 200) 
						{
							if(this.responseText=="ok")
							{
								document.getElementById('risultato'+id_ditta).innerHTML='<i class="fas fa-check" title="Ditta modificata"></i>';
								setTimeout(function(){ document.getElementById('risultato'+id_ditta).innerHTML='';}, 5000);
							}
							else
							{
								document.getElementById('risultato'+id_ditta).innerHTML='<i class="fas fa-exclamation-triangle"  title="Errore di sistema. Se il problema persiste contattare l amministratore"></i>';
								setTimeout(function(){ document.getElementById('risultato'+id_ditta).innerHTML='';}, 10000);
								console.log(this.responseText);
							}
						}
					};
					xmlhttp.open("POST", "salvaModificheDitta.php?id_ditta="+id_ditta+"&nome="+nome+"&indirizzo="+indirizzo+"&localita="+localita+"&provincia="+provincia+"&cap="+cap+"&riferimento="+riferimento+"&telefono="+telefono+"&cellulare="+cellulare, true);
					xmlhttp.send();
				}
			}
			function inserisciDitta()
			{
				document.getElementById('risultatoNuovaAnagrafica').innerHTML="";
				var nome=document.getElementById("nomeNuovaAnagrafica").innerHTML;
				var indirizzo=document.getElementById("indirizzoNuovaAnagrafica").innerHTML;
				var localita=document.getElementById("localitaNuovaAnagrafica").innerHTML;
				var provincia=document.getElementById("provinciaNuovaAnagrafica").innerHTML;
				var cap=document.getElementById("capNuovaAnagrafica").innerHTML;
				var riferimento=document.getElementById("riferimentoNuovaAnagrafica").innerHTML;
				var telefono=document.getElementById("telefonoNuovaAnagrafica").innerHTML;
				var cellulare=document.getElementById("cellulareNuovaAnagrafica").innerHTML;
				if(nome=='')
					document.getElementById('risultatoNuovaAnagrafica').innerHTML='<i title="Il campo nome è obbligatorio" class="fas fa-exclamation-triangle"></i>';
				else
				{				
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() 
					{
						if (this.readyState == 4 && this.status == 200) 
						{
							if(this.responseText=="ok")
							{
								document.getElementById('risultatoNuovaAnagrafica').innerHTML='<i class="fas fa-check" title="Ditta inserita"></i>';
								anagraficaDitte();
							}
							else
							{
								document.getElementById('risultatoNuovaAnagrafica').innerHTML='<i class="fas fa-exclamation-triangle"  title="Errore di sistema. Se il problema persiste contattare l amministratore"></i>';
								setTimeout(function(){ document.getElementById('risultatoNuovaAnagrafica').innerHTML='';}, 10000);
								console.log(this.responseText);
							}
						}
					};
					xmlhttp.open("POST", "inserisciDitta.php?nome="+nome+"&indirizzo="+indirizzo+"&localita="+localita+"&provincia="+provincia+"&cap="+cap+"&riferimento="+riferimento+"&telefono="+telefono+"&cellulare="+cellulare, true);
					xmlhttp.send();
				}
			}
			function anagraficaOperatori()
			{
				document.getElementById('containerAnagrafiche').innerHTML='';
				document.getElementById("btnFunctionListAnagraficaDitte").classList.remove("btnFunctionListActive");
				document.getElementById("btnFunctionListAnagraficaDitte").className="btnFunctionList";
				document.getElementById("btnFunctionListAnagraficaOperatori").classList.remove("btnFunctionList");
				document.getElementById("btnFunctionListAnagraficaOperatori").className="btnFunctionListActive";
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						if(this.responseText.indexOf("Error")!=-1 || this.responseText.indexOf("Notice")!=-1)
						{
							window.alert("Errore di sistema. Se il problema persiste contattare l' amministratore");
							console.log(this.responseText);
						}
						else
						{
							document.getElementById('containerAnagrafiche').innerHTML=this.responseText;
						}
					}
				};
				xmlhttp.open("POST", "getAnagraficaOperatori.php?", true);
				xmlhttp.send();
			}
			function salvaModificheOperatore(id_operatore)
			{
				document.getElementById('risultato'+id_operatore).innerHTML="";
				var nome=document.getElementById("nomeAnagrafica"+id_operatore).innerHTML;
				var cognome=document.getElementById("cognomeAnagrafica"+id_operatore).innerHTML;
				var ditta=document.getElementById("dittaAnagrafica"+id_operatore).value;
				var ore=document.getElementById("oreAnagrafica"+id_operatore).innerHTML;
				var note=document.getElementById("noteAnagrafica"+id_operatore).innerHTML;
				if(nome=='' || cognome=='' || ditta=='' || ore=='')
					document.getElementById('risultato'+id_operatore).innerHTML='<i title="I campi nome, cognome, ditta, ore sono obbligatori" class="fas fa-exclamation-triangle"></i>';
				else
				{				
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() 
					{
						if (this.readyState == 4 && this.status == 200) 
						{
							if(this.responseText=="ok")
							{
								document.getElementById('risultato'+id_operatore).innerHTML='<i class="fas fa-check" title="Operatore modificato"></i>';
								setTimeout(function(){ document.getElementById('risultato'+id_operatore).innerHTML='';}, 5000);
							}
							else
							{
								document.getElementById('risultato'+id_operatore).innerHTML='<i class="fas fa-exclamation-triangle"  title="Errore di sistema. Se il problema persiste contattare l amministratore"></i>';
								setTimeout(function(){ document.getElementById('risultato'+id_operatore).innerHTML='';}, 10000);
								console.log(this.responseText);
							}
						}
					};
					xmlhttp.open("POST", "salvaModificheOperatore.php?id_operatore="+id_operatore+"&nome="+nome+"&cognome="+cognome+"&ditta="+ditta+"&ore="+ore+"&note="+note, true);
					xmlhttp.send();
				}
			}
			function inserisciOperatore()
			{
				document.getElementById('risultatoNuovaAnagrafica').innerHTML='';
				var nome=document.getElementById("nomeNuovaAnagrafica").innerHTML;
				var cognome=document.getElementById("cognomeNuovaAnagrafica").innerHTML;
				var ditta=document.getElementById("dittaNuovaAnagrafica").value;
				var ore=document.getElementById("oreNuovaAnagrafica").innerHTML;
				var note=document.getElementById("noteNuovaAnagrafica").innerHTML;
				if(nome=='' || cognome=='' || ditta=='' || ore=='')
					document.getElementById('risultatoNuovaAnagrafica').innerHTML='<i title="I campi nome, cognome, ditta, ore sono obbligatori" class="fas fa-exclamation-triangle"></i>';
				else
				{
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() 
					{
						if (this.readyState == 4 && this.status == 200) 
						{
							if(this.responseText=="ok")
							{
								console.log(this.responseText);
								document.getElementById('risultatoNuovaAnagrafica').innerHTML='<i class="fas fa-check" title="Operatore inserito"></i>';
								anagraficaOperatori();
							}
							else
							{
								document.getElementById('risultatoNuovaAnagrafica').innerHTML='<i class="fas fa-exclamation-triangle"  title="Errore di sistema. Se il problema persiste contattare l amministratore"></i>';
								setTimeout(function(){ document.getElementById('risultatoNuovaAnagrafica').innerHTML='';}, 10000);
								console.log(this.responseText);
							}
						}
					};
					xmlhttp.open("POST", "inserisciOperatore.php?nome="+nome+"&cognome="+cognome+"&ditta="+ditta+"&ore="+ore+"&note="+note, true);
					xmlhttp.send();
				}
			}
			function process(e) 
			{
				var code = (e.keyCode ? e.keyCode : e.which);
				if (code == 13) 
				{
					document.getElementById('containerAnagrafiche').focus();
				}
				if (code == 27) 
				{
					//window.alert("esc");
				}
				if (code == 32) 
				{
					//window.alert("spazio");
				}
				if (code == 08) 
				{
					//window.alert("bksp");
				}
				if (code == 18) 
				{
					//window.alert("alt");
				}
				if (code == 17) 
				{
					//window.alert("ctrl");
				}
				if (code == 115) 
				{
					//window.alert("f4");
					//window.open('http://www.google.com');
				}
				if (code == 46) 
				{
					//window.alert("canc");
				}
			}
		</script>
	</head>
	<body onload="aggiungiNotifica('Stai lavorando sulla commessa <?php echo $_SESSION['commessa']; ?>')">
		<?php include('struttura.php'); ?>
		<div id="container">
			<div id="content">
				<div id="immagineLogo" class="immagineLogo" ></div>
				<div class="funcionListContainer">
					<div class="functionList">
						<button class="btnFunctionList" id="btnFunctionListAnagraficaDitte" onclick="anagraficaDitte()"><span>Anagrafica ditte<i class="far fa-building" style="margin-left:10px;"></i></span></button>
						<button class="btnFunctionList" id="btnFunctionListAnagraficaOperatori" onclick="anagraficaOperatori()"><span>Anagrafica operatori<i class="far fa-user-plus" style="margin-left:10px;"></i></span></button>
					</div>
				</div>
				<div id="containerAnagrafiche"></div>
			</div>
		</div>
		<div id="push"></div>
		<div id="footer">
			<b>De&nbspWave&nbspS.r.l.</b>&nbsp&nbsp|&nbsp&nbspVia&nbspDe&nbspMarini&nbsp116149&nbspGenova&nbspItaly&nbsp&nbsp|&nbsp&nbspPhone:&nbsp(+39)&nbsp010&nbsp640201
		</div>
	</body>
</html>





