<?php
 
require __DIR__ . '/vendor/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;
 
session_start();
 
$config = require_once 'cfg.php';

$twitteroauth = new TwitterOAuth($config['consumer_key'], $config['consumer_secret']);
 
$request_token = $twitteroauth->oauth(
    'oauth/request_token', [
        'oauth_callback' => $config['url_callback']
    ]
);
 
if($twitteroauth->getLastHttpCode() != 200) {
    throw new \Exception('There was a problem performing this request');
}
 
$_SESSION['oauth_token'] = $request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
 
$url = $twitteroauth->url(
    'oauth/authorize', [
        'oauth_token' => $request_token['oauth_token']
    ]
);
 
header('Location: '. $url);
?>
