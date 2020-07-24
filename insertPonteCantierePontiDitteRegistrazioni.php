<?php

	include "connessione.php";
	include "Session.php";
	
	$id_registrazione=$_REQUEST['id_registrazione'];
	$id_ditta=$_REQUEST['id_ditta'];
	$ponti=json_decode($_REQUEST['ponti']);

    foreach ($ponti as $ponte)
    {
        $query1="SELECT TOP(1) cantiere_ponti_ditte_registrazioni.*,cantiere_ditte.nome FROM cantiere_ponti_ditte_registrazioni,cantiere_ditte WHERE cantiere_ponti_ditte_registrazioni.ditta=cantiere_ditte.id_ditta AND registrazione=$id_registrazione AND ditta=$id_ditta AND ponte='$ponte'";
        $result1=sqlsrv_query($conn,$query1);
        if($result1==FALSE)
            die("error");
        else
        {
            $rows = sqlsrv_has_rows( $result1 );  
            if ($rows !== true)
            {
                $query2="INSERT INTO cantiere_ponti_ditte_registrazioni (registrazione,ditta,ponte) VALUES ($id_registrazione,$id_ditta,'$ponte')";
                $result2=sqlsrv_query($conn,$query2);
                if($result2==FALSE)
                    die("error");
            }
        }
    }
	
?>
