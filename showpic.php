<!DOCTYPE html
 PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>
		<title>KOASI!</title><link rel="alternate" type="application/rss+xml" title="Get RSS 2.0 Feed" href="rss.php" />
		<link rel="stylesheet" href="style.css" type="text/css" />
		<link rel="stylesheet" href="print.css" type="text/css" media="print" />
		<meta http-equiv="Content-type" content="text/html; charset=ISO-8859-1" />
		
		<script type="text/javascript">
		function ESCclose(evt) {
      if (evt.keyCode == 27)
      window.close();
    }
		</script>
		<style>


#footp { 
	border: 1px solid #3c7796;
	text-indent: 0.5em;
	font-size: 10px;	
	color: #ffffff;
	margin: 0;
	padding: 0.5em;
	background: #3c7796;
}		
		</style>
	</head>

	<body onkeypress="ESCclose(event)">
		
		<div id="content" style="width: 100%; margin:0; padding:0;text-align: center">

<?php

$values=$_GET['values'];
$labels=$_GET['labels'];
$maxval=$_GET['maxval'];
$graphType=$_GET['graphtype'];
$mode=$_GET['mode'];
$height=$_GET['height'];
$width=$_GET['width'];
$title1=$_GET['title1'];
$title2=$_GET['title2'];
$maxval=$_GET['maxval'];

 $src='values='.$values.'&labels='.$labels.'&maxval='.$maxval.'&graphtype='.$graphType.'&mode='.$mode.'&width='.$width.'&height='.$height;

echo '<h2>'.$title1.'</h2><p>';

echo '<img src="chart.php?'.$src.'"><br/>';

echo '<h3>'.$title2.'</h3></p>';


?>
		</div>
	</body>
</html>
