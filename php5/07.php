<?php

//数组在php5时候慎用&



//php7   
/*$arr = array(4,1,2,3);

foreach ($arr as $key => $value) {
	
}

var_dump(current($arr)); //int(4)*/

/*$arr = array(5,1,2,3);

foreach ($arr as $key => $value) {
	$arr[$key] = $value;
}

var_dump(current($arr)); //int(5)*/

$arr = array('a','b','c','d');
foreach ($arr as $key => &$value) {
	
}
foreach ($arr as $k => $v) {
	print_r($arr);
}

/*Array
(
    [0] => a
    [1] => b
    [2] => c
    [3] => d
)
Array
(
    [0] => a
    [1] => b
    [2] => c
    [3] => d
)
Array
(
    [0] => a
    [1] => b
    [2] => c
    [3] => d
)
Array
(
    [0] => a
    [1] => b
    [2] => c
    [3] => d
)*/


