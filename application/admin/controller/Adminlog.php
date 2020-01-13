<?php
namespace app\admin\controller;

use app\common\controller\Base;

class Adminlog extends Base{


    public function look(){
        if(request()->isGet()){
            $logId = input('id');
            $param = model('Adminlog')->where('id', $logId)->value('param');
            $this->assign('param', $param);
        }
        return view();
    }

    protected function _getMap(&$map)
    {
        $map = [];
        //管理员
        $admin_id = input('admin_id');
        if(!empty($admin_id)){
            $map['admin_id'] = $admin_id;
        }
        //管理组
        $group_id = input('group_id');
        if(!empty($group_id)){
            $map['group_id'] = $group_id;
        }
    }

    protected function _tigger_list(&$dataArray){
        foreach($dataArray['data'] as &$value){
            $value['ip'] = long2ip($value['ip']);
            $value['admin_id'] = adminIDtoAdminName($value['admin_id']);
            $value['group_id'] = groupIDtoGroupName($value['group_id']);
        }
    }

}