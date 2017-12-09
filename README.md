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

### Special Thanks / Libs used
* [Darrynten](https://github.com/darrynten/google-natural-language-php) - For making a decent PHP wrapper (+ extra features) for Google's Natural Language API
* [Anton Bagaiev](https://code.tutsplus.com/tutorials/how-to-authenticate-users-with-twitter-oauth-20--cms-25713) - OATUH w/ twitter
* [Abraham](https://abrah.am) - twitterOatuh library
* [j7mbo](https://github.com/J7mbo/twitter-api-php) - PHP wrapper for the twitter API
* My past self - used some of the old code from the old version of this with added optimization + features just for my ENC2135 class

