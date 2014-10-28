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

    public function main(){
        $this->display();
    }

    /**
     * 输出话题列表
     * @param int $page
     */
    public function ls_bak($page='1',$uid=''){
        $Model = D('topic');
        $page = I('page');
        $author = I('uid');

        $table = array(
            'zaome_topic'   =>  'topic',
            'zaome_user'    =>  'user',
            'zaome_picture' =>  'picture',
            );
        $field = array(
            'topic.author'    =>  'uid',
            'topic.id'        =>  'tid',
            'topic.content',
            'topic.repeat'    =>  'repeatcount',
            'topic.like'      =>  'likecount',
            'topic.bg'        =>  'background',
            'user.nickname'   =>  'nickname',
            'picture.url'     =>  'avatar',
            );
        $map = array(
            'topic.pass'      =>  1,
            'topic.delete'    =>  0,
            'topic.report'    => array('lt',50),
            );
        $order = 'topic.time desc,topic.id desc';
        $where = array(
            // 'user.uid'        => 'topic.author',
            // 'picture.id'      => 'user.avatar',
            );


        // $map['pass'] = 1;
        // $map['delete'] = 0;
        // $map['report'] = array('lt',500);


        // 200是OK,20是模块,1219是方法
        $data['code'] = 200201219;
        $data['msg'] = 'succeed';
     

        // TODO
        /* 首先检查这个用户是否被关闭 */
        if ($author) {
            $map['author'] = $author;
            $data['result'] = $Model->table($table)->order($order)
            ->page($page,15)->where($map)->select();
            $this->done($data);
        }
    	$data['result'] = $Model->table($table)
        ->field($field)
        ->order($order)->where($map)->where('user.uid=topic.author')->page($page,15)->select();
        $this->done($data);

    }

    public function ls($page='1',$uid=''){
        $Topic = D('topic');

        $page = I('page');
        $author = I('uid');

        $data['code'] = 200201219;
        $data['msg'] = 'succeed';

        $field = array(
            'id'        =>  'tid',
            'content',
            'repeat'    =>  'repeatcount',
            'like'      =>  'likecount',
            'bg'        =>  'background',
            'author'    =>  'uid',
            );

        $map = array(
            'pass'      =>  1,
            'delete'    =>  0,
            'report'    => array('lt',50),
            );

        $order = 'time desc,id desc';

        if ($author) {
            $map['author'] = $author;
        }

        $data['result'] = $Topic
        ->field($field)
        ->where($map)
        ->page($page,15)
        ->order($order)
        ->select();

        foreach ($data['result'] as $key => $value) {
            $data['result'][$key]['avatar'] = get_avatar($value['uid']);

            $Repeat = D('repeat');
            $map['totid'] = array('in',$value['tid']);
            $refield = array(
                'id'        =>  'avatar',
                'content'   =>  'repeatcontent',
                'uid',
                );
            $order = '`like` desc, `repeat` desc, `time` desc';

            $data['result'][$key]['repeat'] = $Repeat
            ->field($refield)
            ->where($map)
            ->order($order)
            ->limit(10)
            ->select();
            foreach ($data['result'][$key]['repeat'] as $keyre => $valuere) {
                $data['result'][$key]['repeat'][$keyre]['avatar'] = get_avatar($valuere['uid']);
            }
        }

         // dump($data['result']);
        // dump($uids);
        // dump($tids);
        // dump($usermap);
        // dump($datauser);
        // dump($datapic);
        // dump($data);
        dump($data);
        exit();
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