<?php

# This will output debug info into the http response, and is just meant to give an idea of how to call the API.

$url = "https://api.whatismybrowser.com/api/v3/detect";
$api_key = "b48f13776d308f2224512d5b255fbbeb";

# -- responses should have Client Hints headers to induce the client to include *all* Client Hints (not just the basic ones)
header("accept-ch: Sec-Ch-Ua,Sec-Ch-Ua-Full-Version,Sec-Ch-Ua-Platform,Sec-Ch-Ua-Platform-Version,Sec-Ch-Ua-Arch,Sec-Ch-Bitness,Sec-Ch-Ua-Model,Sec-Ch-Ua-Mobile,Device-Memory,Dpr,Viewport-Width,Downlink,Ect,Rtt,Save-Data,Sec-Ch-Prefers-Color-Scheme,Sec-Ch-Prefers-Reduced-Motion,Sec-Ch-Prefers-Contrast,Sec-Ch-Prefers-Reduced-Data,Sec-Ch-Forced-Colors");
header("critical-ch: Sec-Ch-Ua,Sec-Ch-Ua-Full-Version,Sec-Ch-Ua-Platform,Sec-Ch-Ua-Platform-Version,Sec-Ch-Ua-Arch,Sec-Ch-Bitness,Sec-Ch-Ua-Model,Sec-Ch-Ua-Mobile,Device-Memory,Dpr,Viewport-Width,Downlink,Ect,Rtt,Save-Data,Sec-Ch-Prefers-Color-Scheme,Sec-Ch-Prefers-Reduced-Motion,Sec-Ch-Prefers-Contrast,Sec-Ch-Prefers-Reduced-Data,Sec-Ch-Forced-Colors");

# Header order matters, and json dicts don't guarantee order (in some cases)
# So it's necessary to send them as a list of key/value pairs, because lists do preserve order.
$headers_list = [];

# Here we use getallheaders() to get all the headers (instead of looping over $_SERVER)
foreach (getallheaders() as $name => $value) {
    array_push($headers_list, array("name" => $name, "value" => $value));
}

# -- Set up HTTP Headers for the API request
$headers = [
    'X-API-KEY: '.$api_key,
];

# -- Prepare data for the API request
$post_data = array(
    "headers" => $headers_list,
);

# -- Create a CURL handle containing the settings & data
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, true);
curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($post_data));
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

# Now you have "$result_json" and can store, display or process any part of the response.

# -- Copy the data to some variables for easier use
$detection = $result_json->detection;
$risks = $result_json->risks;
$version_check = $result_json->version_check;

$isBrowser = $detection->software_type == "browser" ? 'True' : 'False';
$hasRisks = count($risks->user_agent_risks) > 0 ? 'True' : 'False';

# Now you can do whatever you need to do with the detection result
# Print it to the console, store it in a database, etc

echo "<div>User Agent: ".$_SERVER['HTTP_USER_AGENT']."</div>";
echo "<div>User Agent is Browser: ".$isBrowser." | Type=".$detection->software_type."</div>";
echo "<div>User Agent has risks: ".$hasRisks." | Risk array vardump: "; var_dump($risks->user_agent_risks); echo "</div>";

?>
