<!DOCTYPE html
 PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>
		<title>KOASI!</title><link rel="alternate" type="application/rss+xml" title="Get RSS 2.0 Feed" href="rss.php" />
		<link rel="stylesheet" href="style.css" type="text/css" />
		<link rel="stylesheet" href="print.css" type="text/css" media="print" />

		<meta http-equiv="Content-type" content="text/html; charset=ISO-8859-1" />
	</head>

	<body>
		
		<div id="container">
			
<?php include 'headnav.inc'; ?>
			
			<div id="content">
				<h2>Welcome</h2>
				<p>Welcome to the Kick Off Association Statistics Institute! The institute is open to all online researchers, who want to dive in a wealth of statistical information on all the Kick Off tournaments played by members of the Kick Off Association.
</p>			
<h2>The latest update (January 27th, 2013)... in Alkis words</h2>
<p>
<center><img src="images/news.jpg"></center>
</p>
<h2>Jargon busters</h2>
<p>
<ul>
<li><b>Kick Off</b>: A computer game, coded by Dino Dini, with graphics by Steve Screech, which came out in 1989 by Anco software. The Amiga and Atari ST versions have reached legendary status. A very quick game, giving the player freedom and demanding skill and precision to control it.</li>
<li><b>Kick Off Association (KOA)</b>: An international community, created by Jan Tijssen and Gunther Wening in 1994, which is devoted to KO and derivative games. KOA members organize KO tournament all over Europe, their pinnacle being the KO World Cup, organized every year in October or November. This year's World Cup was held held in Dusseldorf, Germany.
</ul>
</p>

      </div>
			<div id="news">
				<h2>World Cup Winners</h2>

				<p>
				2012: <a href="players.php?player=Dagh N">Dagh Nielsen</a><br/>
				2011: <a href="players.php?player=Gianni T">Gianni Torchio</a><br/>
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

        <h2><a href="http://ko-gathering.com/forum/viewtopic.php?f=5&t=14759">Kick Off 2 CV</a></h2>
        <p style="font-size: 10px"><img src="images/ko2cv.jpg"/><br/>
        KO2 Competition Version. Steve's masterpiece.
        </p>				
				<h2>Latest Tournament</h2>
				<p style="font-size: 10px">
				<?php 
        include 'support/db.inc';
        dbOpen();
        $sql="select name, winner, link, date, place from calendar where winner<>'' order by date desc limit 0,1";
        $result=mysql_query($sql);
        if ($row=mysql_fetch_array($result, MYSQL_ASSOC)) {
          extract ($row);
          echo '<a href="players.php?player='.$winner.'">'.$winner.'</a> was the winner of '.$name.', which was held on the '.date("jS F Y", strtotime($date)).' in '.$place.'<br/>';
          echo 'Click <a href="'.$link.'">here</a> to find out more';          
        }
        dbClose();
        ?>
        </p>

			</div>

<?php
include 'footer.inc';
?>			
		</div>
		
	</body>

</html>
