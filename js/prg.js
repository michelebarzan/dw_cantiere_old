    var cellSelected=[];
    var cabineSelected=[];
    var attivitaSelected=[];
    var orderBy;
    var loaded=false;

    async function checkCookies()
    {
        var orderByCookie=await getCookie("selectOrdinamentoPrg");
        //console.log(orderByCookie);
        if(orderByCookie!=="")
            orderBy=orderByCookie;
        else
            orderBy="posizione ASC";

        creaTabella();
    }
    async function creaTabella()
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

        if(document.getElementById("selectOrdinamentoPrg")!=null)
            orderBy=document.getElementById("selectOrdinamentoPrg").value;
        
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() 
        {
            if (this.readyState == 4 && this.status == 200) 
            {
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

                var pageHeight=document.body.offsetHeight;

                document.getElementById("myTable").getElementsByTagName("tbody")[0].style.width="calc(100% + 20px)";
                document.getElementById("myTable").getElementsByTagName("tbody")[0].style.height=(pageHeight-80)+"px";

                if(this.responseText.indexOf('#endofresponse#')>0)
                {
                    clearInterval(intervalTime);
                    document.getElementById("minutes").innerHTML="00";
                    document.getElementById("seconds").innerHTML="00";
                    clearInterval(interval);
                    document.getElementById("containerProgressBar").style.display="none"; 
                }

                var select=document.createElement("select");
                select.setAttribute("id","selectOrdinamentoPrg");
                select.setAttribute("onchange","setCookie('selectOrdinamentoPrg',this.value);creaTabella()");

                var option=document.createElement("option");
                option.setAttribute("value","posizione ASC");
                if(orderBy=="posizione ASC")
                    option.setAttribute("selected","selected");
                option.innerHTML="Posizione crescente";
                select.appendChild(option);

                var option=document.createElement("option");
                option.setAttribute("value","descrizione ASC");
                if(orderBy=="descrizione ASC")
                    option.setAttribute("selected","selected");
                option.innerHTML="Nome crescente";
                select.appendChild(option);

                var option=document.createElement("option");
                option.setAttribute("value","posizione DESC");
                if(orderBy=="posizione DESC")
                    option.setAttribute("selected","selected");
                option.innerHTML="Posizione decrescente";
                select.appendChild(option);

                var option=document.createElement("option");
                option.setAttribute("value","descrizione DESC");
                if(orderBy=="descrizione DESC")
                    option.setAttribute("selected","selected");
                option.innerHTML="Nome decrescente";
                select.appendChild(option);

                document.getElementById("selectOrdinamentoPrgContainer").innerHTML="";
                document.getElementById("selectOrdinamentoPrgContainer").appendChild(select);
            }
        };
        xmlhttp.open("POST", "creaTabella.php?Deck="+Deck+"&FZ="+FZ+"&gruppo="+ gruppo+"&orderBy="+ orderBy, true);
        xmlhttp.send();
    }
    function setCookie(name,value)
    {
        $.post("setCookie.php",{name,value},
        function(response, status)
        {
            if(status!="success")
                console.log(status);
        });
    }
    function getCookie(name)
    {
        return new Promise(function (resolve, reject) 
        {
            $.get("getCookie.php",{name},
            function(response, status)
            {
                if(status=="success")
                {
                    resolve(response);
                }
                else
                    reject({status});
            });
        });
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
    function checkDitteAttivita(attivita)
    {
        return new Promise(function (resolve, reject) 
        {
            var JSONattivita=JSON.stringify(attivita);
            $.get("checkDitteAttivita.php",{JSONattivita},
            function(response, status)
            {
                if(status=="success")
                {
                    if(response.toLowerCase().indexOf("error")>-1 || response.toLowerCase().indexOf("notice")>-1 || response.toLowerCase().indexOf("warning")>-1)
                    {
                        Swal.fire({icon:"error",title: "Errore. Se il problema persiste contatta l' amministratore",onOpen : function(){document.getElementsByClassName("swal2-title")[0].style.color="gray";document.getElementsByClassName("swal2-title")[0].style.fontSize="14px";}});
                        console.log(response);
                        resolve([]);
                    }
                    else
                    {
                        try {
                            resolve(JSON.parse(response));
                        } catch (error) {
                            Swal.fire({icon:"error",title: "Errore. Se il problema persiste contatta l' amministratore",onOpen : function(){document.getElementsByClassName("swal2-title")[0].style.color="gray";document.getElementsByClassName("swal2-title")[0].style.fontSize="14px";}});
                            console.log(response);
                            resolve([]);
                        }
                    }
                }
            });
        });
    }
    async function registra()
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

            var ditte_response=await checkDitteAttivita(attivitaSelectedUnique);
            console.log(ditte_response);
            if(ditte_response.ditte_attivita.length<=1)
            {
                var outerContainer=document.createElement("div");
                outerContainer.setAttribute("style","");

                var select=document.createElement("select");
                select.setAttribute("style","width:calc(100% - 100px);margin-left:50px;margin-right:50px;height:30px;background-color:transparent;border:none;border-bottom:1px solid gray;font-family:'Montserrat',sans-serif;font-size:12px;color:black;");
                select.setAttribute("id","selectPopupScegliDitta");

                var option=document.createElement("option");
                option.setAttribute("value","");
                option.innerHTML="Nessuna";
                select.appendChild(option);

                ditte_response.anagrafica_ditte.forEach(ditta =>
                {
                    var option=document.createElement("option");
                    option.setAttribute("value",ditta.id_ditta);
                    if(ditte_response.ditte_attivita.length==1 && ditte_response.ditte_attivita[0].nome==ditta.nome)
                        option.setAttribute("selected","selected");
                    option.innerHTML=ditta.nome;
                    select.appendChild(option);
                });

                outerContainer.appendChild(select);

                Swal.fire
                ({
                    title: '<span class="titleSwalList">Scegli ditta</span>',
                    html:outerContainer.outerHTML,
                    allowOutsideClick:false,
                    showCloseButton:false,
                    showConfirmButton:true,
                    allowEscapeKey:false,
                    showCancelButton:false,
                    confirmButtonText:"Conferma",
                    onOpen : function(){}
                }).then((result) => 
                {
                    var ditta=document.getElementById("selectPopupScegliDitta").value;
                    document.getElementById("btnRegistra").disabled = false;
                    if(result.value)
                    {
                        var xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function() 
                        {
                            if (this.readyState == 4 && this.status == 200) 
                            {
                                if(this.responseText=="ok")
                                {
                                    creaTabella();
                                }
                                else
                                {
                                    console.log(this.responseText);
                                    window.alert("Errore"+this.responseText);
                                }
                            }
                        };
                        xmlhttp.open("POST", "registraAttivita.php?attivitaS="+attivitaS+"&cabineS="+cabineS+"&cellS="+ cellS+"&ditta="+ ditta+"&extra=true", true);
                        xmlhttp.send();
                    }
                });
            }
            else
            {                
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
                        {
                            console.log(this.responseText);
                            window.alert("Errore"+this.responseText);
                        }
                    }
                };
                xmlhttp.open("POST", "registraAttivita.php?attivitaS="+attivitaS+"&cabineS="+cabineS+"&cellS="+ cellS+"&ditta="+ ditte_response.ditte_attivita[0].id_ditta+"&extra=false", true);
                xmlhttp.send();
            }
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