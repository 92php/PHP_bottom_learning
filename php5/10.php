<?php




class Dog {
	public $name = "huzi";

	public function __toString()
	{
		return $this->name;
	}
}

$dog = new Dog();

define('DOG', $dog);

print_r(DOG); //huzi

define('~_~', 'laguh');
var_dump(defined('~_~'));//bool(true)
echo constant('~_~'); //laguh



