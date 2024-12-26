<?php

$apiKey = 'hMLEkomeHUGPEdhMWuKMYX9pXh8eZgVw';

$address = 'madhav flat bharimata road causeway road surat 395004';

$address = urlencode($address);

$url = "https://api.tomtom.com/search/2/geocode/$address.json?key=$apiKey";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
} else {

    $data = json_decode($response, true);


    if (isset($data['results'][0]['position']['lat']) && isset($data['results'][0]['position']['lon'])) {
        // Extract the latitude and longitude
        $latitude = $data['results'][0]['viewport']['btmRightPoint']['lat'];
        $longitude = $data['results'][0]['viewport']['btmRightPoint']['lon'];

        // Output the latitude and longitude
        echo "Latitude: $latitude, Longitude: $longitude";
    } else {
        echo "Address not found!";
    }
}

curl_close($ch);

?>