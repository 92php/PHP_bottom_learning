<?php


$a = 3;

/**
一个结构体产生了
{
	union_zvalue {long 3}
	type:IS_LONG
	refcount_gc:1
	is_ref_gc:0
}
*/


$b = "hello";
/**
{
	{
		char:"hello"
		len:5
	}
	type:IS_STRING
	refcount_gc:1
    is_ref_gc:0
}
可以看出，在PHP中，字符串的长度是直接体现在其结构体中的，strlen的速度非常快，时间复杂度为O(1)
*/
