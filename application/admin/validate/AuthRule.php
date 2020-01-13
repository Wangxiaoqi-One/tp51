<?php
namespace app\admin\validate;

use think\Validate;

class AuthRule extends Validate{

    protected $rule =   [
        'name'  => 'require|max:25|unique:authRule', 
        'title'  => 'require', 
    ];
    
    protected $message  =   [
        'name.require' => '名称不能为空',
        'name.max'     => '名称最多不能超过25个字符',
        'name.unique'  => '此规则已存在',
        'title.require' => '未设置名称',
    ];

}