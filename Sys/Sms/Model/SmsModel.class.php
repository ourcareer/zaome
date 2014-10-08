<?php

namespace Sms\Model;
use Think\Model;
/**
 * 会员模型
 */
class SmsModel extends Model{
	/* 用户模型自动验证 */
	protected $_validate = array(
		/* 验证手机号码 */
		array('mobile', 'checkMobile', -8, self::EXISTS_VALIDATE, 'callback'), //手机格式不正确
		array('mobile', 'checkDenyMobile', -9, self::EXISTS_VALIDATE, 'callback'), //手机禁止注册
		array('mobile', '', -10, self::EXISTS_VALIDATE, 'unique'), //手机号被占用

		/* 验证sms验证码 */
		array('smscode', 'checkSmscode', -12, self::EXISTS_VALIDATE, 'callback'), //验证码是否正确
		// array('smscode', 'smscode', -12, self::EXISTS_VALIDATE, 'confirm'), //验证码是否正确
		array('smscode', 'expireSmscode', -13, self::EXISTS_VALIDATE, 'callback'), //验证短信的有效期
		// array('smscode', array(sendtime,sendtime+1800), -13, self::EXISTS_VALIDATE, 'between'),
	);

	/* 用户模型自动完成 */
	protected $_auto = array(
		array('sendtime', NOW_TIME, self::MODEL_INSERT),
		array('ip', 'get_client_ip', self::MODEL_INSERT, 'function', 1),
	);

	/**
	 * 检测用户名是不是被禁止注册,写在数据库里面吧
	 * @param  string $username 用户名
	 * @return boolean          true - 未禁用，false - 禁止注册
	 */
	protected function checkDenyMember($username){
		return true; //TODO: 暂不限制，下一个版本完善
	}

	/**
	 * 检测手机号是否正确,声明一点,这个函数应该是变化的,因为手机号在发展.
	 * 目前只支持国内用户手机号.
	 * @param  string $mobile 手机
	 * @return boolean        true - 正确，false - 手机号不对
	 */
	public function checkMobile($mobile){
		return (strlen($mobile) == 11
			&& (preg_match("/^13\d{9}$/", $mobile)
				|| preg_match("/^14\d{9}$/", $mobile)
				|| preg_match("/^15\d{9}$/", $mobile)
				|| preg_match("/^17\d{9}$/", $mobile)
				|| preg_match("/^18\d{9}$/", $mobile)
			)?true:''
				);
	}

	/**
	 * 检测手机是不是被禁止注册
	 * @param  string $mobile 手机
	 * @return boolean        true - 未禁用，false - 禁止注册
	 */
	protected function checkDenyMobile($mobile){
		return true; //TODO: 暂不限制，下一个版本完善
	}

	/**
	 * 检查短信验证码是否正确
	 * @param string $mobile 手机号
	 * @param string $smscode 短信验证码
	 * @return boolean		true - 验证码正确, false - 验证码错误
	 */
	public function checkSmscode($mobile, $smscode){
		// $dbsmscode = $this->where($mobile)->field('smscode')->find();
		$dbsmscode = $this->getFieldByMobile($mobile,'smscode');
		// dump($mobile);
		// dump($smscode);
		// dump($dbsmscode);
		// dump('haocan');
		// exit();
		if($smscode == $dbsmscode){
			return true;
		} else {
			return $this->getError();
		}
	}
	/**
	 * 检查短信验证码有效期默认是半个小时
	 * @param string $mobile 手机号
	 * @param string $smscode 短信验证码
	 * @return boolean		true - 验证码有效, false - 验证码过期
	 */
	public function expireSmscode($mobile, $smscode, $expire = 1800){
		// $sendtime = $this->where($mobile)->field('sendtime')->find();
		$sendtime = $this->getFieldByMobile($mobile,'sendtime');
		if($sendtime + $expire > NOW_TIME){
			return true;
		} else {
			return $this->getError();
		}
	}

	public function sendSMS($mobile){
		$TemplateId = C("TEMPLATEID")?C("TEMPLATEID"):1;
		$smscode = random();
		$res = sendTemplateSMS($mobile,array($smscode,'5'),$TemplateId);
		if ($res=1) {
			$data=array(
				'mobile'	=>	$mobile,
				'smscode'	=>	$smscode,
				);
			$data = $this->create($data);
			if ($data) {
				return $this->save($data);
			}
		}
		return false;
	}

}
