<?php
namespace app\common\controller;

use Qiniu\Qiniu;

trait Qiniuyun
{


    //上传图片的方法
    protected function uploadImg($filename, $filepath){
        $qn = new Qiniu();
        return $qn->uploadImage($filename, $filepath);
    }

}