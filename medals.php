<!DOCTYPE html
 PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>
		<title>KOASI!</title><link rel="alternate" type="application/rss+xml" title="Get RSS 2.0 Feed" href="rss.php" />
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
		<h2>Medals table</h2>
    	
			
			
<?php
  include 'support/db.inc'; 
  $players=array();
  
  dbOpen(); 
  $cups=array ("World Cup I","World Cup II","World Cup III","World Cup IV","World Cup V","World Cup VI","World Cup VII","World Cup VIII","World Cup IX","World Cup X", "World Cup XI", "World Cup XII","World Cup XIII","World Cup XIV","World Cup 2015","World Cup XVI");
  for ($i=0; $i<count($cups); $i++) {
    $sql="select p, player from `tables` where tournament='".$cups[$i]."' and p<9";
    $result=mysql_query($sql);
    while ($row=mysql_fetch_assoc($result)) {
      
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
    /*
  for ($i=0; $i<count($players); $i++) {
    for ($n=$i+1; $n<count($players); $n++) {
      if ($players[$i][5]<$players[$i][5]) {
        $tmp=$players[$i];
        $players[$i]=$players[$n];
        $players[$n]=$tmp;      
      }
    }
  }
  */

  array_multisort($players,SORT_DESC);

  
  echo '<table><tr><th >#</th><th  >Player</th><th  ><img src="images/gold.gif"/></th><th  ><img src="images/silver.gif"/></th><th  ><img src="images/bronze.gif"/></th><th  >4th </th><th  >5th - 8th</th></tr>';
  $i=0;
  foreach ($players as $key=>$val) {
    $i++;
    echo '<tr><td>'.strval($i).'</td>';
    echo '<td>'.$key.'</td>';
    echo '<td>'.$val[0].'</td>';
    echo '<td>'.$val[1].'</td>';
    echo '<td>'.$val[2].'</td>';
    echo '<td>'.$val[3].'</td>';
    echo '<td>'.$val[4].'</td></tr>';    
        
  }
  echo '</table>';
  
  /*


    grdMedals.Col = 7
    grdMedals.Sort = SortSettings.flexSortGenericDescending
    
    For i = 1 To grdMedals.Rows - 1
        grdMedals.TextMatrix(i, 0) = i
    Next
End Sub

*/  
  
  dbClose();
?>
		</div>
	</body>
</html>
