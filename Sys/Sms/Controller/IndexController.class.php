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
/*        
        $verify = I('verify');
		if(!check_verify($verify)){
			$this->error('验证码输入错误！');
		}
*/
		$mobile = I('mobile');
        $use = I('use');        
    	$Sms = new SmsApi();
    	$res = $Sms->checkMobile($mobile);
    	if (!$res) {
            $rt['code'] = '-200191905';
            $rt['msg'] = '手机号错误！';
            $this->ajaxReturn($rt);
    		// $this->error('手机号错误！');
    	}
        $times['limittime_90'] = $Sms->checkTimes($mobile,90);
        if ($times['limittime_90'] >= 1) {
            $rt['code'] = '-200191905';
            $rt['msg'] = '90秒之内只能发送一条，请耐心等待！';
            $this->ajaxReturn($rt);
        }
        $times['limittime_300'] = $Sms->checkTimes($mobile,300);
        if ($times['limittime_300'] >= 2) {
            $rt['code'] = '-200191905';
            $rt['msg'] = '5分钟之内只能发送2条！';
            $this->ajaxReturn($rt);
        }
        $times['limittime_900'] = $Sms->checkTimes($mobile,900);
        if ($times['limittime_900'] >= 3) {
            $rt['code'] = '-200191905';
            $rt['msg'] = '15分钟之内只能发送3条！';
            $this->ajaxReturn($rt);
        }
        $times['limitime_86400'] = $Sms->checkTimes($mobile,86400);
        if ($times['limitime_86400'] >= 5) {
            $rt['code'] = '-200191905';
            $rt['msg'] = '一天只能只能发送5条！';
            $this->ajaxReturn($rt);
        }
        $times['limittime_2592000'] = $Sms->checkTimes($mobile,2592000);
        if ($times['limittime_2592000'] >= 10) {
            $rt['code'] = '-200191905';
            $rt['msg'] = '你的手机号发送过多，已经被禁止！';
            $this->ajaxReturn($rt);
        }
        // dump($times);
        // exit();
    	// dump(I());
    	// exit();
    	// $smscode = random();
    	// echo($mobile).'<br/>';
    	// echo($smscode).'<br/>';
 		$result = $Sms->sendSMS($mobile,$use);
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