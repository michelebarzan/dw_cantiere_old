<?php

	include "connessione.php";
	include "Session.php";
	
	
	echo "<span id='intestazioneDatiRegistrazione'>Dati nuova registrazione:</span>";
	
	$queryRighe="SELECT * FROM tblAnagrafica ORDER BY Ditta_nome";
	$resultRighe=sqlsrv_query($conn,$queryRighe);
	if($resultRighe==FALSE)
	{
		echo "<br><br>Errore esecuzione query<br>Query: ".$queryRighe."<br>Errore: ";
		die(print_r(sqlsrv_errors(),TRUE));
	}
	else
	{
		echo "<select id='selectDitte' class='inputTesto' onchange='aggiungiDitta(this.value)' >";
			echo "<option value='' disabled selected>Ditta</option>";
			while($rowRighe=sqlsrv_fetch_array($resultRighe))
			{
				echo "<option value='".$rowRighe['ID']." | ".$rowRighe['Ditta_nome']."'>".$rowRighe['Ditta_nome']."</option>";
			}
		echo "</select>";
	}
	echo "<input type='date' id='dataRegistrazione' class='inputTesto' value='".date('Y-m-d', time())."' />";

	echo "<ul id='listaDitte'>";
		//echo "<li id='liListaDitte14' class='liListaDitte' onclick='selezionaDitta(14)'>14 | Nome ditta</li>";
	echo "</ul>";
	
	echo "<div id='divInputUomini'>";
		echo "<div class='divInputUomini'>";
			echo "Ufficio";
			echo "<input type='number' id='uominiUfficio' min='0' value='0' />";
		echo "</div>";
		echo "<div class='divInputUomini'>";
			echo "Magazzino";
			echo "<input type='number' id='uominiMagazzino' min='0' value='0' />";
		echo "</div>";
		echo "<div class='divInputUomini'>";
			echo "Imbarchi";
			echo "<input type='number' id='uominiImbarchi' min='0' value='0' />";
		echo "</div>";
	echo "</div>";
	
?>