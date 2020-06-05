<?php

	include "connessione.php";
	include "Session.php";
	
	$id_registrazione=$_REQUEST['id_registrazione'];
	$data=$_REQUEST['data'];
	
	$q="SELECT * FROM cantiere_registrazioni WHERE data='$data' AND commessa=".$_SESSION['id_commessa'];
	$r=sqlsrv_query($conn,$q);
	if($r==FALSE)
	{
		echo "<br><br>Errore esecuzione query<br>Query: ".$q."<br>Errore: ";
		die(print_r(sqlsrv_errors(),TRUE));
	}
	else
	{
		$rows = sqlsrv_has_rows( $r );
		if ($rows === true)
		{
			echo "E' gia presente una registrazione in questa data";
		}
		else
		{
			$queryPonte="INSERT INTO cantiere_registrazioni(data,utente,note,commessa) SELECT '$data',".getIdUtente($conn,$_SESSION['Username']).",note,".$_SESSION['id_commessa']." FROM cantiere_registrazioni WHERE id_registrazione=$id_registrazione";
			$resultPonte=sqlsrv_query($conn,$queryPonte);
			if($resultPonte==FALSE)
			{
				echo "<br><br>Errore esecuzione query<br>Query: ".$queryPonte."<br>Errore: ";
				die(print_r(sqlsrv_errors(),TRUE));
			}
			else
			{
				$q="SELECT MAX(id_registrazione) AS id_registrazione FROM cantiere_registrazioni WHERE data='$data' AND utente=".getIdUtente($conn,$_SESSION['Username'])." AND commessa=".$_SESSION['id_commessa'];
				$r=sqlsrv_query($conn,$q);
				if($r==FALSE)
				{
					echo "<br><br>Errore esecuzione query<br>Query: ".$q."<br>Errore: ";
					die(print_r(sqlsrv_errors(),TRUE));
				}
				else
				{
					while($row=sqlsrv_fetch_array($r))
					{
						$new_id_registrazione=$row['id_registrazione'];
					}
					$q2="INSERT INTO [dbo].[cantiere_ponti_ditte_registrazioni]([ditta],[ponte],[registrazione],[operatore],[ore],[utente]) SELECT [ditta],[ponte],'$new_id_registrazione',[operatore],[ore],".getIdUtente($conn,$_SESSION['Username'])." FROM [dbo].[cantiere_ponti_ditte_registrazioni] WHERE registrazione=$id_registrazione";
					$r2=sqlsrv_query($conn,$q2);
					if($r2==FALSE)
					{
						echo "<br><br>Errore esecuzione query<br>Query: ".$q2."<br>Errore: ";
						die(print_r(sqlsrv_errors(),TRUE));
					}
					else
					{
						echo $new_id_registrazione;
					}
				}
			}
		}
	}

	
	
	function getIdUtente($conn,$username)
	{
		$q="SELECT id_utente FROM utenti WHERE username='$username'";
		$r=sqlsrv_query($conn,$q);
		if($r==FALSE)
		{
			echo "<br><br>Errore esecuzione query<br>Query: ".$q."<br>Errore: ";
			die(print_r(sqlsrv_errors(),TRUE));
		}
		else
		{
			while($row=sqlsrv_fetch_array($r))
			{
				return $row['id_utente'];
			}
		}
	}
?>