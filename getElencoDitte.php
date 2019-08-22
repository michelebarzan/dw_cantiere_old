<?php

	include "connessione.php";
	include "Session.php";
	
	$id_registrazione=$_REQUEST['id_registrazione'];

	echo "<table id='myTableElencoDitte'>";
		echo "<tr>";
			echo "<th>Nome ditta</th>";
			echo "<th></th>";
		echo "</tr>";
		$queryOperatore="SELECT DISTINCT cantiere_ditte.nome,cantiere_ditte.id_ditta FROM cantiere_ditte,cantiere_ponti_ditte_registrazioni WHERE cantiere_ponti_ditte_registrazioni.ditta=cantiere_ditte.id_ditta AND cantiere_ponti_ditte_registrazioni.registrazione=$id_registrazione";
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
				echo "<tr class='righeDitte' id='rigaDitta".$rowOperatore['id_ditta']."' onclick='selezionaDitta(".$rowOperatore['id_ditta'].",$id_registrazione)'>";
					echo "<td >".$rowOperatore['nome']."</td>";
					echo '<td ><input type="button" class="btnEliminaRigaRegistrazione" value="" onclick="eliminaRigaRegistrazioneDitta('.$id_registrazione.','.$rowOperatore["id_ditta"].')" /></td>';
				echo "</tr>";
			}
		}
	echo "</table>";
?>
