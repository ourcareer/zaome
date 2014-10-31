<?php

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',True);

// 定义应用目录
define('APP_PATH','./Sys/');

// 自动生成模块
// define('BIND_MODULE', 'Common');//这是自动完成的 系统默认
// define('BIND_MODULE', 'Home');//系统默认模块
// define('BIND_MODULE', 'Admin');
// define('BIND_MODULE', 'Topic');
// define('BIND_MODULE', 'User');
// define('BIND_MODULE', 'Bug');
// define('BIND_MODULE', 'Sms');
// define('BIND_MODULE', 'Api');

// 定义runtime的路径
define('RUNTIME_PATH','./Data/Runtime/');

// ThinkPHP路径
define('THINK_PATH','./Src/ThinkPHP/');

// 引入ThinkPHP入口文件
require( THINK_PATH.'/ThinkPHP.php');

?>