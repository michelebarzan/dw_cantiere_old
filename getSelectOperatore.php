<?php

	include "connessione.php";

	$id_ditta=$_REQUEST['id_ditta'];
	
	$queryPonte="SELECT * FROM cantiere_operatori_ditte WHERE ditta=$id_ditta";
	$resultPonte=sqlsrv_query($conn,$queryPonte);
	if($resultPonte==FALSE)
	{
		echo "<br><br>Errore esecuzione query<br>Query: ".$queryPonte."<br>Errore: ";
		die(print_r(sqlsrv_errors(),TRUE));
	}
	else
	{
		echo "<select id='selectOperatore' class='inputTesto' >";
			echo "<option value='' disabled selected>Scegli operatore</option>";
			while($rowPonte=sqlsrv_fetch_array($resultPonte))
			{
				echo "<option value='".$rowPonte['id_operatore']."' >".$rowPonte['nome']." ".$rowPonte['cognome']."</option>";
			}
		echo "</select>";
	}
		
?>