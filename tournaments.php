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
    <div class="container">

<?php
include 'support/db.inc'; 
$page="tournaments";
include 'header.inc';

?>   
<div class="row row-content">
	<div class="col-xs-8 col-sm-7 col-sm-offset-1">
        
<?php
function ShowGames($player, $phase) {	
  global $tournament;
  $where="tournament='".$tournament."'";  
  if ($phase!='') $where=$where." and phase ='".$phase."'";
  if ($player!='') $where=$where." and (`team a`='".$player."' or `team b`='".$player."') ";
  $sql = "select `team a`, `team b`, a, b, extra from scores where ".$where." order by id";  
  $result=runQuery($sql);
  
  if ($phase!="") echo '<br/><u>'.$phase.'</u><br/>';
  echo '<table class="table table-striped table-condensed"><tr><th width="30%">Team A</th><th width="30%">Team B</th><th width="10%">A</th><th width="10%">B</th><th width="20%">Extra</th></tr>';
  while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    echo '<tr><td>'.$row['team a'].'</td><td>'.$row['team b'].'</td><td>'.$row['a'].'</td><td>'.$row['b'].'</td><td>';
    if ($row['extra']!='') echo $row['extra'];
    echo '</td></tr>'; 
  }
  echo '</table>';
} 

dbOpen();
$tournament="";
$country="";
if (isset($_GET['tournament'])) $tournament=$_GET['tournament'];
if (isset($_GET['country'])) $country=$_GET['country'];

$sql="select `date`,country from `tournament players` where tournament='".$tournament."'";

$result=runQuery($sql);
if ($row=mysqli_fetch_array($result,MYSQLI_NUM)) {
  echo "<h3>".$tournament." - held in ".$row[1]." on ".date('j/m/Y',strtotime($row[0]))."</h3><p>";
    $cup=getFirstRec("select `Cup?` from `tournament players` where tournament ='".$tournament."'");
    if ($cup=="-1") {
    echo '<b>No table available</b><br/>This tournament was a cup competition.<br/>';          
    } else {    
    	$sql="select p, player, g, w, d, l, gs, gc, pts from `tables` where tournament='".$tournament."'";
    	$result=runQuery($sql);
    	echo '<b>Table</b><br/>';
    	echo '<table class="table table-striped table-condensed"><tr><th>#</th><th>Player</th><th>G</th><th>W</th><th>D</th><th>L</th><th>GS</th><th>GC</th><th>Pts</th></tr>';
		while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
		  echo '<tr><td>'.$row['p'].'</td><td><a href="players.php?player='.$row['player'].'">'.$row['player'].'</a></td><td>'.$row['g'].'</td><td>'.$row['w'].'</td><td>'.$row['d'].'</td><td>'.$row['l'].'</td><td>'.$row['gs'].'</td><td>'.$row['gc'].'</td><td>'.$row['pts'].'</td></tr>';
		}
		echo '</table>';
	//    gRes.Open "select distinct phase from scores where phase is not null and " & sSQLWhere, oCon, 0, 1    
    }

    echo '<br/><b>Games</b><br/><div style="overflow:auto; height:250px; width:100%;">';    
    $sql="select distinct(phase) from scores where tournament='".$tournament."'";
    $phases=runQuery($sql);

    while ($row=mysqli_fetch_array($phases,MYSQLI_ASSOC))  {
    	$phase=$row['phase'];    
  		ShowGames ("", $phase);  		
	}
	echo '</div> ';
} else { 
    echo '<h3>No tournament selected</h3>';	
   if ($tournament!="") echo "<p>No information is recorded for tournament '".$tournament."'.</p><p> If it's a recent tournament (i.e. it took place after the last db update date - check the bottom of this page for that), then it will be added soon in the KOASI.</p>";
   }
    echo '</p>';  

?>
	</div>

	 <div class="col-xs-4 col-sm-3 " >
		<h3>Select tournament</h3>
		
		<form name="tournaments" onSubmit="return SendForm();" onKeypress="javascript:if (event.keyCode == 13) SendForm();">
			<div class="form-group">

			<?php        
				$sql= "select tournament, country from `tournament players` where not (tournament like 'World Cup%') order by chrono, tournament";				
				$result=runQuery($sql);
				echo '<label for="tournament">Tournament to show:</label><select size="24" name="tournamenthidden" style="display:none; width:100%;font-size: 10px" >';
				
				while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          		echo '<option value="'.$row['country'].'">'.$row['tournament'].'</option>';
        		}
            
				echo '</select><br/>';
				echo '<select size="20" name="tournament" style="width:100%;" class="form-control">';				
				echo '</select>';
				
				echo '<label for="country">Country:</label><br/>';
				echo '<select name="country" onChange="FillList();" class="form-control" style="width:100%;" class="form-control" >';
				echo '<option selected>(all)</option>';
				$sql="select country from countries where country<>'WC' order by country";
				$result=runQuery($sql);
				while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          		echo '<option';
          		if (strtolower($row['country'])==strtolower($country)) echo ' selected';
          		echo '>'.$row['country'].'</option>';
          	}
				echo '</select>';
				echo '<input type="submit" value="View" class="btn btn-primary"/>';
				echo '</p></form>';

  dbClose();
?>
			</div>
		</form>		
	</div>	
</div>

<?php
include 'footer.inc';
?>			
		</div>

    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>		
	</body>
<script language="javascript">
$( document ).ready(function() {
   FillList();
});
function ClearList(obj){
  for (var i=obj.options.length-1; i>=0; i--){
    obj.options[i] = null;
  }
  obj.selectedIndex = -1;
}


function addOption(selectbox,text,value )
{
var optn = document.createElement("OPTION");
optn.text = text;
optn.value = value;
selectbox.options.add(optn);
}

  function FillList () {  
	  var selectbox;
	  var country;	  
	  selectbox=document.forms.tournaments.country;
	  country=selectbox.options[selectbox.selectedIndex].text;       
     
      trg=document.forms.tournaments.tournament;
      src=document.forms.tournaments.tournamenthidden;
	  ClearList(trg);
     
     
try {	  	
	var recs=0;  	
	for(i=src.options.length-1;i>=0;i--) {
		if (country.toLowerCase()=='(all)') {
			addOption(trg, src.options[i].text, src.options[i].value);
			recs++;
		} else {
			if (src.options[i].value.toLowerCase()==country.toLowerCase()) {
				addOption(trg, src.options[i].text, src.options[i].value);
				recs++;
			}
			 
		}		
	}
	if (recs<30) trg.size=recs;

}
catch (e)
{
alert (e.message);
}


return false;
  }

function SendForm() {
	var obj=document.forms.tournaments.tournament;
	var obj1=document.forms.tournaments.country;
	url='tournaments.php?tournament=' + obj.options[obj.selectedIndex].text + '&country=' + obj1.options[obj1.selectedIndex].text;
	window.location=url;
	return false;
}  
  
  </script>	

</html>
