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
$page="rankings";
include 'header.inc';

?>   
   <div class="row row-content">
            <div class="col-xs-8 col-md-7 col-md-offset-1">
        
<?php
function GetMonthStr() {
  if (isset($_GET["month"])) {
      $s=strtolower($_GET["month"]);
      $mon="";
      $yr=substr($s,strlen($s)-2);
      for ($i=1; $i<13; $i++) {
        if (strtolower(substr($s,0,strpos($s,' ')))==strtolower(date('F', mktime(0,0,0,$i)))) {
          $mon=$i;          
        }
      }      
    } else return GetLastMonth();
    if ($mon=="") return GetLastMonth();
      else {  
        if (strlen($mon)<2) $mon="0".$mon;
        return "r".$mon.$yr;
      }
}

function GetLastMonth() {
  $lastMonth="0000";
  $val=0;
  $result = runQuery("select * from rankings where player='0'");
  
  for ($i=0; $i<mysqli_num_fields($result); $i++) {
    $s=strtoupper(mysqli_fetch_field_direct($result, $i)->name);

    if (($s!="R") && ($s!="PLAYER") && ($s!="COUNTRY") && ($s!="FIRSTPLAYED") && ($s!="ACTIVITY") && ($s!="ADDRESS") && ($s!="PROFILE")) {
    $val=(int)substr($s,1,2) + 12* (int)substr($s,3,2);
    
    if ($val > ((int)substr($lastMonth,1,2) + 12* (int)substr($lastMonth,3,2))) {
      $lastMonth=$s;
      }
    }
  }
  return strtolower($lastMonth);
}

dbOpen();
$month=GetMonthStr();
$country="";
$rownum=30;
$rowstart=0;
if (isset($_GET['rowstart'])) $rowstart=$_GET['rowstart'];
if (isset($_GET['country'])) {
  $country=$_GET['country'];
  if (strtolower($country)=="(all)") $country="";
  } 
if (isset($_GET['rowsperpage'])) $rownum=$_GET['rowsperpage'];
if (strtolower($rownum)=="(all)") $rownum=1000;
if (intval($rownum)==0) $rownum=30;
if ($rownum<0) $rownum=0;
if ($rowstart<0) $rowstart=0;
if (intval($rowstart)==0) $rowstart=0;


$prevMonth="r1007";
$rankLimit=1;
If ($prevMonth == "R1001") $prevMonth = "";

//sTmp = "01/" & Mid(sMonth, 2, 2) & "/" & Mid(sMonth, 4, 2)
//dTmp = DateAdd("m", -1, sTmp)
//sTmp = "R" & Format(dTmp, "mmyy")
//sPrevMonth = sTmp
//$resultPrev=mysql_query("select ".$prevMonth." from rankings");    

$sql = "select player, ".$month.", country from rankings where ".$month." <>-1";
$sqlWhere="";
if ($rankLimit) {
  $sqlWhere = " and (select count(player) from `tables` where player=rankings.player)  > 1 and activity<=36 ";
  }

if ($country!="") {
  $sqlWhere=$sqlWhere." and country='".$country."'";
  }

$sql=$sql.$sqlWhere." order by ".$month." desc";
$sql=$sql." limit ".$rowstart.",".$rownum;

$monthstr=date('F',mktime(0,0,0,(int)substr($month,1,2)))." 20".substr($month,3,2);
echo "<h2>Rankings for ".$monthstr."</h2>";
echo "<table class='table table-striped table-condensed'><thead><tr><th width=10%>Pos</th><th >Player</th>";
echo "<th >Country</th><th>Points</th></tr></thead><tbody>";

$i=$rowstart;
$result = runQuery($sql);

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $i++;
    if (fmod($i,2)==0) echo "<tr class='d0'>";
      else  echo "<tr class='d1'>";
    echo "<td>".$i."</td>";
    echo '<td><a href="players.php?player='.$row['player'].'">'.$row['player'].'</a></td>';

    if ($SHOWFLAGS) echo "<td><img src='flags/".$row['country'].".jpg'/></td>";
    else
    echo "<td>".$row['country']."</td>";

    echo "<td>".$row[$month]."</td>";
    echo "</tr>";
}

//mysql_free_result($result);

echo "</tbody></table>";
if ($rownum!=1000) {
$val=date('F',mktime(0,0,0,(int)substr($month,1,2)))." 20".substr($month,3,2);
echo '<div id="navfoot"><a href="rankings.php?rowsperpage='.$rownum.'&country='.$country.'&month='.$val.'">First</a>';
echo ' | <a href="rankings.php?rowsperpage='.$rownum.'&rowstart='.($rowstart-$rownum).'&country='.$country.'&month='.$val.'">Previous</a>';
echo ' | <a href="rankings.php?rowsperpage='.$rownum.'&rowstart='.($rowstart+$rownum).'&country='.$country.'&month='.$val.'">Next</a>';
echo '</div>';
//echo ' | Last';
}


?>
</div>

 <div class="col-xs-4 col-sm-3 " >
				<h3>Filter rankings</h3>
				
				<form><div class="form-group">
				<label for="month">Month:</label><br/>
				<select name="month" id="month"style="width: 100%" class="form-control">
        <?php        
        //$lastMonth=strtoupper(GetLastMonth());

        $result = runQuery("select * from rankings where player='0'");
        for ($i=0; $i<mysqli_num_fields($result); $i++) {
          $s=strtoupper(mysqli_fetch_field_direct($result, $i)->name);
      
          if (($s!="R") && ($s!="PLAYER") && ($s!="COUNTRY") && ($s!="FIRSTPLAYED") && ($s!="ACTIVITY") && ($s!="ADDRESS") && ($s!="PROFILE")) {
            $val=date('F',mktime(0,0,0,(int)substr($s,1,2)))." 20".substr($s,3,2);     
            echo "<option";
            echo (($s==strtoupper($month))?" selected ":"");
            echo ">";
            echo $val;
            echo "</option>";
            }
          }

        ?>

        </select>
		
				<label for="country">Country:</label><br/>
				<select name="country" id="country" style="width: 100%" class="form-control">
				<option selected>(all)</option>
        <?php
        $result = runQuery("select country from countries order by country");
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          if ($row['country']!='WC') {
            echo "<option ";
            echo (($country==$row['country'])?" selected >":">");          
            echo $row['country']."</option>";
            }
          }
          dbClose();
        ?>
        
        </select>
		
        <label for="rowsperpage">No of rows:</label><br/>
        <select name="rowsperpage" id="rowsperpage" style="width:100%" class="form-control">    
        <?php
        $vals=array("10","20","30","50","(all)");
        $s=$rownum;
        if ($s==1000) $s="(all)";
        for ($i=0; $i<5; $i++) {
        echo $vals[$i];
          echo "<option".(($s==$vals[$i])?" selected ":"").">".$vals[$i]."</option>"; 
        }    
        

        ?>
        </select>
        
        <input type="submit" class="btn btn-primary" value="Filter"/>
        <br/>
 </div>
        </form>
        
				
			</div>
			
			</div>

<?php
include 'footer.inc';
?>			
		</div>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>		
	</body>

</html>
