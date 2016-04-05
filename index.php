<?php
	
	error_reporting(E_ALL);
	
	session_start();
	
	require_once('system/mysql.php');
	require_once('system/functions.php');
	
	// indien de gebruiker het formulier heeft ingevuld, controleer de input, anders niet.
	$errMsg = (isset($_GET['action']) ? checkFormValues() : '');
			
	if(isset($_GET['action']) and $_GET['action'] == 'update_resultaat'){
		//indien er voor de standaard gegevens al een fout is, toon de fout.
		if($errMsg != ''){
			$error = array('status_ok'=>false,'msg'=>$errMsg);
			print(json_encode($error));
		}else{
			$values = getFormValues($dbc,true);
			$values['status_ok'] = true;
			print(json_encode($values));
		}
	}elseif(isset($_GET['action']) and $_GET['action'] == 'toon_resultaat' and $errMsg == ''){
		// indien gewenst, abboneren we de gebruiker op de nieuwsbrief.
		if(array_key_exists('nieuwsbrief', $_POST) and $_POST['nieuwsbrief'] == 1) abboneerOpNieuwsbrief($_POST['email'],$dbc);
		$values = getFormValues($dbc,false);
		include('./templates/tpl_resultaat.php');
	}else{
		$statement = $dbc->prepare("select date_created from gemaakte_berekeningen order by id DESC limit 0,1");
		$statement->execute();
		$row = $statement->fetch();
		if(is_array($row)){
			$melding = 'Laatste berekening was '.getTimeDifference($row['date_created']);
		}else{
			$melding = "U bent de eerste!";
		}
		include('./templates/tpl_index.php');
	}

?>