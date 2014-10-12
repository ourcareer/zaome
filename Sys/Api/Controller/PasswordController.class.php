<?php
namespace Api\Controller;
use Think\Controller;
class PasswordController extends Controller {
    public function index(){
        $Api = A('User/Index');
    	$Api->password();
    }
}