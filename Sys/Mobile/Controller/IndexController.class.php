<?php
namespace Mobile\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $this->display('');
    }
    public function share(){
    	$this->display();
    }
}