<?php

	include "connessione.php";
	include "Session.php";
	
	$id_ponti_ditte_registrazioni=$_REQUEST['id_ponti_ditte_registrazioni'];
	$note=$_REQUEST['note'];
	
	$queryOperatore="UPDATE cantiere_ponti_ditte_registrazioni SET note='$note' WHERE id_ponti_ditte_registrazioni=$id_ponti_ditte_registrazioni";
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