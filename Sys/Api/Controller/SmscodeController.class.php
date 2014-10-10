<?php
namespace Api\Controller;
use Think\Controller;
class SmscodeController extends Controller {
    public function index(){
        $Api = A('Sms/Index');
    	$Api->sendSMScode();
    }
}