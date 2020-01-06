<?php
namespace app\admin\controller;
 
use app\common\controller\Base;


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

    public function upload(){
        if(request()->isGet()){
            return view();
        }else{
            $file = request()->file('pic');
            $path = $file->getRealPath();
            $filename = $file->getInfo('name');
            if($this->uploadImg($filename, $path)){
                $this->success('上传图片成功');
            }else{
                $this->error('上传失败');
            }
        }
    }
}