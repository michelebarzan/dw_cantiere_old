<?php

	include "connessione.php";
	include "Session.php";

	$idTblGiorniDitte=$_REQUEST['idTblGiorniDitte'];
	$idDitta=$_REQUEST['idDitta'];
	$ID=getID($conn);
	
	$queryColonne="INSERT INTO ditte ([ID],[IDDittaGiorni],[IDAnagDitte]) VALUES (".$ID.",$idTblGiorniDitte,$idDitta)";
	$resultColonne=sqlsrv_query($conn,$queryColonne);
	if($resultColonne==FALSE)
	{
		echo "<br><br>Errore esecuzione query<br>Query: ".$queryColonne."<br>Errore: ";
		die(print_r(sqlsrv_errors(),TRUE));
	}
	else
	{
		echo $ID;
	}

	
	
	
	function getID($conn)
	{
		$queryColonne="SELECT MAX(ID)AS ID FROM ditte";
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
				return $rowColonne['ID']+1;
			}
		}
	}
?>