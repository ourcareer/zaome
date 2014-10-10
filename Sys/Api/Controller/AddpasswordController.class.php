<?php
namespace Api\Controller;
use Think\Controller;
class AddpasswordController extends Controller {
    public function index(){
    	$Api = A('User/Index');
    	$Api->addpassword();    	
    }
}