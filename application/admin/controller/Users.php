<?php
namespace app\admin\controller;
 
use think\Validate;
use app\common\controller\Base;
use app\common\traits\Qiniuyun;
use Phpexcel\Phpexcel;

class Users extends Base{

    use Qiniuyun;

    protected $beforeActionList = [
        '_beforeuploadValidate'  =>  ['only'=>'upload'],
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
        } else {
            $listRows = input('numPerPage') ?? '500';
            $list = $this->getImagelist($listRows);
            foreach ($list['items'] as &$value) {
                $value['img_url'] = config('qiniu.qn_domain') . $value['key'];
            }
            $this->assign('data', $list['items']);
        }
    }

    public function outXl(){

        if(request()->isGet()){
            $title = '用户基本信息表';
            $filed = ['A'=>'用户ID', 'B'=>'用户名', 'C'=>'性别', 'D'=>'身份证', 'E'=>'户籍', 'F'=>'联系方式'];
            $type = ['id'=>'A', 'username'=>'B', 'sex'=>'C', 'IDcard'=>'D', 'addr'=>'E', 'phone'=>'F'];
            $data = $this->getUserList();
            Phpexcel::outExcel($title, $filed, $data, $type);

        }
    }

    protected function getUserList(){
        $list = model("Users")->where('is_del', 1)->field('id,username,sex,IDcard,addr,phone')->select();
        $list = $list->toArray();
        foreach($list as &$value){
            $value['sex'] = $value['sex'] ? '男' : '女';
        }
        return $list;
    }
    
}