<?php
namespace app\admin\controller;


class Studylesson extends Base{


    protected function initialize()
    {
        parent::initialize();
        $usersInfo = model('Users')->field('id, username, phone')->select();
        $majors = model('Major')->field('id, majorname, studytime')->select();
        $this->assign('usersInfo', $usersInfo);
        $this->assign('majors', $majors);
    }

    protected function _getMap(&$map)
    {
        $keyword = trim(input('keyword'));
        //学习状态
        $studystatus = input('studystatus');
        if(!empty($studystatus)){
            $map['studystatus'] = $studystatus;
        }
        if(!empty($keyword)){
            $map = function ($query) use($map, $keyword){
                $query->where($map)
                      ->where('username','like', '%'.$keyword.'%');
            };
        }
    }

    protected function _tigger_list(&$dataArray){
        foreach($dataArray['data'] as &$value){
            $value['userID'] = userIDtoPhone($value['userID']);
            $value['lesson'] = majorIdToMajorName($value['lesson']);
            $value['studytime'] = majorIdToMajorTime($value['lesson']);
        }
    }
    protected function _tigger_edit(&$info){
            $info['username'] = userIDtoPhone($info['userID']);
            $info['studytime'] = majorIdToMajorTime($info['lesson']);
    }

    public function treelookup(){
        $listRows = input('numPerPage') ?? '10';
        $map['is_del'] = '0';
        $data = model('Major')->where($map)->paginate($listRows);
        $page = $data->render();
        $dataArry = $data->toArray();
        $this->assign('page', $page);
        $this->assign('data', $dataArry['data']);
        $this->assign('currentPage', $dataArry['current_page']);
        $this->assign('numPerPage', $dataArry['per_page']);
        $this->assign('total', $dataArry['total']);
        return view();
    }
}