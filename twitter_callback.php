<?php
require __DIR__ . '/vendor/autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;
use DarrynTen\GoogleNaturalLanguagePhp\GoogleNaturalLanguage;

session_start();
$config = require_once 'cfg.php';
// get and filter oauth verifier
$oauth_verifier = filter_input(INPUT_GET, 'oauth_verifier');
// check tokens
if (empty($oauth_verifier) ||
    empty($_SESSION['oauth_token']) ||
    empty($_SESSION['oauth_token_secret'])
) {
    // something's missing, go and login again
    header('Location: ' . $config['url_login']);
}
// connect with application token
$connection = new TwitterOAuth(
    $config['consumer_key'],
    $config['consumer_secret'],
    $_SESSION['oauth_token'],
    $_SESSION['oauth_token_secret']
);
// request user token
$token = $connection->oauth(
    'oauth/access_token', [
        'oauth_verifier' => $oauth_verifier
    ]
);
// connect with user token
$twitter = new TwitterOAuth(
    $config['consumer_key'],
    $config['consumer_secret'],
    $token['oauth_token'],
    $token['oauth_token_secret']
);
$user = $twitter->get('account/verify_credentials');
// if something's wrong, go and log in again
if(isset($user->error)) {
    header('Location: ' . $config['url_login']);
}
// fuck pdo tbh
$test = $twitter->get('account/settings');
$usr = $test->screen_name;

// Config options
$config = [
  'projectId' => 'personal-cloud-155618'  // At the very least
];

// Make a processor
$language = new GoogleNaturalLanguage($config);

$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
$getfield = '?screen_name=' . $usr . '&count=7';
$requestMethod = 'GET';


$settings = array(
    'oauth_access_token' => $token['oauth_token'],
    'oauth_access_token_secret' => $token['oauth_token_secret'],
    'consumer_key' =>  'ZptcrxHFhDZsphYeGezhD4kJh',
    'consumer_secret' => 'SUtmtVldq4FsgVOztz3imMnM8r59Oe29LceGi38o3xXEmTy0CN',
);

$twitter = new TwitterAPIExchange($settings);
$varto = $twitter->setGetfield($getfield)
    ->buildOauth($url, $requestMethod)
    ->performRequest();

function indent($varto) {

    $result      = '';
    $pos         = 0;
    $strLen      = strlen($varto);
    $indentStr   = '  ';
    $newLine     = "\n";
    $prevChar    = '';
    $outOfQuotes = true;

    for ($i=0; $i<=$strLen; $i++) {
        $char = substr($varto, $i, 1);
        if ($char == '"' && $prevChar != '\\') {
            $outOfQuotes = !$outOfQuotes;
        }
				else if(($char == '}' || $char == ']') && $outOfQuotes) {
            $result .= $newLine;
            $pos --;
            for ($j=0; $j<$pos; $j++) {
                $result .= $indentStr;
            }
        }
        $result .= $char;
        if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
            $result .= $newLine;
            if ($char == '{' || $char == '[') {
                $pos ++;
            }

            for ($j = 0; $j < $pos; $j++) {
                $result .= $indentStr;
            }
        }

        $prevChar = $char;
    }

    return $result;
}

file_put_contents('cache.json', indent($varto));
?>

<?php
$r = 0;
$g = 0;
$json = file_get_contents('cache.json');
$json_output = json_decode($json);
//>implying I know what im doing 
foreach ($json_output as $result) {
    
    $text = $result->text;
$language->setText($text);
$annotation = $language->getSentiment();
$sentiment = $annotation->sentiment();
if($sentiment['score'] != null) {
    $r+=$sentiment['score'];
    echo $r . " ";
    $g++;
    echo $g. " ";
}
}
$r = ($r / $g);
echo 'final =' . $r;
if ($r==1){
    echo'Your twitter is exceptionally posative! woah bruh';
}
else if ($r > .6){
    echo 'your twitter is very very posative!';
    echo $r;
}
else if ($r > .3){
    echo 'your twitter mostly posative!';
}
else if ($r > 0){
    echo 'your twitter is sorta posative!';
}
else if ($r == 0){
    echo 'your twitter is sorta totally neutral!';
}
else if ($r== -1){
    echo'Your twitter is exceptionally negative! woah bruh';
}
else if ($r > -.6){
    echo 'your twitter is very very negative!';
}
else if ($r > -.3){
    echo 'your twitter mostly negative!';
}
else if ($r > -0){
    echo 'your twitter is sorta negative!';
}


 
?>
