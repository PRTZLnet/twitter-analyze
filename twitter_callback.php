<?php
require __DIR__ . '/vendor/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;
use DarrynTen\GoogleNaturalLanguagePhp\GoogleNaturalLanguage;
session_start();
$configT = require_once 'cfg.php';
//maybe not the best way, but an easier way
$_SESSION['consumer_key'] = $configT['consumer_key'];
$_SESSION['consumer_secret'] = $configT['consumer_secret'];

//this is a step taken from mindmapengineer's guide
$oauth_verifier = filter_input(INPUT_GET, 'oauth_verifier');
if (empty($oauth_verifier) || empty($_SESSION['oauth_token']) || empty($_SESSION['oauth_token_secret'])) {
    header('Location: ' . $configT['url_login']);
}

//note for future quinn: do not remove this line, this uses the application token to request the oauth toekn
$connectionomatic = new TwitterOAuth(
    $config['consumer_key'],
    $config['consumer_secret'],
    $_SESSION['oauth_token'],
    $_SESSION['oauth_token_secret']
);
$token = $connectionomatic->oauth(
    'oauth/access_token', [
        'oauth_verifier' => $oauth_verifier
    ]
);

$workerBee = new TwitterOAuth(
    $_SESSION['consumer_key'],
    $_SESSION['consumer_secret'],
    $token['oauth_token'],
    $token['oauth_token_secret']
);

$verifyAuth = $workerBee->get('account/verify_credentials');
if(isset($verifyAuth->error)) {
    header('Location: ' . $configT['url_login']);

}

$screenNameget = $workerBee->get('account/settings');
$usr = $screenNameget->screen_name;

$config = [
  'projectId' => 'personal-cloud-155618'  
];
$language = new GoogleNaturalLanguage($config);




$settings = array(
    'oauth_access_token' => $token['oauth_token'],
    'oauth_access_token_secret' => $token['oauth_token_secret'],
    'consumer_key' =>  $_SESSION['consumer_key'],
    'consumer_secret' => $_SESSION['consumer_secret'],
);

$twitter = new TwitterAPIExchange($settings);


$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
$getfield = '?screen_name=' . $usr;
$requestMethod = 'GET';
$reqResult2 = $twitter->setGetfield($getfield)
    ->buildOauth($url, $requestMethod)
    ->performRequest();

  
  
  
   $url = 'https://api.twitter.com/1.1/search/tweets.json';
$requestMethod = 'GET';
$getfield = '?q=#FSU';
$reqResult =  $twitter->setGetfield($getfield)
                              ->buildOauth($url, $requestMethod)
                              ->performRequest();

$r = 0;
$g = 0;
$c = 0;

$json_output = json_decode($reqResult);
$array = array(

              );
              
foreach($json_output->statuses as $result) {
$text = $result->text;
$language->setText($text);
$annotation = $language->getSentiment();
$sentiment = $annotation->sentiment();
if($sentiment['score'] != null) {
$tempvar1 = $sentiment['score'];
$array[$g]['tweet'] = $text;
$array[$g]['s'] = $tempvar1;
    $r+=$sentiment['score'];
    echo $r . " ";
    $g++;
    echo $g. " ";
}
}
$r = ($r / $g);
$_SESSION['overall'] = $r;
$_SESSION['arr'] = $array;


$json_output = json_decode($reqResult2);
$array2 = array(

              );
              
foreach($json_output as $result) {
$text = $result->text;
$language->setText($text);
$annotation = $language->getSentiment();
$sentiment = $annotation->sentiment();
if($sentiment['score'] != null) {
$tempvar1 = $sentiment['score'];
$array2[$g]['tweet'] = $text;
$array2[$g]['s'] = $tempvar1;
    $r+=$sentiment['score'];
    echo $r . " ";
    $g++;
    echo $g. " ";
}
}
$_SESSION['arr2'] = $array2;


header('Location: index.php');
?>