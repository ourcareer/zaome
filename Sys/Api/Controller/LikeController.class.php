<?php

namespace Api\Controller;
use Think\Controller;

class LikeController extends Controller {

    public function index($tid = '',$rid = '',$cancel = ''){
    	$Api = A('Topic/Index');
    	$Api->like($tid,$rid,$cancel);
    }

}