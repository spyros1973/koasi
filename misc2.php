 <?php 
include 'support/db.inc'; 
?>
<!DOCTYPE html
 PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>
		<title>KOASI!</title><link rel="alternate" type="application/rss+xml" title="Get RSS 2.0 Feed" href="rss.php" />
		<link rel="stylesheet" href="style.css" type="text/css" />
		<link rel="stylesheet" href="print.css" type="text/css" media="print" />
		<meta http-equiv="Content-type" content="text/html; charset=ISO-8859-1" />
		
	<script>
  function PopStats( type) {  
    window.open ("topstats.php?stattype="+type, "TopStats","menubar=1,resizable=0,width=400,height=470");
  }
  </script>	
	</head>

	<body>
		
		<div id="container">
			
<?php 
include 'headnav.inc'; 
?>	
			
			<div id="content">
	
	
        
<?php

function Name2Href($str) {
  $s1=substr($str,0,strpos($str,"(")-1);
  $s2=substr($str,strpos($str,"("));
  return '<a href="players.php?player='.$s1.'">'.$s1.'</a> '.$s2;  
}


dbOpen();

echo '<h2>General stats</h2><p>';
echo "<table>";

$games=getFirstRec("select count(*) from scores");
$goals=getFirstRec("select sum(a+b) from scores");

$gamesPreN = getFirstRec("select count(*) from scores, `tournament players` where scores.tournament=`tournament players`.tournament and `tournament players`.equalteams=0");
$gamesPostN = getFirstRec("select count(*) from scores, `tournament players` where scores.tournament=`tournament players`.tournament and `tournament players`.equalteams<>0");
$aGoalsPreN = getFirstRec("select sum(a) from scores, `tournament players` where scores.tournament=`tournament players`.tournament and `tournament players`.equalteams=0");
$aGoalsPostN = getFirstRec("select sum(a) from scores, `tournament players` where scores.tournament=`tournament players`.tournament and `tournament players`.equalteams<>0");
$bGoalsPreN = getFirstRec("select sum(b) from scores, `tournament players` where scores.tournament=`tournament players`.tournament and `tournament players`.equalteams=0");
$bGoalsPostN = getFirstRec("select sum(b) from scores, `tournament players` where scores.tournament=`tournament players`.tournament and `tournament players`.equalteams<>0");



echo "<tr><td width='60%'><b>Total games</b></td><td>".$games."</td></tr>";
echo "<tr><td><b>Total goals</b></td><td>".$goals."</td></tr>";
echo "<tr><td><b>Average goals per game</b></td><td>".number_format(($goals/$games),2)."</td></tr>";
if ($gamesPreN>0)  echo "<tr><td><b>Average score before Team N</b></td><td>".number_format($aGoalsPreN/$gamesPreN,2)." - ".number_format($bGoalsPreN/$gamesPreN,2)."</td></tr>"; 
if ($gamesPostN>0)  echo "<tr><td><b>Average score after Team N</b></td><td>".number_format($aGoalsPostN/$gamesPostN,2)." - ".number_format($bGoalsPostN/$gamesPostN,2)."</td></tr>"; 


echo "</table></p><br/>";

