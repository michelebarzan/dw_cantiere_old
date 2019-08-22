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
		<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.33.1/dist/sweetalert2.min.js"></script>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@7.33.1/dist/sweetalert2.min.css">
		<link rel="stylesheet" href="fontawesomepro/css/fontawesomepro.css" />
		<title>Prg cantiere</title>
		<link rel="stylesheet" href="css/stylePrgV8.css" />
		<script>
			var cellSelected=[];
			var cabineSelected=[];
			var attivitaSelected=[];
			
			function creaTabella()
			{
				document.getElementById("containerProgressBar").style.display="table";  
				newGridSpinner("Caricamento in corso...","spinnerContainerProgressBar","","","font-size:12px;color:white");
				cellSelected=[];
				cabineSelected=[];
				attivitaSelected=[];
				try
				{
					var l=document.getElementById("myTable").rows.length;
					var Deck=document.getElementById("filtroDeck").value;
					var FZ=document.getElementById("filtroFZ").value;
					var gruppo=document.getElementById("filtroGruppo").value;
				}
				catch
				{
					var Deck=document.getElementById("filtroDeck1").value;
					var FZ=document.getElementById("filtroFZ1").value;
					var gruppo=document.getElementById("filtroGruppo1").value;
				}
				var interval;
				var intervalTime;
				
				var minutesLabel = document.getElementById("minutes");
				var secondsLabel = document.getElementById("seconds");
				var totalSeconds = 0;
				intervalTime=setInterval(setTime, 1000);
				function setTime() 
				{
					++totalSeconds;
					secondsLabel.innerHTML = pad(totalSeconds % 60);
					minutesLabel.innerHTML = pad(parseInt(totalSeconds / 60));
					if(totalSeconds>=230)
						location.reload();
				}

				function pad(val) 
				{
					var valString = val + "";
					if (valString.length < 2) 
					{
						return "0" + valString;
					} 
					else 
					{
						return valString;
					}
				}

				/*var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						var res=this.responseText.split("|");
						var time2=res[0];
						var time=res[1];
						var nCelle=res[2];
						
						document.getElementById("nCelle").innerHTML="Totale: "+nCelle+" celle"; 
						
						document.getElementById("containerProgressBar").style.display="table";  
						document.getElementById("bar").style.width="0%";
						
						var elem = document.getElementById("bar");   
						var width = 0.0;
						interval = setInterval(frame, time2/100);
						function frame() 
						{
							if (width >= 100) 
							{
								clearInterval(interval);
							} 
							else 
							{
								width+=0.2; 
								width2=width.toFixed(1);
								elem.style.width = width2 + '%'; 
								if(Number.isInteger(width2))
									document.getElementById("progressPC").innerHTML = width2+".0";
								else
									document.getElementById("progressPC").innerHTML = width2;
							}
						}
					}
				};
				xmlhttp.open("POST", "getNCelle.php?Deck="+Deck+"&FZ="+FZ+"&gruppo="+ gruppo, true);
				xmlhttp.send();	*/			
				
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						/*var response=this.responseText.split("||SPLIT||");
						document.getElementById("tabella").innerHTML  =  response[1];
						var tabella=document.getElementById("tabella").outerHTML;
						document.getElementById("container").innerHTML=response[0]+tabella;*/
						document.getElementById("tabella").innerHTML  =this.responseText;
						var all = document.getElementsByClassName("attivita");
						for (var i = 0; i < all.length; i++) 
						{
							var height=300;
							all[i].style.height=height+"px";
							all[i].style.maxHeight=height+"px";
							all[i].style.minHeight=height+"px";
							all[i].style.width="40px";
							all[i].style.maxWidth="40px"; 
							all[i].style.minWidth="40px"; 
						}
						if(this.responseText.indexOf('#endofresponse#')>0)
						{
							clearInterval(intervalTime);
							document.getElementById("minutes").innerHTML="00";
							document.getElementById("seconds").innerHTML="00";
							clearInterval(interval);
							document.getElementById("containerProgressBar").style.display="none"; 
						}
					}
				};
				xmlhttp.open("POST", "creaTabella.php?Deck="+Deck+"&FZ="+FZ+"&gruppo="+ gruppo, true);
				xmlhttp.send();
			}
			function setSelezionata(NCabina,Descrizione)
			{
				if(cellSelected.indexOf(NCabina+"|"+Descrizione)==-1)
				{
					cellSelected.push(NCabina+"|"+Descrizione);
					cabineSelected.push(NCabina);
					attivitaSelected.push(Descrizione);
					
					document.getElementById("cell"+NCabina+Descrizione).style.background="#98D7A6";
					document.getElementById("cell"+NCabina+Descrizione).style.cursor="not-allowed";
				}
			}
			function registra()
			{			
				if(cellSelected.length==0)
					window.alert("Nessuna attivita selezionata");
				else
				{
					document.getElementById("btnRegistra").disabled = true;
					var attivitaSelectedUnique=[];
					
					$.each(attivitaSelected, function(z, el)
					{
						if($.inArray(el, attivitaSelectedUnique) === -1) attivitaSelectedUnique.push(el);
					});
					
					var attivitaS=attivitaSelectedUnique.toString();
					var cabineS=cabineSelected.toString();
					var cellS=cellSelected.toString();
					
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() 
					{
						if (this.readyState == 4 && this.status == 200) 
						{
							document.getElementById("btnRegistra").disabled = false;
							if(this.responseText=="ok")
							{
								creaTabella();
							}
							else
								window.alert("Errore"+this.responseText);
						}
					};
					xmlhttp.open("POST", "registraAttivita.php?attivitaS="+attivitaS+"&cabineS="+cabineS+"&cellS="+ cellS, true);
					xmlhttp.send();
				}
			}
			function attivitaGruppo(event)
			{
				var x = event.clientX;
				var y = event.clientY;
				//window.alert("X coords: " + x + ", Y coords: " + y);
				
				try
				{
					var l=document.getElementById("myTable").rows.length;
					var gruppo=document.getElementById("filtroGruppo").value;
				}
				catch
				{
					var gruppo=document.getElementById("filtroGruppo1").value;
				}
				
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						document.getElementById("popupAttivitaGruppo").innerHTML  =  this.responseText;
						document.getElementById("popupAttivitaGruppo").style.left=x;
						document.getElementById("popupAttivitaGruppo").style.top=y;
						document.getElementById("popupAttivitaGruppo").style.display="inline-block";
					}
				};
				xmlhttp.open("POST", "attivitaGruppo.php?gruppo="+gruppo, true);
				xmlhttp.send();
			}
			function gotopath(path)
			{
				window.location = path;
			}
			function fullscreen()
			{
				if ((document.fullScreenElement && document.fullScreenElement !== null) ||    
			   (!document.mozFullScreen && !document.webkitIsFullScreen)) {
				if (document.documentElement.requestFullScreen) {  
				  document.documentElement.requestFullScreen();  
				} else if (document.documentElement.mozRequestFullScreen) {  
				  document.documentElement.mozRequestFullScreen();  
				} else if (document.documentElement.webkitRequestFullScreen) {  
				  document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);  
				}  
			  } else {  
				if (document.cancelFullScreen) {  
				  document.cancelFullScreen();  
				} else if (document.mozCancelFullScreen) {  
				  document.mozCancelFullScreen();  
				} else if (document.webkitCancelFullScreen) {  
				  document.webkitCancelFullScreen();  
				}  
			  }  
			}
			function popupRegistrazione(NCabina,colonna)
			{
				Swal.fire(
				{
					title: '<span class="titleSwalList">Elimina registrazione o gestisci note</span>',
					html:
					'<ul class="ulSwalList">' +
						'<li><b>Numero cabina: </b>'+NCabina+'</li>' +
						'<li><b>Attivita: </b>'+colonna+'</li>' +
					'</ul>',
					//text: "Cabina: "+NCabina+", attivita: "+colonna,
					type: 'info',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Gestisci note',
					cancelButtonText: 'Elimina registrazione'
				}).then((result) => 
				{
					if (result.value) 
					{
						var xmlhttp = new XMLHttpRequest();
						xmlhttp.onreadystatechange = function() 
						{
							if (this.readyState == 4 && this.status == 200) 
							{
								var idNotaEsistente='';
								var notaEsistente='';
								if(this.responseText!='')
								{
									var idNotaEsistente=this.responseText.split("|")[0];
									var notaEsistente=this.responseText.split("|")[1];
								}
								Swal.fire({
										title: '<span class="titleSwalList">Gestisci note</span>',
										html:'<textarea maxlength="500" placeholder="Inserisci il testo della nota..." id="textareaSwalList">'+notaEsistente+'</textarea>',
										showCancelButton: true,
										cancelButtonText: 'Annulla',
										confirmButtonText: 'Conferma'
									}).then((result) => 
									{
										if (result.value) 
										{
											var note=document.getElementById("textareaSwalList").value;
											aggiungiNote(NCabina,colonna,note,idNotaEsistente);
										}
									})
							}
						};
						xmlhttp.open("POST", "getNoteEsistenti.php?NCabina="+NCabina+"&colonna="+colonna, true);
						xmlhttp.send();
					}
					else
					{
						if(result.dismiss=="cancel")
							eliminaRegistrazione(NCabina,colonna);
					}
				});
			}
			function aggiungiNote(NCabina,colonna,note,idNotaEsistente)
			{
				var http = new XMLHttpRequest();
				var url = 'aggiungiNote.php';
				var params = "NCabina="+NCabina+"&colonna="+colonna+"&note="+note+"&idNotaEsistente="+idNotaEsistente;
				http.open('POST', url, true);
				
				http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

				http.onreadystatechange = function() 
				{
					if(http.readyState == 4 && http.status == 200) 
					{
						if(this.responseText=="ok")
						{
							Swal.fire({
							  type: 'success',
							  title: '<span class="titleSwalList">Nota inserita</span>',
							  allowOutsideClick: false
							}).then((result) => {
							  if (result.value) 
							  {
								creaTabella();
							  }
							})
						}
						else
						{
							Swal.fire({
							  type: 'error',
							  title: 'Errore',
							  text: this.responseText,
							})
						}
					}
				}
				http.send(params);
			}
			function eliminaRegistrazione(NCabina,colonna)
			{
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						if(this.responseText=="ok")
						{
							Swal.fire({
							  type: 'success',
							  title: '<span class="titleSwalList">Registrazione eliminata</span>',
							  allowOutsideClick: false
							}).then((result) => {
							  if (result.value) 
							  {
								creaTabella();
							  }
							})
						}
						else
						{
							Swal.fire({
							  type: 'error',
							  title: 'Errore',
							  text: this.responseText,
							})
						}
					}
				};
				xmlhttp.open("POST", "eliminaRegistrazione.php?NCabina="+NCabina+"&colonna="+colonna, true);
				xmlhttp.send();
			}
			function newGridSpinner(message,container,spinnerContainerStyle,spinnerStyle,messageStyle)
			{
				document.getElementById(container).innerHTML='<div id="gridSpinnerContainer"  style="'+spinnerContainerStyle+'"><div  style="'+spinnerStyle+'" class="sk-cube-grid"><div class="sk-cube sk-cube1"></div><div class="sk-cube sk-cube2"></div><div class="sk-cube sk-cube3"></div><div class="sk-cube sk-cube4"></div><div class="sk-cube sk-cube5"></div> <div class="sk-cube sk-cube6"></div><div class="sk-cube sk-cube7"></div><div class="sk-cube sk-cube8"></div><div class="sk-cube sk-cube9"></div></div><div id="messaggiSpinner" style="'+messageStyle+'">'+message+'</div></div>';
			}
			function showPopupLegenda()
			{
				Swal.fire({
				  title: '<span class="titleSwalList">Legenda</span>',
				  html: '<ul class="ulSwalList" style="list-style-type: circle;">'+
							'<li style="padding-bottom:5px"><i class="fas fa-square" style="color:#EBEBEB;font-size:20px;margin-right:10px;"></i>Assegnata + non svolta</li>'+
							'<li style="padding-bottom:5px"><i class="fas fa-square" style="color:#24953E;font-size:20px;margin-right:10px;"></i>Assegnata + svolta</li>'+
							'<li style="padding-bottom:5px"><i class="fas fa-square" style="color:#BFBFBF;font-size:20px;margin-right:10px;"></i>Non assegnata + non svolta</li>'+
							'<li style="padding-bottom:5px"><i class="fas fa-square" style="color:red;font-size:20px;margin-right:10px;"></i>Errore</li>'+
							'<li style="padding-bottom:5px"><i class="far fa-square" style="color:#BFD5E1;background-color:#24953E;font-size:20px;margin-right:10px;"></i>Assegnata + svolta + note</li>'+
						'</ul>'
				})
			}
		</script>
	</head>
	<body onload="creaTabella()">
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