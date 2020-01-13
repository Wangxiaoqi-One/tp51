<?php
namespace app\admin\controller;

use app\common\controller\Base;

class AuthGroup extends Base{

    protected $beforeActionList = [
        '_beforeEdit'  =>  ['only'=>'edit'],
    ];

    protected function _getMap(&$map)
    {
        $map = [];
        $keyword = trim(input('keyword'));
        if(!empty($keyword)){
            $map = function ($query) use($map, $keyword){
                $query->where($map)
                      ->where('title','like', '%'.$keyword.'%');
            };
        }
        return $map;
    }

    protected function _tigger_list(&$dataArray){
        foreach($dataArray['data'] as &$value){
            $value['status'] = $value['status']==1 ? "正常" : "禁用";
            $value['grouper'] = rtrim(getGrouperName($value['id']), ",");
        }
    }


    protected function _beforeEdit(){
        if(request()->isGet()){
            $rules = model('AuthRule')->select();
            $this->assign("rules", $rules);
        }
    }

}