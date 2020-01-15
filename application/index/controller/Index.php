<?php
namespace app\index\controller;

use think\Controller;
use think\Validate;

class Index extends Controller
{
    public function index()
    {
        $majors = db('major')->where('is_del', 0)->select();
        $this->assign('majors', $majors);
        return view();
    }

    public function register(){
        //获取登录信息
        if (request()->isPost()) {
            $data = input('post.');
            $valicode = $data['captcha'];
            if (!captcha_check($valicode)) {
                exit(json_encode(['code'=> 0, 'msg'=>'验证码错误']));
            }
            $vald= Validate::make([
                'username'  => 'require|max:25|token',
            ]);
            if(!$vald->check($data)){
                $this->error($vald->getError());
            }
            
        }
    }
}
