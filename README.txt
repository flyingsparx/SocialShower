INTRO:
Three PHP files to retrieve social interactions from social media accounts for 
displaying in a website.


USAGE:
Simply include the PHP file in your script and call the appropriate method.

For recent tweets:
include "twitter.php";
getTweets();

For recent Last.fm scrobbles:
include "lastfm.php";
getTracks();

For recent Google+ photo uploads:
include "google_plus.php";
getPhotos();


CUSTOMISATION:
The calls to the respective APIs can be altered to get the data you want. For example,
the request to get recent scrobbles could be altered to get most played artists. 
Another example is that the request to get recent photos could be changed to get the
photos from a specific album.

The format in which the items are displayed can be changed within the respective files.