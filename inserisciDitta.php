<?php

	include "connessione.php";
	include "Session.php";
	
	$nome=$_REQUEST['nome'];
	$nome= str_replace("<div>","",$nome);
	$nome= str_replace("</div>","",$nome);
	$nome= str_replace("<br>","",$nome);
	$indirizzo=$_REQUEST['indirizzo'];
	$indirizzo= str_replace("<div>","",$indirizzo);
	$indirizzo= str_replace("</div>","",$indirizzo);
	$indirizzo= str_replace("<br>","",$indirizzo);
	$localita=$_REQUEST['localita'];
	$localita= str_replace("<div>","",$localita);
	$localita= str_replace("</div>","",$localita);
	$localita= str_replace("<br>","",$localita);
	$provincia=$_REQUEST['provincia'];
	$provincia= str_replace("<div>","",$provincia);
	$provincia= str_replace("</div>","",$provincia);
	$provincia= str_replace("<br>","",$provincia);
	$cap=$_REQUEST['cap'];
	$cap= str_replace("<div>","",$cap);
	$cap= str_replace("</div>","",$cap);
	$cap= str_replace("<br>","",$cap);
	$riferimento=$_REQUEST['riferimento'];
	$riferimento= str_replace("<div>","",$riferimento);
	$riferimento= str_replace("</div>","",$riferimento);
	$riferimento= str_replace("<br>","",$riferimento);
	$telefono=$_REQUEST['telefono'];
	$telefono= str_replace("<div>","",$telefono);
	$telefono= str_replace("</div>","",$telefono);
	$telefono= str_replace("<br>","",$telefono);
	$cellulare=$_REQUEST['cellulare'];
	$cellulare= str_replace("<div>","",$cellulare);
	$cellulare= str_replace("</div>","",$cellulare);
	$cellulare= str_replace("<br>","",$cellulare);
	
	$query2="INSERT INTO [dbo].[cantiere_ditte] ([nome],[indirizzo],[localita],[provincia],[cap],[riferimento],[telefono],[cellulare]) VALUES ('$nome','$indirizzo','$localita','$provincia','$cap','$riferimento','$telefono','$cellulare')";	
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