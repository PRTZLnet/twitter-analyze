<?php
 
require __DIR__ . '/vendor/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;
session_start();
$config = require_once 'cfg.php';




$initial = new TwitterOAuth($config['consumer_key'], $config['consumer_secret']);
$getToken = $initial->oauth(
    'oauth/request_token', [
        'oauth_callback' => $config['url_callback']
    ]
);
 
if($initial->getLastHttpCode() != 200) {
    //!!!420 is a limit problem
    throw new \Exception('There was a problem performing this request');
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
