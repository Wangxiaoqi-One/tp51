<?php
namespace app\api\validate;

use think\Validate;

class Index extends Validate{
    protected $rule =   [
        'username'  => 'require|max:50',  
        'IDcard'=>'idCard|unique:users',
        'addr'=>'require|max:100',
        'nowAddr'=>'require|max:100',
        'phone'=>'mobile',
        'photo'=>'require',
        'idCardbefore'=>'require',
        'idCardback'=>'require',
        'sex'=>'require',
        'housetype'=>'require',
        'employstatus'=>'require',
        'lesson'=>'require|max:25',
        'studystatus'=>'require',
    ];
    
    protected $message  =   [
        'username.require' => '名称不能为空',
        'username.max'     => '名称最多不能超过50个字符',
        'IDcard.idCard'    => '身份证不正确',
        'IDcard.unique'    => '此身份证号已被使用',
        'addr.require'     => '地址不能为空',
        'addr.max'         => '户籍最多不能超过50个字符',
        'nowAddr.require'  => '地址不能为空',
        'nowAddr.max'      => '地址最多不能超过50个字符',
        'phone.mobile'     => '手机格式不正确',
        'photo.require'    => '照片不能为空',
        'idCardbefore.require'=> '身份证照片不能为空',
        'idCardback.require'=>'身份证照片不能为空',
        'sex.require'=>'未选择性别',
        'housetype.require' =>'未选择户籍类型',
        'employstatus.require'=>'未选择就业状态',
        'lesson.require'     => '专业不能为空',
        'lesson.max'         => '专业最多不能超过25个字符',
        'studystatus.require'    => '学习状态不能为空',
    ];
}