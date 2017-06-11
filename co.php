<?php
require __DIR__ . '/vendor/autoload.php';

use DarrynTen\GoogleNaturalLanguagePhp\GoogleNaturalLanguage;

// Config options
$config = [
  'projectId' => 'personal-cloud-155618'  // At the very least
];

// Make a processor
$language = new GoogleNaturalLanguage($config);



$settings = array(
    'oauth_access_token' => "813610044533182464-8hc9ZYWnzwVMK8cK5YXVxbXFs4PnRuC",
    'oauth_access_token_secret' => "RSEb7E6OCCwISTLreogn1QT2Bp7m5DGBIxy0D1SRARCox",
    'consumer_key' => "8RjhJbeoiBGofYDydXIq5bnBf",
    'consumer_secret' => "WBC4HHtH5nyhF0XpR6aN7GyYvdHR46wOZVKDlFzvhGCCV471sd"
);


$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
$getfield = '?screen_name=PRTZLnet&count=7';
$requestMethod = 'GET';

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
$json = file_get_contents('cache.json');
$json_output = json_decode($json);
//>implying I know what im doing 
foreach ($json_output as $result) {
    $text = $result->text;
$language->setText($text);
$annotation = $language->getSentiment();
$sentiment = $annotation->sentiment();
if($sentiment['score'] > 0) {
    $r++;
}
}
if ($r>0){
    echo'your twitter is mostly posative!';
}
else{
    echo'your twitter is mostly negative!';
}
 
?>
