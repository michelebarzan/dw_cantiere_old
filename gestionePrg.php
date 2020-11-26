<?php
	include "Session.php";
	include "connessione.php";
	
	$pageName="Griglia registrazioni";
	$appName="Cantiere";
?>
<html>
	<head>
		<title><?php echo $appName."&nbsp&#8594&nbsp".$pageName; ?></title>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
			<link rel="shortcut icon" type="image/x-icon" href="images/logo.png" />
			<link rel="stylesheet" href="css/styleV15.css" />
			<script src="struttura.js"></script>
			<script>
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
							document.getElementById("popupAttivitaGruppo").style.left=x-20;
							document.getElementById("popupAttivitaGruppo").style.top=y-20;
							document.getElementById("popupAttivitaGruppo").style.display="inline-block";
						}
					};
					xmlhttp.open("POST", "attivitaGruppo.php?gruppo="+gruppo, true);
					xmlhttp.send();
				}
			</script>
			<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
	</head>
	<body onload="aggiungiNotifica('Stai lavorando sulla commessa <?php echo $_SESSION['commessa']; ?>');">
		<?php include('struttura.php'); ?>
		<div id="popupAttivitaGruppo" onmouseout='document.getElementById("popupAttivitaGruppo").style.display="none";'></div>
		<div id="container"style="width:auto">
			<div id="content">
				<div class="logo" style="width:100%;margin-top:30px">
					<img src="images/logo.png">
				</div>
				<form action="prg.php" id="formGestionePrg" method="POST" >
					<div id="gestionPrgContainer">
						<div class="inputContainerGestionPrg">
							<div class="inputLabelGestionPrg">Gruppo</div>
							<select class="inputGestionPrg" id='filtroGruppo1' name='filtroGruppo1' required>
								<?php getSelectGruppo($conn); ?>
							</select>
						</div>
						<div class="inputContainerGestionPrg">
							<div class="inputLabelGestionPrg">Ponte</div>
							<select class="inputGestionPrg" id='filtroDeck1' name='filtroDeck1' required>
								<?php getSelectPonte($conn); ?>
							</select>
						</div>
						<div class="inputContainerGestionPrg">
							<div class="inputLabelGestionPrg">Firezone</div>
							<select class="inputGestionPrg" id='filtroFZ1' name='filtroFZ1' required>
								<?php getSelectFirezone($conn); ?>
							</select>
							<input type="submit" class="bottoneConfermaGestionPrg" value="Conferma">
						</div>
						<div></div>
					</div>
				</form>
			</div>
		</div>
		<div id="push"></div>
		<div id="footer">
			<!--<hr size='1' style='border-color:white;'>-->
			<b>De&nbspWave&nbspS.r.l.</b>&nbsp&nbsp|&nbsp&nbspVia&nbspDe&nbspMarini&nbsp116149&nbspGenova&nbspItaly&nbsp&nbsp|&nbsp&nbspPhone:&nbsp(+39)&nbsp010&nbsp640201
		</div>
	</body>
</html>

