# update 12/4

 - re-did most of the back end
 - laid the framework for hash-tag searches


# twitter.prtzl.net

Using google natural language API, and the twitter API it allows users to display positive/negative ratings for their twitter profiles

The only data received by the site is:

  - API keys for individual accounts obtained by 0auth2.0
  - JSON response from twitter API cached into locally stored file
  - JSON response from Google's Natural Language API
  
# How is the data analyzed?
Old system is gone and will be updated.

But here's how the data is given to me.
via Google's Natural Language API
* [Docs](https://cloud.google.com/natural-language/docs/basics)

| Sentiment        | Sample Values           
| ------------- |:-------------: 
| Clearly Positive   | "score": 0.8, "magnitude": 3.0
| Clearly Negative     | "score": -0.6, "magnitude": 4.0      
| Neutral | 	"score": 0.1, "magnitude": 0.0   
| Mixed | 	"score": 0.0, "magnitude": 4.0 

So, generally .2>0>-.2 is not conclusive.

### Special Thanks
* [Darrynten](https://github.com/darrynten/google-natural-language-php) - For making a decent PHP wrapper (+ extra features) for Google's Natural Language API

### Installation for all the hobbyists and myself when I forget

twitter-analyze requires :
- PHP 5.5+ to run
- Composer
- Twitter Dev keys
- Google API SDK credentials 
- Google Compute Engine/App Engine instance (you can run it at home or on AWS/Azure/VPS/any other Apache/PHP capable service, but you can go look at google's documentation yourself to get that working)
- Preferably Ubuntu 16.04 LTS because that's what I test on. If you are familiar enough with Linux to be reading this far down, you can figure it out
- You to set your own consumer keys, secrets and url_login and url_callback in cfg.php and the one few lines toward the bottom of callback
- Set callback URL and website on apps.twitter.com

To get the thing working install a LAMPP stack, composer, gcloud (already partially installed if on GCE/AE, you will need to run `$ gcloud config list core/` to get a prompt to set up an embedded account/default credentials) and PHP 5.5+:

```sh
$ sudo apt-get update
$ sudo wget "https://www.apachefriends.org/xampp-files/7.1.4/xampp-linux-x64-7.1.4-0-installer.run"
$ sudo chmod +x xampp-linux-x64-7.1.4-0-installer.run 
$ sudo ./xampp-linux-x64-7.1.4-0-installer.run 
$ curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer
$ sudo apt-get install google-cloud-sdk
$ gcloud init
```
 nice.

### todo:
- Actually write unit tests and integrate with travis ci
- Move from the forced-to-tweet model to pretty charts and the option to post
- Storing data for next login (e.g. your twitter got 5% more hostile)
- Store old tweets and their sentiments per account so that I don't have to keep pulling them when the user logs in. As in, it only gets the sentiment of a new tweet. Twitter's REST API supports getting 'newest' `since_id`. So that'll have to be stored with the rest of the data(Probably in a fucking huge JSON or NoSQL database)
- update to 280 chars. Because twitter had to fuck with what was working. Time to analyze 280 character lil pump lyrics and the hottest takes around.

### possible bugs:
- curl may not install right so, that's something i'll have to narrow down in a better tutorial
- sometimes the index table flat out REFUSES to display more than 3 or 4 tweets. Still generates the columns for them. Probably a twitter response error rather than an issue with my code ¯\_(ツ)_/¯
