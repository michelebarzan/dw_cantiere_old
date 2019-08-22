<?php

	include "connessione.php";
	include "Session.php";

	$colonna=$_REQUEST['colonna'];
	$NCabina=$_REQUEST['NCabina'];
	
	$queryRighe="DELETE tblDettagliAttSvolte FROM tblDettagliAttSvolte WHERE IDDettagliAttSvolte=(SELECT IDDettagliAttSvolte FROM elencoRegistrazioni WHERE Descrizione = N'$colonna' AND [numero cabina] = N'$NCabina' AND commessa=".$_SESSION['id_commessa'].")";
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