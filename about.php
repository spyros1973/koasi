<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="Spyros Paraschis">    
	
    <title>Kick Off Association Statistics Institute</title>
    
    <!-- Bootstrap -->
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="bower_components/bootstrap/dist/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="css/mystyle.css" rel="stylesheet">
	
	<link href="https://fonts.googleapis.com/css?family=Press+Start+2P" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body >        
<?php
include "modal.inc";
?>
    <div class="container">

<?php
include 'support/db.inc'; 
$page="about";
include 'header.inc';

?>   
<div class="row row-content">
	<div class="col-xs-8 col-sm-7 col-sm-offset-1">
		<h3>A little history</h3>
		<p>Kick Off is a computer football game that came out in 1989. Created by Dino Dini and sold by Anco, Kick Off reached legendary status in its Amiga and Atari ST incarnations and is considered by many as the best football game even created, giving you freedom to play, requiring skills and providing hectic entertainment.

		<p>The Kick Off Association, KOA for short, is a community devoted to Kick Off and to a lesser extent to similar or derivative games, like Final Whistle, Player Manager, Kick Off 2002, online Kick off, Throw In and Word of Football (the last two being modern games inspired by KO). The community has been created by  Gunther Wening and Jan Tijssen in 2001. Members of the KOA organise local and international KO Tournaments all over Europe. The pinnacle of these is the KO World Cup, organized every year around November.
		<p>
		Among the KOA members are some crazy number-loving people. From the early days all tournament results were recorded and a player ranking system had been developed. Following progress, the results were first recorded in a simple (or not so simple...) MS Excel worksheet, which was maintained by Glenn Loite and Robert Swift, then Alkis Polyrakis created an MS Access application to extract statistical information from the game results and then me, Spyros Paraschis, created the <a href="http://ko-gathering.com/forum/viewtopic.php?f=12&t=14608">KOA Stats Analyser</a>, a Windows application to show even more stats, whether you wanted to know them or not :).
		<p>The KOASI is the next step in this evolution ladder - an online application which allows everyone to see many interesting, or not so interesting, statistics on the KOA games, without the bounds of using Windows and having to install an application, as was the case with the Stats Analyser.</p>       
		</p>

	</div>

<div class="col-xs-4 col-sm-3">
<h3>Credits</h3>
<p>
<b>Spyros Paraschis</b>: Application  coding and website design.<br/>
<b>Alkis Polyrakis</b>: KOA tournament database maintenance.<br/>
<b>Mark Williams</b>: Web hosting.<br/> 
</p>

<h3>The predecessor</h3>        
<p >
<img class="img-responsive" src="images/statsanal.jpg"/>
<div class="caption">
<a href="http://ko-gathering.com/forum/viewtopic.php?f=12&t=14608">Stats Analyser</a>
</div>
</p>
<h3>The legend</a></h3>
<p><img class="img-responsive" src="images/ko2shot.jpg"/>
Kick Off 2
</p>				

</div>
</div>
</div>
<?php
include 'footer.inc';
?>
	<div id="dimOverlay" style="display:none">
        <img src='images/camberwait.gif' alt='Loading indicator' /><span class='sr-only'>Loading...</span>
    </div>
		
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>		

	</body>

</html>