<?php

	include "connessione.php";
	include "Session.php";
	
	$id_operatore=$_REQUEST['id_operatore'];
	$nome=$_REQUEST['nome'];
	$nome= str_replace("<div>","",$nome);
	$nome= str_replace("</div>","",$nome);
	$nome= str_replace("<br>","",$nome);
	$cognome=$_REQUEST['cognome'];
	$cognome= str_replace("<div>","",$cognome);
	$cognome= str_replace("</div>","",$cognome);
	$cognome= str_replace("<br>","",$cognome);
	$ditta=$_REQUEST['ditta'];
	$ore=$_REQUEST['ore'];
	$ore= str_replace("<div>","",$ore);
	$ore= str_replace("</div>","",$ore);
	$ore= str_replace("<br>","",$ore);
	$note=$_REQUEST['note'];
	$note= str_replace("<div>","",$note);
	$note= str_replace("</div>","",$note);
	$note= str_replace("<br>","",$note);
	
	$query2="UPDATE cantiere_operatori_ditte SET nome='$nome', cognome='$cognome', ditta='$ditta', orePred='$ore', note='$note' WHERE id_operatore=$id_operatore";	
	$result2=sqlsrv_query($conn,$query2);
	if($result2==FALSE)
	{
		echo "<br><br>Errore esecuzione query<br>Query: ".$query2."<br>Errore: ";
		die(print_r(sqlsrv_errors(),TRUE));
	}
	else
	{
		echo "ok";
	}
	
?>