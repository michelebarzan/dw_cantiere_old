<?php

	include "connessione.php";
	include "Session.php";
	
	$data=$_REQUEST['data'];
	
	$q="SELECT * FROM cantiere_registrazioni WHERE data='$data' AND commessa=".$_SESSION['id_commessa'];
	$r=sqlsrv_query($conn,$q);
	if($r==FALSE)
	{
		echo "<br><br>Errore esecuzione query<br>Query: ".$q."<br>Errore: ";
		die(print_r(sqlsrv_errors(),TRUE));
	}
	else
	{
		$rows = sqlsrv_has_rows( $r );
		if ($rows === true)
		{
			echo "E' gia presente una registrazione in questa data";
		}
		else
		{
			$queryPonte="INSERT INTO cantiere_registrazioni(data,utente,commessa) VALUES ('$data',".getIdUtente($conn,$_SESSION['Username']).",".$_SESSION['id_commessa'].")";
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
		}
	}
	
	
	
	function getIdUtente($conn,$username)
	{
		$q="SELECT id_utente FROM utenti WHERE username='$username'";
		$r=sqlsrv_query($conn,$q);
		if($r==FALSE)
		{
			echo "<br><br>Errore esecuzione query<br>Query: ".$q."<br>Errore: ";
			die(print_r(sqlsrv_errors(),TRUE));
		}
		else
		{
			while($row=sqlsrv_fetch_array($r))
			{
				return $row['id_utente'];
			}
		}
	}
?>