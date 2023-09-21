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

<body onkeypress="ESCclose(event)">
    <div class="container">

<?php
include 'support/db.inc'; 
include 'stats.inc'; 
if (isset($_GET['stattype'])) {
    $stattype=$_GET['stattype'];
	echo '<div class="page-header"><h2>'.$stats[$stattype].'</h2></div>';
?>   



<div class="row row-content">
	<div class="col-xs-12">

<?php
  
    dbOpen();
    
    switch ($stattype) {
      case 0: //games
        echo '<table class="table table-striped table-condensed"><tr><th>Player</th><th>Games</th></tr>';
        $sql = 'select sum(games) gam, player from '
        . ' ('
        . ' (select count(*) as games, `Team A` as player from scores group by player )'
        . ' union '
        . ' (select count(*) as games, `Team B` as player from scores group by player) '
        . ' ) spyros '
        . ' group by player'
        . ' order by gam desc limit 0,20';
        $result=runQuery($sql);
        while ($row=mysqli_fetch_array($result,MYSQLI_BOTH)) {
          echo '<tr><td>'.$row[1].'</td><td>'.$row[0].'</td></tr>';
        }
        echo '</table>';
        break;
      case 1: //best attack avg
        echo '<table class="table table-striped table-condensed"><tr><th>Player</th><th>Goals per game</th></tr>';
		$sql="select gol, matches, player from (select avg(goals) gol, sum(games) matches, player from ( (SELECT avg( A ) AS goals, count( A ) AS games, `Team A` AS player FROM scores GROUP BY player) union all(SELECT avg( B ) AS goals, count( B ) AS games, `Team B` AS player FROM scores GROUP BY player) ) j group by player ) spyros where matches >=30 order by gol desc limit 0,20";
        $result=runQuery($sql);
        while ($row=mysqli_fetch_array($result,MYSQLI_BOTH)) {
          echo '<tr><td>'.$row[2].'</td><td>'.number_format($row[0],2).'</td></tr>';
        }
        echo '<tfoot><tr><td>Game limit: 30</td></tr></tfoot>';
		echo '</table>';
        break;      
      case 2: //best defense avg
        echo '<table class="table table-striped table-condensed"><tr><th>Player</th><th>Goals per game</th></tr>';
        $sql = 'select gol, matches, player from
(select avg(goals) gol, sum(games) matches, player from 
(
(SELECT avg( A ) AS goals, count( A ) AS games, `Team B` AS player
FROM scores
GROUP BY player)
union all
(SELECT avg( B ) AS goals, count( B ) AS games, `Team A` AS player
FROM scores
GROUP BY player) ) j group by player ) spyros 

where matches >=30 
order by gol asc limit 0,20';

        $result=runQuery($sql);		
        while ($row=mysqli_fetch_array($result,MYSQLI_BOTH)) {
          echo '<tr><td>'.$row[2].'</td><td>'.number_format($row[0],2).'</td></tr>';
        }
        echo '<tfoot><tr><td>Game limit: 30</td></tr></tfoot>';
		echo '</table>';        
        break;      
      case 3: //worst attack avg
        echo '<table class="table table-striped table-condensed"><tr><th>Player</th><th>Goals per game</th></tr>';
$sql="select gol, matches, player from (select avg(goals) gol, sum(games) matches, player from ( (SELECT avg( A ) AS goals, count( A ) AS games, `Team A` AS player FROM scores GROUP BY player) union all (SELECT avg( B ) AS goals, count( B ) AS games, `Team B` AS player FROM scores GROUP BY player) ) j group by player ) spyros where matches >=30 order by gol asc limit 0,20";
        $result=runQuery($sql);
        while ($row=mysqli_fetch_array($result,MYSQLI_BOTH)) {
          echo '<tr><td>'.$row[2].'</td><td>'.number_format($row[0],2).'</td></tr>';
        }
        echo '<tfoot><tr><td>Game limit: 30</td></tr></tfoot>';
		echo '</table>';
        
        break;                     
      case 4: //worst defense avg
        echo '<table class="table table-striped table-condensed"><tr><th>Player</th><th>Goals per game</th></tr>';
        $sql = 'select gol, matches, player from
(select avg(goals) gol, sum(games) matches, player from 
(
(SELECT avg( A ) AS goals, count( A ) AS games, `Team B` AS player
FROM scores
GROUP BY player)
union all
(SELECT avg( B ) AS goals, count( B ) AS games, `Team A` AS player
FROM scores
GROUP BY player) ) j group by player ) spyros 

where matches >=30 
order by gol desc limit 0,20';

        $result=runQuery($sql);
        while ($row=mysqli_fetch_array($result,MYSQLI_BOTH)) {
          echo '<tr><td>'.$row[2].'</td><td>'.number_format($row[0],2).'</td></tr>';
        }
		echo '<tfoot><tr><td>Game limit: 30</td></tr></tfoot>';
        echo '</table>';
        
        break;
      case 5: //most goals scored
        echo '<table class="table table-striped table-condensed"><tr><th>Player</th><th>Goals</th></tr>';
        $sql = 'select sum(goals) gol, player from '
        . ' ('
        . ' (select sum(A) as goals, `Team A` as player from scores group by player )'
        . ' union all'
        . ' (select sum(B) as goals, `Team B` as player from scores group by player) '
        . ' ) spyros '
        . ' group by player'
        . ' order by gol desc'
        . ' limit 0,20';
        $result=runQuery($sql);
        while ($row=mysqli_fetch_array($result,MYSQLI_BOTH)) {
          echo '<tr><td>'.$row[1].'</td><td>'.$row[0].'</td></tr>';
        }
        echo '</table>';
        break;
      case 6: //most goals conceded
        echo '<table class="table table-striped table-condensed"><tr><th>Player</th><th>Goals</th></tr>';
        $sql = 'select sum(goals) gol, player from '
        . ' ('
        . ' (select sum(A) as goals, `Team B` as player from scores group by player )'
        . ' union all'
        . ' (select sum(B) as goals, `Team A` as player from scores group by player) '
        . ' ) spyros '
        . ' group by player'
        . ' order by gol desc'
        . ' limit 0,20';
        $result=runQuery($sql);
        while ($row=mysqli_fetch_array($result,MYSQLI_BOTH)) {
          echo '<tr><td>'.$row[1].'</td><td>'.$row[0].'</td></tr>';
        }
        echo '</table>';
        break;
      case 7: //most wins
        echo '<table class="table table-striped table-condensed"><tr><th>Player</th><th>Wins</th></tr>';
        $sql = 'select sum(wins) matches , player from '
        . ' ('
        . ' (select count(*) as wins, `Team A` as player from scores where A>B group by player )'
        . ' union all'
        . ' (select count(*) as wins, `Team B` as player from scores where B>A group by player) '
        . ' ) spyros '
        . ' group by player'
        . ' order by matches desc'
        . ' limit 0,20';
        $result=runQuery($sql);
        while ($row=mysqli_fetch_array($result,MYSQLI_BOTH)) {
          echo '<tr><td>'.$row[1].'</td><td>'.$row[0].'</td></tr>';
        }
        echo '</table>';
        break;
      case 8: //most draws
        echo '<table class="table table-striped table-condensed"><tr><th>Player</th><th>Draws</th></tr>';
        $sql = 'select sum(draws) matches , player from '
        . ' ('
        . ' (select count(*) as draws, `Team A` as player from scores where A=B group by player )'
        . ' union all'
        . ' (select count(*) as draws, `Team B` as player from scores where B=A group by player) '
        . ' ) spyros '
        . ' group by player'
        . ' order by matches desc'
        . ' limit 0,20';
        $result=runQuery($sql);
        while ($row=mysqli_fetch_array($result,MYSQLI_BOTH)) {
          echo '<tr><td>'.$row[1].'</td><td>'.$row[0].'</td></tr>';
        }
        echo '</table>';
		
        break;
      case 9: //most losses
        echo '<table class="table table-striped table-condensed"><tr><th>Player</th><th>Losses</th></tr>';
        $sql = 'select sum(losses) matches , player from '
        . ' ('
        . ' (select count(*) as losses, `Team A` as player from scores where A<B group by player )'
        . ' union '
        . ' (select count(*) as losses, `Team B` as player from scores where B<A group by player) '
        . ' ) spyros '
        . ' group by player'
        . ' order by matches desc'
        . ' limit 0,20';
        $result=runQuery($sql);
        while ($row=mysqli_fetch_array($result,MYSQLI_BOTH)) {
          echo '<tr><td>'.$row[1].'</td><td>'.$row[0].'</td></tr>';
        }
        echo '</table>';
        break;
      case 10: //biggest win %
        echo '<table class="table table-striped table-condensed"><tr><th>Player</th><th>Win %</th></tr>';
      $sql = 'select * from (select (100 * won / (won+Drawn+lost)) as pct , name from added_players where won+drawn+lost>=30 ) spyros order by pct desc limit 0,20';


        $result=runQuery($sql);
        while ($row=mysqli_fetch_array($result,MYSQLI_BOTH)) {
          echo '<tr><td>'.$row[1].'</td><td>'.number_format($row[0],2).'%</td></tr>';
        }
        echo '<tfoot><tr><td>Game limit: 30</td></tr></tfoot>';
		echo '</table>';
        
        break;      
      case 11: //biggest draw %
        echo '<table class="table table-striped table-condensed"><tr><th>Player</th><th>Draw %</th></tr>';
      $sql = 'select * from (select (100 * drawn / (won+Drawn+lost)) as pct , name from added_players where won+drawn+lost>=30 ) spyros order by pct desc limit 0,20';


        $result=runQuery($sql);
        while ($row=mysqli_fetch_array($result,MYSQLI_BOTH)) {
          echo '<tr><td>'.$row[1].'</td><td>'.number_format($row[0],2).'%</td></tr>';
        }
        echo '<tfoot><tr><td>Game limit: 30</td></tr></tfoot>';
		echo '</table>';
        
        break;      
      case 12: //biggest loss %
        echo '<table class="table table-striped table-condensed"><tr><th>Player</th><th>Loss %</th></tr>';
      $sql = 'select * from (select (100 * lost / (won+Drawn+lost)) as pct , name from added_players where won+drawn+lost>=30 ) spyros order by pct desc limit 0,20';

        $result=runQuery($sql);
        while ($row=mysqli_fetch_array($result,MYSQLI_BOTH)) {
          echo '<tr><td>'.$row[1].'</td><td>'.number_format($row[0],2).'%</td></tr>';
        }
        echo '<tfoot><tr><td>Game limit: 30</td></tr></tfoot>';
		echo '</table>';
        
        break;      
      case 13: //tournaments won
        echo '<table class="table table-striped table-condensed"><tr><th>Player</th><th>Tournaments</th></tr>';
      $sql = 'select count(*) wins, player from `tables` where p=1 group by player order by wins desc limit 0,20';
        $result=runQuery($sql);
        while ($row=mysqli_fetch_array($result,MYSQLI_BOTH)) {
          echo '<tr><td>'.$row[1].'</td><td>'.$row[0].'</td></tr>';
        }
        echo '</table>';
        
        break;
             
      case 14: //clean sheets 
        echo '<table class="table table-striped table-condensed"><tr><th>Player</th><th>Games</th></tr>';
      $sql = 'select clean, name from added_players order by clean desc LIMIT 0, 20 ';
        $result=runQuery($sql);
        while ($row=mysqli_fetch_array($result,MYSQLI_BOTH)) {
          echo '<tr><td>'.$row[1].'</td><td>'.$row[0].'</td></tr>';
        }
        echo '</table>';
        
        break;
       
      case 15: //clean sheets %
        echo '<table class="table table-striped table-condensed"><tr><th>Player</th><th>Game %</th></tr>';
        $sql = 'SELECT '
        . ' (100 * clean / (won+drawn+lost)) pct, name'
        . ' FROM added_players'
        . ' where won+drawn+lost >= 30 '
        . ' order by pct desc'
        . ' limit 0,20'
        . ' ';
        $result=runQuery($sql);
        while ($row=mysqli_fetch_array($result,MYSQLI_BOTH)) {
          echo '<tr><td>'.$row[1].'</td><td>'.number_format($row[0],2).'%</td></tr>';
        }
        echo '<tfoot><tr><td>Game limit: 30</td></tr></tfoot>';
		echo '</table>';
        
        break;
      case 16: //no goals scored
        echo '<table class="table table-striped table-condensed"><tr><th>Player</th><th>Games</th></tr>';
      $sql = 'select nogoal, name from added_players order by nogoal desc LIMIT 0, 20 ';
        $result=runQuery($sql);
        while ($row=mysqli_fetch_array($result,MYSQLI_BOTH)) {
          echo '<tr><td>'.$row[1].'</td><td>'.$row[0].'</td></tr>';
        }
        echo '</table>';
        
        break;
       
      case 17: //nogoals scored %
        echo '<table class="table table-striped table-condensed"><tr><th>Player</th><th>Game %</th></tr>';
        $sql = 'SELECT '
        . ' (100 * nogoal / (won+drawn+lost)) pct, name'
        . ' FROM added_players'
        . ' where won+drawn+lost >= 30 '
        . ' order by pct desc'
        . ' limit 0,20'
        . ' ';
        $result=runQuery($sql);
        while ($row=mysqli_fetch_array($result,MYSQLI_BOTH)) {
          echo '<tr><td>'.$row[1].'</td><td>'.number_format($row[0],2).'%</td></tr>';
        }
        echo '</table>';
        
        break;
      case 18: //different opponents
        echo '<table class="table table-striped table-condensed"><tr><th>Player</th><th>Opponents</th></tr>';
      $sql = 'select opponentno, name from added_players order by opponentno desc LIMIT 0, 20 ';
        $result=runQuery($sql);
        while ($row=mysqli_fetch_array($result,MYSQLI_BOTH)) {
          echo '<tr><td>'.$row[1].'</td><td>'.$row[0].'</td></tr>';
        }
        echo '</table>';
        
        break;
      case 19: //different countries
        echo '<table class="table table-striped table-condensed"><tr><th>Player</th><th>Countries</th></tr>';
      $sql = 'select opponentcountryno, name from added_players order by opponentcountryno desc LIMIT 0, 20 ';
        $result=runQuery($sql);
        while ($row=mysqli_fetch_array($result,MYSQLI_BOTH)) {
          echo '<tr><td>'.$row[1].'</td><td>'.$row[0].'</td></tr>';
        }
        echo '</table>';
        
        break;
      case 20: //easiest for
        echo '<table class="table table-striped table-condensed"><tr><th>Player</th><th>Player no</th></tr>';
      $sql = 'select easiestfor, name from added_players order by easiestfor desc LIMIT 0, 20 ';
        $result=runQuery($sql);
        while ($row=mysqli_fetch_array($result,MYSQLI_BOTH)) {
          echo '<tr><td>'.$row[1].'</td><td>'.$row[0].'</td></tr>';
        }
        echo '</table>';
        
        break;
      case 21: //hardest for
        echo '<table class="table table-striped table-condensed"><tr><th>Player</th><th>Player no</th></tr>';
      $sql = 'select hardestfor, name from added_players order by hardestfor desc LIMIT 0, 20 ';
        $result=runQuery($sql);
        while ($row=mysqli_fetch_array($result,MYSQLI_BOTH)) {
          echo '<tr><td>'.$row[1].'</td><td>'.$row[0].'</td></tr>';
        }
        echo '</table>';
        
        break;
      case 22: //double scored
        echo '<table class="table table-striped table-condensed"><tr><th>Player</th><th>Games</th></tr>';
      $sql = 'select doublescored, name from added_players order by doublescored desc LIMIT 0, 20 ';
        $result=runQuery($sql);
        while ($row=mysqli_fetch_array($result,MYSQLI_BOTH)) {
          echo '<tr><td>'.$row[1].'</td><td>'.$row[0].'</td></tr>';
        }
        echo '</table>';
        
        break;
      case 23: //double conceded
        echo '<table class="table table-striped table-condensed"><tr><th>Player</th><th>Games</th></tr>';
      $sql = 'select doubleconceded, name from added_players order by doubleconceded desc LIMIT 0, 20 ';
        $result=runQuery($sql);
        while ($row=mysqli_fetch_array($result,MYSQLI_BOTH)) {
          echo '<tr><td>'.$row[1].'</td><td>'.$row[0].'</td></tr>';
        }
        echo '</table>';
        
        break;
      case 24: //activity rating
        echo '<table class="table table-striped table-condensed"><tr><th>Player</th><th>Rating</th></tr>';
      $sql = 'select activityrating, name from added_players order by activityrating desc LIMIT 0, 20 ';
        $result=runQuery($sql);
        while ($row=mysqli_fetch_array($result,MYSQLI_BOTH)) {
          echo '<tr><td>'.$row[1].'</td><td>'.number_format($row[0],2).'</td></tr>';
        }
        echo '</table>';
        
        break;
      case 25: //most danger
        echo '<table class="table table-striped table-condensed"><tr><th>Player</th><th>Rating</th></tr>';
      $sql = 'select ((hardestfor-easiestfor)/opponentno) danger, name from added_players where opponentno>=10 order by danger desc LIMIT 0, 20 ';
        $result=runQuery($sql);
        while ($row=mysqli_fetch_array($result,MYSQLI_BOTH)) {
          echo '<tr><td>'.$row[1].'</td><td>'.number_format($row[0],2).'</td></tr>';
        }
        echo '</table>';
        echo '<p id="footp">Opponent limit: 10</p>';
        break;

      case 26: //least danger
        echo '<table class="table table-striped table-condensed"><tr><th>Player</th><th>Rating</th></tr>';
      $sql = 'select ((hardestfor-easiestfor)/opponentno) danger, name from added_players where opponentno>=10 order by danger asc LIMIT 0, 20 ';
        $result=runQuery($sql);
        while ($row=mysqli_fetch_array($result,MYSQLI_BOTH)) {
          echo '<tr><td>'.$row[1].'</td><td>'.number_format($row[0],2).'</td></tr>';
        }
        echo '</table>';
        echo '<p id="footp">Opponent limit: 10</p>';
        break;


}

dbClose();
}

?>
</div>
	</div>
	
	</div>
<?php
//include 'footer.inc';
?>
	<div id="dimOverlay" style="display:none">
        <img src='images/camberwait.gif' alt='Loading indicator' /><span class='sr-only'>Loading...</span>
    </div>
		
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>		
	<script type="text/javascript">
		function ESCclose(evt) {
			if (evt.keyCode == 27)
			window.close(); 
		}
	</script>
	</body>
</html>