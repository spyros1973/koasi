<?php
  
include("classes/feedcreator.class.php"); 
include "support/db.inc";

$rss = new UniversalFeedCreator(); 
$rss->useCached(); 
$rss->title = "KO-gathering"; 
$rss->description = "KOA tournament information"; 
$rss->link = "http://www.ko-gathering.com/koasi"; 
$rss->syndicationURL = "http://www.ko-gathering.com/koasi/".$_SERVER['PHP_SELF'];

// $image = new FeedImage(); 
// $image->title = "dailyphp.net logo"; 
// $image->url = "http://www.dailyphp.net/images/logo.gif"; 
// $image->link = "http://www.dailyphp.net"; 
// $image->description = "Feed provided by dailyphp.net. Click to visit."; 
// $rss->image = $image; 


// get your news items from somewhere, e.g. your database: 
dbOpen();
$date=date("Y-m-d");
$sql="select name, winner, country, link, `date`, place, organiser from calendar where ";
$sql=$sql."`date`>='".$date."' order by `date` desc";
 
$res = mysql_query($sql); 
while ($data = mysql_fetch_object($res)) { 
    $item = new FeedItem(); 
    $item->title = $data->name; 
    $item->link = $data->link; 
    $item->description = "KO2 tournament organized in ".$data->place." (".$data->country.") on ".date("j/m/Y", strtotime($data->date))." by ".$data->organiser; 
    $item->date = $data->date; 
    $item->source = "http://www.ko-gathering.com/koasi"; 
    $item->author = "KOASI";      
    $rss->addItem($item); 
} 

$res = mysql_query("select title,description,link,newsdate from news where newsdate>='".$date."' order by newsdate desc"); 
while ($data = mysql_fetch_object($res)) { 
    $item = new FeedItem(); 
    $item->title = $data->title; 
    $item->link = $data->link; 
    $item->description = $data->description; 
    $item->date = $data->newsdate; 
    $item->source = "http://www.ko-gathering.com/koasi"; 
    $item->author = "KOASI";      
    $rss->addItem($item); 
} 


dbClose();
$rss->saveFeed("RSS1.0", "feed.xml"); 
?>
