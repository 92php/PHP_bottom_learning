<?php

//���ø�ֵ���ص�

$a = 3;
$b = &$a;

/**
�Ƿ�����������ṹ�壿����

��û���ٴβ����ṹ��,����2����������1���ṹ��

$a = 3   ======>   zvalue:3
                   type:IS_LONG
				   refcount_gc:1
				   is_ref_gc:0

$b = &$a  ======>   zvalue:3		
                   type:IS_LONG
				   refcount_gc:2
				   is_ref_gc:1		
	
$b = 5  
�ṹ��û�з��ѣ����ǹ���һ���ṹ��
				   zvalue:5	
                   type:IS_LONG
				   refcount_gc:2
				   is_ref_gc:1	

	
*/

$b = 5;


echo $a,$b;  //5,5


