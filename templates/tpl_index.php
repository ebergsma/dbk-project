<?php

if(!isset($title) or $title == '' or is_null($title)) $title = 'Assesment opdracht DBK';
?>
		
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Assesment">
		<meta name="author" content="Elwin">

		<title><? echo $title; ?></title>

		<!-- Bootstrap core CSS -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		
		<!-- Custom CSS -->
		<link href="css/custom.css" rel="stylesheet">
	</head>
	
	<body>
		<div class="container-fluid">
			<form id="form" action="?action=toon_resultaat" method="POST">
<?php
	if($errMsg != ''){
		$errTitle = (substr_count ($errMsg, '<br/>') > 1 ? 'De volgende fouten zijn opgetreden:' : 'De volgende fout is opgetreden:');
?>
				<div class="row">
					<div class="alert alert-danger" role="alert"><? echo '<h3>'.$errTitle.'</h3>'.$errMsg; ?></div>
				</div>	
<?php		
	}
?>				
				<div class="row">
					<div class="col-sm-6">
						<h1>Bereken uw Return on Investment</h1>
					</div>	
				</div>
				<div class="row">
					<div class="col-sm-6"><label for="omzet">Gewenste omzet per maand</label></div>
					<div class="col-sm-6"><input type="text" class="euro placeholder" placeholder="100.000" id="omzet" name="omzet" value="<? echo ((array_key_exists('omzet',$_POST) and $_POST['omzet'] != '') ? $_POST['omzet'] : ''); ?>"></div>
					<div class="col-sm-6"><label for="marge">marge</label></div>
					<div class="col-sm-6">
						<select id="marge" name="marge">
							<option value="15">&gt; 15&percnt;</option>
							<option value="0">&lt; 15&percnt;</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6"><label for="bestel-waarde">Gemiddelde bestel waarde</label></div>
					<div class="col-sm-6"><input type="text" class="euro placeholder" placeholder="100" name="bestel_waarde" id="bestel_waarde" value="<? echo ((array_key_exists('bestel_waarde',$_POST) and $_POST['bestel_waarde'] != '') ? $_POST['bestel_waarde'] : ''); ?>"></div>
				</div>
				<div class="row">
					<div class="col-sm-6"><label for="conversie">Conversiepercentage</label></div>
					<div class="col-sm-6">
						<input type="text" size="4" class="percentage placeholder" placeholder="1" name="conversie" id="conversie" value="<? echo ((array_key_exists('conversie',$_POST) and $_POST['conversie'] != '') ? $_POST['conversie'] : ''); ?>">
						<input type="checkbox" name="conversie_onbekend" id="conversie-onbekend">
						<label for="conversie-onbekend">weet ik niet</label>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6"><label for="naam">URL webshop</label></div>
					<div class="col-sm-6"><input type="text" placeholder="webshop.nl" name="naam" id="naam" value="<? echo ((array_key_exists('naam',$_POST) and $_POST['naam'] != '') ? $_POST['naam'] : ''); ?>" class="placeholder"></div>
				</div>
				<div class="row">
					<div class="col-sm-6"><label for="naam">E-mailadres</label></div>
					<div class="col-sm-6"><input type="text" placeholder="info@webshop.nl" value="<? echo ((array_key_exists('email',$_POST) and $_POST['email'] != '') ? $_POST['email'] : ''); ?>" name="email" id="email" class="placeholder"></div>
				</div>
				<div class="row">
					<div class="col-sm-6">Nieuwsbrief</div>
					<div class="col-sm-6" colspan="3">
						<input type="checkbox" value="1" name="nieuwsbrief" id="nieuwsbrief">
						<label for="nieuwsbrief">Ja, ik wil mij graag aanmelden voor de nieuwsbrief</label>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6"><label for="zoekterm1">Zoektermen</label></div>
					<div class="col-sm-6"><input type="text" name="zoekterm1" id="zoekterm1" value="<? echo ((array_key_exists('zoekterm1',$_POST) and $_POST['zoekterm1'] != '') ? $_POST['zoekterm1'] : ''); ?>"></div>
					<div class="col-sm-6"><label for="zoekterm2">&nbsp;</label></div>
					<div class="col-sm-6"><input type="text" name="zoekterm2" id="zoekterm2" value="<? echo ((array_key_exists('zoekterm2',$_POST) and $_POST['zoekterm2'] != '') ? $_POST['zoekterm2'] : ''); ?>"></div>
					<div class="col-sm-6"><label for="zoekterm3">&nbsp;</label></div>
					<div class="col-sm-6"><input type="text" name="zoekterm3" id="zoekterm3" value="<? echo ((array_key_exists('zoekterm3',$_POST) and $_POST['zoekterm3'] != '') ? $_POST['zoekterm3'] : ''); ?>"></div>
					<div class="col-sm-6"><label for="zoekterm4">&nbsp;</label></div>
					<div class="col-sm-6"><input type="text" name="zoekterm4" id="zoekterm4" value="<? echo ((array_key_exists('zoekterm4',$_POST) and $_POST['zoekterm4'] != '') ? $_POST['zoekterm4'] : ''); ?>"></div>
					<div class="col-sm-6"><label for="zoekterm5">&nbsp;</label></div>
					<div class="col-sm-6"><input type="text" name="zoekterm5" id="zoekterm5" value="<? echo ((array_key_exists('zoekterm5',$_POST) and $_POST['zoekterm5'] != '') ? $_POST['zoekterm5'] : ''); ?>"></div>
				</div>
				<div class="row">
					<div class="col-sm-6"><input type="submit" value="Bereken Roi"></div>
					<div class="col-sm-6"><? echo $melding ?></div>
				</div>
			</form>
		</div>
	</body>
</html>	