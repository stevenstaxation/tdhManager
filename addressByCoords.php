<?php

$lat = POST['latitude'];
$lng = POST['longitude'];

// Get the address based on returned lat & long
$address_url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $lat . ',' . $lng . '&sensor=false&key=AIzaSyAVW9tbTr9ILP5uL8RXuBrZ5AOvSGe8LwA';
console.log(address_utl);
$address_json = json_decode(file_get_contents($address_url));
$address_data = $address_json->results[0]->address_components;

foreach($address_data as $data) {
    $array[$data->types[0]] = $data->long_name;
}

echo json_encode($array);


?>