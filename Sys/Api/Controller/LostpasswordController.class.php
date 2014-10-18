<?php
namespace Api\Controller;
use Think\Controller;
class LostpasswordController extends Controller {
    public function index(){
    	$Api = A('User/Index');
    	$Api->lostpassword();
    }
}