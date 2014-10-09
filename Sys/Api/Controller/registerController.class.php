<?php
namespace Api\Controller;
use Think\Controller;
class RegisterController extends Controller {
    public function index(){
    	$Api = A('User/Index');
    	$Api->register();
    }
}