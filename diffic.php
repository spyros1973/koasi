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
			
			
			
<?php
  include 'support/db.inc'; 
  if (isset($_GET['player']))  $player=$_GET['player'];
  dbOpen(); 
  $sql="select count(*) from added_players where name='".$player."'";
  $count=getFirstRec($sql);
if ($count!=0) {
    
      dbOpen();
      echo '<h2>'.$player.' is among the easiest opponents for:</h2>';
      echo '<div>'; //</div> style="overflow:auto; height:180px; width:100%;">';
      
  $sql="select name, country from added_players where easy1='".$player."' or easy2='".$player."' or easy3='".$player."' order by name, country";
   	
     $result=mysql_query($sql);
     $played=false;
          while ($row=mysql_fetch_array($result)) {
            if ($played==false) {
              echo "<table><tr><th>Player</th><th>Country</th><th></th></tr>";  		
              $played=true;
            }
            $link='<a href="playervs.php?player1='.$player.'&player2='.$row[0].'">VS</a>';
            echo '<tr><td>'.$row[0].'</td><td>'.$row[1].'</td><td>'.$link.'</td></tr>';
          }  
  
  if ($played==true) {      
    echo "</table></div><br/>";  			
  }	else {
    echo "<b>No players found</b></div><br/>";
  }
 
 
      echo '<h2>'.$player.' is among the hardest opponents for:</h2>';
      echo '<div>'; //</div> style="overflow:auto; height:180px; width:100%;">';
      
  $sql="select name, country from added_players where hard1='".$player."' or hard2='".$player."' or hard3='".$player."' order by name, country";
   	
     $result=mysql_query($sql);
     $played=false;
          while ($row=mysql_fetch_array($result)) {
            if ($played==false) {
              echo "<table><tr><th>Player</th><th>Country</th><th></th></tr>";  		
              $played=true;
            }
            $link='<a href="playervs.php?player1='.$player.'&player2='.$row[0].'">VS</a>';
            echo '<tr><td>'.$row[0].'</td><td>'.$row[1].'</td><td>'.$link.'</td></tr>';
          }  
  
  if ($played==true) {      
    echo "</table></div><br/>";  			
  }	else {
    echo "<b>No players found</b><br/>";
  }
 
 
  
} else {  echo "<b>This player is unknown</b></div><br/>";
}

dbClose();
?>
		</div>
	</body>
</html>
