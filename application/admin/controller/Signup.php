<?php
namespace app\admin\controller;

use app\common\controller\Base;

class Signup extends Base{

    protected function initialize()
    {
        parent::initialize();
        $majors = model('Major')->field('id, majorname, studytime')->select();
        $this->assign('majors', $majors);
        $this->obj = 'Users';
    }

    protected function _tigger_add($model){
        $info = input('post.');
        $info['userID'] = $model->id;
        $result = model('Studylesson')->allowField(true)->save($info);
        if($result){
            return true;
        }else{
            return false;
        }
    }
}