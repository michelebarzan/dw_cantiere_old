var ditte=[];
var sortableDropHelper=
{
    origin:null,
    target:null,
    item:null
};
var id_ditta;

function anagraficaDitte()
{
    var containerAnagrafiche= document.getElementById("containerAnagrafiche");
    containerAnagrafiche.style.height="";

    var controlBar=document.getElementById("actionBarInserimentoAnagrafiche");

    controlBar.style.display="flex";
    controlBar.innerHTML="";

    var div=document.createElement("div");
    div.setAttribute("class","rcb-select-container");
    div.innerHTML='<span>Righe: </span><span id="rowsNumEditableTable">0</span>';
    controlBar.appendChild(div);

    var button=document.createElement("button");
    button.setAttribute("class","rcb-button-text-icon");
    button.setAttribute("onclick","resetFilters();getTable(selectetTable)");
    button.innerHTML='<span>Ripristina</span><i class="fad fa-filter" style="margin-left:5px"></i>';
    controlBar.appendChild(button);

    getTable("cantiere_ditte_view",'nome','ASC');
}
function getTable(table,orderBy,orderType)
{
    if(table=="cantiere_ditte_view")
    {
        getEditableTable
        ({
            table:'cantiere_ditte_view',
            editable: true,
            primaryKey:"id_ditta",
            container:'containerAnagrafiche',
            readOnlyColumns:['id_ditta'],
            noInsertColumns:['id_ditta'],
            orderBy:orderBy,
            orderType:orderType
        });
    }
    if(table=="cantiere_operatori_ditte_view")
    {
        getEditableTable
        ({
            table:'cantiere_operatori_ditte_view',
            editable: true,
            primaryKey:"id_operatore",
            container:'containerAnagrafiche',
            readOnlyColumns:['id_operatore'],
            noInsertColumns:['id_operatore'],
            orderBy:orderBy,
            orderType:orderType
        });
    }
}
function editableTableLoad()
{
    if(selectetTable=="cantiere_ditte_view")
    {
        var deleteButtons=document.getElementsByClassName("btnDeleteEditableTable");
        for (let index = 0; index < deleteButtons.length; index++)
        {
            const deleteButton = deleteButtons[index];
            var id_ditta=parseInt(deleteButton.parentElement.parentElement.cells[0].innerHTML);
            deleteButton.setAttribute("onclick","eliminaDitta("+id_ditta+")");
        }
    }
    if(selectetTable=="cantiere_operatori_ditte_view")
    {
        var deleteButtons=document.getElementsByClassName("btnDeleteEditableTable");
        for (let index = 0; index < deleteButtons.length; index++)
        {
            const deleteButton = deleteButtons[index];
            var id_operatore=parseInt(deleteButton.parentElement.parentElement.cells[0].innerHTML);
            deleteButton.setAttribute("onclick","eliminaOperatore("+id_operatore+")");
        }
    }
}
function eliminaOperatore(id_operatore)
{
    $.post("eliminaOperatore.php",
    {
        id_operatore
    },
    function(response, status)
    {
        if(status=="success")
        {
            getTable(selectetTable);
        }
    });
}
function eliminaDitta(id_ditta)
{
    $.post("eliminaDitta.php",
    {
        id_ditta
    },
    function(response, status)
    {
        if(status=="success")
        {
            getTable(selectetTable);
        }
    });
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
    var containerAnagrafiche= document.getElementById("containerAnagrafiche");
    containerAnagrafiche.style.height="";

    var controlBar=document.getElementById("actionBarInserimentoAnagrafiche");

    controlBar.style.display="flex";
    controlBar.innerHTML="";

    var div=document.createElement("div");
    div.setAttribute("class","rcb-select-container");
    div.innerHTML='<span>Righe: </span><span id="rowsNumEditableTable">0</span>';
    controlBar.appendChild(div);

    var button=document.createElement("button");
    button.setAttribute("class","rcb-button-text-icon");
    button.setAttribute("onclick","resetFilters();getTable(selectetTable)");
    button.innerHTML='<span>Ripristina</span><i class="fad fa-filter" style="margin-left:5px"></i>';
    controlBar.appendChild(button);

    getTable("cantiere_operatori_ditte_view",'cognome','ASC');

    /*document.getElementById('containerAnagrafiche').innerHTML='';
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
    xmlhttp.send();*/
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
async function assegnazioneOperatori()
{
    var containerAnagrafiche= document.getElementById("containerAnagrafiche");
    containerAnagrafiche.innerHTML="";
    containerAnagrafiche.style.height="calc(100% - calc(50px + 180px + 10px + 70px + 50px + 40px + 10px + 90px))";

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

    ditte=await getDitte();
    
    var controlBar=document.getElementById("actionBarInserimentoAnagrafiche");

    controlBar.style.display="flex";
    controlBar.innerHTML="";

    var actionBarItem=document.createElement("div");
    actionBarItem.setAttribute("class","rcb-select-container");
    
    var span=document.createElement("span");
    span.innerHTML="Ditta";
    actionBarItem.appendChild(span);

    var select=document.createElement("select");
    select.setAttribute("onchange","getOperatoriAssegnazioneOperatori(true)");
    select.setAttribute("id","selectDittaInserimentoAnagrafiche");

    ditte.forEach(function (ditta)
    {
        var option=document.createElement("option");
        option.setAttribute("value",ditta.id_ditta);
        option.innerHTML=ditta.nome;
        select.appendChild(option);
    });
    
    actionBarItem.appendChild(select);
    controlBar.appendChild(actionBarItem);

    $("#selectDittaInserimentoAnagrafiche").multipleSelect
    ({
        single:true,
        onAfterCreate: function () 
                {
                    $(".ms-choice").css({"height":"20px","line-height":"21px","background-color":"transparent","border":"none"});
                },
        onOpen:function()
        {
            $(".ms-search input").css({"font-family":"'Montserrat',sans-serif","font-size":"12px","text-align":"left"});
            $(".hide-radio").css({"font-family":"'Montserrat',sans-serif","font-size":"12px","text-align":"left"});
        },
        filter:true,
        filterPlaceholder:"Cerca...",
        locale:"it-IT"
    });

    getOperatoriAssegnazioneOperatori(false);
}
async function getOperatoriAssegnazioneOperatori(loading)
{
    var containerAnagrafiche= document.getElementById("containerAnagrafiche");
    containerAnagrafiche.innerHTML="";

    if(loading)
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
    }

    id_ditta=document.getElementById("selectDittaInserimentoAnagrafiche").value;
    var ditta=getFirstObjByPropValue(ditte,"id_ditta",id_ditta);

    var operatori=await getOperatori();
    var operatori_ditta=await getOperatoriDitta(id_ditta);

    var operatoriDittaContainer=document.createElement("div");
    operatoriDittaContainer.setAttribute("class","container-operatori-inserimento-anagrafiche");

    var operatoriDittaTitleContainer=document.createElement("div");
    operatoriDittaTitleContainer.setAttribute("class","title-container-operatori-inserimento-anagrafiche");
    operatoriDittaTitleContainer.innerHTML="<span>Operatori della ditta "+ditta.nome+"</span><span id='nOperatoriDitta'></span>";
    operatoriDittaContainer.appendChild(operatoriDittaTitleContainer);

    var operatoriDittaInnerContainer=document.createElement("div");
    operatoriDittaInnerContainer.setAttribute("class","inner-container-operatori-inserimento-anagrafiche connectedSortable");
    operatoriDittaInnerContainer.setAttribute("id","operatoriDittaContainer");
    operatoriDittaContainer.appendChild(operatoriDittaInnerContainer);

    operatori_ditta.forEach(function(operatore)
    {
        var item=document.createElement("div");
        item.setAttribute("class","operatori-item");

        item.setAttribute("id_operatore",operatore.id_operatore);
        item.setAttribute("nome",operatore.nome);
        item.setAttribute("cognome",operatore.cognome);
        item.setAttribute("orePred",operatore.orePred);
        item.setAttribute("ditta",operatore.ditta);

        var i=document.createElement("i");
        i.setAttribute("class","fad fa-user");
        item.appendChild(i);

        var span=document.createElement("span");
        span.innerHTML=operatore.cognome+" "+operatore.nome;
        item.appendChild(span);

        operatoriDittaInnerContainer.appendChild(item);
    });

    containerAnagrafiche.appendChild(operatoriDittaContainer);

    var label=document.createElement("div");
    label.setAttribute("class","container-operatori-inserimento-anagrafiche-label");
    label.innerHTML="<i class='fad fa-hospital-user'></i><span>Trascina un operatore</span><i class='fad fa-sort-alt'></i>";
    containerAnagrafiche.appendChild(label);

    var operatoriContainer=document.createElement("div");
    operatoriContainer.setAttribute("class","container-operatori-inserimento-anagrafiche");

    var operatoriTitleContainer=document.createElement("div");
    operatoriTitleContainer.setAttribute("class","title-container-operatori-inserimento-anagrafiche");
    operatoriTitleContainer.innerHTML="<span>Operatori non assegnati</span><span id='nOperatori'></span>";
    operatoriContainer.appendChild(operatoriTitleContainer);

    var operatoriInnerContainer=document.createElement("div");
    operatoriInnerContainer.setAttribute("class","inner-container-operatori-inserimento-anagrafiche connectedSortable");
    operatoriInnerContainer.setAttribute("id","operatoriContainer");
    operatoriContainer.appendChild(operatoriInnerContainer);

    operatori.forEach(function(operatore)
    {
        var item=document.createElement("div");
        item.setAttribute("class","operatori-item");

        item.setAttribute("id_operatore",operatore.id_operatore);
        item.setAttribute("nome",operatore.nome);
        item.setAttribute("cognome",operatore.cognome);
        item.setAttribute("orePred",operatore.orePred);
        //item.setAttribute("ditta",operatore.ditta);

        var i=document.createElement("i");
        i.setAttribute("class","fad fa-user");
        item.appendChild(i);

        var span=document.createElement("span");
        span.innerHTML=operatore.cognome+" "+operatore.nome;
        item.appendChild(span);

        operatoriDittaInnerContainer.appendChild(item);

        operatoriInnerContainer.appendChild(item);
    });

    containerAnagrafiche.appendChild(operatoriContainer);

    getTotaleOperatori();
    
    Swal.close();

    $( ".connectedSortable" ).sortable
    ({
        connectWith: ".connectedSortable",
        start: function( event, ui )
        {
            var elements=document.getElementsByClassName("inner-container-operatori-inserimento-anagrafiche");
            for (let index = 0; index < elements.length; index++)
            {
                var element = elements[index];
                element.style.backgroundColor="#4c92cb11";
                element.style.borderColor="#4C91CB";
            }
        },
        stop: function( event, ui )
        {
            var elements=document.getElementsByClassName("inner-container-operatori-inserimento-anagrafiche");
            for (let index = 0; index < elements.length; index++)
            {
                var element = elements[index];
                element.style.backgroundColor="";
                element.style.borderColor="";
            }
        },
        update: function( event, ui )
                {
                    var item=ui.item;
                    var changedList = this.id;

                    if(sortableDropHelper.origin==null)
                    {
                        sortableDropHelper.origin=changedList;
                    }
                    else
                    {
                        sortableDropHelper.target=changedList;

                        sortableDropHelper.item=item;

                        if(sortableDropHelper.target!=sortableDropHelper.origin && sortableDropHelper.target!=null && sortableDropHelper.origin!=null)
                        {
                            var id_operatore=sortableDropHelper.item.attr("id_operatore");
                            var nome=sortableDropHelper.item.attr("nome");
                            var cognome=sortableDropHelper.item.attr("cognome");
                            var orePred=sortableDropHelper.item.attr("orePred");

                            if(sortableDropHelper.origin!="operatoriContainer")
                            {
                                rimuoviOperatoreDitta(id_operatore);
                            }
                            if(sortableDropHelper.target!="operatoriContainer")
                            {
                                aggiungiOperatoreDitta(id_operatore);
                            }

                            sortableDropHelper.origin=null;
                            sortableDropHelper.target=null;
                            sortableDropHelper.item=null;

                            getTotaleOperatori();
                        }
                    }
                }
    }).disableSelection();
}
function getTotaleOperatori()
{
    var nOperatori=document.getElementById("operatoriContainer").childElementCount;
    var nOperatoriDitta=document.getElementById("operatoriDittaContainer").childElementCount;

    document.getElementById("nOperatori").innerHTML=nOperatori+" operatori disponibili";
    document.getElementById("nOperatoriDitta").innerHTML=nOperatoriDitta+" operatori assegnati";
}
function rimuoviOperatoreDitta(id_operatore)
{
    $.get("rimuoviOperatoreDitta.php",
    {
        id_operatore
    },
    function(response, status)
    {
        if(status=="success")
        {
            console.log(response);
        }
    });
}
function aggiungiOperatoreDitta(id_operatore)
{
    $.get("aggiungiOperatoreDitta.php",
    {
        id_operatore,
        id_ditta
    },
    function(response, status)
    {
        if(status=="success")
        {
            console.log(response);
        }
    });
}
function getOperatori()
{
    return new Promise(function (resolve, reject) 
    {
        $.get("getOperatori.php",
        function(response, status)
        {
            if(status=="success")
            {
                resolve(JSON.parse(response));
            }
        });
    });
}
function getOperatoriDitta(id_ditta)
{
    return new Promise(function (resolve, reject) 
    {
        $.get("getOperatoriDitta.php",
        {
            id_ditta
        },
        function(response, status)
        {
            if(status=="success")
            {
                resolve(JSON.parse(response));
            }
        });
    });
}
function getDitte()
{
    return new Promise(function (resolve, reject) 
    {
        $.get("getDitte.php",
        function(response, status)
        {
            if(status=="success")
            {
                resolve(JSON.parse(response));
            }
        });
    });
}
window.addEventListener("keydown", function(event)
{
    var code = (event.keyCode ? event.keyCode : event.which);
    if (code == 13) 
    {
        event.preventDefault();
    }
});
function getFirstObjByPropValue(array,prop,propValue)
{
    var return_item;
    array.forEach(function(item)
    {
        if(item[prop]==propValue)
        {
            return_item= item;
        }
    });
    return return_item;
}