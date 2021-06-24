<?php

$postcode = $_POST['postcode'];

$postcode = urlencode($postcode);

$query = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $postcode . '&sensor=false&key=AIzaSyAVW9tbTr9ILP5uL8RXuBrZ5AOvSGe8LwA';
$result = json_decode(file_get_contents($query));



$lat = $result->results[0]->geometry->location->lat;
$lng = $result->results[0]->geometry->location->lng;

// Get the address based on returned lat & long
$address_url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $lat . ',' . $lng . '&sensor=false&key=AIzaSyAVW9tbTr9ILP5uL8RXuBrZ5AOvSGe8LwA';
$address_json = json_decode(file_get_contents($address_url));
$address_data = $address_json->results[0]->address_components;

foreach($address_data as $data) {
    $array[$data->types[0]] = $data->long_name;
}

echo json_encode($array);


?>