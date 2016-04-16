<?php
    
    error_reporting(E_ALL);
    
    session_start();
    
    require_once('system/mysql.php');
    require_once('system/functions.php');
    
    if (strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') === 0) {
        $_SESSION['postdata'] = $_POST;
        header('Location: ' . $_SERVER['PHP_SELF'] . '?'
        . $_SERVER['QUERY_STRING']);
        exit;
    }
    if (isset($_SESSION['postdata'])) {
        $_POST = $_SESSION['postdata'];
    }
    
    /*
        indien de gebruiker het formulier heeft ingevuld, controleer de input,
        anders niet.
    */
    $error_message = (
        isset($_GET['actie'])
        ? checkFormValues()
        : ''
    );
            
    if (isset($_GET['actie']) and $_GET['actie'] == 'update_resultaat'){
        //indien er voor de standaard gegevens al een fout is, toon de fout.
        if($error_message != ''){
            $error = array(
                'status_ok' => false,
                'msg' => $error_message
            );
            print(
                json_encode($error)
            );
        }else{
            $values = getFormValues($dbc, true);
            $values['status_ok'] = true;
            print(
                json_encode($values)
            );
        }
    } elseif (
            isset($_GET['actie'])
            and $_GET['actie'] == 'toon_resultaat'
            and $error_message == ''
    ){        
        // indien gewenst, abboneren we de gebruiker op de nieuwsbrief.
        if (
            array_key_exists('nieuwsbrief', $_POST)
            and
            $_POST['nieuwsbrief'] == 1
        ) abboneerOpNieuwsbrief($_POST['email'], $dbc);
        
        $values = getFormValues($dbc, false);
        include('./templates/tpl_resultaat.php');
    } else {
		if (isset($_SESSION['postdata'])) {
			unset($_SESSION['postdata']);
		}	
        $statement = $dbc->prepare(
            'select date_created'
            . ' from gemaakte_berekeningen order by id DESC limit 0,1'
            );
        $statement->execute();
        $row = $statement->fetch();
        if (is_array($row)) {
            $melding = 'Laatste berekening was '
            . getTimeDifference($row['date_created']);
        } else {
            $melding = 'U bent de eerste!';
        }
        include('./templates/tpl_index.php');
    }
