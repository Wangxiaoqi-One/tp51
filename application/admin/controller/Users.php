<?php
namespace app\admin\controller;
 
use think\Validate;
use app\common\controller\Base;
use app\common\traits\Qiniuyun;


class Users extends Base{

    use Qiniuyun;

    protected $upload_vali = true;

    protected $beforeActionList = [
        'uploadValidate'  =>  ['only'=>'upload'],
    ];

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

    protected function uploadValidate(){
        if(request()->isPost()){
            $file = request()->file('pic');
            $width = input('width');
            $height = input('height');
            $validate = new Validate([
                'pic'  => 'file|image:'.$width.','.$height . '|fileExt:' . config('setImage.upload_img_type') . '|fileSize:' . config('setImage.upload_img_size'),
            ]);
            if (!$validate->check(['pic'=>$file])) {
                $this->upload_vali = false;
            }
        }
    }
    
}