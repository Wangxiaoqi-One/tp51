<?php
namespace app\admin\validate;

use think\Validate;

class AuthGroup extends Validate{

    protected $rule =   [
        'title'  => 'require|max:25|unique:authRule', 
    ];
    
    protected $message  =   [
        'title.require' => '名称不能为空',
        'title.max'     => '名称最多不能超过25个字符',
        'title.unique'  => '此管理组已存在',
    ];

}