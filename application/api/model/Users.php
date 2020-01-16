<?php
namespace app\api\model;

use think\Model;

class Users extends Model{

    public function studylesson()
    {
        return $this->hasOne('Studylesson','userID', 'id');
    }

}