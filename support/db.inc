<?php
$SHOWFLAGS=1;
date_default_timezone_set('UTC');
error_reporting(E_ALL);
include "secrets.inc";
 
function dbOpen() {  
	global $conn;
	//$_server, $_user,$_pass,$_database are defined in secrets.inc
	$conn = mysqli_connect($_server, $_user,$_pass,$_database);
    if (!$conn) {
      die('Could not connect: ' . mysqli_error());
    }    
}

function runQuery($sql) {
	global $conn;
	return mysqli_query($conn,$sql);
}

function dbClose() {
  global $conn;
  if (isset($conn)) mysqli_close($conn);
}

function getFirstRec($sql) {
  global $conn;
  $res=mysqli_query($conn,$sql);
  $rec=mysqli_fetch_row($res);
  return ($rec[0]);   
}

function escapeString($str) {
	global $conn;
	return mysqli_real_escape_string($conn,$str);
}
?>
