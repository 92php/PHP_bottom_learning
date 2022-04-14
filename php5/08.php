<?php




$age = 29;
function t(){
	$age = 3;
	echo $age;
}
t(); //3



function t2(){
	$a = "world";
	echo $a;
}

function t1(){
	$a = "hello";
	echo $a;
	t2();
}

t1(); //helloworld



