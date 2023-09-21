<!DOCTYPE html
 PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>
		<title>KOASI!</title><link rel="alternate" type="application/rss+xml" title="Get RSS 2.0 Feed" href="rss.php" />
		<link rel="stylesheet" href="style.css" type="text/css" />
		<link rel="stylesheet" href="print.css" type="text/css" media="print" />
		<meta http-equiv="Content-type" content="text/html; charset=ISO-8859-1" />
	</head>

	<body>
		
		<div id="container">
			

			<div id="header">
			<img src="images/header.jpg"/>
			</div>
			
			<div id="nav">
				<a href="index.php">Home</a>
				<a href="rankings.php">Rankings</a>
				<a href="players.php">Player stats</a>
				<a href="worldcups.php">World cups</a>
				<a href="tournaments.php">Tournaments</a>
				<a href="misc.php">Misc Stats</a>
				<a href="calendar.php">Calendar</a>				
        <a href="links.php">Links</a>
        <a href="about.php">About</a>
				<a href="mailto:spyros1973@yahoo.com">Contact</a>


<div id="news" style="margin:0; margin-top: 8px; padding:0; width: 150px; clear:left">

<h2 style="font-size: 11px; ">Host YOUR tourney!</h2>
<div id="normal">Hosting your own Kick Off 2 tournament could not be more E.A.S.Y. Click <a href="http://ko-gathering.com/forum/viewtopic.php?t=13761" style="display:inline; font-variant: normal; background: #ffffff;color: #3c7796; border:0; padding:0; margin:0; text-indent:0; font-weight: normal" >here</a> for details.</div>
<img src="images/promocal.jpg"/>
</div>
</div>			
			<div id="content">
				<h2>Tournament calendar</h2>

				<?php 
        include 'support/db.inc';
        
function GetMonthStr($date) {
  $dates=array();
  
  if ($date!="") {
      $yr=substr($date,strlen($s)-4);
      
      for ($i=1; $i<13; $i++) {
        if (strtolower(substr($date,0,strpos($date,' ')))==strtolower(date('F', mktime(0,0,0,$i)))) {
			$dates[]= mktime(0,0,0,$i,1,$yr);
			$dates[]= mktime(0,0,0,$i+1,-1,$yr);
			
			return $dates;          
        }
      }      
      return null;
  }  
}
        
        $tourncountry="";
        $tourndate="";
        if (isset($_GET['country'])) $tourncountry=$_GET['country'];
        if (isset($_GET['date'])) $tourndate=$_GET['date'];
        if (strtolower($tourncountry)=="(all)") $tourncountry="";
        if (strtolower($tourndate)=="(all)") $tourndate="";
        

        
        dbOpen();
        
		$dates=GetMonthStr($tourndate);


		if ($dates==null) {
	    	echo "<p><b>Future tournaments".(($tourncountry!='')?" in ".$tourncountry:"")."</b></p>";
	      echo "<table><tr><th width=5%>#</th><th width=30%>Tournament</th>";
	      echo "<th width=15%>Description</th><th  width=14%>Country</th><th  width=17%>Date</th><th  width=5%>Info</th><th  width=14%>Winner</th></tr>";
	    	  $date=date("Y-m-d");
	        $sql="select name, winner, country, link, `date`, place from calendar where `date`>='".$date."'";
	        

		if ($tourncountry!="") $sql=$sql." and country='".$tourncountry."' ";	        
        $sql=$sql." order by `date` asc";

	        $result=mysql_query($sql);
	        $i=0;
	        while ($row=mysql_fetch_array($result, MYSQL_ASSOC)) {
	          extract ($row);
	          $i++;
	          echo "<tr><td>".$i."</td><td>".$name."</td><td>".$place."</td>";
          if ($SHOWFLAGS) echo "<td><img src='flags/".$country.".jpg'/></td>";
          else
          echo "<td>".$country."</td>";
	          
            echo "<td>".date("j/m/Y", strtotime($date))."</td><td><a href='".$link."'><center><img src='images/info.gif'/></center></a></td><td>".(($winner!='')?$winner:"&nbsp;")."</td></tr>";               
	        }        
	        echo "</table>";
		}
    
    
		if ($dates==null)     	
    		echo "<p><b>Past tournaments".(($tourncountry!='')?" in ".$tourncountry:"")."</b></p>";
    	else
    		echo "<p><b>Tournaments".(($tourncountry!='')?" in ".$tourncountry:"")." on ".date('F Y',$dates[0])."</b></p>";
      
      echo "<table><tr><th>#</th><th>Tournament</th>";
      echo "<th width=15%>Description</th><th  width=14%>Country</th><th  width=17%>Date</th><th width=5%>Info</th><th  width=14%>Winner</th></tr>";
    	  $date=date("Y-m-d");
        $sql="select name, winner, country, link, `date`, place from calendar where ";
        if ($dates==null) 
        	  $sql=$sql."`date`<'".$date."' ";
        else	 
           $sql=$sql."`date`>='".date('Y-m-d',$dates[0])."' and `date`<='".date('Y-m-d',$dates[1])."' " ;
        
		if ($tourncountry!="") $sql=$sql." and country='".$tourncountry."' ";	        
        $sql=$sql." order by `date` desc";


        $result=mysql_query($sql);
        $i=0;
        while ($row=mysql_fetch_array($result, MYSQL_ASSOC)) {
          extract ($row);
          $i++;
          echo "<tr><td>".$i."</td><td><a href='tournaments.php?tournament=".$name."'>".$name."</a></td><td>".$place."</td>";
          
          if ($SHOWFLAGS) echo "<td><img src='flags/".$country.".jpg'/></td>";
          else
          echo "<td>".$country."</td>";
          
          echo "<td>".date("j/m/Y", strtotime($date))."</td><td><a href='".$link."'><center><img src='images/info.gif'/></center></a></td><td>".(($winner!='')?$winner:"&nbsp;")."</td></tr>";               
        }        
        echo "</table>";
    
    
    	
        ?>
