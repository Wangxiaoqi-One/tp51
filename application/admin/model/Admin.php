<?php
namespace app\admin\model;

use think\db\Where;
use think\Model;

class Admin extends Model{


    public function login($un, $pw){

        $user = $this->where('username', $un)->find();
        if ($user && $user['status']) {
            if (md5($pw) === $user['password']) {
                $auth_group = model('AuthGroupAccess')->where('uid', $user['id'])->value('group_id');
                if($auth_group){
                session(config('auth.SESSION_ADMIN_KEY'), ['username' => $un, 'uid' => $user['id'], 'login_time' => time()], 'admin');
                    return $user['id'];
                }else{
                    return -3;
                }
            } else {
                return -2;
            }
        }
        return -1; 

    }
}