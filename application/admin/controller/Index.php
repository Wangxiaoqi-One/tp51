<?php
namespace app\admin\controller;

use think\Controller;

class Index extends Controller{

    public function index(){
        $user = session(config('auth.SESSION_ADMIN_KEY'), '', 'admin');
        $this->assign('username', $user['username']);
        return view();
    }

}