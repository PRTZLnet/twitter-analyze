
# update 9/20

Shit is getting pushed this week but here's a pre-update for the readme

 - Updated composer.json to be my own not a copy of someone else's
 - fixed security holes
 - removed a significant part of code that was dev-only (the JSON sorting script)

# twitter.prtzl.net

Using google natural language API, and the twitter API it allows users to display positive/negative ratings for their twitter profiles

The only data received by the site is:

  - API keys for individual accounts obtained by 0auth2.0
  - JSON response from twitter API cached into locally stored file
  - JSON response from Google's Natural Language API
  
# How is the data analyzed?
Old system is gone and will be updated.

but here's how the data is given to me.
via Google's Natural Language API
* [Docs](https://cloud.google.com/natural-language/docs/basics)

| Sentiment        | Sample Values           
| ------------- |:-------------: 
| Clearly Positive   | "score": 0.8, "magnitude": 3.0
| Clearly Negative     | "score": -0.6, "magnitude": 4.0      
| Neutral | 	"score": 0.1, "magnitude": 0.0   
| Mixed | 	"score": 0.0, "magnitude": 4.0 

### Special Thanks
* [Darrynten](https://github.com/darrynten/google-natural-language-php) - For making a PHP wrapper for Google's Natural Language API

### Installation for all the hobbyists and myself when I forget

twitter-analyze requires :
- PHP 7.0+ to run
- Composer
- Twitter Dev keys
- Google API SDK credentials 
- Google Compute Engine instance (you can run it at home or on AWS/Azure/VPS/any other Apache/PHP capable service, but you can go look at google's documentation yourself to get that working)
- Ubuntu 16.04 LTS
- You to set your own consumer keys, secrets and url_login and url_callback in cfg.php
- Set callback URL and website on apps.twitter.com

To get the thing working install a LAMPP stack, composer, gcloud (already partially installed if on GCE) and PHP 7.0+:

```sh
$ sudo apt-get update
$ sudo wget "https://www.apachefriends.org/xampp-files/7.1.4/xampp-linux-x64-7.1.4-0-installer.run"
$ sudo chmod +x xampp-linux-x64-7.1.4-0-installer.run 
$ sudo ./xampp-linux-x64-7.1.4-0-installer.run 
$ curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer
$ sudo apt-get install google-cloud-sdk
$ gcloud init
```

Then 

```sh
$ sudo /opt/lampp/lampp stop
$ cd opt/lampp
```




### may or may not be required
Extract this repository into your vm, doesnt matter how, but place it into the htdocs folder and re-name twitter_login.php to index.php and start the LAMPP again

```sh
$ cd htdocs
$ sudo mv twitter_login.php index.php
$ php /usr/local/bin/composer install
$ php /usr/local/bin/composer update
$ sudo /opt/lampp/lampp start
```


### Permissions on Linux:
 - should actually be fixed. so that's nice.

### todo:
- Actually write unit tests and integrate with travis ci
- Not cache json output from twitter to save memory and monies
- Google Cloud API integration *without* the SDK 

### possible bugs:
- curl may not install right so, that's something i'll have to narrow down in a better tutorial
