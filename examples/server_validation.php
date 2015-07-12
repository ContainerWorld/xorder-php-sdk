<?php 

require '../vendor/autoload.php';

try {
    
    $xorder = new XOrder\XOrder('xorder.xml', true);
    $credentials = new XOrder\Credentials('username', 'password', 'account');

    $client = new XOrder\Client;
    $client->login($credentials);
    
    $response = $client->validate($xorder);

}

catch (XOrder\Exceptions\FileDoesNotExistException $e) {}
catch (XOrder\Exceptions\InvalidCredentialsException $e) {}
catch (XOrder\Exceptions\XOrderConnectionException $e) {}

finally {
    var_dump($response);
}
