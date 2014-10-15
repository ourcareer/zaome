<?php

namespace Sms\Model;
use Think\Model;

//把之前的那个放到第三方类库去了

/**
 * 短信模型
 */
class SmsModel extends Model{

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
		$dbsmscodes = $this->where(array('mobile'=>$mobile))->field('smscode')->select();
		foreach ($dbsmscodes as $key => $value) {
			$dbsmscode[]=$value['smscode'];
		}
		if(in_array($smscode, $dbsmscode)){
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
	public function expireSmscode($mobile, $smscode, $expire = '1800'){
		$sendtime = $this->where(array('mobile'=>$mobile,'smscode'=>$smscode))->limit(1)->order('sendtime desc')->field('sendtime')->find();
		// $sendtime = $this->getFieldByMobile($mobile,'sendtime');
		$sendtime = $sendtime['sendtime'];
		// dump($sendtime);
		// dump($expire);
		// dump(NOW_TIME);
		// dump($sendtime+$expire);
		// exit();
		if($sendtime + $expire > NOW_TIME){
			return true;
		} else {
			return '-30';
		}
	}

	public function sendSMS($mobile){
		$tempId = C("TEMPLATEID")?C("TEMPLATEID"):1;
		$smscode = $this->random();

		$res = $this->sendTemplateSMS($mobile,array($smscode,'5'),$tempId);
		// $res = 200191913;
		// dump($res);
		// exit();
		if ($res == '200191913') {
			$data=array(
				'mobile'	=>	$mobile,
				'smscode'	=>	$smscode,
				);

			$data = $this->create($data);
			if ($data) {
				if($res = $this->add($data)) return '200191913';
			}
		}
			// dump($data);
			// dump('a');
			// exit();
		return $res;
	}


	/**
	  * 发送模板短信
	  * @param to 手机号码集合,用英文逗号分开
	  * @param datas 内容数据 格式为数组 例如：array('Marry','Alon')，如不需替换请填 null
	  * @param $tempId 模板Id,测试应用和未上线应用使用测试模板请填写1，正式应用上线后填写已申请审核通过的模板ID
	  */       
	public function sendTemplateSMS($to,$datas,$tempId)
	{

		//主帐号,对应开官网发者主账号下的 ACCOUNT SID
		$accountSid= C('accountSid');

		//主帐号令牌,对应官网开发者主账号下的 AUTH TOKEN
		$accountToken= C('accountToken');

		//应用Id，在官网应用列表中点击应用，对应应用详情中的APP ID
		//在开发调试的时候，可以使用官网自动为您分配的测试Demo的APP ID
		$appId=C('appId');

		//请求地址
		//沙盒环境（用于应用开发调试）：sandboxapp.cloopen.com
		//生产环境（用户应用上线使用）：app.cloopen.com
		$serverIP=C('serverIP');


		//请求端口，生产环境和沙盒环境一致
		$serverPort=C('serverPort');

		//REST版本号，在官网文档REST介绍中获得。
		$softVersion=C('softVersion');

	     // 初始化REST SDK
	     // global $accountSid,$accountToken,$appId,$serverIP,$serverPort,$softVersion;
	     $rest = new \Org\Util\CCPRestSmsSDK($serverIP,$serverPort,$softVersion);
	     $rest->setAccount($accountSid,$accountToken);
	     $rest->setAppId($appId);
	    
	     // 发送模板短信
	     // echo "Sending TemplateSMS to $to <br/>";
	     $result = $rest->sendTemplateSMS($to,$datas,$tempId);

	     if($result == NULL ) {
	         // echo "result error!";
	         break;
	     }
	     if($result->statusCode!=0) {
	         // echo "error code :" . $result->statusCode . "<br>";
	         // echo "error msg :" . $result->statusMsg . "<br>";
	         //TODO 添加错误处理逻辑
	         return $result->statusCode;
	     }else{
	         // echo "Sendind TemplateSMS success!<br/>";
	         // 获取返回信息
	         $smsmessage = $result->TemplateSMS;
	         // echo "dateCreated:".$smsmessage->dateCreated."<br/>";
	         // echo "smsMessageSid:".$smsmessage->smsMessageSid."<br/>";
	         //TODO 添加成功处理逻辑
	         //TODO加入数据库
	         //返回值
	         if ($smsmessage) {
	         	 // echo $smsmessage;exit();
		         // echo "dateCreated:".$smsmessage->dateCreated."<br/>";
		         // echo "smsMessageSid:".$smsmessage->smsMessageSid."<br/>";
		         return 200191913;
	         }
	         return false;
	     }
	}

	/**
	 * 这个函数是自己写的。
	 * @param string $length 长度，可以自己定义长度
	 * @param int 0 这表示不使用纯数字 1表示使用纯数字
	 */
	public function random($length = 4 , $numeric = 0) {
	    PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
	    if($numeric) {
	        $hash = sprintf('%0'.$length.'d', mt_rand(0, pow(10, $length) - 1));
	    } else {
	        $hash = '';
	        // $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789abcdefghjkmnpqrstuvwxyz';
	        $chars = '23456789';
	        $max = strlen($chars) - 1;
	        for($i = 0; $i < $length; $i++) {
	            $hash .= $chars[mt_rand(0, $max)];
	        }
	    }
	    return $hash;
	}


}
