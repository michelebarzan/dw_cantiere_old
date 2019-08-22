<?php

	include "connessione.php";
	include "Session.php";
	
	$queryRighe="SELECT cantiere_registrazioni.*,utenti.username FROM cantiere_registrazioni,utenti WHERE cantiere_registrazioni.utente=utenti.id_utente AND cantiere_registrazioni.commessa=".$_SESSION['id_commessa']." ORDER BY data DESC";
	$resultRighe=sqlsrv_query($conn,$queryRighe);
	if($resultRighe==FALSE)
	{
		echo "<br><br>Errore esecuzione query<br>Query: ".$queryRighe."<br>Errore: ";
		die(print_r(sqlsrv_errors(),TRUE));
	}
	else
	{
		echo "<table id='myTableElencoRegistrazioni'>";
			echo "<tr>";
				echo "<th>Id</th>";
				echo "<th>Data</th>";
				echo "<th>Creatore</th>";
				echo "<th>Note</th>";
				echo "<th></th>";
			echo "</tr>";
			while($rowRighe=sqlsrv_fetch_array($resultRighe))
			{
				echo "<tr id='rigaRegistrazione".$rowRighe['id_registrazione']."' class='righeRegistraioni' onclick='selezionaRegistrazione(".$rowRighe['id_registrazione'].",".htmlspecialchars(json_encode($rowRighe['data']->format('d/m/Y'))).")'>";
					echo "<td>".$rowRighe['id_registrazione']."</td>";
					echo "<td>".$rowRighe['data']->format('d/m/Y')."</td>";
					echo "<td>".$rowRighe['username']."</td>";
					echo '<td><i class="fal fa-file-alt" style="font-size:140%" title="Modifica note" onclick="apriPopupModificaNoteRegistrazione('.$rowRighe["id_registrazione"].')"></i></td>';
					echo "<td style='padding:0px'><input type='button' id='btnSelezionaRegistrazione".$rowRighe['id_registrazione']."' class='btnSelezionaRegistrazione' onclick='selezionaRegistrazione(".$rowRighe['id_registrazione'].",".htmlspecialchars(json_encode($rowRighe['data']->format('d/m/Y'))).")' /></td>";
				echo "</tr>";
			}
		echo "</table>";
	}
	
	
	
?>