<?php

	include "connessione.php";
	include "Session.php";
	
	$id_ditta=$_REQUEST['id_ditta'];
	$id_registrazione=$_REQUEST['id_registrazione'];
	
	echo "<table id='myTableElencoPonti'>";
		echo "<tr>";
			echo "<th>Ditta</th>";
			echo "<th>Ponte</th>";
			echo "<th>Operatori</th>";
			echo "<th>Ore</th>";
			echo "<th></th>";
		echo "</tr>";
		
		$queryPonte="SELECT cantiere_riepilogo_totali_ditte.* FROM cantiere_riepilogo_totali_ditte WHERE id_ditta=$id_ditta AND registrazione=$id_registrazione";
		$resultPonte=sqlsrv_query($conn,$queryPonte);
		if($resultPonte==FALSE)
		{
			echo "<br><br>Errore esecuzione query<br>Query: ".$queryPonte."<br>Errore: ";
			die(print_r(sqlsrv_errors(),TRUE));
		}
		else
		{
			while($rowPonte=sqlsrv_fetch_array($resultPonte))
			{
				echo "<tr class='righePonte' id='rigaPonte$id_ditta".$rowPonte['ponte']."' onclick='selezionaPonte($id_registrazione,$id_ditta,".htmlspecialchars(json_encode($rowPonte['ponte'])).")'>";
					echo "<td >".$rowPonte['nome']."</td>";
					echo "<td >".$rowPonte['ponte']."</td>";
					echo "<td >".$rowPonte['nOperatori']."</td>";
					echo "<td >".$rowPonte['ore']."</td>";
					echo '<td ><input type="button" class="btnEliminaRigaRegistrazione" value="" onclick="eliminaRigaRegistrazionePonte('.$id_registrazione.','.$id_ditta.','.htmlspecialchars(json_encode($rowPonte["ponte"])).')" /></td>';
				echo "</tr>";
			}
		}
	
	function getDitta($conn,$id)
	{
		$queryPonte="SELECT Ditta_nome FROM [tblAnagrafica] WHERE ID=$id";
		$resultPonte=sqlsrv_query($conn,$queryPonte);
		if($resultPonte==FALSE)
		{
			echo "<br><br>Errore esecuzione query<br>Query: ".$queryPonte."<br>Errore: ";
			die(print_r(sqlsrv_errors(),TRUE));
		}
		else
		{
			while($rowPonte=sqlsrv_fetch_array($resultPonte))
			{
				return $rowPonte['Ditta_nome'];
			}
		}
	}
	
?>