echo '<h2>Individual records</h2><p><table>';
$result=runQuery("select * from added_misc");
while  ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {	
//while (1==0) {
  echo '<tr><td width="60%"><b><a href="#" onclick="PopStats(0);return false;">Most games played</a></b></td><td>'.Name2Href($row["s00"]).'</td></tr>';
  echo "<tr><td><b><a href='#' onclick='PopStats(1);'>Best attack avg</a></b></td><td>".Name2Href($row['s01'])."</td></tr>";
  echo "<tr><td><b><a href='#' onclick='PopStats(2);'>Best defense avg</a></b></td><td>".Name2Href($row['s02'])."</td></tr>";
  echo "<tr><td><b><a href='#' onclick='PopStats(3);'>Worst attack avg</a></b></td><td>".Name2Href($row['s03'])."</td></tr>";
  echo "<tr><td><b><a href='#' onclick='PopStats(4);'>Worst defense avg</a></b></td><td>".Name2Href($row['s04'])."</td></tr>";
  echo "<tr><td><b><a href='#' onclick='PopStats(5);'>Most goals scored</a></b></td><td>".Name2Href($row['s13'])."</td></tr>";
  echo "<tr><td><b><a href='#' onclick='PopStats(6);'>Most goals conceded</a></b></td><td>".Name2Href($row['s14'])."</td></tr>";
  echo "<tr><td><b><a href='#' onclick='PopStats(7);'>Most wins</a></b></td><td>".Name2Href($row['s15'])."</td></tr>";
  echo "<tr><td><b><a href='#' onclick='PopStats(8);'>Most draws</a></b></td><td>".Name2Href($row['s16'])."</td></tr>";
  echo "<tr><td><b><a href='#' onclick='PopStats(9);'>Most losses</a></b></td><td>".Name2Href($row['s17'])."</td></tr>";
  echo "<tr><td><b><a href='#' onclick='PopStats(10);'>Biggest win %</a></b></td><td>".Name2Href($row['s18'])."</td></tr>";
  echo "<tr><td><b><a href='#' onclick='PopStats(11);'>Biggest draw %</a></b></td><td>".Name2Href($row['s19'])."</td></tr>";
  echo "<tr><td><b><a href='#' onclick='PopStats(12);'>Biggest loss %</a></b></td><td>".Name2Href($row['s20'])."</td></tr>";
  echo "<tr><td><b><a href='#' onclick='PopStats(13);'>Most tournaments won</a></b></td><td>".Name2Href($row['s27'])."</td></tr>";
  echo "<tr><td><b><a href='#' onclick='PopStats(14);'>Most clean sheets</a></b></td><td>".Name2Href($row['s28'])."</td></tr>";
  echo "<tr><td><b><a href='#' onclick='PopStats(15);'>Most clean sheets %</a></b></td><td>".Name2Href($row['s29'])."</td></tr>";
  echo "<tr><td><b><a href='#' onclick='PopStats(16);'>Most games with no goals scored</a></b></td><td>".Name2Href($row['s30'])."</td></tr>";
  echo "<tr><td><b><a href='#' onclick='PopStats(17);'>Most games with no goals scored %</a></b></td><td>".Name2Href($row['s31'])."</td></tr>";
  echo "<tr><td><b><a href='#' onclick='PopStats(18);'>Played against most players</a></b></td><td>".Name2Href($row['s35'])."</td></tr>";
  echo "<tr><td><b><a href='#' onclick='PopStats(19);'>Played against most countries</a></b></td><td>".Name2Href($row['s36'])."</td></tr>";
  echo "<tr><td><b><a href='#' onclick='PopStats(20);'>Easiest opponent for more</a></b></td><td>".Name2Href($row['s37'])."</td></tr>";
  echo "<tr><td><b><a href='#' onclick='PopStats(21);'>Hardest opponent for more</a></b></td><td>".Name2Href($row['s38'])."</td></tr>";
  echo "<tr><td><b><a href='#' onclick='PopStats(22);'>Most games scored double figures</a></b></td><td>".Name2Href($row['s43'])."</td></tr>";
  echo "<tr><td><b><a href='#' onclick='PopStats(23);'>Most games conceded double figures</a></b></td><td>".Name2Href($row['s44'])."</td></tr>";
  echo "<tr><td><b><a href='#' onclick='PopStats(24);'>Most games per month in the last year</a></b></td><td>".Name2Href($row['s45'])."</td></tr>";
  
  $sql = 'select name, format((hardestfor-easiestfor)/opponentno,2) from added_players where opponentno>=10 order by (hardestfor-easiestfor)/opponentno desc LIMIT 0, 1';
  
  $res=runQuery($sql);
  $rec=mysqli_fetch_row($res);
  $danger=Name2Href($rec[0].' ('.$rec[1].' pts)');   
  echo "<tr><td><b><a href='#' onclick='PopStats(25);' title='For each player, we subtract the players for which he is the easiest opponent from those for which he is the hardest and then divide by the total number of opponents. A value close to 1 signifies that a player is the hardest opponent for almost all his opponents - quite an achievement!'>Most dangerous</a></b></td><td>".$danger."</td></tr>";


  $sql = 'select name, format((hardestfor-easiestfor)/opponentno,2) from added_players where opponentno>=10 order by (hardestfor-easiestfor)/opponentno asc LIMIT 0, 1';
  
  $res=runQuery($sql);
  $rec=mysqli_fetch_row($res);
  $danger=Name2Href($rec[0].' ('.$rec[1].' pts)');   
  echo "<tr><td><b><a href='#' onclick='PopStats(26);' title='For each player, we subtract the players for which he is the easiest opponent from those for which he is the hardest and then divide by the total number of opponents. A value close to -1 signifies that a player is the easiest opponent for almost all his opponents - quite an achievement!'>Least dangerous</a></b></td><td>".$danger."</td></tr>";

}

