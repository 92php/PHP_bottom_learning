# 全方位深度剖析PHP7底层源码   


第1章 课程介绍  
    1-1 课程整体介绍  
        php7新特性   
        php7性能基准测试，与php5性能对比   
        php7中新的语法特性  
		基础变量与内存管理   
		   zval的基本结构   
		   字符串（zend_string）   
		   引用类型（zend_reference）   
		   数组类型（zend_array/HashTable）   
		   small/large/huge内存  
		   内存对齐  
		   内存类型标记  
		php运行的生命周期   
		   cli模式   
		   fpm模式   
		   fastcgi协议   
		   网络编程/信号/多进程编程    
		php代码的编译与执行     
		   词法/语法分析基本原理    
		   抽象语法树（AST）    
		   zend虚拟机   
		   执行过程    
		基本语法实现的细节    
		   各类基础语法的实现    
		php扩展的编写     
		   手把手编写一个php扩展，理论用于实践    
	   
第2章 PHP7的新特性    
    2-1 带你编译和安装PHP7   
	   php7的编译安装   
	   下载 http://php.net/releases/   
	   tar -zxvf php-7.1.0.tar.gz   
	   cd php-7.1.0    
	   
	   ./configure -h > test  //输出到test   
	   vim test   
	   
	   ./configure --prefix=/home/codes/php/php-7.1.0/output/ --enable-fpm --enable-debug   
	   make   
	   make install   
	   
	   cd output/   
	   cd sbin  //里面有php-fpm目录，默认是没有这个sbin目录   
	   
	   cd bin/   //php可执行目录   
	   
	   
	   cd php-7.1.0/Zend/   
	   vim bench.php   
	   
	2-2 如何要对PHP7与PHP5进行性能对比    
	   ./php-7.1.0/bin/php  php-7.1.0/Zend/bench.php   
	   vim php-7.1.0/Zend/micro_bench.php   

	2-3 PHP7有哪些新特性    

	   太空船操作符，用于比较两个表达式   
	   echo 1<=>1;  //0   
	   echo 1<=>0;  //1   
	   echo 1<=>2;  //-1     

       类型声明    
       declare(strict_types=1);  //strict_types=1表示开启严格模式   
       function sumOfInts(int ...$ints):int{ 
       	  return array_sum($ints);  
       }  

       null合并操作符   
       $page = isset($_GET['page'])?$_GET['page']:0;   
       $page = $_GET['page']??0;   

       常量数组   
         define('ANIMALS',['dog','cat','bird']);   

       namespace批量导入   
         use Space\{ClassA,ClassB,ClassC as C};   
		
	  throwable接口   
	    try{   
	    	undefindfunc();   
	    }catch(Error $e){   
	    	var_dump($e);   
	    }	   

	    set_exception_handler(  
	    	function($e){   
	    		var_dump($e);  
	    		});  
	    undefindfunc();   
	    
	   Closure::call()   
	   class Test{   
	   	  private $num = 1;  
	   }   
	   $f = function(){  
	   	  return $this->num+1;  
	   }  
	   echo $f=>call(new Test);  //2   


	   intdiv函数   
	     intdiv(10,3);   //3   

	   list的方括号写法   
	     $arr = [1,2,3];   
	     list($a,$b,$c) = $arr;  
	     var_dump($a,$b,$c);//1,2,3   

	     $arr = [1,2,3];   
	     [$a,$b,$c] = $arr;   
	     var_dump($a,$b,$c);//1,2,3   

	   抽象语法树（AST）   
	     
		 ($a)['b'] = 1;   
		 var_dump($a);   
		 //array(1){["b"]=>int(1)}   

