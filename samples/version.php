<?php

# This will output debug info into the http response, and is just meant to give an idea of how to call the API.

$url = "https://api.whatismybrowser.com/api/v3/version_numbers";
$api_key = "b48f13776d308f2224512d5b255fbbeb";

# -- Set up HTTP Headers for the API request
$headers = [
    'X-API-KEY: '.$api_key,
];

# -- Create a CURL handle
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

# -- Make the request
$result = curl_exec($ch);
$curl_info = curl_getinfo($ch);
curl_close($ch);

# -- Decode the api response as json
$result_json = json_decode($result);
if ($result_json === null) {
    echo "Couldn't decode the response as JSON\n";
    echo $result;
    exit();
}

# -- Check the API request was successful
if ($result_json->result->code != "success") {
    echo "The API did not return a 'success' response. It said:<br />result code: ".$result_json->result->code.", message_code: ".$result_json->result->message_code.", message: ".$result_json->result->message."<br />\n";
    exit();
}

# -- Pretty print the full response
echo "<pre>".json_encode($result_json, JSON_PRETTY_PRINT)."</pre>\n";

# -- Demonstrating printing out specific software version numbers:
echo "Latest Chrome on Windows Version Number: ".implode(".", $result_json->version_data->software->chrome->windows->latest_version)."\n";
echo "Latest Firefox (standard, desktop) Version Number: ". implode(".", $result_json->version_data->software->firefox->standard->latest_version)."\n";
