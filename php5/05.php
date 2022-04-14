<?php

//强制分裂

$a = 3;
/**
{
zvalue:3
type:IS_LONG
refcount_gc:1
is_ref_gc:0
}
*/
$b = $a;
/**
{
zvalue:3
type:IS_LONG
refcount_gc:2
is_ref_gc:0
}
*/
$c = &$a;
/**
不会是这样变，否则，$b,将会干扰
{
zvalue:3
type:IS_LONG
refcount_gc:3
is_ref_gc:1
}

//如果is_ref_gc 0->1的过程中，refcount_gc>1,将会强制分裂
b 分裂一份结构体
{
zvalue:3
type:IS_LONG
refcount_gc:1
is_ref_gc:0
}
a,c 共用一份结构体
{
zvalue:3
type:IS_LONG
refcount_gc:2
is_ref_gc:1
}
*/


$c = 5;


echo $a,$b,$c;  //5,3,5


