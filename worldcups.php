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
$page="worldcups";
include 'header.inc';

?>   
<div class="row row-content">
	<div class="col-xs-8 col-sm-7 col-sm-offset-1">


<?php
function ShowGames($tournament, $phase) {
	$where="tournament='".$tournament."'";
	if ($phase!='') $where=$where." and phase ='".$phase."'";
	//if ($player!='') $where=$where." and (`team a`='".$player."' or `team b`='".$player."') ";
	$sql = "select `team a`, `team b`, a, b, extra from scores where ".$where." order by id";
	$result=runQuery($sql);
	//if ($phase!="") echo '<br/><u>'.$phase.'</u><br/>';
	echo '<table class="table table-striped table-condensed"><tr><th width="35%">Team A</th><th width="35%">Team B</th><th width="10%">A</th><th width="10%">B</th><th width="10%">et</th></tr>';
	while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		echo '<tr><td>'.$row['team a'].'</td><td>'.$row['team b'].'</td><td>'.$row['a'].'</td><td>'.$row['b'].'</td><td>';
		if ($row['extra']!='') echo $row['extra'];
		echo '</td></tr>';
	}
	echo '</table>';
}
function ShowTable($cup, $phase) {			
	if ($phase=='') {
		$sql="select p, player, g, w, d, l, gs, gc, pts from `tables` where tournament='".$cup."'";
	} else {
		$group = substr($phase,strpos($phase,"Group"));
		if (strtolower(trim($cup)) == "world cup 2015") $cup="World Cup XV ";
		$t=strtolower(str_replace("  "," ",$cup." tables"));		
		if (strtoupper($group)=="FUN CUP - GROUP 33-40") $group = "Group 33-40";
		$sql="select p, player, g, w, d, l, gs, gc, pts from `".$t."` where tournament='".$group."'";
	}	
	$result=runQuery($sql) ;
	$i=0;
	while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
		if ($i==0) {
			echo '<table class="table table-striped table-condensed"><tr><th>#</th><th>Player</th><th>G</th><th>W</th><th>D</th><th>L</th><th>GS</th><th>GC</th><th>Pts</th></tr>';
			$i=1;
		}
		echo '<tr><td>'.$row['p'].'</td><td>';
		echo '<a href="players.php?player='.$row['player'].'">'.$row['player'].'</a></td><td>'.$row['g'].'</td><td>'.$row['w'].'</td><td>'.$row['d'].'</td><td>'.$row['l'].'</td><td>'.$row['gs'].'</td><td>'.$row['gc'].'</td><td>'.$row['pts'].'</td></tr>';
	}
	echo '</table>';
}
dbOpen();
$wc="World Cup ";
$round="";
$phase="";
$worldcup="";
$info="";
if (isset($_GET['wc'])) $worldcup=$_GET['wc'];
switch ($worldcup) {
	case "1":
	    $wc.="I ";
	$info="Dartford, England";
	break;
	case "2":
	    $wc.="II ";
	$info="Athens, Greece";
	break;
	case "3":
	    $wc.="III ";
	$info="Groningen, Netherlands";
	break;
	case "4":
	    $wc.="IV ";
	$info="Milan, Italy";
	break;
	case "5":
	    $wc.="V ";
	$info="Cologne, Germany";
	break;
	case "6":
	    $wc.="VI ";
	$info="Rickmansworth, England";
	break;
	case "7":
	    $wc.="VII ";
	$info="Rome, Italy";
	break;
	case "8":
	    $wc.="VIII ";
	$info="Athens, Greece";
	break;
	case "9":
	    $wc.="IX ";
	    $info="Austria, Voitsberg";
	break;
	case "10":
	    $wc.="X ";
	    $info="Germany, Dusseldorf";
	break;
	case "11":
	    $wc.="XI ";
	    $info="England, Birmingham";
	    break;
	case "12":
	    $wc.="XII ";
	    $info="Italy, Milan";
	    break;
	case "13":
	    $wc.="XIII ";
	    $info="Voitsberg, Austria";
	    break;
	case "14":
	    $wc.="XIV ";
	    $info="Copenhagen, Denmark";
	    break;
	case "15":
	    $wc.="2015 ";
	    $info="Dublin, Ireland";
	    break;
	case "16":
	    $wc.="XVI ";
	    $info="Milan, Italy";
	    break;

	default:
	    $wc="";
	break;
}
if ($wc!="") {
	echo '<h3>'.$wc.' <span style="font-variant: normal">( held in '.$info.' )</span></h3>'; 
	echo '<div class="panel-group">';  
	echo '<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" href="#standings">Standings</a></h4></div>';
	echo '<div id="standings" class="panel-collapse collapse in" ><div class="panel-body" style="height:300px;overflow:scroll;">';
	ShowTable($wc, '');
	echo '</div>';
	echo "</div></div>";      

	echo '<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" href="#games">Games</a></h4></div>';
	echo '<div id="games" class="panel-collapse collapse" ><div class="panel-body" style="height:300px;overflow:scroll;">';
	$sql = "SELECT distinct(phase) FROM `scores` where tournament='".$wc."'";
	$phases=runQuery($sql);
	while ($row=mysqli_fetch_array($phases,MYSQLI_ASSOC)) {
		$phase=$row['phase'];
		echo '<div>';
		echo '<u>'.$phase.'</u><br/>';
		echo '<table class="table table-striped table-condensed"><tr><td valign="top">';
		ShowTable($wc,$phase);
		echo '</td><td valign="top">';
		ShowGames ($wc, $phase);
		echo '</td></tr></table>';
		echo '</div>';
	}
	echo '</div>';
	echo "</div></div>";
	
	
	echo '<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" href="#stats">Statistics</a></h4></div>';
	echo '<div id="stats" class="panel-collapse collapse" ><div class="panel-body" style="height:300px;overflow:scroll;">';
	$sql="SELECT ( gol / games )gol, player FROM ( SELECT sum( goals ) gol, player, sum( games ) games FROM ( ( SELECT sum( A ) AS goals, count( A ) AS games, `Team A` AS player FROM scores WHERE tournament = '".$wc."' GROUP BY player ) UNION ( SELECT sum( B ) AS goals, count( B ) AS games, `Team B` AS player FROM scores WHERE tournament = '".$wc."' GROUP BY player ) )spyros GROUP BY player ORDER BY gol DESC )stats ORDER BY gol DESC LIMIT 0 , 8";
	$result=runQuery($sql);
	$pls=array();
	$gol=array();
	$i=0;	
	echo '<div class="row row-content"><div class="col-xs-6">';
	echo '<b>Best Attack (goals per game)</b><br/>';
	echo '<table class="table table-striped table-condensed">';
	while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
		$i++;
		echo '<tr><td width="10%">'.$i.'</td><td>'.$row['player'].' ('.number_format($row['gol'],2).')</td>';
		echo '</tr>';
		$pls[]=$row['player'];
		$gol[]=number_format($row['gol'],2);
	}
	echo '</table>';
	echo '</div>';
	echo '<div class="col-xs-6">';
	$val1=implode(",",$pls);
	$val2=implode(",",$gol);
	echo '<img src="chart.php?values='.$val2.'&labels='.$val1.'&graphtype=0&mode=1&width=240&height=240"/><br/>&nbsp;<br/>';		
	echo '</div>';	
	echo '</div>';
	
	echo '<div class="row row-content">';
	echo '<div class="col-xs-6">';	
	$sql = 'SELECT avg( goals ) gol, player FROM ( '
	        . ' ( SELECT avg( B ) AS goals, count( A ) AS games, `Team A` AS player FROM scores where tournament=\''.$wc.'\' GROUP BY player) UNION ( SELECT avg( A ) AS goals, count( B ) AS games, `Team B` AS player FROM scores where tournament=\''.$wc.'\' GROUP BY player ) )spyros GROUP BY player ORDER BY gol asc LIMIT 0 , 8';
	$sql="SELECT ( gol / games )gol, player FROM ( SELECT sum( goals ) gol, player, sum( games ) games FROM ( ( SELECT sum( B ) AS goals, count( A ) AS games, `Team A` AS player FROM scores WHERE tournament = '".$wc."' GROUP BY player ) UNION ( SELECT sum( A ) AS goals, count( B ) AS games, `Team B` AS player FROM scores WHERE tournament = '".$wc."' GROUP BY player ) )spyros GROUP BY player ORDER BY gol DESC )stats ORDER BY gol asc LIMIT 0 , 8";
	$result=runQuery($sql);
	$pls=array();
	$gol=array();
	$i=0;
	echo '<b>Best Defense (goals per game)</b><br/><table class="table table-striped table-condensed">';
	while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
		$i++;
		echo '<tr><td width="10%">'.$i.'</td><td>'.$row['player'].' ('.number_format($row['gol'],2).')</td></tr>';
		$pls[]=$row['player'];
		$gol[]=number_format($row['gol'],2);
	}
	echo '</table>';
	echo '</div>';
	$val1=implode(",",$pls);
	$val2=implode(",",$gol);
	echo '<div class="col-xs-6">';
	echo '<img src="chart.php?values='.$val2.'&labels='.$val1.'&graphtype=0&mode=1&width=240&height=240"/><br/>&nbsp;<br/>';

	echo '</div></div></div>';
	echo "</div></div>";

	echo '</div>';
} else echo '<h3>No world cup selected</h3>';
?>

