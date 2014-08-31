<?php
return array(
    'DB_PREFIX' => 'wx_',
    'DB_DSN' => 'mysql://root:8ecba89b81@localhost:3306/wxprintadmin',


    'DEFAULT_FILTER'=>'htmlspecialchars,stripslashes',
    /*路由设置*/
    'URL_MODEL' 			=>	0,				//URL访问模式
    'URL_ROUTER_ON'   		=> true, 			//开启路由
    'URL_HTML_SUFFIX'		=>'shtml',			//伪静态后缀
    'URL_ROUTE_RULES' 		=> array( 			//定义路由规则
        'api/:token'        => 'Home/Weixin/index',


    ),

);