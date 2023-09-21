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
$page="players";
include 'header.inc';
?>   
			
<?php 
function GetPct($tot, $num) {
  $s=$num;
  if ($tot!=0) $s=$s." (".number_format(($num/$tot * 100),2)."%)";    
  return $s;
}

function GetAvg($tot, $num) {
  $s=$num;
  if ($tot!=0) $s=$s." (".number_format(($num/$tot),2).")";
  return $s;
}

function Name2Href($str) {
  $s1=substr($str,0,strpos($str,"(")-1);
  $s2=substr($str,strpos($str,"("));
  return '<a href="players.php?player='.$s1.'">'.$s1.'</a> '.$s2;  
}

function VSLink($p1, $p2, $txt) {
  if ($txt=='') $txt='vs';
  $s='<a href="#" onclick="javascript:ShowVS(';
  $s.="'".$p1."','".$p2."'";
  $s.=');">'.$txt.'</a>';
  return $s;
}

function ShowMedals($player) {
    $gold=getFirstRec("select count(*) from `tables` where tournament like 'World Cup%' and player='".$player."' and p=1");
    $silver=getFirstRec("select count(*) from `tables` where tournament like 'World Cup%' and player='".$player."' and p=2");
    $bronze=getFirstRec("select count(*) from `tables` where tournament like 'World Cup%' and player='".$player."' and p=3");
    
    for ($i=0; $i<$bronze; $i++) {
      echo '<img src="images/bronze.gif"/>';
    }    
    for ($i=0; $i<$silver; $i++) {
      echo '<img src="images/silver.gif"/>';
    }    
    
    for ($i=0; $i<$gold; $i++) {
      echo '<img src="images/gold.gif"/>';
    }    

}
$player="";
$letter="A";
if (isset($_GET['player'])) $player=$_GET['player'];
dbOpen();
$result = runQuery("select * from added_players where name='".$player."'");
if (($player!="") && ($result)) {
  echo ' <div class="row row-content"><div class="col-xs-8 col-sm-7 col-sm-offset-1">';
  while ($row =  mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $games=($row['won']+$row['drawn']+$row['lost']);
    echo '<h2>'.$player.' (#'.$row['rankpos'].' - '.$row['rankpoints'].' pts) ';
        
    ShowMedals($player);
    echo "</h2><table class='table table-striped table-condensed'>";
    //echo "<tr><td><b>Origin</b></td><td>".$row['country'];
    //if ((!$row['address']=='NULL') && (!$row['address']=='')) echo ' ('.$row['address'].')';
    //echo "</td></tr>";
    echo "<tr><td><b>Tournaments played</b></td><td>".$row['tournplayed']."</td></tr>";
    echo "<tr><td><b>Tournaments won</b></td><td>".GetPct($row['tournplayed'],$row['tournwon'])."</td></tr>";
    echo "<tr><td><b>World cups played</b></td><td>".$row['wcplayed']."</td></tr>";
    echo "<tr><td><b>Games played</b></td><td>".$games."</td></tr>";
    echo "<tr><td><b>Games won</b></td><td>".GetPct($games,$row['won'])."</td></tr>";
    echo "<tr><td><b>Games drawn</b></td><td>".GetPct($games,$row['drawn'])."</td></tr>";
    echo "<tr><td><b>Games lost</b></td><td>".GetPct($games,$row['lost'])."</td></tr>";
    echo "<tr><td><b>Goals for</b></td><td>".GetAvg($games,$row['gfor'])."</td></tr>";
    echo "<tr><td><b>Goals against</b></td><td>".GetAvg($games,$row['gagainst'])."</td></tr>";
    echo "<tr><td><b>Last tournament</b></td><td>".$row['lasttournament']."</td></tr>"; 
    echo "<tr><td><b>Games per month in the last year</b></td><td>".number_Format($row['activityrating'],2)."</td></tr>"; 
    echo "<tr><td><b>1st easiest opponent</b></td><td>".(($row['easy1'])!="-"?"<a href='players.php?player=".$row['easy1']."'>".$row['easy1']."</a>":$row['easy1']);
    if ($row['easy1']!='-') echo '&nbsp;<span style="font-size:10px">'.VSLink($player, $row['easy1'],'(vs)').'</span>';
    echo "</td></tr>";
    echo "<tr><td><b>2nd easiest opponent</b></td><td>".(($row['easy2'])!="-"?"<a href='players.php?player=".$row['easy2']."'>".$row['easy2']."</a>":$row['easy2']);
    if ($row['easy2']!='-') echo '&nbsp;<span style="font-size:10px">'.VSLink($player, $row['easy2'],'(vs)').'</span>';
    echo "</td></tr>";
    echo "<tr><td><b>3rd easiest opponent</b></td><td>".(($row['easy3'])!="-"?"<a href='players.php?player=".$row['easy3']."'>".$row['easy3']."</a>":$row['easy3']);
    if ($row['easy3']!='-') echo '&nbsp;<span style="font-size:10px">'.VSLink($player, $row['easy3'],'(vs)').'</span>';
    echo "</td></tr>";
    echo "<tr><td><b>1st hardest opponent</b></td><td>".(($row['hard1'])!="-"?"<a href='players.php?player=".$row['hard1']."'>".$row['hard1']."</a>":$row['hard1']);
    if ($row['hard1']!='-') echo '&nbsp;<span style="font-size:10px">'.VSLink($player, $row['hard1'],'(vs)').'</span>';
    echo "</td></tr>";
    echo "<tr><td><b>2nd hardest opponent</b></td><td>".(($row['hard2'])!="-"?"<a href='players.php?player=".$row['hard2']."'>".$row['hard2']."</a>":$row['hard2']);
    if ($row['hard2']!='-') echo '&nbsp;<span style="font-size:10px">'.VSLink($player, $row['hard2'],'(vs)').'</span>';
    echo "</td></tr>";
    echo "<tr><td><b>3rd hardest opponent</b></td><td>".(($row['hard3'])!="-"?"<a href='players.php?player=".$row['hard3']."'>".$row['hard3']."</a>":$row['hard3']);
    if ($row['hard3']!='-') echo '&nbsp;<span style="font-size:10px">'.VSLink($player, $row['hard3'],'(vs)').'</span>';
    echo "</td></tr>";


//$link="<script>window.open ('diffic.php?player=".$player."', 'Easiest / hardest','menubar=1,resizable=0,width=400,height=470');</script>";

    echo '<tr><td><b>Easiest opponent for</b></td><td><a href="#" onclick="getEasyHard(\''.$player.'\')">'.$row['easiestfor'].' player(s)</a></td></tr>';  
    echo '<tr><td><b>Hardest opponent for</b></td><td><a href="#" onclick="getEasyHard(\''.$player.'\')">'.$row['hardestfor'].' player(s)</a></td></tr>';  
    echo "<tr><td><b>Different opponents</b></td><td>".$row['opponentno']."</td></tr>";
    echo "<tr><td><b>Opponents' countries</b></td><td>".$row['opponentcountryno']."</td></tr>";    
    echo "<tr><td><b>More frequent opponent</b></td><td>".Name2Href($row['mostfrequent']." (".$row['mostfrequentgames'])." games) ";
    echo '<span style="font-size:10px;">';
    echo VSLink ($player, $row['mostfrequent'],'(vs)');   
    echo '</span>';
    echo "</td></tr>";    
    echo "<tr><td><b>Total clean sheets</b></td><td>".GetPct($games,$row['clean'])."</td></tr>";   
    echo "<tr><td><b>No goals scored</b></td><td>".GetPct($games,$row['nogoal'])."</td></tr>"; 
    echo "<tr><td><b>Scored double figures</b></td><td>".GetPct($games,$row['doublescored'])."</td></tr>"; 
    echo "<tr><td><b>Conceded double figures</b></td><td>".GetPct($games,$row['doubleconceded'])."</td></tr>"; 
    echo "<tr><td><b>Biggest win</b></td><td>".$row['biggestwin']."</td></tr>";
    echo "<tr><td><b>Biggest defeat</b></td><td>".$row['biggestdefeat']."</td></tr>"; 

	$sql = "select ((hardestfor-easiestfor)/opponentno) danger, name from added_players where name='".$player."'";
	$val=number_format(getFirstRec($sql),2);
    echo "<tr><td><b>Danger rating</b></td><td>".$val."</td></tr>"; 
}    

echo "</table>";
echo '</p><br/>';

echo '<h2>Game List</a></h2>';
echo '<div style="overflow:auto; height:250px; width:100%;">';

echo "<table class='table table-striped table-condensed'><thead><tr><th>Team A</th><th>Team B</th><th>A</th><th>B</th><th>Tournament</th></tr></thead><tbody>";
$sql = "select * from ((select `Team A`, `Team B`, A, B, scores.tournament, chrono from scores, `tournament players` where scores.tournament=`tournament players`.tournament and `Team A`='".$player."' order by chrono asc) union (select `Team A`,`Team B`, A, B, scores.tournament, chrono from scores, `tournament players` where scores.tournament=`tournament players`.Tournament and `Team B`='".$player."' order by chrono asc)) spyros order by chrono";
$result=runQuery($sql);
$i=0;
while ($row= mysqli_fetch_array($result, MYSQLI_NUM)) {
	$i++;
	if (fmod($i,2)==0) echo "<tr class='d0'>";
		else  echo "<tr class='d1'>";
		echo '<td>'.$row[0].'</td><td>'.$row[1].'</td><td>'.$row[2].'</td><td>'.$row[3].'</td><td><a href="tournaments.php?tournament='.$row[4].'">'.$row[4].'</a></td></tr>';
	}

	echo "</tbody></table></div><br/>";
	echo '</div>';

	} else {
		echo '<div class="row row-content"><div class="col-xs-8 col-sm-7 col-sm-offset-1">';
		echo '<h2>No player selected</h2>';
		echo '</div>';
	}
