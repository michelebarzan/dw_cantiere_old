<?php

	include "connessione.php";
	include "Session.php";
	
	$query2="SELECT cantiere_ditte.* FROM cantiere_ditte ORDER BY cantiere_ditte.nome";	
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
				echo "<th>Indirizzo</th>";
				echo "<th>Localita</th>";
				echo "<th>Provincia</th>";
				echo "<th>CAP</th>";
				echo "<th>Riferimento</th>";
				echo "<th>Telefono</th>";
				echo "<th>Cellulare</th>";
				echo "<th></th>";
				echo "<th></th>";
			echo "</tr>";
		while($row2=sqlsrv_fetch_array($result2))
		{
			echo "<tr id='rigaAnagrafica".$row2['id_ditta']."'>";
				echo '<td id="nomeAnagrafica'.$row2["id_ditta"].'" onkeyup="process(event, this)" contenteditable>'.$row2["nome"].'</td>';
				echo '<td id="indirizzoAnagrafica'.$row2["id_ditta"].'" onkeyup="process(event, this)" contenteditable>'.$row2["indirizzo"].'</td>';
				echo '<td id="localitaAnagrafica'.$row2["id_ditta"].'" onkeyup="process(event, this)" contenteditable>'.$row2["localita"].'</td>';
				echo '<td id="provinciaAnagrafica'.$row2["id_ditta"].'" onkeyup="process(event, this)" contenteditable>'.$row2["provincia"].'</td>';
				echo '<td id="capAnagrafica'.$row2["id_ditta"].'" onkeyup="process(event, this)" contenteditable>'.$row2["cap"].'</td>';
				echo '<td id="riferimentoAnagrafica'.$row2["id_ditta"].'" onkeyup="process(event, this)" contenteditable>'.$row2["riferimento"].'</td>';
				echo '<td id="telefonoAnagrafica'.$row2["id_ditta"].'" onkeyup="process(event, this)" contenteditable>'.$row2["telefono"].'</td>';
				echo '<td id="cellulareAnagrafica'.$row2["id_ditta"].'" onkeyup="process(event, this)" contenteditable>'.$row2["cellulare"].'</td>';
				echo '<td><i class="fas fa-save" title="Salva modifiche" onclick="salvaModificheDitta('.$row2["id_ditta"].')"></i></td>';
				echo '<td id="risultato'.$row2["id_ditta"].'" style="text-align:right;width:40px"></td>';
			echo "</tr>";
		}
			echo "<tr id='rigaNuovaAnagrafica'>";
				echo '<td id="nomeNuovaAnagrafica" onkeyup="process(event, this)" contenteditable></td>';
				echo '<td id="indirizzoNuovaAnagrafica" onkeyup="process(event, this)" contenteditable></td>';
				echo '<td id="localitaNuovaAnagrafica" onkeyup="process(event, this)" contenteditable></td>';
				echo '<td id="provinciaNuovaAnagrafica" onkeyup="process(event, this)" contenteditable></td>';
				echo '<td id="capNuovaAnagrafica" onkeyup="process(event, this)" contenteditable></td>';
				echo '<td id="riferimentoNuovaAnagrafica" onkeyup="process(event, this)" contenteditable></td>';
				echo '<td id="telefonoNuovaAnagrafica" onkeyup="process(event, this)" contenteditable></td>';
				echo '<td id="cellulareNuovaAnagrafica" onkeyup="process(event, this)" contenteditable></td>';
				echo '<td><i class="fas fa-user-plus"  title="Inserisci operatore" onclick="inserisciDitta()"></i></td>';
				echo '<td id="risultatoNuovaAnagrafica" style="text-align:right;width:40px"></td>';
			echo "</tr>";
		echo "</table>";
	}

	
?>