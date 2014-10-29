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
    // public function ls_bak($page='1',$uid=''){
    //     $Model = D('topic');
    //     $page = I('page');
    //     $author = I('uid');

    //     $table = array(
    //         'zaome_topic'   =>  'topic',
    //         'zaome_user'    =>  'user',
    //         'zaome_picture' =>  'picture',
    //         );
    //     $field = array(
    //         'topic.author'    =>  'uid',
    //         'topic.id'        =>  'tid',
    //         'topic.content',
    //         'topic.reply'    =>  'replycount',
    //         'topic.like'      =>  'likecount',
    //         'topic.bg'        =>  'background',
    //         'user.nickname'   =>  'nickname',
    //         'picture.url'     =>  'avatar',
    //         );
    //     $map = array(
    //         'topic.pass'      =>  1,
    //         'topic.delete'    =>  0,
    //         'topic.report'    => array('lt',50),
    //         );
    //     $order = 'topic.time desc,topic.id desc';
    //     $where = array(
    //         // 'user.uid'        => 'topic.author',
    //         // 'picture.id'      => 'user.avatar',
    //         );


    //     // $map['pass'] = 1;
    //     // $map['delete'] = 0;
    //     // $map['report'] = array('lt',500);


    //     // 200是OK,20是模块,1219是方法
    //     $data['code'] = 200201219;
    //     $data['msg'] = 'succeed';
     

    //     // TODO
    //     /* 首先检查这个用户是否被关闭 */
    //     if ($author) {
    //         $map['author'] = $author;
    //         $data['result'] = $Model->table($table)->order($order)
    //         ->page($page,15)->where($map)->select();
    //         $this->done($data);
    //     }
    // 	$data['result'] = $Model->table($table)
    //     ->field($field)
    //     ->order($order)->where($map)->where('user.uid=topic.author')->page($page,15)->select();
    //     $this->done($data);

    // }

    public function ls($page,$uid){
        $Topic = D('topic');

        $page = intval($page);
        $uid = intval($uid);

        $data['code'] = 200201219;
        $data['msg'] = 'succeed';

        $field = array(
            'uid',
            'share'     =>  'nickname',
            'id'        =>  'tid',
            'content',
            'reply'    =>  'replycount',
            'like'      =>  'likecount',
            'bg'        =>  'background',
            );

        $map = array(
            'pass'      =>  1,
            'delete'    =>  0,
            'report'    => array('lt',50),
            );

        $order = 'time desc,id desc';

        if ($uid) {
            $map['uid'] = $uid;
        }
        // dump($map);
        // exit();

        $data['result'] = $Topic
        ->field($field)
        ->where($map)
        ->page($page,15)
        ->order($order)
        ->select();
        // dump($data);
        // exit();

        foreach ($data['result'] as $key => $value) {
            $data['result'][$key]['avatar'] = get_avatar($value['uid']);
            $data['result'][$key]['nickname'] = get_nickname($value['uid']);

            $Repeat = D('reply');
            $map['totid'] = array('in',$value['tid']);
            $refield = array(
                'id'        =>  'avatar',
                'content'   =>  'replycontent',
                'uid',
                );
            $order = '`like` desc, `reply` desc, `time` desc';

            $data['result'][$key]['reply'] = $Repeat
            ->field($refield)
            ->where($map)
            ->order($order)
            ->limit(10)
            ->select();
            foreach ($data['result'][$key]['reply'] as $keyre => $valuere) {
                $data['result'][$key]['reply'][$keyre]['avatar'] = get_avatar($valuere['uid']);
            }
        }

         // dump($data['result']);
        // dump($uids);
        // dump($tids);
        // dump($usermap);
        // dump($datauser);
        // dump($datapic);
        // dump($data);
        // dump($data);
        // exit();
        $this->done($data);

    }
    public function add($totid,$rid){
        if ( !is_login() ) {
            $rt['code'] = '-1';
            $rt['msg'] = '请先登录！';
            $this->ajaxReturn($rt);         
        }

        if (IS_POST) {
            // $Topic = D('topic');
            // $author = I('author');
            $rt['code'] = '200200104';
            $rt['msg'] = 'succeed';

            $uid = is_login();
            
            $content = I('content');
            $time = NOW_TIME;
            $ip = get_client_ip(1);
            $bg = I('bg');
            
            $data['uid'] = $uid;
            $data['content'] = $content;
            $data['time'] = $time;
            $data['ip'] = $ip;
            $data['bg'] = $bg;

            if ($totid && is_numeric($totid)) {
                $data['totid'] = $totid;
                if ($rid && is_numeric($rid)) {
                    $data['rid'] = $rid;
                }
                $Reply = D('reply');
                $data = $Reply->create($data);
                $rt['result'] = $Reply->add();
                // TODO加入通知中心
                if ($rt['result']) {
                }
                $this->ajaxReturn($rt);
            }    

            $this->done($data,$rt);            
        }
    }

    public function del(){

    }

    public function mod(){

    }

    public function reply($totid,$rid){
        if ( !is_login() ) {
            $rt['code'] = '-1';
            $rt['msg'] = '请先登录！';
            $this->ajaxReturn($rt);         
        }
        if(IS_POST){
            $content = I('content');
            $picture = I();
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