</div>
<div class="col-xs-4 col-sm-3 ">
       <h3>Select World Cup</h3>
       <form name="worldcup">
       <p>
       <select size="16" name="wc" style="width:100%;" class="form-control">
       <option value="1">World Cup I (Dartford)</option>
       <option value="2">World Cup II (Athens)</option>
       <option value="3">World Cup III (Groningen)</option>
       <option value="4">World Cup IV (Milan)</option>
       <option value="5">World Cup V (Cologne)</option>
       <option value="6">World Cup VI (Rickmansworth)</option>
       <option value="7">World Cup VII (Rome)</option>
       <option value="8">World Cup VIII (Athens)</option>
       <option value="9">World Cup IX (Voitsberg)</option>
       <option value="10">World Cup X (Dusseldorf)</option>
       <option value="11">World Cup XI (Birmingham)</option>
	   <option value="12">World Cup XII (Milan)</option>
	   <option value="13">World Cup XIII (Voitsberg)</option>
	   <option value="14">World Cup XIV (Copenhagen)</option>
	   <option value="15">World Cup XV (Dublin)</option>
	   <option value="16">World Cup XVI (Milan)</option>
 			 </select>
				<input type="submit" class="btn btn-primary"  value="View"/>
				</p></form>

       <h3>Other Stats</h3>
       <form name="otherstats">
       <p>

       <a href="#" onclick="getMedals();">Medals table</a><br/>
       <a href="#" onclick="javascript:window.open ('cummulative.php', 'Cummulative_World_Cup_Stats','menubar=1,resizable=0,width=500,scrollbars=1,height=600');">Cummulative stats</a><br/>

        </p></div>
