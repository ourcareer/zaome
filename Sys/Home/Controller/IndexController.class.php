<?php

/**
 * Copyright (c) zaome Inc
 * Author ancon <zhongfuzhong@gmail.com>
 */

namespace Home\Controller;
use Think\Controller;

/**
 * 首页控制器
 */
class IndexController extends HomeController {
    
    /**
     * 系统首页
     * 应该有统计功能,统计访客信息或者会员信息
     * 如果会员已经登录则显示登录
     * 首页为下载页面
     */
    public function index(){
    	//预留统计模块,挺难的,接下来再做

    	//判断是否登录
    	// dump(session());

        // dump('aa');

    	$this->display();
    }

    /**
     * 联系我们
     */
    public function contact(){
        $this->display();
    }
}