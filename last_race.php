<?php

require_once 'auth.php';

if (!checkAuth()) exit;

header('Content-Type: application/json');

last_race();

function last_race(){

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api-formula-1.p.rapidapi.com/races?type=race&timezone=Europe%2FRome&last=1",
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
    
    $json = json_decode($response, true);

    if ($err) 
	echo "cURL Error #:" . $err;  


$curl_driver = curl_init();

curl_setopt_array($curl_driver, [
	CURLOPT_URL => "https://api-formula-1.p.rapidapi.com/rankings/races?race=1513",
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

$res = curl_exec($curl_driver);
$err2 = curl_error($curl_driver);

$json_driver = json_decode($res,true);

if ($err2) 
    echo "cURL_driver Error #:" . $err2;
    
    $last = array();

            $last[0] = array(
                            'name' => $json['response'][0]['competition']['name'],
                            'city' => $json['response'][0]['competition']['location']['city'],
                            'winner' => $json_driver['response'][0]['driver']['name']);
    
    curl_close($curl);
    curl_close($curl_driver);
    # Ritorno l'array
    echo json_encode($last);
}
?>