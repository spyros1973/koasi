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
	<style>
	.box { margin: 15px; height:180px;  display: inline-block; vertical-align: top; }
	</style>
</head>

<body >        
<?php
include "modal.inc"
?>
    <div class="container">

<?php
include 'support/db.inc'; 
$page="about";
include 'header.inc';

?>
<div class="row row-content">
<div class="col-xs-10 col-xs-offset-1">
<p>
<h3>Hot (or maybe not so) off the press!</h3>
</p>
From the frozen summers of <a href="players.php?player=Jorn F">Tromsø</a>, to the hot beaches of <a href="players.php?player=Vasilis K">Kalamata</a>, and from the skycrapers of <a href="players.php?player=Wayne L">Hong Kong</a>, to the cozy seats of a Tully's Coffee shop in <a href="players.php?player=Thor S">Seattle</a>, 
everyone knows and reads The Lob, KOA's favorite newspaper. Conceptualized, created, edited, illustrated, printed and delivered by Alkis Polyrakis, The Lob is a must read for the modern KOAer 
and here you can find all the back papers for your reading pleasure.
</div>
</div>
<div class="row row-content">
&nbsp;
</div>
<div class="row row-content" >	
<?php

$papers=array();
if ($handle = opendir('news')) {
    
	while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != ".." && is_file('news/'.$file)) {
			$dt=substr($file,9,4);
			$month=substr($dt,0,2);
			$year=substr($dt,2,2);
			
			array_push($papers,array("file"=>$file,"date"=>date('F Y',mktime(0,0,0,$month,1,2000 + $year)),"timestamp"=>mktime(0,0,0,$month,1,2000 + $year)));			
        }
    }	
    closedir($handle);
	}
	
	$dates = array();
	foreach ($papers as $key => $row)
	{
		$dates[$key] = $row['timestamp'];
	}

	array_multisort($dates, SORT_DESC, $papers);


	//array_multisort($papers,SORT_DESC);
	foreach($papers as $paper)
	{
		echo '<div class="col-md-2 col-sm-3 col-xs-4 text-xs-center">';
		echo '<div class="box">';
		echo '<img class="img-responsive" style="height:180px;margin:0 auto;" src="news/'.$paper["file"].'" title="'.$paper["date"].' "/>';
		echo '</div>';
		echo '<div class="caption">'.$paper["date"].'</div>';
		echo '</div>';
	}

?>
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
<script language="javascript">
$( document ).ready(function() {
   $("img").click(function() {
	  var o = document.getElementById("modalBody");
	  o.innerHTML="<img src='" + this.src + "' class='img-responsive' style=' margin: 0 auto;' />";
	  var t = document.getElementById("modalTitle");
	  t.innerHTML=this.title;
	  $('#divModal').modal();
   });
});
</script>
	</body>

</html>

