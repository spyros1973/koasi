<?php
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="KOASI"');
    header('HTTP/1.0 401 Unauthorized');
    echo "Please enter the admin's user name and password";
    exit;
} else {
   $usr=$_SERVER['PHP_AUTH_USER'];
   $pwd=$_SERVER['PHP_AUTH_PW'];
   if (!(($user="garry") && ($pwd=="koalegend"))) {
   echo "Wrong credentials. Please try again.";
   exit;
   } 

include 'support/db.inc';    
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
	 <script type='Text/JavaScript' src='scw.js'></script> 
		<meta http-equiv="Content-type" content="text/html; charset=ISO-8859-1" />

	</head>

	<body>
		
		<div id="container">
			
<?php include 'headnav.inc'; ?>
			
			<div id="content">
				<h2>Players' info</h2>

			<?php 
            
      dbOpen();
      $country="";
      if (isset($_GET['country'])) $country=$_GET['country'];

      if (strtolower($country)=="(all)") $country="";

	  $i=0;
	  foreach($_GET as $variable => $value) {
	  	if ((strtolower($variable)!="country") && $value!="" ){
	  		$pl="";
	  		for ($n=0; $n<strlen($variable); $n++) {
	  			if (substr($variable,$n,1)=="_") $pl=$pl." ";
	  				else $pl=$pl.substr($variable,$n,1);
	  				
			}
			$sql="update rankings set address='".$value."' where player='".$pl."'";
			mysql_query($sql);
			$sql="update added_players set address='".$value."' where player='".$pl."'";
			mysql_query($sql);
			$i++;
		}		
	  }

      echo "<form name='players'>";
      echo "<table><tr><th>#</th><th>Name</th>";
      echo "<th>Country</th><th>Address</th></tr>";
    
      $sql="select player, country, address from rankings";
      if ($country!="") $sql=$sql." where country='".$country."' ";
      $sql=$sql." order by player";
      $result=mysql_query($sql);
      $i=0;
      while ($row=mysql_fetch_array($result, MYSQL_ASSOC)) {
          extract ($row);
          $i++;
          echo "<tr><td>".$i."</td><td>".$player."</td><td>".$country."</td><td><input type='text' name='".$player."' value='".$address."' style='width:100%;border-style: dotted; border-width: 1px;' maxlength='255'/></td></tr>";          
          }
        echo "</table><br/>";
		echo "<input style='float:right' type='submit' value='Submit' />";
        dbClose();
        ?>
<br/>
		</form>
      </div>

		<div id="news">
        <h2>Player filter</h2>
		  <form name="filter">        
        
        <p> ByCountry:</br>
        
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
          dbClose();
        ?>
				</select>
        <br/>&nbsp;<br/>
        <input type="submit" value="Filter"/><br/>
        </p>
		  </form>	
			</div>
      


<?php
include 'footer.inc';
?>			
		</div>
		
	</body>

</html>
