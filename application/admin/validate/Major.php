<?php
namespace app\admin\validate;

use think\Validate;

class Major extends Validate{

    protected $rule =   [
        'majorname'  => 'require|max:25|unique:major', 
        'studytime'  => 'require', 
    ];
    
    protected $message  =   [
        'majorname.require' => '名称不能为空',
        'majorname.max'     => '名称最多不能超过2个字符',
        'majorname.unique'  => '此专业已存在',
        'studytime.require' => '需要指定学习时间',
    ];
}