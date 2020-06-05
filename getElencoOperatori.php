<?php

	include "connessione.php";
	include "Session.php";
	
	$id_ditta=$_REQUEST['id_ditta'];
	$ponte=$_REQUEST['ponte'];
	$id_registrazione=$_REQUEST['id_registrazione'];
	
	echo "<table id='myTableElencoOperatori'>";
		echo "<tr>";
			echo "<th>Nome</th>";
			echo "<th>Cognome</th>";
			echo "<th>Ore</th>";
			echo "<th>Note</th>";
			echo "<th>Utente</th>";
			echo "<th></th>";
		echo "</tr>";
		$queryOperatore="SELECT * FROM cantiere_riepilogo_ore_operatori WHERE ditta =$id_ditta AND ponte='$ponte' AND registrazione=$id_registrazione";//echo $queryOperatore;
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
				echo "<tr id='rigaOperatore' class='rigaOperatore'>";
					echo "<td >".$rowOperatore['nome']."</td>";
					echo "<td >".$rowOperatore['cognome']."</td>";
					echo "<td onfocusout='modificaOre(".$rowOperatore['id_ponti_ditte_registrazioni'].",this.innerHTML)' contenteditable>".$rowOperatore['ore']."</td>";
					echo "<td onfocusout='modificaNote(".$rowOperatore['id_ponti_ditte_registrazioni'].",this.innerHTML)' contenteditable>".$rowOperatore['note']."</td>";
					echo "<td >".$rowOperatore['username']."</td>";
					echo '<td ><input type="button" class="btnEliminaRigaRegistrazione" value="" onclick="eliminaRigaRegistrazioneOperatore('.$id_registrazione.','.$id_ditta.','.htmlspecialchars(json_encode($ponte)).','.$rowOperatore["id_operatore"].')" /></td>';
				echo "</tr>";
			}
		}
	echo "</table>";
?>