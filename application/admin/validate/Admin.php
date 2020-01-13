<?php
namespace app\admin\validate;

use think\route\Rule;
use think\Validate;

class Admin extends Validate{

    protected $rule =   [
        'username'  => 'require|max:25|unique:admin', 
        'password'  => 'require', 
    ];
    
    protected $message  =   [
        'username.require' => '名称不能为空',
        'username.max'     => '名称最多不能超过2个字符',
        'username.unique'  => '此管理员已存在',
        'password.require' => '未设置密码',
    ];

}