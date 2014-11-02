<?php

namespace Api\Controller;
use Think\Controller;

class ReplyController extends Controller {

    public function index($tid = '',$rid = ''){
    	$Api = A('Topic/Index');
    	$Api->add($tid,$rid);
    }
}