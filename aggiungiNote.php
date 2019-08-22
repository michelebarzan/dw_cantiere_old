<?php

	include "connessione.php";
	include "Session.php";
	
	$NCabina=$_REQUEST['NCabina'];
	$colonna=$_REQUEST['colonna'];
	$note=$_REQUEST['note'];
	$idNotaEsistente=$_REQUEST['idNotaEsistente'];

	if($idNotaEsistente=="")
	{
		$queryPonte="INSERT INTO [dbo].[cantiere_note]
           ([numero_cabina]
           ,[descrizione]
           ,[commessa]
           ,[data_ultima_modifica]
           ,[nota]
           ,[utente])
     VALUES
           ('$NCabina','$colonna',".$_SESSION['id_commessa'].",getDate(),'$note',".getIdUtente($conn).")";
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
	else
	{
		$queryPonte="UPDATE cantiere_note SET nota='$note', data_ultima_modifica=getDate() WHERE id_nota=$idNotaEsistente";
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
