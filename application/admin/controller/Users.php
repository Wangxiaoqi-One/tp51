<?php
namespace app\admin\controller;


class Users extends Base{

    protected function _getMap(&$map)
    {
        //搜索关键字
        $keyword = trim(input('keyword'));
        $housetype = input('housetype');
        $employtype = input('employstatus');
        //就业状态
        if (!empty($employtype)) {
            $map['employstatus'] = $employtype;
        }
        if(!empty($keyword)){
            $map = function ($query) use($map, $keyword){
                $query->where($map)
                      ->where('username','like', '%'.$keyword.'%');
            };
        } 
    }
}