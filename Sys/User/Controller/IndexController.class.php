<?php

/**
 * Copyright (c) zaome Inc
 * Author ancon <zhongfuzhong@gmail.com>
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
 * 5,验证码; TODO!
 * 6,用户锁定.
 * 7，上传头像.TODO!
 */
class IndexController extends Controller {

	/* 空操作，用于输出404页面 */
	/*
	public function _empty(){
		$this->redirect('index');
	}

*/
    public function index(){
    	dump(session());
    	dump('test');
    	dump(NOW_TIME);

    	$this->display();
    }

	/**
	 * 注册页面
	 * @author ancon
	 */
	public function register(){
		/*
        if(!C('USER_ALLOW_REGISTER')){
            $this->error('注册已关闭');
        }
        */
		if(IS_POST){
			$mobile = I('mobile');
			$smscode = I('smscode');

			$verify = I('verify');
			if(!check_verify($verify)){
				$this->error('验证码输入错误！');
			}
			/* 调用注册接口注册用户 */
            $User = new UserApi;
            /* 调用短信接口验证 */
            $Sms = new SmsApi;
            /* 验证码是否正确 */
            $res = $Sms->checkSmscode($mobile, $smscode);
            if ($res<1) {
            	$this->error($this->showRegError($res));
            }
            
            /* 验证码是否过期 */
            $res = $Sms->expireSmscode($mobile, $smscode, 180000);
            if ($res<1) {
            	$this->error($this->showRegError($res));
            }
            /* 注册开始 */
            $uid = $User->register($mobile);
			if($uid > 0){ //注册成功
				// API返回一串数值！
				// TODO
				$this->success('注册成功！',U('index'));
			} else { //注册失败，显示错误信息
				// API返回错误信息，直接显示的信息
				// TODO
				$this->error($this->showRegError($uid));
			}

		} else { //显示注册表单
			$this->display('register');
		}
	}

	/**
	 * 获取用户注册错误信息
	 * @param  integer $code 错误编码
	 * @return string        错误信息
	 */
	private function showRegError($code = 0){
		switch ($code) {
			case -1:  $error = '用户名长度必须在16个字符以内！'; break;
			case -2:  $error = '用户名被禁止注册！'; break;
			case -3:  $error = '用户名被占用！'; break;
			case -4:  $error = '邮箱格式不正确！'; break;
			case -5:  $error = '邮箱长度必须在3-32个字符之间！'; break;
			case -6:  $error = '邮箱被禁止注册！'; break;
			case -7:  $error = '邮箱被占用！'; break;
			case -8:  $error = '手机格式不正确！'; break;
			case -9:  $error = '手机被禁止注册！'; break;
			case -10: $error = '手机号被占用！'; break;
			case -11:  $error = '密码长度必须在6-30个字符之间！'; break;
			case -12:  $error = '验证码错误！'; break;
			case -13:  $error = '验证码过期！'; break;
			case -14:  $error = '已经添加过密码！'; break;
			default:  $error = '未知错误！';
		}
		return $error;
	}

	/**
	 * 添加密码
	 * @author ancon
	 */
	public function addPassword(){
		if (!is_login()) {
			$this->error('您还没有登陆',U('login'));
		}
		if (IS_POST) {
			$uid = is_login();
			$password = I('post.password');
			$repassword = I('post.repassword');
			if ($password !== $repassword) {
				$this->error('您输入的两次密码不一致');
			}
			/* 调用用户API */
			$Api = new UserApi();
            $res = $Api->addPassword($uid, $password);
            if($res>0){
                $this->success('添加密码成功！');
                // $this->success('添加密码成功！',U('index'));
            }else{
                $this->error($this->showRegError($res));
            }
        }else{
            $this->display();        
		}
	}

    /**
     * 修改密码
     * @author ancon
     */
    public function password(){
		if ( !is_login() ) {
			$this->error( '您还没有登陆',U('login') );
		}
        if ( IS_POST ) {
            //获取参数
            $uid        =   is_login();
            $password   =   I('post.oldpassword');
            $repassword = I('post.repassword');
            $data['password'] = I('post.password');
            empty($password) && $this->error('请输入原密码');
            empty($data['password']) && $this->error('请输入新密码');
            empty($repassword) && $this->error('请再次输入密码');

            if($data['password'] !== $repassword){
                $this->error('您输入的新密码与再次密码不一致');
            }

            $Api = new UserApi();
            $res = $Api->updateInfo($uid, $password, $data);
            if($res['status']){
                $this->success('修改密码成功！');
            }else{
                $this->error($res['info']);
            }
        }else{
            $this->display();
        }
    }

	/**
	 * 退出登录
	 */
	public function logout(){
		if(is_login()){
			$Api = new UserApi();
			$Api->logout();
			$this->success('退出成功！', U('index'));
		} else {
			$this->redirect('login');
		}
	}

	/**
	 * 登录系统
	 */
	public function login(){
		if(IS_POST){
			$username = I('post.username');
			$password = I('post.password');
			$verify = I('verify');
			if(!check_verify($verify)){
				$this->error('验证码输入错误！');
			}
			$Api = new UserApi();
			// dump(I());
			// exit();
			$uid = $Api->login($username, $password,3);
			if ($uid<0) { //登录失败！
				switch($uid) {
					case -1: $error = '用户不存在或被禁用！'; break; //系统级别禁用
					case -2: $error = '密码错误！'; break;
					default: $error = '未知错误！'; break; // 0-接口参数错误（调试阶段使用）
				}
				$this->error($error);
			}
			elseif ($uid>0) {
				action_log('user_login', 'user', $uid, $uid);
				// $this->success('登录成功！', U('Topic/index/topic'));
				$this->success('登录成功！', U('User/Index/index'));
			} else {
				$this->error('失败！');
			}
		} else {
			$this->display('login');
		}
	}

	/* 验证码，用于登录和注册 */
	public function verify(){
		$verify = new \Think\Verify();
		$verify->entry(1);
	}




}