?>
        
<div class="col-xs-4 col-sm-3">
	<h4>Select player</h4>
	<form name="selectplayer">
	<div class="form-group" id="playerlist">
	<p>
	<select name="player" style="width:100%" class="form-control">
        
<?php
	$result=runQuery("select name from added_players order by name");
	$pl=$player;
	if ($pl=="") $pla="Gianni T";
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		echo "<option ".(($pl==$row['name'])?" selected ":"").">";
		echo $row['name']."</option>";
	}

	echo '</select><input type="submit" class="btn btn-primary" value="Select"/></p></form>';
	
	//echo '<form><fieldset><div class="form-group"><label for="query">Search:</label><input type="text" class="form-control" name="query" id="query" placeholder="Start typing something to search...">';
	//echo '</div><button type="submit" class="btn btn-primary">Search</button></fieldset></form>';
	
	
    echo '';
        
	if ($player!="") {        
		echo '<h4>Rankings progress</h4><br/>';
		$pts=array();
		$lbl=array();
		$min=0;
		$max=0;       
		$result = runQuery("select * from rankings where player='".$player."'");
		$row=mysqli_fetch_array($result,MYSQLI_NUM);
		for ($i=0; $i<mysqli_num_fields($result); $i++) {
			$s=strtoupper(mysqli_fetch_field_direct($result, $i)->name);
	  
			if (($s!="R") && ($s!="PLAYER") && ($s!="COUNTRY") && ($s!="FIRSTPLAYED") && ($s!="ACTIVITY") && ($s!="ADDRESS") && ($s!="PROFILE")) {
				if (($row) && ($row[$i]!=-1)) {
					$pts[]=$row[$i];
					$lbl[]=substr($s,1);
				}
			}
		}
		if (count($pts)>0) {
			$max=max($pts);
			$min=min($pts);
		}
		$val=implode(",",$pts);
		$val1=implode(",",$lbl);
		$title1="Rankings progress graph for ".$player;
		$title2="( Rankings points range: ".$min." - ".$max.")";
		$src='values='.$val.'&labels='.$val1.'&maxval=3800&graphtype=1&mode=0&width=640&height=480&title1='.$title1.'&title2='.$title2;
		echo '<a href="showpic.php?'.$src.'" >';
		echo '<img style="width:100%;height:auto;" border="0" src="chart.php?values='.$val.'&labels='.$val1.'&maxval=3800&graphtype=1&mode=0" title="Rankings progress graph for '.$player.' ('.$min.' - '.$max.')"/>';
		echo '</a><br/>&nbsp;<br/>';
		echo '<h4>'.$player.' vs player</h4>';
		echo '<form name="vsplayer" onsubmit="return ShowVS(null,null);"> ';
		echo '<p><select name="opponent" style="width:100%" class="form-control"/><br/>';
			
		$result=runQuery("select name from added_players order by name");
		if ($player=="") $player="Gianni T";
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			echo "<option ".(($player==$row['name'])?" selected ":"").">";
			echo $row['name']."</option>";
		}
		echo '</select>';
		echo '<input type="hidden" name="selectedplayer"  value="'.$player.'"/>';
		echo '<input type="submit" class="btn btn-primary" value="View" onclick="return ShowVS();"/>';
		echo '</p></div></form>';
		echo '<h4>vs The World!</h4>';
