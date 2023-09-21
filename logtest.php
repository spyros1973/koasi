<?php
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    echo "Please enter the admin's user name and password";
    exit;
} else {
   $usr=$_SERVER['PHP_AUTH_USER'];
   $pwd=$_SERVER['PHP_AUTH_PW'];
   if !($user="1" && $pwd=="1") {
   exit;
   } 
   
}
?>


<!DOCTYPE html
 PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>
		<title>KOASI!</title>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<link rel="stylesheet" href="print.css" type="text/css" media="print" />
		<meta http-equiv="Content-type" content="text/html; charset=ISO-8859-1" />
	</head>

	<body>
		
		<div id="container">
			
<?php include 'headnav.inc'; ?>
			
			<div id="content">
				<h2>Tournament calendar</h2>

				<?php 
        include 'db.inc';
        
        $country="";
        $date="";
        
        dbOpen();
        
        
    
      echo "<table><tr><th>#</th><th>Tournament</th>";
      echo "<th>Place</th><th>Country</th><th>Date</th><th>Infolink</th><th>Winner</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr>";
    
        $sql="select name, winner, country, link, date, place from calendar order by date desc";
        $result=mysql_query($sql);
        $i=0;
        if ($row=mysql_fetch_array($result, MYSQL_ASSOC)) {
          extract ($row);
          $i++;
          echo "<tr><td>".$i."</td><td>".$name."</td><td>".$place."</td><td>".$country."</td><td>".date("j/m/Y", strtotime($date))."</td><td><a href='".$link."'><img src='info.gif'/></a></td><td>".(($winner!='')?$winner:"&nbsp;")."</td>";
          echo '<td><a href="caladmin.php?action=add">add</a></td>';
          echo '<td><a href="caladmin.php?action=edit&id='.$calendarid.'">add</a></td>';
          echo '<td><a href="caladmin.php?action=delete&id='.$calendarid.'">add</a></td></tr>';

          }        
        echo "</table>";
        dbClose();
        ?>
<br/>
<div id="navfoot"><a href="caladmin.php">Show calendar admin panel</a></div>

      </div>
      
      
      


<?php
include 'footer.inc';
?>			
		</div>
		
	</body>

</html>
