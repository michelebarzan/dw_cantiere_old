<?php

	include "connessione.php";
	include "Session.php";
	
	$id_registrazione=$_REQUEST['id_registrazione'];
	$id_ditta=$_REQUEST['id_ditta'];
	$ponte=$_REQUEST['ponte'];
    $operatori=json_decode($_REQUEST['operatori']);

    $id_utente=getIdUtente($conn,$_SESSION['Username']);
    
    foreach ($operatori as $id_operatore)
    {
        $query1="SELECT ponte, nome, cognome, ore, ditta, registrazione, id_ponti_ditte_registrazioni, id_operatore, note, username
                FROM dbo.cantiere_riepilogo_ore_operatori
                WHERE (ponte = '$ponte') AND (registrazione = $id_registrazione) AND (id_operatore = $id_operatore)";
        $result1=sqlsrv_query($conn,$query1);
        if($result1==FALSE)
        {
            die("error1");
        }
        else
        {
            $rows = sqlsrv_has_rows( $result1 );  
            if ($rows !== true)
            {
                $query2="INSERT INTO cantiere_ponti_ditte_registrazioni (registrazione,ditta,ponte,operatore,ore,utente) VALUES ($id_registrazione,$id_ditta,'$ponte',$id_operatore,".getOrePred($conn,$id_operatore).",".$id_utente.")";
                $result2=sqlsrv_query($conn,$query2);
                if($result2==FALSE)
                    die("error2".$query2);
            }
        }
    }

	
	function getOrePred($conn,$id_operatore)
	{
		$query1="SELECT orePred FROM cantiere_operatori_ditte WHERE id_operatore=$id_operatore";
		$result1=sqlsrv_query($conn,$query1);
		if($result1==FALSE)
		{
			die("error3");
		}
		else
		{
			while($row1=sqlsrv_fetch_array($result1))
			{
				return $row1['orePred'];
            }
            return 0;
		}
	}
	function getIdUtente($conn,$username) 
	{
		$q="SELECT id_utente FROM utenti WHERE username='$username'";
		$r=sqlsrv_query($conn,$q);
		if($r==FALSE)
		{
			die("error4");
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
