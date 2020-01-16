<?php
namespace app\common\traits;

use Qiniu\Qiniu;

trait QiniuUpload
{

    public function uploadImage($file)
    {
        $path = $file->getRealPath();
        $ext = pathinfo($file->getInfo('name'), PATHINFO_EXTENSION);
        $filename = str_replace('.' . $ext, '', $file->getInfo('name')) . '-' . time() . '.' . $ext;
        $res = ['code' => 0, 'msg' => '', 'types' => input('types')];
        $qn = new Qiniu();
        if ($qn->uploadImage($filename, $path)) {
            $res['code'] = 1;
            $res['msg'] = $filename;
        } else {
            $res['msg'] = '上传失败';
        }
        return $res;
    }

}