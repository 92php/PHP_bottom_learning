<?php


$a = 3;
$b = 4.321;
$c = "hello";

/**
生成了3个结构体
同时，全局符号表中，多了3条记录

a-----> 0x123  -----> 结构体{3}
b-----> 0x215  -----> 结构体{4.321}
a-----> 0x3a0  -----> 结构体{hello}

*/


