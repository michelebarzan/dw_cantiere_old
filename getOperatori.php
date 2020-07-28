<?php

	include "connessione.php";
	include "Session.php";
    
    $operatori=[];

    $query="SELECT * FROM cantiere_operatori_ditte WHERE eliminato='false' AND ditta IS NULL";
    $result=sqlsrv_query($conn,$query);
    if($result==FALSE)
    {
        die("error");
    }
    else
    {
        while($row=sqlsrv_fetch_array($result))
        {
            $operatore["id_operatore"]=$row['id_operatore'];
            $operatore["nome"]=$row['nome'];
            $operatore["cognome"]=$row['cognome'];
            $operatore["orePred"]=$row['orePred'];

            array_push($operatori,$operatore);
        }
        echo json_encode($operatori);
    }

?>