第3章 基本变量与内存管理机制   
    3-1 什么是小而巧的zval   
      定义，是一个结构体,大小16字节  
      struct_zval_struct{  
		zend_value   value;   
		union u1;  
		union u2;  
      }  
      value又是一个联合体   
      typedef union_zend_value{  
		zend_long  lval;  //整型  
		double   dval;    //浮点型  
		zend_refcounted *counted;  
		zend_string *str;  //字符串  
		zend_array *arr;   //数组  
		zend_object *obj;   //对象  
		zend_resource *res; //资源类型  
		zend_reference *ref; //引用类型  
		zend_ast_ref *ast;   
		zval  *zv;  
		viod *ptr;  
		zend_class_entry *ce; //类  
		zend_function *func;  //函数  
		...
  	  }zend_value;  

  	  u1和u2   
  	  union{  
 		stuct{  
			ZEND_ENDIAN_LOHI_4(  
				zend_uchar type, //类型  
				zend_uchar type_flags,  
				zend_uchar const_flags,  
				zend_uchar reserved  
			)  
 		}v;  
 		uint32_t type_info;  
  	  }u1;  
  	  union{  
		uint32_t next;  
		uint32_t cache_slot; 
		uint32_t lineno;  
		uint32_t num_args;  
		uint32_t fe_pos;  
		uint32_t fe_iter_idx;  
		uint32_t access_flags;  
		uint32_t property_guard;  
  	  }u2;  
  	  
    3-2 不同变量对应的zval实战  
  	  用gdb调试源码  
  	  
  	3-3 Zend_string与写时复制实战  

  	3-4 带你实战引用类型的使用  
		$a = "string";  
		$b = &$a;  

		echo $a; //string  
		echo $b; //string  

		$b = "hello";  
		echo $a; //hello  
		echo $b; //hello  

		unset($b);  
		echo $b; //空  
		echo $a; //hello  

	3-5 什么是PHP7源码中的数组  
	
	3-6 带你实战数组的增删改查     
        $a = [];  
		$a[1] = "a";  
		$a[] = "b";  
		var_dump($a); //array(2) { [1]=> string(1) "a" [2]=> string(1) "b" } 

		$a["k1"] = "v1";  
		$a["k2"] = "v2";  

		echo $a["k1"]; //v1  
		var_dump($a); //array(4) { [1]=> string(1) "a" [2]=> string(1) "b" ["k1"]=> string(2) "v1" ["k2"]=> string(2) "v2" }  

		$a["k1"] = "c";  
		var_dump($a); //array(4) { [1]=> string(1) "a" [2]=> string(1) "b" ["k1"]=> string(1) "c" ["k2"]=> string(2) "v2" }  

		unset($a["k2"]);  
		var_dump($a); //array(3) { [1]=> string(1) "a" [2]=> string(1) "b" ["k1"]=> string(1) "c" }  
		
	3-7 继续实战数组的增删改查（彻底知道数组的底层实现逻辑）  
	
	3-8 再次总结基本变量  
	
	3-9 内存管理基础知识  

	    从malloc谈内存管理  
	    void *ptr=malloc(size) //malloc返回的指针ptr,指向可用内存的首地址  
	    free(ptr)  
		 
		php7内存接口  
		void *ptr = _emalloc(size)  
		_efree(ptr)  

		基本概念  
		chunk:2MB大小的内存  
		page：4KB大小的内存  
		
	3-10 什么是真正的内存分配过程  
		内存规格  
		内存预分配：使用mmap分配chunk  
		内存分类  
		   1.Small（30种规格）size<=3kb  
		   2.Large 3kb<size<=2mb-4kb  
		   3.Huge size>2mb-4kb  
		   
	3-11 什么是Small内存的管理	 
	
	3-12 带你实战Small内存管理   
	
	3-13 Chunk的内存对齐    
	
	3-14 认识真实的Small和Large内存的标记  
	
	3-15 内存标记和内存释放时大小的判断  
	
	3-16 总结内存管理  

