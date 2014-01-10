<?php
$url = 'http://nmil.knsclients.com/register/new';
//$fields = array('name' => urlencode('admin'),'password' => urlencode('admin888'),'email' => urlencode('joseph@knstek.com'),'contact' => urlencode('33939393939'));
$fields = array('name' => urlencode(''),'password' => urlencode(''),'email' => urlencode(''),'contact' => urlencode('33939393939'));

//url-ify the data for the POST
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string, '&');

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);

$json_response = curl_exec($curl);
$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);
$response = json_decode($json_response, true);

echo "<pre>";
print_r($response);
echo "</pre>";

?>