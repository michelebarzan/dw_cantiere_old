<?php

	include "connessione.php";
	include "Session.php";
	
    $id_operatore=$_REQUEST["id_operatore"];

    $query2="UPDATE cantiere_operatori_ditte SET eliminato='true' WHERE id_operatore=$id_operatore";	
    $result2=sqlsrv_query($conn,$query2);
    if($result2==FALSE)
    {
        die("error");
    }
	
?>