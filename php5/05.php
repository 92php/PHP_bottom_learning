<?php

//ǿ�Ʒ���

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
�����������䣬����$b,�������
{
zvalue:3
type:IS_LONG
refcount_gc:3
is_ref_gc:1
}

//���is_ref_gc 0->1�Ĺ����У�refcount_gc>1,����ǿ�Ʒ���
b ����һ�ݽṹ��
{
zvalue:3
type:IS_LONG
refcount_gc:1
is_ref_gc:0
}
a,c ����һ�ݽṹ��
{
zvalue:3
type:IS_LONG
refcount_gc:2
is_ref_gc:1
}
*/


$c = 5;


echo $a,$b,$c;  //5,3,5


