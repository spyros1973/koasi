<?php
// Add values to the graph

$maxVal=0;
$graphType=1;
$imgWidth=320;
$imgHeight=240;
$fontSize=3;


// 0=bar, 1=line 
$values = $_GET['values'];
$labels=$_GET['labels'];
$graphValues=explode(",",$values);
$graphLabels=explode(",",$labels);
$mode=$_GET['mode'];

if (isset($_GET['maxval'])) $maxVal=$_GET['maxval'];
if (isset($_GET['height'])) $imgHeight=$_GET['height'];
if (isset($_GET['width'])) $imgWidth=$_GET['width'];
if (isset($_GET['graphtype'])) $graphType=$_GET['graphtype'];



if (($imgWidth>320) && ($imgHeight>200)) $fontSize++;

// Define .PNG image
header("Content-type: image/png");
header("Expires:0");
$offX=24;
$offY=44;
$steps=count($graphValues);
$zoomW=($imgWidth-$offX) / $steps;
$zoomH=($imgHeight-$offY) /$steps;
$i=max($graphValues);
if ($maxVal<$i) $maxVal=$i;

$maxVal*=1.2;
$valFactor=($imgHeight-$offY)/($maxVal);


// Create image and define colors
$image=imagecreate($imgWidth+1, $imgHeight+1);
$colorWhite=imagecolorallocate($image, 255, 255, 255);
$colorGrey=imagecolorallocate($image, 192, 192, 192);
$colorBlue=imagecolorallocate($image, 0, 0, 255);
$colorBlack=imagecolorallocate($image, 0, 0, 0);

// Create border around image
imagerectangle($image,$offX,0,$imgWidth, $imgHeight-$offY, $colorGrey);

//labels
//input - dependant

if ($mode==0) { //player progress
for ($i=1000; $i<=5000; $i+=1000) {
  
  if (($imgHeight - ($i * $valFactor))<$imgHeight) imagestring($image,$fontSize,0,$imgHeight - ($i * $valFactor) - $offY,(strval($i/1000))."k",$colorBlue);
  }
for ($i=500; $i<=5000; $i+=250) {
  imagestring($image,$fontSize,$offX - 4,$imgHeight - ($i * $valFactor) - $offY,"-",$colorBlue);   
  }
for ($i=0; $i<$steps; $i++) {
  $s=substr($graphLabels[$i],0,2)."/20".substr($graphLabels[$i],2,2);
  if (substr($s,0,2)=="01") {
  imageline($image,$offX+$i*$zoomW,$imgHeight-$offY-$fontSize,$offX+$i*$zoomW,$imgHeight-$offY+2,$colorBlue);
  imagestringup($image,$fontSize,-4+$offX + $i*$zoomW,$imgHeight  ,substr($s,3),$colorBlue);
}
}
}


// Create grid

for ($i=0; $i<$steps; $i+=($steps/4)){
imageline($image, $offX+($i*$zoomW), 0,$offX+( $i*$zoomW ), $imgHeight, $colorGrey);
imageline($image, $offX, $i*$zoomH, $imgWidth, $i*$zoomH, $colorGrey);
}

// Add in graph values

switch ($graphType) {
  case 0:
    for ($i=0; $i<$steps; $i++) {
      imagerectangle($image, $offX+ ($i * $zoomW), $imgHeight-($graphValues[$i]*$valFactor), $offX + ($i * $zoomW + $zoomW),$imgHeight, $colorBlue);  
      imagefilledrectangle($image,$offX + 1+ ($i * $zoomW), $imgHeight-($graphValues[$i] * $valFactor)+1, $offX + ($i * $zoomW + $zoomW)-1,$imgHeight, $colorGrey);
    }
    break;
  case 1:
     for ($i=1; $i<$steps; $i++) {
      imageline($image,$offX+ ($i-1) * $zoomW, $imgHeight-($graphValues[$i-1]*$valFactor) - $offY,$offX + ($i*$zoomW),$imgHeight-($graphValues[$i]*$valFactor) - $offY,$colorBlue);      
    }
    break;

}

//overwrite labels in wc stats graphs
if ($mode==1) { //wc stats
for ($i=0; $i<$steps; $i++) {
  $s=$graphLabels[$i];

  //imageline($image,$offX+$i*$zoomW,$imgHeight-$offY,$offX+$i*$zoomW,$imgHeight-$offY+4,$colorBlue);
  imagestringup($image,$fontSize+1,4+$offX + $i*$zoomW,$imgHeight-(4*$fontSize) +2*$fontSize  ,$s,$colorBlack);
}

for ($i=($maxVal/10); $i<=$maxVal; $i+=($maxVal/5)) {  
  if (($imgHeight - ($i * $valFactor))<$imgHeight) imagestring($image,$fontSize,4,$imgHeight - ($i * $valFactor)  ,(strval(floor($i)))."",$colorBlue);
}
      
}


// Output graph and clear image from memory
imagepng($image);
imagedestroy($image);
?>
