<?php
namespace app\admin\controller;

use think\Controller;

class Pub extends Controller{

    public function index(){
        return view('login');
    }


    public function login(){

        //获取登录信息
        if (request()->isPost()) {
            $un = input('username');
            $pw = input('password');
            $valicode = input('valicode');
            if (captcha_check($valicode)) {
                $uid = model('Admin')->login($un, $pw);
                if($uid > 0){
                    $this->success("登录成功", url("index/index"));
                }else{
                    $error = "未知错误";
                    switch($uid){
                        case -1:
                            $error = "用户名不存在或被禁用";
                            break;
                        case -2:
                            $error = "密码错误";
                            break;
                        case -3:
                            $error = "未在管理组当中";
                            break;
                    }
                    $this->error($error);
                }
            } else {
                $this->error("验证码错误");
            }
        }

    }

    public function logout(){
        session(null, 'admin');
        $this->redirect('admin/pub/index');
    }


}