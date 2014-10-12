<?php
return array(
	//'配置项'=>'配置值'
	'URL_ROUTER_ON'         =>  true,   // 是否开启URL路由
    'URL_ROUTE_RULES'       =>  array(
    array('topic/:id','Topic/index', '', array('method' => 'GET')),
    array('topic','Topic/add', '', array('method' => 'POST')),
    array('topic','Topic/update', '', array('method' => 'PUT')),
    ), // 默认路由规则 针对模块
);