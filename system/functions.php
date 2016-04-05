<?php 

	/*
		We controleren of de minimaal benodigde waarden aanwezig zijn.
		Indien dit niet het geval is, of de waarden zijn niet correct, retourneren we een foutmelding.
	*/
	function checkFormValues(){
		$errMsg = '';
		
		if(!is_array($_POST)) $errMsg =  $errMsg . 'U hebt geen waarden ingevoerd.<br/>';
		
		if(!array_key_exists('omzet', $_POST) or (array_key_exists('omzet', $_POST) and $_POST['omzet'] == '')) $errMsg = $errMsg . 'U hebt geen omzet opgegeven.<br/>';
		if(array_key_exists('omzet', $_POST) and !is_numeric(str_replace(array('.',','),'',$_POST['omzet']))) $errMsg =  $errMsg . 'De door u opgegeven omzet was geen valide bedrag.<br/>';
		
		if(!array_key_exists('bestel_waarde', $_POST) or (array_key_exists('bestel_waarde', $_POST) and $_POST['bestel_waarde'] == '')) $errMsg = $errMsg . 'U hebt geen bestel waarde opgegeven.<br/>';
		if(array_key_exists('bestel_waarde', $_POST) and !is_numeric(str_replace(array('.',','),'',$_POST['bestel_waarde']))) $errMsg =  $errMsg . 'De door u opgegeven bestel waarde was geen valide bedrag.<br/>';
		
		// enkel controle wanneer we er wat mee gaan doen.
		if(array_key_exists('nieuwsbrief', $_POST)){
			if(!array_key_exists('email', $_POST) or (array_key_exists('email', $_POST) and $_POST['email'] == '')) $errMsg = $errMsg . 'U hebt geen email adres opgegeven.<br/>';
			if(!array_key_exists('email', $_POST) or (array_key_exists('email', $_POST) and !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))) $errMsg = $errMsg . 'U hebt geen geldig email adres opgegeven.<br/>';
		}
		
		if(!array_key_exists('conversie_onbekend', $_POST)){
			if(!array_key_exists('conversie', $_POST) or (array_key_exists('conversie', $_POST) and $_POST['conversie'] == '')) $errMsg = $errMsg . 'U hebt geen conversie percentage opgegeven.<br/>';
			if(array_key_exists('conversie', $_POST) and (!is_numeric(str_replace(array('.',','),'',$_POST['conversie'])) or !validPercentage($_POST['conversie']))) $errMsg =  $errMsg . 'De door u opgegeven conversie was geen valide percentage.<br/>';
		}
		
		if(array_key_exists('marketing_budget_percentage',$_POST) and $_POST['marketing_budget_percentage'] == '') $errMsg = $errMsg . 'U hebt geen markting budget percentage opgegeven.<br/>';
		if(array_key_exists('marketing_budget_percentage',$_POST) and $_POST['marketing_budget_percentage'] != '' and !is_numeric($_POST['marketing_budget_percentage'])) $errMsg = $errMsg . 'U hebt geen geldig markting budget percentage opgegeven.';
		if(array_key_exists('marketing_budget_percentage',$_POST) and !validPercentage($_POST['marketing_budget_percentage'])) $errMsg = $errMsg . 'U hebt geen geldig markting budget percentage opgegeven.';
		
		if(
			(array_key_exists('direct', $_POST) and is_numeric($_POST['direct']))
			and (array_key_exists('google', $_POST) and is_numeric($_POST['google']))
			and (array_key_exists('vw_betaald', $_POST) and is_numeric($_POST['vw_betaald']))
			and (array_key_exists('vw_onbetaald', $_POST) and is_numeric($_POST['vw_onbetaald']))
			and (array_key_exists('overig', $_POST) and is_numeric($_POST['overig']))
			and (array_key_exists('adwords', $_POST) and is_numeric($_POST['adwords']))
			){
				if(array_sum(array($_POST['direct'],$_POST['google'],$_POST['vw_betaald'],$_POST['vw_onbetaald'],$_POST['overig'],$_POST['adwords'])) != 100){
					$errMsg = $errMsg . 'Het totaal aan percentage bezoekers moet 100 bedragen. Dit is niet het geval.<br/>';
				}
			
		}
		
		return $errMsg;
	}
	
	/*
		Controleer of zoekwoord bekend is. Indien zo, retoutneer de bekende waarden.
		Indien niet, genereer waarden en sla deze op voor toekomstige opdrachten.
		
		Deze functie zou eigenlijk een google api moeten aanroepen voor correcte resultaten.
		In dit voorbeeld wordt dat niet gebruikt.
	*/
	function getZoekwoordResultaat($zoekwoord, $dbc){
		$statement = $dbc->prepare("select * from zoekwoorden where woord = :woord");
		$statement->execute(array(':woord' => $zoekwoord));
		$row = $statement->fetch();
		if(is_array($row)){
			$cpc = $row['cpc'];
			$volume = $row['volume'];
		}else{
			$cpc = rand(0,200); //cpc in centen
			$volume = rand(0,1000000); //volume per maand
			$statement = $dbc->prepare('insert into zoekwoorden (woord,cpc,volume) VALUES (:woord,:cpc,:volume)');
			$statement->execute(array(':woord' => $zoekwoord,':cpc'=>$cpc,':volume'=>$volume));
		}
		
		return array('woord'=>$zoekwoord,'cpc'=>$cpc,'volume'=>$volume);		
	}
	
	/*
		functie om tijd geleden te tonen op het formulier.
		Code is niet van mij, komt van stack overflow: http://stackoverflow.com/questions/1416697/converting-timestamp-to-time-ago-in-php-e-g-1-day-ago-2-days-ago
		Heb de strings enkel vertaald.
	*/
	function getTimeDifference($time) {
		//Let's set the current time
		$currentTime = date('Y-m-d H:i:s');
		$toTime = strtotime($currentTime);
		
		$fromTime = strtotime($time);
		
		$timeDiff = floor(abs($toTime - $fromTime) / 60);

		if ($timeDiff < 2) {
			$timeDiff = "Zojuist";
		} elseif ($timeDiff > 2 && $timeDiff < 60) {
			$timeDiff = floor(abs($timeDiff)) . " minuten geleden";
		} elseif ($timeDiff > 60 && $timeDiff < 120) {
			$timeDiff = floor(abs($timeDiff / 60)) . " uur geleden";
		} elseif ($timeDiff < 1440) {
			$timeDiff = floor(abs($timeDiff / 60)) . " uren geleden";
		} elseif ($timeDiff > 1440 && $timeDiff < 2880) {
			$timeDiff = floor(abs($timeDiff / 1440)) . " dag geleden";
		} elseif ($timeDiff > 2880) {
			$timeDiff = floor(abs($timeDiff / 1440)) . " dagen geleden";
		}

		return $timeDiff;
	}
	
	/*
		Wanneer het email adres nog niet bekend is, opslaan in nieuwsbrief abbonees tabel.
	*/
	function abboneerOpNieuwsbrief($email,$dbc){
		$statement = $dbc->prepare('select * from niewsbrief_aanmeldingen where email = :email');
		$statement->execute(array(':email' => $email));
		$row = $statement->fetch();
		if(!is_array($row)){
			$statement = $dbc->prepare('insert into niewsbrief_aanmeldingen (email) VALUES (:email)');
			$statement->execute(array(':email' => $email));
		}
	}
	
	function validPercentage($getal){
		if(!is_numeric($getal)) return false;
		return ((intval(round($getal)) >= 0 and intval(round($getal)) <= 100) ? true : false);
	}
	
	/*
		Indien er geen errors zijn gevonden met de ingevoerde waarden, kunnen we deze verwerken tot waarden die we in de berekening kunnen gebruiken.
		Deze functie retourneert ook meteen de berekende velden op basis van de ingevoerde waarden en slaat deze op in de database.
	*/
	function getFormValues($dbc,$jquery=false){
		// $cpc = budget_marketing / betaald_bezoek;
		$values = array();
		$values['omzet'] = str_replace(array('.',','),'',$_POST['omzet']);
		$values['marge'] = $_POST['marge'];
		$values['marketing_budget_percentage'] = ((isset($_POST['marketing_budget_percentage']) and $_POST['marketing_budget_percentage'] != '' and validPercentage(str_replace(array('.',','),'',$_POST['conversie']))) ? $_POST['marketing_budget_percentage'] : ($values['marge'] == 15 ? '7.5' : '2.5'));
		$values['marketing_budget_bedrag'] = ((isset($_POST['marketing_budget_bedrag']) and $_POST['marketing_budget_bedrag'] != '') ? str_replace(array('.',','),'',$_POST['marketing_budget_bedrag']) : ($values['omzet'] / 100 * $values['marketing_budget_percentage'])); // kan uit opslag
		$values['bestel_waarde'] = str_replace(array('.',','),'',$_POST['bestel_waarde']);
		$values['conversie'] = (array_key_exists('conversie_onbekend', $_POST) ? 1 : str_replace(array('.',','),'',$_POST['conversie']));
		$values['benodigde_bestellingen'] = round($values['omzet'] / $values['bestel_waarde']); // kan uit opslag
		$values['bezoekers'] = round( 100 / $values['conversie'] * $values['benodigde_bestellingen']); // kan uit opslag
		$values['session_id'] = session_id();
		
		$values['direct'] = ((array_key_exists('direct', $_POST) and validPercentage($_POST['direct'])) ? $_POST['direct'] : 20);
		$values['google'] = ((array_key_exists('google', $_POST) and validPercentage($_POST['google'])) ? $_POST['google'] : 25);
		$values['adwords'] = ((array_key_exists('adwords', $_POST) and validPercentage($_POST['adwords'])) ? $_POST['adwords'] : 35);
		$values['vw_betaald'] = ((array_key_exists('vw_betaald', $_POST) and validPercentage($_POST['vw_betaald'])) ? $_POST['vw_betaald'] : 10);
		$values['vw_onbetaald'] = ((array_key_exists('vw_onbetaald', $_POST) and validPercentage($_POST['vw_onbetaald'])) ? $_POST['vw_onbetaald'] : 10);
		$values['overig'] = ((array_key_exists('overig', $_POST) and validPercentage($_POST['overig'])) ? $_POST['overig'] : 0);
		
		$values['percentage_samen'] = ($values['adwords'] + $values['vw_betaald']); // kan uit opslag
		$values['betaald_bezoek']  = round($values['percentage_samen'] / 100 * $values['bezoekers']); // kan uit opslag
		$values['bezoekers_kopen'] = round($values['bezoekers'] / 100 * $values['percentage_samen']); // kan uit opslag
		
		$values['cpc'] = number_format((float)($values['marketing_budget_bedrag'] / $values['betaald_bezoek']), 2, '.', ''); // kan uit opslag
		
		if(!$jquery){
			$values['naam'] = $_POST['naam'];			
			$values['zoekterm1'] = getZoekwoordResultaat($_POST['zoekterm1'], $dbc);
			$values['zoekterm2'] = getZoekwoordResultaat($_POST['zoekterm2'], $dbc);
			$values['zoekterm3'] = getZoekwoordResultaat($_POST['zoekterm3'], $dbc);
			$values['zoekterm4'] = getZoekwoordResultaat($_POST['zoekterm4'], $dbc);
			$values['zoekterm5'] = getZoekwoordResultaat($_POST['zoekterm5'], $dbc);
		}else{
			$statement = $dbc->prepare('select naam, zoekterm1, zoekterm2, zoekterm3, zoekterm4, zoekterm5 from gemaakte_berekeningen where session_id = :session_id order by id DESC limit 0,1');
			$statement->execute(array('session_id'=>$values['session_id']));
			$data = $statement->fetch();
			if(is_array($data)){
				for($i=1;$i<=5;$i++){
					$values['zoekterm'.$i] = getZoekwoordResultaat($data['zoekterm'.$i], $dbc);
				}
				$values['naam'] = $data['naam'];
			}else{
				for($i=1;$i<=5;$i++){
					$values['zoekterm'.$i] = getZoekwoordResultaat('', $dbc);
				}
				$values['naam'] = '';
			}
		}
		
		$values['totaal_zoekvolume'] = 0; // kan uit opslag
		$values['totaal_cpc'] = 0; // kan uit opslag
		
		$insert_values = array();
		foreach($values as $k => $v){
			if(is_array($v)){
				$insert_values[':'.$k] = $v['woord'];
				if($v['woord'] != ''){
					$values['totaal_zoekvolume'] += $v['volume'];
					$values['totaal_cpc'] += $v['cpc'];
				}	
			}else{
				$insert_values[':'.$k] = $v;
			}
		}
		
		if($values['totaal_cpc'] == 0){
			// 1 euro indien niets opgegeven.
			$values['totaal_cpc'] = 100;
		}
		
		$insert_values[':cpc_euros'] = $values['cpc_euros'] = ($values['totaal_cpc'] / 100);
				
		$statement = $dbc->prepare('insert into gemaakte_berekeningen (omzet,marge,marketing_budget_percentage,marketing_budget_bedrag,cpc,bestel_waarde,conversie,benodigde_bestellingen,bezoekers,naam,percentage_samen,betaald_bezoek,bezoekers_kopen,totaal_zoekvolume,totaal_cpc,cpc_euros,direct,google,adwords,vw_betaald,vw_onbetaald,overig,zoekterm1,zoekterm2,zoekterm3,zoekterm4,zoekterm5,session_id) VALUES (:omzet,:marge,:marketing_budget_percentage,:marketing_budget_bedrag,:bestel_waarde,:conversie,:benodigde_bestellingen,:bezoekers,:naam,:percentage_samen,:betaald_bezoek,:bezoekers_kopen,:totaal_zoekvolume,:totaal_cpc,:cpc_euros,:direct,:google,:adwords,:cpc,:vw_betaald,:vw_onbetaald,:overig,:zoekterm1,:zoekterm2,:zoekterm3,:zoekterm4,:zoekterm5,:session_id)');
		$statement->execute($insert_values);
		
		$values['adwords_bezoekers_nodig'] = round(($values['bezoekers'] / 100) * $values['adwords']);
		$values['cpc_prijs'] = (($values['omzet'] / 100) * $values['marketing_budget_percentage']);
		$values['cpc_budget'] = ($values['cpc_prijs'] / $values['bezoekers_kopen']);
		$values['cpc_mogelijk'] = (($values['cpc_budget'] >= $values['cpc_euros']) ? true : false);
		$values['cpc_prijs'] = number_format((float)$values['cpc_prijs'], 2, '.', '');
		$values['cpc_budget'] = number_format((float)$values['cpc_budget'], 2, '.', '');
		//de gebruiker heeft niets aan de session_id of zoektermen, enkel de totale waarde is nodig.
		unset($values['session_id']);
		if($jquery){
			for($i=1;$i<=5;$i++){
				unset($values['zoekterm'.$i]);
			}
		}
		
		return $values;
	}
	
