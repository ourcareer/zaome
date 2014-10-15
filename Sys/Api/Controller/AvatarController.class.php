<?php
namespace Api\Controller;
use Think\Controller;
class AvatarController extends Controller {
    public function index(){
    	$Api = A('User/Index');
    	$Api->uploadAvatar();
    }
}