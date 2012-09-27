<?

/* 
* Include this file and print the Last.fm data by calling getTracks()
*/

/*
* Format the time of the track played into a relative form (e.g. 4 minutes ago)
* Some of the function is adapted from Creare Web Design
* http://www.creare-webdesign.co.uk/blog/videos/display-latest-tweet-php.html
*/
function formatTime($track_time){
	$nowtime = time();
	$timeago = ($nowtime-$track_time);
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
   return $timemessage;
}

/*
* Invoke this function to get the recent tracks for a given user. 
* Edit this function if you wish to change how the tracks are formatted
*/    
function getTracks(){
	$user = "";
	
	$tracks=  simplexml_load_file("http://ws.audioscrobbler.com/1.0/user/".$user."/recenttracks.rss");
	$songs = $tracks->channel;	
	
	for ($i = 0; $i < count($tracks->item); $i++){
		$track_name = $tracks->item[$i]->title;
		$track_url = $tracks->item[$i]->link;
		$track_time = formatTime(strtotime($tracks->item[$i]->pubDate));
		
		echo '<li><a href="'.track_url.'">'.track_name.'</a><br />'.$track_time.'</li>';
	}
}
?>