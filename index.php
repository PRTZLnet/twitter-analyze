<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title></title>
<?php
session_start();
$url = 'twitter_login.php';
if($_SESSION['arr'] == null){
  header('Location: '. $url);
}
?>
</head>
<body>
<head>
<link href="css/bg.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
</head>
<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

   <nav class="navbar navbar-default main-navbar">
    <span class="col-xs-10 col-md-3 menu-item menu-header">twitter.prtzl.net</span>

  <div class="menu-item hidden-xs hidden-sm col-md-6 md-menu-items">
	  <a href="index.php"><div class="col-xs-4 menu-text">Home</div></a>
	  <a href="twitter_login.php"><div class="col-xs-4 menu-text">Reload account</div></a>

  </div>
  </nav>




<div class="container">
 <br>
 <input type="text" id="search" placeholder="Type to search">
<table id="table">
  <div class="row">
    <div class="col-xs-12">
      <p><b>This takes RTs = Endorsements; meaning RT sentiment IS factored in.</b></p>
      <p><b>Also, google's AI is not so good at parsing slang or sarcasm, take scores with a grain of salt.</b></p>
      <p>generally, all caps also fucks with this shit</p>
      <table class="table table-bordered table-hover dt-responsive" id='table'>

        <thead>
          <tr>
            <th>tweet</th>
            <th>rating</th>
          </tr>
        </thead>
        <tbody>
<?php

$count = 0;
$avg = 0;
$put = null;
session_start();
    foreach($_SESSION['arr'] as $tweet){
      $avg+=$tweet['s'];
      $put = $tweet['s'] > 0.0 ? "positive" : "negative";
        echo'<tr>'; 
        echo'<td>'. $tweet['tweet']."</td>";
        echo'<td>('. $tweet['s'].') ' . $put . '</td>';
        echo'<tr>';
        $count++;
    }
$avg = $avg/$count;

?>
<!--
for the future 
<form method="post">
    <input type="submit" name="test" id="test" value="RUN" /><br/>
</form>

<?php
/*
$TweetMe = $avg > 0.0 ? "My twitter is positive! Check yours at http://twitter.prtzl.net!" : "My twitter is negative! Check yours at http://twitter.prtzl.net!";
require "vendor/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;
$config = require_once 'cfg.php';
$ck = $config['consumer_key'];
$cs = $config['consumer_secret'];
$ok = $_SESSION['oauth_token'];
$ots = $_SESSION['oauth_token_secret'];

function testfun()
{
   echo "rin";

}

if(array_key_exists('test',$_POST)){
   testfun();
}
*/
?>
-->
        </tbody>
        <tfoot>
          <tr> </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>
<script type="text/javascript" src="js/srch.js"></script>
<footer>

	</footer>
</body>
</html>
