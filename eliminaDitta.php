<?php

	include "connessione.php";
	include "Session.php";
	
    $id_ditta=$_REQUEST["id_ditta"];

    $query2="UPDATE cantiere_ditte SET eliminata='true' WHERE id_ditta=$id_ditta";	
    $result2=sqlsrv_query($conn,$query2);
    if($result2==FALSE)
    {
        die("error");
    }
	
?>