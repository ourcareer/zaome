<?php

namespace Sms\Api;
use User\Api\Api;
use Sms\Model\SmsModel;

class SmsApi extends Api{   
    /**
     * 构造方法，实例化操作模型
     */    
    protected function _init(){
        $this->model = new SmsModel();
    }

  
    public function checkSmscode($mobile, $smscode){
        return $this->model->checkSmscode($mobile, $smscode);
    }

    public function expireSmscode($mobile, $smscode, $expire){
        return $this->model->expireSmscode($mobile, $smscode,$expire);
    }
 
     public function checkTimes($mobile, $limittime){
        return $this->model->checkTimes($mobile, $limittime);
    }
 
    /**
     * 检测手机
     * @param  string  $mobile  手机
     * @return integer         错误编号
     */
    public function checkMobile($mobile){
        return $this->model->checkMobile($mobile);
    }

    /**
     * 发送短信，接下来就是网关的事情了
     * @param string $mobile    手机
     * @return integer          错误代码
     */
    public function sendSMS($mobile,$use){
        $return = $this->model->sendSMS($mobile,$use);
        // dump($return);
        // exit();
        return $return;
    }

}
