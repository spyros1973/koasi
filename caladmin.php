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
		<script type="text/javascript">

function validate_required(field,alerttxt)
{
	
with (field) {
	if (value==null||value=="")
  		{alert(alerttxt);return false;}
	else {return true;}
	}
}

function CheckForm(thisform) {

	with (thisform) {
		if (validate_required(name,'Please enter the tournament name')==false) {
			name.focus();
			return false;
		}				
		if (validate_required(place,'Please enter the tournament description')==false) {
			place.focus();
			return false;
		}				
		if (validate_required(country,'Please enter the tournament country')==false) {
			country.focus();
			return false;
		}				
		if (validate_required(date,'Please enter the tournament date')==false) {
			date.focus();
			return false;
		}				
		if (validate_required(weblink,'Please enter the tournament information link')==false) {
			weblink.focus();
			return false;
		}				
		if (validate_required(organiser,'Please enter the tournament organiser')==false) {
			organiser.focus();
			return false;
		}				
		return true;
	}
}
		
		</script>
	</head>

	<body>
		
		<div id="container">
			
<?php include 'headnav.inc'; ?>
			
			<div id="content">
				<h2>Tournament calendar administration page</h2>

			<?php 
      
      
      function getDateTime($str) {
      	$d=substr($str,7,4);
      	for ($i=1; $i<13; $i++) {
      		//echo "Checking if ".date("M",mktime(0,0,0,$i,1,1))." = ".substr($str,3,3)."<br/>";
      		if ((date('M',mktime(0,0,0,$i,1,1))) == substr($str,3,3)) {
      			$d=$d.'-'.$i;
      			exitfor; 
      		}      			
      	} 
      	$d=$d.'-'.substr($str,0,2);
      	return $d;
      }
        
      $action="";
      $id="";

      if (isset($_GET['action'])) $action=strtolower($_GET['action']);
      if (isset($_GET['id'])) $id=intval($_GET['id']);
      dbOpen();
      if (($action=="delete") && ($id!="")) {
        $sql="delete from calendar where calendarid=".$id;
        mysql_query($sql);
      }  
      
      if (($action=="add") || ($action=="edit")) {
		  echo '&nbsp;<br/>';
		  echo '<div><b>';
		  echo (($action=="add")?"Add a new":"Edit")." tournament</b><br/>";
		  echo '<form name="tourney" onsubmit="return CheckForm(this)";>';
		  
		  if (($action=="edit")) {
			$sql="select name, place, country, date, federation, organiser, winner, link, comment from calendar where calendarid=".$id;
			$result=mysql_query($sql);
			$row=mysql_fetch_array($result, MYSQL_ASSOC);
			extract($row);
		  }
		  
		  echo '<table>';
		  
		  echo '<tr><td>Name:</td><td><input type="text" name="name" style="width:180px; border-style: dotted; border-width: 1px;" maxlength="50" value="'.(($action=="add")?'':$name).'"></td></tr>';
		  echo '<tr><td>Description:</td><td><input type="text" name="place" style="width:180px; border-style: dotted; border-width: 1px;" maxlength="50"  value="'.(($action=="add")?'':$place).'"></td></tr>';
		  echo '<tr><td>Country:</td><td><input type="text" name="country" style="width:180px; border-style: dotted; border-width: 1px;" maxlength="50"  value="'.(($action=="add")?'':$country).'"></td></tr>';
		  echo '<tr><td>Date:</td><td><input type="text" name="date" readonly="readonly" style="width:100; border-style: dotted; border-width: 1px;" maxlength="11" value="';
		  if ($action=="add")  echo date('d/M/Y');
		  	  else echo date("d/M/Y",strtotime($date));
		  echo '";><input type="button" value="pick date" style="font-size: 6px"; onclick="scwShow(document.forms[0].date,event);"></td></tr>';
		  echo '<tr><td>Web link:</td><td><input type="text" name="weblink" style="width:100%; border-style: dotted; border-width: 1px;" maxlength="255"   value="'.(($action=="add")?'':$link).'"></td></tr>';
		  echo '<tr><td>Federation:</td><td><input type="text" name="federation" style="width:180px; border-style: dotted; border-width: 1px;" maxlength="50"   value="'.(($action=="add")?'':$federation).'"></td></tr>';
		  echo '<tr><td>Organiser:</td><td><input type="text" name="organiser" style="width:100px; border-style: dotted; border-width: 1px;" maxlength="30"   value="'.(($action=="add")?'':$organiser).'"></td></tr>';
		  echo '<tr><td>Winner:</td><td><input type="text" name="winner" style="width:100px; border-style: dotted; border-width: 1px;" maxlength="30"   value="'.(($action=="add")?'':$winner).'"></td></tr>';
		  echo '<tr><td>Comment:</td><td><input type="text" name="comment" style="width:100%; border-style: dotted; border-width: 1px;" maxlength="100"   value="'.(($action=="add")?'':$comment).'"></td></tr>';
		  echo '<tr><td colspan=2><input type="submit" style="width:200; border-style: solid; border-width: 2px; float: right" value="Submit"></td></tr>';
		  echo '<input type="hidden" name="action" value="'.$action.'rec">';
		  echo '<input type="hidden" name="id" value="'.$id.'">';
		  echo '</table></form></div>';
      }
      
      if ($action=="addrec") {
      	extract ($_GET);
      	$sql="insert into calendar (name, place, country, winner, link, `date`, organiser, federation,comment) values (";
      	$sql=$sql."'".$name."','".$place."','".$country."','";
      	$sql=$sql.$winner."','".$weblink."','".getDateTime($date)."','".$organiser."','".$federation."','".$comment."')";
	
      	mysql_query($sql);
      	echo '<script>window.location="caladmin.php";</script>';      	
	  }            

      if ($action=="editrec") {
      	extract ($_GET);
      	$sql="update calendar set name='".$name."',place='".$place."',country='".$country."',winner='";
      	$sql=$sql.$winner."',link='".$weblink."',`date`='".getDateTime($date)."',comment='".$comment."', organiser='".$organiser."', federation='".$federation."' where calendarid=".$id;
	    	mysql_query($sql);
	    	echo '<script>window.location="caladmin.php";</script>';
	  }            

    
      echo "<table><tr><th>#</th><th>Tournament</th>";
      echo "<th>Description</th><th>Country</th><th>Date</th><th>Infolink</th><th>Winner</th><th style='text-align:center'>edit</th><th style='text-align:center'>-</th></tr>";
    
      $sql="select calendarid, name, winner, country, link, `date`, place from calendar order by date desc";
      $result=mysql_query($sql);
      $i=0;
      while ($row=mysql_fetch_array($result, MYSQL_ASSOC)) {
          extract ($row);
          $i++;
          echo "<tr><td>".$i."</td><td>".$name."</td><td>".$place."</td><td>".$country."</td><td>".date("j/m/Y", strtotime($date))."</td><td><center><a href='".$link."'><img src='images/info.gif'/></a></center></td><td>".(($winner!='')?$winner:"&nbsp;")."</td>";
          
          echo '<td><a href="caladmin.php?action=edit&id='.$calendarid.'">edit</a></td>';
          echo '<td><a href="caladmin.php?action=delete&id='.$calendarid.'" onclick="return confirm';
          echo "('Please confirm');";
          echo '">delete</a></td></tr>';

          }        
        echo "</table><br/>";


        dbClose();
        ?>
<br/>

      </div>

			<div id="news">
				<h2>Administration</h2>

				<p>
       <a href="caladmin.php?action=add">Add a new tournament</a>
        </p>		
        </div>


<?php
include 'footer.inc';
?>			
		</div>
		
	</body>

</html>
