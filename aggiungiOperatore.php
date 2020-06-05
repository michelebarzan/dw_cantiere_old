<?php

	include "connessione.php";
	include "Session.php";
	
	$id_registrazione=$_REQUEST['id_registrazione'];
	$id_ditta=$_REQUEST['id_ditta'];
	$ponte=$_REQUEST['ponte'];
	$id_operatore=$_REQUEST['id_operatore'];

	/*$queryPonte="SELECT TOP(1) cantiere_ponti_ditte_registrazioni.*,cantiere_ditte.nome AS nomeDitta,cantiere_operatori_ditte.nome,cantiere_operatori_ditte.cognome 
	FROM cantiere_ponti_ditte_registrazioni,cantiere_ditte,cantiere_operatori_ditte 
	WHERE cantiere_ponti_ditte_registrazioni.ditta=cantiere_ditte.id_ditta AND cantiere_ponti_ditte_registrazioni.operatore=cantiere_operatori_ditte.id_operatore AND registrazione=$id_registrazione AND cantiere_ponti_ditte_registrazioni.ditta=$id_ditta AND ponte='$ponte' AND operatore=$id_operatore";*/
	$queryPonte="SELECT ponte, nome, cognome, ore, ditta, registrazione, id_ponti_ditte_registrazioni, id_operatore, note, username
				FROM dbo.cantiere_riepilogo_ore_operatori
				WHERE (ponte = '$ponte') AND (registrazione = $id_registrazione) AND (id_operatore = $id_operatore)";
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
				echo "Operatore ".$rowPonte['nome']." ".$rowPonte['cognome']." gia presente per il ponte ".$rowPonte['ponte']." per la ditta ".$rowPonte['nomeDitta']." per la registrazione $id_registrazione";//echo $queryPonte;
			}
		}
		else
		{
			$queryOperatore="INSERT INTO cantiere_ponti_ditte_registrazioni (registrazione,ditta,ponte,operatore,ore,utente) VALUES ($id_registrazione,$id_ditta,'$ponte',$id_operatore,".getOrePred($conn,$id_operatore).",".getIdUtente($conn,$_SESSION['Username']).")";
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
	function getOrePred($conn,$id_operatore)
	{
		$queryPonte="SELECT orePred FROM cantiere_operatori_ditte WHERE id_operatore=$id_operatore";
		$resultPonte=sqlsrv_query($conn,$queryPonte);
		if($resultPonte==FALSE)
		{
			echo "<br><br>Errore esecuzione query<br>Query: ".$queryPonte."<br>Errore: ";
			die(print_r(sqlsrv_errors(),TRUE));
		}
		else
		{
			while($rowPonte=sqlsrv_fetch_array($resultPonte))
			{
				return $rowPonte['orePred'];
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
