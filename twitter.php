<?

/*
* Some of the code is adapted from Creare Web Design
* http://www.creare-webdesign.co.uk/blog/videos/display-latest-tweet-php.html
*/

/*
* Function detects links, hashtags and mentions and formats them as hyperlinks
*/
function changeLink($string, $tags=false, $nofollow, $target){
	if(!$tags){
		$string = strip_tags($string);
	} else {
		if($target){
			$string = str_replace("<a", "<a target=\"_blank\"", $string);
		}
		if($nofollow){
			$string = str_replace("<a", "<a rel=\"nofollow\"", $string);
		}
	}
	return $string;
}

/*
* Parses the XML returned by Twitter into more machine-readable forms.
* Also formats the date time format into a relative time (e.g. 5 minutes ago)
*/
function getLatestTweets($xml, $tags=false, $nofollow=true, $target=true,$widget=false){
	global $twitterid;
	$xmlDoc = new DOMDocument();
	$xmlDoc->load($xml);
     
	$x = $xmlDoc->getElementsByTagName("entry");
     
	$tweets = array();
	foreach($x as $item){
		$tweet = array();
		if($item->childNodes->length){
        	foreach($item->childNodes as $i){
				$tweet[$i->nodeName] = $i->nodeValue;
			}
		}
		$tweets[] = $tweet;
	}
     
	$return = array();
      
	foreach($tweets as $tweettag){
		$tweetdate = $tweettag["published"];
		$tweet = $tweettag["content"];
		$timedate = explode("T",$tweetdate);
		$date = $timedate[0];
		$time = substr($timedate[1],0, -1);
		$tweettime = (strtotime($date." ".$time))+3600; // This is the value of the time difference - UK + 1 hours (3600 seconds)
		$nowtime = time();
		$timeago = ($nowtime-$tweettime);
		$thehours = floor($timeago/3600);
		$theminutes = floor($timeago/60);
		$thedays = floor($timeago/86400);
		if($theminutes < 60){
			if($theminutes < 1){
				$timemessage =  "Less than 1 minute ago";
			} else if($theminutes == 1) {
				$timemessage = $theminutes." minute ago";
			} else {
				$timemessage = $theminutes." minutes ago";
			}
		} else if($theminutes > 60 && $thedays < 1){
			if($thehours == 1){
				$timemessage = $thehours." hour ago";
			} else {
				$timemessage = $thehours." hours ago";
			}
		} else {
			if($thedays == 1){
				$timemessage = $thedays." day ago";
			} else {
				$timemessage = $thedays." days ago";
			}
		}
		$return['tweets'][] = changeLink($tweet, $tags, $nofollow, $target);
		$return['times'][] = $timemessage;
	}
	return $return;         
}

/*
* Invoke this function to get the tweets for a given user. Change the parameters
* accordingly.
* Edit this function if you wish to change how the tweets are formatted
*/     
function getTweets(){
	$twitterid = "";
	$numberoftweets = "10";
	$tags = true;
	$nofollow = true;
	$target = true;
	$tweetxml = "http://search.twitter.com/search.atom?q=from:" . $twitterid . "&rpp=" . $numberoftweets . "";
	$tweets = getLatestTweets($tweetxml, $tags, $nofollow, $target, $widget);

	for ($i = 0; $i < count($tweets['tweets']); $i++){
		$tweet_text = $tweets['tweets'][$i];
		$tweet_time = $tweets['times'][$i]
		echo '<li>'.tweet_text.'<br />'.tweet_time.'</li>';
	}
 }         
?>