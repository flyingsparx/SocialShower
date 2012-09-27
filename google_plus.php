<?
/*
* Show recent photos from your Google+ account on your website.
*/

/* 
* Function retrieves photo data and then formats them into a list.
*/
function getPhotos(){
	$userID = "";
	$feed = simplexml_load_file("https://picasaweb.google.com/data/feed/api/user/".$userID."?kind=photo&max-results=8");
	for ($i = 0; $i < 8; $i++){
		$element = $feed->entry[$i]->content;	
		
		$var = $element->attributes();
		$url = $var->src;
	
		echo '<li><img src="'.$url.'"/></li>';
	}
}
?>