echo "</table></p><br/>";

  echo '<h2>Biggest wins</h2><p>';
  echo '<table><tr><th>Team A</th><th>Team B</th><th>A</th><th>B</th><th>Tournament</th></tr>';
  $result=runQuery(strtolower("SELECT  `TEAM A`, `TEAM B`, A, B, A-B as expr, TOURNAMENT FROM scores where abs(a-b)>13 ORDER BY Abs(a-b) DESC limit 0,10"));
  while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
    echo '<tr><td><a href="players.php?player='.$row['team a'].'">'.$row['team a'].'</a></td>';
    echo '<td><a href="players.php?player='.$row['team b'].'">'.$row['team b'].'</a></td>';
    echo '<td>'.$row['a'].'</td>';
    echo '<td>'.$row['b'].'</td>';
    //echo '<td>'.$row['expr'].'</td>';
    echo '<td>'.$row['tournament'].'</td></tr>';
  }

echo '</p></table>';

  echo '<h2>Most goals scored</h2><p>';
  echo '<table><tr><th>Team A</th><th>Team B</th><th>A</th><th>B</th><th>Tournament</th></tr>';
  $result=runQuery(strtolower("SELECT  `TEAM A`, `TEAM B`, A, B, A+B as expr, TOURNAMENT FROM scores where a+b>14 ORDER BY a+b DESC limit 0,10"));
  while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
    echo '<tr><td><a href="players.php?player='.$row['team a'].'">'.$row['team a'].'</a></td>';
    echo '<td><a href="players.php?player='.$row['team b'].'">'.$row['team b'].'</a></td>';

    echo '<td>'.$row['a'].'</td>';
    echo '<td>'.$row['b'].'</td>';
    //echo '<td>'.$row['expr'].'</td>';
    echo '<td>'.$row['tournament'].'</td></tr>';
  }

echo '</p></table>';




?>
</p>
</div>        
			


			<div id="news">
        <h2><a href="http://www.ko-gathering.com/phpbb2/viewforum.php?f=23">Throw-in</a></h2>
        <p style="font-size: 10px"><img src="images/throw.jpg"/><br/>
        Throw-in, a modern game inspired by Kick Off 2.
        </p>				

<?php

$sql="select avg(a+b) gol, DATE_FORMAT(`tournament players`.date , '%Y') hron from scores, `tournament players` where `tournament players`.tournament=scores.tournament  group by hron";

       echo '<h2>Goals per game by year</h2><br/>';
       $gol=array();
       $lbl=array();
       $min=0;
       $max=0;       
       $result = runQuery($sql);
       while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
            $gol[]=$row['gol'];
            $lbl[]=$row['hron'];
        }          
        
        $val=implode(",",$gol);
        $val1=implode(",",$lbl);
        $title1="KOA history stats";
        $title2="Goals per game by year";
        $src='values='.$val.'&maxval=10&labels='.$val1.'&graphtype=0&mode=1&title1='.$title1.'&title2='.$title2;
        echo '<a href="showpic.php?'.$src.'&width=640&height=480" >';
        //echo '<img border="0" src="chart.php?'.$src.'&width=160&height=120" title="Goals per game by year"/>';
        echo '</a><br/>&nbsp;<br/>';

dbClose();
?>


			</div>

<?php
include 'footer.inc';
?>			
		</div>
		
	</body>

</html>
