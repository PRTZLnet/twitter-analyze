<?php
require __DIR__ . '/vendor/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;
use DarrynTen\GoogleNaturalLanguagePhp\GoogleNaturalLanguage;
session_start();
$config = require_once 'cfg.php';
$oauth_verifier = filter_input(INPUT_GET, 'oauth_verifier');
if (empty($oauth_verifier) ||
    empty($_SESSION['oauth_token']) ||
    empty($_SESSION['oauth_token_secret'])
) {
    header('Location: ' . $config['url_login']);
}
$connection = new TwitterOAuth(
    $config['consumer_key'],
    $config['consumer_secret'],
    $_SESSION['oauth_token'],
    $_SESSION['oauth_token_secret']
);
$token = $connection->oauth(
    'oauth/access_token', [
        'oauth_verifier' => $oauth_verifier
    ]
);
$d = new TwitterOAuth(
    $config['consumer_key'],
    $config['consumer_secret'],
    $token['oauth_token'],
    $token['oauth_token_secret']
);
$user = $d->get('account/verify_credentials');
if(isset($user->error)) {
    header('Location: ' . $config['url_login']);
}
// fuck pdo tbh
$test = $d->get('account/settings');
$usr = $test->screen_name;
$config = [
  'projectId' => 'personal-cloud-155618'  // At the very least
];
$language = new GoogleNaturalLanguage($config);
$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
$getfield = '?screen_name=' . $usr . '&include_rts=false';
$requestMethod = 'GET';

$settings = array(
    'oauth_access_token' => $token['oauth_token'],
    'oauth_access_token_secret' => $token['oauth_token_secret'],
    'consumer_key' =>  'x',
    'consumer_secret' => 'x',
);

$twitter = new TwitterAPIExchange($settings);
$varto = $twitter->setGetfield($getfield)
    ->buildOauth($url, $requestMethod)
    ->performRequest();
$r = 0;
$g = 0;
$c = 0;
$json_output = json_decode($varto);

//because I'm a cheap shitbag Google's API limits me to ~1000 characters per request before charging me money. 7*140 = 980 

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
//this^^^ is required. It would be kinda nice if PHP let you do $json_output->text as $result. Maybe it can and im bad at formatting.
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
$url1 = "index.php";
header('Location: '. $url1);

?>
