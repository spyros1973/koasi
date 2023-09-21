<?php
include "support/db.inc";
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
$month=GetLastMonth();
$sql = "select player, ".$month.", country from rankings where ".$month." <>-1 ";
$sqlWhere = " and (select count(player) from `tables` where player=rankings.player)  > 1 and activity<=36 order by ".$month." desc";

$result = runQuery($sql.$sqlWhere);
header('Content-Type: text/plain');
echo "[code]\n";
echo "  R        Player       Country  Points\n";
$i=0;

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $i++;	
	printf("%3.2s", $i);
	printf("%14.13s", $row['player']);
	printf("%15.14s", $row['country']);
	printf("%7.6s\n", $row[$month]);
}
echo "[/code]";  
dbClose();
?>