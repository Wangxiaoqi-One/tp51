<?php
namespace app\admin\controller;

use app\common\traits\Qiniuyun;
use think\Controller;

class Imagelist extends Controller{

    use Qiniuyun;

    public function index(){
        $listRows = input('numPerPage') ?? '100';
        $list = $this->getImagelist($listRows);
        foreach($list['items'] as &$value){
            $value['img_url'] = config('qiniu.qn_domain') . $value['key'];
        }
        $this->assign('numPerPage', $listRows);
        $this->assign('total', count($list['items']));
        $this->assign('data', $list['items']);
        return view();
    }

    public function deltag(){

        if(request()->isGet()){

            $key = input('keys');
            $keys = explode(',', rtrim($key,','));
            $ret = $this->deleteImages($keys);
            if(!$ret){
                $this->error("删除失败");
            }else{
                $this->success($ret);
            }
        }

    }


}