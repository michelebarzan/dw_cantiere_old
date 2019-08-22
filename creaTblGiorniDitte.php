<?php

	include "connessione.php";
	include "Session.php";

	$data=$_REQUEST['data'];
	
	$IdGiorni=getIdTblGiorniDitte($conn);
	
	$queryColonne="INSERT INTO tblGiorniDitte([Giornata],[UominiUfficio],[UominiMagazzino],[UominiImbarchi],[utente]) VALUES ('$data',0,0,0,'".$_SESSION['Username']."')";
	$resultColonne=sqlsrv_query($conn,$queryColonne);
	if($resultColonne==FALSE)
	{
		echo "<br><br>Errore esecuzione query<br>Query: ".$queryColonne."<br>Errore: ";
		die(print_r(sqlsrv_errors(),TRUE));
	}
	else
	{
		echo $IdGiorni;
	}

	
	
	
	function getIdTblGiorniDitte($conn)
	{
		$queryColonne="SELECT MAX(IdGiorni)AS IdGiorni FROM tblGiorniDitte";
		$resultColonne=sqlsrv_query($conn,$queryColonne);
		if($resultColonne==FALSE)
		{
			echo "<br><br>Errore esecuzione query<br>Query: ".$queryColonne."<br>Errore: ";
			die(print_r(sqlsrv_errors(),TRUE));
		}
		else
		{
			while($rowColonne=sqlsrv_fetch_array($resultColonne))
			{
				return $rowColonne['IdGiorni']+1;
			}
		}
	}
?>