/*VARIABILI GLOBALI -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	var registrazioneVisualizzata;
	var dittaSelezionata;
	var ponteSelezionato;

	window.onclick = function(event) 
	{
		if (event.target == document.getElementById('modalDuplica')) 
		{
			chiudiPopupDuplica();
		}
		if (event.target == document.getElementById('modalNuova')) 
		{
			chiudiPopupNuova();
		}
		if (event.target == document.getElementById('modalAggiungiDitta')) 
		{
			chiudiPopupAggiungiDitta();
		}
		if (event.target == document.getElementById('modalAggiungiOperatore')) 
		{
			chiudiPopupAggiungiOperatore();
		}
		if (event.target == document.getElementById('modalAggiungiPonte')) 
		{
			chiudiPopupAggiungiPonte();
		}
	}
/*FUNZIONI-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	function getElencoRegistrazioni()
	{
		Swal.fire
        ({
            title: "Caricamento in corso... ",
            background:"rgba(0,0,0,0.4)",
            html: '<i style="color:#ddd" class="fad fa-spinner-third fa-spin fa-3x"></i>',
            showConfirmButton:false,
            showCloseButton:false,
            allowEscapeKey:false,
            allowOutsideClick:false,
            onOpen : function()
            {
                document.getElementsByClassName("swal2-title")[0].style.color="white";
                document.getElementsByClassName("swal2-title")[0].style.fontSize="14px";
                document.getElementsByClassName("swal2-title")[0].style.fontWeight="normal";
                document.getElementsByClassName("swal2-container")[0].style.padding="0px";
                document.getElementsByClassName("swal2-popup")[0].style.padding="0px";
                document.getElementsByClassName("swal2-popup")[0].style.height="100%";
                document.getElementsByClassName("swal2-popup")[0].style.maxWidth="100%";document.getElementsByClassName("swal2-popup")[0].style.minWidth="100%";document.getElementsByClassName("swal2-popup")[0].style.width="100%";
            }
		});

		svuotaValoriNull();
		dittaSelezionata="";
		ponteSelezionato="";
		registrazioneVisualizzata='';
		document.getElementById('elencoDitte').innerHTML="";
		document.getElementById('intestazioneDatiRegistrazione').innerHTML="Dati registrazione:";
		document.getElementById('dataRegistrazione').value="";
		document.getElementById('elencoPonti').innerHTML="";
		document.getElementById('elencoOperatori').innerHTML="";
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
				document.getElementById("elencoRegistrazioni").innerHTML  =this.responseText;
				Swal.close();
			}
		};
		xmlhttp.open("POST", "getElencoRegistrazioni.php?", true);
		xmlhttp.send();
	}
/*--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
	function cambiaDataRegistrazione()
	{
		if(registrazioneVisualizzata=='' || registrazioneVisualizzata==null)
		{
			window.alert("Impossibile cambiare la data. Nessuna registrazione selezionata");
		}
		else
		{
			var data=document.getElementById('dataRegistrazione').value;
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() 
			{
				if (this.readyState == 4 && this.status == 200) 
				{
					if(this.responseText=="ok")
					{
						getElencoRegistrazioni();
						setTimeout(function(){ document.getElementById('rigaRegistrazione'+registrazioneVisualizzata).click() }, 500);
					}
					else
						window.alert(this.responseText);
				}
			};
			xmlhttp.open("POST", "cambiaDataRegistrazione.php?id_registrazione="+registrazioneVisualizzata+"&data="+data, true);
			xmlhttp.send();
		}
	}
/*--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	function modificaNoteRegistrazione(id_registrazione,note)
	{
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
				if(this.responseText!="ok")
					window.alert("Errore. Impossibile modificare le note. Se il problema persiste contattare l' amministratore");
			}
		};
		xmlhttp.open("POST", "modificaNoteRegistrazione.php?id_registrazione="+id_registrazione+"&note="+note, true);
		xmlhttp.send();
	}
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	function apriPopupModificaNoteRegistrazione(id_registrazione)
	{
		document.getElementById("modalModificaNoteRegistrazione").style.display = "block";
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
				document.getElementById("textAreaNoteRegistrazione").value =this.responseText;
			}
		};
		xmlhttp.open("POST", "getNoteRegistrazione.php?id_registrazione="+id_registrazione, true);
		xmlhttp.send();		
	}
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	function chiudiPopupModificaNoteRegistrazione()
	{
		document.getElementById("textAreaNoteRegistrazione").value="";
		document.getElementById("modalModificaNoteRegistrazione").style.display = "none";
	}
/*--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	function getElencoPonti(id_ditta,id_registrazione)
	{
		ponteSelezionato="";
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
				document.getElementById("elencoPonti").innerHTML =this.responseText;
			}
		};
		xmlhttp.open("POST", "getElencoPonti.php?id_ditta="+id_ditta+"&id_registrazione="+id_registrazione, true);
		xmlhttp.send();
	}
/*--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	function selezionaRegistrazione(id_registrazione,data)
	{
		svuotaValoriNull();
		registrazioneVisualizzata=id_registrazione;
		document.getElementById('elencoDitte').innerHTML="";
		document.getElementById('elencoPonti').innerHTML="";
		document.getElementById('elencoOperatori').innerHTML="";
		/*document.getElementById('titoloDitte').style.display="inline-block";
		document.getElementById('selectDitte').style.display="none";*/
		//Stile elemento tabella
		var all = document.getElementsByClassName("btnSelezionaRegistrazione");
		for (var i = 0; i < all.length; i++) 
		{
			all[i].className = "btnSelezionaRegistrazione";
		}
		var all2 = document.getElementsByClassName("btnSelezionaRegistrazioneClicked");
		for (var i = 0; i < all2.length; i++) 
		{
			all2[i].className = "btnSelezionaRegistrazione";
		}
		document.getElementById("btnSelezionaRegistrazione"+id_registrazione).className = "btnSelezionaRegistrazioneClicked";
		var all3 = document.getElementsByClassName("righeRegistraioni");
		for (var i = 0; i < all3.length; i++) 
		{
			all3[i].style.background = "";
		}
		document.getElementById("rigaRegistrazione"+id_registrazione).style.background = "#CCE5FF";
		//riempio intestazione
		document.getElementById("intestazioneDatiRegistrazione").innerHTML="Dati registrazione n. "+id_registrazione;
		//riempio data
		var dataNew=getNewData(data);
		document.getElementById("dataRegistrazione").value=dataNew;
		//riempio lista ditte
		document.getElementById("elencoDitte").innerHTML="";
		getElencoDitte(id_registrazione);
	}
