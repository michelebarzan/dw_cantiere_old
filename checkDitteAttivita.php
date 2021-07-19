    <?php

	include "connessione.php";
	include "Session.php";
	
	$attivita=json_decode($_REQUEST['JSONattivita']);
    $attivita_in="'".implode("','",$attivita)."'";

    $ditte_attivita=[];
    $anagrafica_ditte=[];

	$query="SELECT DISTINCT TOP (100) PERCENT dbo.cantiere_ditte.id_ditta, dbo.cantiere_ditte.nome
            FROM dbo.programmazione_attivita_commessa INNER JOIN dbo.Attivita ON dbo.programmazione_attivita_commessa.codice_attivita = dbo.Attivita.CodiceAttivita INNER JOIN dbo.programmazione_ditte_attivita ON dbo.programmazione_attivita_commessa.codice_attivita = dbo.programmazione_ditte_attivita.codice_attivita INNER JOIN dbo.cantiere_ditte ON dbo.programmazione_ditte_attivita.ditta = dbo.cantiere_ditte.id_ditta
            WHERE (dbo.Attivita.Descrizione IN ($attivita_in)) AND (dbo.programmazione_attivita_commessa.commessa = ".$_SESSION['id_commessa'].") AND (dbo.programmazione_ditte_attivita.commessa = ".$_SESSION['id_commessa'].")
            ORDER BY dbo.cantiere_ditte.nome";
	$result=sqlsrv_query($conn,$query);
	if($result==FALSE)
		die("error".$query);
	else
	{
		while($row=sqlsrv_fetch_array($result))
        {
            $ditta["id_ditta"]=$row["id_ditta"];
            $ditta["nome"]=$row["nome"];

            array_push($ditte_attivita,$ditta);
        }
    }

    $query2="SELECT * FROM cantiere_ditte";
	$result2=sqlsrv_query($conn,$query2);
	if($result2==FALSE)
		die("error".$query);
	else
	{
		while($row2=sqlsrv_fetch_array($result2))
        {
            $ditta["id_ditta"]=$row2["id_ditta"];
            $ditta["nome"]=$row2["nome"];

            array_push($anagrafica_ditte,$ditta);
        }
    }

    $arrayResponse["ditte_attivita"]=$ditte_attivita;
    $arrayResponse["anagrafica_ditte"]=$anagrafica_ditte;

    echo json_encode($arrayResponse);
?>