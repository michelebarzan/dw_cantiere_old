<?php

	include "connessione.php";
	include "Session.php";
	
	$query2="SELECT cantiere_operatori_ditte.*,cantiere_ditte.nome AS nomeDitta FROM cantiere_operatori_ditte,cantiere_ditte WHERE cantiere_operatori_ditte.ditta=cantiere_ditte.id_ditta ORDER BY cantiere_ditte.nome";	
	$result2=sqlsrv_query($conn,$query2);
	if($result2==FALSE)
	{
		echo "<br><br>Errore esecuzione query<br>Query: ".$query2."<br>Errore: ";
		die(print_r(sqlsrv_errors(),TRUE));
	}
	else
	{
		echo "<table id='myTableGestioneAnagrafiche'>";
			echo "<tr>";
				echo "<th>Nome</th>";
				echo "<th>Cognome</th>";
				echo "<th>Ditta</th>";
				echo "<th>Ore</th>";
				echo "<th>Note</th>";
				echo "<th></th>";
				echo "<th></th>";
			echo "</tr>";
		while($row2=sqlsrv_fetch_array($result2))
		{
			echo "<tr id='rigaAnagrafica".$row2['id_operatore']."'>";
				echo '<td id="nomeAnagrafica'.$row2["id_operatore"].'" onkeyup="process(event, this)" contenteditable>'.$row2["nome"].'</td>';
				echo '<td id="cognomeAnagrafica'.$row2["id_operatore"].'" onkeyup="process(event, this)" contenteditable>'.$row2["cognome"].'</td>';
				echo '<td>';
					echo '<select id="dittaAnagrafica'.$row2["id_operatore"].'" class="transparentSelectAnagrafiche">';
						echo '<option value="'.$row2["ditta"].'">'.$row2["nomeDitta"].'</option>';
						getElencoDitte($conn,$row2["ditta"]);
					echo '</select>';
				echo '</td>';
				echo '<td id="oreAnagrafica'.$row2["id_operatore"].'" onkeyup="process(event, this)" contenteditable>'.$row2["orePred"].'</td>';
				echo '<td id="noteAnagrafica'.$row2["id_operatore"].'" onkeyup="process(event, this)" contenteditable>'.$row2["note"].'</td>';
				echo '<td><i class="fas fa-save" title="Salva modifiche" onclick="salvaModificheOperatore('.$row2["id_operatore"].')"></i></td>';
				echo '<td id="risultato'.$row2["id_operatore"].'" style="text-align:right;width:40px"></td>';
			echo "</tr>";
		}
			echo "<tr id='rigaNuovaAnagrafica'>";
				echo '<td id="nomeNuovaAnagrafica" onkeyup="process(event, this)" contenteditable></td>';
				echo '<td id="cognomeNuovaAnagrafica" onkeyup="process(event, this)" contenteditable></td>';
				echo "<td>";
					echo '<select id="dittaNuovaAnagrafica" class="transparentSelectAnagrafiche">';
						echo '<option value="" disabled selected>Ditta</option>';
						getElencoDitte($conn,0);
					echo '</select>';
				echo "</td>";
				echo '<td id="oreNuovaAnagrafica" onkeyup="process(event, this)" contenteditable></td>';
				echo '<td id="noteNuovaAnagrafica" onkeyup="process(event, this)" contenteditable></td>';
				echo '<td><i class="fas fa-user-plus"  title="Inserisci operatore" onclick="inserisciOperatore()"></i></td>';
				echo '<td id="risultatoNuovaAnagrafica" style="text-align:right;width:40px"></td>';
			echo "</tr>";
		echo "</table>";
	}

	function getElencoDitte($conn,$id_ditta)
	{
		$query2="SELECT * FROM cantiere_ditte WHERE id_ditta<>$id_ditta";	
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
				echo '<option value="'.$row2["id_ditta"].'">'.$row2["nome"].'</option>';
			}
		}
	}
	
?>