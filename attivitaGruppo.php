<?php

	include "connessione.php";
	include "Session.php";

	$gruppo=$_REQUEST['gruppo'];
	
	$queryRighe="SELECT * FROM gruppi_colonne WHERE gruppo=$gruppo AND commessa=".$_SESSION['id_commessa'];
	$resultRighe=sqlsrv_query($conn,$queryRighe);
	if($resultRighe==FALSE)
	{
		echo "<br><br>Errore esecuzione query<br>Query: ".$queryRighe."<br>Errore: ";
		die(print_r(sqlsrv_errors(),TRUE));
	}
	else
	{
		while($rowRighe=sqlsrv_fetch_array($resultRighe))
		{
			echo $rowRighe['Descrizione']."<br>";
		}
	}
	
	
	
?>