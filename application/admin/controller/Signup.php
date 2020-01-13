<?php
namespace app\admin\controller;

use think\Validate;
use app\common\controller\Base;
use app\common\traits\Qiniuyun;

class Signup extends Base{


    use Qiniuyun;

    protected $beforeActionList = [
        '_beforeuploadValidate'  =>  ['only'=>'upload'],
    ];

    protected function initialize()
    {
        parent::initialize();
        $majors = model('Major')->field('id, majorname, studytime')->select();
        $this->assign('majors', $majors);
        $this->obj = 'Users';
    }

    protected function _tigger_add($model){
        $info = input('post.');
        $info['userID'] = $model->id;
        $result = model('Studylesson')->allowField(true)->save($info);
        if($result){
            return true;
        }else{
            return false;
        }
    }

    protected function _beforeuploadValidate(){
        if(request()->isPost()){
            if(empty($_FILES['pic']['tmp_name'])){
                exit(json_encode(['code'=> 0, 'msg'=>'未选择图片']));
            }
            $file = request()->file('pic');
            $width = input('width');
            $height = input('height');
            $validate = new Validate([
                'pic'  => 'file|image:'.$width.','.$height . '|fileExt:' . config('setImage.upload_img_type') . '|fileSize:' . config('setImage.upload_img_size'),
            ]);
            if (!$validate->check(['pic'=>$file])) {
                exit(json_encode(['code'=> 0, 'msg'=>'尺寸或格式不正确']));
            }
        }
    }
}