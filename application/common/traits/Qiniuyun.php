<?php
namespace app\common\traits;

use Qiniu\Qiniu;
use think\Validate;

trait Qiniuyun
{

    public function upload(){
        if(request()->isGet()){
            $types = input('types');
            $width = input('width');
            $height = input('height');
            $this->assign('types', $types);
            $this->assign('width', $width);
            $this->assign('height', $height);
            return view();
        }else{
            $file = request()->file('pic');
            $path = $file->getRealPath();
            $filename = $file->getInfo('name');
            $res = ['code'=> 0, 'msg'=>'', 'types'=>input('types')];
            $qn = new Qiniu();
            if($qn->uploadImage($filename, $path)){
                $res['code'] = 1;
                $res['msg'] = $filename;
            }else{
                $res['msg'] = '上传失败';
            }
            return json($res);
        }
    }

}