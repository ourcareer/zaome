<?php
namespace Api\Controller;
use Think\Controller;
class SchoolController extends Controller {
    public function index($school = ''){
    	$Api = A('User/Index');
    	$Api->getschool($school);
    }
}