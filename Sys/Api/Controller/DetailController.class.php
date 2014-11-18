<?php

namespace Api\Controller;
use Think\Controller;

class DetailController extends Controller {

    public function index($tid = '', $rid = ''){
    	$Api = A('Topic/Index');
    	$Api->detail($tid,$rid);
    }

}