<?php
namespace Api\Controller;
use Think\Controller;
class LogoutController extends Controller {
    public function index(){
    	$Api = A('User/Index');
    	$Api->logout();
    }
}