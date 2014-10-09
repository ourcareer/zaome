<?php
namespace Api\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function index(){
    	$Api = A('User/Index');
    	$Api->login();
    }
}