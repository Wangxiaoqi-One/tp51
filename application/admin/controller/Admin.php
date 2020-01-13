<?php
namespace app\admin\controller;

use app\common\controller\Base;

class Admin extends Base{


    protected $beforeActionList = [
        '_beforeEdit'  =>  ['only'=>'edit'],
    ];

    protected function _getMap(&$map)
    {
        $keyword = trim(input('keyword'));
        if(!empty($keyword)){
            $map = function ($query) use($map, $keyword){
                $query->where($map)
                      ->where('username','like', '%'.$keyword.'%');
            };
        }
        return $map;
    }

    protected function _tigger_list(&$dataArray){
        foreach($dataArray['data'] as &$value){
            $group_id = model('AuthGroupAccess')->where('uid', $value['id'])->value('group_id');
            $value['group_id'] = groupIDtoGroupName($group_id);
            $value['last_login_time'] = date("Y-m-d H:i:s", $value['last_login_time']);
            $value['last_login_ip'] = long2ip($value['last_login_ip']);
            $value['status'] = $value['status']==1 ? "正常" : "禁用";
        }
    }

    //将密码加密
    protected function _tigger_edit(&$info)
    {
        if(!empty($info['id'])){
            $password = model('Admin')->where('id', $info['id'])->value('password');
            if($info['password'] !== $password){
                $info['password'] = md5($info['password']);
            }
        }else{
            $info['password'] = md5($info['password']);
        }
    }


    protected function _beforeEdit(){
        if(request()->isGet()){
            $uid = input('id');
            $group_id = model('AuthGroupAccess')->where('uid', $uid)->value('group_id');
            $group_name = groupIDtoGroupName($group_id);
            $this->assign("group_id", $group_name);
        }
    }

    public function authadmin(){
        if(request()->isGet()){
            $admin_id = input('id');
            $username =model('Admin')->where('id', $admin_id)->value('username');
            $group = model('AuthGroup')->where('status', 1)->select();
            $group_id = model('AuthGroupAccess')->where('uid', $admin_id)->value('group_id');
            $this->assign('username', $username);
            $this->assign('id', $admin_id);
            $this->assign('group', $group);
            $this->assign('group_id', $group_id);
            return view();
        }else{
            $data = input('post.');
            $result = model('AuthGroupAccess')->allowField(true)->save($data, ['uid'=>$data['uid']]);
            if($result){
                $this->success('授权成功');
            } else {
                $this->error('授权失败');
            }
        }
    }

}