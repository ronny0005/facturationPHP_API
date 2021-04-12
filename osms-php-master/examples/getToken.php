<?php
require '../src/Osms.php';

use \Osms\Osms;

$config = array(
    'clientId' => 'H3iEIxpjzHsaLQMY9ZeJO2KaBgY2cQTO',
    'clientSecret' => 'yKYUvGD8ZO2DGsAx'
);

$osms = new Osms($config);

//$osms->setVerifyPeerSSL(false);

$response = $osms->getTokenFromConsumerKey();

if (empty($response['error'])) {
    echo $response['access_token'];
    // echo $osms->getToken();
    // echo '<pre>'; print_r($response); echo '</pre>';
} else {
    echo $response['error'];
}
