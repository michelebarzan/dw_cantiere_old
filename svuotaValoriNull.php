<?php

	include "connessione.php";
	include "Session.php";

	$queryRighe="DELETE cantiere_ponti_ditte_registrazioni FROM cantiere_ponti_ditte_registrazioni WHERE registrazione IS NULL OR ditta IS NULL OR ponte IS NULL OR operatore IS NULL";
	$resultRighe=sqlsrv_query($conn,$queryRighe);
	if($resultRighe==FALSE)
	{
		echo "<br><br>Errore esecuzione query<br>Query: ".$queryRighe."<br>Errore: ";
		die(print_r(sqlsrv_errors(),TRUE));
	}
	else
	{
		echo "ok";
	}
?>