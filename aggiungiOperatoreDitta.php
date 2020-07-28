<?php

	include "connessione.php";
	include "Session.php";
    
    $id_ditta=$_REQUEST["id_ditta"];
    $id_operatore=$_REQUEST["id_operatore"];

    $query="UPDATE cantiere_operatori_ditte SET ditta=$id_ditta WHERE id_operatore=$id_operatore";
    $result=sqlsrv_query($conn,$query);
    if($result==FALSE)
    {
        die("error".$query);
    }

?>
