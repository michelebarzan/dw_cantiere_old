<?php
	include "Session.php";
	include "connessione.php";
	
	$pageName="Homepage";
	$appName="Cantiere";
?>
<html>
	<head>
		<title><?php echo $appName."&nbsp&#8594&nbsp".$pageName; ?></title>
		<link rel="stylesheet" href="css/styleV15.css" />
		<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.png" />
		<script src="struttura.js"></script>
		<link rel="stylesheet" href="fontawesomepro/css/fontawesomepro.css" />
		<script>
			function setCommessa(valore)
			{
				var id_commessa=valore.split("|")[0];
				var commessa=valore.split("|")[1];
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						if(this.responseText.indexOf("Error")!=-1 || this.responseText.indexOf("Notice")!=-1)
							window.alert("Errore. Impossibile selezionare la commessa. Se il problema persiste contattare l' amministratore.");
					}
				};
				xmlhttp.open("POST", "setCommessa.php?id_commessa="+id_commessa+"&commessa="+commessa, true);
				xmlhttp.send();
			}
		</script>
	</head>
	<body onload='aggiungiNotifica("Ricordati di selezionare la commessa. Il programma ricordera la tua scelta")'>
		<?php include('struttura.php'); ?>
		<div id="container">
			<div id="content">
				<div id="immagineLogo" class="immagineLogo" ></div>
				<div class="homepageCommessaContainer">
					<span>Stai lavorando sulla commessa </span>
					<select id="selectCommessaHomepage" onchange="setCommessa(this.value)">
						<?php
							$queryPonte="SELECT * FROM commesse ORDER BY commessa";
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
									if($_COOKIE['id_commessa']==$rowPonte['id_commessa'])
									{
										echo "<option value='".$rowPonte['id_commessa']."|".$rowPonte['commessa']."' selected='selected'>".$rowPonte['commessa']."</option>";
										$_SESSION['id_commessa']=$_COOKIE['id_commessa'];
										$_SESSION['commessa']=$_COOKIE['commessa'];
									}
									else
										echo "<option value='".$rowPonte['id_commessa']."|".$rowPonte['commessa']."' >".$rowPonte['commessa']."</option>";
								}
								if(!isset($_COOKIE['id_commessa']))
								{
									echo '<script>setCommessa(document.getElementById("selectCommessaHomepage").value);</script>';
								}
							}
						?>
					</select>
				</div>
				<div class="homepageLinkContainer">
					<div class="homepageLink" title="Imposta i filtri e visualizza la griglia per la registrazione delle attivita" onclick="gotopath('gestionePrg.php')">
						<i class="fal fa-tablet-alt fa-2x"></i>
						<span>Griglia registrazioni</span>
					</div>
					<div class="homepageLink" title="Registra le presenze delle ditte e del personale" onclick="gotopath('presenzeDitte.php')">
						<i class="fal fa-list-alt fa-2x"></i>
						<span>Presenze<br>ditte</span>
					</div>
					<div class="homepageLink" title="Inserisci le anagrafiche delle ditte e del personale" onclick="gotopath('inserimentoAnagrafiche.php')">
						<i class="fal fa-user-plus fa-2x"></i>
						<span>Inserimento anagrafiche</span>
					</div>
				</div>
			</div>
		</div>
		<div id="footer">
			<b>De&nbspWave&nbspS.r.l.</b>&nbsp&nbsp|&nbsp&nbspVia&nbspDe&nbspMarini&nbsp116149&nbspGenova&nbspItaly&nbsp&nbsp|&nbsp&nbspPhone:&nbsp(+39)&nbsp010&nbsp640201
		</div>
	</body>
</html>





