<?php


$a = 3;

/**
һ���ṹ�������
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
���Կ�������PHP�У��ַ����ĳ�����ֱ����������ṹ���еģ�strlen���ٶȷǳ��죬ʱ�临�Ӷ�ΪO(1)
*/
