<?php

	include "connessione.php";
	include "Session.php";
	
	$id_registrazione=$_REQUEST['id_registrazione'];
	$ditte=json_decode($_REQUEST['ditte']);

    foreach ($ditte as $id_ditta)
    {
        $id_ditta=intval($id_ditta);

        $query1="SELECT TOP(1) cantiere_ponti_ditte_registrazioni.*,cantiere_ditte.nome FROM cantiere_ponti_ditte_registrazioni,cantiere_ditte WHERE cantiere_ponti_ditte_registrazioni.ditta=cantiere_ditte.id_ditta AND registrazione=$id_registrazione AND ditta=$id_ditta";
        $result1=sqlsrv_query($conn,$query1);
        if($result1==FALSE)
            die("error");
        else
        {
            $rows = sqlsrv_has_rows( $result1 );  
            if ($rows !== true)
            {
                $query2="INSERT INTO cantiere_ponti_ditte_registrazioni (registrazione,ditta) VALUES ($id_registrazione,$id_ditta)";
                $result2=sqlsrv_query($conn,$query2);
                if($result2==FALSE)
                    die("error");
            }
        }
    }
	
?>
