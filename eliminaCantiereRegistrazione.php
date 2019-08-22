<?php

	include "connessione.php";
	include "Session.php";

	$id_registrazione=$_REQUEST['id_registrazione'];
	
	if($_SESSION['Username']=="adriano.testino" || $_SESSION['Username']=="admin")
	{
		$queryRighe="DELETE cantiere_ponti_ditte_registrazioni FROM cantiere_ponti_ditte_registrazioni WHERE registrazione=$id_registrazione";
		$resultRighe=sqlsrv_query($conn,$queryRighe);
		if($resultRighe==FALSE)
		{
			echo "<br><br>Errore esecuzione query<br>Query: ".$queryRighe."<br>Errore: ";
			die(print_r(sqlsrv_errors(),TRUE));
		}
		else
		{
			$queryRighe2="DELETE cantiere_registrazioni FROM cantiere_registrazioni WHERE id_registrazione=$id_registrazione";
			$resultRighe2=sqlsrv_query($conn,$queryRighe2);
			if($resultRighe2==FALSE)
			{
				echo "<br><br>Errore esecuzione query<br>Query: ".$queryRighe2."<br>Errore: ";
				die(print_r(sqlsrv_errors(),TRUE));
			}
			else
			{
				echo "ok";
			}
		}
	}
	else
		echo "Funzione disabilitata";
	
?>