<br/>
<div id="navfoot"><a href="caladmin.php">Show calendar admin panel</a></div>

      </div>
      
      
      
      
			<div id="news">
        <h2>Tournament finder</h2>
		  <form>        
        <p>Month:</br>
        
        
        <select name="date" style="width:100%">
        <option selected>(all)</option>
				<?php

				for ($i=1; $i<13; $i++) {        
          $val=date('F',mktime(0,0,0,$i))." 2008";
          echo "<option ".(($tourndate==$val)?"selected":"").">".$val."</option>";
        }        
        ?>
				</select>
		          
        <p>Country:</br>
        
        <select name="country" style="width:100%">
        <option selected>(all)</option>
				<?php
        $result = mysql_query("select country from countries order by country");
        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
          if ($row['country']!='WC') {
            echo "<option ";
            echo (($tourncountry==$row['country'])?" selected >":">");          
            echo $row['country']."</option>";
            }
          }          
        ?>
				</select>
        <br/>&nbsp;<br/>
        <input type="submit" value="Find"/><br/>
        </p>
				<h2>Latest Tournament</h2>
				<p style="font-size: 10px">
				<?php 
        $sql="select name, winner, link, date, place from calendar where winner<>'' order by date desc limit 0,1";
        $result=mysql_query($sql);
        if ($row=mysql_fetch_array($result, MYSQL_ASSOC)) {
          extract ($row);
          echo '<a href="players.php?player='.$winner.'">'.$winner.'</a> was the winner of '.$name.', which was held on the '.date("jS F Y", strtotime($date)).' in '.$place.'<br/>';
          echo 'Click <a href="'.$link.'">here</a> to find out more';          
        }

  echo '</p><h2>Next Tournament</h2>';
  echo '<p style="font-size: 10px">';
        //$sql="select name, winner, link, date, place from calendar where winner='' order by date desc limit 0,1";
        $sql="select name, winner, link, date, place, organiser from calendar where winner='' order by date asc limit 0,1";
        $result=mysql_query($sql);
        if ($row=mysql_fetch_array($result, MYSQL_ASSOC)) {
          extract ($row);
          echo 'The next KOA tournament will be '.$name.', organised by '.$organiser.', which will be held on the '.date("jS F Y", strtotime($date)).'.<br/>';
          echo 'Click <a href="'.$link.'">here</a> to find out more';          
        }
        
        ?>
        </p>

<?php

$sql = 'SELECT count(*), year(date) FROM `tournament players` group by year(date) LIMIT 0, 30 '; 

       echo '<h2>Tournaments per year</h2><br/>';
       $trn=array();
       $lbl=array();
       $min=0;
       $max=0;       
       $result = mysql_query($sql);
       while ($row=mysql_fetch_array($result)) {
            $trn[]=$row[0];
            $lbl[]=$row[1];
        }          
        
        $val=implode(",",$trn);
        $val1=implode(",",$lbl);
        $title1="KOA history stats";
        $title2="Tournaments per year";
        $src='values='.$val.'&maxval=80&labels='.$val1.'&graphtype=0&mode=1&title1='.$title1.'&title2='.$title2;
        echo '<a href="showpic.php?'.$src.'&width=640&height=480" >';
        echo '<img border="0" src="chart.php?'.$src.'&width=160&height=120" title="Tournaments per year"/>';
        echo '</a><br/>&nbsp;<br/>';

dbClose();
?>


        
		  </form>	
			</div>

<?php
include 'footer.inc';
?>			
		</div>
		
	</body>

</html>
