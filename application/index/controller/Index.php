<?php
namespace app\index\controller;

use app\common\traits\QiniuUpload;
use app\index\model\Users;
use think\Controller;

class Index extends Controller
{
    use QiniuUpload;

    public function index()
    {
        if(request()->isGet()){
            $majors = db('major')->where('is_del', 0)->select();
            $this->assign('majors', $majors);
            return view();
        }else{
            $data = input('post.');
            $valicode = $data['captcha'];
            if (!captcha_check($valicode)) {
                exit(json_encode(['code'=> 0, 'msg'=>'验证码错误']));
            }
            $this->upload($data);
            $vald = validate('index');
            if ($vald->check($data)) {
                $user = new Users();
                $user->allowField(true)->save($data);
                $res = $user->studylesson()->save($data);
                echo $res ? json("成功") : json("失败");
            } else {
                echo json($vald->getError());
            }

        }
    }


    protected function upload(&$data)
    {
        $photo_file = request()->file('photo');
        $p_res = $this->uploadImage($photo_file);
        if ($p_res['code'] == 0) {
            exit(json_encode(['code' => 0, 'msg' => '照片上传错误']));
        }
        $data['photo'] = $p_res['msg'];
        $id_before = request()->file('idCardbefore');
        $bf_res = $this->uploadImage($id_before);
        if ($bf_res['code'] == 0) {
            exit(json_encode(['code' => 0, 'msg' => '照片上传错误']));
        }
        $data['idCardbefore'] = $bf_res['msg'];
        $id_back = request()->file('idCardback');
        $id_bk = $this->uploadImage($id_back);
        if ($id_bk['code'] == 0) {
            exit(json_encode(['code' => 0, 'msg' => '照片上传错误']));
        }
        $data['idCardback'] = $id_bk['msg'];
    }
}
