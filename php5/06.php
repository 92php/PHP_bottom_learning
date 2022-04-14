<?php

/*$arr = array(0,1,2,3);
$temp = $arr;

$arr[1] = 11;

echo $temp[1];  //1
*/

/*$arr = array(0,1,2,3);
$temp = $arr;

$x = &$arr[1];
$arr[1] = 999;

echo $temp[1]; //1*/

$arr = array(0,1,2,3);
$x = &$arr[1];
$temp = $arr;

$arr[1] = 999;
echo $temp[1]; //999


