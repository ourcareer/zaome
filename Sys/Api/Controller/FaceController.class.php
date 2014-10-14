<?php
namespace Api\Controller;
use Think\Controller;
class FaceController extends Controller {
    public function index(){
    	$Api = A('User/Index');
    	$Api->uploadFace();
    }
}