</div></div>
<?php
include 'footer.inc';
?>
	<div id="dimOverlay" style="display:none">
        <img src='images/camberwait.gif' alt='Loading indicator' /><span class='sr-only'>Loading...</span>
    </div>
		
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>		
	<script>
	function getMedals() {
		document.getElementById("modalTitle").innerHTML="World cup medals";
		makeRequest("retriever.php","wcmedals");
	}

	function processRequestResults(action,res,p1,p2) {
		if (action == "wcmedals") 
			showMedals(res);
	}		

	function showMedals(results) {		;
		var o = document.getElementById("modalBody");
		var s='';
		if (results.info=="0") {
			if (results.players.length>0) {								
				s+= '<table class="table table-striped table-condensed"><thead><tr><th >#</th><th  >Player</th><th  ><img src="images/gold.gif"/></th><th  ><img src="images/silver.gif"/></th><th  ><img src="images/bronze.gif"/></th><th  >4th </th><th  >5th - 8th</th></tr></thead><tbody>';
				for (var i = 0; i < results.players.length; i++) {
					var pl=results.players[i];
					s+='<tr>';
					for (var n=0; n<pl.length; n++) {
						s+= '<td>' + pl[n] + '</td>';
					}					
					s+= '</tr>';					
				}
				s += "</tbody></table>";						
			}
		
		o.innerHTML = s;            
		} else {
		o.innerHTML = "<h3>" + results.message + "</h3>";	
		}
		
		$('#divModal').modal();		
	}
	
<?php
include "request.inc";
?>

	</script>	
	</body>

</html>