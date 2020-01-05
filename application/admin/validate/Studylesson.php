<?php
namespace app\admin\validate;

use think\Validate;

class Studylesson extends Validate{

    protected $rule =   [ 
        'lesson'=>'require|max:25',
        'studytime'=>'require|max:25',
        'studystatus'=>'require',
        'userID'=>'require|unique:studylesson',
    ];
    
    protected $message  =   [
        'lesson.require'     => '专业不能为空',
        'lesson.max'         => '专业最多不能超过25个字符',
        'studytime.require'  => '学习时间不能为空',
        'studytime.max'      => '学习时间最多不能超过25个字符',
        'studystatus.require'    => '学习状态不能为空',
        'userID.require'=> '用户id不能为空',
        'userID.unique'=> '此用户已存在',
    ];
}