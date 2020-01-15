<?php
namespace app\admin\validate;

use think\Validate;

class Users extends Validate{

    protected $rule =   [
        'username'  => 'require|max:50|token',  
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
    ];
}