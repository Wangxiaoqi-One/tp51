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
            $files = request()->file('pic');
            if(count($files) > 1){
                foreach($files as $file){
                    $res = $this->uploadImage($file);
                    if (!$res['code']) {
                        return json($res);
                    }
                }
                $res['msg'] = '上传成功';
                return json($res);
            }else{
                $res = $this->uploadImage($file);
                return json($res);
            }
        }
    }


    protected function uploadImage($file){
        $path = $file->getRealPath();
            $ext = pathinfo($file->getInfo('name'), PATHINFO_EXTENSION);
            $filename = str_replace('.' . $ext, '', $file->getInfo('name')) . '-' . time() . '.' . $ext;
            $res = ['code'=> 0, 'msg'=>'', 'types'=>input('types')];
            $qn = new Qiniu();
            if($qn->uploadImage($filename, $path)){
                $res['code'] = 1;
                $res['msg'] = $filename;
            }else{
                $res['msg'] = '上传失败';
            }
            return $res;
    }

    public function getImagelist($limit=100){
        $qn = new Qiniu();
        return $qn->getImageList($limit);
    }

    public function deleteImages($keys){
        $qn = new Qiniu();
        return $qn->deleteImage($keys);
    }

}