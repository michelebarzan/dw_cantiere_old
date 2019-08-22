<?php

	include "connessione.php";
	include "Session.php";
	
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
	
	$query2="INSERT INTO [dbo].[cantiere_operatori_ditte] ([nome],[cognome],[orePred],[ditta],[note]) VALUES ('$nome','$cognome','$ore','$ditta','$note') ";	
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