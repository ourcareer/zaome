<?php


// 引入短信平台。
import("@.Smscode.CCPRestSmsSDK");

/**
  * 发送模板短信
  * @param to 手机号码集合,用英文逗号分开
  * @param datas 内容数据 格式为数组 例如：array('Marry','Alon')，如不需替换请填 null
  * @param $tempId 模板Id,测试应用和未上线应用使用测试模板请填写1，正式应用上线后填写已申请审核通过的模板ID
  */       
function sendTemplateSMS($to,$datas,$tempId)
{


	//主帐号,对应开官网发者主账号下的 ACCOUNT SID
	$accountSid= '8a48b551488d07a801489aab991e03b4';

	//主帐号令牌,对应官网开发者主账号下的 AUTH TOKEN
	$accountToken= 'e7ac190c7575499c9d23b71920860d60';

	//应用Id，在官网应用列表中点击应用，对应应用详情中的APP ID
	//在开发调试的时候，可以使用官网自动为您分配的测试Demo的APP ID
	$appId='aaf98f89488d0aad01489b0bbc100465';

	//请求地址
	//沙盒环境（用于应用开发调试）：sandboxapp.cloopen.com
	//生产环境（用户应用上线使用）：app.cloopen.com
	$serverIP='sandboxapp.cloopen.com';


	//请求端口，生产环境和沙盒环境一致
	$serverPort='8883';

	//REST版本号，在官网文档REST介绍中获得。
	$softVersion='2013-12-26';


     // 初始化REST SDK
     // global $accountSid,$accountToken,$appId,$serverIP,$serverPort,$softVersion;
     $rest = new REST($serverIP,$serverPort,$softVersion);
     $rest->setAccount($accountSid,$accountToken);
     $rest->setAppId($appId);
    
     // 发送模板短信
     echo "Sending TemplateSMS to $to <br/>";
     $result = $rest->sendTemplateSMS($to,$datas,$tempId);
     if($result == NULL ) {
         echo "result error!";
         break;
     }
     if($result->statusCode!=0) {
         echo "error code :" . $result->statusCode . "<br>";
         echo "error msg :" . $result->statusMsg . "<br>";
         //TODO 添加错误处理逻辑
         return $result->statusCode;
     }else{
         echo "Sendind TemplateSMS success!<br/>";
         // 获取返回信息
         $smsmessage = $result->TemplateSMS;
         echo "dateCreated:".$smsmessage->dateCreated."<br/>";
         echo "smsMessageSid:".$smsmessage->smsMessageSid."<br/>";
         //TODO 添加成功处理逻辑
         //TODO加入数据库
         //返回值
         return true;
     }
}

/**
 * 这个函数是自己写的。
 * @param string $length 长度，可以自己定义长度
 * @param int 0 这表示不使用纯数字 1表示使用纯数字
 */
function random($length = 4 , $numeric = 0) {
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


?>