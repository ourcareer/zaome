<?php
namespace Api\Controller;
use Think\Controller;
class PictureController extends Controller {
    public function index(){
    	$Api = A('Topic/Index');
    	$Api->uploadPicture();
    }
}