<?php

	include "connessione.php";
	include "Session.php";
	
	$id_registrazione=$_REQUEST['id_registrazione'];
	$id_ditta=$_REQUEST['id_ditta'];
	$ponte=$_REQUEST['ponte'];
	$id_operatore=$_REQUEST['id_operatore'];

	$queryOperatore="DELETE cantiere_ponti_ditte_registrazioni FROM cantiere_ponti_ditte_registrazioni WHERE registrazione = '$id_registrazione' AND ditta = '$id_ditta' AND ponte = '$ponte' AND operatore = '$id_operatore'";
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
?>
