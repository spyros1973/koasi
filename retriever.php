<?php
include 'support/db.inc'; 
$action=$p1=$p2=$p3="";

if (isset($_GET["action"]))
	$action=$_GET["action"];
if (isset($_GET["p1"]))
	$p1=$_GET["p1"];
if (isset($_GET["p2"]))
	$p2=$_GET["p2"];
if (isset($_GET["p3"]))
	$p3=$_GET["p3"];

function GetPct($tot, $num) {
  $s=$num;
  if ($tot!=0) $s=$s." (".number_format(($num/$tot * 100),2)."%)";    
  return $s;
}  

function Name2Href($str) {
  $s1=substr($str,0,strpos($str,"(")-1);
  $s2=substr($str,strpos($str,"("));
  return '<a href="players.php?player='.$s1.'">'.$s1.'</a> '.$s2;  
}

dbOpen();
switch ($action) {
	case "playerlist": {
		$result=runQuery("select name from added_players order by name");
		$players=array();
		while ($row= mysqli_fetch_array($query, MYSQLI_NUM)) {
			array_push($players,$row[0]);
		}
		$response=array("info" => "0", "players" => $players);
		break;
	}
	case "playervs": {				
		$p1=escapeString($p1);
		$p2=escapeString($p2);
		$p3=escapeString($p3);
		$sql = "select * from ((select `Team A`, `Team B`, A, B, scores.tournament, chrono from scores, `tournament players` where scores.tournament=`tournament players`.Tournament and `Team A`='".$p1."' and `Team B`='".$p2."' order by chrono asc) union (select `Team A`,`Team B`, A, B, scores.tournament, chrono from scores, `tournament players` where scores.tournament=`tournament players`.Tournament and `Team B`='".$p1."' and `Team A`='".$p2."' order by chrono asc)) spyros order by chrono";	
		$query=runQuery($sql);
		$played=false;
		$big1=-50;
		$big2=-50;
		$big1s="";
		$big2s="";
		$games=array();		
		
		while ($row= mysqli_fetch_array($query, MYSQLI_NUM)) {
			if ($played==false) {		
			$played=true;
			}
			$result=array("Team_A" => $row[0], "Team_B" => $row[1], "A" =>  $row[2], "B" => $row[3], "Tournament" => $row[4], "chrono" => $row[5]);
			array_push($games,$result);
			if ($row[0]==$p1) {
				if (($row[2]-$row[3]>0) && ($row[2]-$row[3]>$big1)) {
					$big1=$row[2]-$row[3];
					$big1s=$row[2]."-".$row[3]." (".$row[4].")";
				}
			} else {
				if (($row[3]-$row[2]>0) && ($row[3]-$row[2]>$big1)) {
					$big1=$row[3]-$row[2];
					$big1s=$row[2]."-".$row[3]." (".$row[4].")";
				}
			}    
			if ($row[0]==$p2) {
				if (($row[2]-$row[3]>0) && ($row[2]-$row[3]>$big2)) {
					$big2=$row[2]-$row[3];
					$big2s=$row[2]."-".$row[3]." (".$row[4].")";
				}
			} else {
				if (($row[3]-$row[2]>0) && ($row[3]-$row[2]>$big2)) {
					$big2=$row[3]-$row[2];
					$big2s=$row[2]."-".$row[3]." (".$row[4].")";
				}
			}    
		}
		
		if ($played==true) {						
			$sql="select count(*) from scores where `Team A`='".$p1."' and `Team B`='".$p2."' and A>B";			
			$awon=getFirstRec($sql);
			$sql="select count(*) from scores where `Team A`='".$p1."' and `Team B`='".$p2."' and A=B";
			$adrawn=getFirstRec($sql);
			$sql="select count(*) from scores where `Team A`='".$p1."' and `Team B`='".$p2."' and A<B";
			$alost=getFirstRec($sql);			
			$sql="select sum(a) from scores where `Team A`='".$p1."' and `Team B`='".$p2."' ";
			$afor=getFirstRec($sql);
			$sql="select sum(b) from scores where `Team A`='".$p1."' and `Team B`='".$p2."' ";
			$aagainst=getFirstRec($sql);
			$sql="select count(*) from scores where `Team B`='".$p1."' and `Team A`='".$p2."' and B>A";
			$awon=$awon + getFirstRec($sql);
			$sql="select count(*) from scores where `Team B`='".$p1."' and `Team A`='".$p2."' and A=B";
			$adrawn=$adrawn + getFirstRec($sql);
			$sql="select count(*) from scores where `Team B`='".$p1."' and `Team A`='".$p2."' and A>B";
			$alost=$alost + getFirstRec($sql);
			$sql="select sum(b) from scores where `Team B`='".$p1."' and `Team A`='".$p2."' ";
			$afor=$afor + getFirstRec($sql);
			$sql="select sum(a) from scores where `Team B`='".$p1."' and `Team A`='".$p2."' ";
			$aagainst=$aagainst + getFirstRec($sql);
			$aforavg=number_format($afor / ($awon+$adrawn+$alost),2);
			$aagainstavg=number_format($aagainst / ($awon+$adrawn+$alost),2);
			$sql="select rankpoints, rankpos from added_players where name='".$p1."'";
			$result=runQuery($sql);
			$row=mysqli_fetch_array($result,MYSQLI_NUM);
			$rank1=$row[1];
			$rankpts1=$row[0];
			$sql="select rankpoints, rankpos from added_players where name='".$p2."'";
			$result=runQuery($sql);
			$row=mysqli_fetch_array($result,MYSQLI_NUM);
			$rank2=$row[1];
			$rankpts2=$row[0];			
			$stats=array();
			$pl1=array();
			$pl2=array();
			array_push($pl1,array("name"=>"Rank_points","value"=>$rankpts1));
			array_push($pl1,array("name"=>"Rank_pos","value"=>$rank1));
			array_push($pl1,array("name"=>"Games","value"=>($awon+$adrawn+$alost)));
			array_push($pl1,array("name"=>"Wins","value"=>GetPct($awon+$adrawn+$alost,$awon)));
			array_push($pl1,array("name"=>"Draws","value"=>GetPct($awon+$adrawn+$alost,$adrawn)));
			array_push($pl1,array("name"=>"Losses","value"=>GetPct($awon+$adrawn+$alost,$alost)));
			array_push($pl1,array("name"=>"Goals_for","value"=>$afor." (".$aforavg.")"));
			array_push($pl1,array("name"=>"Goals_against","value"=>$aagainst." (".$aagainstavg.")"));
			array_push($pl1,array("name"=>"Biggest_win","value"=>(($big1>0)?$big1s:"-")));

			array_push($pl2,array("name"=>"Rank_points","value"=>$rankpts2));
			array_push($pl2,array("name"=>"Rank_pos","value"=>$rank2));
			array_push($pl2,array("name"=>"Games","value"=>($awon+$adrawn+$alost)));
			array_push($pl2,array("name"=>"Wins","value"=>GetPct($awon+$adrawn+$alost,$alost)));
			array_push($pl2,array("name"=>"Draws","value"=>GetPct($awon+$adrawn+$alost,$adrawn)));
			array_push($pl2,array("name"=>"Losses","value"=>GetPct($awon+$adrawn+$alost,$awon)));
			array_push($pl2,array("name"=>"Goals_for","value"=>$aagainst." (".$aagainstavg.")"));
			array_push($pl2,array("name"=>"Goals_against","value"=>$afor." (".$aforavg.")"));
			array_push($pl2,array("name"=>"Biggest_win","value"=>(($big2>0)?$big2s:"-")));

			$response=array("info" => "0", "games" => $games, "pl1" => $pl1, "pl2" => $pl2);
		} else {
			if ((strtolower($p1)==strtolower($p2))) {
				$response=array("info" => "1", "message" => "Let's skip the megalomania please.");
			} else $response=array("info" => "1", "message" => "No games between these players are recorded.");
		}		
		break;
	}
	case "countryvs": {
		$p1=escapeString($p1);
		$p2=escapeString($p2);
		$p3=escapeString($p3);
		$sql = "select * from ((select `Team A`, `Team B`, A, B, scores.tournament, chrono from scores, `tournament players` where scores.tournament=`tournament players`.Tournament and `Team A`='".$p1."' and `Team B`='".$p2."' order by chrono asc) union (select `Team A`,`Team B`, A, B, scores.tournament, chrono from scores, `tournament players` where scores.tournament=`tournament players`.Tournament and `Team B`='".$p1."' and `Team A`='".$p2."' order by chrono asc)) spyros order by chrono";	
		$sql = 'select `team a`, `team b`, a, b, scores.tournament, chrono from scores, rankings, `tournament players` '
        . ' where ((`team a`=\''.$p1.'\' and rankings.country=\''.$p2.'\' and scores.`team b`=rankings.player) or ( `team b`=\''.$p1.'\' and rankings.country=\''.$p2.'\' and scores.`team a`=rankings.player)) and scores.tournament=`tournament players`.tournament order by chrono';
		$query=runQuery($sql);
		$played=false;
		$big1=-50;
		$big2=-50;
		$big1s="";
		$big2s="";
		$awon=$adrawn=$alost=$afor=$bfor=0;
		$games=array();		
		
		while ($row= mysqli_fetch_array($query, MYSQLI_NUM)) {			
			if ($played==false) {		
				$played=true;
			}
			$result=array("Team_A" => $row[0], "Team_B" => $row[1], "A" =>  $row[2], "B" => $row[3], "Tournament" => $row[4], "chrono" => $row[5]);
			array_push($games,$result);
			if ($row[0]==$p1) {
				$afor+=$row[2];
				$bfor+=$row[3];
				if ($row[2]>$row[3]) $awon++;
					if ($row[3]>$row[2]) $alost++;
					if ($row[2]==$row[3]) $adrawn++;      		      		
				if (($row[2]-$row[3]>0) && ($row[2]-$row[3]>$big1)) {
					$big1=$row[2]-$row[3];
					$big1s=$row[0]."-".$row[1].": ".$row[2]."-".$row[3]." (".$row[4].")";
				}
				if (($row[3]-$row[2]>0) && ($row[3]-$row[2]>$big2)) {
					$big2=$row[3]-$row[2];
					$big2s=$row[0]."-".$row[1].": ".$row[2]."-".$row[3]." (".$row[4].")";
				}
			} else {
				$afor+=$row[3];
					$bfor+=$row[2];
				if ($row[2]>$row[3]) $alost++;
					if ($row[3]>$row[2]) $awon++;
					if ($row[2]==$row[3]) $adrawn++;      	
				if (($row[3]-$row[2]>0) && ($row[3]-$row[2]>$big1)) {
					$big1=$row[3]-$row[2];
					$big1s=$row[0]."-".$row[1].": ".$row[2]."-".$row[3]." (".$row[4].")";
				}
				if (($row[2]-$row[3]>0) && ($row[2]-$row[3]>$big2)) {
					$big2=$row[2]-$row[3];
					$big2s=$row[2]."-".$row[3]." (".$row[4].")";
					$big2s=$row[0]."-".$row[1].": ".$row[2]."-".$row[3]." (".$row[4].")";
				}
			}
		}
		
		if ($played==true) {			
			$aforavg=number_format($afor / ($awon+$adrawn+$alost),2);
			$bforavg=number_format($bfor / ($awon+$adrawn+$alost),2);
		
			$stats=array();
			$pl1=array();
			$pl2=array();
			array_push($pl1,array("name"=>"Games","value"=>($awon+$adrawn+$alost)));
			array_push($pl1,array("name"=>"Wins","value"=>$awon));
			array_push($pl1,array("name"=>"Draws","value"=>$adrawn));
			array_push($pl1,array("name"=>"Losses","value"=>$alost));
			array_push($pl1,array("name"=>"Goals_for","value"=>$afor." (".$aforavg.")"));
			array_push($pl1,array("name"=>"Goals_against","value"=>$bfor." (".$bforavg.")"));
			array_push($pl1,array("name"=>"Biggest_win","value"=>(($big1>0)?$big1s:"-")));

			array_push($pl2,array("name"=>"Games","value"=>($awon+$adrawn+$alost)));
			array_push($pl2,array("name"=>"Wins","value"=>$alost));
			array_push($pl2,array("name"=>"Draws","value"=>$adrawn));
			array_push($pl2,array("name"=>"Losses","value"=>$awon));
			array_push($pl2,array("name"=>"Goals_for","value"=>$bfor." (".$bforavg.")"));
			array_push($pl2,array("name"=>"Goals_against","value"=>$afor." (".$aforavg.")"));
			array_push($pl2,array("name"=>"Biggest_win","value"=>(($big2>0)?$big2s:"-")));
			
			$response=array("info" => "0", "games" => $games, "pl1" => $pl1, "pl2" => $pl2);			
		} else {
			$response=array("info" => "1", "message" => "No games between ".$p1." and players from ".$p2."  are recorded.");
		}
		break;
	}
	case "easyhard": {
		$p1=escapeString($p1);   			
		$easy=array();
		$hard=array();
		$sql="select name, country from added_players where easy1='".$p1."' or easy2='".$p1."' or easy3='".$p1."' order by name, country";
		$result=runQuery($sql);
        while ($row=mysqli_fetch_array($result,MYSQLI_NUM)) {            
			array_push($easy,array("player"=>$row[0],"country"=>$row[1]));
        }

		$sql="select name, country from added_players where hard1='".$p1."' or hard2='".$p1."' or hard3='".$p1."' order by name, country";
		$result=runQuery($sql);
        while ($row=mysqli_fetch_array($result,MYSQLI_NUM)) {
			array_push($hard,array("player"=>$row[0],"country"=>$row[1]));
        }
		
		$response=array("info" => "0", "easy" => $easy, "hard" => $hard);
		break;
	}
	case "wcmedals": {
		$players=array();
		$players=array();
		$cups=array ("World Cup I","World Cup II","World Cup III","World Cup IV","World Cup V","World Cup VI","World Cup VII","World Cup VIII","World Cup IX","World Cup X", "World Cup XI", "World Cup XII","World Cup XIII","World Cup XIV","World Cup 2015","World Cup XVI");
		
		for ($i=0; $i<count($cups); $i++) {
			$sql="select p, player from `tables` where tournament='".$cups[$i]."' and p<9";
			$result=runQuery($sql);			
			while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {      				
				if (!array_key_exists($row['player'],$players)) {
					$player=array(0,0,0,0,0,0);        
					$players[$row['player']]=$player;     
				}
				if ($row['p']==1) $players[$row['player']][0]++;
				if ($row['p']==2) $players[$row['player']][1]++;
				if ($row['p']==3) $players[$row['player']][2]++;
				if ($row['p']==4) $players[$row['player']][3]++;
				if ($row['p']>4) $players[$row['player']][4]++;
				$players[$row['player']][5]=100*$players[$row['player']][0]+40*$players[$row['player']][1]+15*$players[$row['player']][2]+4*$players[$row['player']][3]+$players[$row['player']][4];
			}
		}		
		array_multisort($players,SORT_DESC);
		
		$result=array();
		$i=0;		
		foreach ($players as $key=>$val) {
			$i++;
			$pl=array($i,$key,$val[0],$val[1],$val[2],$val[3],$val[4]);
			array_push($result,$pl);
		}
		$response=array("info" => "0", "players" => $result);
		break;
	}
	case "miscgeneral": {
		$stats=array();
		$games=getFirstRec("select count(*) from scores");
		$goals=getFirstRec("select sum(a+b) from scores");
		$gamesPreN = getFirstRec("select count(*) from scores, `tournament players` where scores.tournament=`tournament players`.tournament and `tournament players`.equalteams=0");
		$gamesPostN = getFirstRec("select count(*) from scores, `tournament players` where scores.tournament=`tournament players`.tournament and `tournament players`.equalteams<>0");
		$aGoalsPreN = getFirstRec("select sum(a) from scores, `tournament players` where scores.tournament=`tournament players`.tournament and `tournament players`.equalteams=0");
		$aGoalsPostN = getFirstRec("select sum(a) from scores, `tournament players` where scores.tournament=`tournament players`.tournament and `tournament players`.equalteams<>0");
		$bGoalsPreN = getFirstRec("select sum(b) from scores, `tournament players` where scores.tournament=`tournament players`.tournament and `tournament players`.equalteams=0");
		$bGoalsPostN = getFirstRec("select sum(b) from scores, `tournament players` where scores.tournament=`tournament players`.tournament and `tournament players`.equalteams<>0");
		array_push($stats,array("name"=>"Total games","value"=>$games));
		array_push($stats,array("name"=>"Total goals","value"=>$goals));
		array_push($stats,array("name"=>"Average goals per game","value"=>number_format(($goals/$games),2)));
		array_push($stats,array("name"=>"Average score with A>B","value"=>number_format($aGoalsPreN/$gamesPreN,2)." - ".number_format($bGoalsPreN/$gamesPreN,2)));
		array_push($stats,array("name"=>"Average score with A=B","value"=>number_format($aGoalsPostN/$gamesPostN,2)." - ".number_format($bGoalsPostN/$gamesPostN,2)));
		$response=array("info" => "0", "stats" => $stats);
		break;
	}
	case "miscindividual": {
		$stats=array();
		$result=runQuery("select * from added_misc");
		while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			array_push($stats,array("name"=>"Most games played","value"=>Name2Href($row["s00"])));
			array_push($stats,array("name"=>"Best attack avg","value"=>Name2Href($row["s01"])));
			array_push($stats,array("name"=>"Best defense avg","value"=>Name2Href($row["s02"])));
			array_push($stats,array("name"=>"Worst attack avg","value"=>Name2Href($row["s03"])));
			array_push($stats,array("name"=>"Worst defense avg","value"=>Name2Href($row["s04"])));
			array_push($stats,array("name"=>"Most goals scored","value"=>Name2Href($row["s13"])));
			array_push($stats,array("name"=>"Most goals conceded","value"=>Name2Href($row["s14"])));
			array_push($stats,array("name"=>"Most wins","value"=>Name2Href($row["s15"])));
			array_push($stats,array("name"=>"Most draws","value"=>Name2Href($row["s16"])));
			array_push($stats,array("name"=>"Most losses","value"=>Name2Href($row["s17"])));
			array_push($stats,array("name"=>"Biggest win %","value"=>Name2Href($row["s18"])));
			array_push($stats,array("name"=>"Biggest draw %","value"=>Name2Href($row["s19"])));
			array_push($stats,array("name"=>"Biggest loss %","value"=>Name2Href($row["s20"])));
			array_push($stats,array("name"=>"Most tournaments won","value"=>Name2Href($row["s27"])));
			array_push($stats,array("name"=>"Most clean sheets","value"=>Name2Href($row["s28"])));
			array_push($stats,array("name"=>"Most clean sheets %","value"=>Name2Href($row["s29"])));
			array_push($stats,array("name"=>"Most games with no goals scored","value"=>Name2Href($row["s30"])));
			array_push($stats,array("name"=>"Most games with no goals scored %","value"=>Name2Href($row["s31"])));
			array_push($stats,array("name"=>"Played against most players","value"=>Name2Href($row["s35"])));
			array_push($stats,array("name"=>"Played against most countries","value"=>Name2Href($row["s36"])));
			array_push($stats,array("name"=>"Easiest opponent for more","value"=>Name2Href($row["s37"])));
			array_push($stats,array("name"=>"Hardest opponent for more","value"=>Name2Href($row["s38"])));
			array_push($stats,array("name"=>"Most games scored double figures","value"=>Name2Href($row["s43"])));
			array_push($stats,array("name"=>"Most games conceded double figures","value"=>Name2Href($row["s44"])));
			array_push($stats,array("name"=>"Most games per month in the last year","value"=>Name2Href($row["s45"])));

			$sql = 'select name, format((hardestfor-easiestfor)/opponentno,2) from added_players where opponentno>=10 order by (hardestfor-easiestfor)/opponentno desc LIMIT 0, 1';
			$res=runQuery($sql);
			$rec=mysqli_fetch_row($res);
			$danger=Name2Href($rec[0].' ('.$rec[1].' pts)');  
			array_push($stats,array("name"=>"Most dangerous","value"=>$danger,"tooltip"=>"For each player, we subtract the players for which he is the easiest opponent from those for which he is the hardest and then divide by the total number of opponents. A value close to 1 signifies that a player is the hardest opponent for almost all his opponents - quite an achievement!"));
			
			$sql = 'select name, format((hardestfor-easiestfor)/opponentno,2) from added_players where opponentno>=10 order by (hardestfor-easiestfor)/opponentno asc LIMIT 0, 1';
			$res=runQuery($sql);
			$rec=mysqli_fetch_row($res);
			$danger=Name2Href($rec[0].' ('.$rec[1].' pts)');   
			array_push($stats,array("name"=>"Least dangerous","value"=>$danger,"tooltip"=>"For each player, we subtract the players for which he is the easiest opponent from those for which he is the hardest and then divide by the total number of opponents. A value close to -1 signifies that a player is the easiest opponent for almost all his opponents - quite an achievement!"));
		}
		
		$response=array("info" => "0", "stats" => $stats);
		break;
	}
	case "miscbiggestwins": {
		$stats=array();
		$result=runQuery(strtolower("SELECT  `TEAM A`, `TEAM B`, A, B, A-B as expr, TOURNAMENT FROM scores where abs(a-b)>13 ORDER BY Abs(a-b) DESC limit 0,10"));
		while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
			$score=array("Team_A" => $row['team a'], "Team_B" => $row['team b'], "A" =>  $row['a'], "B" => $row['b'], "Tournament" => $row['tournament']);
			array_push($stats,$score);
		}
		$response=array("info" => "0", "games" => $stats);
		break;
	}
	case "miscmostgoals": {
		$stats=array();
		$result=runQuery(strtolower("SELECT  `TEAM A`, `TEAM B`, A, B, A+B as expr, TOURNAMENT FROM scores where a+b>14 ORDER BY a+b DESC limit 0,10"));
		while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
			$score=array("Team_A" => $row['team a'], "Team_B" => $row['team b'], "A" =>  $row['a'], "B" => $row['b'], "Tournament" => $row['tournament']);
			array_push($stats,$score);
		}
		$response=array("info" => "0", "games" => $stats);
		break;
	}	
		
}	
	
dbClose();

header('Content-Type: application/json');
echo json_encode($response);

?>