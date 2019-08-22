<?php

	include "connessione.php";
	include "Session.php";
	
	$id_registrazione=$_REQUEST['id_registrazione'];
	$id_ditta=$_REQUEST['id_ditta'];

	$queryPonte="SELECT TOP(1) cantiere_ponti_ditte_registrazioni.*,cantiere_ditte.nome FROM cantiere_ponti_ditte_registrazioni,cantiere_ditte WHERE cantiere_ponti_ditte_registrazioni.ditta=cantiere_ditte.id_ditta AND registrazione=$id_registrazione AND ditta=$id_ditta";
	$resultPonte=sqlsrv_query($conn,$queryPonte);
	if($resultPonte==FALSE)
	{
		echo "<br><br>Errore esecuzione query<br>Query: ".$queryPonte."<br>Errore: ";
		die(print_r(sqlsrv_errors(),TRUE));
	}
	else
	{
		$rows = sqlsrv_has_rows( $resultPonte );  
		if ($rows === true)
		{
			while($rowPonte=sqlsrv_fetch_array($resultPonte))
			{
				echo "Ditta ".$rowPonte['nome']." gia presente per la registrazione $id_registrazione";
			}
		}
		else
		{
			$queryOperatore="INSERT INTO cantiere_ponti_ditte_registrazioni (registrazione,ditta) VALUES ($id_registrazione,$id_ditta)";
			$resultOperatore=sqlsrv_query($conn,$queryOperatore);
			if($resultOperatore==FALSE)
			{
				echo "<br><br>Errore esecuzione query<br>Query: ".$queryOperatore."<br>Errore: ";
				die(print_r(sqlsrv_errors(),TRUE));
			}
			else
			{
				echo "ok";
			}
		}
	}
	
?>
