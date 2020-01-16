<?php
namespace app\api\controller\v1;

use app\api\model\Users;
use think\Controller;

class Register extends Controller{

    public function reg(){
        $data = input('post.');
        $vald = validate('Register');
        $res = ['code'=>0, 'msg'=>'报名失败'];
        if ($vald->check($data)) {
            $user = new Users();
            $user->allowField(true)->save($data);
            if($user->studylesson()->save($data)){
                $res['code'] = 1;
                $res['msg'] = '报名成功';
            }
        } else {
            $res['msg'] = $vald->getError();
        }
        return json($res);
    }


    public function getMajor(){
        $type = input('type');
        $res = db($type)->where('is_del', 0)->select();
        return json($res);
    }

}