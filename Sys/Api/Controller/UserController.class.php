<?php
namespace Api\Controller;
use Think\Controller;
class UserController extends Controller {
    public function index(){
    	$Api = A('User/Index');
    	$Api->userinfo();
    }
}