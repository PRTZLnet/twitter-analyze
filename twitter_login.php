<?php
 
require __DIR__ . '/vendor/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;
session_start();
$config = require_once 'cfg.php';
// much of the following is adapted from Anton Bagaiev's guide that can be found here: https://code.tutsplus.com/tutorials/how-to-authenticate-users-with-twitter-oauth-20--cms-25713


$initial = new TwitterOAuth($config['consumer_key'], $config['consumer_secret']);
$getToken = $initial->oauth(
    'oauth/request_token', [
        'oauth_callback' => $config['url_callback']
    ]
);
 
if($initial->getLastHttpCode() != 200) {
    //if it's not 200, I'm probably getting banned.
    die();
}
 
$_SESSION['oauth_token'] = $getToken['oauth_token'];
$_SESSION['oauth_token_secret'] = $getToken['oauth_token_secret'];
 
$url = $initial->url(
    'oauth/authorize', [
        'oauth_token' => $getToken['oauth_token']
    ]
);
 
header('Location: '. $url);
?>
