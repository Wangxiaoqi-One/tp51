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
            $width = input('width');
            $height = input('height');
            $path = $file->getRealPath();
            $filename = $file->getInfo('name');
            $validate = new Validate([
                'pic'  => 'file|image:'.$width.','.$height,
            ]);
            $res = ['code'=> 0, 'msg'=>'', 'types'=>input('types')];
            if (!$validate->check(['pic'=>$file])) {
                $res['msg'] = '图片尺寸不正确';
                return json($res);
            }
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