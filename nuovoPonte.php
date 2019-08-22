<?php

	include "connessione.php";
	include "Session.php";
	
	$idDitte=$_REQUEST['idDitte'];
	$ponte=$_REQUEST['ponte'];
	$operatori=$_REQUEST['operatori'];
	$ore=$_REQUEST['ore'];
	
	$IDUomini=getIDUomini($conn);
	$IDUominiDitta=getIDUominiDitta($conn,$idDitte);
	
	$queryRighe="INSERT INTO [dbo].[tblUominiDitta] ([IDUomini],[IDUominiDitta],[Ponte],[NUomini],[NOre]) VALUES ($IDUomini,$IDUominiDitta,'$ponte',$operatori,$ore)";
	$resultRighe=sqlsrv_query($conn,$queryRighe);
	if($resultRighe==FALSE)
	{
		echo "<br><br>Errore esecuzione query<br>Query: ".$queryRighe."<br>Errore: ";
		die(print_r(sqlsrv_errors(),TRUE));
	}
	else
	{
		echo $IDUomini;
	}

	
	
	
	function getIDUomini($conn)
	{
		$queryRighe="SELECT MAX(IDUomini) AS IDUomini FROM tblUominiDitta";
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
				return $rowRighe['IDUomini']+1;
			}
		}
	}
	
	function getIDUominiDitta($conn,$idDitte)
	{
		$queryRighe="SELECT ID FROM ditte WHERE IDDittaGiorni=$idDitte";
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
				return $rowRighe['ID'];
			}
		}
	}
	
?>