?>

	<form name="vscountry" >
	<div class="form-group">
	<p>
	<select name="country" style="width:100%" class="form-control">

<?php
	$result = runQuery("select country from countries order by country");
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		if ($row['country']!='WC') {
			echo "<option >";
			//echo (($country==$row['country'])?" selected >":">");
			echo $row['country']."</option>";
		}
	}
	echo '</select>';
	echo '<input type="hidden" name="selectedplayer"  value="'.$player.'"/>';				
	echo '<input type="submit" class="btn btn-primary"  value="View" onclick="return ShowVSCountry();"/>';
?>
    </p>
	</div>
    </form>	

<?php				
		echo '<h4>More frequent opponents</h4>';
		$sql = 'select `CountOfTeam A`+ `CountOfTeam B` as suma, `Team A` from '
				. ' (SELECT Count(scores.`Team A`) AS `CountOfTeam A`, scores.`Team A` From scores WHERE (((scores.`Team B`)=\''.$player.'\')) GROUP BY scores.`Team A`) as table1, (SELECT Count(scores.`Team B`) AS `CountOfTeam B`, scores.`Team B` From scores WHERE (((scores.`Team A`)=\''.$player.'\')) GROUP BY scores.`Team B`) as table2 Where table1.`team A` = table2.`Team B` order by (`CountOfTeam A`+`CountOfTeam B`) desc limit 0,10';
		$result=runQuery($sql);
		echo '<table class="table table-condensed table-striped"><tr><th>Player</th><th>Games</th><th>View</th></tr>';
		$i=0;
		while ($row=mysqli_fetch_array($result,MYSQLI_NUM)) {
			$i++;
			if (fmod($i,2)==0) echo "<tr class='d0'>";
				else  echo "<tr class='d1'>";
			echo '<td><a href="players.php?player='.$row[1].'">'.$row[1].'</td>';
			echo '<td>'.$row[0].'</td>';
			echo '<td>'.VSLink($player, $row[1],'');
			echo '</td></tr>';
		}
		echo '</table>';
	}

	echo '</div></div></div></div>';
	dbClose();
	include 'footer.inc';
