<?php
namespace app\admin\model;

use think\db\Where;
use think\facade\Log;
use think\Model;

class Admin extends Model{


    public function login($un, $pw){

        $user = $this->where('username', $un)->find();
        if ($user && $user['status']) {
            if (md5($pw) === $user['password']) {
                $group_id = model('AuthGroupAccess')->where('uid', $user['id'])->value('group_id') ?: 0;
                if($group_id){
                    session(config('auth.SESSION_ADMIN_KEY'), ['username' => $un, 'uid' => $user['id'], 'login_time' => time()], 'admin');
                    $ip = ip2long(request()->ip());
                    $this->writeLog($user['id'], $group_id, $ip);
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

    final protected function writeLog($admin_id, $group_id, $ip)
    {
        Log::write('admin_id:' . $admin_id . '--group_id:' . $group_id . 'ip:' . long2ip($ip) . '--date:' . date('Y-m-d H:i:s', time()), 'adminloginlog');
        $data['admin_id'] = $admin_id;
        $data['group_id'] = $group_id;
        $data['ip'] = $ip;
        model('AdminLoginLog')->save($data);
    }
}