<?php
namespace app\admin\controller;

use think\Controller;

class Base extends Controller{

    protected $obj = '';

    protected function initialize()
    {
        parent::initialize();
        if(empty($this->obj)){
            $this->obj = request()->controller();
        }
    }

    public function index(){
        $sort = 'asc';
        if(!empty(input('_sort'))){
            $sort = input('_sort') == 'asc' ? 'asc' : 'desc';
        }
        $order = empty(input('_order')) ? model($this->obj)->getPk():input('_order');

        $listRows = input('numPerPage') ?? '10';
        $map['is_del'] = '0';
        if(method_exists($this, '_getMap')){
            $this->_getMap($map);
        }
        $data = model($this->obj)->where($map)->order($order.' '.$sort)->paginate($listRows);
        $page = $data->render();
        $dataArry = $data->toArray();
        if(method_exists($this, '_tigger_list')){
            $this->_tigger_list($dataArry);
        }
        $this->assign('page', $page);
        $this->assign('data', $dataArry['data']);
        $this->assign('currentPage', $dataArry['current_page']);
        $this->assign('numPerPage', $dataArry['per_page']);
        $this->assign('total', $dataArry['total']);
        return view();
    }

    public function add(){
        if(request()->isGet()){
            return view();
        }
        else{
            $data = input('post.');
            $vald = validate($this->obj);
            if(!$vald->check($data)){
                $this->error($vald->getError());
            }
            $model = model($this->obj);
            $model->startTrans();
            $result = $model->allowField(true)->save($data);
            $tiggerResult = true;
            if(method_exists($this, '_tigger_add')){
                $tiggerResult = $this->_tigger_add($model);
            }
            if($result && $tiggerResult){
                $model->commit();
                $this->success('新增成功');
            } else {
                $model->rollback();
                //错误页面的默认跳转页面是返回前一页，通常不需要设置
                $this->error('新增失败');
            }
        }
    }

    public function edit(){
        if(request()->isGet()){
            $id = input('id');
            $data = model($this->obj)->where('id',$id)->find();
            if(method_exists($this, '_tigger_edit')){
                $tiggerResult = $this->_tigger_edit($data);
            }
            $this->assign('data', $data);
            return view();
        }else{
            $data = input('post.');
            $vald = validate($this->obj);
            if(!$vald->check($data)){
                $this->error($vald->getError());
            }
            $result = model($this->obj)->allowField(true)->save($data, ['id'=>$data['id']]);
            if($result){
                $this->success('更新成功');
            } else {
                //错误页面的默认跳转页面是返回前一页，通常不需要设置
                $this->error('更新失败');
            }
        }
    }
    public function deltag(){
        $id = input('id');
        $result = model($this->obj)->where('id', $id)->setField('is_del', 1);
        if ($result) {
            //设置成功后跳转页面的地址，默认的返回页面是$_SERVER['HTTP_REFERER']
            $this->success('删除成功');
        } else {
            //错误页面的默认跳转页面是返回前一页，通常不需要设置
            $this->error('删除失败');
        }
    }
}