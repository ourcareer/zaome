<?php
namespace Sms\Controller;
use Think\Controller;
use Sms\Api\SmsApi;

class IndexController extends Controller {

   /**
     * 发送短信
     * 手机号码，替换内容数组，模板ID
     */
    public function sendSMScode(){
    	//TODO只有post方法才能认，并且，需要带该app的验证码才行。
    	//现在阶段，先这么上吧
    	//TODO每天只能发5条
    	//TODO，每个ip只能发3条，半小时之内。

		/* 检测验证码 */
        $verify = I('verify');
		if(!check_verify($verify)){
			$this->error('验证码输入错误！');
		}
		$mobile = I('mobile');
    	$Sms = new SmsApi();
    	$res = $Sms->checkMobile($mobile);
    	if (!$res) {
            $rt['code'] = '-200191905';
            $rt['msg'] = '手机号错误！';
            $this->ajaxReturn($rt);
    		// $this->error('手机号错误！');
    	}
    	// dump(I());
    	// exit();
    	// $smscode = random();
    	// echo($mobile).'<br/>';
    	// echo($smscode).'<br/>';
 		$result = $Sms->sendSMS($mobile);
 		if ($result == '200191913') {
                $rt['code'] = '200191905';
                $rt['msg'] = '已经成功发送了！';
 				$this->ajaxReturn($rt);
 		}
        elseif (!$result) {
                $rt['code'] = '-200191905';
                $rt['msg'] = '发送失败！';
                $this->ajaxReturn($rt);
            }
        else {
            $rt['code'] = '-200191905';
            $rt['msg'] = $result;
            $this->ajaxReturn($rt);
        }
    	// sendTemplateSMS("$mobile",array($smscode,'5'),"1");
    	// sendTemplateSMS("15010438587",array($smscode,'5'),"1");
    }


}