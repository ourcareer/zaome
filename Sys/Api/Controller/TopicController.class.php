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


/*
use Think\Controller\RestController;
class TopicController extends RestController {

    protected $allowMethod    = array('get','post','put'); // REST允许的请求类型列表
    protected $allowType      = array('html','xml','json'); // REST允许请求的资源类型列表

   public function rest() {
     switch ($this->_method){
      case 'get':
			$this->index();           
           break;
      case 'put':
      		dump('xiugai');
      		exit();
           break;
      case 'post':
    		dump('zengja');
      		exit();
      		$this->add();
           break;
     }
   }
	*/


    public function index($page='1',$uid=''){
    	$Api = A('Topic/Index');
    	$Api->ls($page,$uid);
    }

    public function add(){
    	$Api = A('Topic/Index');
    	$Api->add();
    }



}