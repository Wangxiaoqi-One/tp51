<?php
namespace app\admin\controller;

use app\common\controller\Base;

class Major extends Base{
    
    protected function _getMap(&$map)
    {
        $keyword = trim(input('keyword'));
        if(!empty($keyword)){
            $map = function ($query) use($map, $keyword){
                $query->where($map)
                      ->where('majorname','like', '%'.$keyword.'%');
            };
        }
        return $map;
    }

}