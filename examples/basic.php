<?php 

require '../vendor/autoload.php';

$xorder = new XOrder\XOrder('xorder.xml', true);
$credentials = new XOrder\Credentials('bridgeb', 'brg75brw', '190566');

$client = new XOrder\Client($credentials);
$client->login();

$response = $client->send($xorder);

var_dump($response);
var_dump($response->toArray());
