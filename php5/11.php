<?php



class Dog {
	public $leg = 4;
	public $wei = 20;
}

$dog = new Dog();
//问 $dog是一个对象吗？
/*
{
	handle---指向---》[hash表{leg:4,wei:20}]
}
*/

$d2 = $dog;
$d2->leg = 5;

echo $dog->leg; //5
echo $d2->leg; //5

$d2 = false;
echo $dog->leg; //5



