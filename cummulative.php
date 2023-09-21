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


?>   

<div class="page-header">
<h2>Cummulative World Cup Stats</h2>
</div>


<div class="row row-content">
	<div class="col-xs-12">

<?php	
  function curPageName() {
    return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
 }

function MakeLink($txt,$srt) {  
  global $sort;
  global $order;
  $ord=$order;
  if ($sort==$srt) {
	if ($ord==0) $ord=1;
 		else $ord=0;
  }
  return '<a href="'.curPageName().'?sort='.$srt.'&order='.$ord.'">'.$txt.'</a>';
}

  function ShowTable($title, $id, $sql) {
    $result=runQuery($sql);

  	echo '<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" href="#'.$id.'">'.$title.'</a></h4></div>';
	echo '<div id="'.$id.'" class="panel-collapse collapse in" ><div class="panel-body" style="height:300px;overflow:scroll;">';
    echo '<table class="table table-striped table-condensed"><tr><th width="5%">#</th><th width="25%">'.MakeLink('Player',0).'</th><th width="10%">'.MakeLink('G',2).'</th><th width="10%">'.MakeLink('W',3).'</th><th  width="10%">'.MakeLink('D',4).'</th><th  width="10%">'.MakeLink('L',5).'</th><th  width="10%">'.MakeLink('GS',6).'</th><th  width="10%">'.MakeLink('GC',7).'</th><th width="10%">'.MakeLink('GD',8).'</th><th  width="10%">'.MakeLink('Pts',1).'</th></tr>';
  		
    $i=0;
    while ($row=mysqli_fetch_array($result,MYSQLI_BOTH)) {
      $i++;
      echo '<tr><td>'.$i.'</td><td><a href="players.php?player='.$row[0].'">'.$row['player'].'</a></td><td>'.$row[2].'</td><td>'.$row[3].'</td><td>'.$row[4].'</td><td>'.$row[5].'</td><td>'.$row[6].'</td><td>'.$row[7].'</td><td>'.$row[8].'</td><td>'.$row[1].'</td></tr>';        
    }  
    echo '</table></div>';  
	echo "</div></div>";  
  }

  $sort=1;
  $order=0;
  if (isset($_GET['sort'])) $sort=$_GET['sort'];
  if (isset($_GET['order'])) $order=$_GET['order'];
  if (($sort<0) || ($sort>8)) $sort=1;
  if (($order!=0) && ($order!=1)) $order=0;

dbOpen(); 
  $cups=array ("World Cup I","World Cup II","World Cup III","World Cup IV","World Cup V","World Cup VI","World Cup VII","World Cup VIII","World Cup IX","World Cup X", "World Cup XI");
$orders=array("desc","asc");  $criteria=array("player","points","games","wins","draws","losses","goalsfor","goalsagainst","goaldifference");	

    $sql="select player, sum(pts) points, sum(g) games, sum(w) wins, sum(d) draws, sum(l) losses, sum(gs) goalsfor, sum(gc) goalsagainst, sum(gs)-sum(gc) goaldifference  from `tables` where tournament like 'World Cup %' group by player order by ".$criteria[$sort]." ".$orders[$order];
  ShowTable("Totals (sorted by ".$criteria[$sort].")","totals",$sql);

    $sql="select player, truncate( (sum(pts) / sum(g)),3 ) points, sum(g) games, sum(w) wins, sum(d) draws, sum(l) losses, truncate( (sum(gs) / sum(g)),2) goalsfor, truncate((sum(gc) / sum(g)),2)  goalsagainst, truncate(( (sum(gs)-sum(gc)) / sum(g)),2)  goaldifference   from `tables` where tournament like 'World Cup %' group by player order by ".$criteria[$sort]." ".$orders[$order];
  
  ShowTable("Averages (sorted by ".$criteria[$sort].")","averages",$sql);

        
  dbClose();
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