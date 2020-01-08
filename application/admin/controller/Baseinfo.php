<?php
namespace app\admin\controller;

use think\Controller;
use think\facade\Env;

class Baseinfo extends Controller{
    

    public function index(){
        return view();
    }

    public function save(){
        $data = input('post.');
        $setImgPath = Env::get('config_path') . 'setImage.php';
        $array = array('logo_img'  =>  array('width'=>$data['logo_imgW'], 'height'=>$data['logo_imgH']),
        'userPhoto'  =>  array('width'=>$data['userPhotoW'], 'height'=>$data['userPhotoH']),
        'idCardbefore'  =>  array('width'=>$data['idCardbeforeW'], 'height'=>$data['idCardbeforeH']),
        'idCardback'  =>  array('width'=>$data['idCardbackW'], 'height'=>$data['idCardbackH']),
        'upload_img_size'  =>  intval($data['upload_img_size']) * 1024 *1024,
        'upload_img_type'  =>  $data['upload_img_type'],)
            
        ;
        //缓存 
        $text = '<?php return ' . var_export($array, true) . ';';
        if (fopen($setImgPath, 'w+')) {
            if(file_put_contents($setImgPath, $text) !== false){
                $this->success('修改配置成功');
            }else{
                $this->error('修改失败');
            }
        } else {
            $this->error('打开文件失败');
        }
    }

}