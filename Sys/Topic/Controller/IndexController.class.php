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