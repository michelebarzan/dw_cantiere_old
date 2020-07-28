<?php

	include "connessione.php";
	include "Session.php";
    
    $ditte=[];

    $query="SELECT * FROM cantiere_ditte WHERE eliminata='false'";
    $result=sqlsrv_query($conn,$query);
    if($result==FALSE)
    {
        die("error");
    }
    else
    {
        while($row=sqlsrv_fetch_array($result))
        {
            $ditta["id_ditta"]=$row['id_ditta'];
            $ditta["nome"]=$row['nome'];

            array_push($ditte,$ditta);
        }
        echo json_encode($ditte);
    }

?>
