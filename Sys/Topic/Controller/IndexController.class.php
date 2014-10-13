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


    public function uploadPicture(){
        $pictureconfig = C('PICTURE_UPLOAD');
        // $upload->upload($pictureconfig);
        $Api = new \Think\Upload($pictureconfig);// 实例化上传类
        // $upload->maxSize   =     3145728 ;// 设置附件上传大小
        // $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        // $upload->rootPath  =     './Data/Face/'; // 设置附件上传根目录
        // $upload->savePath  =     ''; // 设置附件上传（子）目录
        // 上传文件 
        $info   =   $Api->upload();
        $info['topicbg']['url'] = $pictureconfig['rootPath'].$info['topicbg']['savepath'].$info['topicbg']['savename'];
        if(!$info) {// 上传错误提示错误信息
            $this->error($Api->getError());
        }else{// 上传成功
            $Picture = D('picture');
            dump($pictureconfig);
            dump($info);
            exit();
            $this->success('上传成功！');
        }
    }


  /**
     * 上传图片
     * @author ancon <zhongyu@buaa.edu.cn>
     */
    public function uploadPicture2(){
        //TODO: 用户登录检测

        /* 返回标准数据 */
        $return  = array('code' => 0, 'msg' => '上传成功', 'data' => '');

        /* 调用文件上传组件上传文件 */
        // $Picture = D('Picture');

        $Picture = new \Think\Upload();
        $pic_driver = C('PICTURE_UPLOAD_DRIVER');
        dump('a');
        // exit();
        dump( C('PICTURE_UPLOAD'));
        $info = $Picture->upload(
            $_FILES,
            C('PICTURE_UPLOAD'),
            C('PICTURE_UPLOAD_DRIVER'),
            C("UPLOAD_{$pic_driver}_CONFIG")
        );

        /* 记录图片信息 */
        if($info){
            $return['code'] = 200202120;
            $return = array_merge($info['download'], $return);
        } else {
            $return['code'] = '-200202120';
            $return['msg']   = $Picture->getError();
        }

        /* 返回JSON数据 */
        $this->ajaxReturn($return);
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