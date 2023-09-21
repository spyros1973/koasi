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
$page="misc";
include 'header.inc';

?>   
<div class="row row-content">
	<div class="col-xs-6">
		<div class="panel-group">
			<div class="panel panel-default">
			  <div class="panel-heading">
				<h4 class="panel-title">
				  <a data-toggle="collapse" href="#divGeneral">General stats</a>
				</h4>
			  </div>
			  <div id="divGeneral" class="panel-collapse collapse in">
				<div id="divGeneralBody" class="panel-body"></div>				
			  </div>
			</div>
			
			<div class="panel panel-default">
			  <div class="panel-heading">
				<h4 class="panel-title">
				  <a data-toggle="collapse" href="#divBiggestWins">Biggest wins</a>
				</h4>
			  </div>
			  <div id="divBiggestWins" class="panel-collapse collapse in">
				<div id="divBiggestWinsBody" class="panel-body"></div>				
			  </div>
			</div>

			<div class="panel panel-default">
			  <div class="panel-heading">
				<h4 class="panel-title">
				  <a data-toggle="collapse" href="#divMostGoals">Most goals</a>
				</h4>
			  </div>
			  <div id="divMostGoals" class="panel-collapse collapse in">
				<div id="divMostGoalsBody" class="panel-body"></div>				
			  </div>
			</div>
			
			
		  </div>
</div>
<div class="col-xs-6 ">
		<div class="panel-group">
		
			<div class="panel panel-default">
			  <div class="panel-heading">
				<h4 class="panel-title">
				  <a data-toggle="collapse" href="#divIndividual">Individual</a>
				</h4>
			  </div>
			  <div id="divIndividual" class="panel-collapse collapse in">
				<div id="divIndividualBody" class="panel-body"></div>				
			  </div>
			</div>
			
		  </div>
 </div>
</div>
</div>
<?php
include 'footer.inc';
?>
	<div id="dimOverlay" style="display:none">
        <img src='images/camberwait.gif' alt='Loading indicator' /><span class='sr-only'>Loading...</span>
    </div>
		
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>		
	<script>
		$( document ).ready(function() {
			getGeneral();
			getIndividual();
			getBiggestWins();
			getMostGoals();
		});

	function getGeneral() {		
		makeRequest("retriever.php","miscgeneral",null,null,'divGeneralBody');
	}

	function getIndividual() {		
		makeRequest("retriever.php","miscindividual",null,null,'divIndividualBody');
	}

	function getBiggestWins() {		
		makeRequest("retriever.php","miscbiggestwins",null,null,'divBiggestWinsBody');
	}

	function getMostGoals() {		
		makeRequest("retriever.php","miscmostgoals",null,null,'divMostGoalsBody');
	}
	
	
	function processRequestResults(action,res,p1,p2) {
		if (action == "miscgeneral") 
			showStats(res,document.getElementById("divGeneralBody"));
		if (action == "miscindividual") 
			showStats(res,document.getElementById("divIndividualBody"),"getPopStats");
		if (action == "miscbiggestwins") 
			showGames(res,document.getElementById("divBiggestWinsBody"));		
		if (action == "miscmostgoals") 
			showGames(res,document.getElementById("divMostGoalsBody"));		

	}		

	function showGames(results,div) {
		var s='';
		if (results && results.info=="0") {
			s += "<table class='table table-striped table-condensed'><thead><tr><th>Team A</th>";
			s += "<th>Team B</th><th>A</th><th>B</th><th>Tournament</th></tr></thead><tbody>";
			for (var i = 0; i < results.games.length; i++) {
				var r = results.games[i];
				s+="<tr><td>" + r.Team_A + "</td><td>" + r.Team_B + "</td><td>" + r.A;
				s+="</td><td>" + r.B + "</td><td>" + r.Tournament + "</td></tr>";
			}
			s += "</tbody></table>";
			div.innerHTML = s;
		} else {
			div.innerHTML = "<h4>" + results.message + "</h4>";		
		}
	}
	
	function popStats( type) {  
		window.open ("topstats.php?stattype="+type, "TopStats","menubar=1,resizable=0,width=400,height=600");
	}

	function showStats(results,div,popStats) {
		var s='';
		if (results.info=="0") {
			if (results.stats.length>0) {								
				s+= '<table class="table table-striped table-condensed"><tbody>';
				var idx=0;
				for (var i = 0; i < results.stats.length; i++) {
					var st=results.stats[i];
					
					lnk=st.name;
					if (popStats) {
						lnk="<a href='#' onclick='popStats(" + idx + ");'>" + st.name + "</a>";
					}
					
					if (st.tooltip)
						s+='<tr><td title="' + st.tooltip + '"><strong>' + lnk + '</strong></td><td>' + st.value + '</td></td></tr>';
					else
						s+='<tr><td><strong>' + lnk + '</strong></td><td>' + st.value + '</td></td></tr>';
					
					idx++;
				}
				s += "</tbody></table>";						
			}
		
		div.innerHTML = s;            
		} else {
		div.innerHTML = "<h3>" + results.message + "</h3>";	
		}		
	}
	
	
<?php
include "request.inc";
?>

	</script>	
	</body>

</html>