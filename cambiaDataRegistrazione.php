<?php

	include "connessione.php";
	include "Session.php";
	
	$id_registrazione=$_REQUEST['id_registrazione'];
	$data=$_REQUEST['data'];

	$queryPonte="UPDATE cantiere_registrazioni SET data='$data' WHERE id_registrazione=$id_registrazione";
	$resultPonte=sqlsrv_query($conn,$queryPonte);
	if($resultPonte==FALSE)
	{
		echo "<br><br>Errore esecuzione query<br>Query: ".$queryPonte."<br>Errore: ";
		die(print_r(sqlsrv_errors(),TRUE));
	}
	else
	{
		echo "ok";
	}
	
?>