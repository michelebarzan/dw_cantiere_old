<?php

	include "connessione.php";
	include "Session.php";

	$Deck=$_REQUEST['Deck'];
	$FZ=$_REQUEST['FZ'];
	$gruppo=$_REQUEST['gruppo'];
	
	$nColonne=3;
	$colonne=array();
	
	$queryColonne="SELECT Descrizione FROM gruppi_colonne WHERE gruppo=$gruppo AND commessa=".$_SESSION['id_commessa'];
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
			$nColonne++;
			array_push($colonne,$rowColonne['Descrizione']);
		}
	}
	
	$nCelle=$nColonne;
	$time=$nColonne;
	
	$queryRighe="SELECT grigliaWeb_1.* FROM [grigliaWeb_1] WHERE [grigliaWeb_1].Deck LIKE '$Deck' AND [grigliaWeb_1].FZ LIKE '$FZ' AND commessa=".$_SESSION['id_commessa'];//echo $queryRighe;
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
			$i=0;
			while($i<sizeof($colonne))
			{
				$nCelle++;
				if($rowRighe[$colonne[$i]]==0)
				{
					$time=$time+1;
				}
				if($rowRighe[$colonne[$i]]==1)
				{
					$time=$time+4;
				}
				$i++;
			}
			$time=$time+3;
		}
	}
	
	if($time>=0 && $time<500)
	{
		$time2=10;
	}
	if($time>=500 && $time<1000)
	{
		$time2=intval($time/7);
	}
	if($time>=1000 && $time<2000)
	{
		$time2=intval($time/6);
	}
	if($time>=2000 && $time<3000)
	{
		$time2=intval($time/5);
	}
	if($time>=3000 && $time<4000)
	{
		$time2=intval($time/4);
	}
	if($time>=4000)
	{
		$time2=intval($time/3);
	}
	
	//$time=$time2;
	
	echo $time2."|".$time."|".$nCelle;
	
?>