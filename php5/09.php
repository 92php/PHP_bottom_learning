<?php




/*function t(){
	$age = 1;
	return $age +=1;
}

echo t(); //2
echo t(); //2
echo t(); //2*/

function t(){
	static $age = 1;
	return $age +=1;
}

echo t(); //2
echo t(); //3
echo t(); //4



