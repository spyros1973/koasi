<div class="page-header">
<div class="jumbotron">
			</div>			
 <nav class="navbar navbar-inverse" role="navigation">
 
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>                
            </div>

            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="<?php echo ($page == 'home' ? 'active' : '')?>">
					<a href="index.php"><span class="glyphicon glyphicon-home"
                         aria-hidden="true"></span> Home</a></li>
                    <li class="<?php echo ($page == 'rankings' ? 'active' : '')?>"><a href="rankings.php">
                        Rankings
                    </a></li>
                    <li class="<?php echo ($page == 'players' ? 'active' : '')?>"><a href="players.php">
                        Players
                    </a></li>
                    <li class="<?php echo ($page == 'tournaments' ? 'active' : '')?>"><a href="tournaments.php">
                        Tournaments
                    </a></li>
                    <li class="<?php echo ($page == 'worldcups' ? 'active' : '')?>"><a href="worldcups.php">
                        World Cups
                    </a></li>
                    <li class="<?php echo ($page == 'misc' ? 'active' : '')?>"><a href="misc.php">
                        Misc statistics
                    </a></li>
                    <li class="<?php echo ($page == 'about' ? 'active' : '')?>"><a href="about.php">
                        About
                    </a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>