第4章 PHP运行的生命周期  
    4-2 什么是CLI模式  
        cli模式的生命周期  
        php_module_startup(模块初始化阶段)---》php_request_startup(请求初始化阶段)---》php_execute_script(脚本执行阶段)---》php_request_shutdown(请求关闭阶段)---》php_module_shutdown(模块关闭阶段)  

    4-3 实战CLI模式的生命周期  
    
    4-4 认识模块初始化部分函数调用图   
    
    4-5 详解php_module_startup阶段  
    
    4-6 详解php_request_startup   
    
    4-7 详解执行和管理阶段  
    
    4-8 何为FPM的三种模式
        1.pm=static   //static模式始终会保持一个固定的子进程数   	
        2.pm=dynamic  //动态模式  子进程的数量是变化的   
        3.pm=ondemand //按需模式 把内存放到第一位   
        ps aux | grep fpm    
        kill 22332 //杀死fpm    
        ps aux | grep fpm | wc -l  
	   
    4-9 网络编程的基础知识  
        server端  
        client端  
            1.socket  
            2.bind  
            3.listen  
            4.accept  

    4-10 网络编程实战  
        netstat -anp | grep 3000  

    4-11 信号处理实战   
        两个进程，一个master，一个worker  
        把master进程kill掉，worker进程还能工作不？ 能  
        kill掉worker进程，还能工作不？ 能 
        主进程负责管理监听子进程相关情况，杀掉子进程后，会重新启动一个新的子进程  

    4-12 FPM的生命周期    
        php_module_startup---->fcgi_accept_request--->php_request_startup---->fpm_request_executing--->php_execute_script----->fpm_request_end---->php_request_shutdown----->fcgi_accept_request 

        php_request_shutdown====>php_module_shutdown   

    4-13 实战：使用GDB调试FPM  
    
    4-14 FastCGI协议理论讲解  
        浏览器----》apache/nginx(接受请求)----cgi/fastcgi-->php-fpm(管理php-cgi)---->index.php---cgi/fastcgi-->apache/nginx(html数据)----》浏览器   
        
    4-15 FastCGI协议实战  
        tcpdump -i lo port 9000 -XX -S  
        三次握手   fastcgi  

第5章 PHP代码的解析与执行  
    5-1 解释型语言也需要编译吗
        php----->编译器----》opcodes--->虚拟机--->物理机  
        
    5-2 NFA和DFA  
        词法分析入门-NFA（不确定有穷自动机）  
        词法分析入门-DFA（确定有穷自动机）  
        
    5-3 实战：使用re2c做词法分析  
    
    5-4 语法分析入门与巴科斯范式  
    
    5-5 实战：使用bison做语法分析  
    
    5-6 PHP7的词法和语法分析   
        正则表达式处理字符串 
        
    5-7 实战：PHP7词法分析过程  
    
    5-8 实战：PHP7语法分析的过程  
    
    5-9 AST编译成指令集   
    
    5-10 实战：AST编译成opcode的过程  
    
    5-11 Zend虚拟机的基础  
        php代码---》词法分析器，语法分析器---》AST----》编译器---》执行栈，Opline指令，符号表-----》执行引擎  
    5-12 实战：Zend虚拟机的执行  

第6章 基本语法实现的细节和原理   
    6-1 break语法的AST、栈、符号表和指令集    
        实战：中断与跳转的实现  
        break语法      
        goto语法       
        
    6-2 break命令执行过程   
    
    6-3 include语法的AST、栈、符号表和常量  
        include语法  
        require语法  
        include_once语法  
        require_once语法 
        
    6-4 include 语法的执行  
    
    6-5 条件判断语法的AST  
        if(){}else{}  
        
    6-6 条件语句的栈、符号表、常量和指令集  
    
    6-7 条件语法的执行过程  
    
    6-8 foreach的AST、栈、符号表和常量数组  
        循环语法实现  
          foreach语法  
          while语法  
          for语法  
          do while语法  
    6-9 foreach指令集  
    
    6-10 foreach语法的执行过程  
    
    6-11 异常处理的AST、栈、符号表、常量和指令集   
          异常和错误的处理实现
          try{}catch(){}finally(){}  
          
    6-12 异常处理的执行过程  
    
第7章 编写一个PHP扩展  
    7-1 编写一个简单的扩展  
        cd ext/ 
        ./ext_skel --extname=helloworld  
        cd helloworld  
        vim congif.m4  
        phpize  
        ./configure --with-php-config=xxx  
        make && make install 
    
    7-2 实战：扩展的具体分析  
    
    7-3 一个简单的日志扩展  
    
    7-4 SeasLog扩展分析（一）  
    
    7-5 SeasLog扩展分析（二） 
    
    7-6 内部函数sort分析 
        PHP_FUNCTION(sort) 
      
    7-7 内部扩展date  

第8章 课程总结   























     

            
    


		





  








           




	   
	   
	   
	   
	   
	   
	   
	   
	  
	
	
	
  












