<?php

	include "connessione.php";
	include "Session.php";
	
	$NCabina=$_REQUEST['NCabina'];
	$colonna=$_REQUEST['colonna'];

	$queryPonte="SELECT id_nota,nota FROM cantiere_note WHERE numero_cabina='$NCabina' AND descrizione='$colonna' AND utente=".getIdUtente($conn)." AND commessa=".$_SESSION['id_commessa'];
	$resultPonte=sqlsrv_query($conn,$queryPonte);
	if($resultPonte==FALSE)
	{
		echo "<br><br>Errore esecuzione query<br>Query: ".$queryPonte."<br>Errore: ";
		die(print_r(sqlsrv_errors(),TRUE));
	}
	else
	{
		while($rowRighe=sqlsrv_fetch_array($resultPonte))
		{
			echo $rowRighe['id_nota']."|".$rowRighe['nota'];
		}
	}
	
	function getIdUtente($conn)
	{
		$queryPonte="SELECT id_utente FROM utenti WHERE username='".$_SESSION['Username']."'";
		$resultPonte=sqlsrv_query($conn,$queryPonte);
		if($resultPonte==FALSE)
		{
			echo "<br><br>Errore esecuzione query<br>Query: ".$queryPonte."<br>Errore: ";
			die(print_r(sqlsrv_errors(),TRUE));
		}
		else
		{
			while($rowRighe=sqlsrv_fetch_array($resultPonte))
			{
				return $rowRighe['id_utente'];
			}
		}
	}
	
?>
