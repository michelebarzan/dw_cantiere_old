<?php

	include "connessione.php";
	include "Session.php";

	//echo "<div id='divBottoniRegistrazioni'>";
		echo "<input type='button' id='btnDuplica' class='btnRegistrazioni' onclick='duplicaRegistrazione()' value='Duplica registrazione' />";
		echo "<input type='button' id='btnElimina' class='btnRegistrazioni' onclick='aliminaRegistrazione()' value='Elimina registrazione' />";
		echo "<input type='button' id='btnNuova' class='btnRegistrazioni' onclick='nuovaRegistrazione()' value='Nuova registrazione' />";
	//echo "</div>";

?>