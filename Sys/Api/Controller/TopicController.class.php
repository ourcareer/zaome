<?php

/**
 * TODO!!
 * 使用get的话，获取问题list。
 * 使用post的话，添加问题。
 * 使用put的话，修改问题。
 */
namespace Api\Controller;
use Think\Controller;

class TopicController extends Controller {
    public function index($page='1',$uid=''){
    	$Api = A('Topic/Index');
    	$Api->ls($page,$uid);
    }



}