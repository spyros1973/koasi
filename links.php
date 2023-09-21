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
	<h3>Kick Off related</h3>
	<p>
<ul>
<li><b><a href="http://www.ko-gathering.com/">Kick Off Gathering</a></b>: The website of the Kick Off Association. Head there for loads of (slightly unorganized :) ) info on Kick Off, derivative games and tournament participation details. The forum is the obvious meeting place, but don't forget to take a look at the WiKi.</li>
<li><b><a href="http://www.ko-gathering.com/phpbb2/viewforum.php?f=23">Throw-in</a></b>: A modern game heavily inspired by Kick Off. Throw-in is actively developed by 3 times Kick Off Word Champion, Gianluca Troiano and despite being still in beta state, it is already a very playble game.
<li><b><a href="http://ko-gathering.com/forum/viewtopic.php?f=12&t=14608">The Stats Analyser</a></b>: The predecessor to KOASI is essentially the offline version of it. It runs on Windows and it provides more or less all the information contained in KOASI. 
<li><b><a href="http://www.alkis.org">Alkis.org</a></b>: The homepage of huge KO2 lover and legendary KOA member Alkis Polyrakis contains a very detailed section on KOA World Cups, full of statistics and analysis.</li>
<li><b><a href="http://homepage.ntlworld.com/mbishop/FixturesV3.exe">BBob's tournament scheduler</a></b>: A hit program among KOA users, Bounty Bob's tournament scheduler allows you to easily setup a tournament and keep track of the results. It even calculates the ranking points won/lost. Despite the lack of documentation, it's a snap to use.</li>
</ul>
</p>

<h2>Misc links</h2>
<p>
<ul>
<li><b><a href="http://www.paraschis.gr">paraschis.gr</a></b>: The homepage of Spyros Paraschis, creator of this website and <s>current</s> ex KOA World Champion. It contains freeware game reviews and original software made by... me. It also contains an interesting cycling blog in Greek.</li>

</div>

<div class="col-xs-4 col-sm-3">
<h3>World cup winners</h3>
		2010: <a href="players.php?player=Dagh N">Dagh Nielsen</a><br/>
		2009: <a href="players.php?player=Gianni T">Gianni Torchio</a><br/>
        2008: <a href="players.php?player=Gianni T">Gianni Torchio</a><br/>
        2007: <a href="players.php?player=Spyros P">Spyros Paraschis</a><br/>
        2006: <a href="players.php?player=Spyros P">Spyros Paraschis</a><br/>
        2005: <a href="players.php?player=Gianluca T">Gianluca Troiano</a><br/>
        2004: <a href="players.php?player=Gianluca T">Gianluca Troiano</a><br/>
        2003: <a href="players.php?player=Gianluca T">Gianluca Troiano</a><br/>
        2002: <a href="players.php?player=Rikki F">Rikki Fullarton</a><br/>
        2001: <a href="players.php?player=Alkis P">Alkis Polyrakis</a><br/>
        </p>		

<h3>The legend</a></h3>
<p ><img class="img-responsive" src="images/ko2shot.jpg"/>
<div class="caption">Kick Off 2</div>
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

