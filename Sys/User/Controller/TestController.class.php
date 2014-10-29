<?php

/**
 * Copyright (c) zaome Inc
 * Author ancon <zhongfuzhong@gmail.com>
 * Modify 2014-10-18 14:34:47
 */

namespace User\Controller;
use User\Api\UserApi;
use Think\Controller;
use Sms\Api\SmsApi;
/**
 * 用户模块
 * 1,注册;
 * 2,登录;
 * 3,登出;
 * 4,修改密码;
 * 5,验证码; 
 * 6,用户锁定.
 * 7，上传头像.
 * 8，更新用户信息.
 */
class TestController extends Controller {
	public function lostpassword(){

		if(IS_POST){
			$mobile = I('mobile');
			$smscode = I('smscode');
			$password = I('post.password');
			$repassword = I('post.repassword');
			if ($password !== $repassword) {
				$rt['code'] = '-200211215';
				$rt['msg'] = '您输入的两次密码不一致';
				$this->ajaxReturn($rt);
				// $this->error('您输入的两次密码不一致');
			}
		


            /* 调用短信接口验证 */
            $Sms = new SmsApi;
            /* 验证码是否正确 */
            $res = $Sms->checkSmscode($mobile, $smscode);
            if ($res<1) {
				$rt['code'] = '-200211215';
				$rt['msg'] = '短信验证码不正确！';
				$this->ajaxReturn($rt);
            }
 
            /* 验证码是否过期 */
            $expire = C('EXPIRETIME');
            $res = $Sms->expireSmscode($mobile, $smscode, $expire);
            if ($res<1) {
				$rt['code'] = '-200211215';
				$rt['msg'] = '短信验证码过期！';
				$this->ajaxReturn($rt);            	
            }


			/* 调用用户模块接口 */
            $User = new UserApi;
            $uid = M('User')->getFieldByMobile($mobile,'uid');
            $lost = 1;
            $res = $User->addPassword($uid, $password, $lost);
            // dump($res);
            // exit();
            if($res>0){
            	$rt['code'] = '200211215';
            	$rt['msg'] = 'succeed';
            	$rt['result']['token_access'] = session('user_auth_sign');
            	$this->ajaxReturn($rt);
                // $this->success('添加密码成功！',U('index'));
            }else{
            	$rt['code'] = '-200211215';
            	$rt['msg'] = $res;
            	// $rt['msg'] = $this->showRegError($res);
            	$this->ajaxReturn($rt);
                // $this->error($this->showRegError($res));
            }
        }
	}
}