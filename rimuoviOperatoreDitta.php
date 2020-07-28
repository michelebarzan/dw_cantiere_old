<?php

	include "connessione.php";
	include "Session.php";
    
    $id_operatore=$_REQUEST["id_operatore"];

    $query="UPDATE cantiere_operatori_ditte SET ditta=NULL WHERE id_operatore=$id_operatore";
    $result=sqlsrv_query($conn,$query);
    if($result==FALSE)
    {
        die("error".$query);
    }

?>
