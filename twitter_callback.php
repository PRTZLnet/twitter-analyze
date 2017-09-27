<?php
require __DIR__ . '/vendor/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;
use DarrynTen\GoogleNaturalLanguagePhp\GoogleNaturalLanguage;
session_start();
$configT = require_once 'cfg.php';
//maybe not the best way, but an easier way
$_SESSION['consumer_key'] = $configT['consumer_key'];
$_SESSION['consumer_secret'] = $configT['consumer_secret'];

//this is a step taken from mindmapengineer's guide; really only does something if twitter is fucking up
$oauth_verifier = filter_input(INPUT_GET, 'oauth_verifier');
if (empty($oauth_verifier) ||
    empty($_SESSION['oauth_token']) ||
    empty($_SESSION['oauth_token_secret'])
) {
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


$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
$getfield = '?screen_name=' . $usr;
$requestMethod = 'GET';


$settings = array(
    'oauth_access_token' => $token['oauth_token'],
    'oauth_access_token_secret' => $token['oauth_token_secret'],
    'consumer_key' =>  $_SESSION['consumer_key'],
    'consumer_secret' => $_SESSION['consumer_secret'],
);

$twitter = new TwitterAPIExchange($settings);

$reqResult = $twitter->setGetfield($getfield)
    ->buildOauth($url, $requestMethod)
    ->performRequest();
$r = 0;
$g = 0;
$c = 0;

$json_output = json_decode($reqResult);
$array = array(
                  array( 'tweet' => 'null','s' => null ),
                  array( 'tweet' => 'null','s' => null ),
                  array( 'tweet' => 'null','s' => null ),
                  array( 'tweet' => 'null','s' => null ),
                  array( 'tweet' => 'null','s' => null ),
                  array( 'tweet' => 'null','s' => null ),
                  array( 'tweet' => 'null','s' => null ),

              );
              
foreach($json_output as $result) {
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
echo 'final =' . $r;
print_r($array);
$_SESSION['arr'] = $array;
header('Location: index.php');
?>
