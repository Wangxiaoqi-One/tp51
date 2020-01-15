<?php
namespace app\admin\model;

use think\Model;

class Users extends Model{
    

    public function Studylesson()
    {
        return $this->hasOne('Studylesson', 'uid', 'id');
    }

}
