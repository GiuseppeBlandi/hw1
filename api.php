<?php 
/*******************************************************
    Ritorna un JSON con i risultati dell'API selezionata
********************************************************/
require_once 'auth.php';

// Se la sessione è scaduta, esco
if (!checkAuth()) exit;

// Imposto l'header della risposta
header('Content-Type: application/json');

// A seconda del tipo scelto, eseguo una funzione diversa

switch($_GET['type']) {
    case 'piloti': piloti(); break;
    case 'costruttori': costruttori(); break;
    default: break;
}

function piloti(){
    $query = urlencode($_GET["q"]);
    $url = 'http://ergast.com/api/f1/'.$query.'/driverstandings.json';

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $data = curl_exec($ch);
    
    $json = json_decode($data, true);
    curl_close($ch);

    $json = json_decode($data, true);
    $newJson = array();
    
    for ($i = 0; $i < $json['MRData']['total']; $i++) {
        $newJson[] = array(
                            'type'=>'pilot',
                            'length'=>$json['MRData']['total'],
                            'position' => $json['MRData']['StandingsTable']['StandingsLists'][0]['DriverStandings'][$i]['position'],
                            'pilot' => $json['MRData']['StandingsTable']['StandingsLists'][0]['DriverStandings'][$i]['Driver']['driverId'],
                            'scuderia'=>$json['MRData']['StandingsTable']['StandingsLists'][0]['DriverStandings'][$i]['Constructors'][0]['constructorId'],
                            'points' => $json['MRData']['StandingsTable']['StandingsLists'][0]['DriverStandings'][$i]['points'],
                            'wins' => $json['MRData']['StandingsTable']['StandingsLists'][0]['DriverStandings'][$i]['wins']);
    }

    echo json_encode($newJson);
}

function costruttori(){
    $query=urlencode($_GET["q"]);
    $url='http://ergast.com/api/f1/'.$query.'/constructorStandings.json';

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
    $data = curl_exec($ch);
    
    $json = json_decode($data, true);
    
    curl_close($ch);

    $json = json_decode($data, true);
    
    $newJson = array();

    for ($i = 0; $i < $json['MRData']['total']; $i++) {
        $newJson[] = array(
                            'type'=>'constructor',
                            'length'=>$json['MRData']['total'],
                            'position' => $json['MRData']['StandingsTable']['StandingsLists'][0]['ConstructorStandings'][$i]['position'],
                            'constructor' => $json['MRData']['StandingsTable']['StandingsLists'][0]['ConstructorStandings'][$i]['Constructor']['constructorId'],
                            'points' => $json['MRData']['StandingsTable']['StandingsLists'][0]['ConstructorStandings'][$i]['points'],
                            'wins' => $json['MRData']['StandingsTable']['StandingsLists'][0]['ConstructorStandings'][$i]['wins']);
    }

    echo json_encode($newJson);
}
?>
