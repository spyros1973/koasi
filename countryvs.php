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
  if (isset($_GET['player']) && (isset($_GET['country']))) {
    $player=$_GET['player'];
    $country=$_GET['country'];
    
    dbOpen();
    echo '<h2>'.$player.' vs '.$country.'</h2>';
    echo '<div style="overflow:auto; height:180px; width:100%;">';
    

	$sql = 'select `team a`, `team b`, a, b, scores.tournament, chrono from scores, rankings, `tournament players` '
        . ' where ((`team a`=\''.$player.'\' and rankings.country=\''.$country.'\' and scores.`team b`=rankings.player) or ( `team b`=\''.$player.'\' and rankings.country=\''.$country.'\' and scores.`team a`=rankings.player)) and scores.tournament=`tournament players`.tournament order by chrono';
 	
        $result=runQuery($sql);
   $played=false;
   $big1=-50;
   $big2=-50;
   $awon=$adrawn=$alost=$afor=$bfor=0;
        while ($row=mysqli_fetch_array($result,MYSQLI_NUM)) {
          if ($played==false) {
            echo "<table><tr><th>Team A</th><th>Team B</th><th>A</th><th>B</th><th>Tournament</th></tr>";
		
            $played=true;
          }
          echo '<tr><td>'.$row[0].'</td><td>'.$row[1].'</td><td>'.$row[2].'</td><td>'.$row[3].'</td><td>'.$row[4].'</td></tr>';
      	if ($row[0]==$player) {
      	      $afor+=$row[2];
      			$bfor+=$row[3];
      		if ($row[2]>$row[3]) 	$awon++;
				if ($row[3]>$row[2]) 	$alost++;
				if ($row[2]==$row[3]) 	$adrawn++;
      		
      		
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
      		if ($row[2]>$row[3]) 	$alost++;
				if ($row[3]>$row[2]) 	$awon++;
				if ($row[2]==$row[3]) 	$adrawn++;
      	
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
    
echo "</table></div><br/>";
$aforavg=number_format($afor / ($awon+$adrawn+$alost),2);
$bforavg=number_format($bfor / ($awon+$adrawn+$alost),2);


    echo "<h2>Statistics</h2>";
    echo "<table><tr><th>&nbsp;</th><th>".$player."</th><th>".$country."</th></tr>";
    echo "<tr><td>Games</td><td>".($awon+$adrawn+$alost)."</td><td>".($awon+$adrawn+$alost)."</td></tr>";
    echo "<tr><td>Wins</td><td>".$awon."</td><td>".$alost."</td></tr>";
    echo "<tr><td>Draws</td><td>".$adrawn."</td><td>".$adrawn."</td></tr>";
    echo "<tr><td>Losses</td><td>".$alost."</td><td>".$awon."</td></tr>";
    echo "<tr><td>Goals for</td><td>".$afor." (".$aforavg.")</td><td>".$bfor." (".$bforavg.")</td></tr>";
    echo "<tr><td>Goals against</td><td>".$bfor." (".$bforavg.")</td><td>".$afor." (".$aforavg.")</td></tr>";
	 echo "<tr><td>Biggest win</td><td>".(($big1>0)?$big1s:"-")."</td><td>".(($big2>0)?$big2s:"-")."</td></tr>";
    echo "</table><br/>";
} else { 
  echo "<p style='text-align:center'>";
  echo "No games between ".$player." and players from ".$country."  are recorded.";
  echo "</p>";
}
  dbClose();
}

?>
			
				
		</div>
		
	</body>

</html>
