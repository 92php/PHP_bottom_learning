<?php


$a = 3;
$b = $a;


/**
是否产生了两个结构体？？？

并没有再次产生结构体,而是2个变量共用1个结构体

$a = 3   ======>   zvalue:3
                   type:IS_LONG
				   refcount_gc:1
				   is_ref_gc:0

$b = $a  ======>   zvalue:3		
                   type:IS_LONG
				   refcount_gc:2
				   is_ref_gc:0		
				
*/

$b = 5;

/**
$a  =====>  zvalue:3
            type:IS_LONG
			refcount_gc:1
			is_ref_gc:0

$b =======> zvalue:5
            type:IS_LONG
			refcount_gc:1
			is_ref_gc:0

*/


echo $a,$b;  //3,5


