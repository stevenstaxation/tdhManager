<?php
// Init cURL session
$curl = curl_init();

$VRNToLookup = $_POST['VRN'];

// Set API Key
$ApiKey = "a3376f88-ee79-4973-93d1-c4b1061a598f";

// Construct URL String
$url = "https://uk1.ukvehicledata.co.uk/api/datapackage/%s?v=2&api_nullitems=1&key_vrm=%s&auth_apikey=%s";
$url = sprintf($url, "VehicleData", $VRNToLookup, $ApiKey); // Syntax: sprintf($url, "PackageName", "VRM", ApiKey);
// Note your package name here. There are 5 standard packagenames. Please see your control panel > weblookup or contact your account manager

// Create array of options for the cURL session
curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET"
));

// Execute cURL session and store the response in $response
$response = curl_exec($curl);

// If the operation failed, store the error message in $error
$error = curl_error($curl);

// Close cURL session
curl_close($curl);

// If there was an error, print it to screen. Otherwise, unserialize response and print to screen.
if ($error) {
  echo "cURL Error: " . $error;
} else {
  echo $response; // For demonstration purposes - Unserialize response & dump array contents to screen
    
}

?>