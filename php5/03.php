<?php


$a = 3;
$b = $a;


/**
�Ƿ�����������ṹ�壿����

��û���ٴβ����ṹ��,����2����������1���ṹ��

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


