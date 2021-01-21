<?php
	include "connessione.php";
	include "Session.php";

	if(set_time_limit(240))
	{
		$Deck=$_REQUEST['Deck'];
		$FZ=$_REQUEST['FZ'];
		$gruppo=$_REQUEST['gruppo'];
		$orderBy=$_REQUEST['orderBy'];
		
		$attivitaParentesi=array();
		$attivita=array();
		
		/*echo "<div id='containerIntestazione'>";
			echo "<div id='intestazioneTabella'>";
			echo "<div class='intestazione-tabella-row'>";
				echo "<span>Gruppo:";
					costruisciSelectGruppo($conn,"Gruppo",$gruppo);
				echo "</span>";
				echo "<div onclick='showPopupLegenda()'>Legenda<i class='far fa-question-circle' style='margin-left:5px;'></i></div>";
				echo '<input type="button" value="" id="btnChiudiPrg" onclick="'. 'gotopath(' . htmlspecialchars(json_encode("gestionePrg.php")) . ')" />';
				echo '<input type="button" value="" id="btnFullScreen" onclick="'. 'fullscreen()" />';
			echo "</div>";
			echo "<div class='intestazione-tabella-row'>";
				echo "<span>Commessa: ".$_SESSION['commessa']."</span>";
				echo "<span style='margin-left:10px'>Ordinamento attività:";
					echo '<select id="selectOrdinamentoPrg" onchange="creaTabella()">
						<option value="posizione DESC">Posizione descrescente</option>
						<option value="posizione ASC">Posizione crescente</option>
						<option value="descrizione DESC">Nome descrescente</option>
						<option value="descrizione ASC">Nome crescente</option>
					</select>';
				echo "</span>";
				echo "<input type='button' value='Registra' onclick='registra()' id='btnRegistra' />";
			echo "</div>";
		echo "</div>";*/
		echo "<div id='containerIntestazione'>";
			echo "<div id='intestazioneTabella'>";
			echo "<div class='intestazione-tabella-row'>";
				echo "<div class='intestazione-tabella-div'>";
					echo "<span>Gruppo:";
						costruisciSelectGruppo($conn,"Gruppo",$gruppo);
					echo "</span>";
				echo "</div>";
				echo "<button class='intestazione-tabella-button' onclick='showPopupLegenda()' style='margin-left:5px'><span>Legenda</span><i class='far fa-question-circle'></i></button>";
				echo '<button class="intestazione-tabella-icon-button" id="btnFullScreen" onclick="'. 'fullscreen()" /><i class="fal fa-expand-wide"></i></button>';
				echo '<button class="intestazione-tabella-icon-button" id="btnChiudiPrg" onclick="'. 'gotopath(' . htmlspecialchars(json_encode("gestionePrg.php")) . ')" ><i class="fal fa-times"></i></button></button>';
			echo "</div>";
			echo "<div class='intestazione-tabella-row'>";
				echo "<div class='intestazione-tabella-div'>";echo "<span>Commessa: <b>".$_SESSION['commessa']."</b></span>";echo "</div>";
				echo "<div class='intestazione-tabella-div' style='margin-left:15px'>";
					echo "<span>Ordinamento attività:</span>";
					echo '<div id="selectOrdinamentoPrgContainer"></div>';
					/*echo '<select id="selectOrdinamentoPrg" onchange="setCookie(' . htmlspecialchars(json_encode("selectOrdinamentoPrg")) . ',this.value);creaTabella()">';
						switch ($orderBy)
						{
							case 'posizione ASC':echo '<option value="posizione ASC">Posizione crescente</option>';break;
							case 'descrizione ASC':echo '<option value="descrizione ASC">Nome crescente</option>';break;
							case 'posizione DESC':echo '<option value="posizione DESC">Posizione descrescente</option>';break;
							case 'descrizione DESC':echo '<option value="descrizione DESC">Nome descrescente</option>';break;						
						}
						if($orderBy!="posizione ASC")
						echo '<option value="posizione ASC">Posizione crescente</option>';
						if($orderBy!="descrizione ASC")
							echo '<option value="descrizione ASC">Nome crescente</option>';
						if($orderBy!="posizione DESC")
						echo '<option value="posizione DESC">Posizione descrescente</option>';
							if($orderBy!="descrizione DESC")
						echo '<option value="descrizione DESC">Nome descrescente</option>';
					echo '</select>';*/
				echo "</div>";
				echo "<button style='margin-left:auto;opacity:0.6;background:#BFD5E1;height:30px;border:1px solid #0765D0;' class='intestazione-tabella-button' onclick='registra()' id='btnRegistra'><span style='color:#0765D0;font-weight:bold'>Registra</span></button>";
			echo "</div>";
		echo "</div>";
		//echo "||SPLIT||";
		echo "<table id='myTable'>";
			echo "<thead>";
				echo '<tr class="rigaFiltriAttivita">';
					echo '<th class="colonneFiltri" style="left:0">';
						costruisciSelect($conn,"Deck",$Deck,"permessi_ponti_utenti");
					echo '</th>';
					echo '<th class="colonneFiltri" style="left:100">';
						costruisciSelect($conn,"FZ",$FZ,"permessi_firezone_utenti");
					echo '</th>';
					echo '<th class="colonneFiltri" style="left:200">NCab</th>';
					$colonne=array();
					$queryColonne="SELECT * FROM gruppi_colonne WHERE gruppo=$gruppo  AND commessa=".$_SESSION['id_commessa']." ORDER BY $orderBy";
					$resultColonne=sqlsrv_query($conn,$queryColonne);
					if($resultColonne==FALSE)
					{
						echo "<br><br>Errore esecuzione query<br>Query: ".$queryColonne."<br>Errore: ";
						die(print_r(sqlsrv_errors(),TRUE));
					}
					else
					{
						$j=0;
						while($rowColonne=sqlsrv_fetch_array($resultColonne))
						{
							if($rowColonne['Descrizione']!="00" && $rowColonne['Descrizione']!="NCabina" && $rowColonne['Descrizione']!="commessa")
							{
								echo '<th class="attivita">'.$rowColonne['Descrizione'].'</th>';
								array_push($colonne,$rowColonne['Descrizione']);
								array_push($attivita,$rowColonne['Descrizione']);
								array_push($attivitaParentesi,"[".$rowColonne['Descrizione']."]");
							}
							$j++;
						}
					}
				echo '</tr>';
				getTotali($conn,$Deck,$FZ,$attivitaParentesi,$attivita);
			echo "</thead>";
	
			echo "<tbody>";
				echo "<tr class='spaceRow'></tr>";
			$queryRighe="SELECT distinct * 
						FROM (SELECT w1.numero_cabina AS nCabina, SUM(w1.valore) AS risultato, dbo.[tip cab].Deck AS ponte, CONVERT(varchar(2), dbo.[tip cab].FZ) AS firezone, 
						w1.Descrizione AS descrizione, w1.commessa
						FROM (SELECT dbo.tblDettagliAttSvolte.[numero cabina] AS numero_cabina, dbo.attivitasvolteV.codiceattivita AS codice_attivita, 10 AS valore, dbo.attivitasvolteV.commessa, dbo.Attivita.Descrizione
						FROM dbo.attivitasvolteV INNER JOIN
						dbo.Attivita ON dbo.attivitasvolteV.codiceattivita = dbo.Attivita.CodiceAttivita INNER JOIN
						dbo.tblDettagliAttSvolte ON dbo.attivitasvolteV.IDAttSvolte = dbo.tblDettagliAttSvolte.IDAttSvolteDettagli
						UNION ALL
						SELECT dbo.view_tblInternaCabineAttivita_1.numero_cabina AS nCabina, Attivita_1.CodiceAttivita AS codice_attivita, dbo.view_tblInternaCabineAttivita_1.val AS valore, dbo.view_tblInternaCabineAttivita_1.commessa, 
						dbo.view_tblInternaCabineAttivita_1.Descrizione
						FROM dbo.view_tblInternaCabineAttivita_1 INNER JOIN
						dbo.Attivita AS Attivita_1 ON dbo.view_tblInternaCabineAttivita_1.Descrizione = Attivita_1.Descrizione) AS w1 INNER JOIN
						dbo.[tip cab] ON w1.numero_cabina = dbo.[tip cab].[Nr# Cabina  Santarossa] AND w1.commessa = dbo.[tip cab].commessa
						GROUP BY w1.numero_cabina, dbo.[tip cab].Deck, CONVERT(varchar(2), dbo.[tip cab].FZ), dbo.[tip cab].Famiglia, dbo.[tip cab].[Pax/Crew], w1.Descrizione, w1.commessa
						HAVING (dbo.[tip cab].Deck LIKE N'$Deck') AND (CONVERT(varchar(2), dbo.[tip cab].FZ) LIKE '$FZ') AND (w1.commessa = ".$_SESSION['id_commessa'].")) t PIVOT (SUM(risultato) 
						FOR descrizione IN (".implode(",",$attivitaParentesi).")) p";//echo $queryRighe;
			$resultRighe=sqlsrv_query($conn,$queryRighe);
			if($resultRighe==FALSE)
			{
				echo "<br><br>Errore esecuzione query<br>Query: ".$queryRighe."<br>Errore: ";
				die(print_r(sqlsrv_errors(),TRUE));
			}
			else
			{//$a="";
				while($rowRighe=sqlsrv_fetch_array($resultRighe))
				{
					echo '<tr>';
						echo "<td class='righeFiltri'>".$rowRighe['ponte']."</td>";
						echo "<td class='righeFiltri'>".$rowRighe['firezone']."</td>";
						echo "<td class='righeFiltri'>".$rowRighe['nCabina']."</td>";
						foreach ($attivita as $value) 
						{
							if($rowRighe[$value]==11)
							{
								if(checkNote($conn,$rowRighe['nCabina'],$value))
									echo '<td class="celleLavorate" style="border:4px solid #BFD5E1;" onclick="popupRegistrazione(' . htmlspecialchars(json_encode($rowRighe['nCabina'])) . ','. htmlspecialchars(json_encode($value)) . ')"></td>';//verde
								else
									echo '<td class="celleLavorate" onclick="popupRegistrazione(' . htmlspecialchars(json_encode($rowRighe['nCabina'])) . ','. htmlspecialchars(json_encode($value)) . ')"></td>';//verde
							}
							if($rowRighe[$value]==0)
								echo "<td class='celleDisabled'></td>";//grigio
							if($rowRighe[$value]==1)
								echo '<td class="celle" id="cell'.$rowRighe['nCabina'].''.$value.'" title="Cabina: '.$rowRighe['nCabina'].'  |  Attivita: '.$value.'" onclick="'. 'setSelezionata(' . htmlspecialchars(json_encode($rowRighe['nCabina'])) . ','. htmlspecialchars(json_encode($value)) . ')"></td>';//niente
							if($rowRighe[$value]!=11 && $rowRighe[$value]!=0 && $rowRighe[$value]!=1)
								echo '<td class="celleDisabled" onclick="popupRegistrazione(' . htmlspecialchars(json_encode($rowRighe['nCabina'])) . ','. htmlspecialchars(json_encode($value)) . ')" style="background:red"></td>';//rosso
						}
					echo '</tr>';
				}
			}
			echo "</tbody>";
		echo "</table>";
		//echo $a;
		echo "<span style='display:none'>#endofresponse#</span>";
	}
	else
		echo "<b style='color:red'>Errore di sistema: </b>Contattare l' amministratore";
	
	
	
	function getTotali($conn,$Deck,$FZ,$attivitaParentesi,$attivita)
	{
		$totali=array();
		foreach ($attivita as $value) 
		{
			array_push($totali,0);
		}
		$queryRighe="SELECT distinct * 
					FROM (SELECT w1.numero_cabina AS nCabina, SUM(w1.valore) AS risultato, dbo.[tip cab].Deck AS ponte, CONVERT(varchar(2), dbo.[tip cab].FZ) AS firezone, 
					w1.Descrizione AS descrizione, w1.commessa
					FROM (SELECT dbo.tblDettagliAttSvolte.[numero cabina] AS numero_cabina, dbo.attivitasvolteV.codiceattivita AS codice_attivita, 10 AS valore, dbo.attivitasvolteV.commessa, dbo.Attivita.Descrizione
					FROM dbo.attivitasvolteV INNER JOIN
					dbo.Attivita ON dbo.attivitasvolteV.codiceattivita = dbo.Attivita.CodiceAttivita INNER JOIN
					dbo.tblDettagliAttSvolte ON dbo.attivitasvolteV.IDAttSvolte = dbo.tblDettagliAttSvolte.IDAttSvolteDettagli
					UNION ALL
					SELECT dbo.view_tblInternaCabineAttivita_1.numero_cabina AS nCabina, Attivita_1.CodiceAttivita AS codice_attivita, dbo.view_tblInternaCabineAttivita_1.val AS valore, dbo.view_tblInternaCabineAttivita_1.commessa, 
					dbo.view_tblInternaCabineAttivita_1.Descrizione
					FROM dbo.view_tblInternaCabineAttivita_1 INNER JOIN
					dbo.Attivita AS Attivita_1 ON dbo.view_tblInternaCabineAttivita_1.Descrizione = Attivita_1.Descrizione) AS w1 INNER JOIN
					dbo.[tip cab] ON w1.numero_cabina = dbo.[tip cab].[Nr# Cabina  Santarossa] AND w1.commessa = dbo.[tip cab].commessa
					GROUP BY w1.numero_cabina, dbo.[tip cab].Deck, CONVERT(varchar(2), dbo.[tip cab].FZ), dbo.[tip cab].Famiglia, dbo.[tip cab].[Pax/Crew], w1.Descrizione, w1.commessa
					HAVING (dbo.[tip cab].Deck LIKE N'$Deck') AND (CONVERT(varchar(2), dbo.[tip cab].FZ) LIKE '$FZ') AND (w1.commessa = ".$_SESSION['id_commessa'].")) t PIVOT (SUM(risultato) 
					FOR descrizione IN (".implode(",",$attivitaParentesi).")) p";
		$resultRighe=sqlsrv_query($conn,$queryRighe);
		if($resultRighe==FALSE)
		{
			echo "<br><br>Errore esecuzione query<br>Query: ".$queryRighe."<br>Errore: ";
			die(print_r(sqlsrv_errors(),TRUE));
		}
		else
		{
			while($rowRighe=sqlsrv_fetch_array($resultRighe))
			{
				$i=0;
				foreach ($attivita as $value) 
				{
					if($rowRighe[$value]==11)
					{
						$totali[$i]=$totali[$i]+1;
					}
					$i++;
				}
			}
		}
		
		
		
		echo '<tr class="rigaTotali">';
			echo "<td class='righeFiltri' style='border-right:1px solid #BFD5E1;'></td>";
			echo "<td class='righeFiltri' style='border-right:1px solid #BFD5E1;border-left:1px solid #BFD5E1'>TOTALI: </td>";
			echo "<td class='righeFiltri' style='border-left:1px solid #BFD5E1;'></td>";
			$j=0;
			foreach ($attivita as $value) 
			{
				echo "<td class='celleTotali'>".($totali[$j])."</td>";
				$j++;
			}
			
		echo '</tr>';
	}
	function checkNote($conn,$NCabina,$colonna)
	{
		$query="SELECT * FROM cantiere_note WHERE numero_cabina='$NCabina' AND descrizione='$colonna' AND utente=".getIdUtenteGestionePrg($conn)." AND commessa=".$_SESSION['id_commessa'];
		$result=sqlsrv_query($conn,$query);
		if($result==FALSE)
		{
			echo "<br><br>Errore esecuzione query<br>Query: ".$query."<br>Errore: ";
			die(print_r(sqlsrv_errors(),TRUE));
		}
		else
		{
			$rows = sqlsrv_has_rows( $result );
			if ($rows === true)
				return true;
			else
				return false;
		}
	}
	function getCella($conn,$NCabina,$colonna)
	{
		$query="SELECT [$colonna] FROM  dbo.view_tblInternaCabineAttivita INNER JOIN dbo.[tip cab] ON dbo.view_tblInternaCabineAttivita.NCabina = dbo.[tip cab].[Nr# Cabina  Santarossa] WHERE NCabina='$NCabina' AND dbo.[tip cab].commessa=".$_SESSION['id_commessa'];
		$result=sqlsrv_query($conn,$query);
		if($result==FALSE)
		{
			echo "<br><br>Errore esecuzione query<br>Query: ".$query."<br>Errore: ";
			die(print_r(sqlsrv_errors(),TRUE));
		}
		else
		{
			while($row=sqlsrv_fetch_array($result))
			{
				return $row[$colonna];
			}
		}
	}
	
	function getLavorato($conn,$NCabina,$colonna)
	{
		$query="SELECT * FROM [cabineLavorate] WHERE NCabina='$NCabina' AND Descrizione='$colonna' AND commessa=".$_SESSION['id_commessa'];
		$result=sqlsrv_query($conn,$query);
		if($result==FALSE)
		{
			echo "<br><br>Errore esecuzione query<br>Query: ".$query."<br>Errore: ";
			die(print_r(sqlsrv_errors(),TRUE));
		}
		else
		{
			$rows = sqlsrv_has_rows( $result );
			if ($rows === true)
				return 1;
			else 
				return 0;
		}
	}
	
	function costruisciSelect($conn,$colonna,$valore,$vista)
	{
		echo $colonna."<br>";
		if($valore!='%')
		{
			echo "<select id='filtro$colonna' class='selectFiltro' onchange='creaTabella()'>";
			if($valore!='')
				echo "<option value='$valore'>$valore</option>";
		}
		else
			echo "<select id='filtro$colonna' class='selectFiltro' onchange='creaTabella()'>";
		$query1="SELECT COUNT (*) AS n1 FROM (SELECT DISTINCT $colonna FROM $vista WHERE commessa=".$_SESSION['id_commessa']." AND username='".$_SESSION['Username']."') AS derivedtbl_1";
		$result1=sqlsrv_query($conn,$query1);
		if($result1==FALSE)
		{
			echo "<br><br>Errore esecuzione query<br>Query: ".$query1."<br>Errore: ";
			die(print_r(sqlsrv_errors(),TRUE));
		}
		else
		{
			while($row1=sqlsrv_fetch_array($result1))
			{
				$n1=$row1['n1'];
			}
		}
		$query2="SELECT COUNT(DISTINCT $colonna) AS n2 FROM dbo.[tip cab]";
		$result2=sqlsrv_query($conn,$query2);
		if($result2==FALSE)
		{
			echo "<br><br>Errore esecuzione query<br>Query: ".$query2."<br>Errore: ";
			die(print_r(sqlsrv_errors(),TRUE));
		}
		else
		{
			while($row2=sqlsrv_fetch_array($result2))
			{
				$n2=$row2['n2'];
			}
		}
		if($n1==$n2)
			echo "<option value='%'>Tutti</option>";
		if($valore!='%')
			$querycolonna="SELECT DISTINCT $colonna FROM $vista WHERE [$colonna] <> '$valore' AND commessa=".$_SESSION['id_commessa']." AND username='".$_SESSION['Username']."' ORDER BY $colonna ";
		else
			$querycolonna="SELECT DISTINCT $colonna FROM $vista WHERE commessa=".$_SESSION['id_commessa']." AND username='".$_SESSION['Username']."' ORDER BY $colonna ";
		$resultcolonna=sqlsrv_query($conn,$querycolonna);
		if($resultcolonna==FALSE)
		{
			echo "<br><br>Errore esecuzione query<br>Query: ".$querycolonna."<br>Errore: ";
			die(print_r(sqlsrv_errors(),TRUE));
		}
		else
		{
			while($rowcolonna=sqlsrv_fetch_array($resultcolonna))
			{
				echo "<option value='".$rowcolonna[$colonna]."'>".$rowcolonna[$colonna]."</option>";
			}
		}
		echo "</select>";
		/*if($valore!='%')
		{
			echo "<select id='filtro$colonna' class='selectFiltro' onchange='creaTabella()'>";
			if($valore=='')
				echo "<option value='$valore'>$colonna: NULL</option>";
			else
				echo "<option value='$valore'>$colonna: $valore</option>";
		}
		else
			echo "<select id='filtro$colonna' class='selectFiltro' onchange='creaTabella()'>";
		
		echo "<option value='%'>$colonna: Tutti</option>";
		if($valore!='%')
			$querycolonna="SELECT DISTINCT [$colonna] FROM  dbo.view_tblInternaCabineAttivita INNER JOIN dbo.[tip cab] ON dbo.view_tblInternaCabineAttivita.NCabina = dbo.[tip cab].[Nr# Cabina  Santarossa] WHERE [$colonna] <> '$valore' AND dbo.[tip cab].commessa=".$_SESSION['id_commessa']." ORDER BY [$colonna] ";
		else
			$querycolonna="SELECT DISTINCT [$colonna] FROM  dbo.view_tblInternaCabineAttivita INNER JOIN dbo.[tip cab] ON dbo.view_tblInternaCabineAttivita.NCabina = dbo.[tip cab].[Nr# Cabina  Santarossa] WHERE dbo.[tip cab].commessa=".$_SESSION['id_commessa']." ORDER BY [$colonna] ";
		$resultcolonna=sqlsrv_query($conn,$querycolonna);
		if($resultcolonna==FALSE)
		{
			echo "<br><br>Errore esecuzione query<br>Query: ".$querycolonna."<br>Errore: ";
			die(print_r(sqlsrv_errors(),TRUE));
		}
		else
		{
			while($rowcolonna=sqlsrv_fetch_array($resultcolonna))
			{
				if($rowcolonna[$colonna]==NULL || $rowcolonna[$colonna]=='')
					echo "<option value='".$rowcolonna[$colonna]."'>$colonna: NULL</option>";
				else
					echo "<option value='".$rowcolonna[$colonna]."'>$colonna: ".$rowcolonna[$colonna]."</option>";
			}
		}
		echo "</select>";*/
	}
	
	function costruisciSelectGruppo($conn,$colonna,$valore)
	{
		echo "<select id='filtro$colonna' class='selectFiltroGruppo' onchange='creaTabella()'>";
		echo "<option value='$valore'>".getNomeGruppo($conn,$valore)."</option>";
		
		//$querycolonna="SELECT * FROM gruppi WHERE [id_gruppo] <> '$valore' AND commessa=".$_SESSION['id_commessa']." ORDER BY [nomeGruppo] ";
		$querycolonna="SELECT *
						FROM dbo.gruppi
						WHERE (commessa = ".$_SESSION['id_commessa'].") AND (id_gruppo IN
						(SELECT gruppo
						FROM dbo.permessi_gruppo
						WHERE [gruppo] <> '$valore' AND (utente = ".getIdUtenteGestionePrg($conn)."))) AND (griglia = 'true')";
		$resultcolonna=sqlsrv_query($conn,$querycolonna);
		if($resultcolonna==FALSE)
		{
			echo "<br><br>Errore esecuzione query<br>Query: ".$querycolonna."<br>Errore: ";
			die(print_r(sqlsrv_errors(),TRUE));
		}
		else
		{
			while($rowcolonna=sqlsrv_fetch_array($resultcolonna))
			{
				echo "<option value='".$rowcolonna['id_gruppo']."'>".$rowcolonna['nomeGruppo']."</option>";
			}
		}
		echo "</select>";
	}
	function getIdUtenteGestionePrg($conn)
	{
		$query="SELECT id_utente FROM  utenti WHERE username='".$_SESSION['Username']."'";
		$result=sqlsrv_query($conn,$query);
		if($result==FALSE)
		{
			echo "<br><br>Errore esecuzione query<br>Query: ".$query."<br>Errore: ";
			die(print_r(sqlsrv_errors(),TRUE));
		}
		else
		{
			while($row=sqlsrv_fetch_array($result))
			{
				return $row['id_utente'];
			}
		}
	}
	function getNomeGruppo($conn,$id_gruppo)
	{
		$querycolonna="SELECT nomeGruppo FROM gruppi WHERE [id_gruppo] = $id_gruppo AND commessa=".$_SESSION['id_commessa'];
		$resultcolonna=sqlsrv_query($conn,$querycolonna);
		if($resultcolonna==FALSE)
		{
			echo "<br><br>Errore esecuzione query<br>Query: ".$querycolonna."<br>Errore: ";
			die(print_r(sqlsrv_errors(),TRUE));
		}
		else
		{
			while($rowcolonna=sqlsrv_fetch_array($resultcolonna))
			{
				return $rowcolonna['nomeGruppo'];
			}
		}
	}
?>