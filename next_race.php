<?php 

require_once 'auth.php';

if (!checkAuth()) exit;

header('Content-Type: application/json');
next_race();

function next_race(){

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api-formula-1.p.rapidapi.com/races?timezone=Europe%2FRome&next=1",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "X-RapidAPI-Host: api-formula-1.p.rapidapi.com",
            "X-RapidAPI-Key: 3602ceead1mshea92eb39f141411p112260jsn27954b3ffb16"
        ],
    ]);
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
        
    if ($err) 
        echo "cURL Error #:" . $err;

    $json = json_decode($response, true);
    $next = array();

            $next[0] = array(
                            'name'=>$json['response'][0]['competition']['name'],
                            'city'=>$json['response'][0]['competition']['location']['city'],
                            'laps' => $json['response'][0]['laps']['total'],);
    
    curl_close($curl);            
    # Ritorno l'array
    echo json_encode($next);
}

?>