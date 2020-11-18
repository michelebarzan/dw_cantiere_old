<?php

	include "connessione.php";
	include "Session.php";
    
    $data_source=$_REQUEST['data_source'];
    
    $customSelectItems=[];
    
    if($data_source=="ditte")
        $query="SELECT cantiere_ditte.nome AS label,cantiere_ditte.id_ditta AS [value] FROM cantiere_ditte WHERE eliminata='false' ORDER BY nome";
    if($data_source=="ponti")
        $query="SELECT ponte as label, ponte as [value] FROM (SELECT 'gen' AS ponte UNION ALL SELECT 'pref' AS ponte UNION ALL SELECT 'mag' AS ponte UNION ALL SELECT 'bag' AS ponte UNION ALL SELECT ponte FROM cantiere_ponti WHERE commessa=".$_SESSION['id_commessa'].") AS t ORDER BY ponte";
    if($data_source=="operatori")
        $query="SELECT id_operatore AS [value], CONCAT(cognome,CONCAT(' ',nome)) AS label FROM cantiere_operatori_ditte WHERE ditta=".$_REQUEST['ditta']." AND eliminato='false' ORDER BY cognome";
    

    $result=sqlsrv_query($conn,$query);
    if($result==FALSE)
    {
        die("error");
    }
    else
    {
        while($row=sqlsrv_fetch_array($result))
        {
            $customSelectItem["value"]=$row["value"];
            $customSelectItem["label"]=$row["label"];

            array_push($customSelectItems,$customSelectItem);
        }
        echo json_encode($customSelectItems);
    }
?>
