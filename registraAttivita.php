<?php

	include "connessione.php";
	include "Session.php";

	$attivitaS=$_REQUEST['attivitaS'];
	$cabineS=$_REQUEST['cabineS'];
	$cellS=$_REQUEST['cellS'];
	
	$attivitaArray=explode(",",$attivitaS);
	$cabineArray=explode(",",$cabineS);
	$attivitaCabineArray=explode(",",$cellS);
	$attivitaIDAttSvolteArray=array();
	
	//$dataOra = date('Y-m-d h:i:s', time());
	$IDAttSvolte=getIDATTSvolte($conn);
	
	$queryInsertAttivitaSvolte="INSERT INTO attivitasvolteV ([IDAttSvolte],[codiceattivita],[datasvolgimento],[Memorizzato],[commessa]) ";
	$i=0;
	while($i<sizeof($attivitaArray))
	{		
		$IDAttSvolte++;
		array_push($attivitaIDAttSvolteArray,$attivitaArray[$i]."|".$IDAttSvolte);
		if($i==sizeof($attivitaArray)-1)
			$queryInsertAttivitaSvolte=$queryInsertAttivitaSvolte."SELECT $IDAttSvolte, ".getCodiceAttivita($conn,$attivitaArray[$i]).", getDate(),1,".$_SESSION['id_commessa']." ";
		else
			$queryInsertAttivitaSvolte=$queryInsertAttivitaSvolte."SELECT $IDAttSvolte, ".getCodiceAttivita($conn,$attivitaArray[$i]).", getDate(),1,".$_SESSION['id_commessa']." UNION ALL ";
		$i++;
	}
	
	$resultInsertAttivitaSvolte=sqlsrv_query($conn,$queryInsertAttivitaSvolte);
	if($resultInsertAttivitaSvolte==FALSE)
	{
		echo "<br><br>Errore esecuzione query<br>Query: ".$queryInsertAttivitaSvolte."<br>Errore: ";
		die(print_r(sqlsrv_errors(),TRUE));
	}
	else
	{
		$IDDettagliAttSvolte=getIDDettagliAttSvolte($conn);
		$queryInsertDettagliAttivitaSvolte="INSERT INTO tblDettagliAttSvolte ([IDDettagliAttSvolte],[IDAttSvolteDettagli],[numero cabina],[Ponte],[FireZone]) ";
		$j=0;
		while($j<sizeof($attivitaCabineArray))
		{
			$res=explode("|",$attivitaCabineArray[$j]);
			$IDAttSvolteDettagli=getIDAttSvolteDettagli($conn,$res[1],$attivitaIDAttSvolteArray);
			$IDDettagliAttSvolte++;
			$NCabina=$res[0];
			$Deck=getDeck($conn,$NCabina);
			$FZ=getFZ($conn,$NCabina);
			
			
			if($j==sizeof($attivitaCabineArray)-1)
				$queryInsertDettagliAttivitaSvolte=$queryInsertDettagliAttivitaSvolte."SELECT $IDDettagliAttSvolte, $IDAttSvolteDettagli, '$NCabina', '$Deck', '$FZ' ";
			else
				$queryInsertDettagliAttivitaSvolte=$queryInsertDettagliAttivitaSvolte."SELECT $IDDettagliAttSvolte, $IDAttSvolteDettagli, '$NCabina', '$Deck', '$FZ' UNION ALL ";
			$j++;
		}
		
		//echo $queryInsertDettagliAttivitaSvolte;
		
		$resultInsertDettagliAttivitaSvolte=sqlsrv_query($conn,$queryInsertDettagliAttivitaSvolte);
		if($resultInsertDettagliAttivitaSvolte==FALSE)
		{
			echo "<br><br>Errore esecuzione query<br>Query: ".$queryInsertDettagliAttivitaSvolte."<br>Errore: ";
			die(print_r(sqlsrv_errors(),TRUE));
		}
		else
		{
			echo "ok";
		}
	}
	
	
	
	
	
	
	function getIDAttSvolteDettagli($conn,$attivita,$attivitaIDAttSvolteArray)
	{
		$j=0;
		while($j<sizeof($attivitaIDAttSvolteArray))
		{
			$att=explode("|",$attivitaIDAttSvolteArray[$j]);
			if($att[0]==$attivita)
				return $att[1];
			$j++;
		}
	}
	function getDeck($conn,$NCabina)
	{
		$queryRighe="SELECT Deck FROM [grigliaWeb_1] WHERE [NCabina]='$NCabina'";
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
				return $rowRighe['Deck'];
			}
		}
	}
	function getFZ($conn,$NCabina)
	{
		$queryRighe="SELECT FZ FROM [grigliaWeb_1] WHERE [NCabina]='$NCabina'";
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
				return $rowRighe['FZ'];
			}
		}
	}
	
	function getIDATTSvolte($conn)
	{
		$queryRighe="SELECT MAX(IDAttSvolte) AS id FROM attivitasvolte ";
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
				return $rowRighe['id'];
			}
		}
	}
	function getCodiceAttivita($conn,$Descrizione)
	{
		$queryRighe="SELECT CodiceAttivita FROM Attivita WHERE Descrizione='$Descrizione'";
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
				return $rowRighe['CodiceAttivita'];
			}
		}
	}
	function getIDDettagliAttSvolte($conn)
	{
		$queryRighe="SELECT MAX(IDDettagliAttSvolte) AS id FROM tblDettagliAttSvolte ";
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
				return $rowRighe['id'];
			}
		}
	}
	
?>