?>			

    <div id="dimOverlay" style="display:none">
        <img src='images/camberwait.gif' alt='Loading indicator' /><span class='sr-only'>Loading...</span>
    </div>


  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>		
	

	<script>
	
	
	
	function ShowVSCountry() {    	
		selectbox=document.forms[2].country;
		val2=selectbox.options[selectbox.selectedIndex].text;
		val1 =(document.forms[2].selectedplayer.value);
		if (val2==null||val2=="") 
			alert ('Please select a player and a country');
		else {
			try {      	
				document.getElementById("modalTitle").innerHTML=val1 + " vs " + val2;
				makeRequest("retriever.php","countryvs",val1,val2);
			}
			catch (e) {
			}	
		}
		return false;
	}

	function getPlayers() {
		makeRequest("retriever.php","playerlist");
	}
	
	function getEasyHard(pl) {
		document.getElementById("modalTitle").innerHTML="Easiest / hardest stats";
		makeRequest("retriever.php","easyhard",pl,null);
	}
	
    function ShowVS(v1, v2) {		
		selectbox=document.forms[1].opponent;
		if (v1==null||v2==null) {
			val2=selectbox.options[selectbox.selectedIndex].text;
			val1 =(document.forms[1].selectedplayer.value);
		} else {val1=v1; val2=v2;}
      
		if (val2==null||val2=="") 
			alert ('Please select a player');
		else {
			try {				
				document.getElementById("modalTitle").innerHTML=val1 + " vs " + val2;				
				makeRequest("retriever.php","playervs",val1,val2);
			}
			catch (e) {
				alert(e);
			}
      	}      
		return false;      
    }

	function processRequestResults(action,res,p1,p2) {
		if ((action == "playervs") || (action == "countryvs")) 
			showVsInfo(res,p1,p2);		
		if (action=="easyhard")
			showEasyHardInfo(res,p1);
	}		
	
	
