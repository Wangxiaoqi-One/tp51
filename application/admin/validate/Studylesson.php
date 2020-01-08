<?php
namespace app\admin\validate;

use think\Validate;

class Studylesson extends Validate{

    protected $rule =   [ 
        'lesson'=>'require|max:25',
        'username'=>'require|max:25',
        'studystatus'=>'require',
        'userID'=>'require|unique:studylesson',
    ];
    
    protected $message  =   [
        'lesson.require'     => '专业不能为空',
        'lesson.max'         => '专业最多不能超过25个字符',
        'username.require'  => '用户名不能为空',
        'username.max'      => '用户名最多不能超过25个字符',
        'studystatus.require'    => '学习状态不能为空',
        'userID.require'=> '用户id不能为空',
        'userID.unique'=> '此用户已存在',
    ];
}