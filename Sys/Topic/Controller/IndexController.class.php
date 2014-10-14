<?php

namespace Topic\Controller;
use Think\Controller;
class IndexController extends Controller {
 
    public function _initialize(){
        // 验证他是否是这个人即OK.
        // 检查权限问题
    }

    public function index(){
        $this->ls();
    }


    public function share(){
        $this->display();
    }

    /**
     * 输出话题列表
     * @param int $page
     */
    public function ls($page='1',$uid=''){
        $Topic = D('topic');

        $page = I('page');
        $author = I('uid');

        // $map['pass'] = 1;
        // $map['delete'] = 0;
        // $map['report'] < 500;
        $map = array(
            'pass'      =>  1,
            'delete'    =>  0,
            'report'    =>  0,         
            );


        // 200是OK,20是模块,1219是方法
        $data['code'] = 200201219;
        $data['msg'] = 'succeed';
     

        // TODO
        /* 首先检查这个用户是否被关闭 */
        if ($author) {
            $map['author'] = $author;
            $data['result'] = $Topic->order('time desc')->page($page,15)->where($map)->select();
        }

    	$data['result'] = $Topic->order('time desc')->page($page,15)->where($map)->select();
        $this->done($data);

    }

    public function add(){
        if ( !is_login() ) {
            $rt['code'] = '-1';
            $rt['msg'] = '请先登录！';
            $this->ajaxReturn($rt);         
        }

        if (IS_POST) {
            $Topic = D('topic');
            // $author = I('author');
            $author = is_login();
            
            $content = I('content');
            $time = NOW_TIME;
            $ip = get_client_ip(1);
            $bg = I('bg');
            
            $data['author'] = $author;
            $data['content'] = $content;
            $data['time'] = $time;
            $data['ip'] = $ip;
            $data['bg'] = $bg;

            $rt['code'] = '200200104';
            $rt['msg'] = 'succeed';
            $this->done($data,$rt);            
        }
    }

    public function del(){

    }

    public function mod(){

    }

    /**
     * 上传图片
     * @author ancon <zhongyu@buaa.edu.cn>
     */
    public function uploadPicture(){

        //测试阶段,先注释.
/*
        if (!$uid = is_login()) {
            $rt['code'] = '-1';
            $rt['msg'] = '请先登录！';
            $this->ajaxReturn($rt); 
        }
*/

        $pictureconfig = C('PICTURE_UPLOAD');
        // $upload->upload($pictureconfig);
        $Api = new \Think\Upload($pictureconfig);// 实例化上传类
        // $upload->maxSize   =     3145728 ;// 设置附件上传大小
        // $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        // $upload->rootPath  =     './Data/Face/'; // 设置附件上传根目录
        // $upload->savePath  =     ''; // 设置附件上传（子）目录
        // 上传文件 
        $info   =   $Api->upload();
        if(!$info) {// 上传错误提示错误信息
            $this->error($Api->getError());
        }else{// 上传成功
            $info[0]['url'] = $pictureconfig['rootPath'].$info[0]['savepath'].$info[0]['savename'];
            $info[0]['create_time'] = NOW_TIME;
            $info[0]['author'] = $uid;
            $info[0]['ip'] = get_client_ip();
            $Picture = D('picture');
            $data = $Picture->create($info[0]);
            $Picture->add($data);

            return $info[0]['url'];
            dump($pictureconfig);
            dump($info);
            exit();
            $this->success('上传成功！');
        }
    }



    public function done($data='',$rt=''){
       
       $Topic = D('topic');

        // AJAX调用返回
    	if (IS_AJAX) {
    		$this->ajaxReturn($data);
    	}
    	// 直接输出模板
        // 不过先做app吧
        if (IS_GET) {
            $this->ajaxReturn($data);
            // $this->assign('data',$data);
            // $this->display();
        }
        if (IS_POST) {
            if ($data = $Topic->create($data)) {
                $insertid = $Topic->add($data);
                if($insertid){
                    $this->ajaxReturn($rt);
                }
            }
        }
        else {
            $rt['code'] = -$rt['code'];
            $rt['msg'] = 'fail';
            $this->ajaxReturn($rt);
        }
    }
}

?>