<?php
include "request.inc";
?>

	function showEasyHardInfo(results,player) {
		var o = document.getElementById("modalBody");
		var s='';
		if (results.info=="0") {
			if (results.easy.length>0) {				
				s+= "<h4>Easiest for " + results.easy.length + " player(s)</h4><table class='table table-striped table-condensed'><thead><tr><th width='40%'>Player</th><th width='40%'>Country</th><th width='20%'>&nbsp;</th><thead><tbody>";
				for (var i = 0; i < results.easy.length; i++) {
					var r=results.easy[i];
					link='<a href="#" onclick="ShowVS(\'' + player + '\',\'' + r.player + '\')">VS</a>';
					s+="<tr><td>" + r.player + "</td><td>" + r.country + "</td><td>" + link + "</td></tr>";
				}
				s += "</tbody></table>";						
			}

			if (results.hard.length>0) {
				s+= "<h4>Hardest for " + results.hard.length + " player(s)</h4><table class='table table-striped table-condensed'><thead><tr><th width='40%'>Player</th><th width='40%'>Country</th><th width='20%'>&nbsp;</th><thead><tbody>";
				for (var i = 0; i < results.hard.length; i++) {
					var r=results.hard[i];
					link='<a href="#" onclick="ShowVS(\'' + player + '\',\'' + r.player + '\')">VS</a>';
					s+="<tr><td>" + r.player + "</td><td>" + r.country + "</td><td>" + link + "</td></tr>";
				}
				s += "</tbody></table>";
			}
			
			if ((results.hard.length==0) && (results.easy.length==0)) {
				s="<h3>" + player + " is not among the easiest or hardest opponents for any player</h3>";
			}
		
		
		o.innerHTML = s;            
		} else {
		o.innerHTML = "<h3>" + results.message + "</h3>";	
		}
		
		$('#divModal').modal();		
	}
	
	function showVsInfo(results,p1,p2) {            
		var o = document.getElementById("modalBody");
		var s='';
		if (results.info=="0") {
		s+= "<h4>Statistics</h4><table class='table table-striped table-condensed'><thead><tr><th>&nbsp;</th><th>";
		s+= p1 + "</th><th>" + p2 + "</th></tr></thead><tbody>";
		for (var i = 0; i < results.pl1.length; i++) {
			var stat1=results.pl1[i];
			var stat2=results.pl2[i];
			s+="<tr><td><strong>" + stat1.name + "</strong></td><td>" + stat1.value + "</td><td>" + stat2.value + "</td></tr>";
		}
		s += "</tbody></table>";
		
		s += "<h4>Games</h4><table class='table table-striped table-condensed'><thead><tr><th>Team A</th>";
		s += "<th>Team B</th><th>A</th><th>B</th><th>Tournament</th></tr></thead><tbody>";
		for (var i = 0; i < results.games.length; i++) {
			var r = results.games[i];
			s+="<tr><td>" + r.Team_A + "</td><td>" + r.Team_B + "</td><td>" + r.A;
			s+="</td><td>" + r.B + "</td><td>" + r.Tournament + "</td></tr>";
		}
		s += "</tbody></table>";
		
		o.innerHTML = s;            
		} else {
		o.innerHTML = "<h3>" + results.message + "</h3>";	
		}
		
		$('#divModal').modal();
	}

	</script>
	</body>
</html>