<?php

	function getSelectGruppo($conn)
	{
		$querycolonna0="SELECT id_gruppo, nomeGruppo, commessa, griglia
						FROM dbo.gruppi
						WHERE (commessa = ".$_SESSION['id_commessa'].") AND (id_gruppo IN
						(SELECT gruppo
						FROM dbo.permessi_gruppo
						WHERE (utente = ".getIdUtenteGestionePrg($conn)."))) AND (griglia = 'true')";
		$resultcolonna0=sqlsrv_query($conn,$querycolonna0);
		if($resultcolonna0==FALSE)
		{
			echo "<br><br>Errore esecuzione query<br>Query: ".$querycolonna0."<br>Errore: ";
			die(print_r(sqlsrv_errors(),TRUE));
		}
		else
		{
			while($rowcolonna0=sqlsrv_fetch_array($resultcolonna0))
			{
				echo "<option value='".$rowcolonna0['id_gruppo']."'>".$rowcolonna0['nomeGruppo']."</option>";
			}
		}
	}
	function getSelectPonte($conn)
	{
		$query1="SELECT COUNT (*) AS nPonti1 FROM (SELECT DISTINCT Deck FROM permessi_ponti_utenti WHERE commessa=".$_SESSION['id_commessa']." AND username='".$_SESSION['Username']."') AS derivedtbl_1";
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
				$nPonti1=$row1['nPonti1'];
			}
		}
		$query2="SELECT COUNT(DISTINCT Deck) AS nPonti2 FROM dbo.[tip cab] WHERE commessa=".$_SESSION['id_commessa'];
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
				$nPonti2=$row2['nPonti2'];
			}
		}
		if($nPonti1==$nPonti2)
			echo "<option value='%'>Tutti</option>";
		$querycolonna1="SELECT DISTINCT Deck FROM permessi_ponti_utenti WHERE commessa=".$_SESSION['id_commessa']." AND username='".$_SESSION['Username']."' ORDER BY Deck ";
		$resultcolonna1=sqlsrv_query($conn,$querycolonna1);
		if($resultcolonna1==FALSE)
		{
			echo "<br><br>Errore esecuzione query<br>Query: ".$querycolonna1."<br>Errore: ";
			die(print_r(sqlsrv_errors(),TRUE));
		}
		else
		{
			while($rowcolonna1=sqlsrv_fetch_array($resultcolonna1))
			{
				echo "<option value='".$rowcolonna1['Deck']."'>".$rowcolonna1['Deck']."</option>";
			}
		}
	}
	function getSelectFirezone($conn)
	{
		$query1="SELECT COUNT (*) AS nFirezone1 FROM (SELECT DISTINCT FZ FROM permessi_firezone_utenti WHERE commessa=".$_SESSION['id_commessa']." AND username='".$_SESSION['Username']."') AS derivedtbl_1";
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
				$nFirezone1=$row1['nFirezone1'];
			}
		}
		$query2="SELECT COUNT(DISTINCT FZ) AS nFirezone2 FROM dbo.[tip cab]";
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
				$nFirezone2=$row2['nFirezone2'];
			}
		}
		if($nFirezone1==$nFirezone2)
			echo "<option value='%'>Tutte</option>";
		$querycolonna1="SELECT DISTINCT FZ FROM permessi_firezone_utenti WHERE commessa=".$_SESSION['id_commessa']." AND username='".$_SESSION['Username']."' ORDER BY FZ";
		$resultcolonna1=sqlsrv_query($conn,$querycolonna1);
		if($resultcolonna1==FALSE)
		{
			echo "<br><br>Errore esecuzione query<br>Query: ".$querycolonna1."<br>Errore: ";
			die(print_r(sqlsrv_errors(),TRUE));
		}
		else
		{
			while($rowcolonna1=sqlsrv_fetch_array($resultcolonna1))
			{
				echo "<option value='".$rowcolonna1['FZ']."'>".$rowcolonna1['FZ']."</option>";
			}
		}
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
	function creaview_tblInternaCabineAttivita($conn)
	{
		$arrayColonne=[];
		array_push($arrayColonne," ISNULL([00],0) AS [00]");
		$query="SELECT Descrizione FROM programmazione_attivita";
		$result=sqlsrv_query($conn,$query);
		if($result==FALSE)
		{
			echo "<br><br>Errore esecuzione query<br>Query: ".$query."<br>Errore: ";
			die(print_r(sqlsrv_errors(),TRUE));
		}
		else
		{
			$query2="SELECT * FROM  
					(SELECT numero_cabina,commessa,Descrizione,val 
						FROM   dbo.view_tblInternaCabineAttivita_1 where commessa=".$_SESSION['id_commessa']."
					) AS SourceTable  
					PIVOT  
					(  
					SUM(val)  
					FOR Descrizione IN ([00]";
			while($row=sqlsrv_fetch_array($result))
			{
				array_push($arrayColonne," ISNULL([".$row['Descrizione']."],0) AS [".$row['Descrizione']."]");
				$query2=$query2.",[".$row['Descrizione']."]";
			}
			$query2=$query2.")) AS PivotTable";
			//echo $query2;
			$query4="drop view view_tblInternaCabineAttivita_2";
			$result4=sqlsrv_query($conn,$query4);
			if($result4==FALSE)
			{
				echo "<br><br>Errore esecuzione query<br>Query: ".$query4."<br>Errore: ";
				die(print_r(sqlsrv_errors(),TRUE));
			}
			else
			{
				echo "ok1";
				$query3="create view view_tblInternaCabineAttivita_2 as ".$query2;
				$result3=sqlsrv_query($conn,$query3);
				if($result3==FALSE)
				{
					echo "<br><br>Errore esecuzione query<br>Query: ".$query3."<br>Errore: ";
					die(print_r(sqlsrv_errors(),TRUE));
				}
				else
				{
					echo "ok2";
					$query5="drop view view_tblInternaCabineAttivita";
					$result5=sqlsrv_query($conn,$query5);
					if($result5==FALSE)
					{
						echo "<br><br>Errore esecuzione query<br>Query: ".$query5."<br>Errore: ";
						die(print_r(sqlsrv_errors(),TRUE));
					}
					else
					{
						echo "ok3";
						$query6="CREATE VIEW view_tblInternaCabineAttivita AS SELECT numero_cabina AS NCabina, commessa, ".implode(",",$arrayColonne)." FROM view_tblInternaCabineAttivita_2";
						$result6=sqlsrv_query($conn,$query6);
						if($result6==FALSE)
						{
							echo "<br><br>Errore esecuzione query<br>Query: ".$query6."<br>Errore: ";
							die(print_r(sqlsrv_errors(),TRUE));
						}
						else
						{
							echo "ok4";
						}
					}
				}
			}
		}
	}

?>

