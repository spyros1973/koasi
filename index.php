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
$page="home";
include 'header.inc';

?>   

        <div class="row row-content">
            <div class="col-xs-12 col-sm-10 col-sm-push-1">
                <div class="media">
                    <div class="media-body">
                        <h2 class="media-heading">Welcome!</h2>
                        <p>Welcome to the Kick Off Association Statistics Institute! The institute is open to all online researchers, who want to dive in a wealth of statistical information on all the Kick Off tournaments played by members of the Kick Off Association. Choose your fix below...</p>
                        <br/>
                    </div>                    
                </div>
            </div>
        </div>

		<div class="row row-content">
		<div class="col-xs-3 col-xs-offset-1">
		<a class="ko2menu" href="rankings.php">
		<div class="media">
		<div class="media-body text-center">
		<p>RANKINGS</p>
		</div>
		</div></a>
		</div>

		<div class="col-xs-3">
		<a class="ko2menu" href="players.php">
		<div class="media">
		<div class="media-body text-center">
		<p>PLAYERS</p>
		</div>
		</div>
		</a>
		</div>

		<div class="col-xs-3">		
		<a class="ko2menu" href="tournaments.php">
		<div class="media">
		<div class="media-body text-center ">
		<p>TOURNAMENTS</p>
		</div>
		</div>
		</a>
		</div>
		</div>
		
		<div class="row row-content">
		<div class="col-xs-12">		
		&nbsp;
		</div>
		</div>
		
		
		<div class="row row-content">
		<div class="col-xs-3 col-xs-offset-2">
		<a class="ko2menu" href="worldcups.php">
		<div class="media">
		<div class="media-body text-center ">
		<p>WORLD CUPS</p>
		</div>
		</div></a>
		</div>

		<div class="col-xs-3">
		<a class="ko2menu" href="misc.php">
		<div class="media">
		<div class="media-body text-center ">
		<p>MISC STATS</p>
		</div>
		</div>
		</a>
		</div>

		<div class="col-xs-3">
		<a class="ko2menu" href="about.php">
		<div class="media">
		<div class="media-body text-center ">
		<p>ABOUT</p>
		</div>
		</div>
		</a>
		</div>

		</div>

		<div class="row row-content">
		<div class="col-xs-12">		
		&nbsp;
		</div>
		</div>
		
		
		<div class="col-xs-3 col-xs-offset-3">
		<a class="ko2menu" href="hof.php">
		<div class="media">
		<div class="media-body text-center ">
		<p>HALL OF FAME</p>
		</div>
		</div>
		</a>
		</div>

		<div class="col-xs-3">
		<a class="ko2menu" href="thelob.php">
		<div class="media">
		<div class="media-body text-center ">
		<p>THE LOB</p>
		</div>
		</div>
		</a>
		</div>

		<div class="col-xs-3">
		<a class="ko2menu" href="http://ko-gathering.com/forum">
		<div class="media">
		<div class="media-body text-center ">
		<p>FORUM</p>
		</div>
		</div>
		</a>
		</div>
		
		
		</div>		
    </div>
	
	
	<?php
include 'footer.inc';
?>			

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
</body>

</html>