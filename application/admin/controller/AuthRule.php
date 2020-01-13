<?php
namespace app\admin\controller;

use app\common\controller\Base;

class AuthRule extends Base{

    protected function _getMap(&$map)
    {
        $map = [];
        $keyword = trim(input('keyword'));
        if(!empty($keyword)){
            $map = function ($query) use($map, $keyword){
                $query->where($map)
                      ->where('name','like', '%'.$keyword.'%')
                      ->whereOr('title','like', '%'.$keyword.'%');
            };
        }
        return $map;
    }

    protected function _tigger_list(&$dataArray){
        foreach($dataArray['data'] as &$value){
            $value['status'] = $value['status']==1 ? "正常" : "禁用";
        }
    }

}