/*--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	function svuotaValoriNull()
	{
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
				if(this.responseText!="ok")
					window.alert("Errore. Impossibile garantire la coerenza dei dati. Se il problema persiste contattare l' amministratore");
			}
		};
		xmlhttp.open("POST", "svuotaValoriNull.php?", true);
		xmlhttp.send();
	}
/*--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	function getElencoDitte(id_registrazione)
	{
		dittaSelezionata="";
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
				document.getElementById('elencoDitte').innerHTML= this.responseText;
			}
		};
		xmlhttp.open("POST", "getElencoDitte.php?id_registrazione="+id_registrazione, true);
		xmlhttp.send();
	}
/*--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	function getNewData(data)
	{
		var anno = data.substr(data.length - 4);
		var mese = data.substring(3, 5);
		var giorno = data.substring(0, 2);
		return anno+"-"+mese+"-"+giorno;
	}
/*--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	function selezionaDitta(id_ditta,id_registrazione)
	{
		document.getElementById('elencoOperatori').innerHTML="";
		var all = document.getElementsByClassName("righeDitte");
		for (var i = 0; i < all.length; i++)
		{
			all[i].style.background = "";
		}
		document.getElementById("rigaDitta" + id_ditta).style.background = "#CCE5FF";
		dittaSelezionata=id_ditta;
		getElencoPonti(id_ditta,id_registrazione);
	}
/*--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	function selezionaPonte(id_registrazione,id_ditta,ponte)
	{
		var all = document.getElementsByClassName("righePonte");
		for (var i = 0; i < all.length; i++)
		{
			all[i].style.background = "";
		}
		document.getElementById("rigaPonte" + id_ditta+ponte).style.background = "#CCE5FF";
		ponteSelezionato=ponte;
		getElencoOperatori(id_registrazione,id_ditta,ponte);
	}
/*--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	function getElencoOperatori(id_registrazione,id_ditta,ponte)
	{
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
				document.getElementById('elencoOperatori').innerHTML= this.responseText;
			}
		};
		xmlhttp.open("POST", "getElencoOperatori.php?id_ditta="+id_ditta+"&ponte="+ponte+"&id_registrazione="+id_registrazione, true);
		xmlhttp.send();
	}
/*--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	function modificaOre(id_ponti_ditte_registrazioni,ore)
	{
		if(isNaN(ore))
			window.alert("Il valore immesso non è valido");
		else
		{
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() 
			{
				if (this.readyState == 4 && this.status == 200) 
				{
					if(this.responseText!="ok")
						window.alert("Errore. Impossibile modificare le ore. Se il problema persiste contattare l' amministratore");
				}
			};
			xmlhttp.open("POST", "modificaOre.php?id_ponti_ditte_registrazioni="+id_ponti_ditte_registrazioni+"&ore="+ore, true);
			xmlhttp.send();
		}
	}
/*--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	function modificaNote(id_ponti_ditte_registrazioni,note)
	{
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
				if(this.responseText!="ok")
					window.alert("Errore. Impossibile modificare le note. Se il problema persiste contattare l' amministratore");
			}
		};
		xmlhttp.open("POST", "modificaNote.php?id_ponti_ditte_registrazioni="+id_ponti_ditte_registrazioni+"&note="+note, true);
		xmlhttp.send();
	}
/*--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	function nuovaRegistrazione(data)
	{
		if(data=='' || data==null)
		{
			window.alert("La data immessa non e' valida");
		}
		else
		{
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() 
			{
				if (this.readyState == 4 && this.status == 200) 
				{
					if(this.responseText=="ok")
					{
						getElencoRegistrazioni();
						setTimeout(function(){ clickMaxRegistrazione(); }, 500);
					}
					else
					{
						if(this.responseText.indexOf("Error")!=-1 || this.responseText.indexOf("Notice")!=-1)
							window.alert("Errore. Impossibile creare una nuova registrazione. Se il problema persiste contattare l' amministratore");
						else
						{
							window.alert("Errore. "+this.responseText);
						}
					}
				}
			};
			xmlhttp.open("POST", "nuovaRegistrazione.php?data="+data, true);
			xmlhttp.send();
		}
	}
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	function apriPopupNuova()
	{
		document.getElementById("modalNuova").style.display = "block";	
	}
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	function chiudiPopupNuova()
	{
		document.getElementById("dataNuovaRegistrazione").value="";
		document.getElementById("modalNuova").style.display = "none";
	}
/*--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	function eliminaRegistrazione()
	{
		if(registrazioneVisualizzata=='' || registrazioneVisualizzata==null)
		{
			window.alert("Nessuna registrazione selezionata");
		}
		else
		{
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() 
			{
				if (this.readyState == 4 && this.status == 200) 
				{
					if(this.responseText=="ok")
						getElencoRegistrazioni();
					else
						window.alert(this.responseText);
				}
			};
			xmlhttp.open("POST", "eliminaCantiereRegistrazione.php?id_registrazione="+registrazioneVisualizzata, true);
			xmlhttp.send();
		}
	}
/*--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	function duplicaRegistrazione(data)
	{
		if(data=='' || data==null)
		{
			window.alert("La data immessa non e' valida");
		}
		else
		{
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() 
			{
				if (this.readyState == 4 && this.status == 200) 
				{
					if(this.responseText.indexOf("Error")!=-1 || this.responseText.indexOf("Notice")!=-1)
						window.alert("Errore. Impossibile duplicare la registrazione. Se il problema persiste contattare l' amministratore");
					else
					{
						if(this.responseText.indexOf("E' gia presente una registrazione in questa data")!=-1 )
							window.alert("Errore. E' gia presente una registrazione in questa data");
						else
						{
							getElencoRegistrazioni();
							setTimeout(function(){ clickMaxRegistrazione(); }, 500);
						}
					}
				}
			};
			xmlhttp.open("POST", "duplicaRegistrazione.php?id_registrazione="+registrazioneVisualizzata+"&data="+data, true);
			xmlhttp.send();
		}
	}
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	function clickMaxRegistrazione()
	{
		var arrayId=[];
		var all = document.getElementsByClassName("btnSelezionaRegistrazione");
		for (var i = 0; i < all.length; i++)
		{
			var fullElementId=all[i].id;
			var elementId = fullElementId.replace("btnSelezionaRegistrazione", "");
			arrayId.push(elementId);
		}
		document.getElementById("btnSelezionaRegistrazione"+Math.max.apply(null, arrayId)).click();
	}
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	function apriPopupDuplica()
	{
		if(registrazioneVisualizzata=='' || registrazioneVisualizzata==null)
		{
			window.alert("Nessuna registrazione selezionata");
		}
		else
			document.getElementById("modalDuplica").style.display = "block";	
	}
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	function chiudiPopupDuplica()
	{
		document.getElementById("dataDuplicaRegistrazione").value="";
		document.getElementById("modalDuplica").style.display = "none";
	}
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	function eliminaRigaRegistrazioneDitta(id_registrazione,id_ditta)
	{
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
				if(this.responseText=="ok")
				{
					getElencoDitte(id_registrazione);
				}
				else
					window.alert("Errore. Impossibile eliminare la riga della registrazione. Se il problema persiste contattare l' amministratore");
			}
		};
		xmlhttp.open("POST", "eliminaRigaRegistrazioneDitta.php?id_registrazione="+id_registrazione+"&id_ditta="+id_ditta, true);
		xmlhttp.send();
	}	
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	function eliminaRigaRegistrazionePonte(id_registrazione,id_ditta,ponte)
	{
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
				if(this.responseText=="ok")
				{
					if(document.getElementById('myTableElencoPonti').rows.length>2)
						getElencoPonti(id_ditta,id_registrazione);
					else
					{
						getElencoDitte(id_registrazione);
						document.getElementById("elencoPonti").innerHTML="";
						document.getElementById("elencoOperatori").innerHTML="";
					}
				}
				else
					window.alert("Errore. Impossibile eliminare la riga della registrazione. Se il problema persiste contattare l' amministratore");
			}
		};
		xmlhttp.open("POST", "eliminaRigaRegistrazionePonte.php?id_registrazione="+id_registrazione+"&id_ditta="+id_ditta+"&ponte="+ponte, true);
		xmlhttp.send();
	}	
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	function eliminaRigaRegistrazioneOperatore(id_registrazione,id_ditta,ponte,id_operatore)
	{
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
				if(this.responseText=="ok")
				{
					getElencoOperatori(id_registrazione,id_ditta,ponte); 
					var nOperatori=document.getElementById('rigaPonte'+id_ditta+ponte).childNodes[2].innerHTML;
					if(nOperatori>1)
					{
						nOperatori--;
						document.getElementById('rigaPonte'+id_ditta+ponte).childNodes[2].innerHTML=nOperatori;
					}
					else
					{
						if(document.getElementById('myTableElencoPonti').rows.length>2)
							getElencoPonti(id_ditta,id_registrazione);
						else
						{
							getElencoDitte(id_registrazione);
							document.getElementById("elencoPonti").innerHTML="";
							document.getElementById("elencoOperatori").innerHTML="";
						}
					}
				}
				else
					window.alert("Errore. Impossibile eliminare la riga della registrazione. Se il problema persiste contattare l' amministratore");
			}
		};
		xmlhttp.open("POST", "eliminaRigaRegistrazioneOperatore.php?id_registrazione="+id_registrazione+"&id_ditta="+id_ditta+"&ponte="+ponte+"&id_operatore="+id_operatore, true);
		xmlhttp.send();
	}	
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	function apriPopupAggiungiDitta()
	{
		if(registrazioneVisualizzata=='' || registrazioneVisualizzata==null)
		{
			window.alert("Nessuna registrazione selezionata");
		}
		else
			document.getElementById("modalAggiungiDitta").style.display = "block";	
	}
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	function chiudiPopupAggiungiDitta()
	{
		document.getElementById("selectDitte").value="";
		document.getElementById("modalAggiungiDitta").style.display = "none";
	}
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	function aggiungiDitta(id_ditta)
	{
		if(id_ditta=='' || id_ditta==null)
		{
			window.alert("Nessuna ditta selezionata");
		}
		else
		{
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() 
			{
				if (this.readyState == 4 && this.status == 200) 
				{
					if(this.responseText=="ok")
					{
						getElencoDitte(registrazioneVisualizzata);
						setTimeout(function(){ document.getElementById('rigaDitta'+id_ditta).click(); }, 300);
					}
					else
					{
						if(this.responseText.indexOf("Error")!=-1 || this.responseText.indexOf("Notice")!=-1)
							window.alert("Errore. Impossibile aggiungere la ditta. Se il problema persiste contattare l' amministratore");
						else
							window.alert(this.responseText);
					}
				}
			};
			xmlhttp.open("POST", "aggiungiDitta.php?id_registrazione="+registrazioneVisualizzata+"&id_ditta="+id_ditta, true);
			xmlhttp.send();
		}
	}
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	function apriPopupAggiungiPonte()
	{
		if(registrazioneVisualizzata=='' || registrazioneVisualizzata==null)
		{
			window.alert("Nessuna registrazione selezionata");
		}
		else
			document.getElementById("modalAggiungiPonte").style.display = "block";	
	}
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	function chiudiPopupAggiungiPonte()
	{
		document.getElementById("selectPonte").value="";
		document.getElementById("modalAggiungiPonte").style.display = "none";
	}
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	function aggiungiPonte(ponte)
	{
		id_ditta=dittaSelezionata;
		if(id_ditta=='' || id_ditta==null)
		{
			window.alert("Nessuna ditta selezionata");
		}
		if(ponte=='' || ponte==null)
		{
			window.alert("Nessun ponte selezionato");
		}
		if(ponte!='' && ponte!=null && id_ditta!='' && id_ditta!=null)
		{
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() 
			{
				if (this.readyState == 4 && this.status == 200) 
				{
					if(this.responseText=="ok")
					{
						document.getElementById('rigaDitta'+id_ditta).click();
						setTimeout(function(){ document.getElementById('rigaPonte'+id_ditta+ponte).click(); },300);
					}
					else
					{
						if(this.responseText.indexOf("Error")!=-1 || this.responseText.indexOf("Notice")!=-1)
							window.alert("Errore. Impossibile aggiungere la ditta. Se il problema persiste contattare l' amministratore");
						else
							window.alert(this.responseText);
					}
				}
			};
			xmlhttp.open("POST", "aggiungiPonte.php?id_registrazione="+registrazioneVisualizzata+"&id_ditta="+id_ditta+"&ponte="+ponte, true);
			xmlhttp.send();
		}
	}
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	function apriPopupAggiungiOperatore()
	{
		id_ditta=dittaSelezionata;
		id_ditta=dittaSelezionata;
		ponte=ponteSelezionato;
		if(ponte=='' || ponte==null)
		{
			window.alert("Nessun ponte selezionato");
		}
		if(id_ditta=='' || id_ditta==null)
		{
			window.alert("Nessuna ditta selezionata");
		}
		if(registrazioneVisualizzata=='' || registrazioneVisualizzata==null)
		{
			window.alert("Nessuna registrazione selezionata");
		}
		if(registrazioneVisualizzata!='' && registrazioneVisualizzata!=null && id_ditta!='' && id_ditta!=null && ponte!='' && ponte!=null)
		{
			document.getElementById("modalAggiungiOperatore").style.display = "block";	
			getSelectOperatore(id_ditta);
		}
	}
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	function chiudiPopupAggiungiOperatore()
	{
		document.getElementById("selectOperatore").value="";
		document.getElementById("modalAggiungiOperatore").style.display = "none";
	}
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	function getSelectOperatore(id_ditta)
	{
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
				if(this.responseText.indexOf("Error")!=-1 || this.responseText.indexOf("Notice")!=-1)
					window.alert("Errore. Impossibile aggiungere il ponte. Se il problema persiste contattare l' amministratore");
				else
				{
					document.getElementById("selectOperatoreContainer").innerHTML=this.responseText;
				}
			}
		};
		xmlhttp.open("POST", "getSelectOperatore.php?id_ditta="+id_ditta, true);
		xmlhttp.send();
	}
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	function aggiungiOperatore(id_operatore)
	{
		id_ditta=dittaSelezionata;
		ponte=ponteSelezionato;
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
				if(this.responseText=="ok")
				{
					document.getElementById('rigaDitta'+id_ditta).click();
					setTimeout(function(){ document.getElementById('rigaPonte'+id_ditta+ponte).click(); },300);
				}
				else
				{
					if(this.responseText.indexOf("Error")!=-1 || this.responseText.indexOf("Notice")!=-1)
						window.alert("Errore. Impossibile aggiungere l' operatore. Se il problema persiste contattare l' amministratore");
					else
						window.alert(this.responseText);
				}
			}
		};
		xmlhttp.open("POST", "aggiungiOperatore.php?id_registrazione="+registrazioneVisualizzata+"&id_ditta="+id_ditta+"&ponte="+ponte+"&id_operatore="+id_operatore, true);
		xmlhttp.send();
	}
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	function reportExcel()
	{
		if(registrazioneVisualizzata=='' || registrazioneVisualizzata==null)
		{
			window.alert("Nessuna registrazione selezionata");
		}
		else
		{
			document.getElementById('hiddenContainerReport').innerHTML="";
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() 
			{
				if (this.readyState == 4 && this.status == 200) 
				{
					if(this.responseText.indexOf("Error")!=-1 || this.responseText.indexOf("Notice")!=-1)
						window.alert("Errore. Impossibile generare il file Excel. Se il problema persiste contattare l' amministratore");
					else
					{
						document.getElementById('hiddenContainerReport').innerHTML=this.responseText;
						tableToExcel('myTableReport');
					}
				}
			};
			xmlhttp.open("POST", "getTabellaReport.php?id_registrazione="+registrazioneVisualizzata, true);
			xmlhttp.send();
		}
	}
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	function stampaReport()
	{
		if(registrazioneVisualizzata=='' || registrazioneVisualizzata==null)
		{
			window.alert("Nessuna registrazione selezionata");
		}
		else
		{
			document.getElementById('hiddenContainerReport').innerHTML="";
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() 
			{
				if (this.readyState == 4 && this.status == 200) 
				{
					if(this.responseText.indexOf("Error")!=-1 || this.responseText.indexOf("Notice")!=-1)
						window.alert("Errore. Impossibile generare il file Excel. Se il problema persiste contattare l' amministratore");
					else
					{
						document.getElementById('hiddenContainerReport').innerHTML=this.responseText;
						window.frames["print_frame"].document.body.innerHTML += document.getElementById("hiddenContainerReport").innerHTML; 
						window.frames["print_frame"].window.focus();
						window.frames["print_frame"].window.print();
					}
				}
			};
			xmlhttp.open("POST", "getTabellaReport.php?id_registrazione="+registrazioneVisualizzata, true);
			xmlhttp.send();
		}
	}
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	var customSelectItems=[];
	var selected=[];

	async function getCustomSelect(button,data_source)
	{
		closeCustomSelect();

		var alert=false;
		if(data_source=="ditte")
		{
			if(registrazioneVisualizzata=='' || registrazioneVisualizzata==null)
			{
				alert=true;
				var alertMessage="Seleziona una registrazione";
			}
		}
		if(data_source=="ponti")
		{
			if(registrazioneVisualizzata=='' || registrazioneVisualizzata==null || dittaSelezionata=='' || dittaSelezionata==null)
			{
				alert=true;
				var alertMessage="Seleziona una registrazione e una ditta";
			}
		}
		if(data_source=="operatori")
		{
			if(registrazioneVisualizzata=='' || registrazioneVisualizzata==null || dittaSelezionata=='' || dittaSelezionata==null || ponteSelezionato=='' || ponteSelezionato==null )
			{
				alert=true;
				var alertMessage="Seleziona una registrazione, una ditta e un ponte";
			}
		}

		if(alert)
		{
			Swal.fire({icon:"error",onOpen:function(){document.getElementsByClassName("swal2-title")[0].style.fontSize="15px"},title: alertMessage});
		}
		else
		{
			if(document.getElementById("customSelect"+data_source)==null)
			{
				var selectOuterContainer=document.createElement("div");
				selectOuterContainer.setAttribute("class","custom-select-outer-container");
				selectOuterContainer.setAttribute("id","customSelect"+data_source);

				document.body.appendChild(selectOuterContainer);
				
				var rect = button.getBoundingClientRect();

				//var width=button.offsetWidth;
				var buttonHeight=button.offsetHeight;

				var left=rect.left;
				var top=rect.top+buttonHeight;
			
				$("#customSelect"+data_source).show();
				$("#customSelect"+data_source).css
				({
					//"left":left+"px",
					"top":top+"px",
					"display":"flex",
					"width":"auto",
					"visibility":"hidden"
				});
				setTimeout(function()
				{
					var width=document.getElementById("customSelect"+data_source).offsetWidth;
					left=left-width;
					$("#customSelect"+data_source).css
					({
						"left":left+"px",
						"visibility":"visible"
					});
				}, 120);

				var searchInput=document.createElement("input");
				searchInput.setAttribute("type","text");
				searchInput.setAttribute("onkeyup","searchCustomSelect(this.value)");
				searchInput.setAttribute("class","custom-select-item custom-select-input-search");
				searchInput.setAttribute("placeholder","Cerca...");
				selectOuterContainer.appendChild(searchInput);

				var spinner=document.createElement("div");
				spinner.setAttribute("id","customSelectSpinner");
				spinner.setAttribute("style","width:100%;display:flex;justify-content:center;align-items:center;flex-direction:row;font-family: 'Montserrat',sans-serif;font-size: 12px;");
				spinner.innerHTML='<i class="fad fa-spinner fa-spin"></i><span style="margin-left:5px">Caricamento in corso...</span>';

				selectOuterContainer.appendChild(spinner);

				customSelectItems=await getCustomSelectItems(data_source);
				
				document.getElementById("customSelectSpinner").remove();

				var innerContainer=document.createElement("div");
				innerContainer.setAttribute("class","custom-select-item custom-select-inner-container");

				var option=document.createElement("button");
				option.setAttribute("class","custom-select-item custom-select-option");
				option.setAttribute("id","customSelectOptionAll");
				option.setAttribute("value","*");
				option.setAttribute("checked","false");
				option.setAttribute("onclick","checkAllOption(this)");

				var checkbox=document.createElement("i");
				checkbox.setAttribute("class","custom-select-item custom-select-checkbox fal fa-square");
				checkbox.setAttribute("value","*");
				option.appendChild(checkbox);

				var span=document.createElement("span");
				span.setAttribute("class","custom-select-item custom-select-span");
				span.innerHTML="Seleziona tutto";
				option.appendChild(span);

				innerContainer.appendChild(option);
				
				customSelectItems.forEach(function(item)
				{
					var option=document.createElement("button");
					option.setAttribute("class","custom-select-item custom-select-option");
					option.setAttribute("value",item.value);
					option.setAttribute("checked","false");
					option.setAttribute("onclick","checkOption(this,'"+item.value+"')");

					var checkbox=document.createElement("i");
					checkbox.setAttribute("class","custom-select-item custom-select-checkbox fal fa-square");
					checkbox.setAttribute("value",item.value);
					option.appendChild(checkbox);

					var span=document.createElement("span");
					span.setAttribute("class","custom-select-item custom-select-span");
					span.innerHTML=item.label;
					option.appendChild(span);

					innerContainer.appendChild(option);
				});
				
				selectOuterContainer.appendChild(innerContainer);

				var confirmButton=document.createElement("button");
				confirmButton.setAttribute("class","custom-select-item custom-select-confirm-button");
				confirmButton.setAttribute("onclick","getSelects('getSelects"+data_source+"')");
				var span=document.createElement("span");
				span.setAttribute("class","custom-select-item");
				span.innerHTML="Conferma";
				confirmButton.appendChild(span);
				var i=document.createElement("i");
				i.setAttribute("class","custom-select-item fad fa-check-double");
				confirmButton.appendChild(i);

				selectOuterContainer.appendChild(confirmButton);
			}
			else
			{
				var rect = button.getBoundingClientRect();

				var left=rect.left;
				var top=rect.top+buttonHeight;
			
				$("#customSelect"+data_source).show();
				$("#customSelect"+data_source).css
				({
					//"left":left+"px",
					"top":top+"px",
					"display":"flex",
					"width":"auto",
					"visibility":"hidden"
				});
				setTimeout(function()
				{
					var width=document.getElementById("customSelect"+data_source).offsetWidth;
					left=left-width;
					$("#customSelect"+data_source).css
					({
						"left":left+"px",
						"visibility":"visible"
					});
				}, 120);
			}
		}
	}
	function getCustomSelectItems(data_source)
	{
		return new Promise(function (resolve, reject) 
		{
			var ditta=null;
			if(data_source=="operatori")
				ditta=dittaSelezionata;
			$.get("getCustomSelectItems.php",
			{
				data_source,
				ditta
			},
			function(response, status)
			{
				if(status=="success")
				{
					if(response.toLowerCase().indexOf("error")>-1 || response.toLowerCase().indexOf("notice")>-1 || response.toLowerCase().indexOf("warning")>-1)
					{
						Swal.fire({icon:"error",onOpen:function(){document.getElementsByClassName("swal2-title")[0].style.fontSize="15px"},title: "Errore. Se il problema persiste contatta l' amministratore"});
						console.log(response);
						resolve([]);
					}
					else
					{
						try {
							resolve(JSON.parse(response));
						} catch (error) {
							Swal.fire({icon:"error",onOpen:function(){document.getElementsByClassName("swal2-title")[0].style.fontSize="15px"},title: "Errore. Se il problema persiste contatta l' amministratore"});
							console.log(error);
							console.log(response);
							resolve([]);
						}
					}
				}
			});
		});
	}
	function closeCustomSelect()
	{
		$(".custom-select-outer-container").remove();
	}
	async function getSelects(fn)
	{
		selected=[];

		var options=document.getElementsByClassName("custom-select-option");
		for (let index = 0; index < options.length; index++) 
		{
			const option = options[index];
			if(option.id!=="customSelectOptionAll")
			{
				var checked=option.getAttribute("checked")=="true";
				if(checked)
					selected.push(option.value);
			}
		}

		closeCustomSelect();

		Swal.fire
        ({
            title: "Caricamento in corso... ",
            background:"rgba(0,0,0,0.4)",
            html: '<i style="color:#ddd" class="fad fa-spinner-third fa-spin fa-3x"></i>',
            showConfirmButton:false,
            showCloseButton:false,
            allowEscapeKey:false,
            allowOutsideClick:false,
            onOpen : function()
            {
                document.getElementsByClassName("swal2-title")[0].style.color="white";
                document.getElementsByClassName("swal2-title")[0].style.fontSize="14px";
                document.getElementsByClassName("swal2-title")[0].style.fontWeight="normal";
                document.getElementsByClassName("swal2-container")[0].style.padding="0px";
                document.getElementsByClassName("swal2-popup")[0].style.padding="0px";
                document.getElementsByClassName("swal2-popup")[0].style.height="100%";
                document.getElementsByClassName("swal2-popup")[0].style.maxWidth="100%";document.getElementsByClassName("swal2-popup")[0].style.minWidth="100%";document.getElementsByClassName("swal2-popup")[0].style.width="100%";
            }
		});
		
		window[fn]();
	}
	function checkAllOption(option)
	{
		var checked=option.getAttribute("checked")=="true";
		if(checked)
		{
			var options=document.getElementsByClassName("custom-select-option");
			for (let index = 0; index < options.length; index++)
			{
				const option = options[index];
				var checkbox=option.getElementsByClassName("custom-select-checkbox")[0];

				checkbox.setAttribute("class","custom-select-item custom-select-checkbox fal fa-square");
				option.setAttribute("checked","false");
			}
		}
		else
		{
			var options=document.getElementsByClassName("custom-select-option");
			for (let index = 0; index < options.length; index++)
			{
				const option = options[index];
				var checkbox=option.getElementsByClassName("custom-select-checkbox")[0];
				
				checkbox.setAttribute("class","custom-select-item custom-select-checkbox fad fa-check-square");
				option.setAttribute("checked","true");
			}			
		}
	}
	function checkOption(option)
	{
		var checked=option.getAttribute("checked")=="true";
		var checkbox=option.getElementsByClassName("custom-select-checkbox")[0];
		if(checked)
		{
			checkbox.setAttribute("class","custom-select-item custom-select-checkbox fal fa-square");
			option.setAttribute("checked","false");
		}
		else
		{
			checkbox.setAttribute("class","custom-select-item custom-select-checkbox fad fa-check-square");
			option.setAttribute("checked","true");
		}

		var nSelected=0;
		var options=document.getElementsByClassName("custom-select-option");
		for (let index = 0; index < options.length; index++) 
		{
			const option = options[index];
			if(option.id!=="customSelectOptionAll")
			{
				var checked=option.getAttribute("checked")=="true";
				if(checked)
					nSelected++;
			}
		}

		if(nSelected==options.length-1)
		{
			var option=document.getElementById("customSelectOptionAll");
			var checkbox=option.getElementsByClassName("custom-select-checkbox")[0];
			checkbox.setAttribute("class","custom-select-item custom-select-checkbox fad fa-check-square");
			option.setAttribute("checked","true");
		}
		else
		{
			var option=document.getElementById("customSelectOptionAll");
			var checkbox=option.getElementsByClassName("custom-select-checkbox")[0];
			checkbox.setAttribute("class","custom-select-item custom-select-checkbox fal fa-square");
			option.setAttribute("checked","false");
		}
	}
	function searchCustomSelect(value)
	{
		$(".custom-select-option").filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	}
	window.addEventListener("click",(function(e) 
	{
		if(e.target.className!="fal fa-plus-circle fa-2x" && e.target.className.indexOf("custom-select-item")==-1 && e.target.className!="custom-select-outer-container")
		{
			closeCustomSelect();
		}
	}));
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	function getSelectsditte()
	{
		if(selected.length==0)
		{
			Swal.fire({icon:"error",onOpen:function(){document.getElementsByClassName("swal2-title")[0].style.fontSize="15px"},title: "Nessuna ditta selezionata"});
		}
		else
		{
			var ditte=JSON.stringify(selected);
			$.get("insertDittaCantierePontiDitteRegistrazioni.php",
			{
				ditte,
				id_registrazione:registrazioneVisualizzata
			},
			function(response, status)
			{
				if(status=="success")
				{
					if(response.toLowerCase().indexOf("error")>-1 || response.toLowerCase().indexOf("notice")>-1 || response.toLowerCase().indexOf("warning")>-1)
					{
						Swal.fire({icon:"error",onOpen:function(){document.getElementsByClassName("swal2-title")[0].style.fontSize="15px"},title: "Errore. Se il problema persiste contatta l' amministratore"});
						console.log(response);
					}
					else
					{
						Swal.close();
						getElencoDitte(registrazioneVisualizzata);
						if(selected.length==1)
							setTimeout(function(){ document.getElementById('rigaDitta'+parseInt(selected[0])).click(); }, 300);
					}
				}
			});
		}
	}
	function getSelectsponti()
	{
		if(selected.length==0)
		{
			Swal.fire({icon:"error",onOpen:function(){document.getElementsByClassName("swal2-title")[0].style.fontSize="15px"},title: "Nessun ponte selezionato"});
		}
		else
		{
			var ponti=JSON.stringify(selected);
			$.get("insertPonteCantierePontiDitteRegistrazioni.php",
			{
				ponti,
				id_registrazione:registrazioneVisualizzata,
				id_ditta:dittaSelezionata
			},
			function(response, status)
			{
				if(status=="success")
				{
					if(response.toLowerCase().indexOf("error")>-1 || response.toLowerCase().indexOf("notice")>-1 || response.toLowerCase().indexOf("warning")>-1)
					{
						Swal.fire({icon:"error",onOpen:function(){document.getElementsByClassName("swal2-title")[0].style.fontSize="15px"},title: "Errore. Se il problema persiste contatta l' amministratore"});
						console.log(response);
					}
					else
					{
						Swal.close();
						document.getElementById('rigaDitta'+dittaSelezionata).click();
						if(selected.length==1)
							setTimeout(function(){ document.getElementById('rigaPonte'+dittaSelezionata+selected[0]).click(); },300);
					}
				}
			});
		}
	}
	function getSelectsoperatori()
	{
		if(selected.length==0)
		{
			Swal.fire({icon:"error",onOpen:function(){document.getElementsByClassName("swal2-title")[0].style.fontSize="15px"},title: "Nessun operatore selezionato"});
		}
		else
		{
			var ponte=ponteSelezionato;

			var operatori=JSON.stringify(selected);
			$.get("insertOperatoreCantierePontiDitteRegistrazioni.php",
			{
				operatori,
				id_registrazione:registrazioneVisualizzata,
				id_ditta:dittaSelezionata,
				ponte
			},
			function(response, status)
			{
				if(status=="success")
				{
					if(response.toLowerCase().indexOf("error")>-1 || response.toLowerCase().indexOf("notice")>-1 || response.toLowerCase().indexOf("warning")>-1)
					{
						Swal.fire({icon:"error",onOpen:function(){document.getElementsByClassName("swal2-title")[0].style.fontSize="15px"},title: "Errore. Se il problema persiste contatta l' amministratore"});
						console.log(response);
					}
					else
					{
						Swal.close();
						document.getElementById('rigaDitta'+dittaSelezionata).click();
						setTimeout(function(){ document.getElementById('rigaPonte'+parseInt(dittaSelezionata)+ponte).click(); },300);
					}
				}
			});
		}
	}