<!DOCTYPE html
 PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>
		<title>KOASI!</title>
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
		
		<div id="content" style="width: 100%; margin:0; padding:0;">
			
			
			
<?php
  include 'support/db.inc'; 
  
function GetPct($tot, $num) {
  $s=$num;
  if ($tot!=0) $s=$s." (".number_format(($num/$tot * 100),2)."%)";    
  return $s;
}  
  
  if (isset($_GET['player1']) && (isset($_GET['player2']))) {
    $pl1=$_GET['player1'];
    $pl2=$_GET['player2'];
    
    dbOpen();
    echo '<h2>'.$pl1.' vs '.$pl2.'</h2>';
    echo '<div style="overflow:auto; height:180px; width:100%;">';
    


 	$sql = "select * from ((select `Team A`, `Team B`, A, B, scores.tournament, chrono from scores, `tournament players` where scores.tournament=`tournament players`.Tournament and `Team A`='".$pl1."' and `Team B`='".$pl2."' order by chrono asc) union (select `Team A`,`Team B`, A, B, scores.tournament, chrono from scores, `tournament players` where scores.tournament=`tournament players`.Tournament and `Team B`='".$pl1."' and `Team A`='".$pl2."' order by chrono asc)) spyros order by chrono";
   //echo $sql;
        $result=mysql_query($sql);
   $played=false;
   $big1=-50;
   $big2=-50;
   $big1s="";
   $big2s="";
        while ($row=mysql_fetch_array($result)) {
          if ($played==false) {
            echo "<table><tr><th>Team A</th><th>Team B</th><th>A</th><th>B</th><th>Tournament</th></tr>";
		
            $played=true;
          }
          echo '<tr><td>'.$row[0].'</td><td>'.$row[1].'</td><td>'.$row[2].'</td><td>'.$row[3].'</td><td>'.$row[4].'</td></tr>';
      	if ($row[0]==$pl1) {
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
      	if ($row[0]==$pl2) {
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
    
echo "</table></div><br/>";
$sql="select count(*) from scores where `Team A`='".$pl1."' and `Team B`='".$pl2."' and A>B";
$awon=getFirstRec($sql);
$sql="select count(*) from scores where `Team A`='".$pl1."' and `Team B`='".$pl2."' and A=B";
$adrawn=getFirstRec($sql);
$sql="select count(*) from scores where `Team A`='".$pl1."' and `Team B`='".$pl2."' and A<B";
$alost=getFirstRec($sql);
$sql="select sum(a) from scores where `Team A`='".$pl1."' and `Team B`='".$pl2."' ";
$afor=getFirstRec($sql);
$sql="select sum(b) from scores where `Team A`='".$pl1."' and `Team B`='".$pl2."' ";
$aagainst=getFirstRec($sql);

$sql="select count(*) from scores where `Team B`='".$pl1."' and `Team A`='".$pl2."' and B>A";
$awon=$awon + getFirstRec($sql);
$sql="select count(*) from scores where `Team B`='".$pl1."' and `Team A`='".$pl2."' and A=B";
$adrawn=$adrawn + getFirstRec($sql);
$sql="select count(*) from scores where `Team B`='".$pl1."' and `Team A`='".$pl2."' and A>B";
$alost=$alost + getFirstRec($sql);


 

$sql="select sum(b) from scores where `Team B`='".$pl1."' and `Team A`='".$pl2."' ";
$afor=$afor + getFirstRec($sql);
$sql="select sum(a) from scores where `Team B`='".$pl1."' and `Team A`='".$pl2."' ";
$aagainst=$aagainst + getFirstRec($sql);
$aforavg=number_format($afor / ($awon+$adrawn+$alost),2);
$aagainstavg=number_format($aagainst / ($awon+$adrawn+$alost),2);
$sql="select rankpoints, rankpos from added_players where name='".$pl1."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
$rank1=$row[1];
$rankpts1=$row[0];
$sql="select rankpoints, rankpos from added_players where name='".$pl2."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
$rank2=$row[1];
$rankpts2=$row[0];



    echo "<h2>Statistics</h2>";
    echo "<table><tr><th>&nbsp;</th><th>".$pl1."</th><th>".$pl2."</th></tr>";
    echo "<tr><td>Rank points</td><td>".$rankpts1."</td><td>".$rankpts2."</td></tr>";
    echo "<tr><td>Rank pos</td><td>#".$rank1."</td><td>#".$rank2."</td></tr>";
    echo "<tr><td>Games</td><td>".($awon+$adrawn+$alost)."</td><td>".($awon+$adrawn+$alost)."</td></tr>";
    echo "<tr><td>Wins</td><td>".GetPct($awon+$adrawn+$alost,$awon)."</td><td>".GetPct($awon+$adrawn+$alost,$alost)."</td></tr>";
    echo "<tr><td>Draws</td><td>".GetPct($awon+$adrawn+$alost,$adrawn)."</td><td>".GetPct($awon+$adrawn+$alost,$adrawn)."</td></tr>";
    echo "<tr><td>Losses</td><td>".GetPct($awon+$adrawn+$alost,$alost)."</td><td>".GetPct($awon+$adrawn+$alost,$awon)."</td></tr>";
    echo "<tr><td>Goals for</td><td>".$afor." (".$aforavg.")</td><td>".$aagainst." (".$aagainstavg.")</td></tr>";
    echo "<tr><td>Goals against</td><td>".$aagainst." (".$aagainstavg.")</td><td>".$afor." (".$aforavg.")</td></tr>";
	 echo "<tr><td>Biggest win</td><td>".(($big1>0)?$big1s:"-")."</td><td>".(($big2>0)?$big2s:"-")."</td></tr>";
    echo "</table><br/>";


} else { 
  echo "<p style='text-align:center'>";
  if ((strtolower($pl1)==strtolower($pl2))) {
    echo "Let's skip the megalomania please.";
  } else echo "No games between these players are recorded.";
  
  echo "</p>";
}
    dbClose();
}

?>
			
				
		</div>
		
	</body>

</html>
