<?php

	include "connessione.php";
	include "Session.php";
	
	$id_registrazione=$_REQUEST['id_registrazione'];

	echo "<table id='myTableReport' style='border-collapse: collapse;width:100%;border:1px solid gray'>";
		echo "<tr>";
			echo "<th style='text-align:left;font-weight:bold;border-bottom:1px solid gray;padding:5px;font-size:70%'>ID</th>";
			echo "<th style='text-align:left;font-weight:bold;border-bottom:1px solid gray;padding:5px;font-size:70%'>Data</th>";
			echo "<th style='text-align:left;font-weight:bold;border-bottom:1px solid gray;padding:5px;font-size:70%'>Creatore</th>";
			echo "<th style='text-align:left;font-weight:bold;border-bottom:1px solid gray;padding:5px;font-size:70%'>Note registrazione</th>";
			echo "<th style='text-align:left;font-weight:bold;border-bottom:1px solid gray;padding:5px;font-size:70%'>Ditta</th>";
			echo "<th style='text-align:left;font-weight:bold;border-bottom:1px solid gray;padding:5px;font-size:70%'>Ponte</th>";
			echo "<th style='text-align:left;font-weight:bold;border-bottom:1px solid gray;padding:5px;font-size:70%'>Nome operatore</th>";
			echo "<th style='text-align:left;font-weight:bold;border-bottom:1px solid gray;padding:5px;font-size:70%'>Cognome operatore</th>";
			echo "<th style='text-align:left;font-weight:bold;border-bottom:1px solid gray;padding:5px;font-size:70%'>Ore</th>";
			echo "<th style='text-align:left;font-weight:bold;border-bottom:1px solid gray;padding:5px;font-size:70%'>Inserito da</th>";
			echo "<th style='text-align:left;font-weight:bold;border-bottom:1px solid gray;padding:5px;font-size:70%'>Note operatore</th>";
		echo "</tr>";
		$queryOperatore="SELECT [id_registrazione],[data],[username],[noteRegistrazione],[nomeDitta],[ponte],[nome],[cognome],[ore],[noteOperatore],[inseritoDa] FROM [dbo].[reportRegistrazioni] WHERE id_registrazione=$id_registrazione";
		$resultOperatore=sqlsrv_query($conn,$queryOperatore);
		if($resultOperatore==FALSE)
		{
			echo "<br><br>Errore esecuzione query<br>Query: ".$queryOperatore."<br>Errore: ";
			die(print_r(sqlsrv_errors(),TRUE));
		}
		else
		{
			while($rowOperatore=sqlsrv_fetch_array($resultOperatore))
			{
				echo "<tr>";
					echo "<td style='text-align:left;border-bottom:1px solid #ddd;padding:5px;font-size:60%'>".$rowOperatore['id_registrazione']."</td>";
					echo "<td style='text-align:left;border-bottom:1px solid #ddd;padding:5px;font-size:60%'>".$rowOperatore['data']->format('d/m/Y')."</td>";
					echo "<td style='text-align:left;border-bottom:1px solid #ddd;padding:5px;font-size:60%'>".$rowOperatore['username']."</td>";
					echo "<td style='text-align:left;border-bottom:1px solid #ddd;padding:5px;font-size:60%'>".$rowOperatore['noteRegistrazione']."</td>";
					echo "<td style='text-align:left;border-bottom:1px solid #ddd;padding:5px;font-size:60%'>".$rowOperatore['nomeDitta']."</td>";
					echo "<td style='text-align:left;border-bottom:1px solid #ddd;padding:5px;font-size:60%'>".$rowOperatore['ponte']."</td>";
					echo "<td style='text-align:left;border-bottom:1px solid #ddd;padding:5px;font-size:60%'>".$rowOperatore['nome']."</td>";
					echo "<td style='text-align:left;border-bottom:1px solid #ddd;padding:5px;font-size:60%'>".$rowOperatore['cognome']."</td>";
					echo "<td style='text-align:left;border-bottom:1px solid #ddd;padding:5px;font-size:60%'>".$rowOperatore['ore']."</td>";
					echo "<td style='text-align:left;border-bottom:1px solid #ddd;padding:5px;font-size:60%'>".$rowOperatore['inseritoDa']."</td>";
					echo "<td style='text-align:left;border-bottom:1px solid #ddd;padding:5px;font-size:60%'>".$rowOperatore['noteOperatore']."</td>";
				echo "</tr>";
			}
		}
	echo "</table>";
?>
